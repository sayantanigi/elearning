	<div class="content-body">
		<div class="container-fluid">
			<div class="page-titles">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?= admin_url('dashboard')?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?= admin_url('course/lists') ?>"><?=ucwords(@$page)?></a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
				</ol>
			</div>
			<div class="d-flex flex-wrap mb-4 row">
				<div class="col-xl-6 col-lg-6 mb-2 titleListing">
					<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1"><?=count($list)?> <?= $title ?></h6></span>				
				</div>
				<div class="col-xl-6 col-lg-6 d-flex flex-wrap">
					<div class="ml-auto">
						<a href="<?= admin_url('course/add') ?>" class="btn btn-rounded btn-info"><span> <i class="fa fa-plus color-info"></i>
						</span> Add New Course </a>				
						
					</div>
				</div>
				
			</div>
			
			<div class="row">
				<div class="col-12">
					<div class="">
						
						<div  id="tab-1" class="tab-view active">
							<div class="table-responsive">
								<table id="example" class="display table-responsive-md coursetable">
									<thead>
										<tr>
											<th>#</th>
											<th>Course Title</th>	
											<!--<th>Subject</th>-->
											<th>Course Levels</th>
											<th>Created On</th>
											<th>Status</th>
											<th>Approved</th>
											<th class="text-center" width="170px">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$i = 1; 
											foreach (@$list as $key => $v){
												//FETCHING COURSE COST AND COURSE HOURS
												/*$sql_chp= "SELECT SUM(chp.cost) AS totalcost, SUM(chp.totalHours) as totalhours FROM `course_chapters` cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$v->courseId."'";
												//echo $sql_chp;exit;
												$cDetail=  $this->mymodel->fetch($sql_chp, true); 

												//FETCHING COURSE'S SUBJECT
												$sql_sub= "SELECT sub.subjectId, sub.subjectName FROM `course_chapters` cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId LEFT JOIN subjects sub ON chp.subjectId=sub.subjectId WHERE cc.courseId='".$v->courseId."' GROUP BY sub.subjectId ORDER BY sub.subjectId";
												//echo $sql_sub;exit;
												$subjectInfo=  $this->mymodel->fetch($sql_sub, false); 

												//Configuring subject string
												$subjectStr = '';
												foreach($subjectInfo as $index => $sub){
												   if($index != count($subjectInfo)-1){
												   	  $delimiter = ', ';
												   }else{
												   	  $delimiter = '';
												   }	
                                                   $subjectStr .= '<a href="'.admin_url('subject/view/'.$sub->subjectId).'">'.$sub->subjectName.'</a>'.$delimiter;
												}*/

												//FETCHING COURSE'S LEVEL
												$sql_cld= "SELECT GROUP_CONCAT(cld.level) as course_level FROM `course_level_details` cld WHERE cld.courseId='".$v->courseId."' AND cld.status = '1'";
												//echo $sql_cld;exit;
												$courseLvlDetail=  $this->mymodel->fetch($sql_cld, true); 
												//$courseLvlStr = join(',', array_map('ucfirst', explode(',', $courseLvlDetail->course_level)));
												$courseLvlArr = explode(',', $courseLvlDetail->course_level);
										?>
											<tr>	
												<td><?= $i++;?></td>
												<td class="courseBnr">
												<?= @$v->courseName ?>
												<!--<p>Price($): <?=$cDetail->totalcost?> </p>-->
												</td>										
												<!--<td class="courseContent">
													<h4 class="fs-16"><?= @$subjectStr ?></h4>
													<p>Duration(Hours): <?=$cDetail->totalhours?> </p>
													
												</td>-->
												<td>
													<?php foreach ($courseLvlArr as $key => $level) { ?>
														<?=ucfirst($level)?> 
														<span class="cursor-pointer course_info" data-toggle="tooltip" data-placement="top" data-original-title="Click to view other detail of this course" data-lvl="<?=$level?>" data-cid="<?=@$v->courseId?>">
															<i class="fa fa-question-circle"></i>
														</span>
														<br>
													<?php } ?>
												</td>
																							
												<td class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></td>
											
												<td>
													<?php if ($v->status == "0") { ?>
														<a href="javascript:void(0)" class="btn btn-xs btn-danger" >Unpublished</a>
													<?php } else{ ?>
														
														<a href="javascript:void(0)" class="btn btn-xs btn-success" >Published</a>
													<?php } ?> 
												</td>

												<td>
													<label class="checkbox-warning check-xl">
														<input type="checkbox" value="<?= @$v->approve_status ?>" <?= (@$v->approve_status == "approved")? 'checked="checked"' : ''; ?> onchange="changeCourseApproveStatus(<?= @$v->courseId ?>, $(this))">
														<span class="slider round"></span>
													</label>
												</td>
											
												<td class="text-center actionbtnlist">
													<a href="<?= admin_url('course/view/'.$v->courseId) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="Details">
														<i class="fa fa-eye"></i>
													</a>
													<a href="<?= admin_url('course/edit/'.$v->courseId) ?>" class="btn btn-xs btn-secondary" data-toggle="tooltip2" title="Edit">
														<i class="fa fa-edit"></i>
													</a>
													<a href="javascript:void(0)" onclick="changeCourseStatus(<?= @$v->courseId ?>, <?= $v->status ?>)" class="btn btn-xs btn-<?=($v->status==1?'success':'danger')?>" data-toggle="tooltip2" title="<?= (!empty($v->status) && $v->status == '1')? 'Click for Un Publish' : 'Click for Publish'; ?>">

														<?= (!empty($v->status) && $v->status == '1')? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?>
													</a>
													<a href="javascript:void(0)" onclick="cloneCourse(<?= @$v->courseId ?>)" class="btn btn-xs btn-warning" data-toggle="tooltip2" title="Clone">
														<i class="fa fa-clone"></i>
													
													</a>
													<a href="javascript:void(0)" onclick="deleteCourse(<?= @$v->courseId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
														<i class="fa fa-trash"></i>
													</a>
												</td>
											</tr>
										<?php } ?>
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
	<div class="modal fade" id="courseInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Course Detail</h5>
	        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
			    <div class="col-lg-12 col-md-12 col-sm-12">
			      <h5><i class="fa fa-clone"></i> Course Information</h5>    
			      <div class="table-responsive pt-0">
			        <table class="table table-bordered">
			          <tr>
			            <th width="30%">Course Total Cost</th>
			            <td width="2%">:</td>
			            <td id="lvl_cost">125</td>
			          </tr>  
			          <tr>
			            <th width="30%">Course Total Duration</th>
			            <td width="2%">:</td>
			            <td id="lvl_dur">125</td>
			          </tr>
			          <tr>
			            <th width="30%">Course Instructor</th>
			            <td width="2%">:</td>
			            <td id="lvl_ins">125</td>
			          </tr>  
			        </table>
			      </div>
			    </div>  
			</div>

			<div class="row">
			    <div class="col-lg-12 col-md-12 col-sm-12">
			      <h5><i class="fa fa-clone"></i> Course Subject & Chapter Detail</h5>    
			      <div class="table-responsive pt-0">
			         <table class="table table-bordered">
			           <thead>
						<tr>
							<th><h5>Level Subject</h5></th>	
							<th><h5>:</h5></th>
							<th><h5>Course Under This Subject</h5></th>
						</tr>
					  </thead>	

					  <tbody id="course_sub_crs_detail">
			          </tbody>

			        </table>
			      </div>
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
		function deleteCourse(courseId) {
			swal({
				title: 'Are You sure want to delete this Course?',
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
					window.location.href = '<?= admin_url('course/delete/') ?>'+courseId
				}
			});
		}

		//Course status change function
		function changeCourseStatus(id, thisSwitch) {      
			var newStatus;      
			
			 if (thisSwitch == '1') 
		     {       
		        newStatus = '0';
		     } else {        
		        newStatus = '1';

		     }
			//console.log(newStatus+"***id->"+id);return false;

			$.ajax({      
				url: adminUrl+'course/changestatus',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					courseId: String(id),        
					status: String(newStatus)        
				},
			})
			.done(function(data) {   
			    var redirectURL = adminUrl+"course/lists"   
				alert_response(data,redirectURL); 
			})
			.fail(function(data) {      
				console.log(data);       
			}); 
		}

		//Course status change function
		function changeCourseApproveStatus(id, thisSwitch) {  
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
				url: adminUrl+'course/changeCourseApproveStatus',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					courseId: String(id),        
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

		$(document).on('click','.course_info',function(){
			var courseId = $(this).data('cid');
			var courseLvl = $(this).data('lvl');

        	$.ajax({      
				url: adminUrl+'course/fetchCourseLvlDetail',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					courseId: courseId,        
					courseLvl: courseLvl        
				},
			})
			.done(function(data) {      
	           //console.log(data);
	           var lvlSubCrsHtml = '';
	           var lvlSubData = data.subjectCrsData;

	           $('#lvl_cost').text('$'+data.lvlCost);
	           $('#lvl_dur').text(data.totalhours+' Hours');
	           $('#lvl_ins').text(data.instructor);

	           for(var i=0;i<lvlSubData.length;i++){
	           	  lvlSubCrsHtml+= '<tr>';
	           	  lvlSubCrsHtml+= '<th width="30%">'+lvlSubData[i].subjectName+'</th>';
	           	  lvlSubCrsHtml+= '<td width="2%">:</td>';
	           	  lvlSubCrsHtml+= '<th>'+lvlSubData[i].chapterName+'</th>';
	           	  lvlSubCrsHtml+= '</tr>';
	           }
               
               $('#course_sub_crs_detail').html(lvlSubCrsHtml); 
			})
			.fail(function(data) {      
				console.log(data);       
			}); 
            $('#courseInfoModal').modal('show');  
		});

	</script>