	<div class="content-body">
		<div class="container-fluid">
			<div class="page-titles">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?= admin_url('dashboard')?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
				</ol>
			</div>
			<div class="d-flex flex-wrap mb-4 row">
				<div class="col-xl-6 col-lg-6 mb-2 titleListing">
					<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1"><?=count($list)?> <?= $title ?></h6></span>
					
					<ul class="slectview">
						<!--<li><a href="javascript:void(0)" class="tab-link active" data-tab="tab-1"><i class="fa fa-bars" aria-hidden="true"></i> List</a></li>
						<li><a href="javascript:void(0)" class="tab-link" data-tab="tab-2"><i class="fa fa-th-large" aria-hidden="true"></i> Grid</a></li>-->
					</ul>
				</div>
				<div class="col-xl-6 col-lg-6 d-flex flex-wrap">
					<div class="ml-auto">
						<a href="<?= admin_url('subject/add') ?>" class="btn btn-rounded btn-info">
							<span> <i class="fa fa-plus color-info"></i></span> Add Subject 
						</a>				
						
					</div>
				</div>
				
			</div>
			
			<!-- row -->
			<div class="row">
				<div class="col-12">
					<div class="">
						<div  id="tab-1" class="tab-view active">
							<div class="table-responsive">
								<table id="example" class="display table-responsive-md coursetable">
									<thead class="text-center">
										<tr>
											<th>#</th>
											<th>Image</th>	
											<th>Details </th>
											<th>Created On</th>
											<th>Created By</th>
											<th>Approved</th>
											<th width="170px">Action</th>
										</tr>
									</thead>
									<tbody class="text-center">
										<?php
											$i = 1; 
											foreach (@$list as $key => $v){
										?>
											<tr>	
												<td><?= $i++;?></td>
												<td class="courseBnr">
													<a href="<?= admin_url('subject/view/'.$v->subjectId) ?>">
													<?php if (@$v->image && file_exists('./uploads/subject/'.@$v->image)) { ?>
														<img src="<?= base_url('uploads/subject/'.@$v->image) ?>" alt="img">
													<?php } else { ?>
														<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
													<?php } ?>
												</a>
												</td>										
												<td class="courseContent">
													<h4 class="fs-16"><a href="<?= admin_url('subject/view/'.$v->subjectId) ?>"><?= @$v->subjectName ?></a></h4>
													<p>
														<?= substr(strip_tags(html_entity_decode($v->summary)), 0,30)."<a href='".admin_url('subject/view/'.$v->subjectId)."' style='color:blue;'>...Read more</a>"; ?> 
												    </p>
													<?php 
													    $chapterList = $this->mymodel->get('chapters', false, 'subjectId', $v->subjectId);
														$testList = $this->mymodel->get('tests', false, 'subjectId', $v->subjectId);

														$sqllession = "SELECT * FROM `subjects` JOIN chapters ON chapters.subjectId =subjects.subjectId  JOIN lessons ON lessons.chapterId=chapters.chapterId WHERE subjects.subjectId=$v->subjectId";

													 	$lessonlist= $this->mymodel->fetch($sqllession);
													 ?>
													<p><?=count($chapterList)?> Chapters &nbsp; <!--<?=count($lessonlist)?> Lessons--> </p>
												</td>
																							
												<td class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></td>
												<td><?=ucfirst($v->created_by)?></td>
											
												<!--<td>
													<?php if ($v->status == "0") { ?>
														<a href="javascript:void(0)" class="btn btn-xs btn-danger" >Unpublished</a>
													<?php } else{ ?>
														<a href="javascript:void(0)" class="btn btn-xs btn-success" >Published</a>
													<?php } ?> 
												</td>-->

												<td>
													<label class="checkbox-warning check-xl">
														<input type="checkbox" value="<?= @$v->approve_status ?>" <?= (@$v->approve_status == "approved")? 'checked="checked"' : ''; ?> onchange="changeSubjectApproveStatus(<?= @$v->subjectId ?>, $(this))">
														<span class="slider round"></span>
													</label>
												</td>

												<td class="text-center actionbtnlist">


													<a href="<?= admin_url('subject/view/'.$v->subjectId) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="Details">
														<i class="fa fa-eye"></i>
													</a>
													<a href="<?= admin_url('subject/edit/'.$v->subjectId) ?>" class="btn btn-xs btn-secondary" data-toggle="tooltip2" title="Edit">
														<i class="fa fa-edit"></i>
													</a>
													<a href="javascript:void(0)" onclick="changeSubjectStatus(<?= @$v->subjectId ?>, <?= $v->status ?>)" class="btn btn-xs btn-success" data-toggle="tooltip2" title="<?= (!empty($v->status) && $v->status == '1')? 'Click for Un Publish' : 'Click for Publish'; ?>">

														<?= (!empty($v->status) && $v->status == '1')? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?>
													</a>
													<a href="javascript:void(0)" onclick="cloneSubject(<?= @$v->subjectId ?>)" class="btn btn-xs btn-warning" data-toggle="tooltip2" title="Clone">
														<i class="fa fa-clone"></i>
													
													</a>
													<a href="javascript:void(0)" onclick="deleteSubject(<?= @$v->subjectId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
														<i class="fa fa-trash"></i>
													</a>
													<!--<button class="btn btn-xs btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Add Contents
													</button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														<a class="dropdown-item" href="<?= admin_url('subject/addChapter/'.@$v->subjectId) ?>"><span> <i class="fa fa-plus color-info"></i>
														</span> Add Chapter</a>
													</div>-->

													<a href="<?= admin_url('subject/addChapter/'.@$v->subjectId) ?>"><button class="btn btn-xs btn-info" type="button" id="dropdownMenuButton" data-toggle="tooltip2" data-title="Add chapters for this subject">
														<i class="fa fa-plus color-info"></i>&nbsp;Add Chapters
													</button></a>
													
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!--<div  id="tab-2" class="tab-view ">
							<div class="row">
								<?php $i = 1; ?>
								<?php foreach (@$list as $key => $v): ?>
								<div class="col-lg-4 col-md-6 col-12">
									<div class="subjectBox">
										<div class="sujectImg">
											<a href="<?= admin_url('subject/view/'.$v->subjectId) ?>">
											<?php if (@$v->image && file_exists('./uploads/subject/'.@$v->image)) { ?>
												<img src="<?= base_url('uploads/subject/'.@$v->image) ?>" alt="img">
											<?php } else { ?>
												<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
											<?php } ?>
										</a>
										</div>
										<div class="courseContent">
											<h4 class="fs-16"><a href="<?= admin_url('subject/view/'.$v->subjectId) ?>"><?= @$v->subjectName ?></a></h4>
											<p><?= substr(strip_tags(html_entity_decode($v->summary)), 0,150); ?></p>
										 <?php 
											$chapterList = $this->mymodel->get('chapters', false, 'subjectId', $v->subjectId);
											
											$testList = $this->mymodel->get('tests', false, 'subjectId', $v->subjectId);
											
											$sqllession = "SELECT * FROM `subjects` JOIN chapters ON chapters.subjectId =subjects.subjectId  JOIN lessons ON lessons.chapterId=chapters.chapterId WHERE subjects.subjectId=$v->subjectId";
											$lessonlist= $this->mymodel->fetch($sqllession);
									    ?>
											<p><?=count($chapterList)?> Chapters &nbsp; <?=count($lessonlist)?> Lessons </p>
										</div>												
										<div class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></div>
										<div class="row">
											
											<div class="col-md-12 text-right actionsub actionbtnlist">
											
												<a href="<?= admin_url('subject/view/'.$v->subjectId) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="Details">
													<i class="fa fa-eye"></i>
												</a>
												<a href="<?= admin_url('subject/edit/'.$v->subjectId) ?>" class="btn btn-xs btn-secondary" data-toggle="tooltip2" title="Edit">
													<i class="fa fa-edit"></i>
												</a>
												<a href="javascript:void(0)" onclick="changeSubjectStatus(<?= @$v->subjectId ?>, <?= $v->status ?>)" class="btn btn-xs btn-success" data-toggle="tooltip2" title="<?= (!empty($v->status) && $v->status == '1')? 'Click for Un Publish' : 'Click for Publish'; ?>">

													<?= (!empty($v->status) && $v->status == '1')? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?>
												</a>
												<a href="javascript:void(0)" onclick="cloneSubject(<?= @$v->subjectId ?>)" class="btn btn-xs btn-warning" data-toggle="tooltip2" title="Clone">
													<i class="fa fa-clone"></i>
												
												</a>
												<a href="javascript:void(0)" onclick="deleteSubject(<?= @$v->subjectId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
													<i class="fa fa-trash"></i>
												</a>

												<button class="btn btn-xs btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Add Contents
													</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													
													<a class="dropdown-item" href="<?= admin_url('subject/addChapter/'.@$v->subjectId) ?>"><span> <i class="fa fa-plus color-info"></i>
													</span> Add Chapter</a>

												</div>
											</div>
										</div>
									</div>
								</div>
								<?php $i++; ?>
								<?php endforeach ?>
							</div>
						</div>-->
					</div>
				</div>

			</div>
		</div>
	</div>

	<script>
		function deleteSubject(subjectId) {
			swal({
				title: 'Are You sure want to delete this Subject?',
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
					window.location.href = '<?= admin_url('subject/delete/') ?>'+subjectId
				}
			});
		}

		//Subject status change function
		function changeSubjectApproveStatus(id, thisSwitch) {  
			var newStatus;      
			if (thisSwitch.val() == "approved") {         
				thisSwitch.val('forbidden');       
				newStatus = 'forbidden';
			} else {      
				thisSwitch.val('approved');       
				newStatus = 'approved';
			}

			//console.log(newStatus+"***id->"+id);return false;

			$.ajax({      
				url: adminUrl+'subject/changeSubjectApproveStatus',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					subjectId: String(id),        
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

	</script>