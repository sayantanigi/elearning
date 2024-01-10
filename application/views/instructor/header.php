<?php 
   $userId = $this->session->userdata('userId');
   $settings = $this->mymodel->get('settings', true, 'settingId', '1'); 
   $myInfo= $this->mymodel->get('users', true, 'userId', $this->session->userdata('userId'));

   $ins_approve_status = $myInfo->approve_status;

   $sql_ins_avg_review = "SELECT Count(reviewId) as ratingCount,AVG(cr.rating) as insAvgRating FROM course_review cr WHERE cr.instructorId='$userId'";
   //echo $sql_ins_avg_review;exit;
   $avgRtingData = $this->mymodel->fetch($sql_ins_avg_review, true);

   $sql_enrolled_students = "SELECT c.courseId,c.courseName,sbc.courseLvl,u.userId,u.firstName,u.lastName,u.email,u.profilePic as profile_pic,u.created,sct.conferenceId,sct.meeting_url,sct.passcode FROM student_booked_classes sbc LEFT JOIN users u ON ( sbc.studentId = u.userId AND u.userType = '1' ) LEFT JOIN courses c ON (sbc.courseId = c.courseId) LEFT JOIN session_conference_tbl sct ON ( sbc.studentId = sct.studentId AND sbc.instructorId = sct.instructorId AND sbc.courseId = sct.courseId AND sbc.courseLvl = sct.courseLvl ) WHERE sbc.instructorId = '".$userId."' GROUP BY sbc.studentId,sbc.courseLvl ORDER BY sbc.classId";  

    //echo $sql_enrolled_students;exit;

    //Feching Enrolled Course List 
    $studentData = $this->mymodel->fetch($sql_enrolled_students, false);
    $studentCount = count($studentData);
    
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
    <link rel="stylesheet" href="<?= base_url('plugins/sweetalert/sweetalert.css');?>"> 

    <link rel="stylesheet" href="<?=base_url('frontend/css/plugins/toastr.min.css')?>">
    
    <?php if($page == "profilesetting"){ ?>
        <link rel="stylesheet" href="<?= base_url('plugins/intelInput/intlTelInput.css');?>"> 
    <?php } ?>    
    
    <link rel="stylesheet" href="<?= base_url('frontend/css/plugins/fullcalendar.css');?>">

    <link rel="stylesheet" href="<?=base_url()?>frontend/css/plugins/jquery-ui.css">

    <link rel="stylesheet" href="<?=base_url()?>frontend/css/plugins/timepicker.min.css">

    <!-- Jquery Lightbox Css -->
    <link href="<?= base_url('backend/vendor/jquery-lightbox/css/jquery.fancybox.min.css') ?>" rel="stylesheet"> 
    <!----END HERE---->

    <!-----JQUERY UI CSS------>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!----END HERE---->

    <!-- Additional Admin Css -->
    
    <link href="<?= base_url('backend/vendor/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <!--End Here-->

    <!-- DROPZONE Css -->
    <link rel="stylesheet" href="<?= base_url('plugins/dropzone/dropzone.min.css');?>"> 
    <!--End Here-->
    
    <link rel="stylesheet" href="<?=base_url('frontend/css/style.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/custom.css')?>">

    <style>
        .dropdown-active{
            background-color: #0071dc!important;
            color: #FFFFFF!important;
        }
        .dropdown-active i{
            color: #FFFFFF!important;
        }
    </style>

    <script src="<?=base_url('frontend/js/vendor/jquery-3.6.0.min.js')?>"></script>

    <script>
        var baseUrl = '<?=base_url()?>';
        var validator;
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
                    <a class="logo" href="<?=base_url()?>">
                        <?php if(!empty($settings->logo)){ ?>
                            <img src="<?= base_url('uploads/logos/'.@$settings->logo) ?>" alt="Logo" width="148" height="62">
                        <?php } else { ?>
                            <img src="<?=base_url('uploads/nouser.png')?>" class="img-responsive" width="90" height="90">
                        <?php } ?>
                    </a>
                </div>
            </div>

            <input type="hidden" id="pageName" value="<?=$page?>">

            <div class="offcanvas-body dashboard-nav__content navScroll">
                <div class="dashboard-nav__menu">
                    <ul class="dashboard-nav__menu-list">

                        <?php if($ins_approve_status == 1){ ?>
                            <li class="<?= (!empty($page) && $page == 'dashboard')? 'active' : ''; ?>">
                                <a href="<?=base_url('instructor/dashboard')?>">
                                    <i class="edumi edumi-layers"></i>
                                    <span class="text">Dashboard</span>
                                </a>
                            </li>

                            <li class="<?= (!empty($page) && $page == 'subjectlist')? 'active' : ''; ?>">
                                <a href="<?=base_url('instructor/subjects')?>">
                                    <i class="edumi edumi-youtuber"></i>
                                    <span class="text">My Subjects</span>
                                </a>
                            </li>

                             <li class="dropdown">
                              <a class="dropdown-toggle <?= (!empty($page) && $page == 'courselist')? 'dropdown-active' : ''; ?>" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="edumi edumi-youtuber"></i> <span class="text">My Courses</span>
                              </a>

                              <ul class="dropdown-menu p-1" aria-labelledby="dropdownMenuLink">
                                 <li class="<?= (!empty($page) && $subpage == 'assignedcourselist')? 'active' : ''; ?>"><a class="dropdown-item" href="<?=base_url('instructor/assigned-course-list')?>"><i class="fa fa-list"></i> Assigned Courses</a></li>

                                 <li class="<?= (!empty($page) && $subpage == 'createdcourselist')? 'active' : ''; ?>"><a class="dropdown-item" href="<?=base_url('instructor/my-created-course')?>"><i class="fa fa-clock"></i> Created Course</a></li>
                              </ul>
                            </li>

                            <li class="dropdown">
                              <a class="dropdown-toggle <?= (!empty($page) && $page == 'calendar')? 'dropdown-active' : ''; ?>" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="far fa-calendar"></i> <span class="text">Calendar</span>
                              </a>

                              <ul class="dropdown-menu p-1" aria-labelledby="dropdownMenuLink">
                                 <li class="<?= (!empty($page) && $subpage == 'viewschedule')? 'active' : ''; ?>"><a class="dropdown-item" href="<?=base_url('instructor/scheduleclasses')?>"><i class="fa fa-calendar"></i> View Schedule</a></li>

                                 <li class="<?= (!empty($page) && $subpage == 'addschedule')? 'active' : ''; ?>"><a class="dropdown-item" href="<?=base_url('instructor/createSchedule')?>"><i class="fa fa-clock"></i> Schedule</a></li>
                                <!--<li><a class="dropdown-item" href="<?=base_url('instructor/addScheduleDate')?>"><i class="fa fa-clock"></i> Sessions</a></li>-->
                                <li class="<?= (!empty($page) && $subpage == 'viewclasses')? 'active' : ''; ?>"><a class="dropdown-item" href="<?=base_url('instructor/viewclasses')?>"><i class="fa fa-book"></i> View Booked Classes</a></li>
                              </ul>
                            </li>

                            <?php if($studentCount>0){ ?>
                                <li class="<?= (!empty($page) && $page == 'studentlist')? 'active' : ''; ?>">
                                    <a href="<?=base_url('instructor/studentlist')?>">
                                        <i class="edumi edumi-users"></i>
                                        <span class="text">My Students</span>
                                    </a>
                                </li>
                            <?php } ?>    
                        </ul>

                   <?php } ?>     
                    
                    <ul class="dashboard-nav__menu-list">
                        <li class="<?= (!empty($page) && $page == 'settings')? 'active' : ''; ?>">
                            <a href="<?=base_url('instructor/settings')?>">
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
                        <?php if(!empty($myInfo->profilePic)){ ?>
                          <img src="<?= base_url('./uploads/users/').@$myInfo->profilePic ?>" width="90" height="90" alt="<?= @$myInfo->lastName ?>">
                        <?php } else { ?>
                          <img src="<?=base_url('uploads/nouser.png')?>" class="img-responsive" width="90" height="90">
                        <?php } ?>
                    </div>
                    <div class="dashboard-header__user-info">
                        <h4 class="dashboard-header__user-name"><span class="welcome-text">Howdy,</span> <?=$myInfo->firstName?> &nbsp;</span><?=$myInfo->lastName?></h4>
                            <?php if(!empty($avgRtingData->insAvgRating)){ ?> 
                                <div class="dashboard-header__user-rating">
                                    <div class="rating-star">
                                        <div class="rating-label" style="width: <?=(ceil($avgRtingData->insAvgRating)*20)?>%;"></div>
                                    </div>
                                    <p><?=number_format((float)$avgRtingData->insAvgRating, 2, '.', '');?> <span>(<?=$avgRtingData->ratingCount?> Ratings)</span></p>
                                </div>
                            <?php }else{ ?>    
                                <img src="<?= base_url('dist/images/no_review.png') ?>" style="width: 140px;padding-bottom: 10px;">
                            <?php } ?>    
                    </div>
                 </div>
                 <div id="google_translate_element"></div>
                   <div class="dashboard-header__btn">
                        <!--<a class="btn btn-outline-primary" href="#"><i class="edumi edumi-content-writing"></i> <span class="text">Add A New Course </span></a>-->
                    </div>
                    <div class="dashboard-header__btn">
                        <!--<a class="btn btn-outline-primary" href="#" data-bs-toggle="modal" data-bs-target="#rewquestModal" data-backdrop="static" data-keyboard="false"  data-toggle="modal"><span class="text">Send Request for Approval </span></a>-->
                    </div>

            </div>
        </div>
    </div>