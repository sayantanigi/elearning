<?php
   /*print"<pre>";
   print_r($subjectDetail);
   print"</pre>";exit;*/
?>

<div class="dashboard-content">
    <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('student/enrolledcourselist')?>"><?=$courseDetail->courseName?></a></li>
            <li class="breadcrumb-item"><a href="<?=base_url('student/subjects/'.$courseId.'/'.$courseLvl)?>"><?=$subjectDetail->subjectName?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Subject Details</li>
          </ol>
        </nav>
        
         <div class="card curriculum-row" id="uploaded_curriculum_media">
           <div class="card-header">
               <h4 class="card-title">Subject Summary</h4>
           </div>
           <div class="card-body">
             <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                   <img src="<?=base_url('uploads/subject/'.$subjectDetail->image)?>" alt="<?=$subjectDetail->subjectName?>">
                </div>  
                <div class="col-lg-9 col-md-9 col-sm-9">
                  <?=strip_tags(htmlspecialchars_decode($subjectDetail->summary))?>
                </div>  
              </div>  
           </div>
         </div>  

         <div class="card curriculum-row mt-5" id="uploaded_curriculum_media">
           <div class="card-header">
               <h4 class="card-title">Subject Objectives</h4>
           </div>
           <div class="card-body">
               <?=strip_tags(htmlspecialchars_decode($subjectDetail->summary))?>
           </div>
         </div>  
    </div>
</div>         