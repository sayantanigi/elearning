<?php 
  /*print"<pre>";
  print_r($reasonList);
  print"</pre>";*/
?>
<div class="dashboard-content">
    <div class="container">
        <h4 class="dashboard-title"><?=$title?></h4>
        <div class="dashboard-course">
            <div class="dashboard-course-list">

              <?php 
                 foreach ($instructorList as $key => $instructor) { 
                    
                    $userId = $this->session->userdata('userId'); 
                    $insName = $instructor->firstName." ".$instructor->lastName; 
                    $insId = $instructor->userId;

                    if ($instructor->profilePic && file_exists('./uploads/users/'.$instructor->profilePic)) {
                       $profilePic = base_url('uploads/users/'.$instructor->profilePic);
                    }else{
                       $profilePic = base_url('dist/images/noimage.jpg');
                    }

                    $sql_ins_avg_review = "SELECT AVG(cr.rating) as insAvgRating FROM course_review cr WHERE cr.instructorId='$insId'";
                    //echo $sql_ins_avg_review;exit;
                    
                    $avgRtingData = $this->mymodel->fetch($sql_ins_avg_review, true);

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

                        //echo $sql_change_ins_record;exit;

                        $changeInstructorCount = $this->db->query($sql_change_ins_record)->num_rows();
                    }else{
                        $changeInstructorCount = 0;
                    }

                    //Check if the current course is cancelled by user ot not
                    $sql_cancel_student_record = "SELECT cc.stuCourseId FROM cancel_students cc WHERE cc.studentId = '$userId' AND cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

                    $cancelStudentCount = $this->db->query($sql_cancel_student_record)->num_rows();

                    //Check if the current course is assigned to multiple instructor
                    $sql_crs_ins_count = "SELECT ci.courseInsId FROM course_instructors ci WHERE ci.courseId = '$courseId' AND ci.level = '$courseLvl'";

                    //echo $sql_crs_ins_count;exit;

                    $courseInsCount = $this->db->query($sql_crs_ins_count)->num_rows();

                    //Check if the current course is cancelled by user ot not
                    $sql_cancel_crs_record = "SELECT cc.requestId FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

                    $cancelCourseCount = $this->db->query($sql_cancel_crs_record)->num_rows();

                    //Count no of session attended
                    $sql_check_attened_class = "SELECT sbc.classId  FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$userId' AND sbc.instructorId='$instructorId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP()";

                    //echo $sql_check_attened_class;exit;

                    $attendedClass = $this->db->query($sql_check_attened_class)->num_rows();
              ?>
                 
                <div class="dashboard-course-item <?=($instructorId != null ? ($instructorId == $instructor->userId?'':'d-none'):'')?>">
                    <input type="hidden" id="insName_<?=$instructor->userId?>" value="<?=$insName?>">
                    <input type="hidden" id="insPicSrc_<?=$instructor->userId?>" value="<?=$profilePic?>">
                    <input type="hidden" id="insBio_<?=$instructor->userId?>" value="<?=html_entity_decode($instructor->descriptions)?>">
                    
                    <?php if(!empty($reviewId)){ ?>
                        <input type="hidden" id="rating_<?=$reviewId?>" value="<?=$instructorData->rating?>">
                        <input type="hidden" id="feedback_<?=$reviewId?>" value="<?=html_entity_decode($instructorData->feedback)?>">
                    <?php } ?>

                      <?php if(!empty($conferenceId)){ ?>
                        <input type="hidden" id="meetingUrl_<?=$conferenceId?>" value="<?=$instructorData->meeting_url?>">
                        <input type="hidden" id="passCode_<?=$conferenceId?>" value="<?=html_entity_decode($instructorData->passcode)?>">
                    <?php } ?>
                        
                    <div class="dashboard-course-item__link" href="#">
                        <div class="dashboard-course-item__thumbnail">
                            <img src="<?=$profilePic?>" alt="instructors" width="260" height="160">
                        </div>
                        <div class="dashboard-course-item__content">
                           <?php if(!empty($avgRtingData->insAvgRating)){ ?> 
                                <div class="dashboard-course-item__rating">
                                    <div class="rating-star">
                                        <div class="rating-label" style="width: <?=(ceil($avgRtingData->insAvgRating)*20)?>%;"></div>
                                    </div>
                                </div>
                            <?php }else{ ?>    
                                <img src="<?= base_url('dist/images/no_review.png') ?>" style="width: 140px;padding-bottom: 10px;">
                            <?php } ?>    
                            <h3 class="dashboard-course-item__title"><?=$insName?></h3>
                            <div class="dashboard-course-item__meta">
                                <!--<ul class="dashboard-course-item__meta-list">
                                    <li>
                                        <span class="meta-label">Total Duration:</span>
                                        <span class="meta-value"><?=$instructor->totalHours?> Hours</span>
                                    </li>
                                    <li>
                                        <span class="meta-label">Chapters:</span>
                                        <span class="meta-value"><?=$instructor->totalChapter?> Chapters</span>
                                    </li>
                                </ul>-->
                            </div>
                            <div class="dashboard-course-item__progress-bar-wrap">
                               <?php if($changeInstructorCount == 0 && $cancelCourseCount == 0){ ?> 
                                     <div class="course_detail" id="show_ins_detail" data-uid="<?=$instructor->userId?>" onclick="showInsDetail(<?=$instructor->userId?>)">Instructor Detail</div>
                                    
                                     <div class="instructor_detail" id="show_ins_schedule" data-bs-toggle="tooltip" data-bs-placement="top" title="<?=($instructorId != null ? ($instructorId == $instructor->userId?'Update Your Schedule':'Book Your Schedule'):'Book Your Schedule')?>" data-bs-custom-class="color-tooltip" style="margin-left:5px;" data-cid="<?=$courseId?>" data-lvl="<?=$courseLvl?>" data-uid="<?=$instructor->userId?>"><i class="far fa-clock"></i>&nbsp;<?=($instructorId != null ? ($instructorId == $instructor->userId?'Update Schedule':'Book Schedule'):'Book Your Schedule')?>
                                     </div>

                                      <?php if(!empty($instructorId) && $attendedClass>=2){?>
                                        <div class="course_detail" id="add_course_review" data-bs-toggle="tooltip" data-bs-placement="top" title="<?=(!empty($reviewId)?'Update':'Add')?> review for this instructor" data-bs-custom-class="color-tooltip" style="margin-left:5px;" onclick="addCourseReview(<?=$instructor->userId?>,<?=$reviewId?>)"><i class="far fa-star"></i></div>
                                     <?php } ?>
                                     
                                     <?php if(!empty($instructorId) && $attendedClass>=2 && $courseInsCount>1){?>
                                        <div class="course_detail show_ins_detail" data-bs-toggle="modal" data-bs-target="#changeInstructorModal" data-backdrop="static" data-keyboard="false"  data-toggle="modal" style="margin-left:5px;" onclick="changeInstructor(<?=$instructor->userId?>)">Change Instructor</div>
                                     <?php } ?>    
                                     
                                     <?php if($conferenceId != null){?>    
                                        <div class="course_detail" id="display_conference_data" data-bs-toggle="tooltip" data-bs-placement="top" title="View your next session's conference detail" data-bs-custom-class="color-tooltip" style="margin-left:5px;" onclick="revealConferenceDetail(<?=$conferenceId?>)"><i class="far fa-link"></i></div>
                                     <?php } ?>
                                <?php 
                                    }else{
                                       if($cancelStudentCount>0 || $cancelCourseCount>0){ 
                                ?>
                                       <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong></strong> This course has been cancelled. You won't be able to perform any action until this dispute is resolved. Stay tuned!
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

             <?php } ?>
               
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showInsDetail">
    <div class="modal-dialog modal-dialog-centered modal-login">
        <div class="modal-wrapper">
            <button type="button" class="modal-close btn-close" data-bs-dismiss="modal"><i class="fal fa-times"></i></button>     
            <div class="modal-content model_req p-4">
                <div class="modal-body">
                    <div class="text-center mb-3" id="ins_profilePic">
                        <img src="http://localhost/elearning/uploads/users/6315a6458453e.jpg" alt="instructors" class="pop-user">
                    </div>
                    <h4 class="text-center mb-3"><span id="ins_name">Eugenia Talley</span></h4>
                    <div class="contentmodal" id="ins_detail">
                        
                    </div>
                </div>
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

<div class="modal fade" id="changeInstructorModal">
    <div class="modal-dialog modal-dialog-centered modal-login">
        <div class="modal-wrapper">
            <button type="button" class="modal-close btn-close" data-bs-dismiss="modal"><i class="fal fa-times"></i></button>     
            <div class="modal-content model_req">
                <div class="modal-header">
                    <h5 class="modal-title">Change Instructor</h5>
                    <p class="modal-description">Submit the form below to change your instructor</p>
                </div>
                <div class="modal-body">
                    <div class="overlayer" style="display: none;">
                        <div class="spinner"></div>
                    </div> 
                    <form id="change_course_instructor" method="post" onsubmit="return false;">
                        <input type="hidden" name="insId" id="chngIns_insId" value="">
                        <input type="hidden" name="courseId" id="chngIns_courseId" value="<?=$courseId?>">
                        <input type="hidden" name="courseLvl" id="chngIns_courseLvl" value="<?=$courseLvl?>">

                        <div class="modal-form">
                           <label class="form-label">Reason for Change:</label>
                           <select class="form-control" name="reasonId" required>
                              <option selected disabled>Please select a reson from below options</option>
                              <?php foreach($reasonList as $index => $reason) { ?>
                                <option value="<?=$reason->reasonId?>"><?=$reason->reason?></option>
                              <?php } ?>  
                           </select>
                        </div>

                        <div id="alert-msg"></div>
                        <div class="modal-form">
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

<script>
    function showInsDetail(instructorId){
        var insName = $("#insName_"+instructorId).val();
        var insPicSrc = $("#insPicSrc_"+instructorId).val();
        var insBio = $("#insBio_"+instructorId).val();

        var ins_Pic = '<img src="'+insPicSrc+'" alt="instructors" class="pop-user">';

        //Populating modal content before display modal
        $("#ins_name").text(insName);
        $("#ins_profilePic").html(ins_Pic);

        if(insBio.length>0){
            $("#ins_detail").text(insBio);
        }else{
            $("#ins_detail").html('No bio available for this instructor at this moment.');
        }    

        //Show modal
        $('#showInsDetail').modal('show');
    } 

    function changeInstructor(instructorId){
       $("#chngIns_insId").val(instructorId);
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

    //HANDLING SCHEDULE FORM
    $(document).on('submit', '#change_course_instructor', function(event){
         event.preventDefault();

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
          
          success:function(resposeData){//alert(resposeData);
              var data = JSON.parse(resposeData);
              $("#chnageInstructorModal").modal('hide');

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