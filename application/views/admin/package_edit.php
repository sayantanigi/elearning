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
							<form action="<?= admin_url('package/update') ?>" method="post" enctype="multipart/form-data">
								<div class="white-box">
									<h3 class="box-title m-b-30 m-t-10">
										Package Information&nbsp;							
									</h3>
									<div class="form-group row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Package Name <span>*</span></label>
												<input type="text" class="form-control" name="packageName" id="packageName" value="<?= @$data->packageName ?>" required="">
												<input type="hidden" name="packageId" value="<?= @$data->packageId ?>" required="">
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Package Type  <span>*</span></label>
												<select name="type" class="form-control" required="">
													<option value="Monthly" <?= (@$data->type == 'Monthly')? 'selected' : '' ?>>
														Monthly
													</option>
													<option value="Yearly" <?= (@$data->type == 'Yearly')? 'selected' : '' ?>>
														Yearly
													</option>

												</select>
											</div>
										</div>

									</div>
									<div class="form-group row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Currency <span style="font-size: 11px;">*</span></label>
												<select name="currency" id="currency" class="form-control" required="">
													<option value="USD" <?= (@$data->currency == 'USD')? 'selected' : '' ?>>USD</option>
												
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Package Price <span>*</span></label>
												<input type="text" class="form-control" name="price" id="price" value="<?= @$data->price ?>" required="">
											</div>
										</div>
									</div>
									<div class="form-group row">

										<div class="col-sm-6">
											<div class="form-group">
												<label>Status <span style="font-size: 11px;">*</span></label>
												<select name="packageStatus" id="packageStatus" class="form-control" required="">
													<option value="1" <?= (@$data->packageStatus == '1')? 'selected' : '' ?>>
														Active
													</option>
													<option value="0" <?= (@$data->packageStatus == '0')? 'selected' : '' ?>>
														Deactive
													</option>
												</select>
											</div>
										</div>

									</div>

									<div class="form-group row">
										<div class="col-sm-12">
											<label> Description <span>*</span></label>
											<textarea name="packageDescription" class="summernote" required="">
												<?= @$data->packageDescription ?>
											</textarea>
										</div>
									</div>
									<div class="form-group row offset-3">
										<div class="col-sm-4 col-sm-offset-4">
											<div class="form-group m-t-30">
												<button type="submit" class="btn btn-success btn-rounded">
													Update
												</button>
												<a class="btn btn-rounded btn-secondary" href="<?= admin_url('package/lists') ?>">
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