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
                        <div class="card-header">
                            <h4>Schedule Calendar of <?=$instructorName?></h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="fc-overflow">
                                <div id="calendar" class="mt-4 mb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> 

            <div class="row booked-sesaon-detail">
              <input type="hidden" id="totalHours" value="<?=$totalHours?>">
              <input type="hidden" id="totalBookedSeason" value="<?=$totalBookedSeason?>">

              <div class="col-lg-3 col-md-3 col-sm-12 book-detail">
                 <span class="meta-label"><label>Total Course Session:</label> <span id="totalHours_span"><?=$totalHours?></span> Hours</span>
              </div>

              <div class="col-lg-3 col-md-3 col-sm-12 book-detail">
                 <span class="meta-label"><label>Booked Course Session:</label> <span id="totalBookedSeason_span"><?=$totalBookedSeason?></span> Hours</span>
              </div>

              <div class="col-lg-3 col-md-3 col-sm-12 book-detail">
                 <span class="meta-label"><label>Course Session Left:</label> <span id="leftSeason_span"><?=($totalHours - $totalBookedSeason==-1?0:$totalHours - $totalBookedSeason)?></span> Hours</span>
              </div>

               <div class="col-lg-2 col-md-2 col-sm-12 book-btn-div">
                 <form id="student_book_season" method="post" onsubmit="return false;">
                     <input type="hidden" name="courseId" value="<?=$courseId?>">
                     <input type="hidden" name="courseLvl" value="<?=$courseLvl?>">
                     <input type="hidden" name="insId" value="<?=$insId?>">
                     <div id="append_element"></div>
                     <button type="submit" id="save_season_data" class="btn btn-primary book-btn">Book Session</button>
                 </form>
              </div>

               <div class="col-lg-1 col-md-1 col-sm-12 booking-info">
                  <span class="cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Check date from calendar and click on Book Schedule button." data-bs-custom-class="color-tooltip">
                     <i class="fa fa-question-circle" aria-hidden="true"></i>
                  </span>   
               </div>
           </div> 
       
        </div>
        <a id="back-to-top" href="#" class="btn btn-secondary btn-sm back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>
        </div>
        <!-- Page Header -->
        <!-- /Page Header -->
    </div>
</div>

<!--<div class="modal fade classBookModal" id="scheduleModal" aria-labelledby="scheduleModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <form id="student_book_class" method="post" onsubmit="return false;">  
          <input type="hidden" id="bookClass_studentId_input" name="studentId" value="<?=$this->session->userdata('userId')?>">
          <input type="hidden" id="bookClass_courseId_input" name="courseId" value="<?=$courseId?>">
          <input type="hidden" id="bookClass_courseLvl_input" name="courseLvl" value="<?=$courseLvl?>">
          <input type="hidden" id="bookClass_insId_input" name="insId" value="<?=$insId?>">
          <input type="hidden" id="bookClass_classDate_input" name="classDate">
          <input type="hidden" id="bookClass_classTime_input" name="classTime">
      
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Booking Class</h5>
            <button type="button" class="modalclose" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          </div>
          
          <div class="modal-body" id="chapterList">
            <div class="courserlistBlock" style="text-align:center;">
                <h5 class="text-success booked" style="display: none;"><i class="fas fa-check"></i>This Schedule Has Already Booked</h5>

                <h5 class="text-warning" style="">Are You Sure Want To Book This Class</h5>
                <div class="pt-3 schedule-detail">
                    <p><label>Course Name:</label> <span id="bookClass_courseName">Test Course</span></p>
                    <p><label>Course Level:</label> <span id="bookClass_courseLevel">Beginner</span></p>
                    <p><label>Instrctor Name:</label> <span id="bookClass_instructorName">Test Instrctor</span></p>

                    <p><label>Class Date:</label> <span id="bookClass_classDate">14/09/2022</span></p>
                    <p><label>Class Time:</label> <span id="bookClass_classTime">5:00 AM-7:00 AM</span></p>
                </div>    
              </div>
           </div>

           <div class="modal-footer justify-content-center">
              <button type="submit" class="btn btn-success save-event submit-btn">Book Class</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
           </div>

       </form>
    </div>
  </div>
</div> 

