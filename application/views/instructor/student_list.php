<?php
  /*print"<pre>";
  print_r($studentData);
  print"</pre>";*/
?>
<div class="dashboard-content">
	<div class="container">
		<h4 class="dashboard-title"><?=$title?></h4>
		<div class="card">
			<div class="card-body">
               <table class="table table-bordered table-responsive-md coursetable">
				  <thead class="text-center">
					<tr>
						<th>Sl No. </th>
						<th>Student Name </th>
						<!--<th>Student Email </th>-->
						<th>Course Name </th>
						<th>Course Level </th>
						<!--<th>Profiile Pic</th>-->
						<th>Student Enrolled</th>	
						<th>Action</th>	
					</tr>
				  </thead>
				  <tbody class="text-center">
					 <?php 
                        if(count($studentData)>0){
                            foreach (@$studentData as $key => $v){ 

                                $studentId = $v->userId;
                                $courseId = $v->courseId;
                                $courseLvl = $v->courseLvl;
                                $instructorId = $this->session->userdata('userId');

                                //Checking if there is any change instructor request for this current instructor
                                $sql_change_ins_record = "SELECT ci.queryId FROM change_instructor ci WHERE ci.studentId = '$studentId' AND ci.courseId = '$courseId' AND ci.courseLvl = '$courseLvl' AND ci.instructorId = '$instructorId'";

                                $changeInstructorCount = $this->db->query($sql_change_ins_record)->num_rows();

                                if($changeInstructorCount>0){
                                    $invalidAction = 1;
                                }

                                //Check if the current course is cancelled by user ot not
                                $sql_cancel_student_record = "SELECT cc.stuCourseId FROM cancel_students cc WHERE cc.studentId = '$studentId' AND cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

                                $cancelStudentCount = $this->db->query($sql_cancel_student_record)->num_rows();

                                //Check if the current course is cancelled by user ot not
                                $sql_cancel_crs_record = "SELECT cc.requestId FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

                                $cancelCourseCount = $this->db->query($sql_cancel_crs_record)->num_rows();

                                if($cancelStudentCount>0){
                                    $invalidAction = 2;
                                }

                                if($cancelCourseCount>0){
                                    $invalidAction = 3;
                                }

                                $sql_fetch_booked_class = "SELECT TIMEDIFF(sbc.toTime , sbc.fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND sbc.classDate < CURDATE()";
                                                
                                //echo $sql_fetch_booked_class;exit;

                                $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);
                                
                                $totalBookedSeason = 0;

                                foreach ($bookedClassData as $index => $time) {
                                    $totalBookedSeason +=  round($time->timeDiff);
                                }

                                //Fetching course total cost
                                $sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

                                //echo $sql_course_details;exit;

                                //Feching Course Details 
                                $courseDetails = $this->mymodel->fetch($sql_course_details, true);

                                $refundAmount = ($courseDetails->courseCost * $totalBookedSeason)/$courseDetails->totalHours;

                     ?>
						<tr>
							<input type="hidden" id="stuId_<?=($key+1)?>" value="<?=$v->userId?>">
							<input type="hidden" id="courseId_<?=($key+1)?>" value="<?=$v->courseId?>">
							<input type="hidden" id="courseLvl_<?=($key+1)?>" value="<?=$v->courseLvl?>">
                            
                            <input type="hidden" id="conferenceId_<?=($key+1)?>" value="<?=$v->conferenceId?>">
							<input type="hidden" id="meetingUrl_<?=($key+1)?>" value="<?=$v->meeting_url?>">
							<input type="hidden" id="passCode_<?=($key+1)?>" value="<?=$v->passcode?>">

                            <input type="hidden" id="courseName_<?=($key+1)?>" value="<?=$v->courseName?>">

                            <input type="hidden" id="crsSession_<?=($key+1)?>" value="<?=$courseDetails->totalHours?>">
                            <input type="hidden" id="crsCost_<?=($key+1)?>" value="<?=$courseDetails->courseCost?>">
                            <input type="hidden" id="bookedSession_<?=($key+1)?>" value="<?=$totalBookedSeason?>">
                            <input type="hidden" id="deductionAmount_<?=($key+1)?>" value="<?=$refundAmount?>">

							<td><?= $key+1 ?></td>
							<td><?= $v->firstName."&nbsp;".$v->lastName ?></td>
							<!--<td><?= $v->email ?></td>-->		
							<td><?= $v->courseName ?></td>		
							<td><?= ucfirst($v->courseLvl) ?></td>		
							<!--<td><?= $totalLesson ?></td>									    	
							<td class="courseBnr">
								<?php if (@$v->profile_pic && file_exists('./uploads/users/'.@$v->profile_pic)) { ?>
									<img src="<?= base_url('uploads/users/'.@$v->profile_pic) ?>" alt="img">
								<?php } else { ?>
									<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
								<?php } ?>
							</td>-->																		
							<td class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></td>
							<td>
                                <div class="dropdown">
                                   <a class="dropdown-toggle dropdown-active dtp-8" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                     <span class="text">Action</span>
                                   </a>

                                   <ul class="dropdown-menu p-1 dm-item" aria-labelledby="dropdownMenuLink">
                                       <?php if($changeInstructorCount == 0 && ($cancelStudentCount == 0 || $cancelCourseCount>0)){ ?>
                                          <li>
                                              <a class="dropdown-item" href="<?= base_url('instructor/showstudentschedule/'.$v->courseId.'/'.$v->courseLvl.'/'.$v->userId) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="color-tooltip" title="Update View this student schedule calendar"><i class="fa fa-eye"></i>&nbsp;View Schedule</a>
                                          </li>
                                         
                                         <li>
                                            <a class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Conference Link for this student" data-bs-custom-class="color-tooltip" onclick="updateConferenceData(<?=$key+1?>)"><i class="fa fa-edit"></i>&nbsp;Conference</a>
                                         </li>
                                        
                                         <li>
                                            <a class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel this current student for this course" data-bs-custom-class="color-tooltip" style="margin-left:5px;" onclick="cancelStudent('<?=($key+1)?>','<?=$courseId?>','<?=$courseLvl?>','<?=$studentId?>')"><i class="fa fa-sign-out"></i>&nbsp;Cancel Student</a>
                                         </li>
                                       <?php 
                                           }else{
                                              if($changeInstructorCount>0){
                                       ?>
                                         <li>
                                              <a class="dropdown-item" href="javascript:void(0);" onclick="showCourseStatus('<?=($key+1)?>','<?=$invalidAction?>')"><i class="fa fa-info-circle"></i>&nbsp;View Course Status
                                              </a>
                                         </li>
                                       <?php }elseif($cancelStudentCount>0 || $cancelCourseCount>0){ ?>     
                                          <li>
                                              <a class="dropdown-item" href="javascript:void(0);" onclick="showCourseStatus('<?=($key+1)?>','<?=$invalidAction?>')"><i class="fa fa-info-circle"></i>&nbsp;View Refund Details
                                              </a>
                                          </li>
                                       <?php } } ?>      
                                   </ul>
                                </div>
							</td>
						</tr>
					 <?php } }else{ ?>
                         <td colspan="5">No student is found at this moment!</td>
                     <?php } ?> 
			       </tbody>
			    </table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="displayRefundModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content course-modal-content">
        <div class="modal-header course-modal-header">
            <h5 class="modal-title" id="display_refund_modal_title"></h5>
            <button type="button" class="btn-close course-info-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="row px-3">
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong></strong><span id="refundReasonTxt"></span>
                  </div> 
                  <div class="table-responsive" id="refundDetailsTbl">
                     <table class="table table-bordered">
                       <tr>
                        <th width="30%">Total Course Session</th>
                        <td width="2%">:</td>
                        <td id="refund_course_session">125</td>
                       </tr>  

                       <tr>
                        <th width="30%">Total Course Cost</th>
                        <td width="2%">:</td>
                        <td id="refund_course_cost">125</td>
                      </tr>   

                      <tr>
                        <th width="30%">Course Session Expired</th>
                        <td width="2%">:</td>
                        <td id="refund_used_session">125</td>
                      </tr>  

                      <tr>
                        <th width="30%">Amount of Deduction</th>
                        <td width="2%">:</td>
                        <td id="refund_deduction_amount">125</td>
                      </tr>

                      <tr>
                        <th width="30%">Refund Amount</th>
                        <td width="2%">:</td>
                        <td id="refund_refund_amount">125</td>
                      </tr>  
                     </table>
                  </div>   
                </div>
            </div>

        </div>
       </div>
     </div>
