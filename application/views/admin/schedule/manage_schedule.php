<?php
  /*print"<pre>";
  print_r($scheduleTime);
  print"</pre>";
  exit;*/

  $weekdayArr = explode(',',$scheduleTime->weekdays);
  $fromTime = substr($scheduleTime->fromTime,0,-3);
  $toTime = substr($scheduleTime->toTime,0,-3);
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('faq/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
            </ol>
        </div>
        
        <div class="row">   
            <div class="col-xl-12 col-lg-12">
              <div class="card">
                <div class="card-body">
                    <form id="manage_schedule_time_form" method="post" onsubmit="return false;">
                          
                        <div class="selectdays weekdays mt-2 mb-3">
                            <label class="fw-bold">Select Week Days</label>
                            <ul>
                                <li><label><input type="checkbox" name="weekdays[]" value="Sunday" <?=(in_array('Sunday',$weekdayArr)?'checked':'')?>> Sunday</label></li>
                                <li><label><input type="checkbox" name="weekdays[]" value="Monday" <?=(in_array('Monday',$weekdayArr)?'checked':'')?>> Monday</label></li>
                                <li><label><input type="checkbox" name="weekdays[]" value="Tuesday" <?=(in_array('Tuesday',$weekdayArr)?'checked':'')?>> Tuesday</label></li>
                                <li><label><input type="checkbox" name="weekdays[]" value="Wednesday" <?=(in_array('Wednesday',$weekdayArr)?'checked':'')?>> Wednesday</label></li>
                                <li><label><input type="checkbox" name="weekdays[]" value="Thursday" <?=(in_array('Thursday',$weekdayArr)?'checked':'')?>> Thursday</label></li>
                                <li><label><input type="checkbox" name="weekdays[]" value="Friday" <?=(in_array('Friday',$weekdayArr)?'checked':'')?>> Friday</label></li>
                                <li><label><input type="checkbox" name="weekdays[]" value="Saturday" <?=(in_array('Saturday',$weekdayArr)?'checked':'')?>> Saturday</label></li>
                            </ul>
                        </div>

                        <input type="hidden" name="instructorId" value="<?=$instructorId?>">

                        <div class="row justify-content-bottom row1 mb-3 mt-2">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="fw-bold">Time From</label>
                                    <input type="text" class="form-control border-primary fromTime" id="fromTime"  name="scheduleTime[fromTime]" data-type="fromTime" value="<?=$fromTime?>" readonly required>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="fw-bold">Time To</label>
                                    <input type="text" class="form-control border border-primary toTime" id="toTime" name="scheduleTime[toTime]" data-type="toTime" value="<?=$toTime?>" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3 text-center">
                        	<div class="col-md-10 mt-2">
                                <div>
                                    <button type="submit" class="btn btn-rounded btn-info">Submit</button>

                                     <a class="btn btn-rounded btn-secondary" href="<?= admin_url('instructors/lists') ?>">
                                        Back
                                    </a>
                                </div>
                                
                            </div> 
                        </div>	
                    </form>
                </div>
              </div>
            </div>
        </div>
     </div>
  </div>


  <script>
   
    //HANDLING CHECKOUT FORM
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

	  	 //Throwing ajax request in server 
	  	 $.ajax({
	      url:adminUrl+'instructors/saveSchedule',
	      method:'POST',
	      data: new FormData(this),
	      contentType:false,
	      processData:false,
	      
	      success:function(resposeData){//alert(resposeData);
	          var data = JSON.parse(resposeData);

              if(data.check == 'success'){
                 setTimeout(function(){
                    alert_func(["Schedule time data saved successfully!", "success", "#A5DC86"]);
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
</script>

