    <div class="dashboard-content">
       <div class="container">
                <h4 class="dashboard-title">Settings</h4>
                <div class="dashboard-settings">
                    <div class="dashboard-tabs-menu">
                        <ul>
                            <li><a class="active" href="<?=base_url('student/settings')?>">Profile</a></li>
                            <li><a href="<?=base_url('student/reset')?>">Reset Password</a></li>
                        </ul>
                    </div>
                    <form action="<?=base_url('student/updateInfo')?>" method="post" enctype="multipart/form-data">
                      <div class="row">  
                         <div class="col-md-12">  
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
                         </div>
                       </div>  

                        <div class="row gy-6">
                            <div class="col-lg-6">
                                <div class="dashboard-content-box">
                                    <input type="hidden" id="pageName" value="profilesetting">
                                    <h4 class="dashboard-content-box__title">Contact information</h4>
                                    <p>Provide your details below to create your account profile</p>

                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">First name</label>
                                                <input type="text" name="firstName" value="<?=@$myInfo->firstName?>" class="form-control">
                                                <input type="hidden" name="userId" value="<?=@$myInfo->userId?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Last name</label>
                                                <input type="text" name="lastName" value="<?=@$myInfo->lastName?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">E-mail</label>
                                                <input type="text" readonly="" name="email" value="<?=@$myInfo->email?>"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="dashboard-content__input">
                                                <label class="form-label-02">Phone Number</label>
                                                <input type="text" name="mobile" id="phone" value="<?=@$myInfo->mobile?>"  class="form-control">
                                            </div>
                                            <input type="hidden" id="ccName" name="ccName" readonly>
                                            <input type="hidden" id="ccCode" name="ccCode" readonly>
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
                                                <label class="form-label-02">Bio</label>
                                                <textarea name="descriptions" class="form-control"><?=@$myInfo->descriptions?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="dashboard-content-box">

                                    <h4 class="dashboard-content-box__title">Photo</h4>
                                    <p>Upload your profile photo.</p>

                                    <div id="dashboard-profile-cover-photo-editor" class="dashboard-settings-profile">
                                        <input id="dashboard-photo-dialogue-box" class="dashboard-settings-profile__input test" type="file" accept=".png,.jpg,.jpeg" />
                                        <div id="dashboard-cover-area" class="dashboard-settings-profile__cover" data-fallback="../frontend/assets/images/cover-photo.jpg" style="background-image:url(<?=base_url('./uploads/users/'.$myInfo->profilePic)?>);height: 245px;">
                                            <!--<span class="cover-deleter">
                                                <i class="far fa-trash-alt"></i>
                                            </span>-->
                                            <div class="overlay">
                                                <button class="cover-uploader" type="button">
                                                    <i class="far fa-camera"></i>&nbsp;
                                                    <span>Update Cover Photo</span>
                                                </button>
                                            </div>
                                        </div>

                                        <!--<div id="photo-meta-area" class="dashboard-settings-profile__photo-meta">
                                            <img src="../frontend/assets/images/info-icon.svg" alt="icon" />
                                            <span>Profile Photo Size: <strong>200x200</strong> pixels,</span>
                                            <span>Cover Photo Size: <strong>700x430</strong> pixels,</span>
                                            <span class="loader-area">Saving&hellip;</span>
                                        </div>-->

                                        <input type="hidden" name="oldProfilePic" value="<?= @$myInfo->profilePic ?>">

                                        <!--<div id="profile-photo" class="dashboard-settings-profile__photo" data-fallback="<?=base_url('./uploads/users/'.$myInfo->profilePic)?>" style="background-image:url(<?=base_url('./uploads/users/'.$myInfo->profilePic)?>)">
                                            <div class="overlay">
                                                <i class="far fa-camera"></i>
                                            </div>
                                        </div>

                                        <div id="profile-photo-option" class="dashboard-settings-profile__photo-option">
                                            <span class="profile-photo-uploader"><i class="far fa-upload"></i> Upload Photo</span>
                                            <span class="profile-photo-deleter"><i class="far fa-trash-alt"></i> Delete</span>
                                        </div>-->
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="dashboard-settings__btn">
                            <button type="submit" class="btn btn-primary btn-hover-secondary">Update Profile</button>
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
</script>