$(document).ready(function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    //Datatable initialization
    var table = $('#example').DataTable({
        createdRow: function ( row, data, index ) {
           $(row).addClass('selected')
        } 
    });
      
    table.on('click', 'tbody tr', function() {
        var $row = table.row(this).nodes().to$();
        var hasClass = $row.hasClass('selected');
        if (hasClass) {
            $row.removeClass('selected')
        } else {
            $row.addClass('selected')
        }
    });
    
    table.rows().every(function() {
        this.nodes().to$().removeClass('selected')
    });

    tinyMCE.init({
        selector: 'textarea.tinymce',
        height: 250,
        plugins: "link image media code",
        toolbar: 'undo redo | styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | '+
                 'outdent indent | media | link image | code',
        setup : function(ed){
             ed.on('NodeChange', function(e){
                 tinyMCE.triggerSave();
                 $("#" + ed.id).valid();
                 //console.log('the event object ' + e);
                 //console.log('the editor object ' + ed);
                 //console.log('the content ' + ed.getContent());
             });
        }
    });

    tinyMCE.init({
        selector: 'textarea.tinymceReadonly',
        height: 250,
        readonly:true,
        setup: function(ed) {
            if($('#'+ed.id).attr('readonly')){
                //console.log(ed);
            }
        }
    });

});

