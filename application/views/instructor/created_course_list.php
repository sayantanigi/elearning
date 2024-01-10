<div class="dashboard-content">
	<div class="container">
		<!--<h4 class="dashboard-title"></h4>-->
		<div class="card">
			<div class="card-body">
				 <div class="d-flex flex-wrap row">
					 <div class="col-lg-9 col-md-9 col-sm-9 d-flex flex-wrap">
              <h4 class="dashboard-title"><?=$title?></h4>
					 </div>	
					 <div class="col-lg-3 col-md-3 col-sm-3 d-flex flex-wrap" style="padding-left: 66px;">
						 <a href="<?= base_url('instructor/course/add') ?>" class="btn btn-rounded btn-info"><span> <i class="fa fa-plus color-info"></i>
						 </span> Add Course </a>	
					 </div>						
						
				 </div>

	       <table class="table table-bordered table-responsive-md coursetable">
					<thead class="text-center">
						<tr>
							<th>#</th>
							<th>Image</th>	
							<th>Course Name </th>
							<th>Course Levels</th>
							<th>Created On</th>
							<th>Approve Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php
						  if(count($courseList)>0){
								foreach (@$courseList as $key => $v){
									//FETCHING COURSE'S LEVEL
									$sql_cld= "SELECT GROUP_CONCAT(cld.level) as course_level FROM `course_level_details` cld WHERE cld.courseId='".$v->courseId."' AND cld.status = '1'";
									//echo $sql_cld;exit;
									$courseLvlDetail=  $this->mymodel->fetch($sql_cld, true); 
									//$courseLvlStr = join(',', array_map('ucfirst', explode(',', $courseLvlDetail->course_level)));
									$courseLvlArr = explode(',', $courseLvlDetail->course_level);
						  ?>
							<tr>	
								<td><?=$key+1?></td>
								<td class="courseBnr">
									<a href="<?= admin_url('course/view/'.$v->courseId) ?>">
										<?php if (@$v->image && file_exists('./uploads/courses/'.@$v->image)) { ?>
											<img src="<?= base_url('uploads/courses/'.@$v->image) ?>" alt="img">
										<?php } else { ?>
											<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
										<?php } ?>
									</a>
								</td>										
								<td ><?= @$v->courseName?></td>

								<td>
									<?php foreach ($courseLvlArr as $key => $level) { ?>
										<?=ucfirst($level)?> 
										<span class="course_info" data-toggle="tooltip" data-placement="top" data-original-title="Click to view other detail of this course" data-lvl="<?=$level?>" data-cid="<?=@$v->courseId?>" style="cursor: pointer;">
											<i class="fa fa-question-circle"></i>
										</span>
										<br>
									<?php } ?>
								</td>
																			
								<td class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></td>

								<td class="fs-13">
									 <?php if($v->approve_status == "approved"){ ?>
									 	  <div class="dashboard-table__text completed" data-dtype="hide">Approved</div>
									 <?php }else{ ?>	
									     <div class="dashboard-table__text cancelled" data-dtype="hide">Not Approved</div>  
									 <?php } ?>    	
								</td>	
							
								<td style="width:15%;">
									 <div class="dropdown">
                      <a class="dropdown-toggle dropdown-active dtp-8" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                         <span class="text">Action</span>
                      </a>

                      <ul class="dropdown-menu p-1 dm-item" aria-labelledby="dropdownMenuLink">
                         <li>
                         	  <a class="dropdown-item" href="<?= base_url('instructor/course/view/'.$v->courseId) ?>"><i class="fa fa-eye"></i>&nbsp;View Course</a>
                         </li>
                         
                         <?php if($v->approve_status == "forbidden"){ ?>
	                         <li>
	                            <a class="dropdown-item" href="<?=base_url('instructor/course/edit/'.$v->courseId)?>"><i class="fa fa-edit"></i>&nbsp;Edit Course</a>
	                         </li>

	                         <li>
	                            <a class="dropdown-item" href="javascript:void(0);" onclick="deleteCourse(<?=@$v->courseId?>)"><i class="fa fa-trash"></i>&nbsp;Delete Course</a>
	                         </li>
	                      <?php } ?> 
	                        <li>
                         	  <a class="dropdown-item" href="<?= base_url('instructor/course/cancel/'.$v->courseId) ?>"><i class="fa fa-sign-out"></i>&nbsp;Cancel Course</a>
                          </li>

                      </ul>
                    </div>
								</td>
							</tr>
						 <?php } }else{ ?>
                <tr>
                  <td colspan="5">No course is created by you!</td>
               </tr> 
            <?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="courseInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content course-modal-content">
      <div class="modal-header course-modal-header">
        <h5 class="modal-title">Course Detail</h5>
        <button type="button" class="btn-close course-info-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
      </div>
      <div class="modal-body course-modal-body">
        <div class="row">
			    <div class="col-lg-12 col-md-12 col-sm-12">
			      <h5><i class="fa fa-clone"></i> Course Information</h5>    
			      <div class="table-responsive pt-3">
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

				<div class="row pt-3">
				    <div class="col-lg-12 col-md-12 col-sm-12">
				      <h5><i class="fa fa-clone"></i> Course Subject & Chapter Detail</h5>    
				      <div class="table-responsive pt-3">
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
				 window.location.href = '<?= base_url('instructor/deleteCourse/') ?>'+courseId
			}
		});
	}

	$(document).on('click','.course_info',function(){
			var courseId = $(this).data('cid');
			var courseLvl = $(this).data('lvl');

      $.ajax({      
				url: baseUrl+'instructor/fetchCourseLvlDetail',       
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
         	  lvlSubCrsHtml+= '<td width="30%">'+lvlSubData[i].subjectName+'</td>';
         	  lvlSubCrsHtml+= '<td width="2%">:</td>';
         	  lvlSubCrsHtml+= '<td>'+lvlSubData[i].chapterName+'</td>';
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