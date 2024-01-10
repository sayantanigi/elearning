<?php
$subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);
$chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
$lessonInfo = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);
$quizInfo = $this->mymodel->get('quiz', true, 'quizId', $quizId);
?>
<div class="content-body">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>"><?=ucwords($lessonInfo->lessonName)?></a></li>
                 <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewQuiz/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$quizId) ?>"><?=ucwords($quizInfo->quizName)?></a></li>
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
								<form action="<?= admin_url('subject/updateQuiz') ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
									<input type="hidden" name="subjectId" id="subjectId" value="<?= @$subjectId ?>">
                                <input type="hidden" name="chapterId" id="chapterId" value="<?= @$chapterId ?>">
                                <input type="hidden" name="lessonId" id="lessonId" value="<?= @$lessonId ?>">
                                 <input type="hidden" name="quizId" id="quizId" value="<?= @$quizId ?>">
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
									<label class="col-sm-3 col-form-label">Instructions </label>
									<div class="col-sm-9">
										<textarea name="instructions" rows="5" class="form-control summernote"><?= strip_tags(html_entity_decode($data->instructions)) ?></textarea>
									</div>
								</div>						

								<div class="form-group row offset-3"> 
									<button type="submit" class="btn btn-rounded btn-info">Update </button>
									<a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>">
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

