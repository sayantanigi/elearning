<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h4 class="page-title"><?= $title ?></h4>
			</div>
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><?= $title ?></li>
				</ol>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="white-box">
					<h3 class="box-title m-b-0"><?= $title ?></h3>
					<p class="text-muted m-b-30"></p>
					<div class="table-responsive">
						<table class="table table-striped table-responsive datatable1">
							<thead>
								<tr>
									<th>#</th>
									<th>Job Title</th>
									<th>User Id</th>
									<th>Category</th>
									<th>Pickup Location</th>
									<th>Drop Location</th>									
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($list as $key => $v): ?>
									<tr>
										<td><?= $i ?></td>
										<td><?= $v->jobTitle ?></td>
										<td>
											<?php if($v->userId==0){?>
												Admin
											<?php }else{
												$userInfo = $this->mymodel->get('users', true, 'userId', $v->userId);
												echo @$userInfo->fullName;
											} ?>
										</td>
										<td><?= $v->categoryName ?></td>
										<td><?= $v->pickupLocation ?></td>
										<td><?= $v->dropLocation ?></td>	
										<td class="text-center">
											<a href="<?= admin_url('jobs/view/'.@$v->jobId) ?>" class="btn btn-success" data-toggle="tooltip" title="View Details">
												<i class="fa fa-eye"></i>
											</a>
											<a href="<?= admin_url('jobs/edit/'.$v->jobId) ?>" class="btn btn-primary" data-toggle="tooltip" title="Edit">
												<i class="ti-pencil-alt"></i>
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