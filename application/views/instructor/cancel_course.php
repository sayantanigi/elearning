<?php 
    $refundDataFound = false;
    foreach ($courseLvlArr as $key => $level) {
        if(in_array($level,$cancelLevelArr)){
           $refundDataFound = true; 
        }
    }
    //print_r($studentBeginnerRefundData);
?>
<div class="dashboard-content">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url('instructor/my-created-course')?>">Course</a></li>
          <li class="breadcrumb-item active" aria-current="page">Cancel Course Level Wise</li>
        </ol>
      </nav>    

      <form class="form-horizontal needs-validation" id="cancel_course_form" method="post" onsubmit="return false;">
        <div class="row"> 

           <div class="col-md-12 mt-3">
            <div class="overlayer" style="display: none;">
               <div class="spinner"></div>
            </div>   
            
            <div class="dashboard-content-box">
                   <h4 class="dashboard-content-box__title">'<?=$courseDetails->courseName?>' Level Cancel Data</h4>
                    <div class="row gy-4" id="courseLvl_Detail">
                       <div class="col-md-12">
                         <input type="hidden" name="courseId" id="courseId" value="<?=$courseDetails->courseId?>">

                         <div id="form_error"></div>
                         
                         <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <?php if(in_array('beginner',$courseLvlArr)){ ?> 
                              <li class="nav-item" role="presentation">
                                <button class="nav-link click_on_tab <?=(in_array('beginner',$courseLvlArr)?'active':'')?>" id="beginner-tab" data-bs-toggle="tab" data-bs-target="#beginner" data-lvl="beginner" type="button" role="tab" aria-controls="beginner" aria-selected="true">Beginner Level</button>
                              </li>
                            <?php } ?>    
                            
                            <?php if(in_array('intermediate',$courseLvlArr)){ ?>  
                              <li class="nav-item" role="presentation">
                                <button class="nav-link click_on_tab <?=((!in_array('beginner',$courseLvlArr) && in_array('intermediate',$courseLvlArr))?'active':'')?>" id="intermediate-tab" data-bs-toggle="tab" data-bs-target="#intermediate" data-lvl="intermediate" type="button" role="tab" aria-controls="intermediate" aria-selected="false">Intermediate Level</button>
                              </li>
                            <?php } ?>  

                            <?php if(in_array('advanced',$courseLvlArr)){ ?> 
                              <li class="nav-item" role="presentation">
                                <button class="nav-link click_on_tab <?=((!in_array('beginner',$courseLvlArr) && !in_array('intermediate',$courseLvlArr) && in_array('intermediate',$courseLvlArr))?'active':'')?>" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" data-lvl="advanced" type="button" role="tab" aria-controls="advanced" aria-selected="false">Advanced Level</button>
                              </li>
                            <?php } ?>  
                        </ul>
                        
                        <div class="tab-content" id="myTabContent">
                            
                             <?php if(in_array('beginner',$courseLvlArr)){ ?> 
                               <div class="tab-pane fade show active" id="beginner" role="tabpanel" aria-labelledby="home-tab">
                                <?php if(!in_array('beginner',$cancelLevelArr)){ ?>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                               <label class="form-label-02">Delete Course Level<span style="color:red;"> *</span></label> 
                                               <select class="form-control" name="cancel_status_beginner" id="cancel_status_beginner">
                                                    <option selected disabled>Please select if you want to cancel this level</option>
                                                    <option value="1">Yes (All students under beginner level will be cancelled and refunded)</option>
                                                    <option value="0" selected>No (No effect will be applied to beginner level)</option>
                                                </select>
                                            </div>
                                        </div>
                                <?php }else{ ?> 
                                     <div class="alert alert-danger mt-2" role="alert">
                                        This level has been cancelled.
                                     </div>
                                <?php } ?>             

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                      <?php if(!in_array('beginner',$cancelLevelArr)){ ?>  
                                          <div class="alert alert-warning" role="alert">
                                           Please select Yes if you want to cancel beginner level of this course. Refund calculation is provided below. 
                                         </div>
                                      <?php } ?>     
                                   
                                   <label class="form-label-02">Students purchased this course level:</label>  
                                   <?php if(!in_array('beginner',$cancelLevelArr) && !empty($studentBeginnerRefundData)){ ?> 
                                       <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                          <th scope="col" class="text-center">#</th>
                                          <th scope="col" class="text-center">Course Name</th>
                                          <th scope="col" class="text-center">Student Name</th>
                                          <th scope="col" class="text-center">Session</th>
                                          <th scope="col" class="text-center">Course Cost</th>
                                          <th scope="col" class="text-center">Amount Calculation</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            
                                            <?php foreach($studentBeginnerRefundData as $index => $refund){ ?>  
                                                <tr>
                                                  <td scope="row"><?=$index+1?></td>
                                                  <td><?=$refund['courseName']?> (<?=$refund['level']?>) </td>
                                                  <td><?=$refund['studentName']?></td>
                                                  <td>
                                                    Course Session: <?=$refund['courseSession']?> Hours<br>
                                                    Exhausted Session: <?=$refund['bookedSession']?> Hours
                                                  </td>
                                                  <td>$<?=$refund['courseCost']?> </td>
                                                   <td>
                                                    Deduction Amount: $<?=$refund['deductionAmount']?><br>
                                                    Refund Amount: $<?=$refund['refundAmount']?>
                                                  </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                       </table>
                                   <?php 
                                       }else{
                                          if(empty($studentBeginnerRefundData)){ 
                                   ?>    
                                        <div class="alert alert-danger" role="alert">
                                           No students have purchased beginner level of '<?=$courseDetails->courseName?>' yet!
                                         </div>
                                   <?php }} ?>      
                                    
                                    <?php if(!in_array('beginner',$cancelLevelArr)){ ?>  
                                        <div class="row gy-4">
                                           <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Cancel Reason<span style="color:red;"> *</span></label>
                                                <textarea class="form-control tinymce" name="beginner_cancel_reason" id="beginner_cancel_reason" placeholder="Describe your reason for cancel course for beginner level..."></textarea>
                                            </div>
                                        </div>
                                      </div>             
                                    <?php } ?>
                                 </div>   
                                </div> 
                               </div>
                             <?php } ?>  
                             
                             <?php if(in_array('intermediate',$courseLvlArr)){ ?> 
                                <div class="tab-pane fade <?=(!in_array('beginner',$courseLvlArr)?'show active':'')?>" id="intermediate" role="tabpanel" aria-labelledby="profile-tab">
                                <?php if(!in_array('intermediate',$cancelLevelArr)){ ?>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                           <label class="form-label-02">Delete Course Level<span style="color:red;"> *</span></label> 
                                           <select class="form-control" name="cancel_status_inter" id="cancel_status_inter">
                                                <option selected disabled>Please select if you want to cancel this level</option>
                                                <option value="1">Yes (All students under intermediate level will be cancelled and refunded)</option>
                                                <option value="0" selected>No (No effect will be applied to intermediate level)</option>
                                            </select>
                                        </div>
                                    </div>

                                <?php }else{ ?> 
                                     <div class="alert alert-danger mt-2" role="alert">
                                        This level has been cancelled.
                                     </div>
                                <?php } ?>      
                                      
                                <div class="row mt-4">
                                  <div class="col-md-12">
                                    <?php if(!in_array('intermediate',$cancelLevelArr)){ ?>
                                        <div class="alert alert-warning" role="alert">
                                            Please select Yes if you want to cancel intermediate level of this course. Refund calculation is provided below. 
                                         </div>
                                    <?php } ?>     
                                   
                                   <label class="form-label-02">Students purchased this course level:</label>  
                                    <?php if(!in_array('intermediate',$cancelLevelArr) && !empty($studentInterRefundData)){ ?>  
                                       <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                          <th scope="col" class="text-center">#</th>
                                          <th scope="col" class="text-center">Course Name</th>
                                          <th scope="col" class="text-center">Student Name</th>
                                          <th scope="col" class="text-center">Session</th>
                                          <th scope="col" class="text-center">Course Cost</th>
                                          <th scope="col" class="text-center">Amount Calculation</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            
                                            <?php foreach($studentInterRefundData as $index => $refund){ ?>  
                                                <tr>
                                                  <td scope="row"><?=$index+1?></td>
                                                  <td><?=$refund['courseName']?> (<?=$refund['level']?>) </td>
                                                  <td><?=$refund['studentName']?></td>
                                                  <td>
                                                    Course Session: <?=$refund['courseSession']?> Hours<br>
                                                    Exhausted Session: <?=$refund['bookedSession']?> Hours
                                                  </td>
                                                  <td>$<?=$refund['courseCost']?> </td>
                                                   <td>
                                                    Deduction Amount: $<?=$refund['deductionAmount']?><br>
                                                    Refund Amount: $<?=$refund['refundAmount']?>
                                                  </td>
                                                </tr>
                                            <?php } ?>
                                         </tbody>
                                       </table>

                                      <?php 
                                           }else{
                                              if(empty($studentInterRefundData)){ 
                                       ?>    
                                            <div class="alert alert-danger" role="alert">
                                               No students have purchased intermediate level of '<?=$courseDetails->courseName?>' yet!
                                             </div>
                                       <?php }} ?>  
                                       
                                       <label class="form-label-02">Cancel Reason<span style="color:red;"> *</span></label>
                                       <?php if(!in_array('intermediate',$cancelLevelArr)){ ?> 
                                           <div class="row gy-4">
                                               <div class="col-md-12">
                                                <div class="dashboard-content__input">
                                                    <textarea class="form-control tinymce" name="inter_cancel_reason" id="inter_cancel_reason" placeholder="Describe your reason for cancel course for intermediate level..."></textarea>
                                                </div>
                                            </div>
                                          </div>             
                                       <?php } ?>    

                                    </div> 
                                 </div>
                                
                                </div> 
                            <?php } ?>    
                             
                             <?php if(in_array('advanced',$courseLvlArr)){ ?> 
                                 <div class="tab-pane fade <?=((!in_array('beginner',$courseLvlArr) && !in_array('intermediate',$courseLvlArr))?'show active':'')?>" id="advanced" role="tabpanel" aria-labelledby="contact-tab">
                                    
                                    <?php if(!in_array('advanced',$cancelLevelArr)){ ?>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                               <label class="form-label-02">Delete Course Level<span style="color:red;"> *</span></label> 
                                               <select class="form-control" name="cancel_status_advanced" id="cancel_status_advanced">
                                                    <option selected disabled>Please select if you want to cancel this level</option>
                                                    <option value="1">Yes (All students under advanced level will be cancelled and refunded)</option>
                                                    <option value="0" selected>No (No effect will be applied to advanced level)</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }else{ ?> 
                                         <div class="alert alert-danger mt-2" role="alert">
                                            This level has been cancelled.
                                         </div>
                                    <?php } ?>         

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <?php if(!in_array('advanced',$cancelLevelArr)){ ?>
                                              <div class="alert alert-warning" role="alert">
                                               Please select Yes if you want to cancel advanced level of this course. Refund calculation is provided below. 
                                             </div>
                                            <?php } ?>     
                                            
                                            <?php if(!in_array('advanced',$cancelLevelArr) && !empty($studentAdvancedRefundData)){ ?>
                                               <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                  <th scope="col" class="text-center">#</th>
                                                  <th scope="col" class="text-center">Course Name</th>
                                                  <th scope="col" class="text-center">Student Name</th>
                                                  <th scope="col" class="text-center">Session</th>
                                                  <th scope="col" class="text-center">Course Cost</th>
                                                  <th scope="col" class="text-center">Amount Calculation</th>
                                                </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    
                                                    <?php foreach($studentAdvancedRefundData as $index => $refund){ ?>  
                                                        <tr>
                                                          <td scope="row"><?=$index+1?></td>
                                                          <td><?=$refund['courseName']?> (<?=$refund['level']?>) </td>
                                                          <td><?=$refund['studentName']?></td>
                                                          <td>
                                                            Course Session: <?=$refund['courseSession']?> Hours<br>
                                                            Exhausted Session: <?=$refund['bookedSession']?> Hours
                                                          </td>
                                                          <td>$<?=$refund['courseCost']?> </td>
                                                           <td>
                                                            Deduction Amount: $<?=$refund['deductionAmount']?><br>
                                                            Refund Amount: $<?=$refund['refundAmount']?>
                                                          </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                               </table>
                                            <?php 
                                               }else{
                                                  if(empty($studentAdvancedRefundData)){ 
                                           ?>    
                                                <div class="alert alert-danger" role="alert">
                                                   No students have purchased intermediate level of '<?=$courseDetails->courseName?>' yet!
                                                 </div>
                                           <?php }} ?>  
                                            
                                            <label class="form-label-02">Cancel Reason<span style="color:red;"> *</span></label>
                                            <?php if(!in_array('advanced',$cancelLevelArr)){ ?>
                                                <div class="row gy-4">
                                                   <div class="col-md-12">
                                                    <div class="dashboard-content__input">
                                                        <textarea class="form-control tinymce" name="advanced_cancel_reason" id="advanced_cancel_reason" placeholder="Describe your reason for cancel course for advanced level..." required></textarea>
                                                    </div>
                                                </div>
                                              </div>             
                                            <?php } ?>    
                                        </div> 
                                    </div>
                                </div>
                            <?php } ?>    
                        </div>  
                    </div>
                </div> 
            </div>

            <div class="col-lg-12">
                <div class="dashboard-settings__btn">
                    <button type="submit" class="btn btn-primary btn-hover-secondary" id="submitCancelCourse">Submit Request</button>
                    <a href="<?=base_url('instructor/my-created-course')?>"><button type="button" class="btn btn-danger btn-hover-danger">Cancel</button></a>
                </div>     
            </div>
        </div>
      </div>
   </form>
  </div>      

  <script type="text/javascript">

    $(document).ready(function () {
       //Your required code here 
    });

    $(document).on("change","#cancel_status_beginner",function(e){
        e.preventDefault();
          
        var cancel_status = $(this).val();

        if(cancel_status == 1){
            //Add required property for beginner level cancel reason
            $("#beginner_cancel_reason").prop('required',true);
        }else{
           //Remove required property for beginner level cancel reason
            $("#beginner_cancel_reason").prop('required',false);
        }
        var validate_beginner_txtarea = validator.element("#beginner_cancel_reason");
    });  

    $(document).on("change","#cancel_status_inter",function(e){
        e.preventDefault();
          
        var cancel_status = $(this).val();

        if(cancel_status == 1){
            //Add required property for beginner level cancel reason
            $("#inter_cancel_reason").prop('required',true);
        }else{
           //Remove required property for beginner level cancel reason
            $("#inter_cancel_reason").prop('required',false);
        }
        var validate_inter_txtarea = validator.element("#inter_cancel_reason");
    });  

    $(document).on("change","#cancel_status_advanced",function(e){
        e.preventDefault();
          
        var cancel_status = $(this).val();

        if(cancel_status == 1){
            //Add required property for beginner level cancel reason
            $("#advanced_cancel_reason").prop('required',true);
        }else{
           //Remove required property for beginner level cancel reason
           $("#advanced_cancel_reason").prop('required',false);
        }
        var validate_advanced_txtarea = validator.element("#advanced_cancel_reason");
    }); 

    function validateCancelCourseForm(){
        
        //Validate beginner level data 
        var cancel_status_beginner = $("#cancel_status_beginner").val();
        
        if(cancel_status_beginner){
           
           if(cancel_status_beginner == 1){
              //Add required property for beginner level cancel reason
              $("#beginner_cancel_reason").prop('required',true);
           }else{
              //Remove required property for beginner level cancel reason
              $("#beginner_cancel_reason").prop('required',false);
           }
           var validate_beginner_txtarea = validator.element("#beginner_cancel_reason");

           if(validate_beginner_txtarea == false){
               var responseArr = ["Reason of cancel is missing in beginner level",'error','#DD6B55'];
               alert_func(responseArr);
               return false;
           }

        }else{
           var validate_beginner_txtarea = true;
        }
        
        //Validate intermediate level data 
        var cancel_status_inter = $("#cancel_status_inter").val();

        if(cancel_status_inter){

            if(cancel_status_inter == 1){
                //Add required property for beginner level cancel reason
                $("#inter_cancel_reason").prop('required',true);
            }else{
               //Remove required property for beginner level cancel reason
                $("#inter_cancel_reason").prop('required',false);
            }
            var validate_inter_txtarea = validator.element("#inter_cancel_reason");

            if(validate_inter_txtarea == false){
               var responseArr = ["Reason of cancel is missing in intermediate level",'error','#DD6B55'];
               alert_func(responseArr);
               return false;
            }

        }else{
            var validate_inter_txtarea = true;
        } 

        //Validate advanced level data 
        var cancel_status_advanced = $("#cancel_status_advanced").val();   

        if(cancel_status_advanced){

            if(cancel_status_advanced == 1){
                //Add required property for beginner level cancel reason
                $("#advanced_cancel_reason").prop('required',true);
            }else{
               //Remove required property for beginner level cancel reason
               $("#advanced_cancel_reason").prop('required',false);
            }
            var validate_advanced_txtarea = validator.element("#advanced_cancel_reason");

            if(validate_advanced_txtarea == false){
               var responseArr = ["Reason of cancel is missing in advanced level",'error','#DD6B55'];
               alert_func(responseArr);
               return false;
            }

        }else{
            var validate_advanced_txtarea = true;
        } 

        if(validate_beginner_txtarea == false || validate_inter_txtarea == false || validate_advanced_txtarea == false){
            return false;
        }else{
            return true;
        } 
    } 

    //HANDLING Course Create FORM
    $("#cancel_course_form").on('submit', function(event){
         event.preventDefault();

         var validateForm = validateCancelCourseForm();

         if(validateForm == true){
         
            //Throwing ajax request in server 
            $.ajax({
              url:baseUrl+'instructor/submitCancelCourse',
              method:'POST',
              data: new FormData(this),
              contentType:false,
              processData:false,
              beforeSend: function() {
                 //Disable submit button
                 $('.overlayer').fadeIn();
                 $("#submitCancelCourse").attr('disable',true);
              },
              success:function(resposeData){
                 $('.overlayer').fadeOut();
                 var data = JSON.parse(resposeData);
                 //console.log(data);
                 var redirectURL = window.location.href.split('#')[0];
                 //var redirectURL = baseUrl+'instructor/my-created-course';
                 if(data.check == 'success'){
                   var responseArr = [data.msg,'success','#A5DC86'];
                   alert_response(responseArr,redirectURL);
                   return true; 
                 }else{
                    var responseArr = [data.msg,'error','#DD6B55'];
                    alert_func(responseArr);
                    return false;
                 }
              }
            });
         }else{
            return false; 
         }    
                  
    });

</script>


