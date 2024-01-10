
$(document).ready(function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});

 //Sweetalert function
 function alert_func(data) {
    swal({title: data[0], type: data[1], confirmButtonColor: data[2]});
 }

 function alert_response(data,redirectURL) {

   //swal({title: data[0], type: data[1], confirmButtonColor: data[2]});

    swal({
        title: data[0],
        type: data[1],
        confirmButtonColor: data[2]
    }, function() {
        window.location = redirectURL;
    });
}

$(document).on('click','#course_detail',function(){
   var courseId = $(this).data('cid');
   var courseLvl = $(this).data('lvl');

   window.location = baseUrl+'student/subjects/'+courseId+'/'+courseLvl;
});

$(document).on('click','#chapter_list',function(){
   var courseId = $(this).data('cid');
   var courseLvl = $(this).data('lvl');
   var subjectId = $(this).data('sid');

   window.location = baseUrl+'student/chapters/'+courseId+'/'+courseLvl+'/'+subjectId;
});

$(document).on('click','#subject_detail',function(){
   var courseId = $(this).data('cid');
   var courseLvl = $(this).data('lvl');
   var subjectId = $(this).data('sid');

   window.location = baseUrl+'student/subject-detail/'+courseId+'/'+courseLvl+'/'+subjectId;
});

$(document).on('click','#chapter_curriculum',function(){
   var courseId = $(this).data('cid');
   var courseLvl = $(this).data('lvl'); 
   var subjectId = $(this).data('sid'); 
   var chapterId = $(this).data('chpid');

   var redirectURL = baseUrl+'student/chapter-curriculum/'+courseId+'/'+courseLvl+'/'+subjectId+'/'+chapterId;
   window.location = redirectURL;
});

$(document).on('click','#instructor_detail',function(){
   var courseId = $(this).data('cid');
   var courseLvl = $(this).data('lvl');

   window.location = baseUrl+'student/instructor/'+courseId+'/'+courseLvl;
});

//Fetching chapter list under subject
$(document).on('click','.showLevelChapters',function(e){
     e.preventDefault();
     var courseId = $("#courseId").val();
     var courseLvl = $("#courseLvl").val();
     var subjectId = $(this).data('sid');

     getLevelChapters(courseId,courseLvl,subjectId);
});

//Show content more or less
function showMoreLess() {
   var dots = document.getElementById("dots");
   var moreText = document.getElementById("more");
   var btnText = document.getElementById("myBtn");

   if (dots.style.display === "none") {
     dots.style.display = "inline";
     btnText.innerHTML = "Read more"; 
     moreText.style.display = "none";
   } else {
     dots.style.display = "none";
     btnText.innerHTML = "Read less"; 
     moreText.style.display = "inline";
   }
}

//Function for fetching level details
function getLevelChapters(courseId,courseLvl,subjectId){

    //var courseLvl = $('.tab-content .active').attr('id'); 
    
    $.ajax({
         url: baseUrl+"student/getLevelChapters",
         type: 'post',
         dataType: 'html',
         data: {courseId:courseId,courseLvl:courseLvl,subjectId:subjectId},
    })

    .done(function(responseData) {
        var data = JSON.parse(responseData);
        //console.log(data);
        if(data.check = 'success'){
           //Appending chapter list on chapter list modal 
           $('#chapterList').html(data.lvlChapterHtml);
           $("#chaptereModal").modal('show');
        }
         
    })
    .fail(function(data) {
       //console.log(data);
    });
}

//Fetching chapter list under subject
$(document).on('click','.showMoreLess',function(e){
    e.preventDefault();

    var index = $(this).data('index');
    var state = $(this).data('state');
    
    if(state == "less"){
       $("#dots_"+index).css({'display':'none'});
       $(this).data('state','more');
       $(this).text("Read less");
       $("#more_"+index).css({'display':'inline'});
    }else{
       $("#dots_"+index).css({'display':'inline'});
       $(this).data('state','less');
       $(this).text("Read more");
       $("#more_"+index).css({'display':'none'});
    } 

    return false;
});

$(document).on('click','#show_ins_schedule',function(){
   var courseId = $(this).data('cid');
   var courseLvl = $(this).data('lvl');
   var insId = $(this).data('uid');

   window.location = baseUrl+'student/scheduleClass/'+courseId+'/'+courseLvl+'/'+insId;
});

$(document).on('click','#show_booked_schedule',function(){
   var courseId = $(this).data('cid');
   var courseLvl = $(this).data('lvl');
   var insId = $(this).data('uid');

   window.location = baseUrl+'student/viewbookedsession/'+courseId+'/'+courseLvl+'/'+insId;
});

$(document).on('click','.show-schedule-info',function(){
    //$("#scheduleModal").modal('show');
});

