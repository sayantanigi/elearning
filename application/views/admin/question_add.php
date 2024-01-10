<?php
$totalSegment = count($this->uri->segment_array());
if(!empty($totalSegment) && $totalSegment ==5){
$subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);
$testInfo = $this->mymodel->get('tests', true, 'testId', $testId);
}else{
    $subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);
    $chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
    $lessonInfo = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);
    $testInfo = $this->mymodel->get('tests', true, 'testId', $testId);
}
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <?php 
                if(!empty($totalSegment) && $totalSegment ==5){
            ?>
            <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
                         <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId.'/'.$testId) ?>"><?=ucwords($testInfo->testName)?></a></li>               
                        <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
            </ol>
            <?php
            }else{
            ?>
                <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
                        <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>"><?=ucwords($lessonInfo->lessonName)?></a></li>
                         <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewTest/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$testId) ?>"><?=ucwords($testInfo->testName)?></a></li>               
                        <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
                </ol>
            <?php
                }
            ?>
        </div>
        <div class="row">	
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> <?= $title ?> </h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="<?= admin_url('subject/createQuestion')?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="subjectId" value="<?= @$subjectId ?>">
                                <input type="hidden" name="chapterId" value="<?= @$chapterId ?>">
                                <input type="hidden" name="lessonId" value="<?= @$lessonId ?>">
                                <input type="hidden" name="testId" value="<?= @$testId ?>">


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Questions <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea name="question" class="form-control" id="question" rows="5" data-error="This field is Required!" required=""></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Image</label>
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
                                                        <input type="file" name="questionImg" accept="images/*" >
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
                                <div class="showHideMCQ">
                                    <div id="answer-group">
                                        <div class="form-group row" id="0">
                                            <label class="col-sm-3">Option 1 : <span>*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="answer[]" id="answer0" onkeyup="setValue($(this))" data-row-id="0">

                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-inline mt-2">
                                                    <label>
                                                        <input type="radio" class="mr-2" id="correctans0" name="correctans"  value="1">
                                                         Correct Answer 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-xs btn-secondary pull-center" id="add-answer-field">
                                        <i class="fa fa-plus"></i> Add Option
                                    </button>
                                    <div class="clearfix"></div>
                                    <br/>

                                </div>

                                <?php 
                                    if(!empty($totalSegment) && $totalSegment ==5){
                                ?>
                                <div class="form-group row offset-3"> 
                                    <button type="submit" class="btn btn-rounded btn-info mr-2">Save</button>
                                    <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/view/'.$subjectId) ?>">
                                        Back
                                    </a>
                                </div>
                                <?php
                                 }else{
                                ?>
                                    <div class="form-group row offset-3"> 
                                        <button type="submit" class="btn btn-rounded btn-info mr-2">Save</button>
                                        <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewTest/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$testId) ?>">
                                                Back
                                            </a>
                                    </div>
                                <?php
                                 }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>					
        </div>
    </div>
</div>


