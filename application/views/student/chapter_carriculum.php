<?php
    $userId = $this->session->userdata('userId');

   //Checking if there is any change instructor request for this current instructor
    $sql_change_ins_record = "SELECT ci.queryId FROM change_instructor ci WHERE ci.studentId = '$userId' AND ci.courseId = '$courseId' AND ci.courseLvl = '$courseLvl'";

    $changeInstructorCount = $this->db->query($sql_change_ins_record)->num_rows(); 


    //Check if the current course is cancelled by user ot not
    $sql_cancel_student_record = "SELECT cc.stuCourseId FROM cancel_students cc WHERE cc.studentId = '$userId' AND cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

    $cancelStudentCount = $this->db->query($sql_cancel_student_record)->num_rows();

    //Check if the current course is cancelled by user ot not
    $sql_cancel_crs_record = "SELECT cc.requestId FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.courseLvl = '$courseLvl'";

    $cancelCourseCount = $this->db->query($sql_cancel_crs_record)->num_rows();
   /*print"<pre>";
   print_r($mediaFiles);
   print"</pre>";exit;*/
?>
<div class="dashboard-content">
    <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('student/enrolledcourselist')?>"><?=$courseDetail->courseName?></a></li>
            <li class="breadcrumb-item"><a href="<?=base_url('student/subjects/'.$courseId.'/'.$courseLvl)?>"><?=$subjectDetail->subjectName?></a></li>
            <li class="breadcrumb-item"><a href="<?=base_url('student/chapters/'.$courseId.'/'.$courseLvl.'/'.$subjectId)?>"><?=$chapterDetail->chapterName?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Chapter Details</li>
          </ol>
        </nav>

        <div class="row m-1">

            <div class="card shadow curriculum-row" id="uploaded_curriculum_media">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-6 d-flex"><h6 class="title my-auto">Chapter Summary</h6></div>
                    </div>
               </div>
               <div class="card-body">
                 <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                       <img src="<?=base_url('uploads/chapter/'.$chapterDetail->chapterImage)?>" alt="<?=$chapterDetail->chapterName?>">
                    </div>  
                    <div class="col-lg-9 col-md-9 col-sm-9">
                      <?=strip_tags(htmlspecialchars_decode($chapterDetail->summary))?>
                    </div>  
                  </div>  
               </div>
             </div>  

            <div class="card shadow curriculum-row mt-5" id="uploaded_curriculum_media">
               <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-6 d-flex"><h6 class="title my-auto">Chapter Objectives</h6></div>
                    </div>
               </div>
               <div class="card-body">
                   <?=strip_tags(htmlspecialchars_decode($chapterDetail->summary))?>
               </div>
            </div> 

            <div class="card shadow curriculum-row mt-5" id="uploaded_curriculum_media">
               <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-6 d-flex"><h6 class="title my-auto">Curriculum Media</h6></div>
                    </div>
                </div>
                <div class="card-body">
                     <?php 
                        if($changeInstructorCount == 0 && $cancelCourseCount == 0){
                          if(count($mediaFiles)>0){
                             foreach($mediaFiles as $key => $media){ 
                                $mediaPath = base_url('uploads/chapter_curriculum/'.$media->mediaFile);
                     ?>      
                        <div class="preview-image-curriculum image-container-frame" id='curriculum_<?=$media->mediaId?>'>
                           
                           <?php if($media->mediaType == "image"){ ?>  
                                <div class="curriculum-content">
                                   <a href="<?=$mediaPath?>" data-fancybox="gallery" data-caption="curriculum_image">  
                                     <img alt="image" src="<?=$mediaPath?>" class="curriculum-main" title="curriculum_image" alt="curriculum_image">
                                   </a>  
                                </div>
                                <div class="file-footer-caption" title="<?=$media->mediaOgName?>">
                                    <div class="file-caption-info"><?=$media->mediaOgName?></div>
                                </div>
                            <?php } ?>    

                            <?php if($media->mediaType == "video"){ ?>  
                                 <div class="curriculum-content">
                                    <a href="<?=$mediaPath?>" data-fancybox="gallery" data-caption="curriculum_image">
                                        <video class="curriculum-main" controls>
                                          <source src="<?=$mediaPath?>" type="video/mp4">
                                        </video>
                                    </a>    
                                 </div>
                                  <div class="file-footer-caption" title="<?=$media->mediaOgName?>">
                                    <div class="file-caption-info"><?=$media->mediaOgName?></div>
                                </div>
                            <?php } ?> 

                            <?php if($media->mediaType == "audio"){ ?>  
                                <div class="curriculum-content">
                                    <div class="curriculum-audio-content">
                                      <i class="fas fa-file-audio-o" area-hidden="true"></i>
                                      <audio class="curriculum-audio-main" controls>
                                      <source src="<?=$mediaPath?>" type="audio/mpeg">
                                    </div>
                                </div>
                                <div class="file-footer-caption" title="<?=$media->mediaOgName?>">
                                    <div class="file-caption-info"><?=$media->mediaOgName?></div>
                                </div>
                            <?php } ?>    

                            <?php if($media->mediaType == "document"){ ?>  
                                <div class="curriculum-content">
                                    <div class="curriculum-doc-content">
                                        <i class="fas fa-file" area-hidden="true"></i>
                                    </div>
                                </div>
                                 <div class="file-footer-caption" title="<?=$media->mediaOgName?>">
                                    <div class="file-caption-info"><?=$media->mediaOgName?></div>
                                </div>
                            <?php } ?> 

                            <div class="curriculum-icons">
                                <a href="<?=$mediaPath?>" download><i class="fas fa-download"></i></a>
                                 <!--<a href="<?=$mediaPath?>" data-fancybox="gallery" data-caption="curriculum_image">
                                     <i class="fas fa-search-plus"></i>
                                 </a>-->
                            </div>
                        </div>
                    <?php } }else{ ?> 
                        <div class="form-group text-center">
                            No media file is uploaded at this moment!
                        </div> 
                    <?php 
                        } }else{
                           if($cancelStudentCount>0 || $cancelCourseCount>0){ 
                    ?>
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong></strong> This course has been cancelled. You won't be able to perform any action until this dispute is resolved. Stay tuned!
                           </div> 
                    <?php }else{ ?>
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong></strong> There is a change instructor request is in pending status. You won't be able to perform any action until this dispute is resolved. Stay tuned!
                           </div> 
                    <?php } } ?>       
                </div>
            </div>
         
        </div>
    </div>
</div>
