<div class="container"> 
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Library</li>
      </ol>
    </nav>
    <div class="row mt-3">
        <input type="hidden" id="courseId" value="<?=$courseDetail->courseId?>">
        <input type="hidden" id="courseLvl" value="<?=$courseLvl?>">

         <?php foreach($courseSubjectList as $index=>$subject){ ?>  
                                                     
         <div class="col-xl-4 col-lg-4 col-sm-6">
            <a href="<?=base_url('student/subject/'.$courseId.'/'.$courseLvl.'/'.$subject->subjectId)?>" class="d-block showLevelChaptersOff" data-sid="<?=$subject->subjectId?>">
                <div class="courseBox">
                    <div class="couserIcon text-center">
                        <img src="<?=base_url('uploads/subject/'.$subject->image)?>">
                    </div>
                    <h3><?=$subject->subjectName?></h3>
                </div>
            </a>
          </div>

        <?php } ?>  
    </div>  
</div>     

 <div class="modal fade subjectmodal" id="chaptereModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Chapters</h5>
        <button type="button" class="modalclose" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body" id="chapterList">
       
        <div class="courserlistBlock">
            <h4 class="h6">Name of the Chapter</h4>
            <p class="mb-2"><small><span class="fw-bold text-primary"><i class="far fa-clock"></i> Duration:</span> 90 Min</small></p>
            <p class="fw-bold mb-1">About the Chapter</p>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. ... <a href="#" class="text-primary">Read more</a></p>
        </div>

      </div>
    </div>
  </div>
</div> 