function clickChkBox(eventData){
         
     var scheduleFormData = {};
     //var eventData = chkbxEventData;

     var courseId = $('#courseId').val();
     var courseLvl = $('#courseLvl').val();
     var insId = $('#insId').val();

     var extendedObj = eventData.extendedProps;
     //console.log(extendedObj);

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
     
     if(checkedCurrentChkbx){

        if(extendedObj.classId != null){
            return false;
        }

        totalBookedSeason =  totalBookedSeason+seasonDiff;
        leftSeason = totalHours - totalBookedSeason;
        
        if(leftSeason >=-1){
            $('#totalBookedSeason').val(totalBookedSeason);
            $('#totalBookedSeason_span').text(totalBookedSeason);   

            $('#leftSeason_span').val(leftSeason);
        }else{
           alert_func(["You have exausted all your sessions,Please remove a session to book another.", "error", "#DD6B55"]);
           $("#"+extendedObj.checkboxId).prop('checked',false);
           return false; 
        }
     }else{

        if(extendedObj.classId == null){
            return false;
        }

        totalBookedSeason =  totalBookedSeason-seasonDiff;
        leftSeason = totalHours - totalBookedSeason;

        $('#totalBookedSeason').val(totalBookedSeason);
        $('#totalBookedSeason_span').text(totalBookedSeason);  

        $('#leftSeason_span').val(leftSeason);
        $('#leftSeason_span').text(leftSeason);
     }

     if(leftSeason == -1){
       $('#leftSeason_span').text(0);
     }else{
       $('#leftSeason_span').text(leftSeason);
     }  

     totalBookedSeason  = parseInt($('#totalBookedSeason').val()); 

     if(booking_status == "available" && modmodify_permission == true){

        if((totalHours - totalBookedSeason)>=-1){
        
            var scheduleFormData = {id:eventData.id,bookingStatus:true,courseId:courseId,courseLvl:courseLvl,insId:insId,classId:extendedObj.classId,classDate:extendedObj.classDate,classRawDate:extendedObj.classRawDate,classTime:extendedObj.classTime};
            manageStudentSessionData(scheduleFormData);
            
        }else{
           $("#"+extendedObj.checkboxId).prop('checked',false); 
           alert_func(["You have exausted all your sessions,Please remove a session to book another.", "error", "#DD6B55"]);
           return false; 
        }    

     }else{
         if(booking_status == "booked" && modmodify_permission == true){
              
            var checkedCurrentChkbx = $("#"+extendedObj.checkboxId).prop('checked');
            //console.log(checkedCurrentChkbx);

            if(!checkedCurrentChkbx){
                var scheduleFormData = {id:eventData.id,bookingStatus:false,courseId:courseId,courseLvl:courseLvl,insId:insId,classId:extendedObj.classId,classDate:extendedObj.classDate,classRawDate:extendedObj.classRawDate,classTime:extendedObj.classTime};
                manageStudentSessionData(scheduleFormData);
            }

         }else{
             alert_func(["Someone has already booked this season,Please book another date.", "error", "#DD6B55"]);
             return false;
         } 
     }

}

function manageStudentSessionData(scheduleFormData){
    
    var renderDate = scheduleFormData.classRawDate;

    if(scheduleFormData.bookingStatus == true){
        var alertText = "You are goining to book a class on "+scheduleFormData.classDate+" from "+scheduleFormData.classTime+".";
    }else{
        var alertText = "You are goining to remove a booked class on "+scheduleFormData.classDate+" from "+scheduleFormData.classTime+".";
    }

    swal({
      title: "Are you sure?",
      text: alertText,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Go ahead",
      closeOnConfirm: true
      },function (inputValue) {
         if (inputValue === true) { 
            $.ajax({
              url:baseUrl+'student/manageStudentSessionData',
              method:'POST',
              data: scheduleFormData,
              beforeSend: function() {
                 //$('.overlayer').fadeIn();
              },
              success:function(responseData){
                  var data = JSON.parse(responseData);
                  var sessionData = data.sessionData;
                  //console.log(data);

                  if(data.check == 'success'){
                      toastr.success(data.msg, 'Success', {timeOut: 2000,progressBar:true}); 

                      $("#totalHours").val(sessionData.totalHours);
                      $("#totalHours_span").text(sessionData.totalHours);
                      
                      $("#totalBookedSeason").val(sessionData.totalBookedSeason);
                      $("#totalBookedSeason_span").text(sessionData.totalBookedSeason);
                      
                      if(sessionData.leftSeason == -1){
                        $("#leftSeason_span").text(0);
                      }else{
                        $("#leftSeason_span").text(sessionData.leftSeason);
                      }
                  }
                  else if(data.check == 'warning'){
                      toastr.warning(data.msg, 'Notice', {timeOut: 2000,progressBar:true}); 
                  }else{
                      toastr.error(data.msg, 'Error', {timeOut: 2000,progressBar:true}); 
                  }
                  
                  $('.overlayer').fadeOut();

                  //Render calendar 
                  renderCalendar(renderDate,true);
               }
           });   
         }else{
           //Hiding tooltip
           $(".popover").hide();
           //Fetch calendar on alert cancel
           renderCalendar(renderDate,true);   
         }  
     });     
}

