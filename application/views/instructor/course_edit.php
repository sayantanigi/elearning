<?php
  
  //Formatting all chapters under various level subjects
  if (!empty($chapterList) && (count($chapterList) > 0)) {
      foreach ($chapterList as $key => $chapter) {
         if($chapter->level == "beginner"){
            $beginnerChapterData = explode('&%*$!',$chapter->chapterData);
            
            foreach($beginnerChapterData as $index => $lvlChapter){
                $chapterData = explode('-',$lvlChapter);
                $beginnerChapterList[$index]['chapterId'] = $chapterData[0];
                $beginnerChapterList[$index]['chapterName'] = $chapterData[1];
            }
            $beginnerChapterList = json_decode(json_encode($beginnerChapterList));
         }

         if($chapter->level == "intermediate"){
            $interChapterData = explode('&%*$!',$chapter->chapterData);

            foreach($interChapterData as $index => $lvlChapter){
                $chapterData = explode('-',$lvlChapter);
                $interChapterList[$index]['chapterId'] = $chapterData[0];
                $interChapterList[$index]['chapterName'] = $chapterData[1];
            }
            $interChapterList = json_decode(json_encode($interChapterList));
         }

         if($chapter->level == "advanced"){
            $advancedChapterData = explode('&%*$!',$chapter->chapterData);

            foreach($advancedChapterData as $index => $lvlChapter){
                $chapterData = explode('-',$lvlChapter);
                $advancedChapterList[$index]['chapterId'] = $chapterData[0];
                $advancedChapterList[$index]['chapterName'] = $chapterData[1];
            }
            $advancedChapterList = json_decode(json_encode($advancedChapterList));
         }

      }
   }else{
      $beginnerChapterList = array();
      $interChapterList = array();
      $advancedChapterList = array();

   }       

  //Formatting various level chapter and subject id
  if (!empty($courseChapterIds) && (count($courseChapterIds) > 0)) {
      foreach ($courseChapterIds as $key => $chapter) {
         if($chapter->level == "beginner"){
            $beginnerSubjectId = explode(',',$chapter->subjectId);
            $beginnerChapterId = explode(',',$chapter->chapterId);
         }

         if($chapter->level == "intermediate"){
            $intermediateSubjectId = explode(',',$chapter->subjectId);
            $intermediateChapterId = explode(',',$chapter->chapterId);
         }

         if($chapter->level == "advanced"){
            $advancedSubjectId = explode(',',$chapter->subjectId);
            $advancedChapterId = explode(',',$chapter->chapterId);
         }
      }
   }else{
      $beginnerSubjectId = array();
      $beginnerChapterId = array();
     
      $intermediateSubjectId = array();
      $intermediateChapterId = array();
     
      $advancedSubjectId = array();
      $advancedChapterId = array();
   }       

  //Formatting various level course and subject id
  if (!empty($courseInsIds) && (count($courseInsIds) > 0)) { 
      foreach ($courseInsIds as $key => $instructor) {
         if($instructor->level == "beginner"){
            $beginnerInsId = explode(',',$instructor->insId);
         }

         if($instructor->level == "intermediate"){
            $intermediateInsId = explode(',',$instructor->insId);
         }

         if($instructor->level == "advanced"){
            $advancedInsId = explode(',',$instructor->insId);
         }
      }
   }else{
      $beginnerInsId = array();
      $intermediateInsId = array();
      $advancedInsId = array();
   }   

  //Formatting various level details
  foreach ($levelDetail as $key => $level) {
     if($level->level == "beginner"){
        $beginnerLvlDetail = $level;
        $beginnerCrsLvlId = $level->crsLvlId;
     }

     if($level->level == "intermediate"){
        $intermediateLvlDetail = $level;
        $interCrsLvlId = $level->crsLvlId;
     }

     if($level->level == "advanced"){
        $advancedLvlDetail = $level;
        $advancedCrsLvlId = $level->crsLvlId;
     }
  }

  /*print"<pre>";
  print_r($beginnerChapterList);
  print"</pre>";exit;*/
