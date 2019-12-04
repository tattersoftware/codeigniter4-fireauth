<?php namespace Config;

/***
*
* This file contains example values to alter default library behavior.
* Recommended usage:
*	1. Copy the file to app/Config/
*	2. Change any values
*	3. Remove any lines to fallback to defaults
*
***/

class MythAuthFirebase extends Tatter\MythAuthFirebase\Config\MythAuthFirebase
{
	// URLs for successful logins, terms of service, and privacy policy
	public $urls = [
		'success' => '',
		'terms'   => '',
		'privacy' => '',
	];

    // Layout for the login view to extend
    public $viewLayout = 'Myth\Auth\Views\layout';

	// Providers - remove or comment ones you do not need
	public $providers = [
		//'firebase.auth.GoogleAuthProvider.PROVIDER_ID',
		//'firebase.auth.FacebookAuthProvider.PROVIDER_ID',
		//'firebase.auth.TwitterAuthProvider.PROVIDER_ID',
		//'firebase.auth.GithubAuthProvider.PROVIDER_ID',
		'firebase.auth.EmailAuthProvider.PROVIDER_ID',
		//'firebase.auth.PhoneAuthProvider.PROVIDER_ID',
		//'firebaseui.auth.AnonymousAuthProvider.PROVIDER_ID',
	];
}
