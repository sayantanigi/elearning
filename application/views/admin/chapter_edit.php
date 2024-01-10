<?php
$subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);
$chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('subject/view/'.$subjectId) ?>"><?=ucwords($subjectInfo->subjectName)?></a></li>
                  <li class="breadcrumb-item"><a href="<?= admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId) ?>"><?=ucwords($chapterInfo->chapterName)?></a></li>
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
                            <form action="<?= admin_url('subject/updateChapter') ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="chapterId" id="chapterId" value="<?= $data->chapterId ?>">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Chapter Name <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="chapterName" id="chapterName" autocomplete="off" value="<?= @$data->chapterName ?>" required="" placeholder="Chapter Name">
                                    </div>
                                </div>
                              
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Chapter Number <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="chapterNumber" id="chapterNumber" autocomplete="off" value="<?= @$data->chapterNumber?>" required="" placeholder="Chapter Number">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Duration (In Hours)<span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="totalHours" id="totalHours" autocomplete="off" value="<?= @$data->totalHours?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Cost (In USD)<span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="cost" id="cost" autocomplete="off" value="<?= @$data->cost?>"  required="">
                                    </div>
                                </div>
                                   <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Summary <span class="error">*</span></label>
                                    <div class="col-sm-9">                 
                                        <textarea name="summary" class="summernote" required=""><?= @$data->summary ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Objectives <span class="error">*</span> </label>
                                    <div class="col-sm-9">
                                        <textarea name="objectives" class="summernote" required=""><?= @$data->objectives ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Image <span class="error">*</span></label>
                                   <div class="col-sm-9">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 250px; height:150px;">
                                                    <?php if (@$data->chapterImage && file_exists('./uploads/chapter/'.@$data->chapterImage)) { ?>
                                                        <img src="<?= base_url('uploads/chapter/'.@$data->chapterImage) ?>" alt="">
                                                    <?php } else { ?>
                                                        <img src="<?= base_url('uploads/noimg.png') ?>" alt="">
                                                    <?php } ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="chapterImage" accept="images/*">
                                                        <input type="hidden" name="oldImage" value="<?= @$data->chapterImage ?>">
                                                    </span>
                                                    <a href="javascript:void(0)" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>

                                            <div class="clearfix" style="display: block;">
                                                <span class="label label-danger">Format</span>&nbsp;jpg, jpeg, png, gif
                                                <span class="label label-danger">Max Upload Size</span>&nbsp;10mb
                                            </div>
                                        </div>
                                </div>


                                <div class="form-group offset-3">             

                                    <button type="submit" class="btn btn-rounded btn-info">Save</button>
                                    <a class="btn btn-rounded btn-secondary" href="<?= admin_url('subject/view/'.$subjectId) ?>">
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
