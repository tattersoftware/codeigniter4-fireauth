<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

	<div class="container">
		<h2>Login or Register</h2>

		<div class="row">
			<div class="col-lg-9">
				<div id="firebaseui-auth-container"></div>
			</div>
		</div>
	</div>

	<!-- Firebase JS SDK and Auth library -->
	<script src="https://www.gstatic.com/firebasejs/7.5.0/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.5.0/firebase-auth.js"></script>
	<script src="https://www.gstatic.com/firebasejs/ui/4.3.0/firebase-ui-auth.js"></script>

	<link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.3.0/firebase-ui-auth.css" />

	<?= view('Tatter\MythAuthFirebase\Views\script', ['config' => config('MythAuthFirebase')]) ?>
		
<?= $this->endSection() ?>
