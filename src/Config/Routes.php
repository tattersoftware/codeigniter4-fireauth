<?php

// Firebase Auth routes
$routes->post('callback',    '\Tatter\Fireauth\Controllers\AuthController::callback',     ['as' => 'callback']);
$routes->get('login_return', '\Tatter\Fireauth\Controllers\AuthController::login_return', ['as' => 'login_return']);
