<?php

/**
 * Application components bootstrap file
 *
 * @author Benjamin Ulmer
 * @link http://github.com/remluben/slim-boilerplate
 */

define('__BASE_DIR', dirname(dirname(__DIR__)) . '/');

require __BASE_DIR . 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start native session to get a session id for the Laravel session store and
// filesystem session handler

session_name('slim-boilerplate');
session_start();

// Environment based configuration
// Allows developers using the getenv('<name>') method to fetch configuration values

if (file_exists(__BASE_DIR . '.env')) {
    Dotenv::load(__BASE_DIR);
}

// IoC container setup

$container = new \Illuminate\Container\Container();

// Application configuration

$config = include(__BASE_DIR . 'app/config/config.php');
$config = new \App\Components\Config\Config($config);

$container->instance('\App\Components\Config\Config', $config);
$container->alias('\App\Components\Config\Config', 'config');

// Slim application setup

$container->singleton('Slim\\Slim', function ($container) use ($config)
{
    $app = new \Slim\Slim(array(
        'debug' => $config->get('app.debug'),
        'mode' => $config->get('app.mode'),
        'log.enabled' => $config->get('app.logging.enabled'),
        'log.level' => $config->get('app.logging.level'),
        'log.writer' => new \App\Components\Logging\FileSystemLogWriter(__BASE_DIR . 'app/storage/logs/' . date('ymd') . '.log'),
        'templates.path' => __BASE_DIR . 'app/ressources/views',
        'view' => new \Slim\Views\Twig(),
    ));


    // Twig template engine setup
    $app->view()->parserOptions = array(
        'debug' => $config->get('app.debug'),
        'cache' => __BASE_DIR . 'app/storage/cache/views'
    );

    $app->view()->parserExtensions = array(
        new \Slim\Views\TwigExtension(),
    );

    // Laravel session component start and shutdown configuration
    $app->hook('slim.before', function ($container) use ($container) {
        $container->make('session')->start();
    });

    $app->hook('slim.after.router', function ($container) use ($container) {
        $container->make('session')->save();
    });

    return $app;
});

$container->alias('Slim\\Slim', 'app');

// Setup router for simple controller routing

$container->singleton('App\\Components\\Routing\\Router', function ($container)
{
    $router = new \App\Components\Routing\Router($container->make('app'), $container);
    $router->setControllerNamespace('\\App\\Http\\Controllers');

    return $router;
});

$container->alias('App\\Components\\Routing\\Router', 'router');

// Filesystem access

$container->singleton('Illuminate\\Filesystem\\Filesystem', function () {
    return new Illuminate\Filesystem\Filesystem;
});

$container->alias('Illuminate\\Filesystem\\Filesystem', 'file');

// Session component

$container->singleton('Illuminate\\Session\\Store', function ($container) {
    $handler = new \Illuminate\Session\FileSessionHandler(
        $container->make('file'),
        __BASE_DIR . 'app/storage/sessions'
    );

    return new \Illuminate\Session\Store('slim-boilerplate', $handler, session_id());
});

$container->alias('Illuminate\\Session\\Store', 'session');

// Use the Sirius validation library for form validation

$container->singleton('App\\Components\\Validation\\FactoryInterface', function () {
    return new \App\Components\Validation\Sirius\SiriusValidatorFactory;
});

// additional globally available components

/**
 * @var Slim\Slim
 */
$app = $container->make('app');

/**
 * @var App\Components\Routing\Router
 */
$router = $container->make('router');