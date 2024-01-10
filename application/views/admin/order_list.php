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
									<th>Order No.</th>
									<th>Order Type</th>
									<th>Name</th>
									<th>Eshop</th>
									<th>Total Amount</th>
									<th>Order Date/Time</th>
									<th>Payment Status</th>
									<th>Order Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($list as $key => $v): ?>
									<tr>
										<td><?= $i ?></td>
										<td><?= @$v->orderNo ?></td>
										<td>
										<?php if ($v->orderType == "0") { ?>
											Normal Order
										<?php } else { ($v->orderType == "1" ) ?>
											Special Order
										<?php } ?>
										</td>
										<td><?= @$v->firstName ?> <?= @$v->lastName ?></td>
										<td><?= @$v->eshopName ?> (<?= @$v->eshopId ?>)</td>
										<td><?= $this->mymodel->getCurrencySymbol() ?> <?= @$v->totalAmount ?></td>
										<td><?= date('d-m-Y \a\t h:i a', strtotime(@$v->created)) ?></td>
										<td>
											<label class="switch">
												<input type="checkbox" value="<?= @$v->paymentStatus ?>" <?= (@$v->paymentStatus == 1)? 'checked="checked"' : ''; ?> onchange="orderStatus(<?= @$v->orderId ?>, $(this))">
												<span class="slider round"></span>
											</label>
										</td>
										<td>

										<?php if ($v->orderStatus == "0") { ?>
											Placed
										<?php } elseif ($v->orderStatus == "1" ) { ?>
											Dispatched
										<?php } elseif ($v->orderStatus == "2" ) { ?>
											Delivered
										<?php } elseif ($v->orderStatus == "3" ) { ?>
											Return Request
										<?php } elseif ($v->orderStatus == "4" ) { ?>
											Returned
										<?php } elseif ($v->orderStatus == "5" ) { ?>
											Received
										<?php } ?> 

									</td>

									<td class="text-center">
										<a href="<?= admin_url('order/details/'.@$v->orderId) ?>" class="btn btn-success" data-toggle="tooltip" title="Edit and View Details">

											Details	<i class="fa fa-info-circle"></i>
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