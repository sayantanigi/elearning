<div class="content-body">

	<div class="container-fluid">

		<div class="page-titles">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>

				<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>

			</ol>

		</div>

		<!-- row -->

		<div class="row">	

			<div class="col-xl-12 col-lg-12">

				<div class="card">

					<div class="card-header">

						<h4 class="card-title"><?= $title ?></h4>

					</div>

					<div class="card-body">

						<div class="basic-form">

							<form action="<?= admin_url('profile/save') ?>" class="form-horizontal" method="post">							



								<div class="form-group row">

									<label class="col-sm-3 col-form-label">Name <span class="error">*</span></label>

									<div class="col-sm-3">

										<input type="text" class="form-control" name="name" id="name" value="<?= $data->name ?>" required="">

									</div>

								</div>

								<div class="form-group row">

									<label class="col-sm-3 col-form-label">Email Address <span class="error">*</span></label>

									<div class="col-sm-3">

										<input type="email" class="form-control" name="email" id="email" value="<?= $data->email ?>" data-validation="email" required="">

									</div>

								</div>

								<div class="form-group row">

									<label class="col-sm-3 col-form-label">Created On <span class="error">*</span></label>

									<div class="col-sm-3">

										<input type="text" class="form-control" name="created" id="created" value="<?= date('d-m-Y h:m A', strtotime($data->created)) ?>" disabled="" required="">

									</div>

								</div>

								<div class="form-group row">

									<label class="col-sm-3 col-form-label">Last Updated <span class="error">*</span></label>

									<div class="col-sm-3">

										<input type="text" class="form-control" name="edited" id="edited" value="<?= date('d-m-Y h:m A', strtotime($data->edited)) ?>" disabled="" required="">

									</div>

								</div>

								<div class="form-group row">

									<div class="col-sm-10">

										<input type="submit" class="btn btn-success" value="Update Profile"/>

									</div>

								</div>

							</form>

						</div>

					</div>

				</div>

			</div>					

		</div>

	</div>

</div>



