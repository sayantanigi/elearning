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
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Blog Title <span class="error">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="title" id="title" autocomplete="off" value="<?= @$data->title ?>" readonly>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
										<div class="col-sm-9">
											<textarea name="descriptions" id="blog_detail" class="form-control summernote"><?= @$data->descriptions ?></textarea>
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
											</div>
										</div>
									</div>								
									<div class="form-group row">

										<div class="form-group row offset-3 ml-3"> 
											<a class="btn btn-rounded btn-secondary" href="<?= admin_url('blog/lists') ?>">
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
	</div>

	<script>
	   $(document).ready(function () {	
		  $("#blog_detail").summernote('disable');
	   });	 
	</script>