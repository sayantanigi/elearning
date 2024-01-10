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
                    <div class="comments-area">
                        <div class="comment-wrap">
                            <h3 class="comment-title">Recover Your Password</h3>
                            <p>Required fields are marked<sup class="error">*</sup></p>
                            <div class="comment-form">
                                <form id="user-forget-password" method="post" onsubmit="return false;">
                                    <div class="row gy-4">
                                        <div class="col-md-9">
                                            <div class="comment-form__input">
                                                <input type="email" name="email" class="form-control" placeholder="Enter Registered Email Address *" required>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="comment-form__input">
                                                <label>Already have an Account ? <a href="" data-bs-toggle="modal" data-bs-target="#loginModal" data-backdrop="static" data-keyboard="false"  data-toggle="modal">Login Here</a>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="comment-form__input">
                                                <button type="submit" id="forget-password-submit" class="btn btn-primary btn-hover-secondary">Submit</button>
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
</div>