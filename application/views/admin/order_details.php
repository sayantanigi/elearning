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
		<div class="col-md-12">
			<div class="white-box">
				<h3 class="box-title m-b-30"><?= @$title ?></h3>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="col-sm-3">Order No. </label>
							<div class="col-sm-3"> <?= $details->orderNo ?></div>
							<label class="col-sm-3">Order Date </label>
							<div class="col-sm-3">
								<?= date('d-m-Y \a\t h:i a', strtotime(@$details->created)) ?></div>
							</div>
						</div>							
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">

								<label class="col-sm-3">Total</label>
								<div class="col-sm-3"><?= $this->mymodel->getCurrencySymbol() ?> <?= @$details->total_Amount ?></div>
								<?php if ($details->orderType == "1") { ?>
									<label class="col-sm-3">Total Reward Value Adjusted</label>
									<div class="col-sm-3"><?= $this->mymodel->getCurrencySymbol() ?> <?= @$details->rewardtotal_Amount ?></div>
								<?php }  ?>

							</div>
						</div>							
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-sm-3">Payment Method </label>
								<div class="col-sm-3">
									<?php if ($details->paymentMethod = 0) { ?> Cash On Delivery
								<?php } else { ?>
									Online Payment Gateway
								<?php } ?>  
							</div>
							<label class="col-sm-3">Order Type</label>
							<div class="col-sm-3">
								<?php if ($details->orderType == "0") { ?>
									Normal Order
								<?php } else { ($details->orderType == "1" ) ?>
								Special Order
							<?php } ?>
						</div>
					</div>
						<div class="form-group">
						<label class="col-sm-3">Order Status</label>
						<div class="col-sm-3">
							<select class="form-control" name="deliveryPersonId" onchange="updateStatus($(this).val(), <?= $details->orderId ?>)">

								<option value="0" <?= (@$details->orderStatus  == "0")? 'selected="selected"' : ''; ?>>
									Placed 
								</option>
								<option value="1" <?= (@$details->orderStatus  == "1")? 'selected="selected"' : ''; ?>>
									Dispatched 
								</option>
								<option value="2" <?= (@$details->orderStatus  == "2")? 'selected="selected"' : ''; ?>>
									Delivered 
								</option>
								<option value="3" <?= (@$details->orderStatus  == "3")? 'selected="selected"' : ''; ?>>
									Return Request 
								</option>
								<option value="4" <?= (@$details->orderStatus  == "4")? 'selected="selected"' : ''; ?>>
									Returned 
								</option>
								<option value="5" <?= (@$details->orderStatus  == "5")? 'selected="selected"' : ''; ?>>
									Received 
								</option>
							</select>
						</div>
						<label class="col-sm-3">Status </label>
						<div class="col-sm-1"> 
							<input type="checkbox" value="<?= @$details->status ?>" <?= (@$details->status == 1)? 'checked="checked"' : ''; ?>>
							<span class="slider round"></span>
						</div>	
					</div>
				</div>							
			</div>
			<hr>
			<h3 class="box-title m-b-30">Product Details</h3>
			<p class="text-muted m-b-30"></p>
			<?php if ($details->orderType == "0") { ?>
				<div class="table-responsive">
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th>#</th>
								<th>Image</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Unit Price</th>
								<th>Total Price</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($productlist as $key => $p): ?>
								<tr>
									<td><?= $i ?></td>
									<td>
										<?php if (file_exists('./uploads/products/small/'.$p->productImage)) { ?>

											<a href="<?= base_url()?>product/details/<?=$p->productId?>/<?=$p->url?>"> <img src="<?= base_url('uploads/products/small/').$p->productImage ?>" style="width:70px"  class="img-thumbnail"  alt=""></a>

										<?php } else { ?>
											<a href="<?= base_url()?>product/details/<?=$p->productId?>/<?=$p->url?>"> <img src="<?= base_url('assets/images/thumbs.jpg') ?>" style="width:70px"  class="img-thumbnail"  alt=""></a>
										<?php } ?>
									</td>
									<td><a href="<?= base_url()?>product/details/<?=$p->productId?>/<?=$p->url?>"><?=$p->productName?></a></td>
									<td><?= @$p->quantity ?></td>
									<td><?=$p->price?></td>
									<td><?= $this->mymodel->getCurrencySymbol() ?> <?= ((@$p->quantity)*(@$p->price)) ?></td>
								</tr>
								<?php $i++; ?>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			<?php } else {?>

				<div class="table-responsive">
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th>#</th>
								<th>Image</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Unit Price</th>
								<th>Unit Reward Value</th>
								<th>Total Price</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($productlist as $key => $rp): ?>
								<tr>
									<td><?= $i ?></td>
									<td>
										<?php if (file_exists('./uploads/products/small/'.$rp->productImage)) { ?>

											<a href="<?= base_url()?>product/details/<?=$rp->productId?>/<?=$rp->url?>"> <img src="<?= base_url('uploads/products/small/').$rp->productImage ?>" style="width:70px"  class="img-thumbnail"  alt=""></a>

										<?php } else { ?>
											<a href="<?= base_url()?>product/details/<?=$rp->productId?>/<?=$rp->url?>"> <img src="<?= base_url('assets/images/thumbs.jpg') ?>" style="width:70px"  class="img-thumbnail"  alt=""></a>
										<?php } ?>
									</td>
									<td><a href="<?= base_url()?>product/rewards/<?=$rp->productId?>/<?=$rp->url?>"><?=$rp->productName?></a></td>
									<td><?= @$rp->quantity ?></td>
									<td><?=$rp->price?></td>
									<td><span class="label label-warning"><sup>o</sup>P</span> <?=$rp->rewardPoints?></td>
									<td><?= $this->mymodel->getCurrencySymbol() ?> <?= ((@$rp->quantity)*(@$rp->price)) ?></td>
								</tr>
								<?php $i++; ?>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			<?php } ?>
			<hr>
			<h3 class="box-title m-b-30">Customer Details</h3>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label class="col-sm-3">Name </label>
						<div class="col-sm-3"> <?= @$details->firstName ?> <?= @$details->lastName ?></div>
						<label class="col-sm-3">Email Address </label>
						<div class="col-sm-3"><?= $details->email ?></div>

					</div>
					<div class="form-group">
						<label class="col-sm-3">Mobile </label>
						<div class="col-sm-3"><?= $details->mobile ?></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3">Customer Note </label>
						<div class="col-sm-3"><?=@$details->orderComment?></div>
					</div>

				</div>							
			</div>
			<hr>
			<h3 class="box-title m-b-30">Delivery Details</h3>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label class="col-sm-3">Receive Products At  </label>
						<div class="col-sm-9"><?php if ($details->receiveProductsAt = 0) { ?> Shipping Address
						<?php } else { ?>
							Nearest E-shop
						<?php } ?>  
					</div>
				</div>
			</div>

			<hr>
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-sm-3">Shipping  </label>
					<div class="col-sm-9"> <?= @$shippingDetails->fullName ?> [<?= @$shippingDetails->mobile ?>] 
						<?= @$shippingDetails->addressLine1 ?>, <?= @$shippingDetails->addressLine2 ?>
                              <?= @$shippingDetails->city ?>, <?= @$shippingDetails->state ?>
                              - <?= @$shippingDetails->postcode ?>  <?= @$shippingDetails->country ?> </div>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label class="col-sm-3">Delivery Center:</label>
				<div class="col-sm-9">
					<select class="form-control select2" name="deliveryPersonId" onchange="assignOrderDelivery($(this).val(), <?= $details->orderId ?>)">
						<option value="">Select Delivery </option>
						<?php if (count($deliveryList) > 0): ?>
							<?php foreach ($deliveryList as $key => $v): ?>
								<option value="<?= $v->deliveryPersonId ?>" <?= (@$deliveryStatus->deliveryPersonId  == @$v->deliveryPersonId)? 'selected="selected"' : ''; ?>>
									<?= $v->name ?> (<?= $v->eshopName ?>)
								</option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
				</div>	
			</div>


		</div>
		<hr>
		<?php if ($details->orderType == "0") { ?>
			<h3 class="box-title m-b-30">Reward Details</h3>

			<div class="row">
				<div class="table-responsive">
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th>First Level</th>
								<th>Second Level</th>
								<th>Third Level</th>
								<th>Fourth Level</th>
								<th>Credit Status</th>
								<th>Redeem Point Status</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($rewardList as $key => $r): ?>
								<tr>

									<td>
										<?php 

										$use=$this->mymodel->fetch_user($r->firstLevel);


										if (is_numeric($r->firstLevel)) {?>
											<?= @$use->firstName ?> <?= @$use->lastName ?>
											<?php
										}else{
											echo @$use->eshopName;
										}
										?>
										<br>
										<?= @$r->firstPoint ?>
									</td>
									<td>
										<?php 
										$use1=$this->mymodel->fetch_user($r->secondLevel);
										if (is_numeric($r->secondLevel)) {?>
											<?= @$use1->firstName ?> <?= @$use1->lastName ?>
											<?php
										}else{
											echo @$use1->eshopName;
										}
										?>
										<br>
										<?= @$r->secondPoint ?>
									</td>
									<td><?php 
									$use2=$this->mymodel->fetch_user($r->thirdLevel);
									if (is_numeric($r->thirdLevel)) {?>
										<?= @$use2->firstName ?> <?= @$use2->lastName ?>
										<?php
									}else{
										echo @$use2->eshopName;
									}
									?>
									<br>
									<?= @$r->thirdPoint ?>
								</td>
								<td><?php 
								$use3=$this->mymodel->fetch_user($r->fourthLevel);
								if (is_numeric($r->fourthLevel)) {?>
									<?= @$use3->firstName ?> <?= @$use3->lastName ?>
									<?php
								}else{
									echo @$use3->eshopName;
								}
								?>
								<br>
								<?= @$r->fourthPoint ?>
							</td>
							<td> 
								<?php if (@$r->creditStatus == 0) {  ?> 
									Pending
								<?php } else { ?>
									credited
								<?php } ?>  
							</td>
							<td> 
								<?php if (@$r->creditStatus == 0) {  ?> 
									<button type="submit" onclick="reedemPoint(<?= $r->id ?>)" class="btn-danger"> Pending  </button>
									<span class="label label-warning">To click on Button to updated</span>

								<?php } else { ?>
									<button type="submit" class="btn-success">  Credited </button>
								<?php } ?>  
							</td>


						</tr>
						<?php $i++; ?>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<hr>						
	</div>
<?php } else {?>
	<h3 class="box-title m-b-30">Reward Details</h3>
	<div class="table-responsive">
		<table class="table table-striped table-responsive">
			<thead>
				<tr>
					<th>Eshop Id</th>
					<th>Credit Status</th>
					<th>Redeem Point Status</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				<?php foreach ($rewardList as $key => $r): ?>
					<tr>

						<td>
							<?php 

							$use=$this->mymodel->fetch_user($r->eshopId);

							echo @$use->eshopName;

							?>
							<br>
							<?= @$r->eshopPoint ?>
						</td>

						<td> 
							<?php if (@$r->creditStatus == 0) {  ?> 
								Pending
							<?php } else { ?>
								credited
							<?php } ?>  
						</td>
						<td> 
							<?php if (@$r->creditStatus == 0) {  ?> 
								<button type="submit" class="btn-danger"> Pending  </button>
								<span class="label label-warning">To click on Button to updated</span>

							<?php } else { ?>
								<button type="submit" class="btn-success">  Credited </button>
							<?php } ?>  
						</td>


					</tr>
					<?php $i++; ?>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
<?php } ?>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4">
		<div class="form-group m-t-20">
			<a class="btn btn-warning waves-effect waves-light m-l-30" href="<?= admin_url('order/lists') ?>">
				Back
			</a>
		</div>
	</div>
</div>
</div>
</div>
</div>
