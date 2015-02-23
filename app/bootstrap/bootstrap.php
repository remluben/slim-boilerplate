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
        'debug' => true,
        'mode' => 'development',
        'log.enabled' => true,
        'log.level' => \Slim\Log::DEBUG,
        'templates.path' => __BASE_DIR . 'app/ressources/views',
        'view' => new \Slim\Views\Twig(),
    ));

    $app->view()->parserOptions = array(
        'debug' => true,
        'cache' => __BASE_DIR . 'app/storage/cache/views'
    );

    $app->view()->parserExtensions = array(
        new \Slim\Views\TwigExtension(),
    );

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
        $container->make('filesystem'),
        __BASE_DIR . 'app/storage/sessions'
    );

    return new \Illuminate\Session\Store('page-boilerplate', $handler);
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