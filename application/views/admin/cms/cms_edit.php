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
								<form action="<?= admin_url('cms/update') ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Section Title <span class="error">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="sectionTitle" id="sectionTitle" autocomplete="off" value="<?= @$data->sectionTitle ?>" required>
											<input type="hidden" name="pageId" id="pageId" value="<?= @$data->pageId ?>" required>
											<input type="hidden" name="page_slug" id="page_slug" value="<?= @$data->page_slug ?>" required>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">CMS Title <span class="error">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="cmsTitle" id="cmsTitle" autocomplete="off" value="<?= @$data->cmsTitle ?>" required>
										</div>
									</div>
                                    
                                    <?php if(@$data->required_link == 1){ ?>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Section Link <span class="error">*</span></label>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="link" id="link" autocomplete="off" value="<?= @$data->link ?>" required>
											</div>
										</div>
									<?php } ?>	
									
									<?php if(@$data->required_image == 1){ ?>
										<div class="form-group row">										
											<label class="col-sm-3 col-form-label">Image <span class="error">*</span></label>
											<div class="col-sm-9">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 250px; height:150px;">
														<?php if (@$data->image && file_exists('./uploads/cms/'.@$data->image)) { ?>
															<img src="<?= base_url('uploads/cms/'.@$data->image) ?>" alt="">
														<?php } else { ?>
															<img src="<?= base_url('uploads/noimg.png') ?>" alt="">
														<?php } ?>
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
													<div>
														<span class="btn btn-default btn-file">
															<span class="fileinput-new">Select image</span>
															<span class="fileinput-exists">Change</span>
															<input type="file" name="image" accept="images/*">
															<input type="hidden" name="hidden_file_name" value="<?= @$data->image ?>">
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
									<?php } ?>	
                                    
                                    <?php if($data->required_textarea == 1){ ?>
										<div class="form-group row">
											<label>Content <span>*</span></label>
											<textarea name="content" id="content" class="form-control <?=(@$data->required_textarea_plugins == '1'?'summernote':'')?>" rows="6" style="height: 100px;" required><?= @$data->content ?></textarea>
										</div>
									<?php } ?>	
															
									<div class="form-group row">

										<div class="form-group offset-3"> 
											<button type="submit" class="btn btn-rounded btn-info">Update </button>&nbsp;
											<a class="btn btn-rounded btn-secondary" href="<?= admin_url('cms/lists/'.$page_slug) ?>">
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