<?php 
    $settings = $this->mymodel->get('settings', true, 'settingId', '1'); 
    $subjects = $this->mymodel->get('subjects', false);
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
    <link rel="stylesheet" href="<?= base_url('frontend/css/owl.carousel.min.css');?>"> 
    <link rel="stylesheet" href="<?=base_url('frontend/css/style.css')?>">
    <link rel="stylesheet" href="<?=base_url('frontend/css/custom.css')?>">

    <script src="<?=base_url('frontend/js/vendor/jquery-3.6.0.min.js')?>"></script>
    <script>
        var baseUrl = "<?=base_url()?>";
        var adminUrl = "<?=admin_url()?>";
    </script>

</head>
<body>
    <main class="main-wrapper">
        <div class="header-section header-sticky">
            <div class="header-top d-none d-sm-block">
                <div class="container">
                    <div class="header-top-bar-wrap">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="header-top-bar-wrap__text">
                                    <p>
                                        Keep learning with free resources during <strong>COVID-19.</strong> <a href="#">Learn more</a>

                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div id="google_translate_element"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="header-main">
                <div class="container">
                    <div class="header-main-wrapper">
                        <div class="header-logo">
                            <a class="header-logo__logo" href="<?=base_url()?>"><img src="<?= base_url('uploads/logos/'.@$settings->logo) ?>" width="296" height="64" alt="Logo"></a>
                        </div>
                        <div class="header-category-menu d-none d-xl-block">
                            <a href="<?=base_url('courselist')?>" class="header-category-toggle">
                                <div class="header-category-toggle__icon">
                                    <svg width="18px" height="18px" viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg')?>" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g stroke="none" stroke-width="1" fill-rule="evenodd">
                                            <path d="M2,14 C3.1045695,14 4,14.8954305 4,16 C4,17.1045695 3.1045695,18 2,18 C0.8954305,18 0,17.1045695 0,16 C0,14.8954305 0.8954305,14 2,14 Z M9,14 C10.1045695,14 11,14.8954305 11,16 C11,17.1045695 10.1045695,18 9,18 C7.8954305,18 7,17.1045695 7,16 C7,14.8954305 7.8954305,14 9,14 Z M16,14 C17.1045695,14 18,14.8954305 18,16 C18,17.1045695 17.1045695,18 16,18 C14.8954305,18 14,17.1045695 14,16 C14,14.8954305 14.8954305,14 16,14 Z M2,7 C3.1045695,7 4,7.8954305 4,9 C4,10.1045695 3.1045695,11 2,11 C0.8954305,11 0,10.1045695 0,9 C0,7.8954305 0.8954305,7 2,7 Z M9,7 C10.1045695,7 11,7.8954305 11,9 C11,10.1045695 10.1045695,11 9,11 C7.8954305,11 7,10.1045695 7,9 C7,7.8954305 7.8954305,7 9,7 Z M16,7 C17.1045695,7 18,7.8954305 18,9 C18,10.1045695 17.1045695,11 16,11 C14.8954305,11 14,10.1045695 14,9 C14,7.8954305 14.8954305,7 16,7 Z M2,0 C3.1045695,0 4,0.8954305 4,2 C4,3.1045695 3.1045695,4 2,4 C0.8954305,4 0,3.1045695 0,2 C0,0.8954305 0.8954305,0 2,0 Z M9,0 C10.1045695,0 11,0.8954305 11,2 C11,3.1045695 10.1045695,4 9,4 C7.8954305,4 7,3.1045695 7,2 C7,0.8954305 7.8954305,0 9,0 Z M16,0 C17.1045695,0 18,0.8954305 18,2 C18,3.1045695 17.1045695,4 16,4 C14.8954305,4 14,3.1045695 14,2 C14,0.8954305 14.8954305,0 16,0 Z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="header-category-toggle__text">Courses</div>
                            </a>

                            <div class="header-category-dropdown-wrap">
                                <ul class="header-category-dropdown">                                   
                                    <?php foreach ($subjects as $key => $sub): ?>
                                        <?php 
                                            //FETCHING COURSE'S SUBJECT
                                            $sql_crs= "SELECT c.courseId,c.courseName FROM `courses` c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE chp.subjectId='".$sub->subjectId."' GROUP BY c.courseId";
                                            //echo $sql_crs;exit;
                                            $courseList=  $this->mymodel->fetch($sql_crs, false);  
                                            $totalCourses = count($courseList);  
                                        ?>
                                        <li><a href="javascript:void(0);"><?=$sub->subjectName?> <?= ($totalCourses >= 1)? '<span class="toggle-sub-menu"></span>' : ''; ?> </a>
                                            <?php if($totalCourses >= 1) { ?>
                                                <ul class="sub-categories children">
                                                  <?php 
                                                     foreach ($courseList as $key => $crs): 

                                                        $sql_lvl= "SELECT GROUP_CONCAT(cl.level) as levelStr FROM `course_level_details` cl WHERE cl.courseId='".$crs->courseId."'";
                                                        $levelData = $this->mymodel->fetch($sql_lvl, true);  
                                                        $levelArr = explode(',', $levelData->levelStr);
                                                  ?>
                                                    <li><a href="<?=base_url('course/details/'.$crs->courseId.'/'.$levelArr[0])?>"><?=$crs->courseName?></a></li> 
                                                  <?php endforeach ?>
                                                </ul>
                                            <?php }?>
                                        </li>
                                    <?php endforeach ?>
                                  
                                </ul>
                            </div>
                        </div>
                        <div class="header-inner">
                            <div class="header-serach">
                                <form action="<?=base_url('courselist')?>" method="post">
                                    <input type="text" name="search_text" class="header-serach__input" placeholder="Search...">
                                    <button type="submit" class="header-serach__btn"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                            <div class="header-navigation d-none d-xl-block">
                                <nav class="menu-primary">
                                    <ul class="menu-primary__container">
                                        <li><a class="active" href="<?=base_url()?>"><span>Home</span></a></li>
                                        <?php if (!$this->session->has_userdata('instructor')){ ?>
                                        <li><a href="<?=base_url('become-a-instructor')?>"><span>Become an Instructor</span></a></li>
                                    <?php }?>
                                    </ul>
                                </nav>
                            </div>
                            <!--<div class="header-action">
                                <a href="#" class="header-action__btn">
                                    <i class="far fa-shopping-cart"></i>
                                    <span class="header-action__number">3</span>
                                </a>
                                <div class="header-mini-cart">
                                    <ul class="header-mini-cart__product-list ">
                                        <li class="header-mini-cart__item">
                                            <a href="#" class="header-mini-cart__close"></a>
                                            <div class="header-mini-cart__thumbnail">
                                                <a href="#"><img src="<?=base_url('frontend/images/product/product-1.png')?>" alt="Product" width="80" height="93"></a>
                                            </div>
                                            <div class="header-mini-cart__caption">
                                                <h3 class="header-mini-cart__name"><a href="#">Awesome for Websites</a></h3>
                                                <span class="header-mini-cart__quantity">1 × <strong class="amount">$49</strong><span class="separator">.00</span></span>
                                            </div>
                                        </li>
                                        <li class="header-mini-cart__item">
                                            <a href="#" class="header-mini-cart__close"></a>
                                            <div class="header-mini-cart__thumbnail">
                                                <a href="#"><img src="<?=base_url('frontend/images/product/product-2.png')?>" alt="Product" width="80" height="93"></a>
                                            </div>
                                            <div class="header-mini-cart__caption">
                                                <h3 class="header-mini-cart__name"> <a href="#">Awesome for Websites</a></h3>
                                                <span class="header-mini-cart__quantity">1 × <strong class="amount">$49</strong><span class="separator">.00</span></span>
                                            </div>
                                        </li>
                                        <li class="header-mini-cart__item">
                                            <a href="#" class="header-mini-cart__close"></a>
                                            <div class="header-mini-cart__thumbnail">
                                                <a href="#"><img src="<?=base_url('frontend/images/product/product-3.png')?>" alt="Product" width="80" height="93"></a>
                                            </div>
                                            <div class="header-mini-cart__caption">
                                                <h3 class="header-mini-cart__name"> <a href="#">Awesome for Websites</a></h3>
                                                <span class="header-mini-cart__quantity">1 × <strong class="amount">$49</strong><span class="separator">.00</span></span>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="header-mini-cart__footer">
                                        <div class="header-mini-cart__total">
                                            <p class="header-mini-cart__label">Total:</p>
                                            <p class="header-mini-cart__value">$445<span class="separator">.99</span></p>
                                        </div>
                                        <div class="header-mini-cart__btn">
                                            <a href="" class="btn btn-primary btn-hover-secondary">View cart</a>
                                            <a href="" class="btn btn-primary btn-hover-secondary">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <div class="header-user d-none d-lg-flex">

                                <?php if ($this->session->has_userdata('userId') && $this->session->has_userdata('student')){?>

                                    <nav class="menu-primary">
                                        <ul class="menu-primary__container">
                                            <li><a class="" href="<?=base_url('student/dashboard')?>"><span>Dashboard</span></a></li>
                                            <li><a href="<?=base_url('login/logout')?>">Logout</a></li>
                                        </ul>
                                    </nav>

                                <?php }  else if ($this->session->has_userdata('userId') && $this->session->has_userdata('instructor')){ ?>
                                    <nav class="menu-primary">
                                        <ul class="menu-primary__container">
                                            <li><a class="" href="<?=base_url('instructor/dashboard')?>"><span>Dashboard</span></a></li>
                                            <li><a href="<?=base_url('login/logout')?>">Logout</a></li>
                                        </ul>
                                    </nav>
                            <?php } else { ?> 
                                <div class="header-user__button">
                                    <button class="header-user__login" data-bs-toggle="modal" data-bs-target="#loginModal" data-backdrop="static" data-keyboard="false"  data-toggle="modal">Log In</button>
                                </div>
                                <div class="header-user__button">
                                    <button class="header-user__signup btn btn-primary btn-hover-primary" id="userRegisterModalOpening">Sign Up</button>
                                </div>
                            <?php }?>                             
                                
                            </div>
                            <div class="header-toggle">
                                <button class="header-toggle__btn d-xl-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMobileMenu">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                </button>
                                <button class="header-toggle__btn search-open d-flex d-md-none">
                                    <span class="dots"></span>
                                    <span class="dots"></span>
                                    <span class="dots"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>