// validate the comment form when it is submitted
validator = $(".needs-validation").validate({
  errorPlacement: function(label, element) {
    label.addClass('mt-2 text-danger');
    label.insertAfter(element);
  },
  highlight: function(element, errorClass) {
    $(element).parent().addClass('has-danger')
    $(element).addClass('form-control-danger')
  },
  ignore: ''
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

/*
//Function to adjust session gap on manage schedule page
function modifyMinutes(timeString, addMinutes,type) {
    if (!timeString.match(/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/)){
        return null;
    }
    var timeSplit = timeString.split(':');
    var hours = parseInt(timeSplit[0]);
    var minutes = parseInt(timeSplit[1]);

    var totalMinutes = hours*60 + minutes;

    if(type == "add"){
       var totalTimeInMin = parseInt(totalMinutes + parseInt(addMinutes)); 
    }else{
       var totalTimeInMin = parseInt(totalMinutes - parseInt(addMinutes));
    }
    
    var modifiedHours = Math.floor(totalTimeInMin / 60);
  
    while (hours >= 24) {
        hours -= 24;
    }
    
    var modifiedMinutes = totalTimeInMin % 60;

    return (modifiedHours + ':' + (modifiedMinutes == 0 ? '00':modifiedMinutes));
}

function timeDiff(fromTime, toTime) {

     var fromTimeCal = fromTime.split(/:/);
     fromTimeCal = fromTimeCal[0]*3600 + fromTimeCal[1]*60;

     var toTimeCal = toTime.split(/:/);   
     toTimeCal = toTimeCal[0]*3600 + toTimeCal[1]*60;

    var td = toTimeCal - fromTimeCal,
    hours = parseInt(td / 3600),
    minutes = parseInt( (td - hours*3600) / 60 ),
    timeDiff = ( (hours < 10 && hours >= 0) ? ('0' + hours) : hours ) + ':' + ( (minutes < 10 && minutes >= 0) ? ('0' + minutes) : minutes );

    return timeDiff;  
}

//Defining schedule timepicker method   
$('.scheduleTime').timepicker({
    formatTime: 'hh:mm TT',
    showButtonPanel: true,
    // stepHour: 2,
    stepMinute: 15,
    // stepSecond: 10,
    onSelect: function(timeText, inst) {
        //console.log(addOnMinutes);

        var type = $(this).data('type');

        if(type == "fromTime"){
           var rtype = "toTime";
        }else{
           var rtype = "fromTime";
        }

        var fromTime = $("#fromTime").val();
        var toTime = $("#toTime").val();

        var lastToTime = $("#lastToTime").val();
        var lastFromTime = $("#lastFromTime").val();

        var fromTimeSec = fromTime.split(/:/);
        fromTimeSec = fromTimeSec[0]*3600 + fromTimeSec[1]*60;

        var toTimeSec = toTime.split(/:/);   
        toTimeSec = toTimeSec[0]*3600 + toTimeSec[1]*60;

        var lastToTimeSec = lastToTime.split(/:/);
        lastToTimeSec = lastToTimeSec[0]*3600 + lastToTimeSec[1]*60;

        var lastFromTimeSec = fromTime.split(/:/);   
        lastFromTimeSec = lastFromTimeSec[0]*3600 + lastFromTimeSec[1]*60;


        if(fromTime.length>0 && toTime.length>0 && toTimeSec>fromTimeSec){
            var sessionDiff = timeDiff(fromTime,toTime).split(':');

            if(type == "fromTime"){
                
                if(sessionDiff[1]>0){
                   if(fromTimeSec>lastFromTimeSec){
                      var fromTimeDiff = timeDiff(lastFromTime,fromTime).split(':');
                      var addOnMinutes= modifyMinutes(toTime,fromTimeDiff[1],'add');
                      $("#lastFromTime").val(fromTime);
                   }else{
                      var fromTimeDiff = timeDiff(fromTime,lastFromTime).split(':');
                      //console.log(toTimeDiff);
                      var addOnMinutes= modifyMinutes(toTime,fromTimeDiff[1],'remove');
                      $("#lastFromTime").val(fromTime);
                   } 
                }else{
                    $("#lastFromTime").val(fromTime);
                    return true;
                } 

            }else{
               
                if(sessionDiff[1]>0){

                   if(toTimeSec>lastToTimeSec){
                      var toTimeDiff = timeDiff(lastToTime,toTime).split(':');
                      var addOnMinutes= modifyMinutes(fromTime,sessionDiff[1],'add');
                      $("#lastToTime").val(toTime);
                   }else{
                      var toTimeDiff = timeDiff(toTime,lastToTime).split(':');
                      //console.log(toTimeDiff);
                      var addOnMinutes= modifyMinutes(fromTime,toTimeDiff[1],'remove');
                      $("#lastToTime").val(toTime);
                   } 
                }else{
                    $("#lastToTime").val(toTime);
                    return true;
                }
            }

        }

        else if(fromTime.length>0 && toTime.length>0 && fromTimeSec>toTimeSec){
           if(type == "fromTime"){
             var addOnMinutes= modifyMinutes(timeText,60,'add');
             $("#lastFromTime").val(fromTime);
             $("#lastToTime").val(addOnMinutes);
           }else{
             var addOnMinutes= modifyMinutes(timeText,60,'remove');
             $("#lastFromTime").val(addOnMinutes);
             $("#lastToTime").val(toTime);
           } 
        }

        else if(fromTime.length>0 && toTime.length>0 && fromTimeSec == toTimeSec){
           if(type == "fromTime"){
             var addOnMinutes= modifyMinutes(timeText,60,'add');
             $("#lastFromTime").val(fromTime);
             $("#lastToTime").val(addOnMinutes);
           }else{
             var addOnMinutes= modifyMinutes(timeText,60,'remove');
             $("#lastFromTime").val(addOnMinutes);
             $("#lastToTime").val(toTime);
           } 
        }

        
        if(type == "fromTime"){
            $("#toTime").val(addOnMinutes);
            $("#toTime").timepicker('destroy'); 

            $("#toTime").timepicker({
                formatTime: 'HH:00',
                showButtonPanel: true,
                minTime: addOnMinutes,
                showMinute:true,
                stepMinute: 15
            });
        }else{
            $("#fromTime").timepicker('destroy'); 
            $("#fromTime").val(addOnMinutes);

            $("#fromTime").timepicker({
                formatTime: 'HH:00',
                showButtonPanel: true,
                minTime: addOnMinutes,
                showMinute:true,
                stepMinute: 15
            }); 
        }    
    }
});*/

function addMinutes(timeString, addMinutes) {
    if (!timeString.match(/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/))
        return null;
    var timeSplit = timeString.split(':');
    var hours = parseInt(timeSplit[0]);

    var minutes = parseInt(timeSplit[1]) + parseInt(addMinutes);

    hours += Math.floor(minutes / 60);
    while (hours >= 24) {
        hours -= 24;
    }
    minutes = minutes % 60;

    return ('0' + hours).slice(-2) + ':' + ('0' +minutes).slice(-2);
}

$('.fromTime').timepicker({
    formatTime: 'hh:mm TT',
    showButtonPanel: true,
    // stepHour: 2,
    stepMinute: 15,
    // stepSecond: 10,
    onSelect: function(timeText, inst) {
        $("#ui-datepicker-div").css({'top':'462px!important','left':'32px!important'});

        var addOnMinutes= addMinutes(timeText,'60');

        $('#toTime').timepicker('destroy'); 

        $('#toTime').val(addOnMinutes);
        $('#toTime').timepicker({
            formatTime: 'HH:00',
            showButtonPanel: true,
            minTime: addOnMinutes,
            showButtonPanel: true,
            showMinute:false,
            // stepHour: 2,
            // stepMinute: 15,
            //maxTime: json['cenvertedTime'],
            onSelect: function(timeText, inst) {
               // slotInterVal(timeText);
            }
        });
    }
});

$('.toTime').timepicker({
    formatTime: 'hh:mm TT',
    showButtonPanel: true,
    minTime: $('#toTime').val(),
    showMinute:false,
});

/*$('#cv').on('change', function() {
   myfile= $( this ).val();
   var ext = myfile.split('.').pop();
   if(ext=="pdf" || ext=="docx" || ext=="doc"){
       return true;
   } else{
       alert("Only Docx or Doc files are allowed!");
       $( this ).val('');
       return false;
   }
});*/

$(document).on('click','#view_student_schedule',function(){
   var courseId = $(this).data('cid');
   var courseLvl = $(this).data('clvl');
   var studentId = $(this).data('sid');

   window.location = baseUrl+'instructor/showstudentschedule/'+courseId+'/'+courseLvl+'/'+studentId;
});

//Course validation
/*function validateCourseForm(){

    //var currentTabId = $('.tab-content .active').attr('id');

    //Validation on intermediate level
    var subject_lvl_beginner = $("#subject_lvl_beginner").val();
    var chapter_lvl_beginner = $("#chapter_lvl_beginner").val();
    var insId_lvl_beginner = $("#insId_lvl_beginner").val();
    
    var lvl_dsiply_status_beginner = $("#lvl_dsiply_status_beginner").val();

    if(lvl_dsiply_status_beginner == 1 || subject_lvl_beginner.length>0 || chapter_lvl_beginner.length>0 || insId_lvl_beginner.length>0){
        if(!lvl_dsiply_status_beginner.length>0 || !subject_lvl_beginner.length > 0 || !chapter_lvl_beginner.length > 0 || !insId_lvl_beginner.length > 0){
            
            var errHtml = '<div class="alert alert-warning" role="alert">Beginner level data is incomplete!</div>';

            $("#lvl_dsiply_status_beginner").prop('required',true);
            $("#subject_lvl_beginner").prop('required',true);
            $("#chapter_lvl_beginner").prop('required',true);
            $("#insId_lvl_beginner").prop('required',true);
            $("#descriptions_beginner").prop('required',true);

            $('.nav-tabs button[data-bs-target="#beginner"]').tab('show');
            $("#courseLvl").val("beginner");
            
            setTimeout(function(){
                validator.element("#subject_lvl_beginner");
                validator.element("#chapter_lvl_beginner");
                validator.element("#insId_lvl_beginner");
                validator.element("#descriptions_beginner");
            },1000);

            $("#form_error").html(errHtml);
            
            setTimeout(function(){
               document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
            },1000);
            
            return false;
        }
    }else{
        if(lvl_dsiply_status_beginner == 0){
           $("#lvl_dsiply_status_beginner").prop('required',false);
           $("#subject_lvl_beginner").prop('required',false);
           $("#chapter_lvl_beginner").prop('required',false);
           $("#insId_lvl_beginner").prop('required',false);
           $("#descriptions_beginner").prop('required',false);

           $("#form_error").html('');
        }  
    }
    
    //Validation on intermediate level
    var subject_lvl_inter = $("#subject_lvl_intermediate").val();
    var chapter_lvl_inter = $("#chapter_lvl_intermediate").val();
    var insId_lvl_inter = $("#insId_lvl_intermediate").val();
    
    var lvl_dsiply_status_inter = $("#lvl_dsiply_status_intermediate").val();

    
    if(lvl_dsiply_status_inter == 1 || subject_lvl_inter.length>0 || chapter_lvl_inter.length>0 || insId_lvl_inter.length>0){
        if(!lvl_dsiply_status_inter.length>0 || !subject_lvl_inter.length > 0 || !chapter_lvl_inter.length > 0 || !insId_lvl_inter.length > 0){

            var errHtml = '<div class="alert alert-warning" role="alert">Intermediate level data is incomplete!</div>';
            
            $("#lvl_dsiply_status_intermediate").prop('required',true);
            $("#subject_lvl_intermediate").prop('required',true);
            $("#chapter_lvl_intermediate").prop('required',true);
            $("#insId_lvl_intermediate").prop('required',true);
            
            $('.nav-tabs button[data-bs-target="#intermediate"]').tab('show');
            $("#courseLvl").val("intermediate");

            setTimeout(function(){
                validator.element("#subject_lvl_intermediate");
                validator.element("#chapter_lvl_intermediate");
                validator.element("#insId_lvl_intermediate");
            },1000);
            
            $("#form_error").html(errHtml);

             setTimeout(function(){
               document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
            },1000);
            
            return false;
        }
    }else{
        if(lvl_dsiply_status_inter == 0){
           $("#lvl_dsiply_status_intermediate").prop('required',false);
           $("#subject_lvl_intermediate").prop('required',false);
           $("#chapter_lvl_intermediate").prop('required',false);
           $("#insId_lvl_intermediate").prop('required',false);

           $("#form_error").html('');
        }  
    }

    //Validation on advanced level
    var subject_lvl_advanced = $("#subject_lvl_advanced").val();
    var chapter_lvl_advanced = $("#chapter_lvl_advanced").val();
    var insId_lvl_advanced = $("#insId_lvl_advanced").val();

    var lvl_dsiply_status_advanced = $("#lvl_dsiply_status_advanced").val();
    
    if(lvl_dsiply_status_advanced == 1 || subject_lvl_advanced.length>0 || chapter_lvl_advanced.length>0 || insId_lvl_advanced.length>0){
        if(!lvl_dsiply_status_advanced.length>0 || !subject_lvl_advanced.length > 0 || !chapter_lvl_advanced.length > 0 || !insId_lvl_advanced.length > 0){
            
            var errHtml = '<div class="alert alert-warning" role="alert">Advanced level data is incomplete!</div>';

            $("#lvl_dsiply_status_advanced").prop('required',true);
            $("#subject_lvl_advanced").prop('required',true);
            $("#chapter_lvl_advanced").prop('required',true);
            $("#insId_lvl_advanced").prop('required',true);

            $('.nav-tabs button[data-bs-target="#advanced"]').tab('show');
            $("#courseLvl").val("advanced");

            setTimeout(function(){
                validator.element("#subject_lvl_advanced");
                validator.element("#chapter_lvl_advanced");
                validator.element("#insId_lvl_advanced");
            },1000);    

            $("#form_error").html(errHtml);
            
             setTimeout(function(){
               document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
            },1000);

            return false;
        }
    }else{
        if(lvl_dsiply_status_advanced == 0){
            $("#lvl_dsiply_status_advanced").prop('required',false);
            $("#subject_lvl_advanced").prop('required',false);
            $("#chapter_lvl_advanced").prop('required',false);
            $("#insId_lvl_advanced").prop('required',false);

            $("#form_error").html('');
        }  
    }

    if(lvl_dsiply_status_beginner == 0 && lvl_dsiply_status_inter == 0 && lvl_dsiply_status_advanced == 0){
         var courseId = $("#courseId").val();

         if(courseId){
            var alertText = "You have to choose at leset one level to update the course!";
         }else{
            var alertText = "You have to choose at leset one level to create a course!";
         }
         var errHtml = '<div class="alert alert-danger" role="alert">'+alertText+'</div>';
         $("#form_error").html(errHtml);
         document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
         return false;
    }else{
        $("#form_error").html('');
    }

    return true;
}*/

$(document).on("change",".test",function () {
    $(this).valid();
});

/*$("input[type='file']").on("change",function () {
    $(this).valid();
    //Check file extension
    var ext = $(this).val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg','doc','docx']) == -1) {
        alert('invalid extension!');
        $(this).val('');
        return false;
    }
    //Check file size
    var fileSize = this.files[0].size;
    if(fileSize>2097152){
        alert("File size can't be more than 2MB.");
        $(this).val('');
        return false;
    }
});*/

/*$(document).on("change","#lvl_dsiply_status_beginner",function(e){
      e.preventDefault();

      var lvl_display_status = $(this).val();

      if(lvl_display_status == 0){
           $("#lvl_dsiply_status_beginner").prop('required',false);
           $("#subject_lvl_beginner").prop('required',false);
           $("#chapter_lvl_beginner").prop('required',false);
           $("#insId_lvl_beginner").prop('required',false);
           $("#descriptions_beginner").prop('required',false);

           $("label.error").hide();
           $(".error").removeClass("error");

           $("#form_error").html('');

           changeSelect();
           return false;
      }
});  

$(document).on("change","#lvl_dsiply_status_intermediate",function(e){
      e.preventDefault();

      var lvl_display_status = $(this).val();

      if(lvl_display_status == 0){
            $("#lvl_dsiply_status_intermediate").prop('required',false);
            $("#subject_lvl_intermediate").prop('required',false);
            $("#chapter_lvl_intermediate").prop('required',false);
            $("#insId_lvl_intermediate").prop('required',false);

            $("label.error").hide();
            $(".error").removeClass("error");

           $("#form_error").html('');

           changeSelect();
           return false;
      }
}); 

$(document).on("change","#lvl_dsiply_status_advanced",function(e){
      e.preventDefault();

      var lvl_display_status = $(this).val();

      if(lvl_display_status == 0){
         $("#lvl_dsiply_status_advanced").prop('required',false);
         $("#subject_lvl_advanced").prop('required',false);
         $("#chapter_lvl_advanced").prop('required',false);
         $("#insId_lvl_advanced").prop('required',false);

         $("label.error").hide();
         $(".error").removeClass("error");

         $("#form_error").html('');

         changeSelect();
         return false;
      }
}); 

//HANDLING CHECKOUT FORM
$(document).on('submit', '#manage_course_form', function(event){
     event.preventDefault();
     
     var courseValidation = validateCourseForm();

     if(!courseValidation){
        console.log(courseValidation);
        return false;
     }else{   

         var courseId = $("#courseId").val();

         if(courseId){
            var form_type = 'update';
            var ajaxController = baseUrl+'instructor/course/update';
         }else{
            var form_type = 'create';
            var ajaxController = baseUrl+'instructor/course/create';
         }
         
         //Throwing ajax request in server 
         $.ajax({
          url:ajaxController,
          method:'POST',
          data: new FormData(this),
          contentType:false,
          processData:false,
          beforeSend: function() {
             
          },
          success:function(resposeData){
             var data = JSON.parse(resposeData);
             //console.log(data);
             if(data.check == 'success'){
               var responseArr = [data.msg,'success','#A5DC86'];
               //var redirectURL = baseUrl+'instructor/course/update'+data.courseId; 
               var redirectURL = baseUrl+'instructor/my-created-course/';
               alert_response(responseArr,redirectURL);
               return true; 
             }else{
                var responseArr = [data.msg,'error','#DD6B55'];
                //var redirectURL = adminUrl+'course/edit/'+data.courseId;  
                alert_func(responseArr);
                return false;
             }
          }
        });

      }         
 });*/



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

        var eventDataStr = JSON.stringify(eventData,null,2);
        
        if(extendedObj.modify_permission == true){
            var appendHtml = '<input type="checkbox" class="chkbx" id="class_'+eventData.id+'" checked>'+' <label>'+eventData.title+'</label>';
        }else{
            var appendHtml = '<label>'+eventData.title+'</label>';
        }

        //appendHtml = eventData.title;
        return {html:appendHtml}

      },
     eventDidMount: function (info) {
        
        var eventData = info.event;
        var extendedObj = eventData.extendedProps;
        
        if(extendedObj.expiry_status == true && extendedObj.booking_status == "booked"){
            var tooltip_title = 'This class is expired';
            var tooltip_content = '<b>Student Name:</b> '+extendedObj.student+'. <br><b>Course Name:</b> '+extendedObj.courseName+'. <br><b>Course Level:</b> '+extendedObj.courseLvl+'.';
        }

        else if(extendedObj.expiry_status == true && extendedObj.booking_status == "expired"){
            var tooltip_title = 'This Date is expired';  
            var tooltip_content = 'No class data is available';      
        } 

        else if(extendedObj.expiry_status == false && extendedObj.booking_status != 'available'){
            var tooltip_title = 'Upcoming class';
            var tooltip_content = '<b>Student Name:</b> '+extendedObj.student+'. <br><b>Course Name:</b> '+extendedObj.courseName+'. <br><b>Course Level:</b> '+extendedObj.courseLvl+'.';
        }

        else if(extendedObj.expiry_status == false && extendedObj.booking_status == 'available'){
            var tooltip_title = 'Not booked yet!';
            var tooltip_content = 'No class data is available';   
        }   

        $(info.el).popover({
            title: tooltip_title,
            animation: true,
            html: true,
            delay: 300,
            content: tooltip_content,
            trigger: 'hover',
            placement: 'top',
            container: 'body'
        });
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

function clickChkBox(eventData){
     
  var scheduleFormData = {};
  //var eventData = chkbxEventData;

  var extendedObj = eventData.extendedProps;
  //console.log(extendedObj);
   
  var checkedCurrentChkbx = $("#"+extendedObj.checkboxId).prop('checked');

  if(!checkedCurrentChkbx && extendedObj.modify_permission == true){
    var scheduleFormData = {id:eventData.id,bookingStatus:false,classId:extendedObj.classId,classDate:extendedObj.classDate};
    manageStudentSessionData(scheduleFormData);
  }
}

function manageStudentSessionData(scheduleFormData){

    var renderDate = scheduleFormData.classDate;

    swal({
      title: "Are you sure?",
      text: "Class will be removed parmanently and can't be recovered later.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Go ahead",
      closeOnConfirm: true
      },function (inputValue) {
          if (inputValue === true) {
            $.ajax({
              url:baseUrl+'instructor/cancelStudentClass',
              method:'POST',
              data: scheduleFormData,
              beforeSend: function() {
                 $('.overlay').fadeIn();
              },
              success:function(responseData){
                  var data = JSON.parse(responseData);
                  var sessionData = data.sessionData;
                  //console.log(data);

                  if(data.check == 'success'){
                     toastr.success(data.msg, 'Success', {timeOut: 2000,progressBar:true}); 
                  }else{
                     toastr.error(data.msg, 'Error', {timeOut: 2000,progressBar:true}); 
                  }
                  
                  $('.overlay').fadeOut();
                  //Render calendar
                  renderCalendar(renderDate,true);

                  $(".popover").hide();
                  return true;
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