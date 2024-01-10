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
									<form action="<?= admin_url('package/create') ?>" method="post" enctype="multipart/form-data">
										<div class="form-group row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Package Name <span>*</span></label>
													<input type="text" class="form-control" name="packageName" id="packageName" value="" required="">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Package Type <span>*</span></label>
													<select name="type" id="type" class="form-control" required="">
														<option value="Monthly" selected="">Monthly</option>
														<option value="Yearly">Yearly</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Currency <span style="font-size: 11px;">*</span></label>
													<select name="currency" id="currency" class="form-control" required="">
														<option value="USD" selected="">USD</option>
														
													</select>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Package Price <span>*</span></label>
													<input type="text" class="form-control" name="price" id="price" value="" required="">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label> Description <span>*</span></label>
												<textarea name="packageDescription" class="summernote" required=""></textarea>
											</div>
										</div>
										<div class="form-group row offset-3">  
											<button type="submit" class="btn btn-rounded btn-info">Create </button>
											<a class="btn btn-rounded btn-secondary" href="<?= admin_url('package/lists') ?>">
												Back
											</a>

										</div>
									</form>
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>