<?php
    header("Cache-Control: no cache");
?>

        <!-- Courses Start -->
        <div class="courses-section section-padding-01">
            <div class="container">

                <!-- Archive Filter Bars Start -->
                <div class="archive-filter-bars">

                    <div class="archive-filter-bar">
                        <p>We found <span><?=count($courseList)?></span> courses available for you <?=(!empty($search_text)?'on "'.$search_text.'"':'')?></p>
                    </div>

                </div>
                <!-- Archive Filter Bars End -->

            

                  <div class="row gy-6">

                     <?php 
                       if(is_array($courseList) && !empty($courseList)){
                         foreach ($courseList as $key => $v){ 

                            $sql_lvl= "SELECT GROUP_CONCAT(cl.level) as levelStr FROM `course_level_details` cl WHERE cl.courseId='".$v->courseId."'";
                            $levelData = $this->mymodel->fetch($sql_lvl, true);  
                            $levelArr = explode(',', $levelData->levelStr);
                     ?>   
                        <div class="col-xl-3 col-lg-4 col-sm-6">

                            <!-- Course Start -->
                            <div class="course-item-02" data-aos="fade-up" data-aos-duration="1000">
                                <div class="course-header">
                                    <div class="course-header__thumbnail rounded-0">
                                        
                                         <?php if (@$v->level_image && file_exists('./uploads/level/'.@$v->level_image)) { ?>
                                            <a href="<?=base_url('course/details/'.$v->courseId.'/'.$levelArr[0])?>"><img src="<?= base_url('uploads/level/'.@$v->level_image) ?>" alt="img" width="258" height="173"></a>
                                        <?php } else { ?>
                                            <a href="<?=base_url('course/details/'.$v->courseId.'/'.$levelArr[0])?>"><img src="<?= base_url('uploads/course_no_image.png') ?>" alt="img" width="258" height="173"></a>
                                        <?php } ?>

                                    </div>
                                    <div class="course-header__badge">
                                        <!--<span class="free">Free</span>-->
                                    </div>
                                </div>
                                <div class="course-info-02">
                                    <div class="text-center"><span class="course-info__badge-text badge-all"><?=ucfirst(@$v->level)?></span></div>
                                    <!--<div class="course-info-02__category">
                                        <a href="#">Communications</a>
                                    </div>-->
                                    <h3 class="course-info__title text-center"><a href="<?=base_url('course/details/'.$v->courseId.'/'.$levelArr[0])?>"><?=@$v->courseName?></a></h3>
                                    <div class="course-info__price ">
                                        <span class="d-flex justify-content-between">
                                            <small class="sale-price">$<?=@$v->lvlCost?></small>
                                            <small class="sale-price">&nbsp;<i class="fa fa-clock"></i>&nbsp;<?=$v->totalHours?>&nbsp;Hours</small>
                                        </span>
                                    </div>
                                    <!--<div class="course-info-02__description">
                                        <p>Negotiation is a skill well worth mastering – by putting …</p>
                                    </div>
                                    <div class="course-info-02__price">
                                        <span class="free">Free</span>
                                    </div>
                                    <div class="course-info-02__rating">

                                        <div class="rating-star">
                                            <div class="rating-label" style="width: 100%;"></div>
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

                <!-- Page Pagination Start 
                <div class="page-pagination">
                    <ul class="pagination justify-content-center">
                        <li><a class="active" href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">...</a></li>
                        <li><a href="#">7</a></li>
                        <li><a href="#"><i class="far fa-angle-double-right"></i></a></li>
                    </ul>
                </div>
                <!-- Page Pagination End -->

            </div>
        </div>
        <!-- Courses End -->

        <!-- Courses Hover End 
        <div id="course-hover">
            <div class="course-item-hover">
                <div class="course-item-hover__category">
                    <a href="#">Communications</a>
                </div>
                <h2 class="course-item-hover__title"><a href="course-single-layout-01.html">Successful Negotiation: Master Your Negotiating Skills</a></h2>
                <div class="course-item-hover__rating">

                    <div class="rating-star">
                        <div class="rating-label" style="width: 100%;"></div>
                    </div>

                    <div class="rating-average">
                        <span class="rating-average__average">5.0</span>
                        <span class="rating-average__total">/5</span>
                    </div>

                    <p class="course-item-hover__rating-count">(2 ratings)</p>
                </div>
                <div class="course-item-hover__meta">
                    <span>5 Lessons</span>
                    <span>2.3 hours</span>
                    <span>All Levels</span>
                </div>
                <div class="course-item-hover__benefits">
                    <h6 class="course-item-hover__benefits-title">What you'll learn</h6>
                    <ul class="course-item-hover__benefits-list">
                        <li>Negotiate effectively and fairly to make 1000s more than they would otherwise</li>
                        <li>Be confident in starting and finishing a negotiation</li>
                        <li>Use smart tactics to increase their bargaining power</li>
                        <li>Develop mental and emotional strength to keep pushing until they get a great price</li>
                        <li>Use negotiating skills in both personal and professional situations</li>
                    </ul>
                </div>
                <div class="course-item-hover__btn">
                    <a class="btn btn-primary btn-hover-secondary w-100" href="#">Add to cart</a>
                    <a class="btn-link" href="#"><i class="far fa-heart"></i> Add to wishlist</a>
                </div>
            </div>
        </div>
        <!-- Courses Hover End -->

        <!-- Courses List Hover End -->
        <div id="course-list-hover">
            <div class="course-item-hover">
                <div class="course-item-hover__category">
                    <a href="#">Communications</a>
                </div>
                <h2 class="course-item-hover__title"><a href="course-single-layout-01.html">Successful Negotiation: Master Your Negotiating Skills</a></h2>
                <div class="course-item-hover__rating">

                    <div class="rating-star">
                        <div class="rating-label" style="width: 100%;"></div>
                    </div>

                    <div class="rating-average">
                        <span class="rating-average__average">5.0</span>
                        <span class="rating-average__total">/5</span>
                    </div>

                    <p class="course-item-hover__rating-count">(2 ratings)</p>
                </div>
                <div class="course-item-hover__meta">
                    <span>5 Lessons</span>
                    <span>2.3 hours</span>
                    <span>All Levels</span>
                </div>
                <div class="course-item-hover__benefits">
                    <h6 class="course-item-hover__benefits-title">What you'll learn</h6>
                    <ul class="course-item-hover__benefits-list">
                        <li>Negotiate effectively and fairly to make 1000s more than they would otherwise</li>
                        <li>Be confident in starting and finishing a negotiation</li>
                        <li>Use smart tactics to increase their bargaining power</li>
                        <li>Develop mental and emotional strength to keep pushing until they get a great price</li>
                        <li>Use negotiating skills in both personal and professional situations</li>
                    </ul>
                </div>
                <div class="course-item-hover__btn">
                    <a class="btn btn-primary btn-hover-secondary w-100" href="#">Add to cart</a>
                    <a class="btn-link" href="#"><i class="far fa-heart"></i> Add to wishlist</a>
                </div>
            </div>
        </div>
        <!-- Courses List Hover End -->



</body>


<!-- Mirrored from htmldemo.net/edumall/edumall/course-grid-01.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 May 2022 07:43:37 GMT -->
</html>