<?php
   $userId = $this->session->userdata('userId');

   //Checking if there is any change instructor request for this current instructor
    $sql_change_ins_record = "SELECT ci.queryId FROM change_instructor ci WHERE ci.studentId = '$userId' AND ci.courseId = '$courseId' AND ci.courseLvl = '$courseLvl' AND ci.instructorId = '$insId'";

    $changeInstructorCount = $this->db->query($sql_change_ins_record)->num_rows(); 

    //Check if the current course is cancelled by user ot not
    $sql_cancel_student_record = "SELECT cc.stuCourseId FROM cancel_students cc WHERE cc.studentId = '$userId' AND cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

    $cancelStudentCount = $this->db->query($sql_cancel_student_record)->num_rows();

    //Check if the current course is cancelled by user ot not
    $sql_cancel_crs_record = "SELECT cc.requestId FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

    $cancelCourseCount = $this->db->query($sql_cancel_crs_record)->num_rows();
?>
<style>
    .fc-list-event-time {
      display:none;
    }
</style>    
<div class="dashboard-content">
    <div class="container">
         <!--<h4 class="dashboard-title"><?=$title?></h4>
           <h5 style="text-align: center; margin: 20px 0;font-family:'Mada',sans-serif;font-weight:500;" >All timings are accoding to the Eastern Time Zone. U.S.A.</h5>-->
            
            <div class="row">
                <input type="hidden" name="insId" id="insId" value="<?=$insId?>">
                <input type="hidden" name="courseId" id="courseId" value="<?=$courseId?>">
                <input type="hidden" name="courseLvl" id="courseLvl" value="<?=$courseLvl?>">
                <!-- Profile Sidebar -->
                
                <!-- / Profile Sidebar -->
                
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        
                        <div class="overlayer" style="display: none;">
                           <div class="spinner"></div>
                        </div>

                        <div class="card-header">
                            <h4>Schedule Calendar of <?=$instructorName?></h4>
                        </div>
                        <?php if($changeInstructorCount == 0 && $cancelCourseCount == 0){ ?>      
                            <div class="card-body pt-0">
                                    <div class="fc-overflow">
                                        <div id="calendar" class="mt-4 mb-4"></div>
                                    </div>

                                     <div class="row booked-sesaon-detail">
                                      <input type="hidden" id="totalHours" value="<?=$totalHours?>">
                                      <input type="hidden" id="totalBookedSeason" value="<?=$totalBookedSeason?>">

                                       <div class="col-lg-1 col-md-1 col-sm-2 book-btn-div">
                                      </div>

                                      <div class="col-lg-3 col-md-3 col-sm-12 book-detail">
                                         <span class="meta-label"><label>Total Session:</label> <span id="totalHours_span"><?=$totalHours?></span> Hours</span>
                                      </div>

                                      <div class="col-lg-3 col-md-3 col-sm-12 book-detail">
                                         <span class="meta-label"><label>Booked Session:</label> <span id="totalBookedSeason_span"><?=$totalBookedSeason?></span> Hours</span>
                                      </div>

                                      <div class="col-lg-3 col-md-3 col-sm-12 book-detail">
                                         <span class="meta-label"><label> Session Left:</label> <span id="leftSeason_span"><?=($totalHours - $totalBookedSeason==-1?0:$totalHours - $totalBookedSeason)?></span> Hours</span>
                                      </div>

                                       <div class="col-lg-1 col-md-1 col-sm-12 booking-info">
                                          <span class="cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Check on any available date on calendar to book new class and uncheck if you wish to cancel any booked class on any date." data-bs-custom-class="color-tooltip">
                                             <i class="fa fa-question-circle" aria-hidden="true"></i>
                                          </span>   
                                       </div>
                                   </div> 
                                <?php 
                                    }else{
                                       if($cancelStudentCount>0 || $cancelCourseCount>0){ 
                                ?>
                                       <div class="alert alert-danger alert-dismissible mx-3 my-5 fade show" role="alert">
                                            <strong></strong> This course has been cancelled. You won't be able to perform any action until this dispute is resolved. Stay tuned!
                                       </div> 
                                <?php }else{ ?>
                                       <div class="alert alert-danger alert-dismissible mx-3 my-5 fade show" role="alert">
                                            <strong></strong> There is a change instructor request is in pending status. You won't be able to perform any action until this dispute is resolved. Stay tuned!
                                       </div> 
                                <?php } } ?>  
                        </div>
                    </div>
                </div>
            </div> 
       
        </div>
        <a id="back-to-top" href="#" class="btn btn-secondary btn-sm back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>
        </div>
        <!-- Page Header -->
        <!-- /Page Header -->
    </div>
