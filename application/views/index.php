<?php
  $start_to_success_title = clean_String($cmsContent[0]->cmsTitle);
  $start_to_success_content = explode(' ',clean_String($cmsContent[0]->content));
  
  $take_your_org_nxt_title = clean_String($cmsContent[1]->cmsTitle);
  $take_your_org_nxt_content = string_seperator(clean_String($cmsContent[1]->content));
  $take_your_org_nxt_img = $cmsContent[1]->image;

  $blue_banner_txt_1 = clean_String($cmsContent[2]->cmsTitle);
  $blue_banner_img_1 = $cmsContent[2]->image;

  $blue_banner_txt_2 = clean_String($cmsContent[3]->cmsTitle);
  $blue_banner_img_2 = $cmsContent[3]->image;

  $blue_banner_txt_3 = clean_String($cmsContent[4]->cmsTitle);
  $blue_banner_img_3 = $cmsContent[4]->image;

  $blue_banner_txt_4 = clean_String($cmsContent[5]->cmsTitle);
  $blue_banner_img_4 = $cmsContent[5]->image;

  $let_us_help_title = clean_String($cmsContent[6]->cmsTitle);
  $let_us_help_content = clean_String($cmsContent[6]->content);
  $let_us_help_link = clean_String($cmsContent[6]->link);

  $testimonial_title = clean_String($cmsContent[7]->cmsTitle);
  $testimonial_content = clean_String($cmsContent[7]->content);

  $become_ins_title = clean_String($cmsContent[8]->cmsTitle);
  $become_ins_content = clean_String($cmsContent[8]->content);
  $become_ins_img = $cmsContent[8]->image;

  $access_edu_title = clean_String($cmsContent[9]->cmsTitle);
  $access_edu_content = clean_String($cmsContent[9]->content);
  $access_edu_img = $cmsContent[9]->image;
  
  /*print"<pre>";
  print_r($take_your_org_nxt_content);
  print"</pre>";exit;*/
?>

<div class="slider-section">
<div class="slider-wrapper scene">
<div class="container">
<div class="row align-items-center gy-10">
<div class="col-md-6">
<div class="slider-widget" data-aos="fade-up" data-aos-duration="1000">
<div class="slider-caption">
    <h3 class="slider-caption__sub-title"><?=$start_to_success_title?></h3>
    <h2 class="slider-caption__main-title"><?=$start_to_success_content[0]?> <?=$start_to_success_content[1]?> <mark><?=$courseData->courseCount?>+</mark> <?=$start_to_success_content[2]?> <?=$start_to_success_content[3]?> <mark><?=count($insData)?></mark> <?=$start_to_success_content[4]?> <!--& Institutions--></h2>
    <p><?=$take_your_org_nxt_title?></p>
</div>
<div class="slider-search">
    <form action="<?=base_url('courselist')?>" method="post">
        <input class="slider-search__field" placeholder="What do you want to learn?">
        <button type="submit" class="slider-search__submit">
            <i class="search-btn-icon fas fa-search"></i>
        </button>
    </form>
</div>
</div>

 
</div>
<div class="col-md-6">
<div class="slider-image">
<div class="slider-image__image text-center text-lg-end" data-aos="fade-up" data-aos-duration="1000">
    <?php if ($take_your_org_nxt_img && file_exists('./uploads/cms/'.$take_your_org_nxt_img)) { ?>
        <img src="<?= base_url('uploads/cms/'.$take_your_org_nxt_img) ?>" alt="Cms Image" class="service-thumb" width="599" height="480">
    <?php } else { ?>
        <img src="<?= base_url('uploads/noimg.png') ?>" alt="" width="599" height="480">
    <?php } ?>
</div>

