<div class="dashboard-content">
    <div class="container">
        <h4 class="dashboard-title">Enrolled Courses</h4>
        <div class="dashboard-course">
            <div class="dashboard-tabs-menu">
                <ul>
                    <li><a class="<?=($subpage == "enrolledcourselist"?"active":"")?>" href="<?=base_url('student/enrolledcourselist')?>">Enrolled Courses</a></li>
                    <li><a class="<?=($subpage == "runningcourselist"?"active":"")?>" href="<?=base_url('student/runningcourselist')?>">Running Courses</a></li>
                    <li><a href="<?=base_url('student/copmpletedcourselist')?>" class="<?=($subpage == "completedcourselist"?"active":"")?>">Completed Courses</a></li>
                </ul>
            </div>
            <div class="dashboard-course-list">

              <?php 
                 $userId = $this->session->userdata('userId'); 
                 
                 if(!empty($courseData)){
                     foreach ($courseData as $key => $course) { 

                        $courseId = $course->courseId;
                        $courseLvl = $course->courseLvl;
                        $userId = $this->session->userdata('userId'); 

                        if($course->level_image && file_exists('./uploads/level/'.$course->level_image)) {
                           $course_thumbnail = base_url('uploads/level/'.$course->level_image);
                        }else{
                           $course_thumbnail = base_url('uploads/courses/'.$course->course_image);
                        }

                        $sql_instructor_detail = "SELECT sbc.instructorId FROM student_booked_classes sbc WHERE sbc.courseId='".$course->courseId."' AND sbc.courseLvl='".$course->courseLvl."' AND sbc.studentId='".$userId."' ORDER BY sbc.classId DESC LIMIT 1";

                        //echo $sql_instructor_detail;exit;

                        $instructorData = $this->mymodel->fetch($sql_instructor_detail, true);

                        $sql_booked_course = "SELECT sbc.instructorId,cr.reviewId,cr.rating,cr.feedback,sct.conferenceId,sct.meeting_url,sct.passcode FROM student_booked_classes sbc LEFT JOIN course_review cr ON ( sbc.courseId=cr.courseId  AND sbc.courseLvl = cr.courseLvl AND sbc.studentId = cr.studentId AND sbc.instructorId = cr.instructorId ) LEFT JOIN session_conference_tbl sct ON ( sbc.studentId = sct.studentId AND sbc.instructorId = sct.instructorId AND sbc.courseId = sct.courseId AND sbc.courseLvl = sct.courseLvl ) WHERE sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.studentId='".$userId."' ORDER BY sbc.classId DESC LIMIT 1";

                        //echo $sql_booked_course;exit;

                        //Feching Enrolled Course List 
                        $instructorData = $this->mymodel->fetch($sql_booked_course, true);
                        
                        if(!empty($instructorData->instructorId)){
                            $instructorId = $instructorData->instructorId;
                            $reviewId = $instructorData->reviewId;
                        }else{
                            $instructorId = null;
                            $reviewId = null;
                        }

                        if(!empty($instructorData->instructorId)){
                           $conferenceId = $instructorData->conferenceId;
                        }else{
                           $conferenceId = null;
                        }

                        if(!empty($instructorId)){
                            //Checking if there is any change instructor request for this current instructor
                            $sql_change_ins_record = "SELECT ci.queryId FROM change_instructor ci WHERE ci.studentId = '$userId' AND ci.courseId = '$courseId' AND ci.courseLvl = '$courseLvl' AND ci.instructorId = '$instructorId'";

                            $changeInstructorCount = $this->db->query($sql_change_ins_record)->num_rows();
                        }else{
                            $changeInstructorCount = 0;
                        }

                        //Check if the current course is cancelled by user ot not
                        $sql_cancel_student_record = "SELECT cc.stuCourseId FROM cancel_students cc WHERE cc.studentId = '$userId' AND cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

                        $cancelStudentCount = $this->db->query($sql_cancel_student_record)->num_rows();

                        //Check if the current course is cancelled by user ot not
                        $sql_cancel_crs_record = "SELECT cc.requestId FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

                        $cancelCourseCount = $this->db->query($sql_cancel_crs_record)->num_rows();

                        //Check if the current course is assigned to multiple instructor
                        $sql_crs_ins_count = "SELECT ci.courseInsId FROM course_instructors ci WHERE ci.courseId = '$courseId' AND ci.level = '$courseLvl'";

                        //echo $sql_crs_ins_count;exit;

                        $courseInsCount = $this->db->query($sql_crs_ins_count)->num_rows();

                        //Count no of session attended
                        $sql_check_attened_class = "SELECT sbc.classId  FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$userId' AND sbc.instructorId='$instructorId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP()";

                        //echo $sql_check_attened_class;exit;

                        $currentInsAttendClass = $this->db->query($sql_check_attened_class)->num_rows();

                        $sql_fetch_booked_class = "SELECT * FROM (SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$userId."' UNION ALL SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes_history WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$userId."' AND requestType = '1') AS bookedClassTbl";
                                        
                        //echo $sql_fetch_booked_class;exit;

                        $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);
                        
                        $totalBookedSeason = 0;

                        foreach ($bookedClassData as $index => $time) {
                            $totalBookedSeason +=  round($time->timeDiff);
                        }

                        $sql_fetch_used_session = "SELECT * FROM (SELECT TIMEDIFF(sbc.toTime , sbc.fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$userId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP() UNION ALL SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes_history WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$userId."' AND requestType = '1') AS attendClassTbl";

                        $attendClassData = $this->mymodel->fetch($sql_fetch_used_session, false);
                        
                        $usedSeason = 0;

                        foreach ($attendClassData as $index2 => $time) {
                            $usedSeason +=  round($time->timeDiff);
                        }  

                        //Fetching course total cost
                        $sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

                        //echo $sql_course_details;exit;

                        //Feching Course Details 
                        $courseDetails = $this->mymodel->fetch($sql_course_details, true);

                        $refundAmount = ($courseDetails->courseCost * $totalBookedSeason)/$courseDetails->totalHours;
                ?>

                <?php if(!empty($reviewId)){ ?>
                    <input type="hidden" id="rating_<?=$reviewId?>" value="<?=$instructorData->rating?>">
                    <input type="hidden" id="feedback_<?=$reviewId?>" value="<?=html_entity_decode($instructorData->feedback)?>">
                <?php } ?>

                <?php if(!empty($conferenceId)){ ?>
                    <input type="hidden" id="meetingUrl_<?=$conferenceId?>" value="<?=$instructorData->meeting_url?>">
                    <input type="hidden" id="passCode_<?=$conferenceId?>" value="<?=html_entity_decode($instructorData->passcode)?>">
                <?php } ?>

                <input type="hidden" id="courseName_<?=($key+1)?>" value="<?=$course->courseName?>">
                <input type="hidden" id="crsSession_<?=($key+1)?>" value="<?=$courseDetails->totalHours?>">
                <input type="hidden" id="crsCost_<?=($key+1)?>" value="<?=$courseDetails->courseCost?>">
                <input type="hidden" id="bookedSession_<?=($key+1)?>" value="<?=$totalBookedSeason?>">
                <input type="hidden" id="deductionAmount_<?=($key+1)?>" value="<?=$refundAmount?>">
                 
                <div class="dashboard-course-item">
                    <div class="dashboard-course-item__link" href="javascript:void(0);">
                        <div class="dashboard-course-item__thumbnail">
                            <img src="<?=$course_thumbnail?>" alt="Courses" style="width: 260px;height: 170px;">
                        </div>
                        <div class="dashboard-course-item__content">
                            <!--<div class="dashboard-course-item__rating">
                                <div class="rating-star">
                                    <div class="rating-label" style="width: 80%;"></div>
                                </div>
                            </div>-->
                            <div class="course-heading">
                                <h3 class="dashboard-course-item__title"><?=$course->courseName?></h3>

                                <?php if($cancelStudentCount>0 || $cancelCourseCount>0){ ?>
                                    <a href="javascript:void(0);" onclick="showRefundDetails('<?=$key+1?>')"><i class="fa fa-info-circle" aria-hidden="true"></i> View Refund Details</a>
                                <?php } ?>    
                            </div>    
                            <div class="dashboard-course-item__meta">
                                <ul class="dashboard-course-item__meta-list">
                                    <li>
                                        <span class="meta-label">Total Duration:</span>
                                        <span class="meta-value"><?=$course->totalHours?> Hours</span>
                                    </li>
                                    <li>
                                        <span class="meta-label">Chapters:</span>
                                        <span class="meta-value"><?=$course->totalChapter?> Chapters</span>
                                    </li>
                                     <li>
                                        <span class="meta-label">Level:</span>
                                        <span class="meta-value"><?=ucfirst($course->courseLvl)?></span>
                                    </li>
                                    <li>
                                        <span class="meta-label">Session Booked:</span>
                                        <span class="meta-value"><?=$totalBookedSeason?> Hours</span>
                                    </li>
                                    <li>
                                        <span class="meta-label">Session Spent:</span>
                                        <span class="meta-value"><?=$usedSeason?> Hours</span>
                                    </li>
                                    <li>
                                        <span class="meta-label">Session Left:</span>
                                        <span class="meta-value"><?=($course->totalHours-$totalBookedSeason)?> Hours</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="dashboard-course-item__progress-bar-wrap">
                                <?php if($changeInstructorCount == 0 && $cancelCourseCount == 0 && $cancelStudentCount == 0){ ?>
                                    <div class="course_detail" id="course_detail" data-cid="<?=$course->courseId?>" data-lvl="<?=$course->courseLvl?>">Level Detail</div>
                                   
                                    <div class="course_detail" id="instructor_detail" style="margin-left:5px;" data-cid="<?=$course->courseId?>" data-lvl="<?=$course->courseLvl?>" data-bs-toggle="tooltip" data-bs-placement="top" title="View instrcutor details for this course" data-bs-custom-class="color-tooltip">Instructor Detail</div>

                                     <?php if(!empty($instructorId) && $currentInsAttendClass>=2 && $courseInsCount>1){?>
                                        <div class="course_detail" id="show_ins_detail" data-bs-toggle="tooltip" data-bs-placement="top" title="Change this course instructor" data-bs-custom-class="color-tooltip" style="margin-left:5px;" onclick="changeInstructor('<?=($key+1)?>',<?=$course->courseId?>,'<?=$course->courseLvl?>',<?=$instructorId?>)"><i class="far fa-exchange"></i></div>

                                        <!--<div class="course_detail" id="add_course_review" data-bs-toggle="tooltip" data-bs-placement="top" title="<?=(!empty($reviewId)?'Update':'Add')?> review for this instructor" data-bs-custom-class="color-tooltip" style="margin-left:5px;" onclick="addCourseReview(<?=$instructorId?>,<?=$reviewId?>)"><i class="far fa-star"></i></div>-->
                                     <?php } ?>

                                     <?php if($cancelCourseCount == 0){?>
                                         <div class="course_detail" id="cancel_course" data-bs-toggle="tooltip" data-bs-placement="top" title="Sign out from this course" data-bs-custom-class="color-tooltip" style="margin-left:5px;" onclick="cancelCourse('<?=($key+1)?>',<?=$course->courseId?>,'<?=$course->courseLvl?>')"><i class="far fa-sign-out"></i></div>
                                     <?php } ?>    

                                     <?php if($conferenceId != null){?>    
                                        <div class="course_detail" id="display_conference_data" data-bs-toggle="tooltip" data-bs-placement="top" title="View your next session's conference detail" data-bs-custom-class="color-tooltip" style="margin-left:5px;" onclick="revealConferenceDetail(<?=$conferenceId?>)"><i class="far fa-link"></i></div>
                                     <?php } ?>

                                    <?php 
                                      if(!empty($instructorData->instructorId) && $instructorData->instructorId != null){ 
                                    ?>
                                        <div class="instructor_detail" id="show_booked_schedule" style="margin-left:5px;" data-cid="<?=$course->courseId?>" data-lvl="<?=$course->courseLvl?>" data-uid="<?=$instructorId?>" data-bs-toggle="tooltip" data-bs-placement="top" title="View your booked session" data-bs-custom-class="color-tooltip"><i class="far fa-clock"></i>&nbsp;</div>
                                    <?php }?>  
                                <?php 
                                    }else{
                                       if($cancelStudentCount>0 || $cancelCourseCount>0){ 
                                ?>
                                       <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong></strong> This course is currently cancelled. You won't be able to perform any action until this dispute is resolved. Stay tuned!
                                       </div> 
                                <?php }else{ ?>
                                       <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong></strong> There is a change instructor request is in pending status. You won't be able to perform any action until this dispute is resolved. Stay tuned!
                                       </div> 
                                <?php } } ?>                
                            </div>
                        </div>
                    </div>
                </div>

             <?php } }else{?>
                <span class="text-left"><h4>You haven't any <?=$course_type?> course yet.</h4></span>
             <?php } ?>  
            </div>
        </div>
    </div>
