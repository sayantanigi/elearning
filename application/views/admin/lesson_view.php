<?php
$subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);
$chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
$lessonInfo = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);

$redirectto = urlencode(current_url());
?>
<div class="content-body">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
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
							<div class="card-header text-right">
								<!-- <a href="<?= admin_url('subject/addTest/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>" class="btn btn-rounded btn-info"><span> <i class="fa fa-plus color-info"></i>
								</span> Add Test </a>	
								<a href="<?= admin_url('subject/addQuiz/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>" class="btn btn-rounded btn-warning"><span> <i class="fa fa-plus color-info"></i>
								</span> Add Quiz </a>	 -->
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="basic-form">							
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Lesson Name </label>
									<div class="col-sm-9">
										<input type="text" readonly="" class="form-control" name="lessonName" id="lessonName" autocomplete="off" value="<?= @$data->lessonName ?>" >
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Lesson Number </label>
									<div class="col-sm-9">
										<input type="text" readonly="" class="form-control" name="lessonNumber" value="<?= @$data->lessonNumber ?>" >
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Descriptions </label>
									<div class="col-sm-9">
										<textarea name="objectives" rows="5" class="form-control" readonly><?= strip_tags(html_entity_decode($data->objectives)) ?></textarea>
									</div>
								</div>
								<div class="form-group row">
										<label class="col-sm-3 col-form-label">Syllabus</label>
										<div class="col-sm-9">
											<textarea name="syllabus"  class="summernote" readonly><?= @$data->syllabus ?></textarea>
										</div>
									</div>
								
									<div class="form-group row">
									<label class="col-sm-3 col-form-label">Duration(in mins) </label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="type" id="duration" value="<?= @$data->duration ?>" readonly>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Image </label>
									<div class="col-sm-9"> 
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail">
												<?php if (@$data->lessonImage && file_exists('./uploads/lesson/'.@$data->lessonImage)) { ?>
													<img src="<?= base_url('uploads/lesson/'.@$data->lessonImage) ?>" style="width: 250px; height: 150px;" alt="">
												<?php } else { ?>
													<img src="<?= base_url('dist/images/noimage.jpg') ?>" style="width: 250px; height: 150px;" alt="">
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							
								
								<div class="form-group row offset-3">  
									<a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>">
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

<script>
		function deleteTest(testId, redirectto) {
			swal({
				title: 'Are You sure want to delete this Test?',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#A5DC86',
				cancelButtonColor: '#DD6B55',
				confirmButtonText: 'Yes',
				cancelButtonText: 'No',
				closeOnConfirm: true,
				closeOnCancel: true
			}, function(isConfirm){
				if (isConfirm) {
					window.location.href = '<?= admin_url('subject/deleteTest/') ?>'+testId+'?redirectto='+redirectto;
				}
			});
		}

		function deleteQuiz(quizId, redirectto) {
			swal({
				title: 'Are You sure want to delete this Quiz?',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#A5DC86',
				cancelButtonColor: '#DD6B55',
				confirmButtonText: 'Yes',
				cancelButtonText: 'No',
				closeOnConfirm: true,
				closeOnCancel: true
			}, function(isConfirm)
			{
				if (isConfirm) {
					window.location.href = '<?= admin_url('subject/deleteQuiz/') ?>'+quizId+'?redirectto='+redirectto;
				}
			});
		}

	</script>
