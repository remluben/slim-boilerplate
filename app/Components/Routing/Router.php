<?php namespace App\Components\Routing;

use App\Components\Routing\Exceptions\RouteControllerMethodNotImplementedException;
use App\Components\Routing\Exceptions\RouteControllerNotFoundException;
use Illuminate\Container\Container;
use Slim\Slim;

/**
 * Routing wrapper class for Slim\Slim application routing component
 *
 * @method delete($name, $callable) \Slim\Route
 * @method get($name, $callable) \Slim\Route
 * @method map($name, $callable) \Slim\Route
 * @method options($name, $callable) \Slim\Route
 * @method patch($name, $callable) \Slim\Route
 * @method post($name, $callable) \Slim\Route
 * @method put($name, $callable) \Slim\Route
 *
 * @author Benjamin Ulmer
 * @link http://github.com/remluben/slim-boilerplate
 */
class Router
{
    /**
     * @var Slim
     */
    private $app;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var string the controller base namespace to use
     */
    private $controllerNamespace = '';

    /**
     * @param Slim      $app
     * @param Container $container
     */
    public function __construct(Slim $app, Container $container)
    {
        $this->app       = $app;
        $this->container = $container;
    }

    public function __call($name, $arguments)
    {
        $last = count($arguments) - 1;
        if ($this->routeCallableIsAControllerAction($arguments[$last])) {
            $arguments[$last] = $this->getControllerRouteCallableArgument($arguments[$last]);
        }

        return call_user_func_array(array($this->app, $name), $arguments);
    }

    /**
     * Sets the base controller namespace to use for controller routing
     *
     * @param string $controllerNamespace
     */
    public function setControllerNamespace($controllerNamespace)
    {
        $this->controllerNamespace = rtrim($controllerNamespace, '\\') . '\\';
    }

    /**
     * @param string $routeCallable
     *
     * @return bool
     */
    private function routeCallableIsAControllerAction($routeCallable)
    {
        return is_string($routeCallable) && strpos($routeCallable, '::') !== false;
    }

    /**
     * @param string $routeCallable
     *
     * @return array
     *
     * @throws Exceptions\RouteControllerMethodNotImplementedException
     * @throws Exceptions\RouteControllerNotFoundException
     */
    private function getControllerRouteCallableArgument($routeCallable)
    {
        list($controller, $method) = explode('::', $routeCallable);
        $controller = $this->controllerNamespace . $controller;

        if (class_exists($controller)) {

            $methods = get_class_methods($controller);
            if (in_array($method . 'Action', $methods)) {
                $routeCallable = array($this->container->make($controller), $method . 'Action');
            }
            else {
                throw new RouteControllerMethodNotImplementedException("Missing method '{$method}Action' in controller $controller.");
            }
        }
        else {
            throw new RouteControllerNotFoundException("Could not find controller '$controller'.");
        }

        return $routeCallable;
    }
}