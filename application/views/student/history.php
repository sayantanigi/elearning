    <div class="dashboard-content">

        <div class="container">
            <h4 class="dashboard-title">Purchase History</h4>
            <div class="dashboard-purchase-history">
                <div class="dashboard-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="id">ID</th>
                                <th class="courses">Course Name</th>
                                <th class="courses">Level</th>
                                <th class="amount">Amount</th>
                                <th class="status">Status</th>
                                <th class="date">Date</th>
                            </tr>
                        </thead>
                        <tbody>

                              <?php 
                                 $userId = $this->session->userdata('userId'); 
                                 
                                 if(!empty($courseData)){
                                     foreach ($courseData as $key => $course) { 
                                        if ($course->level_image && file_exists('./uploads/level/'.$course->level_image)) {
                                           $course_thumbnail = base_url('uploads/level/'.$course->level_image);
                                        }else{
                                           $course_thumbnail = base_url('uploads/courses/'.$course->course_image);
                                        }

                                        $sql_instructor_detail = "SELECT sbc.instructorId FROM student_booked_classes sbc WHERE sbc.courseId='".$course->courseId."' AND sbc.courseLvl='".$course->courseLvl."' AND sbc.studentId='".$userId."' ORDER BY sbc.classId DESC LIMIT 1";

                                        //echo $sql_instructor_detail;exit;

                                        $instructorData = $this->mymodel->fetch($sql_instructor_detail, true);
                              ?> 
                           
                            <tr>
                                <td>
                                    <div class="dashboard-table__text">#108<?=$course->courseId?></div>
                                </td>
                                <td class="course-info">
                                    <div class="dashboard-table__text">
                                        <p><?=$course->courseName?></p>
                                    </div>
                                </td>
                                 <td class="id">
                                    <div class="dashboard-table__text">
                                        <p><?=ucfirst($course->courseLvl)?></p>
                                    </div>
                                </td>
                                <td class="correct">
                                    <div class="dashboard-table__text">
                                        <span class="sale-price">$<?=$course->lvlCost?></span>
                                    </div>
                                </td>
                                <td class="incorrect">
                                    <?php if(!empty($instructorData->instructorId) && $instructorData->instructorId != null){ ?>
                                        <div class="dashboard-table__text completed">Running</div>
                                    <?php }else{ ?>    
                                        <div class="dashboard-table__text cancelled">Enrolled</div>
                                    <?php } ?>     
                                </td>
                                <td class="earned">
                                    <div class="dashboard-table__text"><?=date('Y-m-d',strtotime($course->created))?></div>
                                </td>
                            </tr>
                         <?php } }?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>