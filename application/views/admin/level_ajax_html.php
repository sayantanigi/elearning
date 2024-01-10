<div class="col-md-12" id="level_id_<?=$courseLvlCount?>">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Level <span class="error">*</span></label>
        <div class="col-sm-3">
            <select class="form-control" name="level_<?=$courseLvlCount?>" id="lvl_<?=$courseLvlCount?>" required>
                <option selected disabled>Please select a level </option>
                <?php if(!in_array("beginner", $courseLvl)){ ?>
                    <option value="beginner">Beginners </option>
                <?php } ?>  
                <?php if(!in_array("intermediate", $courseLvl)){ ?>
                    <option value="intermediate">Intermediate</option>
                <?php } ?>  
                <?php if(!in_array("advanced", $courseLvl)){ ?>
                    <option value="advanced">Advanced</option>
                <?php } ?>    
            </select>
        </div>
         <div class="col-sm-6">
            <a href="javascript:void(0);" class="btn btn-rounded btn-danger remove_level_frm_course" data-lvl="<?=$courseLvlCount?>"><span> <i class="fa fa-minus color-info"></i>
            </span> Remove Level </a>    
         </div>
    </div>
     <div class="form-group row">
        <label class="col-sm-3 col-form-label">Subject  <span class="error">*</span></label>
        <div class="col-sm-9">
             <select class="form-control subjectId" name="subjectId_<?=$courseLvlCount?>[]" data-lvl="<?=$courseLvlCount?>" multiple id="subject_lvl_<?=$courseLvlCount?>" required>
            <?php if (!empty($list) && (count($list) > 0)) { ?>
                <option value="">Select Subject</option>
                <?php foreach ($list as $key => $v): ?>
                    <option value="<?= $v->subjectId  ?>">
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
        <label class="col-sm-3 col-form-label">Select Chapters  <span class="error">*</span></label>
        <div class="col-sm-9">
            <select class="form-control chapterId" name="chapterId_<?=$courseLvlCount?>[]" id="chapter_lvl_<?=$courseLvlCount?>" data-lvl="1" multiple required>
                <option></option>
            </select>  
        </div>
    </div>
    <hr style="color:black;">
</div>