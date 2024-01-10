<?php
  $redirectto = urlencode(current_url());
?>
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
								<a href="<?= admin_url('subject/addChapter/'.@$data->subjectId) ?>" class="btn btn-rounded btn-info"><span> <i class="fa fa-plus color-info"></i>
								</span> Add Chapter </a>	
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="basic-form">							
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Subject Name </label>
									<div class="col-sm-9">
										<input type="text" readonly="" class="form-control" name="subjectName" id="subjectName" autocomplete="off" value="<?= @$data->subjectName ?>" required="">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Summary </label>
									<div class="col-sm-9">	
									<textarea readonly class="form-control"><?= strip_tags(html_entity_decode($data->summary)) ?></textarea>
									</div>
								</div>
								<div class="form-group row">
										<label class="col-sm-3 col-form-label">Objectives</label>
										<div class="col-sm-9">
											<textarea readonly class="form-control"><?= strip_tags(html_entity_decode($data->objectives)) ?></textarea>
										</div>
									</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Thumbnail </label>
									<div class="col-sm-9"> 
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail">
												<?php if (@$data->image && file_exists('./uploads/subject/'.@$data->image)) { ?>
													<img src="<?= base_url('uploads/subject/'.@$data->image) ?>" style="width: 250px; height: 150px;" alt="">
												<?php } else { ?>
													<img src="<?= base_url('dist/images/noimage.jpg') ?>" style="width: 250px; height: 150px;" alt="">
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Created Date </label>
									<div class="col-sm-3">
										<input type="text" class="form-control" readonly value="<?= date('d-M-Y', strtotime(@$data->created)) ?>">
									</div>
										<label class="col-sm-3 col-form-label">Last Modified  Date </label>
									<div class="col-sm-3">
										<input type="text" class="form-control" readonly value="<?= date('m/d/Y h:i:s', strtotime(@$data->updated)) ?>">
									</div>
								</div>

								<div class="form-group row">
								
								</div>
								<div class="form-group row">
									<h2>All Chapters</h2>
									<table class="display table table-bordered table-responsive-md coursetable">
									<thead class="text-center">
										<tr>
											<th>Image</th>
											<th>Chapter Name </th>
											<th>Chapter Duration </th>
											<th>Chapter Cost </th>
											<!--<th>Number of Lessons </th>-->
											<th>Created On</th>	
											<th>Approved</th>
											<th width="300px">Action</th>
										</tr>
									</thead>
									<tbody class="text-center">
										<?php $i = 1; ?>
										<?php foreach (@$chpaterlist as $key => $v): ?>
											<?php 
											$totalLesson = $this->mymodel->count('lessons', "chapterId='".@$v->chapterId."'");
											$totalTest = $this->mymodel->count('tests', "chapterId='".@$v->chapterId."'");
											$totalQuiz = $this->mymodel->count('quiz', "chapterId='".@$v->chapterId."'");
											?>
											<tr>
												<td class="courseBnr">
													<?php if (@$v->chapterImage && file_exists('./uploads/chapter/'.@$v->chapterImage)) { ?>
														<img src="<?= base_url('uploads/chapter/'.@$v->chapterImage) ?>" alt="img">
													<?php } else { ?>
														<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
													<?php } ?>
												</td>								
												<td><?= $v->chapterName ?></td>
												<td><?= $v->totalHours.' Hours' ?></td>		
												<td><?= '$ '.$v->cost ?></td>		
												<!--<td><?= $totalLesson ?></td>-->										    	
																					
												<td class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></td>

												<td>
													<label class="checkbox-warning check-xl">
														<input type="checkbox" value="<?= @$v->approve_status ?>" <?= (@$v->approve_status == "approved")? 'checked="checked"' : ''; ?> onchange="changeChapterApproveStatus(<?= @$v->chapterId ?>, $(this))">
														<span class="slider round"></span>
													</label>
												</td>

												<td class="text-center actionbtnlist">
													
													<a href="<?= admin_url('subject/viewChapter/'.@$data->subjectId.'/'.@$v->chapterId) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="Details">
														<i class="fa fa-eye"></i>
													</a>

													<a href="<?= admin_url('subject/editChapter/'.@$data->subjectId.'/'.@$v->chapterId) ?>" class="btn btn-xs btn-secondary"  data-toggle="tooltip2" title="Edit">
														<i class="ti-pencil"></i>
													</a>
													<a href="javascript:void(0)" onclick="changeChapterStatus(<?= @$v->chapterId ?>, <?= $v->status ?>)" class="btn btn-xs btn-success" data-toggle="tooltip2" title="<?= (!empty($v->status) && $v->status == '1')? 'Click for Un Publish' : 'Click for Publish'; ?>">

														<?= (!empty($v->status) && $v->status == '1')? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?>
													</a>

													<a href="<?= admin_url('subject/curriculum/'.$data->subjectId.'/'.$v->chapterId) ?>" class="btn btn-xs btn-info" data-toggle="tooltip2" title="Edit chapter curriculum data">
														<i class="fa fa-picture-o"></i>
													</a>
													
													<a href="javascript:void(0)" onclick="cloneChapter(<?= @$v->chapterId ?>)" class="btn btn-xs btn-warning" data-toggle="tooltip2" title="Clone">
														<i class="fa fa-clone"></i>
													
													</a>
													<button class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete" onclick="deleteChapter(<?= @$v->chapterId ?>)">
														<i class="ti-trash"></i>
													</button>
												<!--	<button class="btn btn-xs btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Add Contents
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														
															<a class="dropdown-item" href="<?= admin_url('subject/addLesson/'.@$data->subjectId.'/'.$v->chapterId) ?>"><span> <i class="fa fa-plus color-info"></i>
															</span> Add Lesson </a>

														</div>-->
												</td>
											</tr>
											<?php $i++; ?>
										<?php endforeach ?>
									</tbody>
								</table>
								</div>
							
								<div class="form-group offset-3">  
									<a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/lists') ?>">
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
		function deleteChapter(chapterId) {
			swal({
				title: 'Are You sure want to delete this Chapter?',
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
					window.location.href = '<?= admin_url('subject/deleteChapter/') ?>'+chapterId
				}
			});
		}

		//Chapter status change function
		function changeChapterApproveStatus(id, thisSwitch) {  
			var newStatus;      
			if (thisSwitch.val() == "approved") {         
				thisSwitch.val('forbidden');       
				newStatus = 'forbidden';
			} else {      
				thisSwitch.val('approved');       
				newStatus = 'approved';
			}

			$.ajax({      
				url: adminUrl+'subject/changeChapterApproveStatus',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					chapterId: String(id),        
					status: String(newStatus)        
				},
			})
			.done(function(data) {      
				alert_func(data);       
			})
			.fail(function(data) {      
				console.log(data);       
			}); 
		}

		function deleteTest(testId,redirectto) {
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
					window.location.href = '<?= admin_url('subject/deleteTest/')?>'+testId+'?redirectto='+redirectto;
				}
			});
		}
	</script>


	