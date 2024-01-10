	<div class="content-body">
		<div class="container-fluid">
			<div class="page-titles">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?= admin_url('dashboard')?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?= admin_url('subject/lists') ?>"><?=ucwords(@$page)?></a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
				</ol>
			</div>
			<div class="d-flex flex-wrap mb-4 row">
				<div class="col-xl-6 col-lg-6 mb-2 titleListing">
					<span class="ttiletop"><h6 class="text-black fs-20 font-w600 mb-1"><?=count($list)?> <?= $title ?></h6></span>
					
					<ul class="slectview">
						<!--<li><a href="javascript:void(0)" class="tab-link active" data-tab="tab-1"><i class="fa fa-bars" aria-hidden="true"></i> List</a></li>
						<li><a href="javascript:void(0)" class="tab-link" data-tab="tab-2"><i class="fa fa-th-large" aria-hidden="true"></i> Grid</a></li>-->
					</ul>
				</div>
				<div class="col-xl-6 col-lg-6 d-flex flex-wrap">
					<div class="ml-auto">
					</div>
				</div>
				
			</div>
			
			<!-- row -->
			<div class="row">
				<div class="col-12">
					<div class="">
						
						<div  id="tab-1" class="tab-view active">
							<div class="table-responsive">
								<table id="example" class="display table-responsive-md coursetable">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th class="text-center">Section Title</th>
											<th class="text-center">CMS Title</th>
											<th class="text-center">Image</th>
											<th class="text-center">Page</th>
											<th class="text-center">Updated On</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody class="text-center">
										<?php $i = 1; ?>
										<?php foreach (@$list as $key => $v): ?>
											<tr>
												<td><?= $i ?></td>
												<td><?= @$v->sectionTitle ?></td>
												<td><?= @$v->cmsTitle ?></td>
												<td>
													<?php if (@$v->image && file_exists('./uploads/cms/'.@$v->image)) { ?>
														<img src="<?= base_url('uploads/cms/'.@$v->image) ?>" alt="<?=$v->sectionTitle?>" class="service-thumb" style="width: auto; max-height: 80px;">
													<?php } else { ?>
														<img src="<?= base_url('uploads/noimg.png') ?>" alt="" style="width: 150px; max-height: 80px;">
													<?php } ?>
												</td>
												<td><?= ucfirst(@$v->page_slug) ?></td>
												<td><?= date('d-m-Y h:i a', strtotime(@$v->modified)) ?></td>
												<td class="text-center">
													<a href="<?= admin_url('cms/edit/'.$v->page_slug.'/'.$v->pageId) ?>" class="btn btn-primary" data-toggle="tooltip" title="Edit">
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

	<script>
		function deleteBlog(articleId) {
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
					window.location.href = '<?= admin_url('blog/delete/') ?>'+articleId
				}
			});
		}

	</script>