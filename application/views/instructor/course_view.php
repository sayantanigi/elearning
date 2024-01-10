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
          <li class="breadcrumb-item active" aria-current="page">View Course Detail</li>
        </ol>
      </nav>    

        <div class="row">
            <div class="col-lg-6">
                <div class="dashboard-content-box">

                    <h4 class="dashboard-content-box__title">Course Description</h4>

                    <div class="row gy-4">
                        <div class="col-md-12">
                          <label class="form-label-02">Course Name<span style="color:red;"> *</span></label>
                          <input type="text" name="courseName" id="courseName" value="<?=(!empty($courseDetail->courseName)?$courseDetail->courseName:'')?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-12">
                            <div class="dashboard-content__input">
                              <label class="form-label-02">Summary<span style="color:red;"> *</span></label>
                              <textarea class="form-control tinymceReadonly" name="descriptions" readonly><?=(!empty($courseDetail->descriptions)?$courseDetail->descriptions:'')?></textarea>
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
                        <input id="dashboard-photo-dialogue-box" class="dashboard-settings-profile__input test" type="file" name="courseImage" accept=".png,.jpg,.jpeg" readonly />
                        <div id="dashboard-cover-area" class="dashboard-settings-profile__cover" data-fallback="<?= base_url('uploads/noimg.png') ?>" style="background-image:url(<?=$courseBgImg?>)">
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
                                       
                                       <label class="form-label-02">Display Level<span style="color:red;"> *</span></label> 
                                       <select class="form-control" name="lvl_dsiply_status_beginner" id="lvl_dsiply_status_beginner" disabled>
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
                                                 <?php 
                                                   if (@$beginnerLvlDetail->image && file_exists('./uploads/level/'.@$beginnerLvlDetail->image)) {
                                                      $lvlBeginnerBgImg = base_url('uploads/level/'.@$beginnerLvlDetail->image);
                                                   }else{
                                                      $lvlBeginnerBgImg = base_url('uploads/noimg.png');
                                                   }   
                                                 ?>
                                                <div class="avatar-preview">
                                                    <div id="crsImgBeginnerPreview" style="background-image: url(<?=$lvlBeginnerBgImg?>);">
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
                                                    <input type="text" class="form-control" name="beginner_intro_video" value="<?=((!empty($beginnerLvlDetail) && !empty($beginnerLvlDetail->intro_video)?$beginnerLvlDetail->intro_video:''))?>" readonly>
                                                </div>
                                            </div>      

                                        </div>
                                       
                                    </div>   

                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <div class="dashboard-content__input">
                                              <label class="form-label-02">Level Summary<span style="color:red;"> *</span></label>
                                              <textarea class="form-control tinymceReadonly" id="descriptions_beginner" name="descriptions_beginner">
                                                  <?=((!empty($beginnerLvlDetail) && !empty($beginnerLvlDetail->descriptions)?$beginnerLvlDetail->descriptions:''))?>
                                              </textarea>
                                            </div>
                                        </div>
                                   </div>

                                </div> 

                                <div id="no_beginner_data_avail" class="mt-4" <?=(!empty($beginnerLvlDetail)?'style="display:none;"':'')?>>
                                    <div class="alert alert-warning" role="alert">
                                       No data is available for this level!
                                    </div>
                                </div>   

                          </div>
                          
                          <div class="tab-pane fade" id="intermediate" role="tabpanel" aria-labelledby="profile-tab">

                               <div class="row mt-4">
                                 <div class="col-md-12">

                                    <label class="form-label-02">Display Level<span style="color:red;"> *</span></label> 
                                     <select class="form-control" name="lvl_dsiply_status_intermediate" id="lvl_dsiply_status_intermediate" disabled>
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
                                             <?php 
                                               if (@$intermediateLvlDetail->image && file_exists('./uploads/level/'.@$intermediateLvlDetail->image)) {
                                                  $lvlInterBgImg = base_url('uploads/level/'.@$intermediateLvlDetail->image);
                                               }else{
                                                  $lvlInterBgImg = base_url('uploads/noimg.png');
                                               }   
                                             ?>
                                            <div class="avatar-preview">
                                                <div id="crsImgInterPreview" style="background-image: url(<?=$lvlInterBgImg?>);">
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
                                                <input type="text" class="form-control" name="intermediate_intro_video" value="<?=((!empty($intermediateLvlDetail) && !empty($intermediateLvlDetail->intro_video)?$intermediateLvlDetail->intro_video:''))?>" readonly>
                                            </div>
                                        </div>  

                                    </div>  

                                   </div>   
                                    
                                   <div class="row">
                                    
                                     <div class="col-md-12 mt-4">
                                        <div class="dashboard-content__input">
                                          <label class="form-label-02">Level Summary<span style="color:red;"> *</span></label>
                                          <textarea class="form-control tinymceReadonly" name="descriptions_intermediate">
                                              <?=((!empty($intermediateLvlDetail) && !empty($intermediateLvlDetail->descriptions)?$intermediateLvlDetail->descriptions:''))?>
                                          </textarea>
                                        </div>
                                    </div>
                                   </div>

                               </div>

                                <div id="no_intermediate_data_avail" class="mt-4" <?=(!empty($intermediateLvlDetail)?'style="display:none;"':'')?>>
                                    <div class="alert alert-warning" role="alert">
                                         No data is available for this level!
                                     </div>
                                </div>     

                           </div>


                            <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="contact-tab">

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                       
                                       <label class="form-label-02">Display Lavel<span style="color:red;"> *</span></label>
                                       <select class="form-control" name="lvl_dsiply_status_advanced" id="lvl_dsiply_status_advanced" disabled>
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
                                                <?php 
                                                   if (@$advancedLvlDetail->image && file_exists('./uploads/level/'.@$advancedLvlDetail->image)) {
                                                      $lvlAdvancedBgImg = base_url('uploads/level/'.@$advancedLvlDetail->image);
                                                   }else{
                                                      $lvlAdvancedBgImg = base_url('uploads/noimg.png');
                                                   }   
                                                ?>
                                                <div class="avatar-preview">
                                                    <div id="crsImgAdvncPreview" style="background-image: url(<?=$lvlAdvancedBgImg?>);">
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
                                                    <input type="text" class="form-control" name="advanced_intro_video" value="<?=((!empty($advancedLvlDetail) && !empty($advancedLvlDetail->intro_video)?$advancedLvlDetail->intro_video:''))?>" readonly>
                                                </div>
                                            </div> 

                                        </div> 

                                     </div>    

                                     <div class="row">   

                                         <div class="col-md-12 mt-4">
                                            <div class="dashboard-content__input">
                                              <label class="form-label-02">Level Summary<span style="color:red;"> *</span></label>
                                              <textarea class="form-control tinymceReadonly" name="descriptions_advanced">
                                                  <?=((!empty($advancedLvlDetail) && !empty($advancedLvlDetail->descriptions)?$advancedLvlDetail->descriptions:''))?>
                                              </textarea>
                                            </div>
                                         </div>
                                     </div>

                                </div>   

                                <div id="no_advanced_data_avail" class="mt-4" <?=(!empty($advancedLvlDetail)?'style="display:none;"':'')?>>
                                    <div class="alert alert-warning" role="alert">
                                        No data is available for this level!
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
                    <a href="<?=base_url('instructor/my-created-course')?>"><button type="button" class="btn btn-info btn-hover-info">Back to Course List Page</button></a>
                </div>     
            </div>
        </div>
    </div>
  </div>      

  <script type="text/javascript">

    function changeSelect(pageState){

        if(pageState == "ready"){
            $(".subjectId,.chapterId,.insId").select2('destroy'); 
        }

        //Applying select2 plugin for selecting subject
        $(".subjectId").select2({
            placeholder : 'Select a subject',
            disabled:'readonly'
        });

        $(".chapterId").select2({
          placeholder : 'Select a subject first',
          disabled:'readonly'
        });

         $(".insId").select2({
          placeholder : 'Select course instructor',
          disabled:'readonly'
        });
    
    }

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

</script>
