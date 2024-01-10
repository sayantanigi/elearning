<?php
    /*print"<pre>";
	print_r($purchasedCourses);
	print"</pre>";exit;*/
?>
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
					<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1"><?=count($purchasedCourses)?> <?= $title ?></h6></span>
					
					<ul class="slectview">
						<!--<li><a href="javascript:void(0)" class="tab-link active" data-tab="tab-1"><i class="fa fa-bars" aria-hidden="true"></i> List</a></li>
						<li><a href="javascript:void(0)" class="tab-link" data-tab="tab-2"><i class="fa fa-th-large" aria-hidden="true"></i> Grid</a></li>-->
					</ul>
				</div>
				<div class="col-xl-6 col-lg-6 d-flex flex-wrap">
					<div class="ml-auto">
									
						
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
									<thead>
										<tr>
											<th>#</th>
											<th>Image</th>
											<th>Course</th>
											<th>Course Creator</th>	
											<th>Student</th>
											<th>Purchased Date</th>	
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										   if(!empty($purchasedCourses)){
						                      foreach ($purchasedCourses as $index => $v) { 

						                      	$courseId = @$v->courseId;
						                      	$courseLvl = @$v->courseLvl;
						                       
						                        if ($v->level_image && file_exists('./uploads/level/'.$v->level_image)) {
						                           $course_thumbnail = base_url('uploads/level/'.$v->level_image);
						                        }else{
						                           $course_thumbnail = base_url('uploads/courses/'.$v->course_image);
						                        }
										?>
											<tr>
												<td><?=$index+1?></td>
												<td class="courseBnr">
													<img src="<?=$course_thumbnail?>" alt="<?= $v->courseName ?>">
												</td>

												<td class="courseContent">
													<h4 class="fs-16"><a href="<?=admin_url('course/view/'.$v->courseId)?>"><?=$v->courseName?></a></h4>
													<p>Level: <?=ucfirst($v->courseLvl)?></p>
													<p>Cost: $<?=$v->lvlCost?></p>
												</td>

												<td class="courseContent">

													<?php if(@$v->created_by == "instructor"){ ?>
														<h4 class="fs-16"><a href="<?=admin_url('instructors/view/'.$v->instructorId)?>"><?=$v->instructorName?></a></h4>
													<?php }else{ ?>
													   	<h4 class="fs-16">Admin</h4>
													<?php } ?>
												</td>

												<td class="courseContent">
													<h4 class="fs-16"><a href="<?=admin_url('students/view/'.$v->userId)?>"><?=$v->studentName?></a></h4>
													<p>Email: <?=$v->email?></p>
													<p>Mobile: <?=$v->mobile?></p>
												</td>

												<td><?=date('jS F, Y',strtotime($v->created))?></td>
												
												<td class="text-center actionbtnlist">
													<!--<a href="<?= admin_url('blog/view/'.@$v->purchaseId) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" title="View">
														<i class="fa fa-eye"></i>
													</a>-->
													
													</a>
													<a href="javascript:void(0)" onclick="deleteBlog(<?= @$v->purchaseId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
														<i class="fa fa-trash"></i>
													</a>
												</td>
											</tr>
										<?php } } ?>
							</tbody>
								</table>
							</div>
						</div>
						
					</div>
				</div>

			</div>
		</div>
	</div>

	<script>
		function deleteBlog(articleId) {
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
					window.location.href = '<?= admin_url('blog/delete/') ?>'+articleId
				}
			});
		}

	</script>