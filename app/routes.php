<?php

use App\Controllers\HomeController;
use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\PasswordController;
use App\Middleware\AuthenticatedMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', HomeController::class . ':index')->setName('home');

$app->group('', function(){
    $this->get('/auth/signup', AuthController::class . ':getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', AuthController::class . ':postSignUp');
    $this->get('/auth/signin', AuthController::class . ':getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', AuthController::class . ':postSignIn');
})->add(new GuestMiddleware($container));

$app->group('', function(){
    $this->get('/auth/signout', AuthController::class . ':getSignOut')->setName('auth.signout');
    $this->get('/auth/password/change', PasswordController::class . ':getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', PasswordController::class . ':postChangePassword');
})->add(new AuthenticatedMiddleware($container));