</div>

<div class="modal fade" id="updateConferenceModal">
    <div class="modal-dialog modal-dialog-centered modal-login">
        <div class="modal-wrapper">
            <button type="button" class="modal-close btn-close" data-bs-dismiss="modal"><i class="fal fa-times"></i></button>     
            <div class="modal-content model_req">
                <div class="modal-header">
                    <h5 class="modal-title">Conference Link</h5>
                    <p class="modal-description">Update Conference Link for this student</p>
                </div>
                <div class="modal-body">
                    <div class="overlayer" style="display: none;">
                        <div class="spinner"></div>
                    </div>  
                    <form id="update_conference_link" method="post" onsubmit="return false;">
                        <input type="hidden" name="studentId" id="conference_stuId" value="">
                        <input type="hidden" name="courseId" id="conference_courseId" value="">
                        <input type="hidden" name="courseLvl" id="conference_courseLvl" value="">
                        <input type="hidden" name="conferenceId" id="conferenceId" value="">

                        <div id="alert-msg"></div>
                        <div class="modal-form">
                            <label class="form-label">Conference Link&nbsp;<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="meeting_url" id="meeting_url" value="" placeholder="Enter Conference Link" required>
                        </div>

                         <div class="modal-form">
                            <label class="form-label">Conference Passcode</label>
                            <input type="text" class="form-control" name="passcode" id="passcode" value="" placeholder="Enter Conference Passcode">
                        </div>
                        
                        <div class="modal-form">
                            <button type="submit" id="resetInstructor" class="btn btn-primary btn-hover-secondary w-100">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="cancelStudentModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content course-modal-content">
      <div class="modal-header course-modal-header">
        <h5 class="modal-title" id="cancel_course_modal_title"></h5>
        <button type="button" class="btn-close course-info-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
      </div>
      <div class="modal-body course-modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <h5><i class="fa fa-clone"></i> Cancellation Information</h5>  
              <div class="overlayer" style="display: none;">
                  <div class="spinner"></div>
              </div>   
              <div class="table-responsive pt-3">
                <table class="table table-bordered">
                   <tr>
                    <th width="30%">Total Course Session</th>
                    <td width="2%">:</td>
                    <td id="course_session">125</td>
                  </tr>  
                   <tr>
                    <th width="30%">Total Course Cost</th>
                    <td width="2%">:</td>
                    <td id="course_cost">125</td>
                  </tr>   
                  <tr>
                    <th width="30%">Course Session Expired</th>
                    <td width="2%">:</td>
                    <td id="used_session">125</td>
                  </tr>  
                  <tr>
                    <th width="30%">Amount of Deduction</th>
                    <td width="2%">:</td>
                    <td id="deduction_amount">125</td>
                  </tr>
                  <tr>
                    <th width="30%">Amount of Refund</th>
                    <td width="2%">:</td>
                    <td id="refund_amount">125</td>
                  </tr>  
                </table>
              </div>
            </div>  
          </div>

         <div class="row pt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <h5><i class="fa fa-clone"></i> Reason for Cancellation (Submit the form below to apply for students cancellation)</h5>     
              <div class="table-responsive pt-3">
                 <form id="cancel_course_form" method="post" onsubmit="return false;">
                    <input type="hidden" name="courseId" id="cancel_courseId" value="">
                    <input type="hidden" name="courseLvl" id="cancel_courseLvl" value="<?=$courseId?>">
                    <input type="hidden" name="studentId" id="cancel_stuId" value="">

                    <div id="alert-msg"></div>
                    <div class="modal-form">
                        <textarea name="descriptions" class="form-control" placeholder="Please explain your reason for cancel this course (All your current data linked with this course will be removed)" required></textarea>
                    </div>
                    
                    <div class="modal-form">
                        <button type="submit" id="resetInstructor" class="btn btn-primary btn-hover-secondary w-100">Submit Request</button>
                    </div>
                </form>
              </div>
            </div>  
         </div>
        </div>
    </div>
  </div>