<div class="slider-image-widget" data-aos="zoom-in-left" data-aos-duration="1000" data-aos-delay="1000">
    <div class="slider-image-widget__icon">
        <svg xmlns="http://www.w3.org/2000/svg')?>" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 53">
            <g fill-rule="nonzero">
                <path d="M46.2977393,23.4211436 C45.3957447,23.4211436 44.6636968,22.6890957 44.6636968,21.787101 C44.6636968,15.5297872 42.2281915,9.64946809 37.8051861,5.22446809 C37.1668883,4.58617021 37.1668883,3.55132984 37.8051861,2.91303197 C38.443484,2.27473409 39.4783245,2.27473409 40.1170213,2.91303197 C45.156383,7.95438832 47.9317819,14.6585106 47.9317819,21.787101 C47.9317819,22.6890957 47.199734,23.4211436 46.2977393,23.4211436 L46.2977393,23.4211436 Z"></path>
                <path d="M1.63404255,23.4211436 C0.732047898,23.4211436 0,22.6890957 0,21.787101 C0,14.6585106 2.77579792,7.95438832 7.81715428,2.91502662 C8.45545215,2.27672875 9.49069154,2.27672875 10.1289894,2.91502662 C10.7672873,3.55332449 10.7672873,4.58856388 10.1289894,5.22686175 C5.70398931,9.64946809 3.26808511,15.5297872 3.26808511,21.787101 C3.26808511,22.6890957 2.53603721,23.4211436 1.63404255,23.4211436 Z"></path>
                <path d="M23.9660905,52.2893617 C19.4605053,52.2893617 15.7958777,48.6247341 15.7958777,44.1191489 C15.7958777,43.2171543 16.5279256,42.4851064 17.4299202,42.4851064 C18.3319149,42.4851064 19.0639628,43.2171543 19.0639628,44.1191489 C19.0639628,46.8231382 21.262101,49.0212766 23.9660905,49.0212766 C26.6696809,49.0212766 28.8682181,46.8231382 28.8682181,44.1191489 C28.8682181,43.2171543 29.600266,42.4851064 30.5022607,42.4851064 C31.4042553,42.4851064 32.1363032,43.2171543 32.1363032,44.1191489 C32.1363032,48.6247341 28.4716755,52.2893617 23.9660905,52.2893617 L23.9660905,52.2893617 Z"></path>
                <path d="M41.9405585,45.7531915 L5.99162237,45.7531915 C3.88882979,45.7531915 2.1785904,44.0429521 2.1785904,41.9405585 C2.1785904,40.8247341 2.66449471,39.7683511 3.51223404,39.0426862 C6.82579792,36.2429521 8.71476061,32.1734043 8.71476061,27.8617021 L8.71476061,21.787101 C8.71476061,13.3775266 15.556117,6.53617021 23.9660905,6.53617021 C32.3756649,6.53617021 39.2170213,13.3775266 39.2170213,21.787101 L39.2170213,27.8617021 C39.2170213,32.1734043 41.1059841,36.2429521 44.3980053,39.0275266 C45.2672873,39.7683511 45.7531915,40.8247341 45.7531915,41.9405585 C45.7531915,44.0429521 44.0429521,45.7531915 41.9405585,45.7531915 Z M23.9660905,9.80425532 C17.3577128,9.80425532 11.9828457,15.1791223 11.9828457,21.787101 L11.9828457,27.8617021 C11.9828457,33.1360372 9.6714096,38.1167553 5.6429521,41.5220744 C5.56675527,41.5875001 5.44667551,41.7227393 5.44667551,41.9405585 C5.44667551,42.2365691 5.69521277,42.4851064 5.99162237,42.4851064 L41.9405585,42.4851064 C42.2365691,42.4851064 42.4851064,42.2365691 42.4851064,41.9405585 C42.4851064,41.7227393 42.3654255,41.5875001 42.2932181,41.5264627 C38.2603723,38.1167553 35.9489362,33.1360372 35.9489362,27.8617021 L35.9489362,21.787101 C35.9489362,15.1791223 30.5740692,9.80425532 23.9660905,9.80425532 Z"></path>
                <path d="M23.9660905,9.80425532 C23.0640958,9.80425532 22.3320479,9.07220742 22.3320479,8.17021277 L22.3320479,1.63404255 C22.3320479,0.732047898 23.0640958,0 23.9660905,0 C24.8680851,0 25.600133,0.732047898 25.600133,1.63404255 L25.600133,8.17021277 C25.600133,9.07220742 24.8680851,9.80425532 23.9660905,9.80425532 Z"></path>
            </g>
        </svg>
    </div>
    <div class="slider-image-widget__caption">
        <h4 class="slider-image-widget__title"><?=$take_your_org_nxt_content[0]?> <strong><?=$take_your_org_nxt_content[1]?></strong></h4>
    </div>
