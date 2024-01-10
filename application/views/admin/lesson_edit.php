<?php
$subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);
$chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
$lessonInfo = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);
?>
	<div class="content-body">
		<div class="container-fluid">
			<div class="page-titles">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
					<li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
					<li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
					  <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonInfo->lessonId) ?>"><?=ucwords($lessonInfo->lessonName)?></a></li>
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
								<form action="<?= admin_url('subject/updateLesson') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
									<input type="hidden" name="subjectId" value="<?= @$subjectId ?>">
									<input type="hidden" name="chapterId" value="<?= @$chapterId ?>">
									<input type="hidden" name="lessonId" value="<?= @$data->lessonId ?>">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Lesson Name </label>
									<div class="col-sm-9">
										<input type="text" readonly="" class="form-control" name="lessonName" id="lessonName" autocomplete="off" value="<?= @$data->lessonName ?>" required="">
									</div>
								</div>
									<div class="form-group row">
									<label class="col-sm-3 col-form-label">Lesson Name </label>
									<div class="col-sm-9">
										<input type="text" readonly="" class="form-control" name="lessonNumber" id="lessonNumber" autocomplete="off" value="<?= @$data->lessonNumber ?>" required="">
									</div>
								</div>
								
									<div class="form-group row">
									<label class="col-sm-3 col-form-label">Duration(in mins) </label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="duration" value="<?= @$data->duration ?>" required="">
									</div>
								</div>

								<div class="form-group row">
										<label class="col-sm-3 col-form-label">Descriptions</label>
										<div class="col-sm-9">
											<textarea name="objectives"  class="summernote" required=""><?= @$data->objectives ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Syllabus</label>
										<div class="col-sm-9">
											<textarea name="syllabus"  class="summernote" required=""><?= @$data->syllabus ?></textarea>
										</div>
									</div>
									<div class="form-group row">										
										<label class="col-sm-3 col-form-label">Image <span class="error">*</span></label>
										<div class="col-sm-9">
											<div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 250px; height:150px;">
                                                    <?php if (@$data->lessonImage && file_exists('./uploads/lesson/'.@$data->lessonImage)) { ?>
                                                        <img src="<?= base_url('uploads/lesson/'.@$data->lessonImage) ?>" alt="">
                                                    <?php } else { ?>
                                                        <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                    <?php } ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="lessonImage" accept="images/*">
                                                        <input type="hidden" name="oldImage" value="<?= @$data->lessonImage ?>">
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

										<div class="form-group row offset-3"> 
											<button type="submit" class="btn btn-rounded btn-info">Update </button>
											<a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>">
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