<?php

use App\Controllers\HomeController;
use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\PasswordController;

$app->get('/home', HomeController::class . ':index')->setName('home');

$app->get('/auth/signup', AuthController::class . ':getSignUp')->setName('auth.signup');
$app->post('/auth/signup', AuthController::class . ':postSignUp');

$app->get('/auth/signin', AuthController::class . ':getSignIn')->setName('auth.signin');
$app->post('/auth/signin', AuthController::class . ':postSignIn');

$app->get('/auth/signout', AuthController::class . ':getSignOut')->setName('auth.signout');

$app->get('/auth/password/change', PasswordController::class . ':getChangePassword')->setName('auth.password.change');
$app->post('/auth/password/change', PasswordController::class . ':postChangePassword');