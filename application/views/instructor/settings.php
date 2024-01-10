<?php
  $paymentInfoArr = unserialize($myInfo->payment_info);

  if($this->session->flashdata('incompleteFields')){
     $incompleteFields = $this->session->flashdata('incompleteFields');
  }

  $oldProfilePic = $myInfo->profilePic;
  $oldCv = $myInfo->cv;

  if(!empty($myInfo->intro_video)){
     if(strpos($myInfo->intro_video, 'youtu')){
        $intro_upload_type = 'cdn';
     }else{
        $intro_upload_type = 'local';
     }
     $oldIntroVideo = $myInfo->intro_video;
  }else{
     $intro_upload_type = null;
     $oldIntroVideo = null;
  }

  /*print"<pre>";
  print_r($timezoneList);
  print"</pre>";*/
?>
    <div class="dashboard-content">
       <div class="container">
                <h4 class="dashboard-title">Settings</h4>
                <div class="dashboard-settings">
                    <input type="hidden" id="pageName" value="profilesetting">
                    <div class="dashboard-tabs-menu">
                        <ul>
                            <li><a class="active" href="<?=base_url('instructor/settings')?>">Profile</a></li>
                            <li><a href="<?=base_url('instructor/reset')?>">Reset Password</a></li>
                        </ul>
                    </div>
                    <form class="needs-validation" id="update_profile_form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="row">   
                         <div class="col-md-12 pl-3">  
                          <?php if($profileProgress !=100){ ?>
                              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong></strong> Please complete your profile to access other sections of the panel.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              </div>

                              <?php foreach ($incompleteFields as $key => $field) { ?>
                                  <!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> <?=$field?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                                  </div> -->
                              <?php } ?> 

                                  
                          <?php } ?>

                          <?php if($this->session->flashdata('success')){ ?>
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> <?=$this->session->flashdata('success');?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              </div>
                          <?php }else if($this->session->flashdata('error')){  ?>
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?=$this->session->flashdata('error');?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          </div>
                         <?php } ?> 

                          <?php if($myInfo->approve_status == 0){ ?>
                              <!--<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Alert!</strong> Your profile is pending for approval.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              </div>-->
                          <?php } ?>    
                           </div>
                         
                         <?php if($profileProgress !=100){ ?>  
                             <div class="dashboard-course-item__progress-bar-wrap px-5 mx-3 py-2">
                                <div class="dashboard-course-item__progress-bar">
                                    <div class="dashboard-course-item__progress-bar-line" style="width: <?=$profileProgress?>%;"></div>
                                </div>
                                <div class="dashboard-course-item__progress-bar-text"><?=$profileProgress?>% Completed</div>
                            </div>
                         <?php } ?>
                         
                         </div>  
                        <div class="row gy-6">

                            <div class="col-lg-6">
                                <div class="dashboard-content-box">

                                    <h4 class="dashboard-content-box__title">Contact information</h4>
                                    <p>Provide your details below to create your account profile</p>

                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">First name<span style="color:red;"> *</span></label>
                                                <input type="text" name="firstName" value="<?=@$myInfo->firstName?>" class="form-control" required>
                                                <input type="hidden" name="userId" value="<?=@$myInfo->userId?>" class="form-control">
                                                <input type="hidden" name="userType" value="2" class="form-control">
                                                <input type="hidden" name="profileProgress" value="<?=$profileProgress?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Last name<span style="color:red;"> *</span></label>
                                                <input type="text" name="lastName" value="<?=@$myInfo->lastName?>" class="form-control" required>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">E-mail<span style="color:red;"> *</span></label>
                                                <input type="text" name="email" value="<?=@$myInfo->email?>"  class="form-control" required readonly>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Phone Number<span style="color:red;"> *</span></label>
                                                <input type="tel" id="phone" name="mobile" id="phone" value="<?=@$myInfo->mobile?>"  class="form-control" style="display: block;" required>
                                            </div>
                                            <input type="hidden" id="ccName" name="ccName" readonly>
                                            <input type="hidden" id="ccCode" name="ccCode" readonly>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Country of Origin<span style="color:red;"> *</span></label>
                                                <input type="tel" id="origin_country" name="origin_country" placeholder="Enter your country of origin" value="<?=@$myInfo->origin_country?>"  class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label-02">Select Your Timezone<span style="color:red;"> *</span></label>
                                            <select class="form-control timezone" name="timezone">
                                                <option></option>
                                                <?php foreach ($timezoneList as $key => $time): ?>
                                                    <option value="<?=$time->timezone?>" <?=(($myInfo->timezone == $time->timezone ?'selected':''))?>>
                                                        <?= $time->timezone ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                         <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Upload Your CV<span style="color:red;"> *</span></label>
                                                <input type="file" name="cv" id="cv" style="width:75%;" <?=(!empty($oldCv)?'':'required')?>> 
                                                <?php if(!empty($myInfo->cv)){ ?>
                                                    <a href="<?=base_url('./uploads/cv/'.$myInfo->cv)?>" style="color:blue;" download><i class="fa fa-eye"></i>&nbsp;Display CV</a>
                                                <?php } ?>     
                                                <input type="hidden" id="oldInsCv" name="oldInsCv" value="<?=$oldCv?>">
                                            </div>
                                        </div>
     
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="dashboard-content-box">

                                    <h4 class="dashboard-content-box__title">Upload profile photo<span style="color:red;"> *</span></h4>
                                    <div id="dashboard-profile-cover-photo-editor" class="dashboard-settings-profile">
                                        <input id="dashboard-photo-dialogue-box" class="dashboard-settings-profile__input test" type="file" accept=".png,.jpg,.jpeg" <?=(!empty($oldProfilePic)?'':'required')?> />
                                        <div id="dashboard-cover-area" class="dashboard-settings-profile__cover" data-fallback="<?=base_url('./uploads/users/'.$myInfo->profilePic)?>" style="background-image:url(<?=base_url('./uploads/users/'.$myInfo->profilePic)?>);height:220px;">
                                            <!--<span class="cover-deleter">
                                                <i class="far fa-trash-alt"></i>
                                            </span>-->
                                            <div class="overlay">
                                                <button class="cover-uploader" type="button">
                                                    <i class="far fa-camera"></i>&nbsp;
                                                    <span>Select Profile Picture</span>
                                                </button>
                                            </div>
                                            <input type="hidden" name="oldProfilePic" value="<?=(!empty($oldProfilePic)?$oldProfilePic:null)?>">
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="dashboard-content-box">

                                    <h4 class="dashboard-content-box__title">Upload Video</h4>
                                    <h6 class="mb-2">Choose Video Type</h6>
                                    <div class="mb-2">
                                        <div class="form-check form-check-inline d-inline-block">
                                          <input class="form-check-input" type="radio" name="upload_type" id="cdn" value="cdn" <?=(!empty($intro_upload_type)?($intro_upload_type == 'cdn'?'checked':''):'')?>>
                                          <label class="form-check-label" for="cdn">Youtube</label>
                                        </div>
                                        <div class="form-check form-check-inline d-inline-block">
                                          <input class="form-check-input" type="radio" name="upload_type" id="local" value="local" <?=(!empty($intro_upload_type)?($intro_upload_type == 'local'?'checked':''):'')?>>
                                          <label class="form-check-label" for="local">Upload from local</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" class="form-control <?=(!empty($intro_upload_type)?($intro_upload_type == 'local'?'':'d-none'):'')?>" name="intro_video_file" id="intro_video_file" style="line-height: 44px;"> 
                                        
                                        <input type="text" class="form-control <?=(!empty($intro_upload_type)?($intro_upload_type == 'cdn'?'':'d-none'):'d-none')?>" name="intro_video_yt" id="intro_video_yt" placeholder="Enter Youtube Video Link..." value="<?=($intro_upload_type == 'cdn'?$oldIntroVideo:'')?>" style="line-height: 44px;">
                                    </div>

                                    <?php if($intro_upload_type == 'local'){ ?>
                                        <a href="<?= base_url('uploads/users/'.$oldIntroVideo) ?>" target="_blank" style="color:blue;"><i class="fa fa-eye"></i> Watch Video</a>
                                    <?php }else{ ?>    
                                         <a href="<?=$oldIntroVideo?>" target="_blank" style="color:blue;"><i class="fa fa-eye"></i> Watch Video</a>
                                    <?php } ?>   
                                    <input type="hidden" name="oldIntroVideo" value="<?=(!empty($oldIntroVideo)?$oldIntroVideo:null)?>">  
                                </div>
                            </div>

                            <div class="col-lg-12">
                               <div class="dashboard-content-box">

                                    <h4 class="dashboard-content-box__title">Payment Information</h4>
                                    <div class="row gy-4">
                                        <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Bank Name<span style="color:red;"> *</span></label>
                                                <input type="text" name="bank_name" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_name']:null))?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Bank Branch Address<span style="color:red;"> *</span></label>
                                                <input type="text" name="bank_address" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_address']:null))?>" required>
                                            </div>
                                        </div>
                                         <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Your Name on Bank Records<span style="color:red;"> *</span></label>
                                                <input type="text" name="ins_bank_name" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['ins_bank_name']:null))?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Account No.<span style="color:red;"> *</span></label>
                                                <input type="number" name="bank_acunt_no" id="accountNo" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_acunt_no']:null))?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Confirm Account No.<span style="color:red;"> *</span></label>
                                                <input type="number" name="cnfrm_bank_acunt_no" id="accountNoCnfrm" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_acunt_no']:null))?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Routing No.<span style="color:red;"> *</span></label>
                                                <input type="number" name="routing_no" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['routing_no']:null))?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Swift Code.<span style="color:red;"> *</span></label>
                                                <input type="text" name="swift_code" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['swift_code']:null))?>" required>
                                            </div>
                                        </div>

                                       <div class="col-md-12">
                                        <div class="dashboard-content__input">
                                            <label class="form-label-02">Bio<span style="color:red;"> *</span></label>
                                            <textarea class="form-control" id="ins_bio" name="descriptions" required><?=@$myInfo->descriptions?></textarea>
                                            <p id="desc_remain_txt" style="color:red;"></p>
                                        </div>
                                    </div>
                                  </div>             
                               </div>
                            </div>

                        </div>

                        <div class="dashboard-settings__btn">
                            <button class="btn btn-primary btn-hover-secondary">Update Profile</button>
                        </div>
                    </form>

                </div>
            </div>
    </div>
