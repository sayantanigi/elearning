	<div class="content-body">
		<div class="container-fluid">
			<div class="page-titles">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?= admin_url('dashboard')?>">Home</a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
				</ol>
			</div>
			<div class="d-flex flex-wrap mb-4 row">
				<div class="col-xl-6 col-lg-6 mb-2 titleListing">
					<span class="ttiletop">
						<h6 class="text-black fs-20 font-w600 mb-1">Reasons</h6>
					</span>
					
				</div>
				<div class="col-xl-6 col-lg-6 mb-2 text-right">
					<ul class="memstuList">
						<li><a class="active" href="<?= base_url('admin/instructors/add-reason');?>">Add New Reason</a></li>
					</ul>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12">
					<div id="tab-1" class="tab-view active">
						<!-- <div class="card-header">
							<h4 class="card-title"><?= $title ?></h4>
						</div> -->
						<div class="memberlistTable">
							<div class="table-responsive">
								<table id="example" class="display table-responsive-md table"> 
									<thead>
										<tr>
											<th>#</th>
											<th>Reason</th>
											<th>Create Date</th>
											<th>Update</th>
											<th>status</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=1;
										  if(!empty($reasonList)){
										    foreach ($reasonList as $reason){	
										?>
												<tr>
													<td><?= $i++;?></td>
													<td><?= $reason->reason;?></td>
													<td>
														<?php 
															if(!empty($reason->created)){ 
													              echo date('d-M-Y h:i:s A',strtotime($reason->created));
															}
														?>
													</td>
													<td>
														<?php 
															if(!empty($reason->updated)){ 
													              echo date('d-M-Y h:i:s A',strtotime($reason->updated));
															}
														?>
													</td>
													<td>
														<?php
															if($reason->status==1){
																 echo btn_publish('admin/instructors/reason/unpublish/'. $reason->reasonId);
															}else{
																 echo btn_unpublish('admin/instructors/reason/publish/'. $reason->reasonId);
															}
														?>
													</td>
													<td class="text-center actionbtnlist">
														<a href="<?= admin_url('instructors/edit-reason/'.$reason->reasonId);?>" class="btn btn-xs btn-secondary" data-toggle="tooltip2" title="Edit">
															<i class="fa fa-edit"></i>
														</a>
														
														<a href="javascript:void(0)" onclick="deleteSubject(<?= @$reason->reasonId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
														<i class="fa fa-trash"></i>
													</a>
													</td>
												</tr>
										<?php
													}
										  	}
										?>
											
											
									</tbody>
								</table>
							</div>
						</div>
					</div>
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
					window.location.href = '<?= admin_url('faq/delete/') ?>'+subjectId
				}
			});
		}

	</script>