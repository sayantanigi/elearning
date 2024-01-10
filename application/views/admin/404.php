<!DOCTYPE html>  
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="GOIGI">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('dist/images/favicon.png') ?>">
	<title>404 - Page Not Found</title>
	<link href="<?= base_url('dist/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('dist/css/animate.css') ?>" rel="stylesheet">
	<link href="<?= base_url('dist/css/style.css') ?>" rel="stylesheet">
	<link href="<?= base_url('dist/css/colors/default.css?v=').time() ?>" id="theme" rel="stylesheet">
</head>
<body>
	<section id="wrapper" class="error-page">
		<div class="error-box">
			<div class="error-body text-center">
				<h1 class="theme-color">404</h1>
				<h3 class="text-uppercase">Page Not Found !</h3>
				<p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
				<a href="<?= admin_url('dashboard') ?>" class="btn btn-main btn-rounded waves-effect waves-light m-b-40">Back to home</a>
			</div>
			<footer class="footer text-center"> <?= date('Y'); ?> &copy; <?= SITENAME ?> </footer>
		</div>
	</section>
	<script src="<?= base_url('plugins/jquery/dist/jquery.min.js') ?>"></script>
	<script src="<?= base_url('dist/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
</body>
</html>
