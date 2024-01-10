<?php
   /*print"<pre>";
   print_r($chapterList);
   print"</pre>";exit;*/
?>
<div class="dashboard-content">
    <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('student/enrolledcourselist')?>"><?=$courseDetail->courseName?></a></li>
            <li class="breadcrumb-item"><a href="<?=base_url('student/subjects/'.$courseId.'/'.$courseLvl)?>"><?=$subjectDetail->subjectName?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Chapters</li>
          </ol>
        </nav>
        <div class="dashboard-course">

            <div class="dashboard-course-list">

                <?php
                   if(count($chapterList)>0){ 
                      foreach($chapterList as $index=>$chapter){ 
                        $chapterId = $chapter->chapterId;
                ?>       

                  <div class="dashboard-course-item">
                    <a class="dashboard-course-item__link" href="#">
                        <div class="dashboard-course-item__thumbnail">
                            <img src="<?=base_url('uploads/chapter/'.$chapter->chapterImage)?>" alt="Courses" width="260" height="160">
                        </div>
                        <div class="dashboard-course-item__content">
                           
                            <h3 class="dashboard-course-item__title"><?=$chapter->chapterName?></h3>
                            <div class="dashboard-course-item__meta">
                                <ul class="dashboard-course-item__meta-list">
                                    <li>
                                        <span class="meta-label">Total Duration:</span>
                                        <span class="meta-value"><?=$chapter->totalHours?> Hours</span>
                                    </li>
                                    <!--<li>
                                        <span class="meta-label">Cost:</span>
                                        <span class="meta-value">$<?=$subjectData->subjectCost?></span>
                                    </li>-->
                                </ul>
                            </div>
                            <div class="dashboard-course-item__progress-bar-wrap">
                                <div class="course_detail" id="chapter_curriculum" data-cid="<?=$courseId?>" data-lvl="<?=$courseLvl?>" data-sid="<?=$subjectId?>" data-chpid="<?=$chapter->chapterId?>">Chapter Curriculum</div>
                            </div>
                        </div>
                    </a>
                </div>

              <?php } }else{?>
                  <span class="text-left"><h4>No chapter is available under this subject cuurently, Please check back later.</h4></span>
              <?php } ?>  
            </div>
        </div>
    </div>
</div>


