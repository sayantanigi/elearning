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
						<a href="<?= admin_url('reports/cancelcoursedata') ?>" class="btn btn-rounded btn-info">
							<span> <i class="fa fa-calculator color-info"></i></span> View Cancel Course List 
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
											<th>Course Image</th>
											<th>Course</th>		
											<th>Student</th>
											<th>Cancelled by</th>
											<th style="width: 15%;">Total Session <br>Attained </th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php 
											foreach ($cancelCourseData as $key => $v): 

												$requestId = $v->stuCourseId ;

												$sql_fetch_booked_class = "SELECT TIMEDIFF(sbch.toTime , sbch.fromTime) as timeDiff FROM student_booked_classes_history sbch WHERE sbch.requestType='2' AND sbch.requestId='$requestId'";
							                    //echo $sql_fetch_booked_class;exit;
							                    $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);
	                                            
	                                            $totalBookedSeason = 0;

											    foreach ($bookedClassData as $key => $time) {
											    	$totalBookedSeason +=  round($time->timeDiff);
											    }
										?>
											<tr class="odd" role="row">
												<td><?= $i ?></td>
												<input type="hidden" id="description_<?=$v->stuCourseId?>" value="<?=html_entity_decode($v->descriptions)?>">

												<td class="courseBnr">
													<?php if (@$v->image && file_exists('./uploads/courses/'.@$v->image)) { ?>
														<img src="<?= base_url('uploads/courses/'.@$v->image) ?>" alt="<?= $v->courseName ?>">
													<?php } else { ?>
														<img src="<?= base_url('uploads/noimg.png') ?>" alt="<?= $v->courseName ?>">
													<?php } ?>
												</td>

												<td class="courseContent">
													<h4 class="fs-16"><a href="<?=base_url('course/view/'.$v->courseId)?>"><?= $v->courseName ?></a></h4>
													<p>Level: <?=ucfirst($v->courseLvl)?></p>
													<p>Created on, <?=date('jS F, Y',strtotime($v->created))?></p>
												</td>
												
												<td class="courseContent">
													<h4 class="fs-16"><a href="<?=base_url('students/view/'.$v->studentId)?>"><?=$v->studentName?></a></h4>
													<p>Email: <?=$v->stuEmail?></p>
													<p>Mobile: <?=$v->stuMobile?></p>
												</td>
											
												<td class="courseContent">
													<h4 class="fs-16">
														<?=$v->userName?> (<?=($v->userType == 1? 'Student':'Instructor')?>)
													</h4>	
													<p>Email: <?=$v->userEmail?></p>
													<p>Mobile: <?=$v->userMobile?></p>
												</td>

												<td style="width: 15%;"><?=$totalBookedSeason." Hours"?></td>

												<td class="text-center actionbtnlist">
													<a href="javascript:void(0);" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="View Resaon" onclick="showReason(<?=$v->stuCourseId?>)">
														<i class="fa fa-eye"></i>
													</a>

													<a href="javascript:void(0)" onclick="restorePurchase(<?= @$v->stuCourseId ?>)" class="btn btn-xs btn-success" data-toggle="tooltip2" title="Restore purchase to current record.">
														<i class="fa fa-recycle"></i>
													</a>

													<a href="javascript:void(0)" onclick="deletePurchaseHistory(<?= @$v->stuCourseId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete purchase record from history">
														<i class="fa fa-trash"></i>
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

	<!-- Modal -->
	<div class="modal fade" id="changeReasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Cancel Course Reason</h5>
	        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
			    <div class="col-lg-12 col-md-12 col-sm-12">
			      <div class="description"></div>
			    </div>  
			</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script>
		function restorePurchase(stuCourseId) {
			alert_func(["This feature is under development, Please try later!", "error", "#DD6B55"]);  
			return false;
			swal({
				title: 'Are You sure want to approve this cancellation request?',
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
					window.location.href = '<?= admin_url('reports/restorePurchase/') ?>'+stuCourseId
				}
			});
		}

		function deletePurchaseHistory(stuCourseId) {
			swal({
				title: 'Are You sure want to delete this cancellation record?',
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
					window.location.href = '<?= admin_url('reports/deletePurchaseHistory/') ?>'+stuCourseId
				}
			});
		}

		function showReason(stuCourseId){
			var description = $("#description_"+stuCourseId).val();

			$(".description").text(description);
            $("#changeReasonModal").modal('show');
		}

	</script>