<div class="modal fade classBookModal" id="removeScheduleModal" aria-labelledby="removeScheduleModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <form id="student_remove_booking" method="post" onsubmit="return false;">  
          <input type="hidden" id="removeBooking_studentId_input" name="studentId" value="<?=$this->session->userdata('userId')?>">
          <input type="hidden" id="removeBooking_courseId_input" name="courseId" value="<?=$courseId?>">
          <input type="hidden" id="removeBooking_courseLvl_input" name="courseLvl" value="<?=$courseLvl?>">
          <input type="hidden" id="removeBooking_insId_input" name="insId" value="<?=$insId?>">
          <input type="hidden" id="removeBooking_classDate_input" name="classDate">
          <input type="hidden" id="removeBooking_classTime_input" name="classTime">
          <input type="hidden" id="removeBooking_bookingId_input" name="bookingId">
      
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Booking Class</h5>
            <button type="button" class="modalclose" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
          </div>
          
          <div class="modal-body" id="chapterList">
            <div class="courserlistBlock" style="text-align:center;">

                <h5 class="text-danger" style="">Are You Sure Want To Delete This Class</h5>
                <div class="pt-3 schedule-detail">
                    <p><label>Course Name:</label> <span id="removeBooking_courseName">Test Course</span></p>
                    <p><label>Course Level:</label> <span id="removeBooking_courseLevel">Beginner</span></p>
                    <p><label>Instrctor Name:</label> <span id="removeBooking_instructorName">Test Instrctor</span></p>

                    <p><label>Class Date:</label> <span id="removeBooking_classDate">14/09/2022</span></p>
                    <p><label>Class Time:</label> <span id="removeBooking_classTime">5:00 AM-7:00 AM</span></p>
                    <p><label>Booking Id:</label> <span id="removeBooking_bookingId">elearningBooked1</span></p>
                </div>    
              </div>
           </div>

           <div class="modal-footer justify-content-center">
              <button type="submit" class="btn btn-danger save-event submit-btn">Delete Class</button>
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
           </div>

       </form>
    </div>
  </div>
</div> -->