</div>

<script>
    function updateConferenceData(rowId){
       var studentId = $("#stuId_"+rowId).val();
       var courseId = $("#courseId_"+rowId).val();
       var courseLvl = $("#courseLvl_"+rowId).val();

       //Reseting form before populate
       $("#update_conference_link")[0].reset();

       $("#conference_stuId").val(studentId);
       $("#conference_courseId").val(courseId);
       $("#conference_courseLvl").val(courseLvl);

       var conferenceId = $("#conferenceId_"+rowId).val();

       if(conferenceId){
       	   var meetingUrl = $("#meetingUrl_"+rowId).val();
           var passcode = $("#passCode_"+rowId).val();
           
           $("#conferenceId").val(conferenceId);
           $("#meeting_url").val(meetingUrl);
           $("#passcode").val(passcode);
       }
      
       //Show modal
       $('#updateConferenceModal').modal('show');
    } 

    function showCourseStatus(index,invalidAction){
       var courseName = $('#courseName_'+index).val(); 

       var course_session = $("#crsSession_"+index).val();
       var course_cost = parseFloat($("#crsCost_"+index).val()).toFixed(2);
       var used_session = $("#bookedSession_"+index).val();
       var deduction_amount = parseFloat($("#deductionAmount_"+index).val()).toFixed(2);

       var refund_amount = parseFloat(course_cost - deduction_amount).toFixed(2);

       if(invalidAction == 1){
          var refundTxt = "There is a change instructor request is in pending status. You won't be able to perform any action until this"+            "dispute is resolved. Please contact the admin if you have any query regarding this issue.";
          $("#refundDetailsTbl").css({'display':'none'});
       }
       else if(invalidAction = 2){
          var refundTxt = "There is a cancel course or student request is in pending status. You won't be able to perform any action until"+            " this dispute is resolved. Please contact the admin if you have any query regarding this issue.";
       }else{
          var refundTxt = "There is a cancel course request by you is in pending status. You won't be able to perform any action until this"+            " dispute is resolved. Please contact the admin if you have any query regarding this issue.";
       }

       $('#refundReasonTxt').text(refundTxt);
       $('#display_refund_modal_title').text("Refund Details for '"+courseName+"'");
       
       $("#refund_course_session").text(course_session+" Hours");
       $("#refund_course_cost").text("$"+course_cost);
       $("#refund_used_session").text(used_session+" Hours");
       $("#refund_deduction_amount").text("$"+deduction_amount);
       $("#refund_refund_amount").text("$"+refund_amount);

       $("#displayRefundModal").modal('show');
    }

    function cancelStudent(index,courseId,courseLvl,studentId){
       var courseName = $('#courseName_'+index).val(); 

       var course_session = $("#crsSession_"+index).val();
       var course_cost = parseFloat($("#crsCost_"+index).val()).toFixed(2);
       var used_session = $("#bookedSession_"+index).val();
       var deduction_amount = parseFloat($("#deductionAmount_"+index).val()).toFixed(2);

       var refund_amount = parseFloat(course_cost - deduction_amount).toFixed(2);

       //console.log(course_session+'***'+course_cost+'***'+used_session+'***'+deduction_amount);

       $('#cancel_course_modal_title').text("Sign out from '"+courseName+"'");
       $("#cancel_courseId").val(courseId);
       $("#cancel_courseLvl").val(courseLvl);
       $("#cancel_stuId").val(studentId);
       
       $("#course_session").text(course_session+" Hours");
       $("#course_cost").text("$"+course_cost);
       $("#used_session").text(used_session+" Hours");
       $("#deduction_amount").text("$"+deduction_amount);
       $("#refund_amount").text("$"+refund_amount);

       $("#cancelStudentModal").modal('show');
    } 

    //HANDLING SCHEDULE FORM
    $(document).on('submit', '#update_conference_link', function(event){
         event.preventDefault();

         //Throwing ajax request in server 
         $.ajax({
          url:baseUrl+'instructor/updateConferenceLink',
          method:'POST',
          data: new FormData(this),
          contentType:false,
          processData:false,
          beforeSend: function() {
             $('.overlayer').fadeIn();
          },
          success:function(resposeData){//alert(resposeData);
              var data = JSON.parse(resposeData);
              $("#updateConferenceModal").modal('hide');
              $('.overlayer').fadeOut();

              if(data.check == 'success'){
                 setTimeout(function(){
                    var redirectURL = window.location.href.split('#')[0];
                    alert_response([data.msg, "success", "#A5DC86"],redirectURL);
                }, 10);
              }else{
                //$(".error_massage").removeClass("d-none");
                setTimeout(function(){
                    alert_func([data.msg, "error", "#DD6B55"]);
                }, 10);
              }
          }
        });    
     });

    //HANDLING COURSE CANCELLATION REQUEST FORM
    $(document).on('submit', '#cancel_course_form', function(event){
         event.preventDefault();

         //Throwing ajax request in server 
         $.ajax({
          url:baseUrl+'instructor/cancelStudent',
          method:'POST',
          data: new FormData(this),
          contentType:false,
          processData:false,
           beforeSend: function() {
             $('.overlayer').fadeIn();
          },
          success:function(resposeData){//alert(resposeData);
              var data = JSON.parse(resposeData);
              $("#chnageInstructorModal").modal('hide');
              $('.overlayer').fadeOut();

              if(data.check == 'success'){
                 setTimeout(function(){
                    var redirectURL = window.location.href.split('#')[0];
                    alert_response([data.msg, "success", "#A5DC86"],redirectURL);
                }, 10);
              }else{
                //$(".error_massage").removeClass("d-none");
                setTimeout(function(){
                    alert_func([data.msg, "error", "#DD6B55"]);
                }, 10);
              }
          }
        });    
    });
</script>    