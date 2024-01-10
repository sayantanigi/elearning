<div class="content-body">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
			</ol>
		</div>
		<!-- row -->
		<form id="create_instructor_form" method="post" onsubmit="return false;">	
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
					<div class="card">
						<div class="card-header">
						<h4 class="card-title"> <?= $title ?> </h4>

						</div>
						<div class="card-body">
							<div class="basic-form">
								<div class="white-box">

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>First Name <span>*</span></label>
												<input type="text" class="form-control" name="firstName" id="firstName" value="<?= @$data->firstName ?>" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Last Name <span>*</span></label>
												<input type="text" class="form-control" name="lastName" id="lastName" required>

											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
												<label>Email Address <span>*</span></label>
												<input type="email" class="form-control" name="email" id="email" data-validation="email" autocomplete="off" required>
											</div>
										</div>
									</div>
									<div class="row">

										<div class="col-sm-12">
											<div class="form-group">
												<label>Mobile <span>*</span></label>
												<input type="text" class="form-control" name="mobile" id="mobile" autocomplete="off" required>
												
												<input type="hidden" id="ccName" name="ccName" readonly>
                                            	<input type="hidden" id="ccCode" name="ccCode" readonly>
											</div>
										</div>

										<div class="col-sm-12">
											<div class="form-group">
												<label>Country of Origin <span>*</span></label>
												<input type="text" class="form-control" name="origin_country" id="origin_country" autocomplete="off" required>
											</div>
										</div>

									</div>

									<div class="row">

										<div class="col-sm-6">
											<div class="form-group select-time">
												<label>Timezone <span style="font-size: 11px;">*</span></label>
												<select name="timezone" id="timezone" class="form-control global-select2" data-placeholder="Please select a timezone" required>
													<option></option>
													<?php foreach ($timezoneList as $key => $time): ?>
	                                                    <option value="<?=$time->timezone?>"><?= $time->timezone ?></option>
	                                                <?php endforeach ?>
												</select>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Status <span style="font-size: 11px;">*</span></label>
												<select name="status" id="status" class="form-control" required>
													<option selected disabled>Please select a status for instructor</option>
													<option value="1">
														Active
													</option>
													<option value="0">
														Deactive
													</option>
												</select>
											</div>
										</div>

									</div>
							   </div>
						   </div>
					    </div>
				    </div>

				    <div class="card">
						<div class="card-header">
							<h4 class="card-title"> Update Resume </h4>
						</div>
						<div class="card-body">
							<div class="basic-form">
								<div class="white-box">

									<div class="row">
										<div class="col-md-12">
                                            <input type="file" name="cv" id="cv" style="width:75%;" <?=(!empty($oldCv)?'':'required')?>> 
                                            <?php if(!empty($data->cv)){ ?>
                                                <a href="<?=base_url('./uploads/cv/'.$data->cv)?>" style="color:blue;" download><i class="fa fa-download"></i>&nbsp;Download CV</a>
                                            <?php } ?>     
                                        </div>
									</div>
								</div>
							</div>			
						</div>
					</div>
	            </div>

	             <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
	               
	               <div class="card">
						<div class="card-header">
							<h4 class="card-title"> Update Profile Picture </h4>
						</div>
						<div class="card-body">
							<div class="basic-form">
								<div class="white-box">

									<div class="row">
                                        

		                                  <div class="form-group row">
		                                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"> 
	                                            <div class="fileinput fileinput-new file-block" data-provides="fileinput">
	                                                <div class="fileinput-new thumbnail" >
	                                                    <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
	                                                </div>
	                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
	                                                <div>
	                                                    <span class="btn btn-default btn-file">
	                                                        <span class="fileinput-new">Select image</span>
	                                                        <span class="fileinput-exists">Change</span>
	                                                        <input type="file" name="profilePic" accept="images/*" required>
	                                                    </span>
	                                                    <a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
	                                                </div>
	                                            </div>
	                                            <div class="clearfix margin-top-10 m-b-20 f12" style="display: block;">
	                                                <span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif
	                                                <span class="label label-danger">Max Upload Size</span>&nbsp;10mb
	                                            </div>
		                                    </div>
		                                 </div>

									</div>
								</div>
							</div>			
						</div>
					</div>

					<div class="card">
						<div class="card-header">
							<h4 class="card-title"> Update Introduction Video </h4>
						</div>
						<div class="card-body">
							<div class="basic-form">
								<div class="white-box">

									<div class="row">
                                       
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                   	    	<h6 class="mb-2">Choose Video Type</h6>
		                                    <div class="mb-2 form-radio">
		                                        <div class="form-check form-check-inline d-inline-block">
		                                          <input class="form-check-input radio-btn" type="radio" name="upload_type" id="cdn" value="cdn" checked>
		                                          <label class="form-check-label radio-label" for="cdn">Youtube</label>
		                                        </div>
		                                        <div class="form-check form-check-inline d-inline-block">
		                                          <input class="form-check-input radio-btn" type="radio" name="upload_type" id="local" value="local">
		                                          <label class="form-check-label radio-label" for="local">Upload from local</label>
		                                        </div>
		                                    </div>
		                                    <div class="mb-3">
		                                        <input type="file" class="form-control d-none" name="intro_video_file" id="intro_video_file" style="line-height: 44px;"> 
		                                        
		                                        <input type="text" class="form-control" name="intro_video_yt" id="intro_video_yt" placeholder="Enter Youtube Video Link..." style="line-height: 44px;">
		                                    </div>
                                        </div>

									</div>
								</div>
							</div>			
						</div>
					</div>

				</div>	
			 </div>
			
			 <div class="row">			

	            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	               
	               <div class="card">
						<div class="card-header">
							<h4 class="card-title"> Payment Information </h4>
						</div>
						<div class="card-body">
							<div class="basic-form">
								<div class="white-box">

									<div class="row">
	                                   
	                                    <div class="col-md-12">
	                                        <label>Bank Name<span style="color:red;"> *</span></label>
	                                        <input type="text" name="bank_name" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_name']:null))?>" required>
	                                    </div>
	                                    <div class="col-md-12 mt-3">
	                                        <label>Bank Branch Address<span style="color:red;"> *</span></label>
	                                        <input type="text" name="bank_address" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_address']:null))?>" required>
	                                    </div>
	                                    
	                                    <div class="col-md-12 mt-3">
	                                        <label>Your Name on Bank Records<span style="color:red;"> *</span></label>
	                                        <input type="text" name="ins_bank_name" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['ins_bank_name']:null))?>" required>
	                                    </div>
	                                   
	                                    <div class="col-md-6 mt-3">
	                                        <label>Account No.<span style="color:red;"> *</span></label>
	                                        <input type="number" name="bank_acunt_no" id="accountNo" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_acunt_no']:null))?>" required>
	                                    </div>

	                                    <div class="col-md-6 mt-3">
	                                        <label>Confirm Account No.<span style="color:red;"> *</span></label>
	                                        <input type="number" name="cnfrm_bank_acunt_no" id="accountNoCnfrm" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_acunt_no']:null))?>" required>
	                                    </div>

	                                    <div class="col-md-6 mt-3">
	                                        <label>Routing No.<span style="color:red;"> *</span></label>
	                                        <input type="number" name="routing_no" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['routing_no']:null))?>" required>
	                                    </div>
	                                    <div class="col-md-6 mt-3">
	                                        <label>Swift Code.<span style="color:red;"> *</span></label>
	                                        <input type="text" name="swift_code" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['swift_code']:null))?>" required>
	                                    </div>

	                                   <div class="col-md-12 mt-3">
	                                        <label>Bio<span style="color:red;"> *</span></label>
	                                        <textarea class="form-control" id="ins_bio" name="descriptions" style="height:120px;" required><?=@$data->descriptions?></textarea>
	                                        <p id="desc_remain_txt" style="color:red;"></p>
	                                  </div>

										<div class="col-md-4 col-sm-4">
											<div class="form-group">
												<button type="submit" id="instructor_submit_btn" class="btn btn-rounded btn-info">
													Create
												</button>
												<a class="btn btn-rounded btn-secondary" href="<?= admin_url('instructors/lists') ?>">
													Back
												</a>
											</div>
										</div>

									</div>
								  </div>
							  </div>
							</div>
						 </div>	
					</div>
	          </div>	
          </form>
	  </div>					
	 </div>
   </div>
