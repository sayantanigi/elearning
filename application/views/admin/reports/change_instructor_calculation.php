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
					<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1"><?=count($changeInstructorData)?> <?= $title ?></h6></span>
					
					<ul class="slectview">
						<!--<li><a href="javascript:void(0)" class="tab-link active" data-tab="tab-1"><i class="fa fa-bars" aria-hidden="true"></i> List</a></li>
						<li><a href="javascript:void(0)" class="tab-link" data-tab="tab-2"><i class="fa fa-th-large" aria-hidden="true"></i> Grid</a></li>-->
					</ul>
				</div>
				<div class="col-xl-6 col-lg-6 d-flex flex-wrap">
					<div class="ml-auto">
						<a href="<?= admin_url('reports/changeinstructordata') ?>" class="btn btn-rounded btn-info">
							<span> <i class="fa fa-list"></i></span> View Change Instructor List 
						</a>
						<?php if($status == 1){ ?> 
							<a href="<?= admin_url('reports/view-unapproved-change-instructor-data/inactive') ?>" class="btn btn-rounded btn-danger">
								<span> <i class="fa fa-list"></i></span> View Unapproved Data 
							</a>	
						<?php }else{ ?>		
						   <a href="<?= admin_url('reports/view-approved-change-instructor-data/active') ?>" class="btn btn-rounded btn-success">
								<span> <i class="fa fa-list"></i></span> View Approved Data 
							</a>
						<?php } ?>			
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
											<th>Instructor</th>
											<th>Total Session <br>Attained </th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php 
											foreach ($changeInstructorData as $key => $v): 

												$requestId = $v->queryId;

												$courseId = $v->courseId;
												$courseLvl = $v->courseLvl;
												$studentId = $v->studentId;
												$instructorId = $v->instructorId;

												$sql_fetch_booked_class = "SELECT TIMEDIFF(sbch.toTime , sbch.fromTime) as timeDiff FROM student_booked_classes_history sbch WHERE sbch.requestType='1' AND sbch.requestId='$requestId' AND sbch.classDate < CURDATE()";
							                    //echo $sql_fetch_booked_class;exit;
							                    $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);
	                                            
	                                            $totalBookedSeason = 0;

											    foreach ($bookedClassData as $key => $time) {
											    	$totalBookedSeason +=  round($time->timeDiff);
											    }

											     //Fetching course total cost
											    $sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

												//echo $sql_course_details;exit;

												//Feching Course Details 
										 		$courseDetails = $this->mymodel->fetch($sql_course_details, true);

										 		$deductAmount = sprintf("%.2f",($courseDetails->courseCost * $totalBookedSeason)/$courseDetails->totalHours);
										 		$refundAmount = sprintf("%.2f",($courseDetails->courseCost - $deductAmount));
										?>
											<tr class="odd" role="row">
												<td><?= $i ?></td>
												<input type="hidden" id="chngReason_<?=$v->queryId?>" value="<?=$v->reason?>">
												<input type="hidden" id="description_<?=$v->queryId?>" value="<?=html_entity_decode($v->descriptions)?>">
												<input type="hidden" id="crsSession_<?=$v->queryId?>" value="<?=$courseDetails->totalHours?>">
												<input type="hidden" id="crsCost_<?=$v->queryId?>" value="<?=$courseDetails->courseCost?>">
												<input type="hidden" id="bookedSession_<?=$v->queryId?>" value="<?=$totalBookedSeason?>">
												<input type="hidden" id="deductAmount_<?=$v->queryId?>" value="<?=$deductAmount?>">
												<input type="hidden" id="refundAmount_<?=$v->queryId?>" value="<?=$refundAmount?>">

												<td class="courseBnr" style="width:13%;">
													<?php if (@$v->image && file_exists('./uploads/courses/'.@$v->image)) { ?>
														<img src="<?= base_url('uploads/courses/'.@$v->image) ?>" alt="<?= $v->courseName ?>">
													<?php } else { ?>
														<img src="<?= base_url('uploads/noimg.png') ?>" alt="<?= $v->courseName ?>">
													<?php } ?>
												</td>

												<td class="courseContent">
													<h4 class="fs-16"><a href="<?=base_url('course/view/'.$v->courseId)?>"><?= $v->courseName ?></a></h4>
													<p>Level: <?=ucfirst($v->courseLvl)?></p>
													<p>Created on: <?=date('jS F, Y',strtotime($v->created))?></p>
												</td>
												
												<td class="courseContent">
													<h4 class="fs-16"><a href="<?=base_url('students/view/'.$v->studentId)?>"><?=$v->studentName?></a></h4>
													<p>Email: <?=$v->email?></p>
													<p>Mobile: <?=$v->mobile?></p>
												</td>

												<td class="courseContent">
													<h4 class="fs-16"><a href="<?=base_url('instructors/view/'.$v->instructorId)?>"><?=$v->insName?></a></h4>
													<p>Email: <?=$v->insEmail?></p>
													<p>Mobile: <?=$v->insMobile?></p>
												</td>

												<td>
													<p>Course Session: <?=$courseDetails->totalHours." Hours"?><br/>
													Used Session: <?=$totalBookedSeason." Hours"?><br/>
													Refund Amount: <?="$".sprintf("%.2f", $refundAmount)?></p>
												</td>
												
												<td class="text-center actionbtnlist">
													<a href="javascript:void(0);" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="View Resaon" onclick="showReason(<?=$v->queryId?>)">
														<i class="fa fa-eye"></i>
													</a>
                                                    
                                                    <?php //if($status == 1){ ?> 
														<!--<a href="javascript:void(0)" onclick="restoreQuery(<?= @$v->queryId ?>)" class="btn btn-xs btn-success" data-toggle="tooltip2" title="Restore instructor to current course.">
															<i class="fa fa-recycle"></i>
														</a>-->
													<?php //} ?>	

													<a href="javascript:void(0)" onclick="deleteQueryHistory(<?= @$v->queryId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete record from history">
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
	<div class="modal fade" id="changeInstructorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Change Reason</h5>
	        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
			    <div class="col-lg-12 col-md-12 col-sm-12">
			      <label><strong>Reason:</strong></label>	
			      <div id="reason"></div><hr>
			    </div>  
			    
			    <div class="col-lg-12 col-md-12 col-sm-12">  
			      <label><strong>Details:</strong></label>
			      <div id="description"></div><hr>
			    </div>  

			    <div class="col-lg-12 col-md-12 col-sm-12">  
			      <label><strong>Refund Calculation:</strong></label>
			    </div>  

			    <div class="col-lg-12">
			    	<table class="table table-bordered">
			          <tr>
			            <th width="30%">Course Session</th>
			            <td width="2%">:</td>
			            <td id="course_session">125</td>
			          </tr>  
			          <tr>
			            <th width="30%">Course Cost</th>
			            <td width="2%">:</td>
			            <td id="course_cost">125</td>
			          </tr>
			          <tr>
			            <th width="30%">Exhausted Session</th>
			            <td width="2%">:</td>
			            <td id="used_session">125</td>
			          </tr>
			          <tr>
			            <th width="30%">Deduction Amount</th>
			            <td width="2%">:</td>
			            <td id="deduction_amount">125</td>
			          </tr>  
			          <tr>
			            <th width="30%">Refund Amount</th>
			            <td width="2%">:</td>
			            <td id="refund_amount">125</td>
			          </tr>  
			        </table>
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
		function restoreQuery(queryId) {
			alert_func(["This feature is under development, Please try later!", "error", "#DD6B55"]);  
			return false;
			swal({
				title: 'Are You sure want to restore this query?',
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
					window.location.href = '<?= admin_url('reports/restoreQuery/') ?>'+queryId
				}
			});
		}

		function deleteQueryHistory(queryId) {
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
					window.location.href = '<?= admin_url('reports/deleteQueryHistory/') ?>'+queryId
				}
			});
		}

		function showReason(queryId){
			var changeReason = $("#chngReason_"+queryId).val();
			var description = $("#description_"+queryId).val();

			var course_session = $("#crsSession_"+queryId).val();
			var course_cost = $("#crsCost_"+queryId).val();
			var used_session = $("#bookedSession_"+queryId).val();
			var deduction_amount = parseFloat($("#deductAmount_"+queryId).val()).toFixed(2);
			var refund_amount = parseFloat($("#refundAmount_"+queryId).val()).toFixed(2);

			$("#reason").text(changeReason);
			$("#description").text(description);

			$("#course_session").text(course_session+" Hours");
			$("#course_cost").text("$"+course_cost);
			$("#used_session").text(used_session+" Hours");
			$("#deduction_amount").text("$"+deduction_amount);
			$("#refund_amount").text("$"+refund_amount);

            $("#changeInstructorModal").modal('show');
		}

	</script>