</div>
</div>

</div>
</div>
</div>

<img class="slider-section__shape-01" data-depth="0.8" src="<?=base_url('frontend/images/shape/edumall-shape-grid-dots.png')?>" alt="Shapesdfsdf" width="417" height="371">
<div class="slider-section__shape-02" data-depth="-1"></div>
<div class="slider-section__shape-03" data-depth="1.6"></div>
<img class="slider-section__shape-04" data-depth="-0.6" src="<?=base_url('frontend/images/shape/edumall-shape-01.png')?>" alt="Shape" width="179" height="178">

</div>
</div>
<div class="offcanvas offcanvas-end offcanvas-mobile" id="offcanvasMobileMenu" style="background-image: url(assets/images/mobile-bg.jpg);">
<div class="offcanvas-header bg-white">
<div class="offcanvas-logo">
<a class="offcanvas-logo__logo" href="#"><img src="<?=base_url('frontend/images/dark-logo.png')?>" alt="Logo"></a>
</div>
<button type="button" class="offcanvas-close" data-bs-dismiss="offcanvas"><i class="fal fa-times"></i></button>
</div>

<div class="offcanvas-body">
<nav class="canvas-menu">
<ul class="offcanvas-menu">
<li><a class="active" href="##"><span>Home</span></a></li>
<li><a href="#"><span>Become an Instructor</span></a></li>
</ul>
</nav>
</div>
<div class="offcanvas-user d-lg-none">
<div class="offcanvas-user__button">
<button class="offcanvas-user__login btn btn-secondary btn-hover-secondarys" data-bs-toggle="modal" data-bs-target="#loginModal">Log In</button>
</div>
<div class="offcanvas-user__button">
<button class="offcanvas-user__signup btn btn-primary btn-hover-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Sign Up</button>
</div>
</div>

