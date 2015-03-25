<?php namespace App\Http\Controllers;

use App\Components\Forms\SubscribeForm;
use App\Components\Validation\FormValidationException;
use Illuminate\Session\Store;
use Slim\Slim;

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

    /**
     * @var \App\Components\Forms\SubscribeForm
     */
    private $subscribeForm;

    /**
     * @var \Illuminate\Session\Store
     */
    private $session;

    public function __construct(Slim $app, Store $session, SubscribeForm $subscribeForm)
    {
        $this->app = $app;
        $this->subscribeForm = $subscribeForm;
        $this->session = $session;
    }

    /**
     * Show the home page
     */
    public function indexAction()
    {
        $this->app->render('home.twig', array(
            'message'  => $this->session->get('message'),
            'errors'   => $this->session->get('errors'),
            'oldInput' => $this->session->get('input')
        ));
    }

    /**
     * Handle the subscription form request
     */
    public function subscribeAction()
    {
        try {
            $this->subscribeForm->validate($this->app->request()->params());
        }
        catch(FormValidationException $e) {

            $this->session->flash('message', 'Oh no, you have entered invalid data. Please correct your input and try again.');
            $this->session->flash('errors', $e->getErrors());
            $this->session->flash('input', $this->app->request()->params());

            $this->app->response->redirect($this->app->urlFor('home'));
            return;
        }

        $this->session->flash('message', 'Thanks for your request. You have successfully subscribed for our newsletter.');
        $this->app->response->redirect($this->app->urlFor('home'));
    }
} 