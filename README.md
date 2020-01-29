# Tatter\Fireauth

Myth:Auth Firebase extension for CodeIgniter 4

## Quick Start

1. Install with Composer: `> composer require tatter/fireauth`
2. Add credentials to your environment configuration **.env**
3. Set the Myth:Auth login view: `'login' => 'Tatter\Fireauth\Views\login'`

## Description

This module extends [Myth:Auth](https://github.com/lonnieezell/myth-auth) to allow logins
from [Firebase Authentication](https://firebase.google.com/docs/auth) by replacing the
default login view with one configured for your Firebase app.

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
* `> composer require tatter/fireauth`

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

## Configuration

The library's default behavior can be altered by extending its config file. Copy
**examples/Fireauth.php** to **app/Config/** and follow the instructions
in the comments. If no config file is found in **app/Config** the library will use its own.

### Credentials

The login view uses your Firebase app's credentials to connect to your project. You must
provide the public API key in the **.env** file in the root of your project. Add this to
the bottom of your file:

```
#--------------------------------------------------------------------
# FIREBASE
#--------------------------------------------------------------------

# firebase.apiKey = YOUR_API_KEY_HERE
```

Before using the UI you must be sure the configuration parameters are loaded and the
Firebase instance initialized. For example, your layout might include this:
```
	<!-- Firebase JS SDK -->
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>

	<!-- Firebase SDK config -->
	<script src="<?= base_url('credentials/firebase.js') ?>"></script>

	<script>
		// Initialize Firebase
		firebase.initializeApp(firebaseConfig);
	</script>
```

For more info on acquiring your config file see
[Firebase Project Support](http://support.google.com/firebase/answer/7015592)

## Usage

This library works through Myth:Auth's `LocalAuthenticator` class to display the login and
provide a service for checking logged in user access and permissions. Since Firebase handles
the actual authentication you will need to configure your project there first and then use
this module's config file to match the desired behavior.

Myth:Auth defines a named route for "login" which will display the Firebase form. Once Firebase
has complete authentication it sends the completed user information to the callback where
the account is verified and the user is logged in.

Read more about authentication at Myth:Auth's
[Authentication docs](https://github.com/lonnieezell/myth-auth/blob/develop/docs/authentication.md).

### Example login

This is an example of what you should expect from Firebase's `authResult` that is used by
the callback to process the login:

```
{
	"user":  {
		"uid": "fnBQhvsaYT5k5tXbZIGMPZiyFac1",
		"displayName": "Joe User",
		"photoURL": null,
		"email": "joe@example.com",
		"emailVerified": false,
		"phoneNumber": null,
		"isAnonymous": false,
		"tenantId": null,
		"providerData": [
			{
				"uid": "joe@example.com",
				"displayName": "Joe User",
				"photoURL": null,
				"email": "joe@example.com",
				"phoneNumber": null,
				"providerId": "password"
			}
		],
		"apiKey": "SyzCz2w8CGAIUyIlzaqHAiFC5WxIJ92T62G7wck",
		"appName": "[DEFAULT]",
		"authDomain": "yourproject.firebaseapp.com",
		"stsTokenManager": {
			"apiKey": "SyzCz2w8CGAIUyIlzaqHAiFC5WxIJ92T62G7wck",
			"refreshToken": "L0uLRAEu4Isq-IbtDruFNntMKz--YAHU8E5hl9QMZ5BMAAw78rJq1WuqOiZF8e4TrwVA5KjeEJWLJMjEN5J6QDbQMHOjX3dANo_Ep0o1WYc43m3XjtJXOocuKAO91K_HyUZ74Knd_AimqeLm-yA-vEugjet2nQwFKzKwVTMPdalBbz_83ZrjQ8Uj8kuxkRMTz00yxMa6Yfw07hojUXiZ-3Xg2oUScjKNrmCSYp-ncLpc9ri7eGPNao8",
			"accessToken": "eyJhbGzUyYjY0OTM0MjUzNGE2YjRhMDUxMjVkNzhmYmIiLCJ0eXAiOciOiJSUzI1NiIsImtpZCI6IjA0NjUxMTM5ZDg4NiJKV1QifQ.eyJuYW1lIjoiTWF0dGhldyBHYXRuZXIiLCJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZGVzdCIsImF1ZCI6I3QiLCJhdXRoX3RpbWUiOjES5jb20vbW9vbGF0aG9m1vb2xhdGhvbnRlcud1NzU0OTA5MzAiJmbmFZR01QWml5VDVrNXRYYlpJRmFjsInVzZXJfaWQiOQlFodnMxIiwic3ViIjoiZm5hWUdNUFppeVQ1azV0WGJaSUZhY0JRaHZzMSIsImlhdCI6MTU3NTQ5MDkzMCwiZXhwIjoxNTc1NDk0NTMwLCJlbWFpbCI6Im1nYXRuZXJAaWNsb3VkLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJlbWFpbCI6WyJtZ2F0bmVyQGljbG91ZC5jb20iXX0sInNpZ25faW5fcHJvdmlkZXIiOiJwYXNzd29yZCJ9fQ.HisMXtXhC6U2O3lSheF7mswOiosbdTMAIwiFXeELoy1Ak4CuFBwvkHmFKlnl9P8YRPjqFVaQ4ah2uYzhbo3L22ql9CQGz4GF4XRHGBijlYPS8EaF1HT8soYdyRv4SB5gW_OAzJy4fPnxsZVFur7AYFPturSPFWZAUA0CXP7rn0H4lxfI-Z90lTX9fBYpB9FFJo7zIOpppNINzCOtKB1w2K6kNsiMIwVxJCO52drS3xZkMwP-UAEReiG6iyv46J-T2j0Q0hmc9HrHzhHMM5JSdbTXPtcX81jD1mrmKdkF-AmlMIsCRrVlMfdEUBCzDTYV4EldpcDfI_g9kbakA8Em6g",
			"expirationTime": 1575494530086
		},
		"redirectEventId": null,
		"lastLoginAt": "1575490930053",
		"createdAt": "1575409918661"
	},
	"credential": null,
	"operationType": "signIn",
	"additionalUserInfo":  {
		"providerId": "password",
		"isNewUser": false
	}
}
```

You may do additional processing of the `user` object by defining an Event
(in **app/Config/Events.php**) that receives the `firebase_new_user` trigger:

```
Events::on('firebase_new_user', function($user)
{
	log_message('debug', 'New FireAuth user: ' . $user->email);
}
```