</div>
<div class="features-section bg-color-primary">
<div class="container">
    
    <div class="row g-6">
        <div class="col-lg-3 col-sm-6">
            <div class="features-item" data-aos="fade-up" data-aos-duration="1000">
            <div class="features-item__icon">
            <?php if ($blue_banner_img_1 && file_exists('./uploads/cms/'.$blue_banner_img_1)) { ?>
                <img src="<?= base_url('uploads/cms/'.$blue_banner_img_1) ?>" alt="Cms Image" class="service-thumb" style="width: 60px; height: 50px;">
            <?php } else { ?>
                <img src="<?= base_url('uploads/noimg.png') ?>" alt="" style="width: 60px; height: 50px;">
            <?php } ?>
            </div>
            <div class="features-item__caption">
            <h3 class="features-item__title"><?=$blue_banner_txt_1?></h3>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="features-item" data-aos="fade-up" data-aos-duration="1000">
            <div class="features-item__icon">
            <?php if ($blue_banner_img_2 && file_exists('./uploads/cms/'.$blue_banner_img_2)) { ?>
                <img src="<?= base_url('uploads/cms/'.$blue_banner_img_2) ?>" alt="Cms Image" class="service-thumb" style="width: 60px; height: 50px;">
            <?php } else { ?>
                <img src="<?= base_url('uploads/noimg.png') ?>" alt="" style="width: 60px; height: 50px;">
            <?php } ?>
            </div>
            <div class="features-item__caption">
            <h3 class="features-item__title"><?=$blue_banner_txt_2?></h3>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="features-item" data-aos="fade-up" data-aos-duration="1000">
            <div class="features-item__icon">
            <?php if ($blue_banner_img_3 && file_exists('./uploads/cms/'.$blue_banner_img_3)) { ?>
                <img src="<?= base_url('uploads/cms/'.$blue_banner_img_3) ?>" alt="Cms Image" class="service-thumb" style="width: 60px; height: 50px;">
            <?php } else { ?>
                <img src="<?= base_url('uploads/noimg.png') ?>" alt="" style="width: 60px; height: 50px;">
            <?php } ?>
            </div>
            <div class="features-item__caption">
            <h3 class="features-item__title"><?=$blue_banner_txt_3?></h3>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="features-item" data-aos="fade-up" data-aos-duration="1000">
            <div class="features-item__icon">
            <?php if ($blue_banner_img_4 && file_exists('./uploads/cms/'.$blue_banner_img_4)) { ?>
                <img src="<?= base_url('uploads/cms/'.$blue_banner_img_4) ?>" alt="Cms Image" class="service-thumb" style="width: 60px; height: 50px;">
            <?php } else { ?>
                <img src="<?= base_url('uploads/noimg.png') ?>" alt="" style="width: 60px; height: 50px;">
            <?php } ?>
            </div>
            <div class="features-item__caption">
            <h3 class="features-item__title"><?=$blue_banner_txt_4?></h3>
            </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="top-instructer courses-section section-padding-02 pb-5">
    <div class="container">
        <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
        <h2 class="section-title__title">Top <mark>Instructors</mark> </h2>
        </div>
        <div class="owl-carousel owl-theme mb-5" id="tutor">
           <?php 
              foreach($insData as $index => $instructor){ 

                $userId = $this->session->userdata('userId'); 
                $insName = $instructor->firstName." ".$instructor->lastName; 
                $insId = $instructor->userId;

                $sql_ins_avg_review = "SELECT Count(reviewId) as ratingCount,AVG(cr.rating) as insAvgRating FROM course_review cr WHERE cr.instructorId='$userId'";
                //echo $sql_ins_avg_review;exit;
                $avgRtingData = $this->mymodel->fetch($sql_ins_avg_review, true);

                if ($instructor->profilePic && file_exists('./uploads/users/'.$instructor->profilePic)) {
                   $profilePic = base_url('uploads/users/'.$instructor->profilePic);
                }else{
                   $profilePic = base_url('dist/images/noimage.jpg');
                }
           ?>   
                <div class="item">
                    
                    <input type="hidden" id="insName_<?=$instructor->userId?>" value="<?=$insName?>">
                    <input type="hidden" id="insPicSrc_<?=$instructor->userId?>" value="<?=$profilePic?>">
                    <input type="hidden" id="insCntry_<?=$instructor->userId?>" value="<?=$instructor->origin_country?>">
                    <input type="hidden" id="insBio_<?=$instructor->userId?>" value="<?=html_entity_decode($instructor->descriptions)?>">

                    <div class="course-item aos-init tutorprofile text-center">
                        <div class="course-header">
                            <div class="course-header__thumbnail ">
                                <!--<a href="#"><img src="http://localhost/elearning/uploads/level/637deedb1306e.jpg" alt="courses" width="258" height="173"></a>-->

                                <?php if (@$instructor->profilePic && file_exists('./uploads/users/'.@$instructor->profilePic)) { ?>
                                    <a href="javascript:void(0);" onclick="showInsDetail(<?=$instructor->userId?>)"><img src="<?= base_url('uploads/users/'.@$instructor->profilePic) ?>" alt="Instructor image" width="258" height="173"></a>
                                <?php } else { ?>
                                    <a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="Instructor image" width="258" height="173"></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="course-info">
                            <h3 class="course-info__title"><a href="javascript:void(0);" onclick="showInsDetail(<?=$instructor->userId?>)"><?=ucfirst($instructor->firstName." ".$instructor->lastName)?></a></h3>
                        </div>
                        <div class="course-info__rating justify-content-center">

                            <?php if(!empty($avgRtingData->insAvgRating)){ ?> 
                                <div class="dashboard-header__user-rating">
                                    <div class="rating-star">
                                        <div class="rating-label" style="width: <?=(ceil($avgRtingData->insAvgRating)*20)?>%;"></div>
                                    </div>
                                    <p><span>(<?=$avgRtingData->ratingCount?> Ratings)</span></p>
                                </div>
                            <?php }else{ ?>    
                                <img src="<?= base_url('dist/images/no_review.png') ?>" style="width: 140px;padding-bottom: 10px;">
                            <?php } ?>    

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!--<div class="categories-section section-padding-02">
<div class="container">
<div class="section-title" data-aos="fade-up" data-aos-duration="1000">
<h2 class="section-title__title">All <mark>Courses</mark> </h2>
</div>
<div class="row g-6">
    <?php 
      if(is_array($list) && !empty($list)){
        foreach ($list as $key => $v){ 
    ?>       
   
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="categories-item" data-aos="fade-up" data-aos-duration="1000">
            <a class="categories-item__link" href="<?=base_url('course/details/'.$v->courseId)?>">
                <div class="categories-item__icon">
                    <?php if (@$v->image && file_exists('./uploads/courses/'.@$v->image)) { ?>
                        <img src="<?= base_url('uploads/courses/'.@$v->image) ?>" alt="img">
                    <?php } else { ?>
                        <img src="<?= base_url('uploads/course_no_image.png') ?>" alt="img">
                    <?php } ?>
                </div>
                <div class="categories-item__info">
                    <h3 class="categories-item__name">&nbsp;<?=@$v->courseName?></h3>
                </div>
            </a>
        </div>
    </div>

    <?php } } else{ ?>
    
      <div class="categories-item__info">
        <h3 class="categories-item__name">No course available at this moment!</h3>
      </div>

    <?php } ?>  

</div>

</div>
</div>-->
<div class="courses-section section-padding-02">
<div class="container">

<div class="row">
<div class="col-lg-6">

<!-- Section Title Start -->
<div class="section-title" data-aos="fade-up" data-aos-duration="1000">
<h2 class="section-title__title">Top <mark>Courses</mark> </h2>
</div>
<!-- Section Title End -->

</div>
<div class="col-lg-6">
<div class="courses-tab-menu" data-aos="fade-up" data-aos-duration="1000">
<ul class="nav justify-content-lg-end">
<li><button class="active" data-bs-toggle="tab" data-bs-target="#tab1">All</button></li>
<!--<li><button data-bs-toggle="tab" data-bs-target="#tab2">Trending</button></li>-->
<li><button data-bs-toggle="tab" data-bs-target="#tab2">Popular</button></li>
</ul>
</div>
</div>
</div>

<div class="tab-content">

    <div class="tab-pane fade show active" id="tab1">

      <div class="row row-cols-xl-5 g-6">

        <?php 
          if(is_array($courseList) && !empty($courseList)){
            foreach ($courseList as $key => $v){ 
        ?>   

            <div class="col-xl col-lg-3 col-md-4 col-sm-6">

                <!-- Course Start -->
                <div class="course-item" data-aos="fade-up" data-aos-duration="1000">
                    <div class="course-header">
                        <div class="course-header__thumbnail ">
                            <?php if (@$v->level_image && file_exists('./uploads/level/'.@$v->level_image)) { ?>
                                <a href="<?=base_url('course/details/'.$v->courseId.'/'.$v->level)?>"><img src="<?= base_url('uploads/level/'.@$v->level_image) ?>" alt="img" width="258" height="173"></a>
                            <?php } else { ?>
                                <a href="<?=base_url('course/details/'.$v->courseId.'/'.$v->level)?>"><img src="<?= base_url('uploads/course_no_image.png') ?>" alt="img" width="258" height="173"></a>
                            <?php } ?>  
                        </div>
                    </div>
                    <div class="course-info">
                        <div class="text-center"><span class="course-info__badge-text badge-all"><?=ucfirst(@$v->level)?></span></div>
                        <h3 class="course-info__title text-center"><a href="<?=base_url('course/details/'.$v->courseId.'/'.$v->level)?>"><?=@$v->courseName?></a></h3>
                        <!--<a href="<?=base_url('course/details/'.$v->courseId)?>" class="course-info__instructor">parra</a>-->
                        <div class="course-info__price ">
                            <span class="d-flex justify-content-between">
                                <small class="sale-price">$<?=@$v->lvlCost?></small>
                                <small class="sale-price">&nbsp;<i class="fa fa-clock"></i>&nbsp;<?=$v->totalHours?>&nbsp;Hours</small>
                            </span>
                        </div>
                        <!--<div class="course-info__rating')?>">

                            <div class="rating-star">
                                <div class="rating-label" style="width: 80%;"></div>
                            </div>

                            <span>(2)</span>
                        </div>-->
                    </div>
                </div>
                <!-- Course End -->

            </div>
        
          <?php } } else{ ?>
    
              <div class="categories-item__info">
                <h3 class="categories-item__name">No course available at this moment!</h3>
              </div>

          <?php } ?>  

     </div>   

    </div>

    <div class="tab-pane fade" id="tab2">

      <div class="row row-cols-xl-5 g-6">
        
        <?php 
          if(is_array($purchasedCourse) && !empty($purchasedCourse)){
            foreach ($purchasedCourse as $key => $v){ 
        ?>   

            <div class="col-xl col-lg-3 col-md-4 col-sm-6">

                <!-- Course Start -->
                <div class="course-item" data-aos="fade-up" data-aos-duration="1000">
                    <div class="course-header">
                        <div class="course-header__thumbnail ">
                            <?php if (@$v->level_image && file_exists('./uploads/level/'.@$v->level_image)) { ?>
                                <a href="<?=base_url('course/details/'.$v->courseId)?>"><img src="<?= base_url('uploads/level/'.@$v->level_image) ?>" alt="img" width="258" height="173"></a>
                            <?php } else { ?>
                                <a href="<?=base_url('course/details/'.$v->courseId)?>"><img src="<?= base_url('uploads/course_no_image.png') ?>" alt="img" width="258" height="173"></a>
                            <?php } ?>  
                        </div>
                    </div>
                    <div class="course-info">
                        <div class="text-center"><span class="course-info__badge-text badge-all"><?=ucfirst(@$v->level)?></span></div>
                        <h3 class="course-info__title text-center"><a href="<?=base_url('course/details/'.$v->courseId)?>"><?=@$v->courseName?></a></h3>
                        <!--<a href="<?=base_url('course/details/'.$v->courseId)?>" class="course-info__instructor">parra</a>-->
                        <div class="course-info__price ">
                            <span class="d-flex justify-content-between">
                                <small class="sale-price">$<?=@$v->lvlCost?></small>
                                <small class="sale-price">&nbsp;<i class="fa fa-clock"></i>&nbsp;<?=$v->totalHours?>&nbsp;Hours</small>
                            </span>
                        </div>
                        <!--<div class="course-info__rating')?>">

                            <div class="rating-star">
                                <div class="rating-label" style="width: 80%;"></div>
                            </div>

                            <span>(2)</span>
                        </div>-->
                    </div>
                </div>
                <!-- Course End -->

            </div>
        
          <?php } } else{ ?>
    
              <div class="categories-item__info">
                <h3 class="categories-item__name">No course available at this moment!</h3>
              </div>

          <?php } ?>  


     </div>   

    </div>

</div>

</div>
</div>
<!-- Course Section End -->

<!-- Call To Action Start -->
<div class="call-to-action section-padding-02">
<div class="container">

<!-- Call To Action Wrapper Start -->
<div class="call-to-action__wrapper">

<!-- Call To Action Icon Start -->
<div class="call-to-action__icon" data-aos="zoom-in" data-aos-duration="1000">
<i class="fas fa-bolt"></i>
</div>
<!-- Call To Action Icon End -->

<!-- Call To Action Content Start -->
<div class="call-to-action__content">

<div class="call-to-action__shape-01"></div>
<div class="call-to-action__shape-02"></div>
<div class="call-to-action__shape-03"></div>

<div class="call-to-action__caption">
<h3 class="call-to-action__sub-title"><?=$let_us_help_title?></h3>
<h3 class="call-to-action__main-title"><?=$let_us_help_content?></h3>
</div>
<div class="call-to-action__btn">
<a href="<?=base_url($let_us_help_link)?>" class="btn btn-secondary btn-hover-primary">Get started</a>
</div>

</div>
<!-- Call To Action Content End -->

</div>
<!-- Call To Action Wrapper End -->

</div>
</div>
<!-- Call To Action End -->

<?php if(count($courseReviewData)>0){ ?>
<!-- Testimonial Start -->
    <div class="testimonial-section section-padding-02">
    <div class="container">
    <div class="row gy-10">
    <div class="col-lg-3 col-md-6">
    <!-- Section Title Start -->
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="section-title__title"><mark><?=$testimonial_title?></mark> </h2>
    <p><?=$testimonial_content?></p>
    </div>
    <!-- Section Title End -->
    </div>
    <div class="col-lg-9">

    <div class="testimonial-active swiper-dots-style" data-aos="fade-up" data-aos-duration="1000">
    <div class="swiper">
      <div class="swiper-wrapper">
        
        <?php foreach($courseReviewData as $index => $review){ ?>
        <div class="swiper-slide">
            <!-- Testimonial Item Start -->
            <div class="testimonial-item">
                <div class="testimonial-quote-icon">
                    <svg xmlns="http://www.w3.org/2000/svg')?>" version="1.1" width="50px" height="40px" viewBox="0 0 50 40">
                        <path d="M21.8750977,2.18046875 C22.4503906,2.18046875 22.9167969,1.7140625 22.9167969,1.13876953 C22.9167969,0.563476562 22.4503906,0.0970703125 21.8750977,0.0970703125 C9.79960938,0.110839844 0.0138671875,9.89658203 2.76635467e-06,21.9720703 L2.76635467e-06,28.2220703 C-0.01796875,34.56875 5.11230469,39.728418 11.4588867,39.7465793 C17.8055664,39.7645508 22.9652344,34.6342773 22.9833957,28.2876953 C23.0013672,21.9410156 17.8710938,16.7813477 11.5245117,16.7632813 C7.77705078,16.7526367 4.25966797,18.5698242 2.10009766,21.6325195 C2.29296875,10.8446289 11.0853516,2.19580078 21.8750977,2.18046875 Z"></path>
                        <path d="M38.5416992,16.7638672 C34.8157227,16.7667969 31.3244141,18.5832031 29.1833984,21.6326172 C29.3763672,10.8446289 38.16875,2.19580078 48.9583984,2.18056641 C49.5336914,2.18056641 50.0000977,1.71416016 50.0000977,1.13886719 C50.0000977,0.563574219 49.5336914,0.0971679688 48.9583984,0.0971679688 C36.8829102,0.1109375 27.097168,9.89667969 27.0833984,21.972168 L27.0833984,28.222168 C27.0833984,34.5503906 32.2134766,39.6804687 38.5416992,39.6804687 C44.8699219,39.6804687 50.0000977,34.5503906 50.0000977,28.222168 C50.0000977,21.8939453 44.8700195,16.7638672 38.5416992,16.7638672 Z"></path>
                    </svg>
                </div>
                <div class="testimonial-main-content">
                    <div class="testimonial-caption">
                        <!--<h3 class="testimonial-caption__title">Great quality!</h3>-->
                        <div class="dashboard-course-item__rating">
                            <div class="rating-star">
                                <div class="rating-label" style="width: <?=($review->rating*20)?>%;"></div>
                            </div>
                        </div>
                        <p><?=$review->feedback?></p>
                    </div>
                    <div class="testimonial-info">
                        <div class="testimonial-info__image">
                            <?php if (@$review->student_image && file_exists('./uploads/users/'.@$review->student_image)) { ?>
                                <img src="<?= base_url('uploads/users/'.@$review->student_image) ?>" alt="<?= $review->studentName ?>" style="width: 60px;height: 60px;">
                            <?php } else { ?>
                                <img src="<?= base_url('uploads/noimg.png') ?>" alt="<?= $v->courseName ?>">
                            <?php } ?>

                        </div>
                        


                        <div class="testimonial-info__caption">
                            <h5 class="testimonial-info__name"><?=$review->studentName?></h5>
                            <p class="testimonial-info__designation"><?=$review->courseName?>/ <?=ucfirst($review->courseLvl)?></p>
                        </div>

                    </div>

                </div>
            </div>
            <!-- Testimonial Item End -->
        </div>    
    <?php } ?>
    </div>
    <div class="swiper-pagination"></div>

    </div>
    </div>
<?php } ?>    

</div>
</div>
</div>
</div>
<div class="banner-section section-padding-02">
<div class="container">
<div class="row gy-8 mb-5">
<div class="col-lg-6">
<div class="banner-box banner-bg-1" data-aos="fade-up" data-aos-duration="1000">
<div class="row gy-4 gy-sm-0 align-items-end">
<div class="col-xxl-6 col-md-7">
    <div class="banner-caption">
        <h3 class="banner-caption__title"><?=$become_ins_title?></h3>
        <p><?=$become_ins_content?></p>
        <a href="javascript:void(0);" class="banner-caption__btn btn btn-primary btn-hover-secondary display_instructor_signup_modal">Start teaching today</a>
    </div>
</div>
<div class="col-xxl-6 col-md-5">
    <div class="banner-image banner-position">
        <?php if ($become_ins_img && file_exists('./uploads/cms/'.$become_ins_img)) { ?>
            <img src="<?= base_url('uploads/cms/'.$become_ins_img) ?>" alt="Cms Image" class="service-thumb" width="350" height="201">
        <?php } else { ?>
            <img src="<?= base_url('uploads/noimg.png') ?>" alt="" width="350" height="201">
        <?php } ?>
    </div>
</div>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="banner-box banner-bg-2" data-aos="fade-up" data-aos-duration="1000">
<div class="row gy-4 gy-sm-0 align-items-end">
<div class="col-md-7">
    <div class="banner-caption">
        <h3 class="banner-caption__title"><?=$access_edu_title?></h3>
        <p><?=$access_edu_content?></p>
        <a href="javascript:void(0);" class="banner-caption__btn btn btn-primary btn-hover-secondary display_student_signup_modal">Register for free</a>
    </div>
</div>
<div class="col-md-5">
    <div class="banner-image banner-position-02">
        <?php if ($access_edu_img && file_exists('./uploads/cms/'.$access_edu_img)) { ?>
            <img src="<?= base_url('uploads/cms/'.$access_edu_img) ?>" alt="Cms Image" class="service-thumb" width="260" height="199">
        <?php } else { ?>
            <img src="<?= base_url('uploads/noimg.png') ?>" alt="" width="350" height="201">
        <?php } ?>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="showInsDetail">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-wrapper">
            <button type="button" class="modal-close btn-close" data-bs-dismiss="modal"><i class="fal fa-times"></i></button>     
            <div class="modal-content model_req p-4">
                <div class="modal-body">
                    <div class="text-center mb-3" id="ins_profilePic">
                        <img src="http://localhost/elearning/uploads/users/6315a6458453e.jpg" alt="instructors" class="pop-user">
                    </div>
                    <h4 class="text-center mb-3">
                        <span id="ins_name">Eugenia Talley</span><br>
                    </h4>
                    <h5 class="text-center" id="ins_origin_country">India</h5>

                    <div class="d-flex justify-content-md-between mt-4">
                        <div class="contentmodal" id="ins_detail"></div>

                        <div class="col-lg-5 popupvideo ps-lg-3">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/xcJtL7QggTI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     
     function showInsDetail(instructorId){
        var insName = $("#insName_"+instructorId).val();
        var insPicSrc = $("#insPicSrc_"+instructorId).val();
        var origin_country = $("#insCntry_"+instructorId).val(); 
        var insBio = $("#insBio_"+instructorId).val();

        var ins_Pic = '<img src="'+insPicSrc+'" alt="instructors" class="pop-user">';

        //Populating modal content before display modal
        $("#ins_name").text(insName);
        $("#ins_profilePic").html(ins_Pic);
        $("#ins_origin_country").text(origin_country);

        if(insBio.length>0){
            $("#ins_detail").text(insBio);
        }else{
            $("#ins_detail").html('No bio available for this instructor at this moment.');
        }    

        //Show modal
        $('#showInsDetail').modal('show');
    } 
</script>    
