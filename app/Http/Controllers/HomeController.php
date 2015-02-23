<?php namespace App\Http\Controllers;

/**
 * Home page controller
 *
 * @author Benjamin Ulmer
 * @link http://github.com/remluben/slim-boilerplate
 */
class HomeController extends BaseController
{
    /**
     * @var \Slim\Slim
     */
    private $app;

    public function __construct(\Slim\Slim $app)
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