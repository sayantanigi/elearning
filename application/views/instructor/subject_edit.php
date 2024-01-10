<?php
  if (@$data->image && file_exists('./uploads/subject/'.@$data->image)) {
     $currentSubjectPic = base_url('./uploads/subject/'.@$data->image);
  }else{
     $currentSubjectPic = base_url('uploads/noimg.png');
  }

  $oldSubjectPic = $data->image;
?>

<div class="dashboard-content">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url('instructor/subjects')?>">Subjects</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$data->subjectName?></li>
        </ol>
      </nav>
       <form action="<?= base_url('instructor/subject/update') ?>" class="needs-validation" method="post" enctype="multipart/form-data">
         <div class="row">
            <div class="col-lg-6">
                <div class="dashboard-content-box">

                    <h4 class="dashboard-content-box__title">Subject Description</h4>

                    <div class="row gy-4">
                        <div class="col-md-12">
                          <label class="form-label-02">Subject Name<span style="color:red;"> *</span></label>
                          <input type="text" name="subjectName" id="subjectName" value="<?=$data->subjectName?>" class="form-control" required>
                          <input type="hidden" name="subjectId" value="<?=$subjectId?>">
                        </div>

                        <div class="col-md-12">
                            <div class="dashboard-content__input">
                              <label class="form-label-02">Summary<span style="color:red;"> *</span></label>
                              <textarea class="form-control tinymce" name="summary" required><?=$data->summary?></textarea>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="dashboard-content-box">

                    <h4 class="dashboard-content-box__title">Subject Thumbnail<span style="color:red;"> *</span></h4>
                    <p>Upload Subject Thumbnail.</p>

                    <div id="dashboard-profile-cover-photo-editor" class="dashboard-settings-profile">
                        <input id="dashboard-photo-dialogue-box" class="dashboard-settings-profile__input test" type="file" name="image" accept=".png,.jpg,.jpeg" <?=(!empty($oldSubjectPic)?'':'required')?> />
                        <div id="dashboard-cover-area" class="dashboard-settings-profile__cover" data-fallback="<?=$currentSubjectPic?>" style="background-image:url(<?=$currentSubjectPic?>)">
                           
                            <div class="overlay">
                                <button class="cover-uploader" type="button">
                                    <i class="far fa-camera"></i>&nbsp;
                                    <span>Select New Subject Thumbnail</span>
                                </button>
                            </div>
                            <input type="hidden" name="oldSubjectPic" value="<?=(!empty($oldSubjectPic)?$oldSubjectPic:null)?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
               <div class="dashboard-content-box">
                    <div class="row gy-4">
                       <div class="col-md-12">
                        <div class="dashboard-content__input">
                            <label class="form-label-02">Subject Objective<span style="color:red;"> *</span></label>
                            <textarea class="form-control tinymce" name="objectives" required><?=$data->objectives?></textarea>
                        </div>
                    </div>
                  </div>             
               </div>
                <div class="dashboard-settings__btn">
                    <button type="submit" class="btn btn-primary btn-hover-secondary">Update Subject</button>
                    <a href="<?=base_url('instructor/subjects')?>">
                        <button type="button" class="btn btn-danger btn-hover-danger">Cancel</button>
                    </a>    
                </div>     
            </div>
         </div>
     </form>
  </div>
</div>     

