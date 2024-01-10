

<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('faq/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
            </ol>
        </div>
        <div class="row">	
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> <?= $title ?> </h4>

                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="<?= admin_url('faq/update/'.$faq->id) ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Question <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        
                                        <textarea name="question"  class="form-control summernote" required>
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
                                
                                <div class="form-group offset-3">  
                                    <button type="submit" class="btn btn-rounded btn-info">Save</button>
                                    <a class="btn btn-rounded btn-secondary" href="<?= admin_url('faq/lists') ?>">
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
