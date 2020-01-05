
	<script type="text/javascript">
		// Firebase configuration
		var firebaseConfig = {
			apiKey: "<?= env('firebase.apiKey') ?>",
			authDomain: "<?= env('firebase.authDomain') ?>",
			databaseURL: "<?= env('firebase.databaseURL') ?>",
			projectId: "<?= env('firebase.projectId') ?>",
			storageBucket: "<?= env('firebase.storageBucket') ?>",
			messagingSenderId: "<?= env('firebase.messagingSenderId') ?>",
			appId: "<?= env('firebase.appId') ?>",
			measurementId: "<?= env('firebase.measurementId') ?>",
		};

		// Initialize Firebase
		firebase.initializeApp(firebaseConfig);

		// FirebaseUI config
		var uiConfig = {
			callbacks: {
				signInSuccessWithAuthResult: function(authResult, redirectUrl) {
					fetch('<?= site_url('callback') ?>', {
						method: 'POST',
						credentials: 'same-origin',
						headers: {
							'Accept': 'application/json',
							'Content-Type': 'application/json'
						},
						body: JSON.stringify(authResult)
					}).then((response) => {
						window.location = '<?= site_url($config->urls['success']) ?>';
					}).catch((error) => {
						console.log(error);
					});

					return false;
				}
			},
			credentialHelper: firebaseui.auth.CredentialHelper.NONE,
			signInSuccessUrl: '<?= site_url($config->urls['success']) ?>',
			signInOptions: [
				<?php foreach ($config->providers as $provider): ?>

				<?= $provider ?>,

				<?php endforeach; ?>
			],
			// Terms of service url/callback.
			tosUrl: '<?= site_url($config->urls['terms']) ?>',
			// Privacy policy url/callback.
			privacyPolicyUrl: '<?= site_url($config->urls['privacy']) ?>'
		};

		// Initialize the FirebaseUI Widget using Firebase.
		var ui = new firebaseui.auth.AuthUI(firebase.auth());

		// The start method will wait until the DOM is loaded.
		ui.start('#firebaseui-auth-container', uiConfig);
	</script>
