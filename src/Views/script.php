	<script type="text/javascript">
		// FirebaseUI config - presupposes configuration and initialization
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
