<div class="content-body">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
			</ol>
		</div>
		<div class="row">	
			<div class="col-xl-12 col-lg-12">
				<div class="card">
					<div class="row">
						<div class="col-md-7">
							<div class="card-header">
								<h4 class="card-title"> <?= $title ?> </h4>
							</div>
						</div>
						<div class="col-md-5">
							<div class="card-header text-right">
									
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="basic-form">							
								<div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Question </label>
                                    <div class="col-sm-9">
                                        <textarea name="answer" class="form-control summernote" required>
                                        	<?= $faq->question;?>
                                        </textarea>

                                    </div>
                                </div>
								

								<div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Answer </label>
                                    <div class="col-sm-9">
                                        <textarea name="answer" class="form-control summernote" required>
                                        	<?= $faq->answer;?>
                                        </textarea>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Status </label>
                                    <div class="col-sm-4">

                                       <select name="status" id="status" class="form-control" required>
													<option value="1" <?= ($faq->status == 1)? 'selected' : '' ?>>
														Active
													</option>
													<option value="0" <?= ($faq->status == 0)? 'selected' : '' ?>>
														Deactive
													</option>
										</select>

                                    </div>
                                </div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Created Date </label>
									<div class="col-sm-3">
										<input type="text" class="form-control" readonly value="<?= date('d-M-y h:i:s A', strtotime(@$faq->created)) ?>">
									</div>
										<label class="col-sm-3 col-form-label">Last Modified  Date </label>
									<div class="col-sm-3">
										<input type="text" class="form-control" readonly value="<?= date('d-M-y h:i:s A', strtotime(@$faq->updated)) ?>">
									</div>
								</div>

								
							
						</div>
					</div>
				</div>
			</div>					
		</div>
	</div>
</div>
