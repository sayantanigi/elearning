<?php

  $become_ins_title =  clean_String($cmsContent[4]->cmsTitle);
  $become_ins_content =  clean_String($cmsContent[4]->content);
  $become_ins_img = $cmsContent[4]->image;

  $become_ins_tab_title =  clean_String($cmsContent[5]->cmsTitle);

  $become_ins_tab1_title =  clean_String($cmsContent[1]->cmsTitle);
  $become_ins_tab1_content =  html_entity_decode($cmsContent[1]->content);
  $become_ins_tab1_img = $cmsContent[1]->image;

  $become_ins_tab2_title =  clean_String($cmsContent[2]->cmsTitle);
  $become_ins_tab2_content =  html_entity_decode($cmsContent[2]->content);
  $become_ins_tab2_img = $cmsContent[2]->image;

  $become_ins_tab3_title =  clean_String($cmsContent[3]->cmsTitle);
  $become_ins_tab3_content =  html_entity_decode($cmsContent[3]->content);
  $become_ins_tab3_img = $cmsContent[3]->image;

  $help_title =  clean_String($cmsContent[0]->cmsTitle);
  $help_content =  clean_String($cmsContent[0]->content);
  $help_img = $cmsContent[0]->image;

  $become_ins_last_title =  clean_String($cmsContent[6]->cmsTitle);
  $become_ins_last_content =  clean_String($cmsContent[6]->content);
  /*print"<pre>";
  print_r($cmsContent);
  print"</pre>";exit;*/