</div>

 <div class="modal fade" id="addCourseReview">
    <div class="modal-dialog modal-dialog-centered modal-login">
        <div class="modal-wrapper">
            <button type="button" class="modal-close btn-close" data-bs-dismiss="modal"><i class="fal fa-times"></i></button>     
            <div class="modal-content model_req">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">Add Review</h5>
                </div>
                <div class="modal-body">
                    <form id="add_course_review" method="post" onsubmit="return false;">
                        <input type="hidden" name="insId" id="review_insId" value="">
                        <input type="hidden" name="courseId" id="review_courseId" value="<?=$courseId?>">
                        <input type="hidden" name="courseLvl" id="review_courseLvl" value="<?=$courseLvl?>">
                        <input type="hidden" name="reviewId" id="reviewId" value="">

                        <div class="rating-box">
                              <label class="form-label">Rating:</label>
                              <div class="rating-container">
                              <input class="review_input" type="radio" name="rating" value="5" id="star-5"> <label class="rating_label" for="star-5">&#9733;</label>
                              
                              <input class="review_input" type="radio" name="rating" value="4" id="star-4"> <label class="rating_label" for="star-4">&#9733;</label>
                              
                              <input class="review_input" type="radio" name="rating" value="3" id="star-3"> <label class="rating_label" for="star-3">&#9733;</label>
                              
                              <input class="review_input" type="radio" name="rating" value="2" id="star-2"> <label class="rating_label" for="star-2">&#9733;</label>
                              
                              <input class="review_input" type="radio" name="rating" value="1" id="star-1"> <label class="rating_label" for="star-1">&#9733;</label>
                            </div>
                        </div>

                        <div id="alert-msg"></div>
                        <div class="modal-form">
                            <label class="form-label">Feedback:</label>
                            <textarea name="feedback" id="feedback" class="form-control" placeholder="Add your review on this course" required></textarea>
                            <p id="feedback_remain_char" style="color:red;"></p>
                        </div>
                        
                        <div class="modal-form">
                            <button type="submit" id="resetInstructor" class="btn btn-primary btn-hover-secondary w-100">Submit</button>
                        </div>
                    </form>

                </div>
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
                      <div class="table-responsive">
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

