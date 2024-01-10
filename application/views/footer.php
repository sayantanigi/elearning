<?php $settings = $this->mymodel->get('settings', true, 'settingId', '1'); ?>
<div class="footer-section footer-bg-1">
    <div class="footer-widget-area section-padding-01">
        <div class="container">
            <div class="row gy-6">
                
                <div class="col-lg-4">
                    <div class="footer-widget ">
                        <a href="<?=base_url()?>" class="footer-widget__logo"><img src="<?= base_url('uploads/logos/'.@$settings->logo) ?>" alt="Logo" width="150" height="32"></a>
                        <div class="footer-widget__social justify-content-start">
                            <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                        </div>
                        
                        
                    </div>
                </div>
                
                <div class="col-lg-5">
                    <div class="footer-widget">
                        <h4 class="footer-widget__title">Links</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="footer-widget__link">
                                    <li><a href="<?=base_url('about-us')?>">About Us</a></li>
                                    <li><a href="<?=base_url('courselist')?>">Courses</a></li>
                                    <li><a href="<?=base_url('blogs')?>">News & Blogs</a></li>
                                    
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="footer-widget__link ">
                                    <li><a href="<?=base_url('faqs')?>">FAQs</a></li>
                                    <li><a href="<?=base_url('terms-and-conditions')?>">Terms of Use</a></li>
                                    <li><a href="<?=base_url('privacy-policy')?>">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-widget">
                        <h4 class="footer-widget__title">Download Our App </h4>
                        <div class="d-flex appdownload mb-3">
                            <a href="#"><img src="<?= base_url('frontend/images/appstores.png')?>"></a>
                            <a href="#"><img src="<?= base_url('frontend/images/play-store.png')?>"></a>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <p class="footer-widget__copyright">&copy;  <?=date('Y')?> <span> <?=$settings->title?> </span> Made by <a href="https://www.goigi.com" target="_blank">GOIGI</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<button id="backBtn" class="back-to-top backBtn">
    <i class="arrow-top fal fa-long-arrow-up"></i>
    <i class="arrow-bottom fal fa-long-arrow-up"></i>
</button>
</main>
<div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-dialog-centered modal-login">
        <div class="modal-wrapper pt-0">

            <div class="overlayer" style="display: none;">
               <div class="spinner"></div>
            </div>
               
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close btn-close modalclose" data-bs-dismiss="modal"><i class="fal fa-times"></i></button>
                    <h5 class="modal-title">Login</h5>
                    <p class="modal-description">Don't have an account yet? <button data-bs-toggle="modal" data-bs-target="#registerModal">Sign up for free</button></p>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div id="alert-msg"></div>
                        <input id="redirectto" name="redirectto"  value="<?= current_url(); ?>" type="hidden">
                        <div class="modal-form">
                            <label class="form-label">Email</label>
                            <input type="text"  id="email" name="email"  value="<?php echo set_value('email'); ?>" class="form-control" placeholder="Your email">
                        </div>
                        <div class="modal-form">
                            <label class="form-label">Password</label>
                            <input type="password" id="password" value="<?php echo set_value('password'); ?>"  name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="modal-form d-flex justify-content-between flex-wrap gap-2">
                            <div class="form-check">
                                <input type="checkbox" id="rememberme">
                                <label for="rememberme">Remember me</label>
                            </div>
                            <div class="text-end">
                                <a class="modal-form__link" href="<?=base_url('forgot-password')?>">Forgot your password?</a>
                            </div>
                        </div>
                        <div class="modal-form">
                            <button type="button" id="submitlogin" class="btn btn-primary btn-hover-secondary w-100">Log In</button>
                        </div>
                    </form>

                    <div class="modal-social-option">
                        <p>or Log-in with</p>

                        <ul class="modal-social-btn">
                            <li><a href="#" class="btn facebook"><i class="fab fa-facebook-square"></i> Facebook</a></li>
                            <li><a href="#" class="btn google"><i class="fab fa-google"></i> Google</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="registerModal">
    <div class="modal-dialog modal-dialog-centered modal-register">
        <div class="modal-wrapper">
            <div class="modal-content">
                <div class="overlayer" style="display: none;">
                    <div class="spinner"></div>
                </div>

                <div class="modal-header">
                    <button type="button" class="modal-close btn-close modalclose" data-bs-dismiss="modal"><i class="fal fa-times"></i></button>
                    <h5 class="modal-title">Sign Up</h5>
                    <p class="modal-description">Already have an account? <button type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Log in</button></p>
                </div>
                <div class="modal-body">
                    <form action="#" id="reg_id" method="post">
                        <div class="row gy-5">
                            <div class="col-md-6">
                                <div class="modal-form">
                                    <label class="form-label">First Name</label>
                                    <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modal-form">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modal-form">
                                    <label class="form-label">Email</label>
                                    <input type="email" id="regEmail" name="regEmail" class="form-control" placeholder="Your Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="modal-form">
                                    <label class="form-label">Password</label>
                                    <input type="password" id="regPassword" name="regPassword" class="form-control" placeholder="Password">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="modal-form">
                                    <label class="form-label">Re-Enter Password</label>
                                    <input type="password" id="regConPassword" name="regConPassword" class="form-control" placeholder="Re-Enter Pasword">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="model-form">
                                    <label><input type="radio" id="student_signup" name="userType" value="1"> Student</label>
                                    <label>
                                        <input type="radio" id="instructor_signup" name="userType" value="2"> Instructor</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="modal-form">
                                        <input type="checkbox" name="term_accept"  id="accept">
                                        <label>Accept the <a href="<?=base_url('terms-and-conditions')?>" target="_blank">Terms</a> and <a href="<?=base_url('privacy-policy')?>" target="_blank">Privacy Policy</a></label>
                                    </div>
                                     <?php echo form_error('accept') ?>
                                </div>
                                <div id="alert-reg-msg"></div>
                                <div class="col-md-12 mt-1">
                                    <div class="modal-form">
                                        <button type="button" id="regSubmit" class="btn btn-primary btn-hover-secondary w-100">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>    
