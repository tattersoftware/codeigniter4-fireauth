<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-9">
				<div id="firebaseui-auth-container"></div>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>
<?= $this->section('footerAssets') ?>

	<!-- Firebase JS Auth library -->
	<script src="https://www.gstatic.com/firebasejs/ui/4.3.0/firebase-ui-auth.js"></script>
	<link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.3.0/firebase-ui-auth.css" />

	<?= view('Tatter\Fireauth\Views\script', ['config' => config('Fireauth')]) ?>

<?= $this->endSection() ?>
