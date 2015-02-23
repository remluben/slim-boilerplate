#Website Boilerplate

A website boilerplate based on the [Slim Framework](http://www.slimframework.com/) as well as a couple of useful Laravel Framework components, which are commonly required, when developing simple websites.

##About

##Why?

As many frameworks provide quite a lot of components and features that seem to be overhead in small projects, I came up with using the Slim Framework.

It requires PHP 5.3 to run, so it should run on quite a broad range of web application servers with PHP installed on them.

After adding the components I require most of the time, I ended up with this little boilerplate project.

##Third party software

In addition to the Slim Micro Framework, the following components are included:

* [Twig template engine](http://twig.sensiolabs.org/)
* [Laravel framework components](http://www.laravel.com/docs) from version 4.x, as these require PHP 5.3 only
    * [IoC Container](https://github.com/illuminate/container)
    * [Session](https://github.com/illuminate/session)
    * [Database](https://github.com/illuminate/database)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)

##Docs

###Configuration

The application can be easily configured using the *app/config/config.php* file.

There are defined a couple of configuration values by default. They can be changed as described and new configuration values may be added as required.

The configuration object is available as as *$config* inside routes.php and can be injected into Controllers by using the *\App\Components\Config\Config $config* parameter.

###Dependency Injection

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

###Routing

A simple router class as a wrapper for the *Slim\Slim* application class is available within the *routes.php* file as *$router*.

It provides a simple way to add controller based routing:


    // The base namespace \App\Http\Controllers\ is set within the app/boilerplate/boilerplate.php file
    // \App\Http\Controllers\HomeController
    $router->get('/home', 'HomeController::index');

    // A simple Slim route using the Router component
    $router->get('/test/:something', function ($something) {
        echo htmlspecialchars($something);
    });

##Roadmap

* Form component integration
* Environment based configuration