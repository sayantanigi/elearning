<?php $setting = $this->mymodel->getSettings(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= (!empty($title) && $title != '')? $title.' | ' : ''; ?><?= SITENAME ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('uploads/logos/'.@$setting->favicon) ?>">

    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <link href="<?= base_url('backend/vendor/jqvmap/css/jqvmap.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('backend/vendor/chartist/css/chartist.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/vendor/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/js/sweetalert/sweetalert.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('backend/vendor/summernote/summernote.css') ?>" rel="stylesheet">
    <!--  <link href="<?= base_url('backend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') ?>" rel="stylesheet"> -->
    <link href="<?= base_url('backend/css/style.css') ?>" rel="stylesheet">
	<link href="<?= base_url('backend/vendor/owl-carousel/owl.carousel.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/vendor/metismenu/css/metisMenu.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/icons/simple-line-icons/css/simple-line-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/icons/font-awesome-old/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/icons/material-design-iconic-font/css/materialdesignicons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/icons/themify-icons/css/themify-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/icons/line-awesome/css/line-awesome.min.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>

    <link href="<?= base_url('plugins/switchery/dist/switchery.min.css') ?>" rel="stylesheet">

    <!-----SCHEDULE CSS------>
    
    <link rel="stylesheet" href="<?= base_url('frontend/css/plugins/fullcalendar.css');?>">

    <link rel="stylesheet" href="<?=base_url()?>frontend/css/plugins/jquery-ui.css">

    <link rel="stylesheet" href="<?=base_url()?>frontend/css/plugins/timepicker.min.css">

    <!----END HERE---->
    

    <link href="<?= base_url('backend/icons/avasta/css/style.css') ?>" rel="stylesheet">

    <link href="<?= base_url('backend/css/custom.css') ?>" rel="stylesheet">

    <link href="<?= base_url('backend/icons/flaticon/flaticon.css') ?>" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">

    <?php if(in_array($subpage, array('instructoradd','instructoredit'))){ ?>
        <link rel="stylesheet" href="<?= base_url('plugins/intelInput/intlTelInput.css');?>"> 
    <?php } ?>  

    <?php if($page == "chaptercurriculum"){ ?>

         <!-----JQUERY UI CSS------>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!----END HERE---->

        <!-- Jquery File Uploader Css -->
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
         <link href="<?= base_url('backend/vendor/bootstrap-uploader/css/fileinput.css') ?>" rel="stylesheet"> 
         <link href="<?= base_url('backend/vendor/bootstrap-uploader/css/fileinput.css') ?>" rel="stylesheet"> 
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous">
         <link href="<?= base_url('backend/vendor/bootstrap-uploader/themes/explorer-fa5/theme.css') ?>" rel="stylesheet"> 

        <!----END HERE---->

    <?php } ?>    

    <!-- Jquery Lightbox Css -->
    <link href="<?= base_url('backend/vendor/jquery-lightbox/css/jquery.fancybox.min.css') ?>" rel="stylesheet"> 
    <!----END HERE---->

    <script src="<?= base_url('plugins/jquery/dist/jquery.min.js')?>"></script>

    <script>
        var adminUrl = '<?=admin_url()?>';  
        var baseUrl = '<?=base_url()?>';  
    </script>
</head>
<body>   
 <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="<?= admin_url() ?>" class="brand-logo">
                <img class="logo-abbr" src="<?= base_url('uploads/logos/'.@$setting->logo) ?>" alt="">
            </a>
        </div>
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                <i class="flaticon-381-calendar-1"></i> <?=date('l, F d Y')?>
                            </div>
							<div class="input-group search-area d-lg-inline-flex d-none">
								<input type="text" class="form-control" placeholder="Search here...">
								<div class="input-group-append">
									<button class="input-group-text"><i class="flaticon-381-search-2"></i></button>
								</div>
							</div>
                        </div>

                        <ul class="navbar-nav header-right">
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell bell-link" href="#">
                                    <i class="las la-envelope-open"></i>
                                </a>
							</li>
						<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon" href="#" role="button" data-toggle="dropdown">
                                    <svg width="26" height="28" viewBox="0 0 26 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.45251 25.6682C10.0606 27.0357 11.4091 28 13.0006 28C14.5922 28 15.9407 27.0357 16.5488 25.6682C15.4266 25.7231 14.2596 25.76 13.0006 25.76C11.7418 25.76 10.5748 25.7231 9.45251 25.6682Z" fill="#3E4954"/>
                                        <path d="M25.3531 19.74C23.8769 17.8785 21.3995 14.2195 21.3995 10.64C21.3995 7.09073 19.1192 3.89758 15.7995 2.72382C15.7592 1.21406 14.5183 0 13.0006 0C11.4819 0 10.2421 1.21406 10.2017 2.72382C6.88095 3.89758 4.60064 7.09073 4.60064 10.64C4.60064 14.2207 2.12434 17.8785 0.647062 19.74C0.154273 20.3616 0.00191325 21.1825 0.240515 21.9363C0.473484 22.6721 1.05361 23.2422 1.79282 23.4595C3.08755 23.8415 5.20991 24.2715 8.44676 24.491C9.84785 24.5851 11.3543 24.64 13.0007 24.64C14.646 24.64 16.1524 24.5851 17.5535 24.491C20.7914 24.2715 22.9127 23.8415 24.2085 23.4595C24.9477 23.2422 25.5268 22.6722 25.7597 21.9363C25.9983 21.1825 25.8448 20.3616 25.3531 19.74Z" fill="#3E4954"/>
                                    </svg>
                                    <span class="badge light text-white bg-primary rounded-circle">52</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3 height380">
                                        <ul class="timeline">
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media mr-2">
                                                        <img alt="image" width="50" src="<?=base_url('backend/images/avatar/1.jpg')?>">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media mr-2 media-info">
                                                        KG
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Resport created successfully</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media mr-2 media-success">
                                                        <i class="fa fa-home"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Reminder : Treatment Time!</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                             <li>
                                                <div class="timeline-panel">
                                                    <div class="media mr-2">
                                                        <img alt="image" width="50" src="<?=base_url('backend/images/avatar/1.jpg')?>">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                           
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media mr-2 media-primary">
                                                        <i class="fa fa-home"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Reminder : Treatment Time!</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <a class="all-notification" href="#">See all notifications <i class="ti-arrow-right"></i></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                            	<a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            		<?php $settings = $this->mymodel->get('settings', true, 'settingId', '1'); ?>
                            		<?php if (@$settings->favicon) { ?>
                            			<img src="<?= base_url('uploads/logos/'.@$settings->favicon) ?>" alt="user-img" width="36" class="img-circle">
                            		<?php } else{ ?>
                            			<img src="<?= base_url('dist/images/users/user.png') ?>" alt="user-img" width="36" class="img-circle">
                            		<?php } ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="<?= admin_url('profile') ?>" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="javascript:void()" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="<?= admin_url('logout')?>" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->