<?php
  $paymentInfoArr = unserialize($data->payment_info);

  $oldProfilePic = $data->profilePic;
  $oldCv = $data->cv;

  if(!empty($data->intro_video)){
     if(strpos($data->intro_video, 'youtu')){
        $intro_upload_type = 'cdn';
     }else{
        $intro_upload_type = 'local';
     }
     $oldIntroVideo = $data->intro_video;
  }else{
     $intro_upload_type = null;
     $oldIntroVideo = null;
  }

  /*print"<pre>";
  print_r($data);
  print"</pre>";*/
?>
<div class="content-body">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
			</ol>
		</div>
		<!-- row -->
		<form id="update_instructor_form" method="post" onsubmit="return false;">	
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
												<input type="text" class="form-control" name="firstName" id="firstName" value="<?= @$data->firstName ?>" readonly>
												<input type="hidden" name="userId" value="<?= @$data->userId ?>" readonly>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Last Name <span>*</span></label>
												<input type="text" class="form-control" name="lastName" id="lastName" value="<?= @$data->lastName ?>" readonly>

											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
												<label>Email Address <span>*</span></label>
												<input type="email" class="form-control" name="email" id="email" value="<?= @$data->email ?>" data-validation="email" autocomplete="off" readonly>
											</div>
										</div>
									</div>
									<div class="row">

										<div class="col-sm-6">
											<div class="form-group">
												<label>Mobile <span>*</span></label>
												<input type="text" class="form-control" name="mobile" id="mobile" value="<?= @$data->mobile ?>" autocomplete="off" readonly>

												<input type="hidden" id="ccName" name="ccName" readonly>
                                            	<input type="hidden" id="ccCode" name="ccCode" readonly>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Country of Origin <span>*</span></label>
												<input type="text" class="form-control" name="origin_country" id="origin_country" value="<?= @$data->origin_country ?>" autocomplete="off" readonly>
											</div>
										</div>

									</div>

									<div class="row">

										<div class="col-sm-6">
											<div class="form-group select-time">
												<label>Timezone <span style="font-size: 11px;">*</span></label>
												<select name="timezone" id="timezone" class="form-control global-select2" data-placeholder="Please select a timezone" readonly>
													<option></option>
													<?php foreach ($timezoneList as $key => $time): ?>
	                                                    <option value="<?=$time->timezone?>" <?=(($data->timezone == $time->timezone ?'selected':''))?>>
	                                                        <?= $time->timezone ?>
	                                                    </option>
	                                                <?php endforeach ?>
												</select>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Status <span style="font-size: 11px;">*</span></label>
												<select name="status" id="status" class="form-control" readonly>
													<option></option>
													<option value="1" <?= (@$data->status == '1')? 'selected' : '' ?>>
														Active
													</option>
													<option value="0" <?= (@$data->status == '0')? 'selected' : '' ?>>
														Deactive
													</option>
												</select>
											</div>
										</div>

										<div class="col-sm-12">
											<div class="form-group">
												<label>Password <span style="font-size: 11px; color:red">(Enter only when you want to change the password)</span></label>
												<input type="password" class="form-control" name="password" autocomplete="off" id="password" value="" >
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
                                            <input type="file" name="cv" id="cv" style="width:75%;" <?=(!empty($oldCv)?'':'readonly')?>> 
                                            <?php if(!empty($data->cv)){ ?>
                                                <a href="<?=base_url('./uploads/cv/'.$data->cv)?>" style="color:blue;" download><i class="fa fa-download"></i>&nbsp;Download CV</a>
                                            <?php } ?>     
                                            <input type="hidden" id="oldInsCv" name="oldInsCv" value="<?=$oldCv?>">
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
	                                                    <?php if (@$data->profilePic && file_exists('./uploads/users/'.@$data->profilePic)) { ?>
															<img src="<?= base_url('uploads/users/'.@$data->profilePic) ?>" alt="">
														<?php } else { ?>
															<img src="<?= base_url('uploads/noimg.png') ?>" alt="">
														<?php } ?>
	                                                </div>
	                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
	                                                <div>
	                                                    <a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
	                                                </div>
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
			                                          <input class="form-check-input radio-btn" type="radio" name="upload_type" id="cdn" value="cdn" <?=(!empty($intro_upload_type)?($intro_upload_type == 'cdn'?'checked':''):'')?>>
			                                          <label class="form-check-label radio-label" for="cdn">Youtube</label>
			                                        </div>
			                                        <div class="form-check form-check-inline d-inline-block">
			                                          <input class="form-check-input radio-btn" type="radio" name="upload_type" id="local" value="local" <?=(!empty($intro_upload_type)?($intro_upload_type == 'local'?'checked':''):'')?>>
			                                          <label class="form-check-label radio-label" for="local">Upload from local</label>
			                                        </div>
			                                    </div>
			                                    <div class="mb-3">
			                                        <input type="file" class="form-control <?=(!empty($intro_upload_type)?($intro_upload_type == 'local'?'':'d-none'):'')?>" name="intro_video_file" id="intro_video_file" style="line-height: 44px;"> 
			                                        
			                                        <input type="text" class="form-control <?=(!empty($intro_upload_type)?($intro_upload_type == 'cdn'?'':'d-none'):'d-none')?>" name="intro_video_yt" id="intro_video_yt" placeholder="Enter Youtube Video Link..." value="<?=($intro_upload_type == 'cdn'?$oldIntroVideo:'')?>" style="line-height: 44px;" readonly>
			                                    </div>

			                                    <?php if($intro_upload_type == 'local'){ ?>
			                                        <a href="<?= base_url('uploads/users/'.$oldIntroVideo) ?>" target="_blank" style="color:blue;"><i class="fa fa-eye"></i> Watch Video</a>
			                                    <?php }else{ ?>    
			                                         <a href="<?=$oldIntroVideo?>" target="_blank" style="color:blue;"><i class="fa fa-eye"></i> Watch Video</a>
			                                    <?php } ?>   
			                                    <input type="hidden" name="oldIntroVideo" value="<?=(!empty($oldIntroVideo)?$oldIntroVideo:null)?>">

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
	                                        <input type="text" name="bank_name" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_name']:null))?>" readonly>
	                                    </div>
	                                    <div class="col-md-12 mt-3">
	                                        <label>Bank Branch Address<span style="color:red;"> *</span></label>
	                                        <input type="text" name="bank_address" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_address']:null))?>" readonly>
	                                    </div>
	                                    
	                                    <div class="col-md-12 mt-3">
	                                        <label>Your Name on Bank Records<span style="color:red;"> *</span></label>
	                                        <input type="text" name="ins_bank_name" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['ins_bank_name']:null))?>" readonly>
	                                    </div>
	                                   
	                                    <div class="col-md-6 mt-3">
	                                        <label>Account No.<span style="color:red;"> *</span></label>
	                                        <input type="number" name="bank_acunt_no" id="accountNo" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_acunt_no']:null))?>" readonly>
	                                    </div>

	                                    <div class="col-md-6 mt-3">
	                                        <label>Confirm Account No.<span style="color:red;"> *</span></label>
	                                        <input type="number" name="cnfrm_bank_acunt_no" id="accountNoCnfrm" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['bank_acunt_no']:null))?>" readonly>
	                                    </div>

	                                    <div class="col-md-6 mt-3">
	                                        <label>Routing No.<span style="color:red;"> *</span></label>
	                                        <input type="number" name="routing_no" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['routing_no']:null))?>" readonly>
	                                    </div>
	                                    <div class="col-md-6 mt-3">
	                                        <label>Swift Code.<span style="color:red;"> *</span></label>
	                                        <input type="text" name="swift_code" class="form-control" value="<?=((!empty($paymentInfoArr)? $paymentInfoArr['swift_code']:null))?>" readonly>
	                                    </div>

	                                   <div class="col-md-12 mt-3">
	                                        <label>Bio<span style="color:red;"> *</span></label>
	                                        <textarea class="form-control" id="ins_bio" name="descriptions" style="height:120px;" readonly><?=@$data->descriptions?></textarea>
	                                        <p id="desc_remain_txt" style="color:red;"></p>
	                                  </div>

									</div>
								  </div>
							  </div>
							</div>
						 </div>	
					</div>
	          </div>	
          </form>

			<div class="card">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card-header">
                            <h4 class="card-title"> All Assigned Courses </h4>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="basic-form">
                      
                      <div class="form-group row">
						<table class="display table table-bordered table-responsive-md coursetable">
							<thead>
								<tr>
									<th>Course Name </th>
									<th>Course Level </th>
									<!--<th>Number of Lessons </th>-->
									<th>Course Image</th>
									<th>Created On</th>	
									<th width="300px">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php 
								   foreach (@$courseList as $key => $v): 
								   	 $courseLvlStr = join(',', array_map('ucfirst', explode(',', $v->course_level)));
								?>
									<tr>
										<td><?= $v->courseName ?></td>
										<td><?= $courseLvlStr ?></td>		
										<!--<td><?= $totalLesson ?></td>-->										    	
										<td class="courseBnr">
											<?php if (@$v->image && file_exists('./uploads/courses/'.@$v->image)) { ?>
												<img src="<?= base_url('uploads/courses/'.@$v->image) ?>" alt="img">
											<?php } else { ?>
												<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
											<?php } ?>
										</td>																		
										<td class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></td>

										<td class="text-center actionbtnlist">
											
											<a href="<?= admin_url('course/edit/'.@$v->courseId) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="Details">
												<i class="fa fa-eye"></i>
											</a>

											<a href="<?= admin_url('course/edit/'.@$v->courseId) ?>" class="btn btn-xs btn-secondary"  data-toggle="tooltip2" title="Edit">
												<i class="ti-pencil"></i>
											</a>
										</td>
									</tr>
									<?php $i++; ?>
								<?php endforeach ?>
						      </tbody>
						    </table>
						  </div>                          
                            
                    </div>
                </div>
            </div>
		</div>					
	  </div>
   </div>
</div>

