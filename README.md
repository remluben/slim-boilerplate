# Website Boilerplate

A website boilerplate based on the [Slim Framework](http://www.slimframework.com/) as well as a couple of useful Laravel Framework components, which are commonly required, when developing simple websites.

## Important note

If you are looking for the *slim-boilerplate* for PHP 5.3, please use the [v1.0.0](https://github.com/remluben/slim-boilerplate/releases/tag/v1.0.0) tag of this repository.

## Why?

As many frameworks provide quite a lot of components and features that seem to be overhead in small projects, I came up with using the Slim Framework.

It requires PHP 7.x to run, so it should by now run on quite a broad range of web application servers with PHP installed on them.

After adding the components I require most of the time, I ended up with this little boilerplate project.

## Third party software

In addition to the Slim Micro Framework, the following components are included:

* [PHP dotenv](https://github.com/vlucas/phpdotenv)
* [Laravel framework components](http://www.laravel.com/docs) from version 5.x
    * [IoC Container](https://github.com/illuminate/container)
    * [Session](https://github.com/illuminate/session)
    * [Database](https://github.com/illuminate/database)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [Sirius validation components](https://github.com/siriusphp/validation)
* [Twig template engine](http://twig.sensiolabs.org/)

Also implementing features based on:

* [Jeffrey Ways Laracasts Validation library](https://github.com/laracasts/Validation)

## Installation

For installation execute the following commands and replace *demo* by your own application name

    git clone https://github.com/remluben/slim-boilerplate.git demo
    cd demo
    composer update

## Docs

###Configuration

The application can be easily configured using the *app/config/config.php* file.

There are defined a couple of configuration values by default. They can be changed as described and new configuration values may be added as required.

The configuration object is available as as *$config* inside routes.php and can be injected into Controllers by using the *\App\Components\Config\Config $config* parameter.

#### Environment based configuration

Within the application base directory exists a *.env.example* file, which can be used for environment based configuration.

Simply rename the file to *.env* and adjust the settings. Settings are read from within *app/config/config.php* using PHP's *getenv()* function.

For further information see: [https://github.com/vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)

#### Database

There are default MSQL database credentials provided within the *app/config/config.php* file as a fallback for development systems.

    host: localhost
    database: development
    username: user
    password: password

### Dependency Injection

The website boilerplate makes use of Laravel's *IoC (Inversion of Control)* component, which allows automatic dependency injection of Controller constructor parameters.

Let's take a look at the *HomeController*, that comes with the application by default:

    class HomeController extends BaseController
    {
        /**
         * @var \Slim\Slim
         */
        private $app;
    
        public function __construct(\Slim\Slim $app) // automatically provided by Laravel's IoC container
        {
            $this->app = $app;
        }
    
        /**
         * Show the home page
         */
        public function indexAction()
        {
            $this->app->render('home.twig');
        }
    }

Note, that it is possible to automatically load any resource from the IoC container, that is registered. You can see how this works in *app/bootstrap/bootstrap.php*.

Further information can be found at http://laravel.com/docs/4.1/ioc

### Routing

A simple router class as a wrapper for the *Slim\Slim* application class is available within the *routes.php* file as *$router*.

It provides a simple way to add controller based routing:


    // The base namespace \App\Http\Controllers\ is set within the app/boilerplate/boilerplate.php file
    // \App\Http\Controllers\HomeController
    $router->get('/home', 'HomeController::index');
    
    // A simple Slim route using the Router component
    $router->get('/test/:something', function ($something) {
        echo htmlspecialchars($something);
    });

### Database

The Laravel database component can be easily injected into Controllers:

    class ExampleController extends BaseController
    {
        /**
         * @var \Slim\Slim
         */
        private $app;
    
        /**
         * @var \Illuminate\Database\Capsule\Manager
         */
        private $db;
    
        public function __construct(
            \Slim\Slim $app,
            \Illuminate\Database\Capsule\Manager $db
        ) {
            $this->app = $app;
            $this->db = $db;
        }
    
        /**
         * Show the home page
         */
        public function indexAction()
        {
            $this->app->render('home.twig');
        }
    }

For further information on how to use the database object see https://github.com/laravel/docs/blob/4.1/database.md

## Roadmap

* Bower and Gulp integration