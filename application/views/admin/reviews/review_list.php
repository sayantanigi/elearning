<?php
    /*print"<pre>";
	print_r($courseReviewData);
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
					<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1"><?=count($courseReviewData)?> <?= $title ?></h6></span>
					
					<ul class="slectview">
						<!--<li><a href="javascript:void(0)" class="tab-link active" data-tab="tab-1"><i class="fa fa-bars" aria-hidden="true"></i> List</a></li>
						<li><a href="javascript:void(0)" class="tab-link" data-tab="tab-2"><i class="fa fa-th-large" aria-hidden="true"></i> Grid</a></li>-->
					</ul>
				</div>
				<div class="col-xl-6 col-lg-6 d-flex flex-wrap">
					
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
											<th>Rating</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($courseReviewData as $key => $v): ?>
											<tr class="odd" role="row">
												<td><?= $i ?></td>
												<input type="hidden" id="feedback_<?=$v->reviewId?>" value="<?=html_entity_decode($v->feedback)?>">

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

												<td class="courseContent">
													<div class="dashboard-course-item__rating">
						                                <div class="rating-star">
						                                    <div class="rating-label" style="width: <?=$v->rating*20?>%;"></div>
						                                </div>
						                            </div>
													<p>Created at: <?=date('jS F, Y',strtotime($v->created))?> </p>
												</td>
												
												<td class="text-center actionbtnlist">
													<a href="javascript:void(0);" class="btn btn-xs btn-primary" data-toggle="tooltip" title="View Feedback" onclick="showReason(<?=$v->reviewId?>)">
														<i class="fa fa-eye"></i>
													</a>

													<a href="javascript:void(0)" onclick="changeReviewStatus(<?= @$v->reviewId ?>, <?= $v->status ?>)" class="btn btn-xs btn-<?=($v->status==1?'success':'danger')?>" data-toggle="tooltip2" title="<?= (!empty($v->status) && $v->status == '1')? 'Click for Un Publish' : 'Click for Publish'; ?>">

														<?= (!empty($v->status) && $v->status == '1')? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?>
													</a>
													
													<a href="javascript:void(0)" onclick="deleteReview(<?= @$v->reviewId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
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
	<div class="modal fade" id="showFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Student Feedback</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
			    <div class="col-lg-12 col-md-12 col-sm-12">
			      <div class="contentmodal"></div>
			    </div>  
			</div>


	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script>
		function deleteReview(reviewId) {
			swal({
				title: 'Are You sure want to delete this Review?',
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
					window.location.href = '<?= admin_url('reviews/delete/') ?>'+reviewId
				}
			});
		}

		function showReason(reviewId){
			var feedback = $("#feedback_"+reviewId).val();
			$(".contentmodal").text(feedback);
            $("#showFeedbackModal").modal('show');
		}

		//Review status change function
		function changeReviewStatus(id, status) {      
			var newStatus;      
			
			 if (status == '1') 
		     {       
		        newStatus = '0';
		     } else {        
		        newStatus = '1';

		     }
			//console.log(newStatus+"***id->"+id);return false;

			$.ajax({      
				url: adminUrl+'reviews/changestatus',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					reviewId: String(id),        
					status: String(newStatus)        
				},
			})
			.done(function(data) {   
			    var redirectURL = adminUrl+"reviews/list"   
				alert_response(data,redirectURL); 
			})
			.fail(function(data) {      
				console.log(data);       
			}); 
		}


	</script>