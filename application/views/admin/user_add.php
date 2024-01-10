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
							<form action="<?= admin_url('students/create') ?>" method="post" enctype="multipart/form-data">
								<div class="white-box">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>First Name <span>*</span></label>
												<input type="text" class="form-control" name="firstName" id="firstName" value="" required="">

											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Last Name <span>*</span></label>
												<input type="text" class="form-control" name="lastName" id="lastName" value="" required="">

											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Mobile <span>*</span></label>
												<input type="text" class="form-control" name="mobile" id="mobile" value="" required="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Email Address <span>*</span></label>
												<input type="email" class="form-control" name="email" id="email" value="" data-validation="email" required="">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Password <span>*</span></label>
												<input type="password" class="form-control" name="password" autocomplete="off" id="password" value="" required="">
											</div>
										</div>
									</div>
								

									<div class="row">
										<div class="col-sm-4 col-sm-offset-4">
											<div class="form-group m-t-30">
												<button type="submit" class="btn btn-rounded btn-info">
													Create
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
