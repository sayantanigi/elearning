<?php
  //Formatting all chapters under various level subjects
  $beginnerSubList = array();
  $interSubList = array();
  $advanceSubList = array();

  if (!empty($courseSubjectData) && (count($courseSubjectData) > 0)) {
      foreach ($courseSubjectData as $key => $subject) {

         if($subject->level == "beginner"){
            $beginnerSubData = explode('&%*$!',$subject->subjectData);

            $beginner_intro_video = $subject->intro_video;
            $beginnerDesc = $subject->descriptions;

            foreach($beginnerSubData as $index => $lvlSubject){
                $subjectData = explode('-',$lvlSubject);
                $beginnerSubList[$index]['subjectId'] = $subjectData[0];
                $beginnerSubList[$index]['subjectName'] = $subjectData[1];
                $beginnerSubList[$index]['image'] = $subjectData[2];
            }
            $beginnerSubList = json_decode(json_encode($beginnerSubList));
         }

         if($subject->level == "intermediate"){
            $interSubData = explode('&%*$!',$subject->subjectData);

            $intermediate_intro_video = $subject->intro_video;
            $intermediateDesc = $subject->descriptions;

            foreach($interSubData as $index => $lvlSubject){
                $subjectData = explode('-',$lvlSubject);
                $interSubList[$index]['subjectId'] = $subjectData[0];
                $interSubList[$index]['subjectName'] = $subjectData[1];
                $interSubList[$index]['image'] = $subjectData[2];
            }
            $interSubList = json_decode(json_encode($interSubList));
         }

         if($subject->level == "advanced"){
            $advanceSubData = explode('&%*$!',$subject->subjectData);

            $advanced_intro_video = $subject->intro_video;
            $advancedDesc = $subject->descriptions;

            foreach($advanceSubData as $index => $lvlSubject){
                $subjectData = explode('-',$lvlSubject);
                $advanceSubList[$index]['subjectId'] = $subjectData[0];
                $advanceSubList[$index]['subjectName'] = $subjectData[1];
                $advanceSubList[$index]['image'] = $subjectData[2];
            }
            $advanceSubList = json_decode(json_encode($advanceSubList));
         }

      }
   } 

   if(!empty($courseLvl)){
      $initLvl = $courseLvl; 
   }

   else if(!empty($beginnerSubList)){
      $initLvl = "beginner";
   }

   else if(!empty($interSubList)){
      $initLvl = "intermediate";
   }

   else if(!empty($advanceSubList)){
      $initLvl = "advanced";
   }

  /*print"<pre>";
  print_r($advanceSubList);
  print"<pre>";
  exit;*/
