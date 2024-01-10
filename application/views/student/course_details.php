<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url('student/enrolledcourselist')?>"><?=$courseDetail->courseName?></a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0);">Chapters</a></li>
        <!--<li class="breadcrumb-item active" aria-current="page">Subjects</li>-->
      </ol>
    </nav>
    <!--<h4 class="dashboard-title">Enrolled Courses</h4>-->
    <div class="dashboard-course">

        <div class="dashboard-course-list">

            <?php
               if(count($courseSubjectList)>0){ 
                  foreach($courseSubjectList as $index=>$subject){ 
                     
                     $subjectId = $subject->subjectId;

                     $sql_subject_details = "SELECT c.courseId,c.courseName,cl.level as courseLvl,s.subjectId,s.subjectName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as subjectCost FROM courses c LEFT JOIN course_level_details cl ON ( c.courseId=cl.courseId AND cl.level = '$courseLvl' ) LEFT JOIN course_chapters cc ON ( c.courseId=cc.courseId  AND cc.level = '$courseLvl' ) LEFT JOIN chapters chp ON ( cc.chapterId=chp.chapterId AND cc.subjectId='$subjectId' ) LEFT JOIN subjects s ON ( s.subjectId=chp.subjectId AND s.subjectId='$subjectId' ) WHERE cc.courseId = '".$courseId."' AND cc.level = '".$courseLvl."' AND cc.subjectId = '".$subjectId."'"; 

                        //echo $sql_enrolled_courses;exit;

                        //Feching Enrolled Course List 
                        $subjectData = $this->mymodel->fetch($sql_subject_details, true);

               ?>  
                <div class="dashboard-course-item">
                    <a class="dashboard-course-item__link" href="#">
                        <div class="dashboard-course-item__thumbnail">
                            <img src="<?=base_url('uploads/subject/'.$subject->image)?>" alt="Courses" width="260" height="160">
                        </div>
                        <div class="dashboard-course-item__content">
                           
                            <h3 class="dashboard-course-item__title"><?=$subject->subjectName?></h3>
                            <div class="dashboard-course-item__meta">
                                <ul class="dashboard-course-item__meta-list">
                                    <li>
                                        <span class="meta-label">Total Duration:</span>
                                        <span class="meta-value"><?=$subjectData->totalHours?> Hours</span>
                                    </li>
                                    <li>
                                        <span class="meta-label">Chapters:</span>
                                        <span class="meta-value"><?=$subjectData->totalChapter?> Chapters</span>
                                    </li>
                                    <!--<li>
                                        <span class="meta-label">Cost:</span>
                                        <span class="meta-value">$<?=$subjectData->subjectCost?></span>
                                    </li>-->
                                </ul>
                            </div>
                            <div class="dashboard-course-item__progress-bar-wrap">
                                <div class="course_detail" id="chapter_list" data-cid="<?=$subjectData->courseId?>" data-lvl="<?=$subjectData->courseLvl?>" data-sid="<?=$subject->subjectId?>">Chapter List</div>
                               
                                <div class="course_detail" id="subject_detail" style="margin-left:5px;" data-cid="<?=$subjectData->courseId?>" data-lvl="<?=$subjectData->courseLvl?>" data-sid="<?=$subject->subjectId?>" data-bs-toggle="tooltip" data-bs-placement="top" title="View this subject details for this course" data-bs-custom-class="color-tooltip">Subject Details</div>
                                
                            </div>
                        </div>
                    </a>
                </div>

             <?php } }else{?>
                <span class="text-left"><h4>You haven't <?=($course_type == "active"?"purchased":"completed")?> any course yet.</h4></span>
             <?php } ?>  
        </div>
    </div>
</div>


<div class="modal fade subjectmodal" id="showSubjectDetailModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subject Details</h5>
        <button type="button" class="modalclose" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body" id="chapterList">
       
        <div class="subjectDetail" id="subjectDetail">
            <h4 class="h6">Name of the Subject</h4>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. ... <a href="#" class="text-primary">Read more</a></p>
        </div>

      </div>
    </div>
  </div>
</div> 


    <script>
        
        function showSubjectDetail(subjectId){
           /*var subejctName = $("#subejctName_"+subjectId).val(); 
           var subejctDetail = $("#subejctDetail_"+subjectId).val();

           $("#subejctName").val(subejctName);
           $("#subejctDetail").val(subejctDetail);*/

            //Throwing ajax request in server 
             $.ajax({
              url:baseUrl+'student/getSubjectSummary/'+subjectId,
              method:'POST',
              dataType:"html",
              success:function(responseData){
                  var data = JSON.parse(responseData);
                  if(data.check == 'success'){
                     $('#subjectDetail').html(data.html);
                     $("#showSubjectDetailModal").modal('show');
                  }else{
                     alert_func(["Something went wrong, Please try again.", "error", "#DD6B55"]);
                     $("#showSubjectDetailModal").modal('hide');
                  }
              }
            });     
        } 

    </script> 