</div>

<script>
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

     $(document).on('submit', '#create_instructor_form', function(event){
        event.preventDefault();

        var accountNo = $('#accountNo').val();
        var accountNoCnfrm = $('#accountNoCnfrm').val();

        if(accountNo != accountNoCnfrm){
             alert_func(["Account no and confirm account no doesn't match", "error", "#DD6B55"]);
             return false;
        }else{
             //Throwing ajax request in server 
             $.ajax({
              url:adminUrl+'instructors/create',
              method:'POST',
              data: new FormData(this),
              contentType:false,
              processData:false,
              beforeSend: function() {
                 $("#instructor_submit_btn").prop("disabled",true);
              },
              success:function(resposeData){
                 var data = JSON.parse(resposeData);
                 //console.log(data);
                 if(data.check == 'success'){
                    //reseting form data
                    //$('#create_instructor_form')[0].reset();
                    $("#instructor_submit_btn").prop("disabled",false);
                   //show Order Success Notification
                   var redirectURL = adminUrl+'instructors/lists';
                   alert_response([data.msg, "success", "#A5DC86"],redirectURL);
                   return true; 
                 }else{
                   $("#instructor_submit_btn").prop("disabled",false);	
                   //show erro on toastr
                   alert_func([data.msg, "error", "#DD6B55"]);
                   return false;
                 }
               }
           }); 
        }
    });
</script>