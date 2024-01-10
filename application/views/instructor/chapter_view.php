<?php
  if (@$data->chapterImage && file_exists('./uploads/chapter/'.@$data->chapterImage)) {
     $currentChapterPic = base_url('./uploads/chapter/'.@$data->chapterImage);
  }else{
     $currentChapterPic = base_url('uploads/noimg.png');
  }

  $oldChapterPic = $data->chapterImage;
?>

<div class="dashboard-content">
  <div class="container">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url('instructor/chapters/'.$subjectId)?>">Chapters</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$data->chapterName?></li>
        </ol>
     </nav> 
    <div class="row">
        <div class="col-lg-6">
            <div class="dashboard-content-box">

                <h4 class="dashboard-content-box__title">Chapter Description</h4>

                <div class="row gy-4">
                    <div class="col-md-12">
                      <label class="form-label-02">Chapter Name</label>
                      <input type="text" name="chapterName" id="chapterName" value="<?=$data->chapterName?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-12">
                      <label class="form-label-02">Chapter Duration (In Hours)</label>
                      <input type="number" name="totalHours" id="totalHours" value="<?=$data->totalHours?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-12">
                      <label class="form-label-02">Chapter Cost (In USD)</label>
                      <input type="number" name="cost" id="cost" value="<?=$data->cost?>" class="form-control" readonly>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-lg-6">
            <div class="dashboard-content-box">

                <h4 class="dashboard-content-box__title">Chapter Thumbnail</h4>
                <p>Current Chapter Thumbnail.</p>

                <div id="dashboard-profile-cover-photo-editor" class="dashboard-settings-profile" style="height:250px;">
                        <input id="dashboard-photo-dialogue-box" class="dashboard-settings-profile__input test" type="file" name="image" accept=".png,.jpg,.jpeg" readonly />
                        <div id="dashboard-cover-area" class="dashboard-settings-profile__cover" data-fallback="<?=$currentChapterPic?>" style="background-image:url(<?=$currentChapterPic?>)">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-3">
           <div class="dashboard-content-box">
                <div class="row gy-4">
                   <div class="col-md-12">
                    <div class="dashboard-content__input">
                        <label class="form-label-02">Chapter Summary</label>
                        <textarea class="form-control tinymceReadonly" name="summary" required><?=$data->summary?></textarea>
                    </div>
                </div>
              </div>             
           </div>
        </div>

        <div class="col-lg-12 mt-3">
           <div class="dashboard-content-box">
                <div class="row gy-4">
                   <div class="col-md-12">
                    <div class="dashboard-content__input">
                        <label class="form-label-02">Chapter Objective</label>
                        <textarea class="form-control tinymceReadonly" name="objectives" required><?=$data->objectives?></textarea>
                    </div>
                </div>
              </div>             
           </div>
            <div class="dashboard-settings__btn">
                <a href="<?=base_url('instructor/chapters/'.$subjectId)?>">
                    <button type="button" class="btn btn-danger btn-hover-danger">Cancel</button>
                </a>    
            </div>  
        </div>      
    </div>
  </div>
</div>    

