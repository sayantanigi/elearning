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
     }

     if($level->level == "intermediate"){
        $intermediateLvlDetail = $level;
     }

     if($level->level == "advanced"){
        $advancedLvlDetail = $level;
     }
  }

  /*print"<pre>";
  print_r($beginnerChapterList);
  print"</pre>";exit;*/

?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('course/lists') ?>"><?=ucwords(@$page)?></a></li>
               
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
            </ol>
        </div>
        <div class="row">   
          <div class="col-xl-12 col-lg-12">
               
                <div class="card">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card-header">
                                <h4 class="card-title"> <?= $title ?> </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="basic-form">
                            
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Course Name <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="courseName" autocomplete="off" value="<?=$courseDetail->courseName?>" placeholder="Course Name" required readonly>
                                        <input type="hidden" name="courseId" id="courseId" value="<?=$courseDetail->courseId?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
                                    <div class="col-sm-9">                 
                                        <textarea name="descriptions" id="crs_desc" class="summernote" readonly required><?=$courseDetail->descriptions?></textarea>
                                    </div>
                                 </div>

                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Course Image </label>
                                   <div class="col-sm-9"> 
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 250px; height: 150px;">
                                                    <?php if (@$courseDetail->image && file_exists('./uploads/courses/'.@$courseDetail->image)) { ?>
                                                        <img src="<?= base_url('uploads/courses/'.@$courseDetail->image) ?>" alt="<?=$courseDetail->courseName?>">
                                                    <?php } else { ?>
                                                        <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="row" id="courseLvl_Detail">
                        <div class="col-md-7">
                            <div class="card-header">
                                <h4 class="card-title"> Edit Course Level Details </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div id="form_error"></div>

                        <div class="basic-form">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link click_on_tab active" id="beginner-tab" data-lvl="beginner" data-toggle="tab" href="#beginner" role="tab" aria-controls="beginner" aria-selected="true">Beginner Level</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link click_on_tab" id="intermediate-tab" data-toggle="tab" data-lvl="intermediate" href="#intermediate" role="tab" aria-controls="intermediate" aria-selected="false">Intermediate Level</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link click_on_tab" id="advanced-tab" data-toggle="tab" data-lvl="advanced" href="#advanced" role="tab" aria-controls="advanced" aria-selected="false">Advanced Level</a>
                              </li>
                            </ul>
                            <input type="hidden" name="courseLvl" id="courseLvl" value="beginner">

                            <div class="tab-content" id="myTabContent">
                              <div class="tab-pane fade show active" id="beginner" role="tabpanel" aria-labelledby="beginner-tab">
                                <div class="row mt-3">  
                                  <div class="col-lg-12">

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Level Display Status <span class="error">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="lvl_dsiply_status_beginner" id="lvl_dsiply_status_beginner" disabled>
                                                <!--<option selected disabled>Please select a display status</option>-->
                                                <option value="1" <?=($beginnerLvlDetail->status == 1?'selected':'')?>>Yes </option>
                                                <option value="0" <?=($beginnerLvlDetail->status == 1?'':'selected')?>>No </option>
                                            </select>
                                        </div>
                                      </div>  

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Subject <span class="error">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control subjectId" name="subjectId_beginner[]" id="subject_lvl_beginner" multiple>
                                                <?php if (!empty($subjectList) && (count($subjectList) > 0)) { ?>
                                                    <option></option>
                                                    <?php foreach ($subjectList as $key => $v): ?>
                                                        <option value="<?= $v->subjectId  ?>" <?=(in_array($v->subjectId, $beginnerSubjectId)?'selected':'')?>>
                                                            <?= $v->subjectName ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                <?php } else { ?>
                                                    <option value="">No subject found</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Select Chapters <span class="error">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control chapterId" name="chapterId_beginner[]" id="chapter_lvl_beginner" multiple  >
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
                                     </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Instructor <span class="error">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control insId" name="insId_beginner[]" id="insId_lvl_beginner" multiple>
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
                                     </div>

                                     <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Summary</label>
                                        <div class="col-sm-9">                 
                                            <textarea name="descriptions_beginner" class="summernote" id="beginner_desc" ><?=$beginnerLvlDetail->descriptions?></textarea>
                                        </div>
                                     </div>
                                    
                                     <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Level Image </label>
                                        <div class="col-sm-9"> 
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 250px; height: 150px;">
                                                         <?php if (@$beginnerLvlDetail->image && file_exists('./uploads/level/'.@$beginnerLvlDetail->image)) { ?>
                                                            <img src="<?= base_url('uploads/level/'.@$beginnerLvlDetail->image) ?>" alt="beginner_lvl_image">
                                                         <?php } else { ?>
                                                            <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                         <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                     </div>

                                  </div>  
                                </div>   

                              </div>
                              <div class="tab-pane fade" id="intermediate" role="tabpanel" aria-labelledby="intermediate-tab">
                                  
                                <div class="row mt-3">  
                                  <div class="col-lg-12">

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Level Display Status <span class="error">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="lvl_dsiply_status_intermediate" id="lvl_dsiply_status_intermediate" disabled>
                                                <!--<option selected disabled>Please select a display status</option>-->
                                                <option value="1" <?=(!empty($intermediateLvlDetail) && $intermediateLvlDetail->status == 1?'selected':'')?>>Yes </option>
                                                <option value="0" <?=(!empty($intermediateLvlDetail) && $intermediateLvlDetail->status == 1?'':'selected')?>>No </option>
                                            </select>
                                        </div>
                                      </div>  

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Subject <span class="error">*</span></label>
                                        <div class="col-sm-9">
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
                                      </div>

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Select Chapters <span class="error">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control chapterId" name="chapterId_intermediate[]" id="chapter_lvl_intermediate" multiple  >
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
                                     </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Instructor <span class="error">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control insId" name="insId_intermediate[]" id="insId_lvl_intermediate" multiple>
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
                                     </div>

                                     <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Summary</label>
                                        <div class="col-sm-9">                 
                                            <textarea name="descriptions_intermediate" class="summernote" id="intermediate_desc" ><?=((!empty($intermediateLvlDetail) && !empty($intermediateLvlDetail->descriptions)?$intermediateLvlDetail->descriptions:''))?></textarea>
                                        </div>
                                     </div>
                                    
                                     <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Level Image </label>
                                        <div class="col-sm-9"> 
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 250px; height: 150px;">
                                                         <?php if (@$intermediateLvlDetail->image && file_exists('./uploads/level/'.@$intermediateLvlDetail->image)) { ?>
                                                            <img src="<?= base_url('uploads/level/'.@$intermediateLvlDetail->image) ?>" alt="beginner_lvl_image">
                                                         <?php } else { ?>
                                                            <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                         <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                     </div>

                                  </div>  
                                </div>  

                              </div>
                              <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
                                  
                                <div class="row mt-3">  
                                   <div class="col-lg-12">

                                     <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Level Display Status <span class="error">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="lvl_dsiply_status_advanced" id="lvl_dsiply_status_advanced" disabled>
                                                <!--<option selected disabled>Please select a display status</option>-->
                                                <option value="1" <?=(!empty($advancedLvlDetail) && $advancedLvlDetail->status == 1?'selected':'')?>>Yes </option>
                                                <option value="0" <?=(!empty($advancedLvlDetail) && $advancedLvlDetail->status == 1?'':'selected')?>>No </option>
                                            </select>
                                        </div>
                                      </div>  

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Subject <span class="error">*</span></label>
                                        <div class="col-sm-9">
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
                                      </div>

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Select Chapters <span class="error">*</span></label>
                                        <div class="col-sm-9">
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
                                     </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Instructor <span class="error">*</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control insId" name="insId_advanced[]" id="insId_lvl_advanced" multiple>
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
                                     </div>

                                     <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Summary</label>
                                        <div class="col-sm-9">                 
                                            <textarea name="descriptions_advanced" class="summernote" id="advanced_desc" ><?=((!empty($advancedLvlDetail) && !empty($advancedLvlDetail->descriptions)?$advancedLvlDetail->descriptions:''))?></textarea>
                                        </div>
                                     </div>
                                    
                                     <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Level Image </label>
                                        <div class="col-sm-9"> 
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 250px; height: 150px;">
                                                         <?php if (@$advancedLvlDetail->image && file_exists('./uploads/level/'.@$advancedLvlDetail->image)) { ?>
                                                            <img src="<?= base_url('uploads/level/'.@$advancedLvlDetail->image) ?>" alt="beginner_lvl_image">
                                                         <?php } else { ?>
                                                            <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                         <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                     </div>

                                  </div>  
                                </div>  

                              </div>
                            </div>

                            <div class="form-group offset-3">             
                                <a class="btn btn-rounded btn-secondary ml-2" href="<?= admin_url('course/lists')?>">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
          </div>  
        </div>                  
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var selectedChapter = [];
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

        //Tab On Click Handler
        $(document).on('click','.click_on_tab',function(event){
            var courseLvl = $(this).data('lvl');
            $("#courseLvl").val(courseLvl);
        });

        $("#crs_desc").summernote('disable');
        $("#beginner_desc").summernote('disable');
        $("#intermediate_desc").summernote('disable');
        $("#advanced_desc").summernote('disable');
    });
</script>
