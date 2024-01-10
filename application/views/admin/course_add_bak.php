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
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card-header">
                                <h4 class="card-title"> <?= $title ?> </h4>
                            </div>
                        </div>
                        <!--<div class="col-md-5">
                            <div class="card-header text-right">
                                <a href="javascript:void(0);" id="add_level_for_course" class="btn btn-rounded btn-success"><span> <i class="fa fa-plus color-info"></i>
                                </span> Add Level </a>    
                            </div>
                        </div>-->
                    </div>

                    <div class="card-body">
                        <div class="basic-form">
                            <form action="<?= admin_url('course/create') ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Course Name <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="courseName" autocomplete="off" value="" required="" placeholder="Course Name">
                                    </div>
                                </div>
                                 
                                 <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Level <span class="error">*</span></label>
                                    <div class="col-sm-3">
                                        <select class="form-control course_lvls" name="level_1" id="lvl_1" required>
                                            <option selected disabled>Please select a level </option>
                                            <option value="beginner">Beginners </option>
                                            <option value="intermediate">Intermediate</option>
                                            <option value="advanced">Advanced</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <a href="javascript:void(0);" id="add_level_for_course" class="btn btn-rounded btn-success"><span> <i class="fa fa-plus color-info"></i>
                                        </span> Add Level </a>    
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Subject  <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control subjectId" name="subjectId_1[]" data-lvl="1" multiple id="subject_lvl_<?=$courseLvlCount?>" required>
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
                                        <select class="form-control chapterId" name="chapterId_1[]" id="chapter_lvl_1" data-lvl="1" multiple required>
                                            <option></option>
                                        </select>  
                                    </div>
                                </div>
                                <hr style="color:black;">

                                <div class="row" id="extra_level_html">
                                     
                                </div> 
                              
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
                                    <div class="col-sm-9">                 
                                        <textarea name="descriptions" class="summernote" required></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Image </label>
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
                                                        <input type="file" name="courseImage" accept="images/*" >
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


                                <div class="form-group row offset-3">             

                                    <button type="submit" class="btn btn-rounded btn-info">Save</button>
                                    <a class="btn btn-rounded btn-secondary" href="<?= admin_url('course/lists')?>">
                                        Back
                                    </a>

                                </div>
                            </form>
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
            placeholder : 'Select a subject'
        });

        $(".chapterId").select2({
          placeholder : 'Select a subject first'
        });
        
        //Subject On Change Handler
        $(document).on('change','.subjectId',function(event){
            var subjectId = $(this).val();
            var subjectTypeof = '';
            var courseLvlCount = $(this).data('lvl');

            var chapterId = $('#chapter_lvl_'+courseLvlCount).val();

            //console.log(chapterId);

            if(subjectId.length==1){
               subjectId = subjectId.toString();
               subjectTypeof = 'string'; 
            }
            else if(subjectId.length>1){
                subjectId = subjectId;
                subjectTypeof = 'array';
            }else{
                $('#chapter_lvl_'+courseLvlCount).html('');
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
                   /*$('#chapter_lvl_'+courseLvlCount).html(data); 
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
                                               chapterList[i].chapterName+'</option>';
                   } 

                   $('#chapter_lvl_'+courseLvlCount).html(chapterListHtml);  
               }else{
                   $('#chapter_lvl_'+courseLvlCount).html('');
               }
                
            })
            .fail(function(data) {
                console.log(data);
            });
        });
    });
</script>
