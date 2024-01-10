<div class="dashboard-content">
    <div class="container">
        <!--<h4 class="dashboard-title"></h4>-->
        <div class="card">
            <div class="card-body">
                 <div class="d-flex flex-wrap row">
                     <div class="col-lg-9 col-md-9 col-sm-9 d-flex flex-wrap">
                         <h4 class="dashboard-title"><?=$title?></h4>
                     </div> 
                     <div class="col-lg-3 col-md-3 col-sm-3 d-flex flex-wrap" style="padding-left: 66px;">
                         <a href="<?= base_url('instructor/chapter/add/'.$subjectId) ?>" class="btn btn-rounded btn-info"><span> <i class="fa fa-plus color-info"></i>
                         </span> Add Chapter </a>   
                     </div>                     
                        
                 </div>

                  <table class="table table-bordered table-responsive-md coursetable">
                    <thead class="text-center">
                        <tr>
                            <th>Image</th>  
                            <th>Chapter Name</th>
                            <th>Chapter Duration</th>
                            <th>Chapter Cost</th>
                            <th>Created On</th>
                            <th>Approve Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                          if(count($list)>0){
                             foreach (@$list as $key => $v){
                        ?>
                            <tr>    
                                <td class="courseBnr">
                                    <a href="<?= admin_url('instructor/chapter/view/'.$v->chapterId) ?>">
                                        <?php if (@$v->chapterImage && file_exists('./uploads/chapter/'.@$v->chapterImage)) { ?>
                                            <img src="<?= base_url('uploads/chapter/'.@$v->chapterImage) ?>" alt="img">
                                        <?php } else { ?>
                                            <img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
                                        <?php } ?>
                                    </a>
                                </td>                                       
                                <td><?= $v->chapterName ?></td>
                                <td><?= $v->totalHours.' Hours' ?></td>     
                                <td><?= '$ '.$v->cost ?></td>       
                                                                            
                                <td class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></td>

                                <td class="fs-13">
                                    <?php if($v->approve_status == "approved"){ ?>
                                        <div class="dashboard-table__text completed" data-dtype="hide">Approved</div>
                                    <?php }else{ ?> 
                                        <div class="dashboard-table__text cancelled" data-dtype="hide">Not Approved</div>  
                                    <?php } ?>      
                                </td>   

                                <td style="width:15%;">
                                    <div class="dropdown">
                                       <a class="dropdown-toggle dropdown-active dtp-8" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                         <span class="text">Action</span>
                                       </a>

                                       <ul class="dropdown-menu p-1 dm-item" aria-labelledby="dropdownMenuLink">
                                         <li>
                                            <a class="dropdown-item" href="<?= base_url('instructor/chapter/view/'.$v->subjectId.'/'.$v->chapterId) ?>"><i class="fa fa-eye"></i>&nbsp;View Chapter</a>
                                         </li>
                                         
                                         <?php if($v->approve_status == "forbidden"){ ?>
                                             <li>
                                                <a class="dropdown-item" href="<?= base_url('instructor/chapter/edit/'.$v->subjectId.'/'.$v->chapterId) ?>"><i class="fa fa-edit"></i>&nbsp;Edit Chapter</a>
                                             </li>

                                             <li>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="deleteChapter(<?=$v->subjectId?>,<?=@$v->chapterId?>)">
                                                    <i class="fa fa-trash"></i>&nbsp;Delete Chapter
                                                </a>
                                             </li>
                                          <?php } ?>
                                          <li>
                                            <a class="dropdown-item" href="<?= base_url('instructor/chapter-curriculum/'.$subjectId.'/'.$v->chapterId) ?>">
                                                <i class="fa fa-list"></i>&nbsp;Chapter Curriculum
                                            </a>
                                          </li>     
                                       </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } }else{ ?>
                            <tr>
                              <td colspan="6">No chapter is created by you!</td>
                           </tr> 
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteChapter(subjectId,chapterId) {
        swal({
            title: 'Are You sure want to delete this Chapter?',
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
                window.location.href = '<?= base_url('instructor/deleteChapter/') ?>'+subjectId+'/'+chapterId
            }
        });
    }
</script>