?>

        <!-- Page Banner Section Start -->
        <div class="page-banner bg-color-04">
            <div class="page-banner__wrapper scene">

                <div>
                    <!-- Page Breadcrumb Start -->
                    <div class="page-breadcrumb">
                        <div class="container">

                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index-main.html"></a></li>
                                <li class="breadcrumb-item active"></li>
                            </ul>

                        </div>
                    </div>
                    <!-- Page Breadcrumb End -->

                    <!-- Instructor Banner Start -->
                    <div class="instructor-banner">
                        <div class="container custom-container">
                            <div class="row align-items-end align-items-xl-center">
                                <div class="col-lg-6">
                                    <!-- Instructor Banner Start -->
                                    <div class="instructor-banner__content" data-aos="fade-up" data-aos-duration="1000">

                                        <!-- Section Title Start -->
                                        <div class="section-title">
                                            <h2 class="section-title__title-03"><?=$become_ins_title?></h2>
                                            <p class="mt-2"><?=$become_ins_content?> </p>
                                        </div>
                                        <!-- Section Title End -->

                                        <a href="javascript:void(0);" class="instructor-banner__btn btn btn-primary btn-hover-secondary display_instructor_signup_modal">Start teaching today</a>
                                    </div>
                                    <!-- Instructor Banner End -->
                                </div>
                                <div class="col-lg-6">
                                    <!-- Instructor Banner Image Start -->
                                    <div class="instructor-banner__image" data-aos="fade-up" data-aos-duration="1000">
                                        <?php if ($become_ins_img && file_exists('./uploads/cms/'.$become_ins_img)) { ?>
                                            <img src="<?= base_url('uploads/cms/'.$become_ins_img) ?>" alt="Cms Image" class="service-thumb" width="727" height="347">
                                        <?php } else { ?>
                                            <img src="<?= base_url('uploads/noimg.png') ?>" alt="" width="350" height="201">
                                        <?php } ?>
                                    </div>
                                    <!-- Instructor Banner Image End -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Instructor Banner End -->
                </div>

                <div class="instructor-banner__shape-01" data-depth="-0.4"></div>
                <div class="instructor-banner__shape-02" data-depth="-0.4"></div>
                <div class="instructor-banner__shape-03" data-depth="0.4"></div>

            </div>
        </div>
        <!-- Page Banner Section End -->

        <!-- Offcanvas Start -->
        <div class="offcanvas offcanvas-end offcanvas-mobile" id="offcanvasMobileMenu" style="background-image: url(assets/images/mobile-bg.jpg);">
            <div class="offcanvas-header bg-white">
                <div class="offcanvas-logo">
                    <a class="offcanvas-logo__logo" href="#"><img src="<?=base_url()?>frontend/images/dark-logo.png" alt="Logo"></a>
                </div>
                <button type="button" class="offcanvas-close" data-bs-dismiss="offcanvas"><i class="fal fa-times"></i></button>
            </div>

            <div class="offcanvas-body">
                <nav class="canvas-menu">
                    <ul class="offcanvas-menu">
                        <li><a class="active" href="#"><span>Home</span></a>

                            <ul class="mega-menu">
                                <li>
                                    <!-- Mega Menu Content Start -->
                                    <div class="mega-menu-content">
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="menu-content-list">
                                                    <a href="index-main.html" class="menu-content-list__link">Main Demo <span class="badge hot">Hot</span></a>
                                                    <a href="index-course-hub.html" class="menu-content-list__link">Course Hub</a>
                                                    <a href="index-online-academy.html" class="menu-content-list__link">Online Academy <span class="badge hot">Hot</span></a>
                                                    <a href="index-university.html" class="menu-content-list__link">University</a>
                                                    <a href="index-education-center.html" class="menu-content-list__link">Education Center <span class="badge hot">Hot</span></a>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="menu-content-list">
                                                    <a href="index-language-academic.html" class="menu-content-list__link">Language Academic</a>
                                                    <a href="index-single-instructor.html" class="menu-content-list__link">Single Instructor</a>
                                                    <a href="index-dev.html" class="menu-content-list__link">Dev <span class="badge new">New</span></a>
                                                    <a href="index-online-art.html" class="menu-content-list__link">Online Art <span class="badge new">New</span></a>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="menu-content-banner" style="background-image: url(assets/images/home-megamenu-bg.jpg);">
                                                    <h4 class="menu-content-banner__title">Achieve Your Goals With EduMall</h4>
                                                    <a href="#" class="menu-content-banner__btn btn btn-primary btn-hover-secondary">Purchase now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Mega Menu Content Start -->
                                </li>
                            </ul>




                        </li>
                        <li>
                            <a href="#"><span>Courses</span></a>
                            <ul class="sub-menu">
                                <li><a href="course-grid-01.html"><span>Grid Basic Layout</span></a></li>
                                <li><a href="course-grid-02.html"><span>Grid Modern Layout</span></a></li>
                                <li><a href="course-grid-left-sidebar.html"><span>Grid Left Sidebar</span></a></li>
                                <li><a href="course-grid-right-sidebar.html"><span>Grid Right Sidebar</span></a></li>
                                <li><a href="course-list.html"><span>List Basic Layout</span></a></li>
                                <li><a href="course-list-left-sidebar.html"><span>List Left Sidebar</span></a></li>
                                <li><a href="course-list-right-sidebar.html"><span>List Right Sidebar</span></a></li>
                                <li><a href="course-category.html"><span>Category Page</span></a></li>
                                <li>
                                    <a href="#"><span>Single Layout</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="course-single-layout-01.html"><span>Layout 01</span></a></li>
                                        <li><a href="course-single-layout-02.html"><span>Layout 02</span></a></li>
                                        <li><a href="course-single-layout-03.html"><span>Layout 03</span></a></li>
                                        <li><a href="course-single-layout-04.html"><span>Layout 04</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span>Blog</span></a>
                            <ul class="sub-menu">
                                <li><a href="blog-grid-01.html"><span>Grid Basic Layout</span></a></li>
                                <li><a href="blog-grid-02.html"><span>Grid Wide</span></a></li>
                                <li><a href="blog-grid-left-sidebar.html"><span>Grid Left Sidebar</span></a></li>
                                <li><a href="blog-grid-right-sidebar.html"><span>Grid Right Sidebar</span></a></li>
                                <li><a href="blog-list-style-01.html"><span>List Layout 01</span></a></li>
                                <li><a href="blog-list-style-02.html"><span>List Layout 02</span></a></li>
                                <li>
                                    <a href="#"><span>Single Layouts</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="blog-details-left-sidebar.html"><span>Left Sidebar</span></a></li>
                                        <li><a href="blog-details-right-sidebar.html"><span>Right Sidebar</span></a></li>
                                        <li><a href="blog-details.html"><span>No Sidebar</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span>Pages</span></a>
                            <ul class="sub-menu">
                                <li><a href="become-an-instructor.html"><span>Become an Instructor</span></a></li>
                                <li>
                                    <a href="instructors.html"><span>Instructor</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="dashboard-my-courses.html"><span>My Courses</span></a></li>
                                        <li><a href="dashboard-announcement.html"><span>Announcements</span></a></li>
                                        <li><a href="dashboard-withdraw.html"><span>Withdrawals</span></a></li>
                                        <li><a href="dashboard-quiz-attempts.html"><span>Quiz Attempts</span></a></li>
                                        <li><a href="dashboard-question-answer.html"><span>Question & Answer</span></a></li>
                                        <li><a href="dashboard-assignments.html"><span>Assignments</span></a></li>
                                        <li><a href="dashboard-students.html"><span>My Students</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="about.html"><span>About us</span></a></li>
                                <li><a href="about-02.html"><span>About us 02</span></a></li>
                                <li><a href="contact-us.html"><span>Contact us</span></a></li>
                                <li><a href="contact-us-02.html"><span>Contact us 02</span></a></li>
                                <li><a href="membership-plans.html"><span>Membership plans</span></a></li>
                                <li><a href="faqs.html"><span>FAQs</span></a></li>
                                <li><a href="404-page.html"><span>404 Page</span></a></li>
                                <li>
                                    <a href="#"><span>Dashboard</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="dashboard-index.html"><span>Dashboard</span></a></li>
                                        <li><a href="dashboard-student-index.html"><span>Dashboard Student</span></a></li>
                                        <li><a href="dashboard-profile.html"><span>My Profile</span></a></li>
                                        <li><a href="dashboard-all-course.html"><span>Enrolled Courses</span></a></li>
                                        <li><a href="dashboard-wishlist.html"><span>Wishlist</span></a></li>
                                        <li><a href="dashboard-reviews.html"><span>Reviews</span></a></li>
                                        <li><a href="dashboard-my-quiz-attempts.html"><span>My Quiz Attempts</span></a></li>
                                        <li><a href="dashboard-purchase-history.html"><span>Purchase History</span></a></li>
                                        <li><a href="dashboard-settings.html"><span>Settings</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span>Features</span></a>
                            <ul class="sub-menu">
                                <li><a href="#"><span>Events</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="event-grid-sidebar.html"><span>Event Listing 01</span></a></li>
                                        <li><a href="event-grid.html"><span>Event Listing 02</span></a></li>
                                        <li><a href="event-list.html"><span>Event Listing 03</span></a></li>
                                        <li><a href="event-list-sidebar.html"><span>Event Listing 04</span></a></li>
                                        <li>
                                            <a href="#"><span>Single Layouts</span></a>
                                            <ul class="sub-menu">
                                                <li><a href="event-details-layout-01.html"><span>Layout 01</span></a></li>
                                                <li><a href="event-details-layout-02.html"><span>Layout 02</span></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#"><span>Shop</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="shop-default.html"><span>Shop – Default</span></a></li>
                                        <li><a href="shop-left-sidebar.html"><span>Shop – Left Sidebar</span></a></li>
                                        <li><a href="shop-right-sidebar.html"><span>Shop – Right Sidebar</span></a></li>
                                        <li><a href="my-account.html"><span>My account</span></a></li>
                                        <li><a href="wishlist.html"><span>Wishlist</span></a></li>
                                        <li><a href="cart.html"><span>Cart</span></a></li>
                                        <li><a href="cart-empty.html"><span>Cart Empty</span></a></li>
                                        <li><a href="checkout.html"><span>Checkout</span></a></li>
                                        <li>
                                            <a href="#"><span>Single Layouts</span></a>
                                            <ul class="sub-menu">
                                                <li><a href="shop-single-list-left-sidebar.html"><span>List – Left Sidebar</span></a></li>
                                                <li><a href="shop-single-list-right-sidebar.html"><span>List – Right Sidebar</span></a></li>
                                                <li><a href="shop-single-list-no-sidebar.html"><span>List – No Sidebar</span></a></li>
                                                <li><a href="shop-single-tab-left-sidebar.html"><span>Tabs – Left Sidebar</span></a></li>
                                                <li><a href="shop-single-tab-right-sidebar.html"><span>Tabs – Right Sidebar</span></a></li>
                                                <li><a href="shop-single-tab-no-sidebar.html"><span>Tabs – No Sidebar</span></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="zoom-meetings.html"><span>Zoom Meetings</span></a></li>
                                <li><a href="zoom-meetings-single.html"><span>Zoom Meeting Single</span></a></li>
                            </ul>
                        </li>

















                    </ul>
                </nav>
            </div>

            <!-- Header User Button Start -->
            <div class="offcanvas-user d-lg-none">
                <div class="offcanvas-user__button">
                    <button class="offcanvas-user__login btn btn-secondary btn-hover-secondarys" data-bs-toggle="modal" data-bs-target="#loginModal">Log In</button>
                </div>
                <div class="offcanvas-user__button">
                    <button class="offcanvas-user__signup btn btn-primary btn-hover-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Sign Up</button>
                </div>
            </div>
            <!-- Header User Button End -->

        </div>
        <!-- Offcanvas End -->

        <!-- Become an Instructor Start -->
        <div class="become-an-instructor section-padding-02">

            <div class="container custom-container">
                <!-- Section Title Start -->
                <div class="section-title text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="section-title__title-03"><?=$become_ins_tab_title?></h2>
                </div>
                <!-- Section Title End -->

                <!-- Become an instructor Start -->
                <div class="become-an-instructor__tabs" data-aos="fade-up" data-aos-duration="1000">
                    <ul class="nav justify-content-center">
                        <li><button class="active" data-bs-toggle="tab" data-bs-target="#tab1"><?=$become_ins_tab1_title?></button></li>
                        <li><button data-bs-toggle="tab" data-bs-target="#tab2"><?=$become_ins_tab2_title?></button></li>
                        <li><button data-bs-toggle="tab" data-bs-target="#tab3"><?=$become_ins_tab3_title?></button></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1">

                            <div class="row gy-10">
                                <div class="col-lg-6">

                                    <!-- Become an instructor content Start -->
                                    <div class="become-an-instructor__content">
                                        <?=$become_ins_tab1_content?>
                                    </div>
                                    <!-- Become an instructor content End -->

                                </div>
                                <div class="col-lg-6">

                                    <!-- Become an instructor Image Start -->
                                    <div class="become-an-instructor__image">
                                        <div class="become-an-instructor__svg-icon">
                                             <?php if ($become_ins_tab1_img && file_exists('./uploads/cms/'.$become_ins_tab1_img)) { ?>
                                                <img src="<?= base_url('uploads/cms/'.$become_ins_tab1_img) ?>" alt="Cms Image" class="service-thumb" width="400" height="296">
                                            <?php } else { ?>
                                                <img src="<?= base_url('uploads/noimg.png') ?>" alt="" width="350" height="201">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- Become an instructor Image End -->

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tab2">

                            <div class="row gy-10">
                                <div class="col-lg-6">

                                    <!-- Become an instructor content Start -->
                                    <div class="become-an-instructor__content">
                                        <?=$become_ins_tab2_content?>
                                    </div>
                                    <!-- Become an instructor content End -->

                                </div>
                                <div class="col-lg-6">

                                    <!-- Become an instructor Image Start -->
                                    <div class="become-an-instructor__image">
                                        <div class="become-an-instructor__svg-icon">
                                            <?php if ($become_ins_tab2_img && file_exists('./uploads/cms/'.$become_ins_tab2_img)) { ?>
                                                <img src="<?= base_url('uploads/cms/'.$become_ins_tab2_img) ?>" alt="Cms Image" class="service-thumb" width="400" height="296">
                                            <?php } else { ?>
                                                <img src="<?= base_url('uploads/noimg.png') ?>" alt="" width="350" height="201">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- Become an instructor Image End -->

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tab3">

                            <div class="row gy-10">
                                <div class="col-lg-6">

                                    <!-- Become an instructor content Start -->
                                    <div class="become-an-instructor__content">
                                        <?=$become_ins_tab3_content?>
                                    </div>
                                    <!-- Become an instructor content End -->

                                </div>
                                <div class="col-lg-6">

                                    <!-- Become an instructor Image Start -->
                                    <div class="become-an-instructor__image">
                                        <div class="become-an-instructor__svg-icon">
                                            <?php if ($become_ins_tab3_img && file_exists('./uploads/cms/'.$become_ins_tab3_img)) { ?>
                                                <img src="<?= base_url('uploads/cms/'.$become_ins_tab3_img) ?>" alt="Cms Image" class="service-thumb" width="400" height="296">
                                            <?php } else { ?>
                                                <img src="<?= base_url('uploads/noimg.png') ?>" alt="" width="350" height="201">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- Become an instructor Image End -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Become an instructor End -->

            </div>

        </div>
        <!-- Become an Instructor End -->

        <!-- Instructor Banner Start -->
        <div class="instructor-banner-02 section-padding-02">
            <div class="container custom-container">

                <!-- Instructor Banner Wrapper Start -->
                <div class="instructor-banner-02__wrapper bg-color-09">
                    <div class="row align-items-xl-center align-items-end">
                        <div class="col-lg-6">
                            <!-- Instructor Banner Content Start -->
                            <div class="instructor-banner-02__content" data-aos="fade-up" data-aos-duration="1000">
                                <h2 class="instructor-banner-02__title"><?=$help_title?></h2>
                                <p><?=$help_content?></p>
                            </div>
                            <!-- Instructor Banner Content End -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Instructor Banner Image Start -->
                            <div class="instructor-banner-02__image text-end" data-aos="fade-up" data-aos-duration="1000">
                                <?php if ($help_img && file_exists('./uploads/cms/'.$help_img)) { ?>
                                    <img src="<?= base_url('uploads/cms/'.$help_img) ?>" alt="Cms Image" class="service-thumb" width="574" height="303">
                                <?php } else { ?>
                                    <img src="<?= base_url('uploads/noimg.png') ?>" alt="" width="574" height="303">
                                <?php } ?>
                            </div>
                            <!-- Instructor Banner Image End -->
                        </div>
                    </div>
                </div>
                <!-- Instructor Banner Wrapper End -->

            </div>
        </div>
        <!-- Instructor Banner End -->

        <!-- Instructor Action Start -->
        <div class="instructor-action section-padding-01">
            <div class="container custom-container">

                <div class="instructor-action__content text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="instructor-action__main-title"><?=$become_ins_last_title?></h2>
                    <h4 class="instructor-action__sub-title"><?=$become_ins_last_content?></h4>
                    <a href="javascript:void(0);" class="instructor-action__btn btn btn-primary btn-hover-secondary display_instructor_signup_modal" href="#">Start teaching today</a>
                </div>

            </div>
        </div>
        <!-- Instructor Action End -->

       