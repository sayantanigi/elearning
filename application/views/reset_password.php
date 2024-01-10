<div class="page-banner">
    <div class="page-banner__wrapper">
        <div class="container">
            <div class="page-breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="##">Find your Account</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="blog-section">
    <div class="container custom-container">
        <div class="blog-details-no-sidebar">
            <div class="blog-details">
                <div class="blog-details__content">
                    <div class="overlayer" style="display: none;">
                       <div class="spinner"></div>
                    </div>

                    <?php 
                        if(!empty($user_auth_err_msg)){
                           echo $user_auth_err_msg;
                        }else{    
                    ?>
                        <div class="comments-area">
                            <div class="comment-wrap">
                                <h3 class="comment-title">Reset Your Password</h3>
                                <p>Required fields are marked<sup class="error">*</sup></p>
                                <div class="comment-form">
                                    <form id="user-reset-password" method="post" onsubmit="return false;">
                                        <input type="hidden" name="user_email" value="<?=$user_email?>">
                                        <div class="row gy-4">
                                            <div class="col-md-9">
                                                <div class="comment-form__input">
                                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password *" required>
                                                </div>
                                            </div>

                                             <div class="col-md-9">
                                                <div class="comment-form__input">
                                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password *" required>
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="comment-form__input">
                                                    <label>Already have an Account ? <a href="" data-bs-toggle="modal" data-bs-target="#loginModal" data-backdrop="static" data-keyboard="false"  data-toggle="modal">Login Here</a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="comment-form__input">
                                                    <button type="submit" id="reset-password-submit" class="btn btn-primary btn-hover-secondary">Reset Password</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>       
                </div>
            </div>
        </div>
    </div>
</div>