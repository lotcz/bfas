<div class="inner cover">	
	<form method="post" action="/voucher" class="form-horizontal" style="max-width:480px;margin:auto">
		<input type="hidden" name="voucher_id" value="<?php echo $voucher->voucher_id ?>" />
		<div class="form-group">
			<label class="col-sm-5 control-label"><?= t('Voucher code:') ?></label>
			<div class="col-sm-7">
				<p class="form-control-static voucher-code"><?php echo $voucher->voucher_code ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="customer_email" class="col-sm-5 control-label"><?= t('Customer e-mail:') ?></label>
			<div class="col-sm-7">
				<input type="text" name="customer_email" value="<?=$voucher->voucher_customer_email ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="customer_name" class="col-sm-5 control-label"><?= t('Customer name:') ?></label>
			<div class="col-sm-7">
				<input type="text" name="customer_name" value="<?=$voucher->voucher_customer_name ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<a class="form-button" href="/admin"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteVoucher();" class="btn btn-danger form-button" value="Delete">
			<input type="submit" class="btn btn-success form-button" value="Save">			
		</div>
	</form>	
</div>

<script>
	function deleteVoucher() {
		if (confirm('<?= t('Are you sure to delete this voucher?') ?>')) {
			document.location = '<?= $base_url ?>/voucher/delete/<?php echo $voucher->voucher_id ?>';
		}
	}	
</script>