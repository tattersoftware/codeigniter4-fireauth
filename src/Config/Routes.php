<?php

// Firebase Auth routes
$routes->post('callback', '\Tatter\MythAuthFirebase\Controllers\AuthController::callback', ['as' => 'callback']);
$routes->get('login_return', '\Tatter\MythAuthFirebase\Controllers\AuthController::login_return', ['as' => 'login_return']);