<script src="<?=base_url('frontend/js/vendor/modernizr-3.11.7.min.js')?>"></script>
<script src="<?=base_url('frontend/js/vendor/jquery-migrate-3.3.2.min.js')?>"></script>
<script src="<?=base_url('frontend/js/vendor/bootstrap.bundle.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/aos.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/parallax.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/swiper-bundle.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/perfect-scrollbar.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/jquery.powertip.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/nice-select.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/glightbox.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/jquery.sticky-kit.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/imagesloaded.pkgd.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/masonry.pkgd.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/flatpickr.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/range-slider.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/select2.min.js')?>"></script>
<script src="<?= base_url('plugins/sweetalert/sweetalert.min.js');?>"></script>

<script async src="https://static.addtoany.com/menu/page.js"></script> 

<script src="<?= base_url('plugins/intelInput/intlTelInput.js');?>"></script>
<script src="<?= base_url('frontend/js/owl.carousel.min.js'); ?>"></script>
<script src="<?=base_url('frontend/js/main.js')?>"></script>
<script src="<?=base_url('frontend/js/frontend_script.js')?>"></script>

<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>

<script type="text/javascript">
       function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                {pageLanguage: 'en'},
                'google_translate_element'
            );
        }
</script>

<script type="text/javascript">  
   
    $(".display_instructor_signup_modal").click(function(){
         $('#instructor_signup').prop("checked", true);
         $('#registerModal').modal('show');
    });

    $(".display_student_signup_modal").click(function(){
         $('#student_signup').prop("checked", true);
         $('#registerModal').modal('show');
    });

      $("#userRegisterModalOpening").click(function(){
         $('#instructor_signup').prop("checked", false);
         $('#student_signup').prop("checked", false);
         $('#registerModal').modal('show');
    });

    $('#submitlogin').click(function() 
    {
        var form_data = {
            email: $('#email').val(),
            password: $('#password').val(),
            redirectto:$('#redirectto').val(),
        };

        $.ajax({
            url: "<?php echo site_url('login/dologin'); ?>",
            type: 'POST',
            data: form_data,
            beforeSend: function() {
                //Displaying loader
                $('.overlayer').fadeIn();
            },
            success: function(msg) {
                //Disable loader
                $('.overlayer').fadeOut();

                //Checking response
                if (msg == 'Email')
                {
                    $('#alert-msg').html('<div class="alert alert-danger text-center">Please enter registered Email!</div>');
                }
                else if (msg == 'Password')
                {
                    $('#alert-msg').html('<div class="alert alert-danger text-center">Password does not matched.!</div>');
                }
                else if (msg == 'NO')
                {
                    $('#alert-msg').html('<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>');
                }
                else if (msg == 'Yes')
                {
                    var successMsg = "You are successfully logged in";
                    $('#alert-msg').html('<div class="alert alert-success">' + successMsg + '</div>');
                    if($('#redirectto').val()=='')
                    {
                        window.location.href = "<?php echo base_url('user') ?>";
                    }else{
                        window.location.href = $('#redirectto').val();
                    }
                }
                else{
                    $('#alert-msg').html('<div class="alert alert-danger">' + msg + '</div>');
                }
                setTimeout(function(){
                   location.reload();
                },1000);
            }
        });
    });


    $('#regSubmit').click(function() 
    {

       var check = ($('input:checkbox[name=term_accept]').is(':checked'));
       if(check === true)
       {    
        var accept =1;

       }else{
            $('#alert-reg-msg').html('<div class="alert alert-danger text-center">Terms and Privacy Policy is required</div>');
            return false;
       }
        
        var form_data = 
        {
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            regEmail:$('#regEmail').val(),
            regPassword:$('#regPassword').val(),
            regConPassword:$('#regConPassword').val(),
            accept:$("#accept").val(),
            userType:$("input[name='userType']:checked").val(),
        };

        $.ajax({
            url: "<?php echo site_url('login/doreg'); ?>",
            type: 'POST',
            data: form_data,
            beforeSend: function() {
                //Displaying loader
                $('.overlayer').fadeIn();
            },
            success: function(responseData) 
            {
                //Disable loader
                $('.overlayer').fadeOut();

                var data = JSON.parse(responseData);
                if (data.check == 'failure')
                {
                    $('#alert-reg-msg').html('<div class="alert alert-danger text-center">Something went wrong! Please try again later.</div>');
                }
                else if (data.check == 'success')
                {
                    var userType = data.userType;
                    var userId = data.userId;

                    if(userType == 1){
                        var redirectURL = baseUrl+'student/settings'; 
                    }else{
                        var redirectURL = baseUrl+'instructor/settings';
                    }
                        
                    //$('#alert-reg-msg').html('<div class="alert alert-success">' + successMsg + '</div>');
                    $('#reg_id').trigger("reset");
                    setTimeout(function(){
                       alert_response([data.msg, "success", "#A5DC86"],redirectURL); 
                    },100);
                }else{
                    var errMsg = data.errors;
                    $('#alert-reg-msg').html('');
                    for(var i=0;i<errMsg.length;i++){
                       $('#alert-reg-msg').append('<div class="alert alert-danger">'+errMsg[i]+'</div>');
                    }    
                }
            }
        });
    });
