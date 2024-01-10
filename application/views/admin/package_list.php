  <div class="content-body">
            <div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= admin_url('dashboard')?>">Home</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
					</ol>
                </div>
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?= $title ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display table-responsive-md">
                                        <thead>
                                        	<tr>
                                        		<th>#</th>
                                        		<th>Package Name</th>
                                        		<th>Package type</th>
                                        		<th>Currency</th>
                                        		<th>Package price</th>
                                        		<th>Updated</th>
                                        		<th>Status</th>
                                        		<th class="text-center">Action</th>
                                        	</tr>
                                        </thead>
                                       <tbody>
            								<?php $i = 1; ?>
            								<?php foreach ($list as $key => $v): ?>
            									<tr>
            										<td><?= $i ?></td>
            										<td><?= @$v->packageName ?> </td>							
            										<td><?= @$v->type ?></td>
            										<td>
            											<span class="btn btn-main"><?= @$v->currency ?></span>
            										</td>
            										<td><?= @$v->currencySymbol ?> <?= @$v->price ?></td>
            										<td><?= date('d-M-Y', strtotime(@$v->updated)) ?></td>
            										<td>
            											<label class="switch">
            												<input type="checkbox" value="<?= @$v->packageStatus ?>" <?= (@$v->packageStatus == 1)? 'checked="checked"' : ''; ?> onchange="changePackageStatus(<?= @$v->packageId ?>, $(this))">
            												<span class="slider round"></span>
            											</label>
            										</td>
            										<td class="text-center">
            											<a href="<?= admin_url('package/view/'.@$v->packageId) ?>" class="btn btn-sm btn-success" data-toggle="tooltip" title="View Details">
            												<i class="fa fa-eye"></i>
            											</a>
            											<a href="<?= admin_url('package/edit/'.@$v->packageId) ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
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
            </div>
        </div>

