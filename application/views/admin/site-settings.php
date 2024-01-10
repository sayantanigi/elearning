 <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
					</ol>
                </div>
                <!-- row -->    
                <div class="d-flex flex-wrap mb-4 row">
                    <div class="col-md-2 titleListing">
                        <span class="ttiletop">
                            <h6 class="text-black fs-20 font-w600 mb-1"><?= $title ?></h6>
                        </span>
                    </div>
                    <div class="col-md-10">
                        <duv class="userdettingtahview">
                            <ul>
                                <li><a href="#general" class="active"><i class="las la-cog"></i> General</a></li>
                                <li><a href="#notify"><i class="las la-bell"></i> Notification</a></li>
                                <li><a href="#changePassword"><i class="las la-key"></i> Password</a></li>
                                <li><a href="#"><i class="las la-link"></i> Integration</a></li>
                                <li><a href="#"><i class="las la-credit-card"></i> Subscription</a></li> 
                            </ul>
                        </duv>
                    </div> 
                </div>
                <div class="row" id="general">
                    <div class="col-md-12">
                        <h2 class="text-black fs-20 font-w600 mb-4">General</h2>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="box-title m-b-20 mb-3">Company Logo</h4>
                                <div class="msgAlert"></div>
                                <div class="compaylogo">
                                    <img class="logo-abbr" src="<?= base_url('uploads/logos/'.@$data->logo) ?>" alt="">
                                </div>
                                <div class="companyBtns">
                                    <div  class="uploadBtn"><label><input type="file" id="changeProfilePic" name="logo_image"> Upload</label></div>
                                    <?php 
                                        if(!empty($data->logo)){
                                    ?>
                                        <button type="button" class="remBtn">Remove</button>
                                    <?php
                                        }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-8 col-lg-8">
                        <div class="card">
                            <div class="card-body settingform">
                                <div class="basic-form">
                                    <form action="<?= admin_url('settings/save') ?>" method="post" enctype="multipart/form-data">
                                        <h4 class="box-title m-b-20 mb-4">Other Information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Company Name</label> 
                                                    <input type="text" name="company" id="company" 
                                                    value="<?= $data->company;?>" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Email</label> 
                                                    <input type="email" class="form-control" name="email" id="email" value="<?= $data->email ?>" autocomplete="off" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Phone Number</label> 
                                                    <input type="text" class="form-control" name="phone" id="phone" value="<?= $data->phone ?>" autocomplete="off" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Address</label> 
                                                    <input type="text" class="form-control" name="address" id="address" value="<?= $data->address ?>" autocomplete="off" required="">
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <h4 class="box-title mb-4 mt-3">Social Media Settings</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Facebook</label>
                                                     <input type="text" class="form-control" name="facebook" id="facebook" value="<?= $data->facebook ?>" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Twitter</label>
                                                    <input type="text" class="form-control" name="twitter" id="twitter" value="<?= $data->twitter ?>" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Linkedin</label>
                                                    <input type="text" class="form-control" name="linkedin" id="linkedin" value="<?= $data->linkedin ?>" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Instagram</label>
                                                     <input type="text" class="form-control" name="instagram" id="instagram" value="<?= $data->instagram ?>" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-right">
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-rounded btn-info" name="settings" id="settings" value="Save Changes"/>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
					</div>					
                </div>
                <div class="notificationPnl" id="notify">
                    <h2 class="text-black fs-20 font-w600 mb-4 mt-1">Notifications</h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="notificationlist">
                                <div class="custom-control custom-switch toggle-switch text-right mr-4 mb-2">
                                    <input type="checkbox" name="member_sub" class="custom-control-input member" member="mem_sub"  id="customSwitch11"  <?php if($data->member_subscription == 1){echo "checked";}?>>
                                    <label class="custom-control-label" for="customSwitch11">New Member Subscription</label>
                                    <p>Get Notification when a member create account and subscribe</p>
                                </div>
                            </div>
                            <div class="notificationlist">
                                <div class="custom-control custom-switch toggle-switch text-right mr-4 mb-2">
                                    <input type="checkbox" class="custom-control-input member" member="mem_active" id="mem" <?php if($data->member_activity == 1){echo "checked";}?>>
                                    <label class="custom-control-label" for="mem">Member Activity</label>
                                    <p>Payment, Cancel Membership</p>
                                </div>
                            </div>
                            <div class="notificationlist">
                                <div class="custom-control custom-switch toggle-switch text-right mr-4 mb-2">
                                    <input type="checkbox" class="custom-control-input member" member="mem_report" id="rr" <?php if($data->weekly_report == 1){echo "checked";}?>>
                                    <label class="custom-control-label" for="rr">Weekly Report</label>
                                    <p>Revenew Report</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="changepassPnl settingform" id="changePassword">
                    <h2 class="text-black fs-20 font-w600 mb-4 mt-1">Change Password</h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">

                                    <form action="<?= admin_url('settings/change_password/'.$admin->userId); ?>" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Email</label>
                                                    <input type="email" class="form-control" value="<?php echo $admin->username;?>"  name="email" required="" readonly> 
                                                    <span><?php echo form_error('email'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Current Password</label>
                                                    <input type="password" class="form-control" required="" name="current_password" value="<?php echo set_value('current_password'); ?>">
                                                     <span><?php echo form_error('current_password'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">New Password</label>
                                                    <input type="password"  class="form-control" name="new_passord" required="" value="<?php echo set_value('new_passord'); ?>">
                                                     <span><?php echo form_error('new_passord'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-14">Confirm Password</label>
                                                    <input type="password" name="confirm_password" value="" class="form-control" required="" placeholder="Enter Your Retype Password"  value="<?php echo set_value('confirm_password'); ?>">
                                                    <span><?php echo form_error('confirm_password'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-rounded btn-info" name="" value="Update Password">
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
        </div>

