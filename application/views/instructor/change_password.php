    <div class="dashboard-content">
        <div class="container">
            <h4 class="dashboard-title">Settings</h4>
            <div class="dashboard-settings">
                <div class="dashboard-tabs-menu">
                    <ul>
                        <li><a href="<?=base_url('instructor/settings')?>">Profile</a></li>
                        <li><a class="active" href="<?=base_url('instructor/reset')?>">Reset Password</a></li>
                    </ul>
                </div>
                <form action="<?=base_url('instructor/change_password')?>" method="post">
                    <div class="row">  
                      <div class="col-md-9 col-md-offset-3">  
                          <?php 
                             if($this->session->flashdata('form_error')){ 
                                $formErrors = $this->session->flashdata('form_error');
                                foreach ($formErrors as $key => $error) { 
                                    if(!empty($error)){
                          ?>
                          
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>Error!</strong> <?=$error;?>
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                          
                          <?php } } }?>
                            
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

                    <div class="row">
                        <div class="col-lg-9">
                            <div class="dashboard-content-box dashboard-settings__info">
                                <h4 class="dashboard-settings__title">Reset Password</h4>
                                <div class="row gy-4">
                                    <div class="col-md-12">
                                        <div class="dashboard-content__input">
                                            <label class="form-label-02">Current Password</label>
                                            <input type="password" name="c_password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="dashboard-content__input">
                                            <label class="form-label-02">New Password</label>
                                            <input type="password" name="n_password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="dashboard-content__input">
                                            <label class="form-label-02">Confirm New Password</label>
                                            <input type="password" name="n_password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-settings__btn">
                        <button type="submit" class="btn btn-primary btn-hover-secondary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>