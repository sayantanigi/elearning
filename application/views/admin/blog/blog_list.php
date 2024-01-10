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
						<a href="<?= admin_url('blog/add') ?>" class="btn btn-rounded btn-info"><span> <i class="fa fa-plus color-info"></i>
						</span> Add Blog </a>				
						
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
											<th class="text-center">Image</th>
											<th class="text-center">Title</th>
											<th class="text-center">Created</th>										
											<th class="text-center">Status</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody class="text-center">
										<?php $i = 1; ?>
										<?php foreach ($list as $key => $v): ?>
											<tr>
												<td><?= $i ?></td>
												<td class="courseBnr">
													<?php if (@$v->thumbnail && file_exists('./uploads/blogs/'.@$v->thumbnail)) { ?>
														<img src="<?= base_url('uploads/blogs/'.@$v->thumbnail) ?>" alt="<?= $v->title ?>">
													<?php } else { ?>
														<img src="<?= base_url('uploads/noimg.png') ?>" alt="<?= $v->title ?>">
													<?php } ?>
												</td>

												<td><?= $v->title ?></td>

												<td><?= $v->created ?></td>
												<td>
													<label class="switch">
														<input type="checkbox" value="<?= $v->status ?>" <?= ($v->status == 1)? 'checked="checked"' : ''; ?> onchange="changeArticleStatus(<?= $v->articleId ?>, $(this))">
														<span class="slider round"></span>
													</label>
												</td>
												<td class="text-center actionbtnlist">
													<a href="<?= admin_url('blog/view/'.@$v->articleId) ?>" class="btn btn-xs btn-primary" data-toggle="tooltip" title="View">
														<i class="fa fa-eye"></i>
													</a>
													<a href="<?= admin_url('blog/edit/'.$v->articleId) ?>" class="btn btn-xs btn-secondary" data-toggle="tooltip" title="Edit">
														<i class="ti-pencil-alt"></i>
													</a>
													<a href="javascript:void(0)" onclick="deleteBlog(<?= @$v->articleId ?>)" class="btn btn-xs btn-danger" data-toggle="tooltip2" title="Delete">
														<i class="fa fa-trash"></i>
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