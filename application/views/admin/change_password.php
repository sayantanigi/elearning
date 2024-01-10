<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h4 class="page-title"><?= @$title ?></h4>
			</div>
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><?= @$title ?></li>
				</ol>
			</div>
		</div>

		<form action="<?= admin_url('change_password/update') ?>" class="form-horizontal" method="post">
			<div class="row">
				<div class="col-md-12">
					<div class="white-box">
						<h3 class="box-title m-b-30"><?= @$title ?></h3>
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<div class="form-group">
									<label for="old_password" class="col-sm-4 text-right">
										Current Password : <span>*</span>
									</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" name="c_password" id="c_password" autocomplete="off" required="">
									</div>
								</div>

								<div class="form-group">
									<label for="new_password" class="col-sm-4 text-right">
										New Password : <span>*</span>
									</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" name="n_password_confirmation" id="n_password_confirmation" autocomplete="off" required="">
									</div>
								</div>

								<div class="form-group">
									<label for="re_password" class="col-sm-4 text-right">
										Repeat Password : <span>*</span>
									</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" name="n_password" id="n_password" data-validation="confirmation" autocomplete="off" required="">
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4 col-sm-offset-4">
								<div class="form-group">
									<input type="submit" class="btn btn-success" name="change_user_password" id="change_user_password" value="Change Password"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>