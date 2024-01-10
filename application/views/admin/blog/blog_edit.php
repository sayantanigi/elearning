	<div class="content-body">
		<div class="container-fluid">
			<div class="page-titles">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
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
								<form action="<?= admin_url('blog/update') ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
									<input type="hidden" name="articleId" id="articleId" value="<?= @$data->articleId ?>">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Blog Title <span class="error">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="title" id="title" autocomplete="off" value="<?= @$data->title ?>" required="">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
										<div class="col-sm-9">
											<textarea name="descriptions" class="form-control summernote" required=""><?= @$data->descriptions ?></textarea>
										</div>
									</div>
									
									<div class="form-group row">										
										<label class="col-sm-3 col-form-label">Image <span class="error">*</span></label>
										<div class="col-sm-9">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 250px; height:150px;">
													<?php if (@$data->thumbnail && file_exists('./uploads/blogs/'.@$data->thumbnail)) { ?>
														<img src="<?= base_url('uploads/blogs/'.@$data->thumbnail) ?>" alt="">
													<?php } else { ?>
														<img src="<?= base_url('uploads/noimg.png') ?>" alt="">
													<?php } ?>
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
												<div>
													<span class="btn btn-default btn-file">
														<span class="fileinput-new">Select image</span>
														<span class="fileinput-exists">Change</span>
														<input type="file" name="thumbnail" accept="images/*">
														<input type="hidden" name="oldThumbnail" value="<?= @$data->thumbnail ?>">
													</span>
													<a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
												</div>
											</div>

											<div class="clearfix" style="display: block;">
												<span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif
												<span class="label label-danger">Max Upload Size</span>&nbsp;10mb
											</div>
										</div>
									</div>								
									<div class="form-group row">

										<div class="form-group offset-3"> 
											<button type="submit" class="btn btn-rounded btn-info">Update </button>&nbsp;
											<a class="btn btn-rounded btn-secondary" href="<?= admin_url('blog/lists') ?>">
												Back
											</a>
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