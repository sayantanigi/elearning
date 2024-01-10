<div class="main-section">
<div class="page-section  nopadding cs-nomargin" style="margin-top: 0px; padding-top: 100px; padding-bottom: 0px; background: url(<?= base_url()?>frontend/assets/extra-images/foodcourt-mainimage-1.png) no-repeat fixed center / cover;">
<div class="container">
<div class="row">
<div class="section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="element-title">
<h3 style="color:red !important; font-size: 35px !important; letter-spacing: 1px !important; line-height: 54px !important; text-align:center!important; font-weight:600!important; text-transform:uppercase!important;">
	<?php if($this->session->flashdata('msg')!='') { ?>
		<label>
			<?php echo @$this->session->flashdata('msg');?>
		</label>
	<?php } ?>
</h3>
<p style="color:#ffffff !important; font-size: 24px !important; line-height: 32px !important; text-align:center!important; text-transform:uppercase!important;">
<a href="<?= base_url() ?>" class="btn btn-lg btn-success ">Back to Home</a> </p>
<br/>
<br/>
<br/>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
