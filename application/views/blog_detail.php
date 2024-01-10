
<?php 
  /*print"<pre>";
  print_r($blogDetail);
  print"</pre>";*/
?>


        <!-- Page Banner Section Start -->
        <div class="page-banner">
            <div class="page-banner__wrapper">
                <div class="container">

                    <!-- Page Breadcrumb Start -->
                    <div class="page-breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index-main.html">Home/</a></li>
                            <li class="breadcrumb-item"><a href="blog-grid-left-sidebar.html">Blog Detail</a></li>
                        </ul>
                    </div>
                    <!-- Page Breadcrumb End -->

                </div>
            </div>
        </div>
        <!-- Page Banner Section End -->


        <!-- Blog Start -->
        <div class="blog-section section-padding-01">
            <div class="container custom-container">

                <!-- Blog Dtails Start -->
                <div class="blog-details text-center">

                    <div class="blog-details__content pt-0">
                        <h3 class="blog-details__title-02"><?=$blogDetail->title?></h3>
                        <div class="blog-details__meta justify-content-center">
                            <a class="meta-action" href="#">
                                <img class="meta-action__avatar" src="<?=base_url('uploads/blogs/'.$blogDetail->thumbnail)?>" alt="Avatar" width="32" height="32">
                            </a>
                            <span class="meta-action"><i class="far fa-calendar"></i> <span class="meta-action__value"><?=date('jS F, Y',strtotime($blogDetail->created))?></span></span>
                        </div>
                    </div>

                    <div class="blog-details__image">
                        <img src="<?=base_url('uploads/blogs/'.$blogDetail->thumbnail)?>" alt="Blog" width="1170" height="634">
                    </div>

                </div>
                <!-- Blog Dtails End -->

                <!-- Blog Dtails Start -->
                <div class="blog-details-no-sidebar">

                    <!-- Blog Dtails Start -->
                    <div class="blog-details">

                        <div class="blog-details__content">
                           <?=html_entity_decode($blogDetail->descriptions)?>
                        </div>
                    
                    </div>
                    <!-- Blog Dtails End -->
                   
                </div>

            </div>
        </div>
        <!-- Blog End -->

        