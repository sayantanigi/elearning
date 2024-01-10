<div class="content-body">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
			</ol>
		</div>
		<!-- row -->
		<div class="row">	
			<div class="col-xl-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title"> <?= $title ?> </h4>

					</div>
					<div class="card-body">
						<div class="basic-form">
							<form action="<?= admin_url('students/update') ?>" method="post" enctype="multipart/form-data">
								<div class="white-box">

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>First Name <span>*</span></label>
												<input type="text" class="form-control" name="firstName" id="firstName" value="<?= @$data->firstName ?>" required="">
												<input type="hidden" name="userId" value="<?= @$data->userId ?>" required="">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Last Name <span>*</span></label>
												<input type="text" class="form-control" name="lastName" id="lastName" value="<?= @$data->lastName ?>" required="">

											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Mobile <span>*</span></label>
												<input type="text" class="form-control" name="mobile" id="mobile" value="<?= @$data->mobile ?>" autocomplete="off" required="">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Email Address <span>*</span></label>
												<input type="email" class="form-control" name="email" id="email" value="<?= @$data->email ?>" data-validation="email" autocomplete="off" required="">
											</div>
										</div>
									</div>
									<div class="row">

										<div class="col-sm-6">
											<div class="form-group">
												<label>Status <span style="font-size: 11px;">*</span></label>
												<select name="status" id="status" class="form-control" required="">
													<option value="1" <?= (@$data->status == '1')? 'selected' : '' ?>>
														Active
													</option>
													<option value="0" <?= (@$data->status == '0')? 'selected' : '' ?>>
														Deactive
													</option>
												</select>
											</div>
										</div>

										
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Password <span style="font-size: 11px; color:red">(Enter only when you want to change the password)</span></label>
												<input type="password" class="form-control" name="password" autocomplete="off" id="password" value="" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 col-sm-offset-4">
											<div class="form-group m-t-30">
												<button type="submit" class="btn btn-rounded btn-info">
													Update
												</button>
												<a class="btn btn-rounded btn-secondary" href="<?= admin_url('students/lists') ?>">
													Back
												</a>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>					
		</div>
	</div>
</div>
