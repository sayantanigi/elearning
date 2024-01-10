<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h4 class="page-title"><?= $title ?></h4>
			</div>
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><?= $title ?></li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form action="<?= admin_url('cms/updateHome') ?>" method="post" enctype="multipart/form-data">
					<div class="white-box">
						<h3 class="box-title m-b-30 m-t-10"><?= $title ?></h3>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Page Title <span>*</span></label>
									<input type="text" class="form-control" name="title" id="title" autocomplete="off" value="<?= @$data->title ?>" required="">
									<input type="hidden" name="id" id="id" value="<?= @$data->id ?>" required="">
								</div>
								<div class="form-group">
									<label> Image <span>*</span></label>
									<div>
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 100px; height: 80px;">
												<?php if (@$data->icon && file_exists('./uploads/home/'.@$data->icon)) { ?>
													<img src="<?= base_url('uploads/home/'.@$data->icon) ?>" alt="">
												<?php } else { ?>
													<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
												<?php } ?>
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100px; max-height: 80px;"></div>
											<div>
												<span class="btn btn-default btn-file">
													<span class="fileinput-new">Select image</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="bannerImage" accept="images/*">
													<input type="hidden" name="oldBannerImage" value="<?= @$data->icon ?>">
												</span>
												<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
										</div>
										<div class="clearfix margin-top-10 m-b-20" style="display: block;">
											<span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif
										
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Content <span>*</span></label>
									<textarea name="shortDesc" class="form-control" rows="3"  id="content" required=""><?= @$data->shortDesc ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 col-sm-offset-4">
								<div class="form-group m-t-20">
									<button type="submit" class="btn btn-success waves-effect waves-light">
										Update
									</button>
									<a class="btn btn-default waves-effect waves-light m-l-30" href="<?= admin_url('cms/homeList') ?>">
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