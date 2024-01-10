<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h4 class="page-title"><?= @$title ?></h4>
			</div>
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="<?=admin_url('dashboard')?>">Home</a></li>
					<li class="active"><?= @$title ?></li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="white-box">
					<h3 class="box-title m-b-0"><?= $title ?></h3>
					<form action="<?= admin_url('enquiry/sendEmail') ?>" method="post" enctype="multipart/form-data">					
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Select Installer <span>*</span></label>
									 <select class="multiselect" multiple="multiple">
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                            <option value="3">Option 3</option>
                                            <option value="4">Option 4</option>
                                            <option value="5">Option 5</option>
                                            <option value="6">Option 6</option>
                                        </select>
									<select class="form-control selected " name="installerId" id="installerId">
										<?php if (!empty($installerlist) && (count($installerlist) > 0)) { ?>
											<option value="">Select Installer</option>
											<?php foreach ($installerlist as $key => $v): ?>
												<option value="<?= $v->email ?>">
													<?= $v->email ?>[<?= $v->fullName ?>]
												</option>
											<?php endforeach ?>
										<?php } else { ?>
											<option value="">No Data Found</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label>Select Cutomer <span>*</span></label>
									<select class="form-control selected" multiple name="customerId" id="customerId">
										<?php if (!empty($customerlist) && (count($customerlist) > 0)) { ?>
											<option value="">Select Customer</option>
											<?php foreach ($customerlist as $key => $v): ?>
												<option value="<?= $v->email ?>">
													<?= $v->email ?>[<?= $v->fullName ?>]
												</option>
											<?php endforeach ?>
										<?php } else { ?>
											<option value="">No Data Found</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label>To <span>*</span></label>
									<textarea required="" class="form-control" name="receiverId" id="receiverId"></textarea>
								</div>
									<div class="form-group">
									<label>Subject <span>*</span></label>
									<input type="text" class="form-control" name="subject" id="subject" autocomplete="off" value="" required="">
								</div>
							
								<div class="form-group">
									<label>Message <span>*</span></label>
									<textarea name="message" id="message" class="summernote" required=""></textarea>
								</div>

								<div class="form-group">
									<label class="col-sm-3">Attachment<span>*</span></label>
									<div class="col-sm-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
												<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
											<div>
												<span class="btn btn-default btn-file">
													<span class="fileinput-new">Select file</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="bannerImage" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" required="">
												</span>
												<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
										</div>
										<div class="clearfix margin-top-10 m-b-20" style="display: block;">
											<span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif, pdf, xls doc
											<span class="label label-danger">Max Upload Size</span>&nbsp;5mb
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 col-sm-offset-4">
								<div class="form-group m-t-20">
									<button type="submit" class="btn btn-success waves-effect waves-light">
										Send
									</button>
									
								</div>
							</div>
						</div>
					</form>
					</div>		
				
			</div>
		</div>
	</div>
</div>
	<div id="view-enquiries-modal" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">View Enquiry Details</h4>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	