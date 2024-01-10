<?php
  /*print"<pre>";
  print_r($scheduleTime);
  print"</pre>";
  exit;*/

  $weekdayArr = explode(',',$scheduleTime->weekdays);
  $fromTime = substr($scheduleTime->fromTime,0,-3);
  $toTime = substr($scheduleTime->toTime,0,-3);

  if(!empty($this->session->userdata('colidedDates'))){
     $colidedDateArr = $this->session->userdata('colidedDates');
  }else{
     $colidedDateArr = array();
  }

  $colidedDayArr = explode(',',$this->session->userdata('colidedDays'));

  /*print"<pre>";
  print_r($colidedDateArr);
  print"</pre>";*/
?>
<div class="dashboard-content">
    <div class="container">
        <h4 class="dashboard-title"><?=$title?></h4>
        <div class="card">
            <div class="card-body">
                <form id="manage_schedule_time_form" method="post" onsubmit="return false;">
                     <?php if(!empty($colidedDateArr)){ ?>
                        <span class="py-2" style="color:red;">Red marked weekdays are to removed upon successful cancellation of the classes mentioned below. If you don't want to remove '<?=$this->session->userdata('colidedDays')?>' from schedule calendar then <a href="javascript:void(0);" id="resetCalendarData" style="color:#1f6ed5;">Click here</a></span>.
                    <?php } ?>    

                    <div class="selectdays weekdays mt-2 mb-3">
                        <label class="fw-bold">Select Week Days</label>
                        <ul>
                            <li style="<?=(in_array('Sunday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>">
                                <label><input type="checkbox" name="weekdays[]" value="Sunday" <?=(in_array('Sunday',$weekdayArr)?'checked':'')?>> Sunday</label>
                            </li>
                            
                            <li style="<?=(in_array('Monday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>">
                                <label><input type="checkbox" name="weekdays[]" value="Monday" <?=(in_array('Monday',$weekdayArr)?'checked':'')?> style="<?=(in_array('Monday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>"> Monday
                                </label>
                            </li>

                            <li style="<?=(in_array('Tuesday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>">
                                <label><input type="checkbox" name="weekdays[]" value="Tuesday" <?=(in_array('Tuesday',$weekdayArr)?'checked':'')?> style="<?=(in_array('Tuesday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>"> Tuesday
                                </label>
                            </li>

                            <li style="<?=(in_array('Wednesday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>">
                                <label><input type="checkbox" name="weekdays[]" value="Wednesday" <?=(in_array('Wednesday',$weekdayArr)?'checked':'')?>> Wednesday
                                </label>
                            </li>

                            <li style="<?=(in_array('Thursday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>">
                                <label>
                                    <input type="checkbox" name="weekdays[]" value="Thursday" <?=(in_array('Thursday',$weekdayArr)?'checked':'')?> style="<?=(in_array('Thursday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>"> Thursday
                                </label>
                            </li>
                            
                            <li style="<?=(in_array('Friday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>">
                                <label><input type="checkbox" name="weekdays[]" value="Friday" <?=(in_array('Friday',$weekdayArr)?'checked':'')?> style="<?=(in_array('Friday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>"> Friday
                                </label>
                            </li>

                            <li style="<?=(in_array('Saturday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>">
                                <label><input type="checkbox" name="weekdays[]" value="Saturday" <?=(in_array('Saturday',$weekdayArr)?'checked':'')?> style="<?=(in_array('Saturday',$colidedDayArr)?'background:#f93636;color: #fff;':'')?>"> Saturday
                                </label>
                            </li>
                        </ul>
                    </div>

                    <div class="row justify-content-bottom row1 mb-3 mt-2">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="fw-bold">Time From</label>
                                <input type="text" class="form-control border-primary fromTime" id="fromTime"  name="scheduleTime[fromTime]" data-type="fromTime" value="<?=$fromTime?>" readonly required>
                                <input type="hidden" id="lastFromTime" name="lastFromTime" value="<?=$fromTime?>">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="fw-bold">Time To</label>
                                <input type="text" class="form-control border border-primary toTime" id="toTime" name="scheduleTime[toTime]" data-type="toTime" value="<?=$toTime?>" readonly required>
                                <input type="hidden" id="lastToTime" name="lastToTime" value="<?=$toTime?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 mt-3 text-center">
                    	<div class="col-md-10 mt-2">
                            <div><button type="submit" class="btn btn-success">Submit</button></div>
                        </div> 
                    </div>	
                </form> 
            </div>
         </div>

         <div class="card mt-3" id="collided_dates_container">
            <div class="card-body" id="collided_dates_div">
            <?php if(!empty($colidedDateArr)){ ?> 
                <table class="table table-bordered">
                    <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Day</th>
                      <th scope="col">Coruse Name</th>
                      <th scope="col">Student Name</th>
                      <th scope="col">Coruse Level</th>
                      <th scope="col">Date</th>
                      <th scope="col">Time</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" style="text-align:center;">
                                <span style="color:#000;">Following dates are booked by some students. Please cancel all the classes by clicking the cancel class button to remove '<?=$this->session->userdata('colidedDays')?>' from your scheule calendar.</span>
                            </td>
                        </tr>   
                        <?php foreach($colidedDateArr as $index => $date){ ?>   
                            <tr>
                              <td scope="row"><?=$index+1?></td>
                              <td><?=$date['day']?></td>
                              <td><?=$date['courseName']?></td>
                              <td><?=$date['studentName']?></td>
                              <td><?=$date['courseLvl']?></td>
                              <td><?=date('jS F, Y',strtotime($date['date']))?></td>
                              <td>
                                 <strong>From</strong>&nbsp;
                                    <?=date('g:i A',strtotime($date['fromTime']))?>&nbsp;
                                 <strong>To</strong>&nbsp;
                                    <?=date('g:i A',strtotime($date['toTime']))?>
                              </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="7" style="text-align:center;">
                                <button class="btn btn-danger" id="cancelBulkClasses">Cancel Classes</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align:center;">
                                <span style="color:#000;">Else you can cancel your desried classes manually from your schedule calendar.</span>
                            </td>
                        </tr>   
                    </tbody>
                </table>
             <?php } ?>
            </div>
         </div>       
      </div>
   </div>
</div>

  <script>
   
    //HANDLING SCHEDULE FORM
	$(document).on('submit', '#manage_schedule_time_form', function(event){
	     event.preventDefault();

         var fromTime = $("#fromTime").val();
         var toTime = $("#toTime").val();

         if(!fromTime.length>0 && !toTime.length>0){
            alert_func(["Form time and To time can't remain empty!", "error", "#DD6B55"]);
            return false;
         }

         else if(!fromTime.length>0){
            alert_func(["Form time can't remain empty!", "error", "#DD6B55"]);
            return false;
         }

         else if(!toTime.length>0){
            alert_func(["To time and can't remain empty!", "error", "#DD6B55"]);
            return false;
         }

         else if(fromTime>toTime){
            alert_func(["From time can't be greater than To time!", "error", "#DD6B55"]);
            return false;
         }

	  	 //Throwing ajax request in server 
	  	 $.ajax({
	      url:baseUrl+'instructor/saveSchedule',
	      method:'POST',
	      data: new FormData(this),
	      contentType:false,
	      processData:false,
	      
	      success:function(resposeData){//alert(resposeData);
	          var data = JSON.parse(resposeData);
              
              if(data.check == 'success'){
                 if(data.hasOwnProperty('tableHtml')){ 
                    $("#collided_dates_div").html(data.tableHtml);
                    $("#collided_dates_container").removeClass('d-none');
                 }

                 setTimeout(function(){
                    swal({
                       title: "Success!",
                       text: "Schedule time data saved successfully!",
                       type: "success"
                    }, function() {
                        location.reload();
                    });
                 }, 10);
              }else{
                //$(".error_massage").removeClass("d-none");
                setTimeout(function(){
                    alert_func(["Something went wrong;Please try again.", "error", "#DD6B55"]);
                }, 10);
              }
	      }
	 	});    
	 });

    //HANDLING Bulk Class Cancel Data
    $(document).on('click', '#cancelBulkClasses', function(event){
         
          swal({
            title: "Are you sure?",
            text: "Classes will be removed parmanently and can't be recovered later.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Go ahead",
            closeOnConfirm: true
            }, function () {
              //Throwing ajax request in server 
              $.ajax({
                  url:baseUrl+'instructor/cancelBulkClasses',
                  method:'POST',

                  success:function(resposeData){
                      var data = JSON.parse(resposeData);
                      
                      if(data.check == 'success'){
                         var redirectURL = window.location.href.split('#')[0];
                         setTimeout(function(){
                             alert_response(["Classes have been cancelled successfully!", "success", "#A5DC86"],redirectURL);
                         }, 10);
                      }else{
                        //$(".error_massage").removeClass("d-none");
                        setTimeout(function(){
                            alert_func(["Something went wrong;Please try again.", "error", "#DD6B55"]);
                        }, 10);
                      }
                  }
                });  
            });  

    });

    //HANDLING Bulk Class Cancel Data
    $(document).on('click', '#resetCalendarData', function(event){
         
          swal({
            title: "Are you sure?",
            text: "Calendar modification data will be removed parmanently from session.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Go ahead",
            closeOnConfirm: true
            }, function () {
              //Throwing ajax request in server 
              $.ajax({
                  url:baseUrl+'instructor/resetCalendarData',
                  method:'POST',

                  success:function(resposeData){
                      var data = JSON.parse(resposeData);
                      
                      if(data.check == 'success'){
                        setTimeout(function(){
                             var redirectURL = window.location.href.split('#')[0];
                             setTimeout(function(){
                                 alert_response(["Calendar modification data was successfully removed.", "success", "#A5DC86"],redirectURL);
                             }, 10);
                        }, 10);
                      }else{
                        //$(".error_massage").removeClass("d-none");
                        setTimeout(function(){
                            alert_func(["Something went wrong, Please try again.", "error", "#DD6B55"]);
                        }, 10);
                      }
                  }
                });  
            });  

    });
</script>

