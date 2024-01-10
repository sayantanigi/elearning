<?php
if(!empty($subjectId)){
   $subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId); 
}
if(!empty($chapterId)){
   $chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId); 
}
if(!empty($lessonId)){
   $lessonInfo = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);
}
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
            <?php if(! empty($subjectInfo)){?>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
            <?php } if(!empty($chapterInfo)){?>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
            <?php } if(! empty($lessonInfo)){?>
                <li class="breadcrumb-item">
                    <a href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>"><?=ucwords($lessonInfo->lessonName)?></a>
                </li>
            <?php }?>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
            </ol>
        </div>
        <div class="row">	
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> <?= $title ?> </h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="<?= admin_url('subject/createTest') ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="subjectId" id="subjectId" value="<?= @$subjectId ?>">
                                <input type="hidden" name="chapterId" id="chapterId" value="<?= @$chapterId ?>">
                                <input type="hidden" name="lessonId" id="lessonId" value="<?= @$lessonId ?>">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Test Name <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="testName" id="testName" autocomplete="off" value="" required="" placeholder="Test Name">
                                    </div>
                                </div>
                              
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Test Number <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="testNumber" id="testNumber" autocomplete="off" value="" required="" placeholder="Test Number">
                                    </div>
                                </div>
                                   <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Instructions <span class="error">*</span></label>
                                    <div class="col-sm-9">                 
                                        <textarea name="instructions" class="summernote" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Duration </label>
                                    <div class="col-sm-9">
                                         <input type="text" class="form-control" name="duration" id="duration" autocomplete="off" value="" required="" placeholder="eg 90Mins">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Image <span class="error">*</span></label>
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
                                                        <input type="file" name="coverImg" accept="images/*" required="">
                                                    </span>
                                                    <a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10 m-b-20 f12" style="display: block;">
                                                <span class="label label-danger">Format</span>&nbsp; jpg, jpeg, png, gif
                                                <span class="label label-danger"> Max Upload Size</span>&nbsp;10mb
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row offset-3">             

                                    <button type="submit" class="btn btn-rounded btn-info">Save</button>
                                    <?php
                                        if(!empty($subjectId) && !empty($chapterId) && !empty($lessonId)){
                                    ?>
                                        <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>">
                                            Back
                                        </a>
                                    <?php
                                      }
                                      elseif(!empty($subjectId) && !empty($chapterId)){
                                    ?>
                                         <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>">
                                            Back
                                         </a>
                                    <?php
                                      }elseif(!empty($subjectId)){
                                    ?>
                                         <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/view/'.$subjectId) ?>">
                                            Back
                                         </a>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>					
        </div>
    </div>
</div>