?>
<div class="dashboard-content">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url('instructor/my-created-course')?>">Course</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Course</li>
        </ol>
      </nav>    

      <form class="form-horizontal needs-validation" id="manage_course_form" method="post" enctype="multipart/form-data" onsubmit="return false;">
        <div class="row">
            <div class="col-lg-6">
                <div class="dashboard-content-box">

                    <h4 class="dashboard-content-box__title">Course Description</h4>

                    <div class="row gy-4">
                        <div class="col-md-12">
                          <label class="form-label-02">Course Name<span style="color:red;"> *</span></label>
                          <input type="text" name="courseName" id="courseName" value="<?=(!empty($courseDetail->courseName)?$courseDetail->courseName:'')?>" class="form-control" required>
                          <input type="hidden" name="courseId" id="courseId" value="<?=$courseDetail->courseId?>">
                        </div>

                        <div class="col-md-12">
                            <div class="dashboard-content__input">
                              <label class="form-label-02">Summary<span style="color:red;"> *</span></label>
                              <textarea class="form-control tinymce" name="descriptions" required><?=(!empty($courseDetail->descriptions)?$courseDetail->descriptions:'')?></textarea>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="dashboard-content-box">

                    <h4 class="dashboard-content-box__title">Course Thumbnail<span style="color:red;"> *</span></h4>
                    <p>Upload Course Thumbnail.</p>
                    <?php 
                       if (@$courseDetail->image && file_exists('./uploads/courses/'.@$courseDetail->image)) { 
                          $courseBgImg = base_url('uploads/courses/'.@$courseDetail->image);
                       }else{
                          $courseBgImg = base_url('uploads/noimg.png');
                       }   
                    ?>
                    <div id="dashboard-profile-cover-photo-editor" class="dashboard-settings-profile">
                        <input id="dashboard-photo-dialogue-box" class="dashboard-settings-profile__input test" type="file" name="courseImage" accept=".png,.jpg,.jpeg" required />
                        <div id="dashboard-cover-area" class="dashboard-settings-profile__cover" data-fallback="<?= base_url('uploads/noimg.png') ?>" style="background-image:url(<?=$courseBgImg?>)">

                            <input type="hidden" name="oldCourseImage" value="<?= @$courseDetail->image ?>">
                           
                            <div class="overlay">
                                <button class="cover-uploader" type="button">
                                    <i class="far fa-camera"></i>&nbsp;
                                    <span>Select Course Thumbnail</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">    

           <div class="col-md-12 mt-3">
                <div class="dashboard-content-box">
                   <h4 class="dashboard-content-box__title">Course Level Data</h4>
                    <div class="row gy-4" id="courseLvl_Detail">
                       <div class="col-md-12">
                         <input type="hidden" name="courseLvl" id="courseLvl" value="beginner">

                         <div id="form_error"></div>

                         <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <button class="nav-link click_on_tab active" id="beginner-tab" data-bs-toggle="tab" data-bs-target="#beginner" data-lvl="beginner" type="button" role="tab" aria-controls="beginner" aria-selected="true">Beginner Level</button>
                          </li>

                          <li class="nav-item" role="presentation">
                            <button class="nav-link click_on_tab" id="intermediate-tab" data-bs-toggle="tab" data-bs-target="#intermediate" data-lvl="intermediate" type="button" role="tab" aria-controls="intermediate" aria-selected="false">Intermediate Level</button>
                          </li>

                          <li class="nav-item" role="presentation">
                            <button class="nav-link click_on_tab" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" data-lvl="advanced" type="button" role="tab" aria-controls="advanced" aria-selected="false">Advanced Level</button>
                          </li>
                        </ul>
                        
                        <div class="tab-content" id="myTabContent">
                          
                          <div class="tab-pane fade show active" id="beginner" role="tabpanel" aria-labelledby="home-tab">

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                       
                                       <input type="hidden" name="beginnerCrsLvlId" id="beginnerCrsLvlId" value="<?=(!empty($beginnerCrsLvlId)?$beginnerCrsLvlId:"null")?>">
                                        
                                       <label class="form-label-02">Display Level<span style="color:red;"> *</span></label> 
                                       <select class="form-control" name="lvl_dsiply_status_beginner" id="lvl_dsiply_status_beginner">
                                            <!--<option selected disabled>Please select a display status</option>-->
                                            <option value="1" <?=(!empty($beginnerLvlDetail)?($beginnerLvlDetail->status == 1?'selected':''):'')?>>Yes (A seperate level will be created for this level and student can purchase this from frontend**)</option>
                                            <option value="0" <?=(!empty($beginnerLvlDetail)?($beginnerLvlDetail->status == 0?'selected':''):'selected')?>>No (No seperate data will be created for this level)</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="course_beginner_details" <?=(empty($beginnerLvlDetail)?'style="display:none;"':'')?>>
                              
                                    <div class="row mt-4">

                                         <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' id="courseImage_beginner" class="imageUpload" name="courseImage_beginner" data-pvid="crsImgBeginnerPreview" accept=".png, .jpg, .jpeg" />
                                                    <label for="courseImage_beginner"></label>
                                                </div>
                                                 <?php 
                                                   if (@$beginnerLvlDetail->image && file_exists('./uploads/level/'.@$beginnerLvlDetail->image)) {
                                                      $lvlBeginnerBgImg = base_url('uploads/level/'.@$beginnerLvlDetail->image);
                                                   }else{
                                                      $lvlBeginnerBgImg = base_url('uploads/noimg.png');
                                                   }   
                                                 ?>
                                                <div class="avatar-preview">
                                                    <div id="crsImgBeginnerPreview" style="background-image: url(<?=$lvlBeginnerBgImg?>);">
                                                        <input type="hidden" name="oldbigLvlImage" value="<?= @$beginnerLvlDetail->image ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-9 col-sm-12">

                                            <div class="col-md-12 mt-4">
                                                <label class="form-label-02">Select Subject<span style="color:red;"> *</span></label>
                                                <select class="form-control subjectId" name="subjectId_beginner[]" id="subject_lvl_beginner" multiple>
                                                    <?php if (!empty($subjectList) && (count($subjectList) > 0)) { ?>
                                                        <option></option>
                                                        <?php foreach ($subjectList as $key => $v): ?>
                                                            <option value="<?= $v->subjectId  ?>" <?=((!empty($beginnerSubjectId) && in_array($v->subjectId, $beginnerSubjectId))?'selected':'')?>>
                                                                <?= $v->subjectName ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    <?php } else { ?>
                                                        <option value="">No subject found</option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                             <div class="col-md-12 mt-4">
                                                <label class="form-label-02">Select Chapters<span style="color:red;"> *</span></label>
                                                <select class="form-control chapterId" name="chapterId_beginner[]" id="chapter_lvl_beginner" multiple>
                                                    <option></option>
                                                     <?php if (!empty($beginnerChapterList) && (count($beginnerChapterList) > 0)) { ?>
                                                        <option value="">Select Chapter</option>
                                                        <?php foreach ($beginnerChapterList as $key => $v): ?>

                                                            <option value="<?= $v->chapterId ?>" <?=(in_array($v->chapterId,$beginnerChapterId)?'selected':'')?>>
                                                                <?= $v->chapterName ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    <?php } else { ?>
                                                        <option value="">No subject found</option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                             <div class="col-md-12 mt-4">
                                                <label class="form-label-02">Instructor<span style="color:red;"> *</span></label>
                                                <input type="hidden" name="insId_beginner[]" value="<?=$_SESSION['userId']?>">
                                                <select class="form-control insId" id="insId_lvl_beginner" disabled>
                                                    <?php if (!empty($instList) && (count($instList) > 0)) { ?>
                                                        <option></option>
                                                        <?php foreach ($instList as $key => $v): ?>
                                                            <option value="<?= $v->userId  ?>" <?=((!empty($beginnerInsId) && in_array($v->userId, $beginnerInsId)?'selected':''))?>>
                                                                <?= $v->firstName."&nbsp;".$v->lastName ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    <?php } else { ?>
                                                        <option value="">No instructor found</option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mt-4">
                                                <label class="form-label-02">Introductional Video</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" name="beginner_intro_video" value="<?=((!empty($beginnerLvlDetail) && !empty($beginnerLvlDetail->intro_video)?$beginnerLvlDetail->intro_video:''))?>">
                                                </div>
                                            </div> 

                                        </div>
                                       
                                    </div>   

                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <div class="dashboard-content__input">
                                              <label class="form-label-02">Level Summary<span style="color:red;"> *</span></label>
                                              <textarea class="form-control tinymce" id="descriptions_beginner" name="descriptions_beginner">
                                                  <?=((!empty($beginnerLvlDetail) && !empty($beginnerLvlDetail->descriptions)?$beginnerLvlDetail->descriptions:''))?>
                                              </textarea>
                                            </div>
                                        </div>
                                   </div>

                                </div> 

                                <div id="no_beginner_data_avail" class="mt-4" <?=(!empty($beginnerLvlDetail)?'style="display:none;"':'')?>>
                                    <div class="alert alert-warning" role="alert">
                                       Please select display status Yes to enter data for this level, else no data will be inserted for this level!
                                    </div>
                                </div>   

                          </div>
                          
                          <div class="tab-pane fade" id="intermediate" role="tabpanel" aria-labelledby="profile-tab">

                               <div class="row mt-4">
                                 <div class="col-md-12">
                                    <input type="hidden" name="interCrsLvlId" id="interCrsLvlId" value="<?=(!empty($interCrsLvlId)?$interCrsLvlId:"null")?>">

                                    <label class="form-label-02">Display Level<span style="color:red;"> *</span></label> 
                                     <select class="form-control" name="lvl_dsiply_status_intermediate" id="lvl_dsiply_status_intermediate">
                                        <!--<option selected disabled>Please select a display status</option>-->
                                        <option value="1" <?=(!empty($intermediateLvlDetail)?($intermediateLvlDetail->status == 1?'selected':''):'')?>>Yes (A seperate level will be created for this level and student can purchase this from frontend**)</option>
                                        <option value="0" <?=(!empty($intermediateLvlDetail)?($intermediateLvlDetail->status == 0?'selected':''):'selected')?>>No (No seperate data will be created for this level)</option>
                                     </select>
                                 </div>
                               </div>
                              
                               <div id="course_intermediate_details" <?=(empty($intermediateLvlDetail)?'style="display:none;"':'')?>>

                                   <div class="row p-4">

                                     <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' id="courseImage_intermediate" class="imageUpload" name="courseImage_intermediate" data-pvid="crsImgInterPreview" accept=".png, .jpg, .jpeg" />
                                                <label for="courseImage_intermediate"></label>
                                            </div>
                                             <?php 
                                               if (@$intermediateLvlDetail->image && file_exists('./uploads/level/'.@$intermediateLvlDetail->image)) {
                                                  $lvlInterBgImg = base_url('uploads/level/'.@$intermediateLvlDetail->image);
                                               }else{
                                                  $lvlInterBgImg = base_url('uploads/noimg.png');
                                               }   
                                             ?>
                                            <div class="avatar-preview">
                                                <div id="crsImgInterPreview" style="background-image: url(<?=$lvlInterBgImg?>);">
                                                    <input type="hidden" name="oldIntLvlImage" value="<?= @$intermediateLvlDetail->image ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                       
                                        <div class="col-md-12 mt-4">
                                            <label class="form-label-02">Select Subject<span style="color:red;"> *</span></label>
                                            <select class="form-control subjectId" name="subjectId_intermediate[]" id="subject_lvl_intermediate" multiple>
                                               <?php if (!empty($subjectList) && (count($subjectList) > 0)) { ?>
                                                    <option></option>
                                                    <?php foreach ($subjectList as $key => $v): ?>
                                                        <option value="<?= $v->subjectId ?>" <?=((!empty($intermediateLvlDetail) && in_array($v->subjectId, $intermediateSubjectId))?'selected':'')?>>
                                                            <?= $v->subjectName ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                <?php } else { ?>
                                                    <option value="">No subject found</option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                         <div class="col-md-12 mt-4">
                                            <label class="form-label-02">Select Chapters<span style="color:red;"> *</span></label>
                                            <select class="form-control chapterId" name="chapterId_intermediate[]" id="chapter_lvl_intermediate" multiple>
                                                <option></option>
                                                <?php if (!empty($interChapterList) && (count($interChapterList) > 0)) { ?>
                                                    <option value="">Select Chapter</option>
                                                    <?php foreach ($interChapterList as $key => $v): ?>
                                                        <option value="<?= $v->chapterId ?>" <?=(in_array($v->chapterId, $intermediateChapterId)?'selected':'')?>>
                                                            <?= $v->chapterName ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                <?php } else { ?>
                                                    <option value="">No subject found</option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <label class="form-label-02">Select Instructor<span style="color:red;"> *</span></label>
                                            <input type="hidden" name="insId_intermediate[]" value="<?=$_SESSION['userId']?>">
                                            <select class="form-control insId" id="insId_lvl_intermediate" disabled>
                                                <?php if (!empty($instList) && (count($instList) > 0)) { ?>
                                                    <option></option>
                                                    <?php foreach ($instList as $key => $v): ?>
                                                        <option value="<?= $v->userId  ?>" <?=((!empty($intermediateInsId) && in_array($v->userId, $intermediateInsId)?'selected':''))?>>
                                                            <?= $v->firstName."&nbsp;".$v->lastName ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                <?php } else { ?>
                                                    <option value="">No instructor found</option>
                                                <?php } ?>
                                            </select>
                                        </div> 

                                       
                                        <div class="col-md-12 mt-4">
                                            <label class="form-label-02">Introductional Video</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="intermediate_intro_video" value="<?=((!empty($intermediateLvlDetail) && !empty($intermediateLvlDetail->intro_video)?$intermediateLvlDetail->intro_video:''))?>">
                                            </div>
                                        </div>  

                                    </div>  

                                   </div>   
                                    
                                   <div class="row">
                                    
                                     <div class="col-md-12 mt-4">
                                        <div class="dashboard-content__input">
                                          <label class="form-label-02">Level Summary<span style="color:red;"> *</span></label>
                                          <textarea class="form-control tinymce" name="descriptions_intermediate">
                                              <?=((!empty($intermediateLvlDetail) && !empty($intermediateLvlDetail->descriptions)?$intermediateLvlDetail->descriptions:''))?>
                                          </textarea>
                                        </div>
                                    </div>
                                   </div>

                               </div>

                                <div id="no_intermediate_data_avail" class="mt-4" <?=(!empty($intermediateLvlDetail)?'style="display:none;"':'')?>>
                                    <div class="alert alert-warning" role="alert">
                                         Please select display status Yes to enter data for this level, else no data will be inserted for this level!
                                     </div>
                                </div>     

                           </div>


                            <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="contact-tab">

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <input type="hidden" name="advancedCrsLvlId" id="advancedCrsLvlId" value="<?=(!empty($advancedCrsLvlId)?$advancedCrsLvlId:"null")?>">

                                       <label class="form-label-02">Display Lavel<span style="color:red;"> *</span></label>
                                       <select class="form-control" name="lvl_dsiply_status_advanced" id="lvl_dsiply_status_advanced">
                                            <!--<option selected disabled>Please select a display status</option>-->
                                            <option value="1" <?=(!empty($advancedLvlDetail)?($advancedLvlDetail->status == 1?'selected':''):'')?>>Yes (A seperate level will be created for this level and student can purchase this from frontend**)</option>
                                            <option value="0" <?=(!empty($advancedLvlDetail)?($advancedLvlDetail->status == 0?'selected':''):'selected')?>>No (No seperate data will be created for this level)</option>
                                        </select>
                                     </div>
                                </div>

                                <div id="course_advanced_details" <?=(empty($advancedLvlDetail)?'style="display:none;"':'')?>>
                                   
                                     <div class="row p-4">
                                    
                                         <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' id="courseImage_advanced" class="imageUpload" name="courseImage_advanced" data-pvid="crsImgAdvncPreview" accept=".png, .jpg, .jpeg" />
                                                    <label for="courseImage_advanced"></label>
                                                </div>
                                                <?php 
                                                   if (@$advancedLvlDetail->image && file_exists('./uploads/level/'.@$advancedLvlDetail->image)) {
                                                      $lvlAdvancedBgImg = base_url('uploads/level/'.@$advancedLvlDetail->image);
                                                   }else{
                                                      $lvlAdvancedBgImg = base_url('uploads/noimg.png');
                                                   }   
                                                ?>
                                                <div class="avatar-preview">
                                                    <div id="crsImgAdvncPreview" style="background-image: url(<?=$lvlAdvancedBgImg?>);">
                                                        <input type="hidden" name="oldAdvLvlImage" value="<?= @$advancedLvlDetail->image ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-9 col-sm-12">

                                            <div class="col-md-12 mt-4">
                                                <label class="form-label-02">Select Subject<span style="color:red;"> *</span></label>
                                                <select class="form-control subjectId" name="subjectId_advanced[]" id="subject_lvl_advanced" multiple>
                                                    <?php if (!empty($subjectList) && (count($subjectList) > 0)) { ?>
                                                        <option></option>
                                                        <?php foreach ($subjectList as $key => $v): ?>
                                                            <option value="<?= $v->subjectId ?>" <?=((!empty($advancedLvlDetail) && in_array($v->subjectId, $advancedSubjectId))?'selected':'')?>>
                                                                <?= $v->subjectName ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    <?php } else { ?>
                                                        <option value="">No subject found</option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mt-4">
                                                <label class="form-label-02">Select Chapters<span style="color:red;"> *</span></label>
                                                <select class="form-control chapterId" name="chapterId_advanced[]" id="chapter_lvl_advanced" multiple>
                                                    <option></option>
                                                    <?php if (!empty($advancedChapterList) && (count($advancedChapterList) > 0)) { ?>
                                                        <option></option>
                                                        <?php foreach ($advancedChapterList as $key => $v): ?>
                                                            <option value="<?= $v->chapterId ?>" <?=(in_array($v->chapterId, $advancedChapterId)?'selected':'')?>>
                                                                <?= $v->chapterName ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    <?php } else { ?>
                                                        <option value="">No subject found</option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mt-4">
                                                <label class="form-label-02">Select Instructor<span style="color:red;"> *</span></label>
                                                <input type="hidden" name="insId_advanced[]" value="<?=$_SESSION['userId']?>">
                                                <select class="form-control insId" id="insId_lvl_advanced" disabled>
                                                    <?php if (!empty($instList) && (count($instList) > 0)) { ?>
                                                        <option></option>
                                                        <?php foreach ($instList as $key => $v): ?>
                                                            <option value="<?= $v->userId  ?>" <?=((!empty($advancedInsId) && in_array($v->userId, $advancedInsId))?'selected':'')?>>
                                                                <?= $v->firstName."&nbsp;".$v->lastName ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    <?php } else { ?>
                                                        <option value="">No instructor found</option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mt-4">
                                                <label class="form-label-02">Introductional Video</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" name="advanced_intro_video" value="<?=((!empty($advancedLvlDetail) && !empty($advancedLvlDetail->intro_video)?$advancedLvlDetail->intro_video:''))?>">
                                                </div>
                                            </div>   

                                        </div> 

                                     </div>    

                                     <div class="row">   

                                         <div class="col-md-12 mt-4">
                                            <div class="dashboard-content__input">
                                              <label class="form-label-02">Level Summary<span style="color:red;"> *</span></label>
                                              <textarea class="form-control tinymce" name="descriptions_advanced">
                                                  <?=((!empty($advancedLvlDetail) && !empty($advancedLvlDetail->descriptions)?$advancedLvlDetail->descriptions:''))?>
                                              </textarea>
                                            </div>
                                         </div>
                                     </div>

                                </div>   

                                <div id="no_advanced_data_avail" class="mt-4" <?=(!empty($advancedLvlDetail)?'style="display:none;"':'')?>>
                                    <div class="alert alert-warning" role="alert">
                                        Please select display status Yes to enter data for this level, else no data will be inserted for this level!
                                    </div>
                                </div> 

                            </div>

                       </div>
                    </div>  

                  </div>
                </div> 
            </div>

            <div class="col-lg-12">
                <div class="dashboard-settings__btn">
                    <button type="submit" class="btn btn-primary btn-hover-secondary">Update Course</button>
                    <a href="<?=base_url('instructor/my-created-course')?>"><button type="button" class="btn btn-danger btn-hover-danger">Cancel</button></a>
                </div>     
            </div>
        </div>
      </form>
    </div>
  </div>      

  <script type="text/javascript">

    function changeSelect(pageState){

        if(pageState == "ready"){
            $(".subjectId,.chapterId,.insId").select2('destroy'); 
        }

        //Applying select2 plugin for selecting subject
        $(".subjectId").select2({
            placeholder : 'Select a subject'
        });

        $(".chapterId").select2({
          placeholder : 'Select a subject first'
        });

         $(".insId").select2({
          placeholder : 'Select course instructor'
        });

        $(".imageUpload").change(function() {
            $(this).valid();
            var imgPreviewId = $(this).data('pvid');
            readURL(this,imgPreviewId);
        });
    
    }

    function readURL(input,previewDivId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#'+previewDivId).css('background-image', 'url('+e.target.result +')');
                $('#'+previewDivId).hide();
                $('#'+previewDivId).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function validateCourseForm(checkCurrentTab=false){

        //var currentTabId = $('.tab-content .active').attr('id');
        var courseId  = $("#courseId").val();
        var currentTab = $("#courseLvl").val();  
        
        var lvl_dsiply_status_beginner = $("#lvl_dsiply_status_beginner").val();
        var lvl_dsiply_status_inter = $("#lvl_dsiply_status_intermediate").val();
        var lvl_dsiply_status_advanced = $("#lvl_dsiply_status_advanced").val();
        
        if((checkCurrentTab && currentTab == "beginner") || checkCurrentTab == false){
            //Validation on intermediate level
            var subject_lvl_beginner = $("#subject_lvl_beginner").val();
            var chapter_lvl_beginner = $("#chapter_lvl_beginner").val();
            var insId_lvl_beginner = $("#insId_lvl_beginner").val();

            var beginnerCrsLvlId = $("#beginnerCrsLvlId").val();

            if(((lvl_dsiply_status_beginner.length>0 && beginnerCrsLvlId != "null") || (lvl_dsiply_status_beginner == 1 && beginnerCrsLvlId == "null")) && (!subject_lvl_beginner.length > 0 || !chapter_lvl_beginner.length > 0 || !insId_lvl_beginner.length > 0)){

                console.log('beginner entered!');

                if(beginnerCrsLvlId != "null"){
                    var errHtml = '<div class="alert alert-warning" role="alert">You have not provided the least required data for existing beginner level, No changes will be made to this level</div>';
                }else{    
                    var errHtml = '<div class="alert alert-warning" role="alert">Beginner level data is incomplete!</div>';
                }

                $("#lvl_dsiply_status_beginner").prop('required',true);
                $("#subject_lvl_beginner").prop('required',true);
                $("#chapter_lvl_beginner").prop('required',true);
                $("#insId_lvl_beginner").prop('required',true);

                $('.nav-tabs button[data-bs-target="#beginner"]').tab('show');
                $("#courseLvl").val("beginner");
                
                setTimeout(function(){
                    validator.element("#subject_lvl_beginner");
                    validator.element("#chapter_lvl_beginner");
                    validator.element("#insId_lvl_beginner");
                },1000);

                $("#form_error").html(errHtml);
                
                setTimeout(function(){
                   document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
                },1000);
                
                return false;
            }else{
                if((lvl_dsiply_status_beginner == 0 && beginnerCrsLvlId == 0)){
                    $("#lvl_dsiply_status_beginner").prop('required',false);
                    $("#subject_lvl_beginner").prop('required',false);
                    $("#chapter_lvl_beginner").prop('required',false);
                    $("#insId_lvl_beginner").prop('required',false);

                    $("label.error").hide();
                    $(".error").removeClass("error");
                    $("#form_error").html('');
                }  
            }
        }    
        
        if((checkCurrentTab && currentTab == "intermediate") || checkCurrentTab == false){
            //Validation on intermediate level
            var subject_lvl_inter = $("#subject_lvl_intermediate").val();
            var chapter_lvl_inter = $("#chapter_lvl_intermediate").val();
            var insId_lvl_inter = $("#insId_lvl_intermediate").val();
           
            var interCrsLvlId = $("#interCrsLvlId").val();

            if(((lvl_dsiply_status_inter.length>0 && interCrsLvlId != "null") || (lvl_dsiply_status_inter == 1 && interCrsLvlId == "null")) && (!subject_lvl_inter.length > 0 || !chapter_lvl_inter.length > 0 || !insId_lvl_inter.length > 0)){
               
                 if(interCrsLvlId != "null"){
                    var errHtml = '<div class="alert alert-warning" role="alert">You have not provided the least required data for existing intermediate level, No changes will be made to this level</div>';
                 }else{    
                    var errHtml = '<div class="alert alert-warning" role="alert">Intermediate level data is incomplete!</div>';
                 }
                
                $("#lvl_dsiply_status_intermediate").prop('required',true);
                $("#subject_lvl_intermediate").prop('required',true);
                $("#chapter_lvl_intermediate").prop('required',true);
                $("#insId_lvl_intermediate").prop('required',true);
                
                $('.nav-tabs button[data-bs-target="#intermediate"]').tab('show');
                $("#courseLvl").val("intermediate");

                setTimeout(function(){
                    validator.element("#subject_lvl_intermediate");
                    validator.element("#chapter_lvl_intermediate");
                    validator.element("#insId_lvl_intermediate");
                },1000);

                $("#form_error").html(errHtml);

                 setTimeout(function(){
                   document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
                },1000);
                
                return false;
            }else{
                if((lvl_dsiply_status_inter == 0 && interCrsLvlId == 0)){
                    $("#lvl_dsiply_status_intermediate").prop('required',false);
                    $("#subject_lvl_intermediate").prop('required',false);
                    $("#chapter_lvl_intermediate").prop('required',false);
                    $("#insId_lvl_intermediate").prop('required',false);
                  
                    $("label.error").hide();
                    $(".error").removeClass("error");
                    $("#form_error").html('');
                }  
            }
        }
        
        if((checkCurrentTab && currentTab == "advanced") || checkCurrentTab == false){    

            //Validation on advanced level
            var subject_lvl_advanced = $("#subject_lvl_advanced").val();
            var chapter_lvl_advanced = $("#chapter_lvl_advanced").val();
            var insId_lvl_advanced = $("#insId_lvl_advanced").val();

            var advancedCrsLvlId = $("#advancedCrsLvlId").val();

            if(((lvl_dsiply_status_advanced.length>0 && advancedCrsLvlId != "null") || (lvl_dsiply_status_advanced == 1 && advancedCrsLvlId == "null")) && (!subject_lvl_advanced.length > 0 || !chapter_lvl_advanced.length > 0 || !insId_lvl_advanced.length > 0)){

                 if(advancedCrsLvlId != "null"){
                    var errHtml = '<div class="alert alert-warning" role="alert">You have not provided the least required data for existing advanced level, No changes will be made to this level</div>';
                 }else{    
                    var errHtml = '<div class="alert alert-warning" role="alert">Advanced level data is incomplete!</div>';
                 }
                 
                 $("#lvl_dsiply_status_advanced").prop('required',true);
                 $("#subject_lvl_advanced").prop('required',true);
                 $("#chapter_lvl_advanced").prop('required',true);
                 $("#insId_lvl_advanced").prop('required',true);

                 $('.nav-tabs button[data-bs-target="#advanced"]').tab('show');
                 $("#courseLvl").val("advanced");

                 setTimeout(function(){
                    validator.element("#subject_lvl_advanced");
                    validator.element("#chapter_lvl_advanced");
                    validator.element("#insId_lvl_advanced");
                 },1000);   

                 $("#form_error").html(errHtml);
        
                 setTimeout(function(){
                    document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
                 },1000);

                 return false;
            }else{
                if((lvl_dsiply_status_advanced == 0 && advancedCrsLvlId == 0)){
                     $("#lvl_dsiply_status_advanced").prop('required',false);
                     $("#subject_lvl_advanced").prop('required',false);
                     $("#chapter_lvl_advanced").prop('required',false);
                     $("#insId_lvl_advanced").prop('required',false);

                     $("label.error").hide();
                     $(".error").removeClass("error");
                     $("#form_error").html('');
                }  
            }
        }    

        if(lvl_dsiply_status_beginner == 0 && lvl_dsiply_status_inter == 0 && lvl_dsiply_status_advanced == 0){
             var courseId = $("#courseId").val();

             if(courseId){
                var alertText = "You have to choose at leset one level to update the course!";
             }else{
                var alertText = "You have to choose at leset one level to create a course!";
             }
             var errHtml = '<div class="alert alert-danger" role="alert">'+alertText+'</div>';
             $("#form_error").html(errHtml);
             document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
             return false;
        }else{
            $("#form_error").html('');
        }

        return true;
    }

    $(document).on("change","#lvl_dsiply_status_beginner",function(e){
          e.preventDefault();
          
          var beginnerCrsLvlId = $("#beginnerCrsLvlId").val();
          var lvl_display_status = $("#lvl_dsiply_status_beginner").val();

          if(beginnerCrsLvlId == "null"){
              if(lvl_display_status == 1){
                 //Show intermediate content section
                 $("#course_beginner_details").show();
                 $("#no_beginner_data_avail").hide(); 
              }else{
                 //Hide intermediate content section
                 $("#course_beginner_details").hide();
                 $("#no_beginner_data_avail").show(); 
              }
          }

          changeSelect();
          validateCourseForm(true);
          return false;
    });  

    $(document).on("change","#lvl_dsiply_status_intermediate",function(e){
          e.preventDefault();

          var interCrsLvlId = $("#interCrsLvlId").val();
          var lvl_display_status = $("#lvl_dsiply_status_intermediate").val();

          if(interCrsLvlId == "null"){
              if(lvl_display_status == 1){
                 //Show intermediate content section
                 $("#course_intermediate_details").show();
                 $("#no_intermediate_data_avail").hide(); 
              }else{
                 //Hide intermediate content section
                 $("#course_intermediate_details").hide();
                 $("#no_intermediate_data_avail").show(); 
              }
          }    

          changeSelect();
          validateCourseForm(true);
          return false;
    }); 

    $(document).on("change","#lvl_dsiply_status_advanced",function(e){
          e.preventDefault();

          var advancedCrsLvlId = $("#advancedCrsLvlId").val();
          var lvl_display_status = $("#lvl_dsiply_status_advanced").val();

          if(advancedCrsLvlId == "null"){
             if(lvl_display_status == 1){
                //Show intermediate content section
                $("#course_advanced_details").show();
                $("#no_advanced_data_avail").hide();
             }else{
                //Hide intermediate content section
                $("#course_advanced_details").hide();
                $("#no_advanced_data_avail").show(); 
             }     
          }

          changeSelect();
          validateCourseForm(true);
          return false;
    }); 

    $(document).ready(function () {
        var selectedChapter = [];

        changeSelect("onLoad");
       
        //Tab On Click Handler
        $(document).on('click','.click_on_tab',function(event){
            var courseLvl = $(this).data('lvl');
            $("#courseLvl").val(courseLvl);

            setTimeout(function(){
                changeSelect("ready");
            },200);
        });
        
        //Subject On Change Handler
        $(document).on('change','.subjectId',function(event){
            var subjectId = $(this).val();
            var subjectTypeof = '';
            var courseLvl = $('#courseLvl').val();

            $(this).valid();
            
            var chapterId = $('#chapter_lvl_'+courseLvl).val();

            chapterId = chapterId.map(function (el) {
              return el.trim();
            });

            //console.log(chapterId);

            if(subjectId.length==1){
               subjectId = subjectId.toString();
               subjectTypeof = 'string'; 
            }
            else if(subjectId.length>1){
                subjectId = subjectId;
                subjectTypeof = 'array';
            }else{
                $('#chapter_lvl_'+courseLvl).html('');
                validateCourseForm(true);
                return false;
            }
          
            $.ajax({
                url: baseUrl+"instructor/getChapters",
                type: 'post',
                dataType: 'html',
                data: {
                    subjectId: subjectId,
                    subjectTypeof:subjectTypeof
                },
            })
            .done(function(responseData) {
                var data = JSON.parse(responseData);
                if(data.check = 'success'){
                   //console.log(data); 
                   var chapterListHtml = '';
                   /*$('#chapter_lvl_'+courseLvl).html(data); 
                   $(".chapterId").select2({
                      placeholder : 'Select a chapter'
                   });*/
                   var chapterList = data.chapterList;
                   //console.log(chapterList); 
        
                   //Creating html element for child category section
                   for(var i=0;i<chapterList.length;i++){
                        
                        if($.inArray(chapterList[i].chapterId, chapterId) !== -1){
                            var selected = 'selected';
                        }else{
                            var selected = '';
                        } 

                        chapterListHtml += '<option value="'+chapterList[i].chapterId+'" '+selected+'>'+
                                               chapterList[i].chapterName+' ('+chapterList[i].subjectName+')'+'</option>';
                   } 

                   $('#chapter_lvl_'+courseLvl).html(chapterListHtml);  
               }else{
                   $('#chapter_lvl_'+courseLvl).html('');
               }

               validateCourseForm(true);
                
            })
            .fail(function(data) {
                console.log(data);
            });
        });

        //Chapter change handling
        $(document).on('change','.chapterId',function(event){
            $(this).valid();
            validateCourseForm(true);
        });

        //Instructor change handling
        $(document).on('change','.insId',function(event){
            $(this).valid();
            validateCourseForm(true);
        });
    });

    $("input[type='file']").on("change",function () {
        $(this).valid();
        //Check file extension
        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            alert('Only image is allowed to upload here!');
            $(this).val('');
            return false;
        }
        //Check file size
        var fileSize = this.files[0].size;
        if(fileSize>2097152){
            alert("File size can't be more than 2MB.");
            $(this).val('');
            return false;
        }
    });

    //HANDLING CHECKOUT FORM
    $("#manage_course_form").on('submit', function(event){
         event.preventDefault();
         
         var courseValidation = validateCourseForm();

         if(!courseValidation){
            //console.log(courseValidation);
            return false;
         }else{   

             var courseId = $("#courseId").val();

             if(courseId){
                var form_type = 'update';
                var ajaxController = baseUrl+'instructor/course/update';
             }else{
                var form_type = 'create';
                var ajaxController = baseUrl+'instructor/course/create';
             }
             
             //Throwing ajax request in server 
             $.ajax({
              url:ajaxController,
              method:'POST',
              data: new FormData(this),
              contentType:false,
              processData:false,
              beforeSend: function() {
                 
              },
              success:function(resposeData){
                 var data = JSON.parse(resposeData);
                 //console.log(data);
                 if(data.check == 'success'){
                   var responseArr = [data.msg,'success','#A5DC86'];
                   var redirectURL = baseUrl+'instructor/course/edit/'+data.courseId; 
                   alert_response(responseArr,redirectURL);
                   return true; 
                 }else{
                    var responseArr = [data.msg,'error','#DD6B55'];
                    //var redirectURL = baseUrl+'instructor/course/edit/'+data.courseId;  
                    alert_func(responseArr);
                    return false;
                 }
              }
            });

          }         
     });
</script>
