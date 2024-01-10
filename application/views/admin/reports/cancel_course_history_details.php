<?php
  /*print"<pre>";
  print_r($cancelCourseDetails);
  print"</pre>";*/
  
  if($cancelCourseDetails->status == '0'){
  	 $record_status = 'inactive';
  }else{
  	 $record_status = 'active';
  }  
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
			<div class="d-flex flex-wrap mb-2 row">
				<div class="col-xl-6 col-lg-6 mb-2 titleListing">
					<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1"><?= $title ?></h6></span>
					
					<ul class="slectview">
						<!--<li><a href="javascript:void(0)" class="tab-link active" data-tab="tab-1"><i class="fa fa-bars" aria-hidden="true"></i> List</a></li>
						<li><a href="javascript:void(0)" class="tab-link" data-tab="tab-2"><i class="fa fa-th-large" aria-hidden="true"></i> Grid</a></li>-->
					</ul>
				</div>
				<div class="col-xl-6 col-lg-6 d-flex flex-wrap">
					<div class="ml-auto">
						<a href="<?= admin_url('reports/cancel_course_history/'.$record_status) ?>" class="btn btn-rounded btn-info">
							<span> <i class="fa fa-list color-info"></i></span> View Cancel Course History 
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
								<table class="display table-responsive-md coursetable dataTable no-footer">
									<thead>
										<tr>
											<th style="width:15%;">Course Image</th>
											<th>Course Name</th>		
											<th>Instructor</th>
											<th>Email</th>
											<th>Contact No</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr class="odd" role="row">
									       <input type="hidden" id="cancelReason" value="<?=strip_tags(html_entity_decode($cancelCourseDetails->descriptions))?>">
											<td class="courseBnr" style="width:15%;">
												<?php if (@$cancelCourseDetails->image && file_exists('./uploads/courses/'.@$cancelCourseDetails->image)) { ?>
													<img src="<?= base_url('uploads/courses/'.@$cancelCourseDetails->image) ?>" alt="<?= $cancelCourseDetails->courseName ?>">
												<?php } else { ?>
													<img src="<?= base_url('uploads/noimg.png') ?>" alt="<?= $cancelCourseDetails->courseName ?>">
												<?php } ?>
											</td>

											<td class="courseContent">
												<h4 class="fs-16"><a href="<?=base_url('course/view/'.$cancelCourseDetails->courseId)?>"><?= $cancelCourseDetails->courseName ?></a></h4>
												<p>Level: <?=ucfirst($cancelCourseDetails->courseLvl)?></p>
												<!--<p>Created on, <?=date('jS F, Y',strtotime($cancelCourseDetails->created))?></p>-->
											</td>
											
											<td class="courseContent">
												<h5><a href="<?=base_url('instructors/view/'.$cancelCourseDetails->instructorId)?>"><?=$cancelCourseDetails->insName?></a></h5>
											</td>

											<td><h6><?=$cancelCourseDetails->insEmail?></h6></td>
											<td><h6><?=$cancelCourseDetails->insMobile?></h6></td>

											<td class="text-center actionbtnlist">
												<a href="javascript:void(0);" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="View Resaon for cancellation" onclick="showReason()">
													<i class="fa fa-eye"></i>
												</a>

												<?php if($cancelCourseDetails->status == 1){ ?> 
														<a href="javascript:void(0)" onclick="restoreQuery(<?= @$v->requestId ?>)" class="btn btn-xs btn-success" data-toggle="tooltip2" title="Restore course to instructor.">
															<i class="fa fa-recycle"></i>
														</a>
												<?php } ?>

												<a href="javascript:void(0)" onclick="deleteCancelCourseHistory(<?= @$cancelCourseDetails->requestId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete cancel course request from history">
													<i class="fa fa-trash"></i>
												</a>
											</td>
										</tr>
								   </tbody>
								</table>
							</div>
						</div>
						
					</div>
				</div>

			</div>

			<div class="d-flex flex-wrap my-4 row">
				<div class="col-md-12">
				<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1">Student elligible for refund under this course</h6></span>
               
                 <table class="display table-responsive-md coursetable dataTable no-footer mt-3">
                    <thead>
                    <tr>
                      <th scope="col" class="text-center">#</th>
                      <th scope="col" class="text-center">Course Name</th>
                      <th scope="col" class="text-center">Student Name</th>
                      <th scope="col" class="text-center">Session</th>
                      <th scope="col" class="text-center">Course Cost</th>
                      <th scope="col" class="text-center">Amount Calculation</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                        
                        <?php 
                            if(count($studentRefundData)>0){
                        	  	foreach($studentRefundData as $index => $refund){ 
                        ?>  
                            <tr>
                              <td scope="row"><?=$index+1?></td>
                              <td><?=$refund['courseName']?> (<?=$refund['level']?>) </td>
                              <td><?=$refund['studentName']?></td>
                              <td>
                                Course Session: <?=$refund['courseSession']?> Hours<br>
                                Booked Session: <?=$refund['bookedSession']?> Hours
                              </td>
                              <td>$<?=$refund['courseCost']?> </td>
                               <td>
                                Deduction Amount: $<?=$refund['deductionAmount']?><br>
                                Refund Amount: $<?=$refund['refundAmount']?>
                              </td>
                            </tr>
                        <?php } }else{ ?>
                        	<tr>
													 	<td colspan="6">No student has booked any class on this course level!</td>
													</tr>
												<?php } ?>	
                    </tbody>
                   </table>
               </div> 

			</div>	
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="cancelCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Reason for Course Cancellation</h5>
	        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="description">
 	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script>
		
		function deleteCancelCourseHistory(requestId) {
			swal({
				title: 'Are You sure want to delete this record from history?',
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
					window.location.href = '<?= admin_url('reports/deleteCancelCourseHistory/') ?>'+requestId
				}
			});
		}

		function showReason(){
			var description = $("#cancelReason").val();

			$("#description").text(description);

			$("#cancelCourseModal").modal('show');
		}

	</script>