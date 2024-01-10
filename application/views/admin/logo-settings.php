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
						<h4 class="card-title"><?= $title ?></h4>
					</div>
					<div class="card-body">
						<div class="basic-form">
							<form action="<?= admin_url('settings/logosave') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Logo <span class="error">*</span></label>
									<div class="col-sm-3">
										<div class="fileinput-new thumbnail" style="width: 200px; height: auto;">
											<?php if ($data->logo != '' && !is_null($data->logo) && file_exists('./uploads/logos/'.$data->logo)) { ?>
												<img src="<?= base_url('uploads/logos/'.$data->logo) ?>" alt="">
											<?php } else { ?>
												<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
											<?php } ?>
										</div>
										<div class="input-group mb-3">
											<div class="custom-file">
												<input type="file" name="logo" class="custom-file-input" accept="images/*" >
												<input type="hidden" name="oldLogo" value="<?= $data->logo ?>" required="">
												<label class="custom-file-label">Choose file</label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Favicon <span class="error">*</span></label>
									<div class="col-sm-3">

										<div class="fileinput-new thumbnail" style="width: 200px; height: auto;">
											<?php if ($data->favicon != '' && !is_null($data->favicon) && file_exists('./uploads/logos/'.$data->favicon)) { ?>
													<img src="<?= base_url('uploads/logos/'.$data->favicon) ?>" alt="">
												<?php } else { ?>
													<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
												<?php } ?>
										</div>
										<div class="input-group mb-3">

											<div class="custom-file">
												<input type="file" name="favicon" class="custom-file-input" accept="images/*" >
												<input type="hidden" name="oldFavicon" value="<?= $data->favicon ?>" required="">
												<label class="custom-file-label">Choose file</label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Title <span class="error">*</span></label>
									<div class="col-sm-3">
										<input type="text" class="form-control" name="title" id="title" autocomplete="off" value="<?= @$data->title ?>" required="">
									</div>
								</div>


								<div class="form-group offset-3">									
										<input type="submit" class="btn btn-rounded btn-info" name="logo_settings" id="logo_settings" value="Update"/>									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>					
		</div>
	</div>
</div>