</main>

<script>
    
    $(document).ready(function () { 
        //Applying select2 plugin for selecting subject
        $(".timezone").select2({
            placeholder : 'Select your timezone'
        });
    });    
    
    $('#ins_bio').keydown(function() {
       //take the event argument
       var maxLen = 600;
       var Length = $(this).val().length; // lets use 'this' instead of looking up the element in the DOM
       var AmountLeft = maxLen - Length;

       if(AmountLeft == -1){
          $('#desc_remain_txt').text('0 characeters left!');
       }else{
          $('#desc_remain_txt').text(AmountLeft+' characeters left!');
       }  

       if(Length > maxLen && e.keyCode != 8){ // allow backspace
          e.preventDefault(); // cancel the default action of the event
          //reassign substring of max length to text area value
         this.value = this.value.substring(0, maxLen);
       }else{
          return true;
       }
    });

    $("input[name='upload_type']").on('change',function(){
        var upload_type = $(this).val();
        
        if(upload_type == "cdn"){
           $('#intro_video_file').addClass('d-none');
           $('#intro_video_yt').removeClass('d-none');
        }else{
           $('#intro_video_yt').addClass('d-none');
           $('#intro_video_file').removeClass('d-none');
        }
    });

    $(document).on('change','#dashboard-photo-dialogue-box',function(){
        $(this).valid();
    });

    $(document).on('change','#cv',function(){
        $(this).valid();
    });

    $(document).on('submit', '#update_profile_form', function(event){
        event.preventDefault();

        var accountNo = $('#accountNo').val();
        var accountNoCnfrm = $('#accountNoCnfrm').val();

        if(accountNo != accountNoCnfrm){
             alert_func(["Account no and confirm account no doesn't match", "error", "#DD6B55"]);
             return false;
        }else{
             //Throwing ajax request in server 
             $.ajax({
              url:baseUrl+'instructor/updateInfo',
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
                    //reseting form data
                    $('#update_profile_form')[0].reset();
                   //show Order Success Notification
                   var redirectURL = window.location.href.split('#')[0];
                   alert_response([data.msg, "warning", "#A5DC86"],redirectURL);
                   return true; 
                 }else{
                   //show erro on toastr
                   alert_func([data.msg, "error", "#DD6B55"]);
                   return false;
                 }
               }
           }); 
        }
    });
</script>    