?>
        <!-- Page Banner Section Start -->
        <div class="page-banner bg-color-12">
            <div class="page-banner__wrapper">
                <div class="container">
                </div>
            </div>
        </div>
        <!-- Page Banner Section End -->
        <!-- Offcanvas Start -->
        <div class="offcanvas offcanvas-end offcanvas-mobile" id="offcanvasMobileMenu" style="background-image: url(<?=base_url()?>frontend/images/mobile-bg.jpg);">
            <div class="offcanvas-header bg-white">
                <div class="offcanvas-logo">
                    <a class="offcanvas-logo__logo" href="#"><img src="<?=base_url()?>frontend/images/dark-logo.png" alt="Logo"></a>
                </div>
                <button type="button" class="offcanvas-close" data-bs-dismiss="offcanvas"><i class="fal fa-times"></i></button>
            </div>

            <div class="offcanvas-body">
                <nav class="canvas-menu">
                    <ul class="offcanvas-menu">
                        <li><a class="active" href="index.html"><span>Home</span></a></li>
                        <li><a href="#"><span>Become an Instructor</span></a></li>
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

        <!-- Tutor Course Top Info Start -->
        <div class="tutor-course-top-info section-padding-01 bg-color-12">
            <div class="container custom-container">

                <div class="row">
                    <div class="col-lg-8">

                        <!-- Tutor Course Top Info Start -->
                        <div class="tutor-course-top-info__content">
                            <h1 class="tutor-course-top-info__title text-white"><?=$courseDetail->courseName?></h1>
                            <div class="tutor-course-top-info__meta">
                                <div class="tutor-course-top-info__meta-rating">
                                    
                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?=(base_url('course/details/'.$courseDetail->courseId.'/'.$courseLvl))?>" data-a2a-title="My Profile Page:">
                                        <a class="a2a_dd text-white" href="https://www.addtoany.com/share"><i class="fas fa-share-alt text-warning me-1"></i> Share</a>
                                    </div>

                                 </div>
                                <!--<div class="tutor-course-top-info__meta-rating">
                                    <a href="#" class="text-white"><i class="fas fa-heart me-1"></i> Like</a>
                                </div>-->
                            </div>
                        </div>
                        <!-- Tutor Course Top Info End -->

                    </div>
                </div>

            </div>
        </div>
        <!-- Tutor Course Top Info End -->

        <!-- Tutor Course Main content Start -->
        <div class="tutor-course-main-content section-padding-01 sticky-parent">
            <div class="container custom-container">
                <input type="hidden" id="courseId" value="<?=$courseDetail->courseId?>">
                <input type="hidden" id="initLvl" value="<?=$initLvl?>">

                <div class="overlayer" style="display: none;">
                   <div class="spinner"></div>
                </div>

               

                <div class="row gy-10">
                    <div class="col-lg-8">
                        <div class="tutor-course-main-segment">
                            <div class="tutor-course-segment">
                                <h4 class="tutor-course-segment__title">About This Course</h4>
                                <div class="tutor-course-segment__content-wrap">
                                    <?=htmlspecialchars_decode($courseDetail->descriptions)?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="courseLabel mt-5">
                            <ul class="nav nav-pillsjustify-content-center mb-1" id="pills-tab" role="tablist">
                              
                              <?php if(!empty($beginnerSubList)){ ?>
                                  <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link click_on_tab <?=(!empty($courseLvl)? ($courseLvl == 'beginner'?'active':''):'')?>" id="pills-home-tab" data-lvl="beginner" data-bs-toggle="pill" data-bs-target="#beginner" type="button" role="tab" aria-controls="beginner" aria-selected="true">Beginner</button>
                                  </li>
                              <?php } ?>
                              
                              <?php if(!empty($interSubList)){ ?>    
                                  <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link click_on_tab <?=(!empty($courseLvl)? ($courseLvl == 'intermediate'?'active':''):'')?>" id="pills-profile-tab" data-lvl="intermediate" data-bs-toggle="pill" data-bs-target="#intermediate" type="button" role="tab" aria-controls="intermediate" aria-selected="false">Intermediate</button>
                                  </li>
                              <?php } ?>
                              

                              <?php if(!empty($advanceSubList)){ ?>    
                                  <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link click_on_tab <?=(!empty($courseLvl)? ($courseLvl == 'advanced'?'active':''):'')?>" id="pills-contact-tab" data-lvl="advanced" data-bs-toggle="pill" data-bs-target="#advanced" type="button" role="tab" aria-controls="advanced" aria-selected="false">Advanced</button>
                                  </li>
                              <?php } ?>
                                  
                            </ul>
                            <div class="tab-content border p-4" id="pills-tabContent">

                              <?php if(!empty($beginnerSubList)){ ?>  
                                  <div class="tab-pane fade <?=($initLvl == 'beginner'?'show active':'')?>" id="beginner" role="tabpanel" aria-labelledby="pills-home-tab">
                                      <div class="border p-3 mb-3">
                                        <div class="d-flex">
                                            <div class="col-lg-<?=( !empty($beginner_intro_video) ? '7':'12' )?> contentmodal" id="beginner_level_details">
                                                <p><?=$beginnerDesc?></p>
                                            </div>
                                            
                                            <?php if(!empty($beginner_intro_video)) { ?>
                                                <div class="col-lg-5 popupvideo ps-lg-3">
                                                    <iframe width="560" height="315" src="<?=$beginner_intro_video?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                </div>
                                            <?php } ?>    
                                        </div>
                                      </div>
                                      <h5 class="h6 text-primary mb-3 text-uppercase text-center">Subjects</h5>
                                        <div class="row g-4">
                                         <?php foreach($beginnerSubList as $index=>$subject){ ?>  
                                             
                                             <div class="col-xl-4 col-lg-4 col-sm-6">
                                                <a href="javascript:void(0);" class="d-block showLevelChapters" data-sid="<?=$subject->subjectId?>">
                                                    <div class="courseBox">
                                                        <div class="couserIcon text-center">
                                                            <img src="<?=base_url('uploads/subject/'.$subject->image)?>">
                                                        </div>
                                                        <h3><?=$subject->subjectName?></h3>
                                                    </div>
                                                </a>
                                              </div>

                                          <?php } ?>  
                                        </div>
                                        
                                  </div>
                              
                              <?php if(!empty($interSubList)){ ?>    
                                  <div class="tab-pane fade <?=($initLvl == 'intermediate'?'show active':'')?>" id="intermediate" role="tabpanel" aria-labelledby="pills-profile-tab">
                                     
                                     <div class="border p-3 mb-3">
                                        <div class="d-flex">
                                            <div class="col-lg-<?=( !empty($intermediate_intro_video) ? '7':'12' )?> contentmodal" id="intermediate_level_details">
                                                <p><?=$intermediateDesc?></p>
                                            </div>
                                            
                                            <?php if(!empty($intermediate_intro_video)){ ?> 
                                                <div class="col-lg-5 popupvideo ps-lg-3">
                                                    <iframe width="560" height="315" src="<?=$intermediate_intro_video?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                </div>
                                            <?php } ?>    
                                        </div>
                                      </div>

                                      <h5 class="h6 text-primary mb-3 text-uppercase text-center">Subjects</h5>
                                          <div class="row g-4">
                                              <?php foreach($interSubList as $index=>$subject){ ?>  
                                             
                                                 <div class="col-xl-4 col-lg-4 col-sm-6">
                                                    <a href="javascript:void(0);" class="d-block showLevelChapters" data-sid="<?=$subject->subjectId?>">
                                                        <div class="courseBox">
                                                            <div class="couserIcon text-center">
                                                                <img src="<?=base_url('uploads/subject/'.$subject->image)?>">
                                                            </div>
                                                            <h3><?=$subject->subjectName?></h3>
                                                        </div>
                                                    </a>
                                                  </div>

                                             <?php } ?>  
                                        </div>
                                    </div>
                              <?php } ?>


                              <?php if(!empty($advanceSubList)){ ?>  
                                  <div class="tab-pane fade <?=($initLvl == 'advanced'?'show active':'')?>" id="advanced" role="tabpanel" aria-labelledby="pills-contact-tab">
                                      
                                      <div class="border p-3 mb-3">
                                        <div class="d-flex">
                                            <div class="col-lg-<?=( !empty($advanced_intro_video) ? '7':'12' )?> contentmodal" id="beginner_level_details">
                                                <p><?=$advancedDesc?></p>
                                            </div>
                                            
                                            <?php if(!empty($advanced_intro_video)) { ?>
                                                <div class="col-lg-5 popupvideo ps-lg-3">
                                                    <iframe width="560" height="315" src="<?=$advanced_intro_video?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                </div>
                                            <?php } ?>    
                                        </div>
                                      </div>

                                      <h5 class="h6 text-primary mb-3 text-uppercase text-center">Subjects</h5>
                                        <div class="row g-4">
                                            <?php foreach($advanceSubList as $index=>$subject){ ?>  
                                             
                                                 <div class="col-xl-4 col-lg-4 col-sm-6">
                                                    <a href="javascript:void(0);" class="d-block showLevelChapters" data-sid="<?=$subject->subjectId?>">
                                                        <div class="courseBox">
                                                            <div class="couserIcon text-center">
                                                                <img src="<?=base_url('uploads/subject/'.$subject->image)?>">
                                                            </div>
                                                            <h3><?=$subject->subjectName?></h3>
                                                        </div>
                                                    </a>
                                                  </div>
                                             <?php } ?>  
                                        </div>
                                    </div>
                               <?php } ?>    
                            </div>
                        </div>

                        <div class="row mt-5">
                            <h5 class="h6 text-primary text-uppercase text-center">Instructors</h5>

                            <div class="owl-carousel owl-theme mt-2" id="tutor2">
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

                                        <div class="course-item aos-init tutorprofile text-center bg-light">
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
                                <?php } } ?>
                            </div>
                        </div>    

                    </div>
                    <div class="col-lg-4">

                        <div class="sidebar-sticky">
                            <div class="tutor-course-sidebar">
                                <div class="tutor-course-price-preview">
                                    <div class="tutor-course-price-preview__thumbnail">
                                        <div class="ratio ratio-16x9" id="course_lvl_img">
                                           <img src="<?=base_url('uploads/courses/'.$courseDetail->image)?>" class="label-courseimg">
                                        </div>
                                    </div>
                                    <div class="tutor-course-price-preview__price">
                                        <div class="tutor-course-price">
                                            <span class="sale-price" id="level_price">$75</span>
                                            <!--<span class="regular-price">$100</span>-->
                                        </div>
                                        <!--<div class="tutor-course-price-badge bg-primary text-white">39% off</div>-->
                                    </div>
                                    <div class="tutor-course-price-preview__meta">
                                        <ul class="tutor-course-meta-list">
                                            <li>
                                                <div class="label"><i class="far fa-sliders-h"></i> Contents </div>
                                                <div class="value" id="chapter_count">24 Chapters</div>
                                            </li>
                                            <li>
                                                <div class="label"><i class="far fa-clock"></i> Duration </div>
                                                <div class="value" id="lvl_duration">48 Hours</div>
                                            </li>
                                            <li>
                                                <div class="label"><i class="far fa-tag"></i> Level </div>
                                                <div class="value" id="currentlVL">Beginner</div>
                                            </li>
                                            <li>
                                                <div class="label"><i class="far fa-tag"></i> Total No of Students Enrolled </div>
                                                <div class="value" id="purchaseCount">0</div>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    
                                    <div class="tutor-course-price-preview__btn">
                                        <?php if($this->session->userdata('userId') && $this->session->has_userdata('student')){ ?>
                                            <button class="btn btn-primary btn-hover-warning w-100" id="purchase-course"> <i class="far fa-shopping-cart"></i> Buy Now </button>

                                            <button class="btn btn-success btn-hover-warning w-100" id="add-course-to-wishlist"> <i class="far fa-heart"></i> Add to Wishlist </button>
                                        <?php }elseif(!$this->session->has_userdata('instructor')){ ?>
                                            <button class="btn btn-warning btn-hover-warning w-120" data-bs-toggle="modal" data-bs-target="#loginModal" data-backdrop="static" data-keyboard="false" data-toggle="modal"> Login to purchase this course </button>
                                        <?php } ?>         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Tutor Course Main content End -->



        <div class="modal fade subjectmodal" id="chaptereModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chapters</h5>
                <button type="button" class="modalclose" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
              </div>
              <div class="modal-body" id="chapterList">
               
                <div class="courserlistBlock">
                    <h4 class="h6">Name of the Chapter</h4>
                    <p class="mb-2"><small><span class="fw-bold text-primary"><i class="far fa-clock"></i> Duration:</span> 90 Min</small></p>
                    <p class="fw-bold mb-1">About the Chapter</p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. ... <a href="#" class="text-primary">Read more</a></p>
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