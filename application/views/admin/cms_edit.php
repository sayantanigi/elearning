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
			<div class="col-md-12">
				<form action="<?= admin_url('cms/update') ?>" method="post" enctype="multipart/form-data">
					<div class="white-box">
						<h3 class="box-title m-b-30 m-t-10"><?= $title ?></h3>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Page Title <span>*</span></label>
									<input type="text" class="form-control" name="pageTitle" id="pageTitle" autocomplete="off" value="<?= @$data->pageTitle ?>" required="">
									<input type="hidden" name="pageId" id="pageId" value="<?= @$data->pageId ?>" required="">
								</div>
								<!-- <div class="form-group">
									<label>Page URL <span>*</span></label>
									<input type="text" class="form-control" name="link" id="link" autocomplete="off" value="<?= base_url(@$data->link) ?>" readonly="" required="">
								</div> -->
								<div class="form-group">
									<label>Page Text <span>*</span></label>
									<input type="text" class="form-control" name="pageText" id="pageText" autocomplete="off" value="<?= @$data->pageText ?>" required="">
								</div>
								<div class="form-group">
									<label>Content <span>*</span></label>
									<textarea name="content" id="content" class="summernote" required=""><?= @$data->content ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 col-sm-offset-4">
								<div class="form-group m-t-20">
									<button type="submit" class="btn btn-success waves-effect waves-light">
										Update
									</button>
									<a class="btn btn-default waves-effect waves-light m-l-30" href="<?= admin_url('cms/lists') ?>">
										Back
									</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>