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
            <form class="form-horizontal forms-sample" id="manage_course_form" method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="card">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card-header">
                                <h4 class="card-title"> <?=$title ?> </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="basic-form">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Course Name <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="courseName" autocomplete="off" placeholder="Course Name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
                                    <div class="col-sm-9">                 
                                        <textarea name="descriptions" class="summernote" required></textarea>
                                    </div>
                                 </div>

                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Course Image </label>
                                   <div class="col-sm-9"> 
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 250px; height: 150px;">
                                                    <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="courseImage" accept="images/*" required>
                                                    </span>
                                                    <a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10 m-b-20 f12" style="display: block;">
                                                <span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif
                                                <span class="label label-danger">Max Upload Size</span>&nbsp;10mb
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
                                <h4 class="card-title"> Add Course Level Details </h4>
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
                                        <label class="col-sm-3 col-form-label">Level <span class="error">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="lvl_dsiply_status_beginner" id="lvl_dsiply_status_beginner">
                                                <!--<option selected disabled>Please select a display status</option>-->
                                                <option value="1">Yes </option>
                                                <option value="0" selected>No </option>
                                            </select>
                                        </div>
                                      </div>  

                                      <div id="course_beginner_details" style="display:none;">

                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Subject <span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control subjectId" name="subjectId_beginner[]" id="subject_lvl_beginner" multiple>
                                                    <?php if (!empty($subjectList) && (count($subjectList) > 0)) { ?>
                                                        <option></option>
                                                        <?php foreach ($subjectList as $key => $v): ?>
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
                                            <label class="col-sm-3 col-form-label">Select Chapters <span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control chapterId" name="chapterId_beginner[]" id="chapter_lvl_beginner" multiple>
                                                    <option></option>
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
                                                            <option value="<?= $v->userId  ?>">
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
                                            <label class="col-sm-3 col-form-label">Introductional Video</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="beginner_intro_video" value="">
                                            </div>
                                         </div>       

                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
                                            <div class="col-sm-9">                 
                                                <textarea name="descriptions_beginner" class="summernote"></textarea>
                                            </div>
                                          </div>
                                        
                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Level Image </label>
                                            <div class="col-sm-9"> 
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 250px; height: 150px;">
                                                            <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
                                                        <div>
                                                            <span class="btn btn-default btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="courseImage_beginner" accept="images/*" >
                                                            </span>
                                                            <a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix margin-top-10 m-b-20 f12" style="display: block;">
                                                        <span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif
                                                        <span class="label label-danger">Max Upload Size</span>&nbsp;10mb
                                                    </div>
                                                </div>
                                             </div>
                                          </div>

                                      </div>   
                                      <div id="no_beginner_data_avail">
                                          <div class="alert alert-warning" role="alert">
                                              Please select display status Yes to enter data for this level, else no data will be inserted for this level!
                                          </div>
                                      </div> 

                                  </div>  
                                </div>   

                              </div>
                              <div class="tab-pane fade" id="intermediate" role="tabpanel" aria-labelledby="intermediate-tab">
                                  
                                <div class="row mt-3">  
                                  <div class="col-lg-12">

                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Level <span class="error">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="lvl_dsiply_status_intermediate" id="lvl_dsiply_status_intermediate">
                                                <!--<option selected disabled>Please select a display status</option>-->
                                                <option value="1">Yes </option>
                                                <option value="0" selected>No </option>
                                            </select>
                                        </div>
                                      </div>  

                                     <div id="course_intermediate_details" style="display:none;">

                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Subject <span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control subjectId" name="subjectId_intermediate[]" id="subject_lvl_intermediate" multiple>
                                                    <?php if (!empty($subjectList) && (count($subjectList) > 0)) { ?>
                                                        <option></option>
                                                        <?php foreach ($subjectList as $key => $v): ?>
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
                                            <label class="col-sm-3 col-form-label">Select Chapters <span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control chapterId" name="chapterId_intermediate[]" id="chapter_lvl_intermediate" multiple>
                                                    <option></option>
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
                                                            <option value="<?= $v->userId  ?>">
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
                                            <label class="col-sm-3 col-form-label">Introductional Video</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="intermediate_intro_video" value="">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
                                            <div class="col-sm-9">                 
                                                <textarea name="descriptions_intermediate" class="summernote"></textarea>
                                            </div>
                                          </div>
                                        
                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Level Image </label>
                                            <div class="col-sm-9"> 
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 250px; height: 150px;">
                                                            <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
                                                        <div>
                                                            <span class="btn btn-default btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="courseImage_intermediate" accept="images/*" >
                                                            </span>
                                                            <a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix margin-top-10 m-b-20 f12" style="display: block;">
                                                        <span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif
                                                        <span class="label label-danger">Max Upload Size</span>&nbsp;10mb
                                                    </div>
                                                </div>
                                             </div>
                                          </div>

                                     </div>
                                     <div id="no_intermediate_data_avail">
                                          <div class="alert alert-warning" role="alert">
                                              Please select display status Yes to enter data for this level, else no data will be inserted for this level!
                                          </div>
                                      </div> 

                                  </div>  
                                </div>  

                              </div>
                              <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
                                  
                                <div class="row mt-3">  
                                   <div class="col-lg-12">

                                     <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Level <span class="error">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="lvl_dsiply_status_advanced" id="lvl_dsiply_status_advanced">
                                                <!--<option selected disabled>Please select a display status</option>-->
                                                <option value="1">Yes </option>
                                                <option value="0" selected>No </option>
                                            </select>
                                        </div>
                                      </div>  
                                      
                                      <div id="course_advanced_details" style="display:none;">

                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Subject <span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control subjectId" name="subjectId_advanced[]" multiple id="subject_lvl_advanced">
                                                    <?php if (!empty($subjectList) && (count($subjectList) > 0)) { ?>
                                                        <option></option>
                                                        <?php foreach ($subjectList as $key => $v): ?>
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
                                            <label class="col-sm-3 col-form-label">Select Chapters <span class="error">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control chapterId" name="chapterId_advanced[]" id="chapter_lvl_advanced" multiple>
                                                    <option></option>
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
                                                            <option value="<?= $v->userId ?>">
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
                                            <label class="col-sm-3 col-form-label">Introductional Video</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="advanced_intro_video" value="">
                                            </div>
                                          </div>       

                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
                                            <div class="col-sm-9">                 
                                                <textarea name="descriptions_advanced" class="summernote"></textarea>
                                            </div>
                                          </div>
                                        
                                          <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Level Image </label>
                                            <div class="col-sm-9"> 
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 250px; height: 150px;">
                                                            <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
                                                        <div>
                                                            <span class="btn btn-default btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="courseImage_advanced" accept="images/*" >
                                                            </span>
                                                            <a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix margin-top-10 m-b-20 f12" style="display: block;">
                                                        <span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif
                                                        <span class="label label-danger">Max Upload Size</span>&nbsp;10mb
                                                    </div>
                                                </div>
                                             </div>
                                          </div>

                                      </div>
                                      <div id="no_advanced_data_avail">
                                          <div class="alert alert-warning" role="alert">
                                              Please select display status Yes to enter data for this level, else no data will be inserted for this level!
                                          </div>
                                      </div> 

                                  </div>  
                                </div>  

                              </div>
                            </div>

                            <div class="form-group offset-3">             
                                <button type="submit" id="save_course_data" class="btn btn-rounded btn-info">Save</button>
                                <a class="btn btn-rounded btn-secondary ml-2" href="<?= admin_url('course/lists')?>">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
            placeholder : 'Select a subject'
        });

        $(".chapterId").select2({
          placeholder : 'Select a subject first'
        });

         $(".insId").select2({
          placeholder : 'Select course instructor'
        });

    }

    function validateCourseForm(checkCurrentTab=false){

        //var currentTabId = $('.tab-content .active').attr('id');
        var currentTab = $("#courseLvl").val();  
        
        var lvl_dsiply_status_beginner = $("#lvl_dsiply_status_beginner").val();
        var lvl_dsiply_status_inter = $("#lvl_dsiply_status_intermediate").val();
        var lvl_dsiply_status_advanced = $("#lvl_dsiply_status_advanced").val();
        
        if((checkCurrentTab && currentTab == "beginner") || checkCurrentTab == false){
            //Validation on beginner level
            var subject_lvl_beginner = $("#subject_lvl_beginner").val();
            var chapter_lvl_beginner = $("#chapter_lvl_beginner").val();
            var insId_lvl_beginner = $("#insId_lvl_beginner").val();
            
            if(lvl_dsiply_status_beginner == 1 && (!subject_lvl_beginner.length > 0 || !chapter_lvl_beginner.length > 0 || !insId_lvl_beginner.length > 0)){
                
                var errHtml = '<div class="alert alert-warning" role="alert">Beginner level data is incomplete!</div>';

                $("#lvl_dsiply_status_beginner").prop('required',true);
                $("#subject_lvl_beginner").prop('required',true);
                $("#chapter_lvl_beginner").prop('required',true);
                $("#insId_lvl_beginner").prop('required',true);

                $('.nav-tabs a[href="#beginner"]').tab('show');
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
                if(lvl_dsiply_status_beginner == 0){
                   $("#lvl_dsiply_status_beginner").prop('required',false);
                   $("#subject_lvl_beginner").prop('required',false);
                   $("#chapter_lvl_beginner").prop('required',false);
                   $("#insId_lvl_beginner").prop('required',false);
                   
                   $("#form_error").html('');
                }  
            }
        }    
        
        if((checkCurrentTab && currentTab == "intermediate") || checkCurrentTab == false){
            //Validation on intermediate level
            var subject_lvl_inter = $("#subject_lvl_intermediate").val();
            var chapter_lvl_inter = $("#chapter_lvl_intermediate").val();
            var insId_lvl_inter = $("#insId_lvl_intermediate").val();
            
            if(lvl_dsiply_status_inter == 1 && (!subject_lvl_inter.length > 0 || !chapter_lvl_inter.length > 0 || !insId_lvl_inter.length > 0)){

                var errHtml = '<div class="alert alert-warning" role="alert">Intermediate level data is incomplete!</div>';
                
                $("#lvl_dsiply_status_intermediate").prop('required',true);
                $("#subject_lvl_intermediate").prop('required',true);
                $("#chapter_lvl_intermediate").prop('required',true);
                $("#insId_lvl_intermediate").prop('required',true);
                
                $('.nav-tabs a[href="#intermediate"]').tab('show');
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
                if(lvl_dsiply_status_inter == 0){
                   $("#lvl_dsiply_status_intermediate").prop('required',false);
                   $("#subject_lvl_intermediate").prop('required',false);
                   $("#chapter_lvl_intermediate").prop('required',false);
                   $("#insId_lvl_intermediate").prop('required',false);
                   
                   $("#form_error").html('');
                }  
            }
        }    
        
        if((checkCurrentTab && currentTab == "advanced") || checkCurrentTab == false){
            //Validation on advanced level
            var subject_lvl_advanced = $("#subject_lvl_advanced").val();
            var chapter_lvl_advanced = $("#chapter_lvl_advanced").val();
            var insId_lvl_advanced = $("#insId_lvl_advanced").val();
            
            if(lvl_dsiply_status_advanced == 1 && (!subject_lvl_advanced.length > 0 || !chapter_lvl_advanced.length > 0 || !insId_lvl_advanced.length > 0)){
                
                var errHtml = '<div class="alert alert-warning" role="alert">Advanced level data is incomplete!</div>';

                $("#lvl_dsiply_status_advanced").prop('required',true);
                $("#subject_lvl_advanced").prop('required',true);
                $("#chapter_lvl_advanced").prop('required',true);
                $("#insId_lvl_advanced").prop('required',true);

                $('.nav-tabs a[href="#advanced"]').tab('show');
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
                if(lvl_dsiply_status_advanced == 0){
                    $("#lvl_dsiply_status_advanced").prop('required',false);
                    $("#subject_lvl_advanced").prop('required',false);
                    $("#chapter_lvl_advanced").prop('required',false);
                    $("#insId_lvl_advanced").prop('required',false);

                    $("#form_error").html('');
                }  
            }
        }    

        if(lvl_dsiply_status_beginner == 0 && lvl_dsiply_status_inter == 0 && lvl_dsiply_status_advanced == 0){

             var alertText = "You have to choose at leset one level to create a course!";
             var errHtml = '<div class="alert alert-danger" role="alert">'+alertText+'</div>';
             $("#form_error").html(errHtml);
             document.getElementById("courseLvl_Detail").scrollIntoView({ behavior: "smooth" });
             return false;
        }else{
            $("#form_error").html('');
        }

        return true;
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
            $(this).valid();
            var subjectTypeof = '';
            var courseLvl = $('#courseLvl').val();

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
                url: adminUrl+"course/getChapters",
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

    $(document).on("change","#lvl_dsiply_status_beginner",function(e){
          e.preventDefault();
          
          var lvl_display_status = $("#lvl_dsiply_status_beginner").val();

          if(lvl_display_status == 1){
             //Show intermediate content section
             $("#course_beginner_details").show();
             $("#no_beginner_data_avail").hide(); 
          }else{
             //Hide intermediate content section
             $("#course_beginner_details").hide();
             $("#no_beginner_data_avail").show(); 
          }

          changeSelect();
          validateCourseForm(true);
          return false;
    });  

    $(document).on("change","#lvl_dsiply_status_intermediate",function(e){
          e.preventDefault();

          var lvl_display_status = $("#lvl_dsiply_status_intermediate").val();

          if(lvl_display_status == 1){
             //Show intermediate content section
             $("#course_intermediate_details").show();
             $("#no_intermediate_data_avail").hide(); 
          }else{
             //Hide intermediate content section
             $("#course_intermediate_details").hide();
             $("#no_intermediate_data_avail").show(); 
          }

          changeSelect();
          validateCourseForm(true);
          return false;
    }); 

    $(document).on("change","#lvl_dsiply_status_advanced",function(e){
          e.preventDefault();

          var lvl_display_status = $("#lvl_dsiply_status_advanced").val();

          if(lvl_display_status == 1){
            //Show intermediate content section
            $("#course_advanced_details").show();
            $("#no_advanced_data_avail").hide();
          }else{
            //Hide intermediate content section
            $("#course_advanced_details").hide();
            $("#no_advanced_data_avail").show(); 
          }     

          changeSelect();
          validateCourseForm(true);
          return false;
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

    //HANDLING Course Create FORM
    $(document).on('submit', '#manage_course_form', function(event){
     event.preventDefault();
     
     var courseValidation = validateCourseForm();

     if(!courseValidation){
        //console.log(courseValidation);
        return false;
     }else{   

         var courseId = $("#courseId").val();

         if(courseId){
            var form_type = 'update';
            var ajaxController = adminUrl+'course/update';
         }else{
            var form_type = 'create';
            var ajaxController = adminUrl+'course/create';
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
               var redirectURL = adminUrl+'course/edit/'+data.courseId; 
               alert_response(responseArr,redirectURL);
               return true; 
             }else{
                var responseArr = [data.msg,'error','#DD6B55'];
                //var redirectURL = adminUrl+'course/edit/'+data.courseId;  
                alert_func(responseArr);
                return false;
             }
          }
        });

      }         
 });
</script>