function bookedSessionData(){
    
    var paramDataObj = {courseId:courseId,courseLvl:courseLvl,insId:insId};

    $.ajax({
          url:baseUrl+'student/getStudentBookedSessionData',
          method:'POST',
          data: paramDataObj,
          success:function(responseData){
              var data = JSON.parse(responseData);
              console.log(data);

              $("#totalHours").val(data.totalHours);
              $("#totalHours_span").text(data.totalHours);
              
              $("#totalBookedSeason").val(data.totalBookedSeason);
              $("#totalBookedSeason_span").text(data.totalBookedSeason);
              
              if(data.leftSeason == -1){
                $("#leftSeason_span").text(0);
              }else{
                $("#leftSeason_span").text(data.leftSeason);
              }
          }
    });   
}

function renderCalendar(date,destroy){
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

        $(".popover").hide();

        var eventDataStr = JSON.stringify(eventData,null,2);

        //console.log(eventInfo);

        if(booking_status == "available" && modmodify_permission == true){
            //Craating custom event
            var appendHtml = '<input type="checkbox" class="chkbx" id="class_'+eventData.id+'">'+' <label>'+eventData.title+'</label>';
        }else{
           if(booking_status == "booked" && modmodify_permission == true){

              //$("#append_element").html('');
              //formIndex = 0; 
           
             //Craating custom event
             var appendHtml = '<input type="checkbox" class="chkbx" id="class_'+eventData.id+'" checked>'+' <label>'+eventData.title+'</label>';
           }else{
              //Craating custom event
              var appendHtml = eventData.title;
           }   
        }

        return {html:appendHtml}

      },
      eventDidMount: function (info) {
        
        var eventData = info.event;
        var extendedObj = eventData.extendedProps;

        var tooltipTitle = extendedObj.course;

        var toolTipContent = '';
        
        if(eventData.backgroundColor == "#fd6a03"){
           toolTipContent += '<b>Course Level:</b> '+extendedObj.courseLvl+'.<br>'; 
           toolTipContent += "<b>Date Status:</b> Available for update";
        }

        /*else if(eventData.backgroundColor == "#DB34A1"){
           toolTipContent = '<b>Course Level:</b> '+extendedObj.courseLvl+'.<br>'; 
           toolTipContent += "<b>Date Status:</b> Booked by you on but further removing this day from "+ 
                              "your schedule will result in unavailability of this day since "+
                              "the instructor has removed this day from their schedule so if you";
        }*/

        else if(eventData.backgroundColor == "#58ce16"){
           toolTipContent += '<b>Course Level:</b> '+extendedObj.courseLvl+'.<br>'; 
           toolTipContent += "<b>Date Status:</b> Booked by you in other course and not available for update from this schedule calendar.";
        }

        else if(eventData.backgroundColor == "#B6B40F"){
           toolTipContent += '<b>Course Level:</b> '+extendedObj.courseLvl+'.<br>'; 
           toolTipContent += "<b>Date Status:</b> Booked by you on past and not available for update currently.";
        }

        else if(eventData.backgroundColor == "#0071dc"){
           toolTipContent += '<b>Course Level:</b> '+extendedObj.courseLvl+'.<br>'; 
           toolTipContent += "<b>Date Status:</b> Booked by you in other course on past and not available for update currently.";
        }

        else if(eventData.backgroundColor == "#db5382"){
           toolTipContent += '<b>Course Level:</b> '+extendedObj.courseLvl+'.<br>'; 
           toolTipContent += "<b>Date Status:</b> Booked by other student and not available for booking currently.";
        }

        else if(eventData.backgroundColor == "#4bd863"){
           toolTipContent +='<b>Course Level:</b> '+extendedObj.courseLvl+'.<br>'; 
           toolTipContent += "<b>Date Status:</b> Available for booking currently.";
        }

        else if(eventData.backgroundColor == "#f71313"){
           tooltipTitle = 'Not booked by any student'; 
           toolTipContent += "<b>Date Status:</b> This day is expired and not available for booking currently.";
        }

        //console.log(tooltipTitle);

        $(info.el).popover({
            title: tooltipTitle,
            animation: true,
            html: true,
            delay: 300,
            placement: 'top',
            content: toolTipContent,
            trigger: 'hover',
            placement: 'top',
            container: 'body'
        });
      },
      datesSet: function (){
         //Your code here
      },
      dateClick: function(info) {
        //console.log('clicked on ' + info.dateStr);
      },
      eventClick: function (eventInfo, event, view) {
         var eventData = eventInfo.event;
         //console.log(eventData);
         clickChkBox(eventData);
      }
    });

    if(destroy){
        calendar.destroy();          
        calendar.gotoDate( date );
    }

    calendar.render(); 
     
}

$('body').on('click', 'button.fc-prev-button', function() {
    bookedSessionData();
});

$('body').on('click', 'button.fc-next-button', function() {
    bookedSessionData();
});
/*----Review Js----*/
