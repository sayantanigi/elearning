<div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<span class="ttiletop">
					<h6 class="text-black fs-20 font-w600 mb-3">Revenue</h6>
				</span>
				<div class="row">
					<div class="col">
						<div class="card bg-primary revinfo">
							<div class="card-body">
								<div class="media align-items-center">
									<div class="media-body">
										<p class="fs-14 mb-2 text-black">Total Earning</p>
										<span class="fs-32 font-w600 text-blue">$ 8654</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card bg-primary revinfo">
							<div class="card-body">
								<div class="media align-items-center">
									<div class="media-body">
										<p class="fs-14 mb-2 text-black">YTD Earning</p>
										<span class="fs-32 font-w600 text-cyan">$ 36,00</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card bg-primary revinfo">
							<div class="card-body">
								<div class="media align-items-center">
									<div class="media-body">
										<p class="fs-14 mb-2 text-black">Quarter Earning</p>
										<span class="fs-32 font-w600 text-pink">$ 25,00</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card bg-primary revinfo">
							<div class="card-body">
								<div class="media align-items-center">
									<div class="media-body">
										<p class="fs-14 mb-2 text-black">New Subscriptions</p>
										<span class="fs-32 font-w600 text-orange">$ 1260</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card bg-primary revinfo">
							<div class="card-body">
								<div class="media align-items-center">
									<div class="media-body">
										<p class="fs-14 mb-2 text-black">Recurring Subscriptions</p>
										<span class="fs-32 font-w600 text-blue">$ 1260</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-xl-12 col-xxl-12">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header border-0 pb-0 flex-wrap">
										<div class="dropdown custom-dropdown mb-0 mt-3 mt-sm-0 mb-2">
											<div class="btn border text-black btn-rounded" role="button" data-toggle="dropdown" aria-expanded="false">
												This Month
												<i class="las la-angle-down scale5 text-primary ml-3"></i>
											</div>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="javascript:void(0);">Details</a>
												<a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
											</div>
										</div>
									</div>
									<div class="card-body">	
										<div id="simple-line-chart" class="ct-chart ct-golden-section chartlist-chart" ></div>
										<div class="d-flex flex-wrap align-items-center justify-content-center mt-3">
											<div class="fs-14 text-black mr-4">
												<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
													<rect width="19" height="19" rx="9.5" fill="#4E36E2"/>
												</svg>
												New Earning
											</div>
											<div class="fs-14 text-black mr-4">
												<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
													<rect width="19" height="19" rx="9.5" fill="#1BD084"/>
												</svg>
												Recurring
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<h2 class="fs-20">Recent Subscription</h2>
						<div class="card">
							<div class="card-body subsBox">
								<div class="subuserList">
									<div class="subuserImg">
										<img src="<?= base_url('dist/images/noimage.jpg') ?>">
									</div>
									<div class="subUserContent">
										<h5>Wasuma</h5>
										<p>wasuma12@gmail.com</p>
										<p><span class="text-primary">Starter</span></p>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subuserImg">
										<img src="<?= base_url('dist/images/noimage.jpg') ?>">
									</div>
									<div class="subUserContent">
										<h5>Wasuma</h5>
										<p>wasuma12@gmail.com</p>
										<p><span class="text-warning">Premium</span></p>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subuserImg">
										<img src="<?= base_url('dist/images/noimage.jpg') ?>">
									</div>
									<div class="subUserContent">
										<h5>Wasuma</h5>
										<p>wasuma12@gmail.com</p>
										<p><span class="text-warning">Premium</span></p>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subuserImg">
										<img src="<?= base_url('dist/images/noimage.jpg') ?>">
									</div>
									<div class="subUserContent">
										<h5>Wasuma</h5>
										<p>wasuma12@gmail.com</p>
										<p><span class="text-primary">Starter</span></p>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<h2 class="fs-20">Top Subscription</h2>
						<div class="card">
							<div class="card-body subsBox">
								<div class="subuserList">
									<div class="subuserImg">
										<img src="<?= base_url('dist/images/noimage.jpg') ?>">
									</div>
									<div class="subUserContent">
										<h5>Wasuma</h5>
										<p>wasuma12@gmail.com</p>
										<p><span class="text-primary">Starter</span></p>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subuserImg">
										<img src="<?= base_url('dist/images/noimage.jpg') ?>">
									</div>
									<div class="subUserContent">
										<h5>Wasuma</h5>
										<p>wasuma12@gmail.com</p>
										<p><span class="text-warning">Premium</span></p>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subuserImg">
										<img src="<?= base_url('dist/images/noimage.jpg') ?>">
									</div>
									<div class="subUserContent">
										<h5>Wasuma</h5>
										<p>wasuma12@gmail.com</p>
										<p><span class="text-warning">Premium</span></p>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subuserImg">
										<img src="<?= base_url('dist/images/noimage.jpg') ?>">
									</div>
									<div class="subUserContent">
										<h5>Wasuma</h5>
										<p>wasuma12@gmail.com</p>
										<p><span class="text-primary">Starter</span></p>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<h2 class="fs-20">Promotion Codes</h2>
						<div class="card">
							<div class="card-body subsBox">
								<div class="subuserList">
									<div class="subUserContent">
										<h5>New Year Promotion</h5>
										<p>Short description goes here</p>
										<p class="fs-10">Expiry to 10 Jun 2021</p>
									</div>
									<div class="subuserImg">
										<span class="fs-12">TECB5A</span>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subUserContent">
										<h5>New Year Promotion</h5>
										<p>Short description goes here</p>
										<p class="fs-10">Expiry to 10 Jun 2021</p>
									</div>
									<div class="subuserImg">
										<span class="fs-12">TECB5A</span>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subUserContent">
										<h5>New Year Promotion</h5>
										<p>Short description goes here</p>
										<p class="fs-10">Expiry to 10 Jun 2021</p>
									</div>
									<div class="subuserImg">
										<span class="fs-12">TECB5A</span>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
								<div class="subuserList">
									<div class="subUserContent">
										<h5>New Year Promotion</h5>
										<p>Short description goes here</p>
										<p class="fs-10">Expiry to 10 Jun 2021</p>
									</div>
									<div class="subuserImg">
										<span class="fs-12">TECB5A</span>
									</div>
									<div class="subuserPrice">
										<span class="fs-12 text-primary">$86</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        