    <div class="dashboard-content">
        <div class="container">
            <h4 class="dashboard-title">Dashboard</h4>
            <div class="dashboard-info">
                <div class="row gy-2 gy-sm-6">
                    <div class="col-md-4 col-sm-6">
                        <div class="dashboard-info__card">
                            <a class="dashboard-info__card-box" href="javascript:void(0);" onclick="redirectToCoursePage('enrolled')">
                                <div class="dashboard-info__card-icon icon-color-01">
                                    <i class="edumi edumi-open-book"></i>
                                </div>
                                <div class="dashboard-info__card-content">
                                    <div class="dashboard-info__card-value"><?=$courseData->enrolledCourseCount?></div>
                                    <div class="dashboard-info__card-heading" onclick="redirectToCoursePage('enrolled')">Enrolled Courses</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="dashboard-info__card">
                            <a class="dashboard-info__card-box" href="javascript:void(0);" onclick="redirectToCoursePage('running')">
                                <div class="dashboard-info__card-icon icon-color-02">
                                    <i class="edumi edumi-streaming"></i>
                                </div>
                                <div class="dashboard-info__card-content">
                                    <div class="dashboard-info__card-value"><?=$runningCourseData?></div>
                                    <div class="dashboard-info__card-heading" onclick="redirectToCoursePage('running')">Running Courses</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="dashboard-info__card">
                            <a class="dashboard-info__card-box" href="javascript:void(0);" onclick="redirectToCoursePage('completed')">
                                <div class="dashboard-info__card-icon icon-color-03">
                                    <i class="edumi edumi-correct"></i>
                                </div>
                                <div class="dashboard-info__card-content">
                                    <div class="dashboard-info__card-value"><?=$completedCourseData?></div>
                                    <div class="dashboard-info__card-heading" onclick="redirectToCoursePage('completed')">Completed Courses</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function redirectToCoursePage(type){
        if(type == 'enrolled'){
           window.location = baseUrl+'student/enrolledcourselist';
        }
        else if(type == 'running'){
           window.location = baseUrl+'student/runningcourselist';
        }else{
           window.location = baseUrl+'student/copmpletedcourselist';
        }
    }
</script>    