</div>



<script>
  var leftSeason;
  var insId = $("#insId").val();
  var courseId = $("#courseId").val();
  var courseLvl = $("#courseLvl").val();
  var chkbxEventData;

  var eventUrl = baseUrl+'student/fetchschedule/'+courseId+'/'+courseLvl+'/'+insId;

  document.addEventListener('DOMContentLoaded', function() {
      var TodayDate = new Date();
      renderCalendar(TodayDate,false);
  });

  function timeDiff(fromTime, toTime) {

     var fromTimeCal = fromTime.split(/:/);

     fromTimeCal = fromTimeCal[0]*3600 + fromTimeCal[1]*60;

     var toTimeCal = toTime.split(/:/);   
     toTimeCal = toTimeCal[0]*3600 + toTimeCal[1]*60;

     var td = toTimeCal - fromTimeCal,
     hours = parseInt(td / 3600),
     minutes = parseInt( (td - hours*3600) / 60 ),
     timeDiff = ( (hours < 10 && hours >= 0) ? ('0' + hours) : hours ) + '.' + ( (minutes < 10 && minutes >= 0) ? ('0' + minutes) : minutes );

     return Math.round((timeDiff));  
  }

  //HANDLING BOOKING FORM
 /* $(document).on('submit', '#student_book_class', function(event){
     event.preventDefault();

     //Throwing ajax request in server 
     $.ajax({
          url:baseUrl+'student/bookClass',
          method:'POST',
          data: new FormData(this),
          contentType:false,
          processData:false,
          
          success:function(resposeData){//alert(resposeData);
              var data = JSON.parse(resposeData);

              if(data.check == 'success'){
                 $("#scheduleModal").modal('hide');
                 setTimeout(function(){
                    var redirectURL = window.location.href.split('#')[0];
                    alert_response(["Class has been booked successfully!", "success", "#A5DC86"],redirectURL);
                }, 100);
              }else{
                //$(".error_massage").removeClass("d-none");
                setTimeout(function(){
                    alert_func(["Something went wrong,Please try again", "error", "#DD6B55"]);
                }, 10);
              }
           }
      });    
  });

  $(document).on('submit', '#student_remove_booking', function(event){
     event.preventDefault();

     //Throwing ajax request in server 
     $.ajax({
          url:baseUrl+'student/removeClass',
          method:'POST',
          data: new FormData(this),
          contentType:false,
          processData:false,
          
          success:function(resposeData){//alert(resposeData);
              var data = JSON.parse(resposeData);

              if(data.check == 'success'){
                 $("#removeScheduleModal").modal('hide');
                 setTimeout(function(){
                    var redirectURL = window.location.href.split('#')[0];
                    alert_response(["Class has been removed successfully!", "success", "#A5DC86"],redirectURL);
                }, 100);
              }else{
                //$(".error_massage").removeClass("d-none");
                setTimeout(function(){
                    alert_func(["Something went wrong,Please try again", "error", "#DD6B55"]);
                }, 10);
              }
           }
      });    
  });*/

  //HANDLING CHECKOUT FORM
  $(document).on('submit', '#student_book_season', function(event){
     event.preventDefault();

     //Throwing ajax request in server 
     $.ajax({
          url:baseUrl+'student/bookStudentSeason',
          method:'POST',
          data: new FormData(this),
          contentType:false,
          processData:false,
          
          success:function(resposeData){//alert(resposeData);
              var data = JSON.parse(resposeData);

              if(data.check == 'success'){
                 $("#scheduleModal").modal('hide');
                 setTimeout(function(){
                    var redirectURL = window.location.href.split('#')[0];
                    alert_response(["Class has been booked successfully!", "success", "#A5DC86"],redirectURL);
                }, 100);
              }else{
                if(data.hasOwnProperty('msg')){
                    setTimeout(function(){
                        alert_func([data.msg, "error", "#DD6B55"]);
                    }, 10);
                }else{
                    setTimeout(function(){
                        alert_func(["Something went wrong,Please try again", "error", "#DD6B55"]);
                    }, 10);
                }
              }
           }
      });    
  });

</script>



