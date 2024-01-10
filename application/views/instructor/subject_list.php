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
						 <a href="<?= base_url('instructor/subject/add') ?>" class="btn btn-rounded btn-info"><span> <i class="fa fa-plus color-info"></i>
						 </span> Add Subject </a>	
					 </div>						
						
				 </div>

	       <table class="table table-bordered table-responsive-md coursetable">
						<thead class="text-center">
							<tr>
								<th>#</th>
								<th>Image</th>	
								<th>Subject Name </th>
								<th>Chapters</th>
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
								<td><?=$key+1?></td>
								<td class="courseBnr">
									<a href="<?= admin_url('subject/view/'.$v->subjectId) ?>">
										<?php if (@$v->image && file_exists('./uploads/subject/'.@$v->image)) { ?>
											<img src="<?= base_url('uploads/subject/'.@$v->image) ?>" alt="img">
										<?php } else { ?>
											<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
										<?php } ?>
									</a>
								</td>										
								<td >
									<!--<p>
										<?= substr(strip_tags(html_entity_decode($v->summary)), 0,30)."<a href='".base_url('instructor/subject/view/'.$v->subjectId)."' style='color:blue;'>...Read more</a>"; ?> 
								    </p>-->
									<?php $chapterList = $this->mymodel->get('chapters', false, 'subjectId', $v->subjectId);

										$testList = $this->mymodel->get('tests', false, 'subjectId', $v->subjectId);

										$sqllession = "SELECT * FROM `subjects` JOIN chapters ON chapters.subjectId =subjects.subjectId  JOIN lessons ON lessons.chapterId=chapters.chapterId WHERE subjects.subjectId=$v->subjectId";

									 	$lessonlist= $this->mymodel->fetch($sqllession);
									 ?>
									<?= @$v->subjectName?>
								</td>

								<td>
									<?=count($chapterList)." Chapter".(count($chapterList)>1?"s":"")?>
								</td>
																			
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
				                         	  <a class="dropdown-item" href="<?= base_url('instructor/subject/view/'.$v->subjectId) ?>"><i class="fa fa-eye"></i>&nbsp;View Subject</a>
				                         </li>
				                         
				                         <?php if($v->approve_status == "forbidden"){ ?>
					                         <li>
					                            <a class="dropdown-item" href="<?=base_url('instructor/subject/edit/'.$v->subjectId)?>"><i class="fa fa-edit"></i>&nbsp;Edit Subject</a>
					                         </li>

					                         <li>
					                            <a class="dropdown-item" href="javascript:void(0);" onclick="deleteSubject(<?=@$v->subjectId?>)">
					                            	<i class="fa fa-trash"></i>&nbsp;Delete Subject
					                            </a>
					                         </li>
					                      <?php } ?>
					                      <li>
					                      	<a class="dropdown-item" href="<?=base_url('instructor/chapters/'.$v->subjectId)?>">
					                            <i class="fa fa-list"></i>&nbsp;Manage Chapters
					                        </a>
					                      </li>     
				                       </ul>
				                    </div>
								</td>
							  </tr>
							<?php } }else{ ?>
				              <tr>
				                  <td colspan="5">No subject is created by you!</td>
				              </tr> 
				            <?php } ?>
						</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	function deleteSubject(subjectId) {
		swal({
			title: 'Are You sure want to delete this Subject?',
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
				window.location.href = '<?= base_url('instructor/deleteSubject/') ?>'+subjectId
			}
		});
	}
</script>