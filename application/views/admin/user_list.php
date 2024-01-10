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
						<h6 class="text-black fs-20 font-w600 mb-1">List of Students</h6>
					</span>
				
				</div>
				<div class="col-xl-6 col-lg-6 mb-2 text-right">
					<ul class="slectview">
						<li><a href="<?= admin_url('students/export_csv');?>" class="tab-link active" data-tab="tab-1"><i class="fa fa-download" aria-hidden="true"></i> <spam>Download Excel</spam></a></li>

					
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div id="tab-1" class="tab-view active">
					
						<div class="memberlistTable">
							<div class="table-responsive">
								<table id="example" class="display table-responsive-md table"> 
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Join Date</th>
											<th>Status</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($list as $key => $v): ?>
											<tr>
												<td><?= $i ?></td>
												<td><p>
													<?php if (@$v->profilePic && file_exists('./uploads/users/'.@$v->profilePic)) { ?>
														<img src="<?= base_url('uploads/users/'.@$v->profilePic) ?>" alt="" class="listusericon">
													<?php } else { ?>
														<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""  class="listusericon">
													<?php } ?>
													<?php 
														$flname = strlen(@$v->firstName.' '.@$v->lastName);
														if($flname >= 21){
														  echo substr(@$v->firstName.' '.@$v->lastName,0,20);
														  echo '..';
														}else{
														  echo substr(@$v->firstName.' '.@$v->lastName,0,21);
														}
														

													?>
														</p>
													</td>											
													
												
												<td><?= @$v->email ?></td>
												<td><?= @$v->mobile ?></td>
												
												<td><?= date('d-M-Y', strtotime(@$v->created)) ?></td>
												<td>
													<label class="checkbox-warning check-xl">
														<input type="checkbox" value="<?= @$v->status ?>" <?= (@$v->status == 1)? 'checked="checked"' : ''; ?> onchange="changeStudentStatus(<?= @$v->userId ?>, $(this))">
														<span class="slider round"></span>
													</label>
												</td>
												<td class="text-center">
													<a href="<?= admin_url('students/view/'.$v->userId) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip2" title="Details">
														<i class="fa fa-eye"></i>
													</a>
													<a href="<?= admin_url('students/edit/'.@$v->userId) ?>" class="btn btn-xs btn-secondary" data-toggle="tooltip2" title="Edit">
														<i class="ti-pencil-alt"></i>
													</a>

													<a href="javascript:void(0)" onclick="deleteStudent(<?= @$v->userId?>)"  class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
														<i class="ti ti-trash"></i>
													</a>
												</td>
											</tr>
											<?php $i++; ?>
										<?php endforeach ?>
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
		function deleteStudent(userId) 
		{
			swal({
				title: 'Are You sure want to delete this User?',
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
					window.location.href = '<?= admin_url('students/delete/') ?>'+userId
				}
			});
		}

		//Article status change function
		function changeStudentStatus(id, thisSwitch) {      
			var newStatus;      
			if (thisSwitch.val() == 1) {         
				thisSwitch.val('0');       
				newStatus = '0';
			} else {      
				thisSwitch.val('1');       
				newStatus = '1';
			}

			//console.log(newStatus+"***id->"+id);return false;

			$.ajax({      
				url: adminUrl+'students/changestatus',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					userId: String(id),        
					status: String(newStatus)        
				},
			})
			.done(function(data) {      
				alert_func(data);       
			})
			.fail(function(data) {      
				console.log(data);       
			}); 
		}

	</script>
