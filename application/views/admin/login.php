<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Panel | <?= SITENAME ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('uploads/logos/'.@$settings->favicon) ?>">
    <link href="<?= base_url('backend/css/style.css') ?>" rel="stylesheet">
</head>

<body class="h-100" style="background-image: linear-gradient(#0143e5, #ffc846);">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="<?=admin_url()?>">
											<?php if (@$settings->logo) { ?>
						<img src="<?= base_url('uploads/logos/'.@$settings->logo) ?>" class="" alt="">
					<?php } ?>
										</a>
									</div>
                                    <h4 class="text-center mb-4">Sign in Super Admin Account</h4>
                                    <form class="form-horizontal form-material" id="loginform" action="<?= admin_url('login') ?><?= ($this->input->get('redirectto'))? '?redirectto='.$this->input->get('redirectto') : ''; ?>" method="post">
                                    	<?php if (!empty($msg)): ?>
                                    		<?= $msg ?>
                                    	<?php endif ?>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>User Name</strong></label>
                                            <input class="form-control" type="text" name="username" required="" placeholder="Username" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required="">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                           
                                            <div class="form-group">
                                                <a href="javascript:void()">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-info text-white btn-block" style="background:#0126cf">Log In</button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Required vendors -->
    <script src="<?= base_url('backend/vendor/global/global.min.js') ?>"></script>
	<script src="<?= base_url('backend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')?>"></script>
    <script src="<?= base_url('backend/js/custom.min.js') ?>"></script>
    <script src="<?= base_url('backend/js/deznav-init.js') ?>"></script>
    <script>
    	$(window).load(function() {
    		$(".alert").delay(7000).fadeOut(1500);
    	});
    </script>
</body>