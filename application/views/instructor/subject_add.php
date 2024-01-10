<div class="dashboard-content">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url('instructor/subjects')?>">Subjects</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create Subject</li>
        </ol>
      </nav>    

      <form action="<?= base_url('instructor/subject/create') ?>" class="needs-validation" method="post" enctype="multipart/form-data">
        <div class="row ">
            <div class="col-lg-6">
                <div class="dashboard-content-box">

                    <h4 class="dashboard-content-box__title">Subject Description</h4>

                    <div class="row gy-4">
                        <div class="col-md-12">
                          <label class="form-label-02">Subject Name<span style="color:red;"> *</span></label>
                          <input type="text" name="subjectName" id="subjectName" value="" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <div class="dashboard-content__input">
                              <label class="form-label-02">Summary<span style="color:red;"> *</span></label>
                              <textarea class="form-control tinymce" name="summary" required></textarea>
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
                        <input id="dashboard-photo-dialogue-box" class="dashboard-settings-profile__input test" type="file" name="image" accept=".png,.jpg,.jpeg" required />
                        <div id="dashboard-cover-area" class="dashboard-settings-profile__cover" data-fallback="<?= base_url('uploads/noimg.png') ?>" style="background-image:url(<?= base_url('uploads/noimg.png') ?>)">
                           
                            <div class="overlay">
                                <button class="cover-uploader" type="button">
                                    <i class="far fa-camera"></i>&nbsp;
                                    <span>Select Subject Thumbnail</span>
                                </button>
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
                            <label class="form-label-02">Subject Objective<span style="color:red;"> *</span></label>
                            <textarea class="form-control tinymce" name="objectives" required></textarea>
                        </div>
                    </div>
                  </div>             
               </div>
                <div class="dashboard-settings__btn">
                    <button type="submit" class="btn btn-primary btn-hover-secondary">Create Subject</button>
                    <a href="<?=base_url('instructor/subjects')?>">
                        <button type="button" class="btn btn-danger btn-hover-danger">Cancel</button>
                    </a>    
                </div>     
            </div>
        </div>
      </form>
    </div>
  </div>      
  
 
  
