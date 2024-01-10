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
						<h6 class="text-black fs-20 font-w600 mb-1">FAQ</h6>
					</span>
					
				</div>
				<div class="col-xl-6 col-lg-6 mb-2 text-right">
					<ul class="memstuList">
						<li><a class="active" href="<?= base_url('uploads/faq/demo/faq.csv');?>" target="_blank">Download</a></li>
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
											<th>Question</th>
											<th>Answer</th>
											<th>Date</th>
											<th>Update</th>
											<th>status</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=1;
										  if(!empty($faqList)){
										    foreach ($faqList as $fList){	
										?>
												<tr>
													<td><?= $i++;?></td>
													<td><?= $fList->question;?></td>
													<td><?= $fList->answer;?></td>
													<td>
														<?php 
															if(!empty($fList->created)){ 
													              echo date('d-M-Y h:i:s A',strtotime($fList->created));
															}
														?>
													</td>
													<td>
														<?php 
															if(!empty($fList->updated)){ 
													              echo date('d-M-Y h:i:s A',strtotime($fList->updated));
															}
														?>
													</td>
													<td>
														<?php
															if($fList->status==1){
																 echo btn_publish('admin/faq/unpblish/'. $fList->id);
															}else{
																 echo btn_unpublish('admin/faq/publish/'. $fList->id);
															}
														?>
													</td>
													<td class="text-center actionbtnlist">
														<a href="<?= admin_url('faq/view/'.$fList->id);?>" class="btn btn-xs btn-primary" data-toggle="tooltip2" title="Details">
															<i class="fa fa-eye"></i>
														</a>
														<a href="<?= admin_url('faq/edit/'.$fList->id);?>" class="btn btn-xs btn-secondary" data-toggle="tooltip2" title="Edit">
															<i class="fa fa-edit"></i>
														</a>
														
														<a href="javascript:void(0)" onclick="deleteSubject(<?= @$fList->id ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
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

					<div id="tab-2" class="tab-view">
						<div class="row">
							
							<div class="col-lg-4 col-md-6">
								<div class="membergridbox">
									<div class="membergridtop">
										<div class="mGridUserPic">
											<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
										</div>
										<div class="mGridUserInfo">
											<h2>Mark H Lui</h2>
											<p>mark123@gmail.com</p>
											<ul class="complredPoints">
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
											</ul>
										</div>
										<div class="mGridAction">
											<div class="dropdown float-right custom-dropdown mb-0">
												<div class="" data-toggle="dropdown">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
															<path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
															<path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													</svg>
												</div>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Edit</a>
												</div>
											</div>
										</div>
									</div>
									<div class="membergridMiddle">
										<p><a href="#" class="btn btn-boredered btn-primary">Starter</a></p>
										<p>Subscription expireon <span class="edate">28 Mar 2021</span></p>
										<p>
											<span class="totalPoints">2150 Point</span>
											<span class="totalSubs">2150 Point</span>
										</p>
									</div>
									<div class="membergridbottom">
										<a href="#">Message</a>
										<div class="otheruserimg">
											<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div class="membergridbox">
									<div class="membergridtop">
										<div class="mGridUserPic">
											<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
										</div>
										<div class="mGridUserInfo">
											<h2>Mark H Lui</h2>
											<p>mark123@gmail.com</p>
											<ul class="complredPoints">
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
											</ul>
										</div>
										<div class="mGridAction">
											<div class="dropdown float-right custom-dropdown mb-0">
												<div class="" data-toggle="dropdown">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
															<path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
															<path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													</svg>
												</div>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Edit</a>
												</div>
											</div>
										</div>
									</div>
									<div class="membergridMiddle">
										<p><a href="#" class="btn btn-boredered btn-warning">Premium</a></p>
										<p>Subscription expireon <span class="edate">28 Mar 2021</span></p>
										<p>
											<span class="totalPoints">2150 Point</span>
											<span class="totalSubs">2150 Point</span>
										</p>
									</div>
									<div class="membergridbottom">
										<a href="#">Message</a>
										<div class="otheruserimg">
											<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div class="membergridbox">
									<div class="membergridtop">
										<div class="mGridUserPic">
											<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
										</div>
										<div class="mGridUserInfo">
											<h2>Mark H Lui</h2>
											<p>mark123@gmail.com</p>
											<ul class="complredPoints">
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
												<li><a href="#"><img src="<?= base_url('dist/images/noimage.jpg') ?>" alt=""></a></li>
											</ul>
										</div>
										<div class="mGridAction">
											<div class="dropdown float-right custom-dropdown mb-0">
												<div class="" data-toggle="dropdown">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
															<path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
															<path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#2E2E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													</svg>
												</div>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Edit</a>
												</div>
											</div>
										</div>
									</div>
									<div class="membergridMiddle">
										<p><a href="#" class="btn btn-boredered btn-primary">Starter</a></p>
										<p>Subscription expireon <span class="edate">28 Mar 2021</span></p>
										<p>
											<span class="totalPoints">2150 Point</span>
											<span class="totalSubs">2150 Point</span>
										</p>
									</div>
									<div class="membergridbottom">
										<a href="#">Message</a>
										<div class="otheruserimg">
											<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
										</div>
									</div>
								</div>
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