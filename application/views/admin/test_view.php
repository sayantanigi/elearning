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
			<?php
			   if(!empty($subjectInfo)){
			?>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
            <?php
            	}if(!empty($chapterInfo)){
            ?>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
            <?php
            	}if(!empty($lessonInfo)){
            ?>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>"><?=ucwords($lessonInfo->lessonName)?></a></li>
            <?php
            	}if(!empty($testInfo)){
            ?>
            	<?php
            	if(!empty($subjectId) && !empty($chapterId) && !empty($lessonId) && !empty($testId)){
            	?>
                 <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewTest/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$testId) ?>"><?=ucwords($testInfo->testName)?></a></li>
	            <?php
	         	   }elseif(!empty($subjectId) && !empty($chapterId) && !empty($testId)){
	         	?>
	         	 <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewTest/'.$subjectId.'/'.$chapterId.'/'.$testId) ?>"><?=ucwords($testInfo->testName)?></a></li>
	         	<?php
	         	   }elseif(!empty($subjectId) && !empty($testId)){
	         	?>
	         	<li class="breadcrumb-item"><a href="<?= admin_url('subject/viewTest/'.$subjectId.'/'.$testId) ?>"><?=ucwords($testInfo->testName)?></a></li>
	         	<?php
	         	   }
	            ?>
            <?php
            	}
            ?>
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
								<a href="<?= admin_url('subject/addQuestion/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$testId) ?>" class="btn btn-rounded btn-info"><span> <i class="fa fa-plus color-info"></i>
								</span> Add Question </a>	
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="basic-form">	
						<div class="form-group row">
									<label class="col-sm-3 col-form-label">Test Name </label>
									<div class="col-sm-9">
										<input type="text" readonly="" class="form-control" name="testName" value="<?= @$data->testName ?>" >
									</div>
								</div>						
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Test Number </label>
									<div class="col-sm-9">
										<input type="text" readonly="" class="form-control" name="testNumber" value="<?= @$data->testNumber ?>" >
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Duration </label>
									<div class="col-sm-9">
										<input type="text" readonly="" class="form-control" name="duration" value="<?= @$data->duration ?>" >
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Instructions </label>
									<div class="col-sm-9">
										<textarea name="instructions" rows="5" class="form-control" readonly><?= strip_tags(html_entity_decode($data->instructions)) ?></textarea>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Image </label>
									<div class="col-sm-9"> 
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail">
												<?php if (@$data->coverImg && file_exists('./uploads/test/'.@$data->coverImg)) { ?>
													<img src="<?= base_url('uploads/test/'.@$data->coverImg) ?>" style="width: 250px; height: 150px;" alt="">
												<?php } else { ?>
													<img src="<?= base_url('dist/images/noimage.jpg') ?>" style="width: 250px; height: 150px;" alt="">
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<h2>List of All Question</h2>
									<table class="display table table-bordered table-responsive-md coursetable">
									<thead>
										<tr>
											<th># </th>	
											<th>Question </th>	
											<th width="220px">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach (@$questionList as $key => $v): ?>
											<tr>
											  <td><?= $i ?></td>
											    <td><?= substr(html_entity_decode($v->question), 0,200) ?></td>
											 
												<td class="text-center actionbtnlist">
													
													<a href="<?= admin_url('subject/viewQuestion/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$testId.'/'.$v->quesId) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="Details">
														<i class="fa fa-eye"></i>
													</a>

													<a href="javascript:void(0)" class="btn btn-xs btn-secondary"  data-toggle="tooltip2" title="Edit">
														<i class="ti-pencil"></i>
													</a>
													<a href="javascript:void(0)" onclick="changeTestStatus(<?= @$v->quesId ?>, <?= $v->status ?>)" class="btn btn-xs btn-success" data-toggle="tooltip2" title="<?= (!empty($v->status) && $v->status == '1')? 'Click for Un Publish' : 'Click for Publish'; ?>">

														<?= (!empty($v->status) && $v->status == '1')? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?>
													</a>
													
													<a href="javascript:void(0)" onclick="cloneQuestion(<?= @$v->quesId ?>)" class="btn btn-xs btn-warning" data-toggle="tooltip2" title="Clone">
														<i class="fa fa-clone"></i>
													
													</a>
													<button class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete" onclick="deleteQuestion(<?= @$v->quesId ?>)">
														<i class="ti-trash"></i>
													</button>												
													
												</td>		

												
											</tr>
											<?php $i++; ?>
										<?php endforeach ?>
									</tbody>
								</table>
								</div>
								
								<div class="form-group row offset-3">  
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
						</div>
					</div>
				</div>
			</div>					
		</div>
	</div>
</div>

