    <div class="dashboard-content">

        <div class="container">
            <h4 class="dashboard-title">Wishlist</h4>
            <div class="overlayer" style="display: none;"></div>
            <div class="dashboard-purchase-history">
                <div class="dashboard-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="id text-center">ID</th>
                                <th class="courses text-center">Course Name</th>
                                <th class="courses text-center">Level</th>
                                <th class="amount text-center">Amount</th>
                                <th class="status text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">

                              <?php 
                                 $userId = $this->session->userdata('userId'); 
                                 
                                 if(!empty($wishListData)){
                                     foreach ($wishListData as $key => $course) { 
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
                                    <div class="dashboard-table__text"><?=date('Y-m-d',strtotime($course->updated))?></div>
                                </td>
                                <td>
                                    <div class="dashboard-table__text cancelled delete-frm-wishlst" data-rid="<?=$course->wishId?>">Delete from Wishlist</div>
                                </td>
                            </tr>
                         <?php } }else{?>  
                            <tr>
                                <td colspan="8">No course has been added into wishlist! <a href="<?=base_url('courselist')?>" style="color: blue;">Visit Course Page</a> to browse our latest courses.</td>
                            </tr>
                         <?php } ?>   
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    //HANDLING CHANGE INSTRUCTOR FORM
    $(document).on('click', '.delete-frm-wishlst', function(event){
         event.preventDefault();
         var wishId = $(this).data('rid');

         swal({
             title: 'Are You sure want to delete this course from wishlist?',
             type: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#A5DC86',
             cancelButtonColor: '#DD6B55',
             confirmButtonText: 'Yes',
             cancelButtonText: 'No',
             closeOnConfirm: true,
             closeOnCancel: true
         }, function(isConfirm){

             if (isConfirm) {

                //Throwing ajax request in server 
                 $.ajax({
                   url:baseUrl+'student/deleteWishList',
                   method:'POST',
                   data: {wishId:wishId},
                   beforeSend: function() {
                     $('.overlayer').fadeIn();
                   },
                   success:function(resposeData){
                      var data = JSON.parse(resposeData);
                      $('.overlayer').fadeOut();

                      if(data.check == 'success'){
                         setTimeout(function(){
                            var redirectURL = window.location.href.split('#')[0];
                            alert_response([data.msg, "success", "#A5DC86"],redirectURL);
                        }, 100);
                      }else{
                        //$(".error_massage").removeClass("d-none");
                        setTimeout(function(){
                            alert_func([data.msg, "error", "#DD6B55"]);
                        }, 100);
                      }
                    }
                });    
             }
        });        
    });
</script>