<div class="modal fade" tabindex="-1" id="changeInstructorModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content course-modal-content">
        <div class="modal-header course-modal-header">
            <h5 class="modal-title" id="change_ins_modal_title"></h5>
            <button type="button" class="btn-close course-info-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="overlayer" style="display: none;">
                <div class="spinner"></div>
            </div> 
            <!--<div class="row px-3">
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <h5><i class="fa fa-clone"></i> Course Refund Details</h5>   

                  <div class="table-responsive pt-3">
                     <table class="table table-bordered">
                       <tr>
                        <th width="30%">Total Course Session</th>
                        <td width="2%">:</td>
                        <td id="chng_course_session">125</td>
                       </tr>  

                       <tr>
                        <th width="30%">Total Course Cost</th>
                        <td width="2%">:</td>
                        <td id="chng_course_cost">125</td>
                      </tr>   

                      <tr>
                        <th width="30%">Course Session Expired</th>
                        <td width="2%">:</td>
                        <td id="chng_used_session">125</td>
                      </tr>  

                      <tr>
                        <th width="30%">Amount of Deduction</th>
                        <td width="2%">:</td>
                        <td id="chng_deduction_amount">125</td>
                      </tr>

                      <tr>
                        <th width="30%">Refund Amount</th>
                        <td width="2%">:</td>
                        <td id="chng_refund_amount">125</td>
                      </tr>  
                     </table>
                  </div>   
                </div>
            </div>-->

            <div class="row pb-3 px-3">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form id="change_course_instructor" method="post" onsubmit="return false;">
                        <input type="hidden" name="insId" id="chngIns_insId" value="">
                        <input type="hidden" name="courseId" id="chngIns_courseId" value="<?=$courseId?>">
                        <input type="hidden" name="courseLvl" id="chngIns_courseLvl" value="<?=$courseLvl?>">

                        <div class="modal-form">
                           <label class="form-label">Reason for Change:</label>
                           <select class="form-control" name="reasonId" id="reasonId" required>
                              <option selected disabled>Please select a reson from below options</option>
                              <?php foreach($reasonList as $index => $reason) { ?>
                                <option value="<?=$reason->reasonId?>"><?=$reason->reason?></option>
                              <?php } ?>  
                           </select>
                        </div>

                        <div id="alert-msg"></div>
                        <div class="modal-form pt-3">
                            <label class="form-label">Reason of change</label>
                            <textarea name="descriptions" class="form-control" placeholder="Please explain your reason for changing the instrucutor (All your current sessions will be reset and new instructors will become available for booking...)" required></textarea>
                        </div>
                        
                        <div class="modal-form">
                            <button type="submit" id="resetInstructor" class="btn btn-primary btn-hover-secondary w-100">Change Instructor</button>
                        </div>
                    </form>
                </div>    
            </div>    
        </div>
       </div>
     </div>