<script>
  var formIndex = 0;  
  var leftSeason;
  var insId = $("#insId").val();
  var courseId = $("#courseId").val();
  var courseLvl = $("#courseLvl").val();
  var chkbxEventData;

  var eventUrl = baseUrl+'student/fetchschedule/'+courseId+'/'+courseLvl+'/'+insId;

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },

      customButtons: {
          prev: {
            text: 'Prev',
            click: function() {
               calendar.prev();
            }
          },
          next: {
            text: 'Next',
            click: function() {
               calendar.next();
            }
          }
       },    
      //initialDate: '2022-08-12',
      initialDate: new Date(),
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: true,
      selectable: true,
      allDay: false,
      height: 600,
      displayEventTime : true,
      events: eventUrl,
      eventContent: function (eventInfo, element, view) {   
        var eventData = eventInfo.event;
        var extendedObj = eventData.extendedProps;
        var booking_status = extendedObj.booking_status;
        var modmodify_permission = extendedObj.modify_permission;

        //console.log(eventInfo);

        var formElemets='';

        if(booking_status == "available" && modmodify_permission == true){
          
            //Craating custom event
            appendHtml = '<input type="checkbox" class="chkbx" id="class_'+eventData.id+'" onclick="clickChkBx()">'+' <label>'+eventData.title+'</label>';
        }else{
             if(booking_status == "booked" && modmodify_permission == true){

                //$("#append_element").html('');
                //formIndex = 0; 
               
                //Craating custom event
                appendHtml = '<input type="checkbox" class="chkbx" id="class_'+eventData.id+'" checked onclick="clickChkBx()">'+' <label>'+eventData.title+'</label>';
               
                //Creating student sesaon booking form elements
                if(extendedObj.classId != null){
                   
                   formElemets += '<input type="hidden" id="classDate_'+eventData.id+'" name="classData['+formIndex+'][classDate]" value="'+extendedObj.classDate+'">';
                   
                   formElemets += '<input type="hidden" id="classTime_'+eventData.id+'" name="classData['+formIndex+'][classTime]" value="'+extendedObj.classTime+'">';

                   formElemets += '<input type="hidden" id="classAvail_'+eventData.id+'" name="classData['+formIndex+'][classAvail]" value="booked">';

                   formElemets += '<input type="hidden" id="classID_'+eventData.id+'" name="classData['+formIndex+'][classId]" value="'+extendedObj.classId+'">';
                   
                   $("#append_element").append(formElemets);
                   $("#save_season_data").text("Update Session");

                   formIndex++;
                   formElemets = '';
                }
             }else{
                //Craating custom event
                appendHtml = eventData.title;
             }   
        }

        return {html:appendHtml}

      },
      dateClick: function(info) {
        //console.log('clicked on ' + info.dateStr);
      },
      eventClick: function (eventInfo, event, view) {
         var eventData = eventInfo.event;

         //console.log(eventData);

         chkbxEventData = eventData;

         /*var extendedObj = eventData.extendedProps;
         //console.log(extendedObj);

         var formElemets='';
         var booking_status = extendedObj.booking_status;
         var modmodify_permission = extendedObj.modify_permission;
         //Calculate booked and left season 
         var totalHours = parseInt($('#totalHours').val());
         var totalBookedSeason  = parseInt($('#totalBookedSeason').val());

         var fromTime = extendedObj.fromTime;
         var toTime = extendedObj.toTime;
         var seasonDiff = parseInt(timeDiff(fromTime,toTime));
         //console.log(seasonDiff);

         var checkedCurrentChkbx = $("#"+extendedObj.checkboxId).prop('checked');
         //console.log(checkedCurrentChkbx);

         $("#"+extendedObj.checkboxId).change(function(e){

             e.preventDefault();
            
             var isChecked = $(this).is(":checked");

             leftSeason = totalHours - totalBookedSeason;

             console.log(leftSeason);
             
             if(isChecked){
                
                if(leftSeason >=-1){
                    totalBookedSeason =  totalBookedSeason+seasonDiff;

                    leftSeason = totalHours - totalBookedSeason;

                    if(leftSeason == -1){
                       $('#leftSeason_span').text(0);
                    }else{
                       $('#leftSeason_span').text(leftSeason);
                    }  

                    $('#totalBookedSeason').val(totalBookedSeason);
                    $('#totalBookedSeason_span').text(totalBookedSeason);   
                }else{
                   alert_func(["You have exausted all your sessions,Please remove a session to book another.", "error", "#DD6B55"]);
                   $(this).prop('checked',false);
                   return false; 
                }
             }else{

                totalBookedSeason =  totalBookedSeason-seasonDiff;

                leftSeason = totalHours - totalBookedSeason;
                
                $('#leftSeason_span').val(leftSeason);
                $('#totalBookedSeason_span').text(totalBookedSeason);  
                $('#leftSeason_span').text(leftSeason);
             }
         });

         totalBookedSeason  = parseInt($('#totalBookedSeason').val()); 

         if(booking_status == "available" && modmodify_permission == true){

            if((totalHours - totalBookedSeason)>0){
            
                if(checkedCurrentChkbx){
                    
                     formElemets += '<input type="hidden" id="classDate_'+eventData.id+'" name="classData['+formIndex+'][classDate]" value="'+extendedObj.classDate+'">';
                       
                     formElemets += '<input type="hidden" id="classTime_'+eventData.id+'" name="classData['+formIndex+'][classTime]" value="'+extendedObj.classTime+'">';

                     formElemets += '<input type="hidden" id="classAvail_'+eventData.id+'" name="classData['+formIndex+'][classAvail]" value="booked">';

                     formElemets += '<input type="hidden" id="classID_'+eventData.id+'" name="classData['+formIndex+'][classId]" value="null">';

                     $("#append_element").append(formElemets);

                     formIndex++;

                }else{
                    
                    $('#classDate_'+eventData.id).remove();
                    $('#classTime_'+eventData.id).remove();
                    $('#classAvail_'+eventData.id).remove();
                    $('#classID_'+eventData.id).remove();
                    
                    if(formIndex != 0){
                        formIndex--;
                    }    
                }
            }else{
               $(this).prop('checked',false); 
               alert_func(["You have exausted all your sessions,Please remove a session to book another.", "error", "#DD6B55"]);
               return false; 
            }    

         }else{
             if(booking_status == "booked" && modmodify_permission == true){
                  
                var checkedCurrentChkbx = $("#"+extendedObj.checkboxId).prop('checked');
                //console.log(checkedCurrentChkbx);

                if(checkedCurrentChkbx){
                    $('#classAvail_'+eventData.id).val('booked');

                }else{
                    $('#classAvail_'+eventData.id).val('freed');
                }

             }else{
                 alert_func(["Someone has already booked this season,Please book another date.", "error", "#DD6B55"]);
                 return false;
             } 
         }

         /*if(booking_status == "available" && modmodify_permission == true){
             $('#bookClass_courseName').text(extendedObj.course);
             $('#bookClass_courseLevel').text(extendedObj.courseLvl);
             $('#bookClass_instructorName').text(extendedObj.instructor);
             
             $('#bookClass_classDate').text(extendedObj.classDate);
             $('#bookClass_classDate_input').val(extendedObj.classDate);

             $('#bookClass_classTime').text(extendedObj.classTime);
             $('#bookClass_classTime_input').val(extendedObj.classTime);

             $('#scheduleModal').modal('show');
         }else{
             if(booking_status == "booked" && modmodify_permission == true){
                  $('#removeBooking_courseName').text(extendedObj.course);
                  $('#removeBooking_courseLevel').text(extendedObj.courseLvl);
                  $('#removeBooking_instructorName').text(extendedObj.instructor);
                 
                  $('#removeBooking_classDate').text(extendedObj.classDate);
                  $('#removeBooking_classDate_input').val(extendedObj.classDate);

                  $('#removeBooking_classTime').text(extendedObj.classTime);
                  $('#removeBooking_classTime_input').val(extendedObj.classTime);
                  
                  $('#removeBooking_bookingId').text(extendedObj.bookingId);
                  $('#removeBooking_bookingId_input').val(extendedObj.bookingId);

                  $('#removeScheduleModal').modal('show');  
             }else{
                 alert_func(["Someone has already booked this season,Please book another date.", "error", "#DD6B55"]);
                 return false;
             }    
         }*/
      }
    });

    calendar.render();
    setTimeout(function(){
        //addCheckboxInEvent();
    },1000);
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



