<?php
if(!empty($subjectId)){
   $subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId); 
}
if(!empty($chapterId)){
   $chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId); 
}
if(!empty($lessonId)){
   $lessonInfo = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);
}
$testInfo = $this->mymodel->get('tests', true, 'testId', $testId);
?>
<div class="content-body">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                <?php if(! empty($subjectInfo)){?>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
	            <?php } if(!empty($chapterInfo)){?>
	                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
	            <?php } if(! empty($lessonInfo)){?>
	                <li class="breadcrumb-item">
	                    <a href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>"><?=ucwords($lessonInfo->lessonName)?></a>
	                </li>
	            <?php }?>
	             <?php
	             	if(!empty($subjectId)){
	             		$subject = $subjectId.'/';
	             	}else{
	             		$subject ='';
	             	}
	             	if(!empty($chapterId)){
	             		$chapter = $chapterId.'/';
	             	}else{
	             		$chapter ='';
	             	}
	             	if(!empty($lessonId)){
	             		$lesson  = $lessonId.'/';
	             	}else{
	             		$lesson ='';
	             	}
                 ?>
                 <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewTest/'.$subject.$chapter.$lessonId.'/'.$testId) ?>"><?=ucwords($testInfo->testName)?></a></li>

                

				<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
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
							
						</div>
					</div>
					<div class="card-body">
						<div class="basic-form">	
								<form action="<?= admin_url('subject/updateTest') ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
									<input type="hidden" name="subjectId" id="subjectId" value="<?= @$subjectId ?>">
                                <input type="hidden" name="chapterId" id="chapterId" value="<?= @$chapterId ?>">
                                <input type="hidden" name="lessonId" id="lessonId" value="<?= @$lessonId ?>">
                                 <input type="hidden" name="testId" id="testId" value="<?= @$testId ?>">
						<div class="form-group row">
									<label class="col-sm-3 col-form-label">Test Name </label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="testName" value="<?= @$data->testName ?>" >
									</div>
								</div>						
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Test Number </label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="testNumber" value="<?= @$data->testNumber ?>" >
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Duration </label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="duration" value="<?= @$data->duration ?>" >
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Instructions </label>
									<div class="col-sm-9">
										<textarea name="instructions" rows="5" class="form-control summernote"><?= strip_tags(html_entity_decode($data->instructions)) ?></textarea>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Image </label>
									<div class="col-sm-9"> 
										<diiv class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 250px; height:150px;">
													<?php if (@$data->coverImg && file_exists('./uploads/test/'.@$data->coverImg)) { ?>
														<img src="<?= base_url('uploads/test/'.@$data->coverImg) ?>" alt="">
													<?php } else { ?>
														<img src="<?= base_url('uploads/noimg.png') ?>" alt="">
													<?php } ?>
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
												<div>
													<span class="btn btn-default btn-file">
														<span class="fileinput-new">Select image</span>
														<span class="fileinput-exists">Change</span>
														<input type="file" name="coverImg" accept="images/*">
														<input type="hidden" name="oldImage" value="<?= @$data->coverImg ?>">
													</span>
													<a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
												</div>
											
											 <div class="clearfix margin-top-10 m-b-20 f12" style="display: block;">
                                                <span class="label label-danger">Format</span>&nbsp; jpg, jpeg, png, gif
                                                <span class="label label-danger"> Max Upload Size</span>&nbsp;10mb
                                            </div>
									</div>
								</div>								

								<div class="form-group row offset-3"> 
									<button type="submit" class="btn btn-rounded btn-info">Update </button>
									<?php
                                        if(!empty($subjectId) && !empty($chapterId) && !empty($lessonId)){
                                    ?>
                                        <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>">
                                            Back
                                        </a>
                                    <?php
                                      }
                                      elseif(!empty($subjectId) && !empty($chapterId)){
                                    ?>
                                         <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>">
                                            Back
                                         </a>
                                    <?php
                                      }elseif(!empty($subjectId)){
                                    ?>
                                         <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/view/'.$subjectId) ?>">
                                            Back
                                         </a>
                                    <?php
                                        }
                                    ?>
								</div>

							</form>
						</div>
						</div>
					</div>
				</div>
			</div>					
		</div>
	</div>

