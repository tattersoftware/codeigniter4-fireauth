<?php namespace Tatter\MythAuthFirebase\Config;

use CodeIgniter\Config\BaseConfig;

class MythAuthFirebase extends BaseConfig
{
	// URLs for successful logins, terms of service, and privacy policy
	public $urls = [
		'success' => 'login_return',
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
