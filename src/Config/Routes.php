<?php

// Firebase Auth callback
$routes->add('callback', '\Tatter\MythAuthFirebase\Controllers\AuthController::callback', ['as' => 'callback']);
