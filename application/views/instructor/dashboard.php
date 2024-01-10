<div class="dashboard-content">
    <div class="container">
        <h4 class="dashboard-title">Dashboard</h4>
        <div class="dashboard-info">
            <div class="row gy-2 gy-sm-6">
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-info__card">
                        <a class="dashboard-info__card-box" href="#">
                            <div class="dashboard-info__card-icon icon-color-01">
                                <i class="edumi edumi-open-book"></i>
                            </div>
                            <div class="dashboard-info__card-content">
                                <div class="dashboard-info__card-value"><?=(!empty($courseList)?count($courseList):0)?></div>
                                <div class="dashboard-info__card-heading" onclick="redirectToCoursePage()">Total Courses</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-info__card">
                        <a class="dashboard-info__card-box" href="#">
                            <div class="dashboard-info__card-icon icon-color-02">
                                <i class="edumi edumi-streaming"></i>
                            </div>
                            <div class="dashboard-info__card-content">
                                <div class="dashboard-info__card-value"><?=(!empty($runningCourseData)?count($runningCourseData):0)?></div>
                                <div class="dashboard-info__card-heading" onclick="redirectToCoursePage()">Running Courses</div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!--<div class="col-md-4 col-sm-6">
                    <div class="dashboard-info__card">
                        <a class="dashboard-info__card-box" href="#">
                            <div class="dashboard-info__card-icon icon-color-03">
                                <i class="edumi edumi-correct"></i>
                            </div>
                            <div class="dashboard-info__card-content">
                                <div class="dashboard-info__card-value">27</div>
                                <div class="dashboard-info__card-heading">Completed Courses</div>
                            </div>
                        </a>
                    </div>
                </div>-->

                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-info__card">
                        <div class="dashboard-info__card-box">
                            <div class="dashboard-info__card-icon icon-color-04">
                                <i class="edumi edumi-group"></i>
                            </div>
                            <div class="dashboard-info__card-content">
                                <div class="dashboard-info__card-value"><?=(!empty($totalStudentData)?$totalStudentData->studentCount:0)?></div>
                                <div class="dashboard-info__card-heading" onclick="redirectToStudentPage()">Total Students</div>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- <div class="col-md-4 col-sm-6">
                    <div class="dashboard-info__card">
                        <div class="dashboard-info__card-box">
                            <div class="dashboard-info__card-icon icon-color-05">
                                <i class="edumi edumi-user-support"></i>
                            </div>
                            <div class="dashboard-info__card-content">
                                <div class="dashboard-info__card-value">1</div>
                                <div class="dashboard-info__card-heading">Total Courses</div>
                            </div>
                        </div>
                    </div>
                </div>-->


                <!--<div class="col-md-4 col-sm-6">
                    <div class="dashboard-info__card">
                        <div class="dashboard-info__card-box">
                            <div class="dashboard-info__card-icon icon-color-06">
                                <i class="edumi edumi-coin"></i>
                            </div>
                            <div class="dashboard-info__card-content">
                                <div class="dashboard-info__card-value"><span class="sale-price">$383</span></div>
                                <div class="dashboard-info__card-heading">Total Earnings</div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>

            <!--Social Box-->
            <div class="row pl-0 pt-3">
               <div class="col-lg-12 col-md-12 col-sm-12">
                 <span class="shareit">Share:</span>
                  <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?=base_url('student/dashboard?show_ins_profile=1&ins_id='.$userId)?>" data-a2a-title="My Profile Page:">
                    <a class="a2a_button_facebook"></a>
                    <a class="a2a_button_twitter"></a>
                    <a class="a2a_button_email"></a>
                    <a class="a2a_button_linkedin"></a>
                    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                  </div>
               </div>
            </div>

        </div>
    </div>
</div>

<script>
    function redirectToCoursePage(){
        window.location = baseUrl+'instructor/courses';
    }

    function redirectToStudentPage(){
        window.location = baseUrl+'instructor/studentlist';
    }
</script>    