<form>
	<div class="form-group col-sm-6">
		<label class="control-label">Name:</label>
		<input type="text" class="form-control" value="<?= @$data->firstName ?> <?= @$data->lastName ?>" readonly="">
	</div>
	<div class="form-group col-sm-6">
		<label class="control-label">Email:</label>
		<input type="text" class="form-control" value="<?= @$data->email ?>" readonly="">
	</div>
	<div class="form-group col-sm-6">
		<label class="control-label">Mobile:</label>
		<input type="text" class="form-control" value="<?= @$data->phone ?>" readonly="">
	</div>
	<div class="form-group col-sm-3">
		<label class="control-label">Contact On:</label>
		<input type="text" class="form-control" value="<?= date('d-m-Y h:i a', strtotime(@$data->created)) ?>" readonly="">
	</div>
	<div class="form-group col-sm-3">
		<label class="control-label">Status:</label>
		<select class="form-control" onchange="changeEnquiryStatus(<?= @$data->enquiryId ?>, $(this))">
			<option value="0" <?= (@$data->status == 0)? 'selected' : '' ?>>Pending</option>
			<option value="1" <?= (@$data->status == 1)? 'selected' : '' ?>>Replied</option>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label">Message:</label>
		<textarea class="form-control" rows="5" readonly=""><?= @$data->message ?></textarea>
	</div>
</form>