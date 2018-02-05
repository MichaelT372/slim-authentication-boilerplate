<?php

use App\Controllers\HomeController;
use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\PasswordController;
use App\Middleware\AuthenticatedMiddleware;

$app->get('/', HomeController::class . ':index')->setName('home');

$app->get('/auth/signup', AuthController::class . ':getSignUp')->setName('auth.signup');
$app->post('/auth/signup', AuthController::class . ':postSignUp');

$app->get('/auth/signin', AuthController::class . ':getSignIn')->setName('auth.signin');
$app->post('/auth/signin', AuthController::class . ':postSignIn');

$app->group('', function(){
    $this->get('/auth/signout', AuthController::class . ':getSignOut')->setName('auth.signout');
    $this->get('/auth/password/change', PasswordController::class . ':getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', PasswordController::class . ':postChangePassword');
})->add(new AuthenticatedMiddleware($container));