</script>

<script>
     var input = document.querySelector("#phone");

     if(input){
        window.intlTelInput(input, {
        //   // allowDropdown: false,
        //   // autoHideDialCode: false,
        //   // autoPlaceholder: "off",
        //   // dropdownContainer: document.body,
        //   // excludeCountries: ["us"],
        //   // formatOnDisplay: false,
        //   // geoIpLookup: function(callback) {
        //   //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        //   //     var countryCode = (resp && resp.country) ? resp.country : "";
        //   //     callback(countryCode);
        //   //   });
        //   // },
        //   // hiddenInput: "full_number",
        //    initialCountry: "us",
        //   // localizedCountries: { 'de': 'Deutschland' },
        //   // nationalMode: false,
        //   // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        //   // placeholderNumberType: "MOBILE",
        //    preferredCountries: ['us', 'tr'],
        //   // separateDialCode: true,
          utilsScript: baseUrl+"plugins/intelInput/utils.js",
        });
     }

     $('#tutor').owlCarousel({
        loop:true,
        margin:20,
        nav:true,
        loop: false,
        rewind: true,
        navText:['<i class="fas fa-chevron-left"></i>',' <i class="fas fa-chevron-right"></i>'],
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
     });
     $('#tutor2').owlCarousel({
        loop:true,
        margin:20,
        nav:true,
        loop: false,
        rewind: true,
        navText:['<i class="fas fa-chevron-left"></i>',' <i class="fas fa-chevron-right"></i>'],
        responsive:{
            0:{
                items:2
            },
            600:{
                items:2
            },
            1000:{
                items:3
            }
        }
     })

  </script>

</body>
</html>