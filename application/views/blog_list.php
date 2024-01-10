
        <!-- Blog Start -->
        <div class="blog-section section-padding-01">
            <div class="container custom-container">

                <div class="row gy-6 grid">
                  <?php
                    if(!empty($list)){ 
                      foreach($list as $key => $blog){ 
                        $blog_desc = strip_tags(html_entity_decode($blog->descriptions));
                  ?> 
                        <div class="col-xl-4 col-md-6 grid-item">
                            <!-- Blog Item Start -->
                            <div class="blog-item-02" data-aos="fade-up" data-aos-duration="1000">
                                <div class="blog-item-02__image">
                                    <?php if (@$blog->thumbnail && file_exists('./uploads/blogs/'.@$blog->thumbnail)) { ?>
                                        <img src="<?= base_url('uploads/blogs/'.@$blog->thumbnail) ?>" alt="<?= $blog->title ?>" style="width: 370px;height: 201px;">
                                    <?php } else { ?>
                                        <img src="<?= base_url('uploads/noimg.png') ?>" alt="<?= $blog->title ?>" style="width: 370px;height: 201px;">
                                    <?php } ?>
                                </div>
                                <div class="blog-item-02__content">
                                    <div class="blog-item-02__meta">
                                        <span class="meta-action"><i class="far fa-calendar"></i> <?=date('jS F, Y',strtotime($blog->created))?></span>
                                        <!--<span class="meta-action"><i class="far fa-eye"></i> 4,036 views</span>-->
                                    </div>
                                    <h3 class="blog-item-02__title"><a href="<?=base_url('blog/'.$blog->articleId)?>"><?=$blog->title?></a></h3>
                                    <p><?=substr($blog_desc,0,77)."..."?></p>
                                    <a class="blog-item-02__more btn btn-light btn-hover-white" href="<?=base_url('blog/'.$blog->articleId)?>">Read More <i class="fal fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                            <!-- Blog Item End -->
                        </div>
                    <?php } }else{ ?>
                         <div class="text-center"><span>No Blog is available at this time</span></div>
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
        <!-- Blog End -->

      