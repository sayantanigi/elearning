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
						<h6 class="text-black fs-20 font-w600 mb-1">List of Instructors</h6>
					</span>
				
				</div>
				<div class="col-xl-6 col-lg-6 mb-2 text-right">
					<ul class="slectview">
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
											<th>User Type</th>
											<th>Request Date</th>
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

												<td>
													<?= (@$v->userType == '1'?'Student':'Instructor') ?>
												</td>
												
												<td><?= date('d-M-Y', strtotime(@$v->reqest_date)) ?></td>
												
												<td class="text-center">
													<a href="<?= admin_url('instructors/profile-updation-detail/'.$v->userId) ?>" class="btn btn-xs btn-secondary" data-toggle="tooltip2" title="Details">
														<i class="fa fa-eye"></i>&nbsp;View Details
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
		function deleteUser(userId) 
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
					window.location.href = '<?= admin_url('instructors/delete/') ?>'+userId
				}
			});
		}

		//Article status change function
		function changeInstructorStatus(id, thisSwitch) {      
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
				url: adminUrl+'instructors/changestatus',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					s: String(id),        
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

		//Course status change function
		function changeApproveStatus(id, thisSwitch) {      
			var newStatus;      
			
			 if (thisSwitch == '1') 
		     {       
		        newStatus = '0';
		     } else {        
		        newStatus = '1';

		     }
			//console.log(newStatus+"***id->"+id);return false;

			$.ajax({      
				url: adminUrl+'instructors/changeapprovestatus',       
				type: 'POST',       
				dataType: 'json',       
				data: {         
					userId: String(id),        
					status: String(newStatus)        
				},
			})
			.done(function(data) {   
			    var redirectURL = adminUrl+"instructors/lists"   
				alert_response(data,redirectURL); 
			})
			.fail(function(data) {      
				console.log(data);       
			}); 
		}

	</script>
