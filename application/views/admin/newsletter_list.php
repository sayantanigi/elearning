<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h4 class="page-title"><?= @$title ?></h4>
			</div>
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><?= @$title ?></li>
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
									<th>Email</th>
									<th>Subscribed On</th>
									<th>Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach (@$list as $key => $v): ?>
									<tr>
										<td><?= $i ?></td>
										<td><?= @$v->email ?></td>
										<td><?= date('d-m-Y h:i a', strtotime(@$v->created)) ?></td>
										<td id="status-id-<?= @$v->enquiryId ?>">
											<?php if (@$v->status == 0) { ?>
												<h4 class="label label-danger">Unsubscribed</h4>
											<?php } else { ?>
												<h4 class="label label-success">Subscribed</h4>
											<?php } ?>
										</td>
										<td class="text-center">
											<a onclick="showEnquiryDetails(<?= @$v->newsletterId ?>)" class="btn btn-warning" data-toggle="tooltip" title="View">
												<i class="fa fa-reply"></i>
											</a>
											<button class="btn btn-danger" data-toggle="tooltip" title="Delete" onclick="deleteNewsletter(<?= @$v->newsletterId ?>)">
												<i class="ti-trash"></i>
											</button>
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
	<div  class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">View Enquiry Details</h4>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		function deleteNewsletter(id) {
			swal({
				title: 'Are You sure want to delete this?',
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
					window.location.href = '<?= admin_url('newsletter/delete/') ?>'+id
				}
			});
		}
	</script>