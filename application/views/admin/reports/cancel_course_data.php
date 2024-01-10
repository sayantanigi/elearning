<?php
    /*print"<pre>";
	print_r($changeInstructorData);
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
					<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1"><?=count($cancelCourseData)?> <?= $title ?></h6></span>
					
					<ul class="slectview">
						<!--<li><a href="javascript:void(0)" class="tab-link active" data-tab="tab-1"><i class="fa fa-bars" aria-hidden="true"></i> List</a></li>
						<li><a href="javascript:void(0)" class="tab-link" data-tab="tab-2"><i class="fa fa-th-large" aria-hidden="true"></i> Grid</a></li>-->
					</ul>
				</div>
				<div class="col-xl-6 col-lg-6 d-flex flex-wrap">
					<div class="ml-auto">
						<a href="<?= admin_url('reports/cancel-course-history') ?>" class="btn btn-rounded btn-info">
							<span> <i class="fa fa-history color-info"></i></span> View Cancel Course History 
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
								<table id="example" class="display table-responsive-md coursetable dataTable no-footer">
									<thead>
										<tr>
											<th>#</th>
											<th style="width:15%;">Course Image</th>
											<th>Course Name</th>		
											<th>Instructor</th>
											<th>Email</th>
											<th>Contact No</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php 
											foreach ($cancelCourseData as $key => $v): 

												$courseId = $v->courseId;
												$courseLvl = $v->courseLvl;
										?>
											<tr class="odd" role="row">
												<td><?= $i ?></td>
												<td class="courseBnr" style="width:15%;">
													<?php if (@$v->image && file_exists('./uploads/courses/'.@$v->image)) { ?>
														<img src="<?= base_url('uploads/courses/'.@$v->image) ?>" alt="<?= $v->courseName ?>">
													<?php } else { ?>
														<img src="<?= base_url('uploads/noimg.png') ?>" alt="<?= $v->courseName ?>">
													<?php } ?>
												</td>

												<td class="courseContent">
													<h4 class="fs-16"><a href="<?=base_url('course/view/'.$v->courseId)?>"><?= $v->courseName ?></a></h4>
													<p>Level: <?=ucfirst($v->courseLvl)?></p>
													<!--<p>Created on, <?=date('jS F, Y',strtotime($v->created))?></p>-->
												</td>
												
												<td class="courseContent">
													<h5><a href="<?=base_url('instructors/view/'.$v->instructorId)?>"><?=$v->insName?></a></h5>
												</td>

												<td><h6><?=$v->insEmail?></h6></td>
												<td><h6><?=$v->insMobile?></h6></td>

												<td class="text-center actionbtnlist">
													<a href="<?=admin_url('reports/cancel-course/details/'.$v->requestId)?>" class="btn btn-xs btn-warning" data-toggle="tooltip2" title="View Details">
														<i class="fa fa-eye"> View Details</i>
													</a>
												</td>
											</tr>
											<?php $i++; ?>
										<?php endforeach ?>
								   </tbody>
								</table>
							</div>
						</div>
						
					</div>
				</div>

			</div>
		</div>
	</div>

	