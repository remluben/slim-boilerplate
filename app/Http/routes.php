<?php

/**
 * Application route setup
 *
 * $app, $container and $router global variables available in here by default
 *
 * @author Benjamin Ulmer
 * @link http://github.com/remluben/slim-boilerplate
 */

// Defining a route using a controller

$router->get('/', 'HomeController::index')->name('home');
$router->post('/', 'HomeController::subscribe')->name('subscribe');

// Using a route with a callback function

$router->get('/terms', function () use ($app) {
    $app->render('terms.twig');
})->name('terms');