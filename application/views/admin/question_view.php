<?php
$subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);
$chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
$lessonInfo = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);
$testInfo = $this->mymodel->get('tests', true, 'testId', $testId);
$questionInfo = $this->mymodel->get('questions', true, 'quesId', $quesId);
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId) ?>"><?=ucwords($lessonInfo->lessonName)?></a></li>
                 <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewTest/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$testId) ?>"><?=ucwords($testInfo->testName)?></a></li>             
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
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Questions <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea style="height:80px!important" name="question" class="form-control" id="question" rows="5" readonly=""><?=$data->question?></textarea>
                                       
                                    </div>
                                </div>
                                <?php if (@$data->image && file_exists('./uploads/questions/'.@$data->image)) { ?>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Thumbnail </label>
                                    <div class="col-sm-9"> 
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <?php if (@$data->image && file_exists('./uploads/questions/'.@$data->image)) { ?>
                                                    <img src="<?= base_url('uploads/questions/'.@$data->image) ?>" style="width: 250px; height: 150px;" alt="">
                                                <?php } else { ?>
                                                    <img src="<?= base_url('dist/images/noimage.jpg') ?>" style="width: 250px; height: 150px;" alt="">
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                                <div class="form-group row">
                                    
                                <label class="col-sm-3">Answer : </label>
                                <div class="col-sm-9">
                                    <?php $i=1; 
                                    foreach($ans_option as $opt){                   

                                        ?>
                                        <div class="form-group">
                                            <div class="row" id="0">

                                                <label class="col-sm-3"> <b>Answer <?=$i;?> :</b> </label>
                                                <div class="col-sm-9">
                                                    <p><?= $opt->optionText?>
                                                    <span class="correct text-success"><?php if($opt->correctAns==1){ echo " [Correct answer]"; }?></span></p>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <?php  $i++; } ?>
                                    </div>
                                
                                </div>
                                 
                                

                                <div class="form-group row offset-3"> 
                                    
                                    <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/viewTest/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$testId) ?>">
                                        Back
                                    </a>
                                </div>
                           
                        </div>
                    </div>
                </div>
            </div>					
        </div>
    </div>
</div>


