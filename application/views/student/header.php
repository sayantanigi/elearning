<?php 
   $settings = $this->mymodel->get('settings', true, 'settingId', '1'); 
   $myInfo = $this->mymodel->get('users', true, 'userId', $this->session->userdata('userId'));
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= (!empty($title) && $title != '')? $title.' | ' : ''; ?><?= SITENAME ?> </title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('uploads/logos/'.@$settings->favicon) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('frontend/css/vendor/fontawesome-all.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/vendor/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/vendor/edumall-icon.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/aos.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/swiper-bundle.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/perfect-scrollbar.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/jquery.powertip.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/glightbox.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/flatpickr.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/ion.rangeSlider.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/select2.min.css')?>">

    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/toastr.min.css')?>">

    <link rel="stylesheet" href="<?= base_url('plugins/sweetalert/sweetalert.css');?>"> 

    <link rel="stylesheet" href="<?= base_url('plugins/intelInput/intlTelInput.css');?>"> 

    <link rel="stylesheet" href="<?= base_url('frontend/css/plugins/fullcalendar.css');?>">

    <link rel="stylesheet" href="<?=base_url('frontend/css/style.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/custom.css')?>">

    <script src="<?=base_url('frontend/js/vendor/jquery-3.6.0.min.js')?>"></script>

    <!-- Jquery Lightbox Css -->
    <link href="<?= base_url('backend/vendor/jquery-lightbox/css/jquery.fancybox.min.css') ?>" rel="stylesheet"> 
    <!----END HERE---->
    
    <script>
        var baseUrl = '<?=base_url()?>';
    </script>

</head>
<body class="dashboard-page dashboard-nav-fixed">
    <div class="dashboard-nav offcanvas offcanvas-start" id="offcanvasDashboard">
        <div class="dashboard-nav__wrapper">
            <div class="offcanvas-header dashboard-nav__header dashboard-nav-header">
                <div class="dashboard-nav__toggle d-xl-none">
                    <button class="toggle-close" data-bs-dismiss="offcanvas"><i class="fal fa-times"></i></button>
                </div>
                <div class="dashboard-nav__logo">
                    <a class="logo" href="<?=base_url()?>"><img src="<?= base_url('uploads/logos/'.@$settings->logo) ?>" alt="Logo" width="148" height="62"></a>
                </div>
            </div>
            <div class="offcanvas-body dashboard-nav__content navScroll">
                <div class="dashboard-nav__menu">
                    <ul class="dashboard-nav__menu-list">
                        <li class="<?= (!empty($page) && $page == 'dashboard')? 'active' : ''; ?>">
                            <a href="<?=base_url('student/dashboard')?>">
                                <i class="edumi edumi-layers"></i>
                                <span class="text">Dashboard</span>
                            </a>
                        </li>
                        <!--<li class="<?= (!empty($title) && $title == 'My Profile')? 'active' : ''; ?>">
                            <a href="<?=base_url('student/profile')?>">
                                <i class="edumi edumi-follower"></i>
                                <span class="text">My Profile</span>
                            </a>
                        </li>-->
                        <li class="<?= (!empty($page) && $page == 'courselist')? 'active' : ''; ?>">
                            <a href="<?=base_url('student/enrolledcourselist')?>">
                                <i class="edumi edumi-open-book"></i>
                                <span class="text">Enrolled Courses</span>
                            </a>
                        </li>
                        <li class="<?= (!empty($title) && $title == 'My Wishlist')? 'active' : ''; ?>">
                            <a href="<?=base_url('student/wishlist')?>">
                                <i class="edumi edumi-heart"></i>
                                <span class="text">Wishlist</span>
                            </a>
                        </li>
                        <li class="<?= (!empty($page) && $page == 'purchasehistory')? 'active' : ''; ?>">
                            <a href="<?=base_url('student/history')?>">
                                <i class="edumi edumi-shopping-cart"></i>
                                <span class="text">Purchase History</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="dashboard-nav__menu-list">
                        <li class="<?= (!empty($page) && $page == 'profilesetting')? 'active' : ''; ?>">
                            <a href="<?=base_url('student/settings')?>">
                                <i class="edumi edumi-settings"></i>
                                <span class="text">Profile Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url('login/logout')?>">
                                <i class="edumi edumi-sign-out"></i>
                                <span class="text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="offcanvas-footer"></div>
        </div>
    </div>
    <main class="dashboard-main-wrapper">
    <div class="dashboard-header">
        <div class="container">
            <div class="dashboard-header__wrap">
                <div class="dashboard-header__toggle-menu d-xl-none">
                    <button class="toggle-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDashboard">
                        <svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M18.7179688,2.60581293 L1.28207031,2.60581293 C0.573828125,2.60581293 0,2.02491559 0,1.30798783 C0,0.591060076 0.573828125,0.0101231939 1.28207031,0.0101231939 L18.7179688,0.0101231939 C19.4261719,0.0101231939 20,0.591020532 20,1.30798783 C20,2.02495513 19.4261719,2.60581293 18.7179688,2.60581293 Z"></path>
                            <path d="M11.5384766,10.5957293 L1.28207031,10.5957293 C0.573828125,10.5957293 2.91322522e-13,10.0147924 2.91322522e-13,9.29786464 C2.91322522e-13,8.58093688 0.573828125,8 1.28207031,8 L11.5384766,8 C12.2466797,8 12.8205469,8.58089734 12.8205469,9.29786464 C12.8205469,10.0148319 12.2466797,10.5957293 11.5384766,10.5957293 Z"></path>
                            <path d="M18.7179688,17.6 L1.28207031,17.6 C0.573828125,17.6 0,17.0628683 0,16.4 C0,15.7371317 0.573828125,15.2 1.28207031,15.2 L18.7179688,15.2 C19.4261719,15.2 20,15.7370952 20,16.4 C20,17.0628683 19.4261719,17.6 18.7179688,17.6 Z"></path>
                        </svg>
                    </button>
                </div>
                <div class="dashboard-header__user">
                    <div class="dashboard-header__user-avatar">

                        <?php if($myInfo->profilePic!=""){ ?>
                            <img src="<?= base_url('uploads/users/').@$myInfo->profilePic ?>" width="90" height="90" alt="<?= @$myInfo->lastName ?>">
                        <?php } else { ?>
                            <img src="<?=base_url('uploads/nouser.png')?>" class="img-responsive" width="90" height="90">
                        <?php } ?>
                    </div>
                    <div class="dashboard-header__user-info">
                        <h4 class="dashboard-header__user-name"><span class="welcome-text"><?=$myInfo->firstName?> &nbsp;</span><?=$myInfo->lastName?> </h4>
                    </div>
                </div>
                 <div id="google_translate_element"></div>
            </div>
        </div>
    </div>