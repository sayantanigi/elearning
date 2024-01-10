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
										<div class="row">							
							<div class="col-sm-6">
								<div class="form-group">
									<label>Package Name </label>
									<input type="text" class="form-control" autocomplete="off" readonly="" value="<?= $data->packageName ?>" required="">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Package Type</label>
									<input type="text" class="form-control" autocomplete="off" readonly="" value="<?= $data->type ?>" required="">
								</div>
							</div>
						</div>
						<div class="row">	
							<div class="col-sm-6">
								<div class="form-group">
									<label>Currency </label>
									<input type="text" class="form-control" autocomplete="off" readonly="" value="<?= $data->currency ?>" required="">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Package price </label>
									<input type="number" class="form-control" autocomplete="off" readonly="" value="<?= $data->price ?>" required="">
								</div>
							</div>
							</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Description </label>
									<textarea readonly="" name="description" class="summernote" required=""><?= @$data->packageDescription ?></textarea>
								</div>
							</div>
						
						</div>

								<div class="form-group row offset-3">  									
									<a class="btn btn-rounded btn-secondary" href="<?= admin_url('package/lists') ?>">
										Back
									</a>
								</div>							
						</div>
					</div>
				</div>
			</div>					
		</div>
	</div>
</div>