</div>

<div class="modal fade" id="revealConferenceModal">
    <div class="modal-dialog modal-dialog-centered modal-login">
        <div class="modal-wrapper">
            <div class="modal-content model_req">
                <div class="modal-header">
                    <h5 class="modal-title">Conference Details</h5>
                </div>
                <div class="modal-body">
                    <div id="alert-msg"></div>
                    <div class="modal-form">
                        <label class="form-label">Conference Link</label>
                        <input type="text" class="form-control" name="meeting_url" id="meeting_url" value="" readonly>
                    </div>

                     <div class="modal-form">
                        <label class="form-label">Conference Passcode</label>
                        <input type="text" class="form-control" name="passcode" id="passcode" value="" readonly>
                    </div>
                    
                    <div class="modal-form">
                        <button type="button" id="closeConfrenceModal" class="btn btn-danger btn-hover-secondary w-100">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="cancelCourseModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content course-modal-content">
      <div class="modal-header course-modal-header">
        <h5 class="modal-title" id="cancel_course_modal_title"></h5>
        <button type="button" class="btn-close course-info-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
      </div>
      <div class="modal-body course-modal-body">
        <div class="row px-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <h5><i class="fa fa-clone"></i> Course Refund Details</h5>    
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
                    <th width="30%">Refund Amount</th>
                    <td width="2%">:</td>
                    <td id="refund_amount">125</td>
                  </tr>  
                </table>
              </div>
            </div>  
          </div>

         <div class="row pt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <h5><i class="fa fa-clone"></i> Reason for Cancellation (Submit the form below to apply for course cancellation)</h5>     
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
    
    function changeInstructor(index,courseId,courseLvl,instructorId){

       var courseName = $('#courseName_'+index).val(); 

       var course_session = $("#crsSession_"+index).val();
       var course_cost = parseFloat($("#crsCost_"+index).val()).toFixed(2);
       var used_session = $("#bookedSession_"+index).val();
       var deduction_amount = parseFloat($("#deductionAmount_"+index).val()).toFixed(2);

       var refund_amount = parseFloat(course_cost - deduction_amount).toFixed(2);

       $('#change_ins_modal_title').text("Change instructor on '"+courseName+"'");
       
       $("#chng_course_session").text(course_session+" Hours");
       $("#chng_course_cost").text("$"+course_cost);
       $("#chng_used_session").text(used_session+" Hours");
       $("#chng_deduction_amount").text("$"+deduction_amount);
       $("#chng_refund_amount").text("$"+refund_amount);

       $("#chngIns_courseId").val(courseId);
       $("#chngIns_courseLvl").val(courseLvl);
       $("#chngIns_insId").val(instructorId);

       $("#changeInstructorModal").modal('show');
    } 

    function showRefundDetails(index){
       var courseName = $('#courseName_'+index).val(); 

       var course_session = $("#crsSession_"+index).val();
       var course_cost = parseFloat($("#crsCost_"+index).val()).toFixed(2);
       var used_session = $("#bookedSession_"+index).val();
       var deduction_amount = parseFloat($("#deductionAmount_"+index).val()).toFixed(2);

       var refund_amount = parseFloat(course_cost - deduction_amount).toFixed(2);

       $('#display_refund_modal_title').text("Refund Details for '"+courseName+"'");
       
       $("#refund_course_session").text(course_session+" Hours");
       $("#refund_course_cost").text("$"+course_cost);
       $("#refund_used_session").text(used_session+" Hours");
       $("#refund_deduction_amount").text("$"+deduction_amount);
       $("#refund_refund_amount").text("$"+refund_amount);

       $("#displayRefundModal").modal('show');
    }

    function cancelCourse(index,courseId,courseLvl,studentId){
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

       $("#cancelCourseModal").modal('show');
    } 


    function revealConferenceDetail(conferenceId){
        var meetingUrl = $("#meetingUrl_"+conferenceId).val();
        var passcode = $("#passCode_"+conferenceId).val();

        $("#meeting_url").val(meetingUrl);
        $("#passcode").val(passcode);

        $("#revealConferenceModal").modal('show');
    }

    function addCourseReview(instructorId,reviewId){
       var rating = $("#rating_"+reviewId).val();  
       var feedback = $("#feedback_"+reviewId).val();  

       if(reviewId){
          $("#modal_title").text("Update Review");
       }else{
          $("#modal_title").text("Add Review");
       }

       $("#star-"+rating).prop("checked",true);
       $("#feedback").text(feedback);

       $("#review_insId").val(instructorId);
       $("#reviewId").val(reviewId);

       $("#addCourseReview").modal('show');
    } 

    $("#closeConfrenceModal").click(function(){
         $("#revealConferenceModal").modal('hide');
    });

     $('#feedback').keydown(function(e) { 
        //take the event argument
        var maxLen = 94;
        var Length = $(this).val().length; // lets use 'this' instead of looking up the element in the DOM

       if(Length > maxLen && e.keyCode != 8){ // allow backspace
          e.preventDefault(); // cancel the default action of the event
          //reassign substring of max length to text area value
         this.value = this.value.substring(0, maxLen);
       }

       var AmountLeft = maxLen - Length;
       if(AmountLeft == -1){
         AmountLeft = 0;
       }
        $('#feedback_remain_char').text(AmountLeft+' characeters left!');
     });

    //HANDLING CHANGE INSTRUCTOR FORM
    $(document).on('submit', '#change_course_instructor', function(event){
         event.preventDefault();
         var reasonId = $('#reasonId').val();

         if(!reasonId){
            alert_func(["Please select a reason to proceed", "error", "#DD6B55"]);
            return false;
         }

         //Throwing ajax request in server 
         $.ajax({
          url:baseUrl+'student/changeInstructor',
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

    //HANDLING COURSE REVIEW FORM
    $(document).on('submit', '#add_course_review', function(event){
         event.preventDefault();

         //Throwing ajax request in server 
         $.ajax({
          url:baseUrl+'student/addCourseReview',
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

    //HANDLING COURSE CANCELLATION REQUEST FORM
    $(document).on('submit', '#cancel_course_form', function(event){
         event.preventDefault();

         //Throwing ajax request in server 
         $.ajax({
          url:baseUrl+'student/cancelCourse',
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