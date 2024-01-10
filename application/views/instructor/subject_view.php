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
  
      <div class="row">
        <div class="col-lg-6">
            <div class="dashboard-content-box">
                <h4 class="dashboard-content-box__title">Subject Description</h4>

                <div class="row gy-4">
                    <div class="col-md-12">
                      <label class="form-label-02">Subject Name</label>
                      <input type="text" name="subjectName" id="subjectName" value="<?=$data->subjectName?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-12">
                        <div class="dashboard-content__input">
                          <label class="form-label-02">Summary</label>
                          <textarea class="form-control tinymceReadonly" name="summary" readonly><?=$data->summary?></textarea>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="dashboard-content-box">

                <h4 class="dashboard-content-box__title">Subject Thumbnail</h4>
                <p>Current Subject Thumbnail.</p>

                <div id="dashboard-profile-cover-photo-editor" class="dashboard-settings-profile">
                    <input id="dashboard-photo-dialogue-box" class="dashboard-settings-profile__input test" type="file" name="image" accept=".png,.jpg,.jpeg" readonly />
                    <div id="dashboard-cover-area" class="dashboard-settings-profile__cover" data-fallback="<?=$currentSubjectPic?>" style="background-image:url(<?=$currentSubjectPic?>)">
                       
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-3">
           <div class="dashboard-content-box">
                <div class="row gy-4">
                   <div class="col-md-12">
                    <div class="dashboard-content__input">
                        <label class="form-label-02">Subject Objective</label>
                        <textarea class="form-control tinymceReadonly" name="objectives" readonly><?=$data->objectives?></textarea>
                    </div>
                </div>
              </div>             
           </div>
           <div class="dashboard-settings__btn">
              <a href="<?=base_url('instructor/subjects')?>">
                <button type="button" class="btn btn-danger btn-hover-danger">Cancel</button>
              </a>
           </div>    
        </div>
    </div>
  </div>
</div>    

   
