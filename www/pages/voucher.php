<?php
	
	global $db;
	
	if (isset($_POST['voucher_id'])) {
		// save voucher values
		$voucher = Voucher::LoadById($db, $_POST['voucher_id']);
		$voucher->voucher_customer_name = $_POST['customer_name'];
		$voucher->voucher_customer_email = $_POST['customer_email'];
		$voucher->save();
		redirect('/admin');
	} elseif (isset($path[1]) && $path[1] == 'edit') {
		// load for edit
		$voucher = Voucher::LoadById($db, $path[2]);
	} elseif (isset($path[1]) && $path[1] == 'delete') {
		Voucher::deleteById($db, $path[2]);
		redirect('/admin');
	} else {
		// new voucher
		$voucher = new Voucher($db);
		do {
			$voucher->voucher_code = Voucher::generateToken();	
			$exist = Voucher::loadByCode($db, $voucher->voucher_code);
		} while (isset($exist));
		
		$voucher->save();
	}
	
?>
<div class="inner cover">	
	<form method="post" action="/voucher" class="code-form">
		<input type="hidden" name="voucher_id" value="<?php echo $voucher->voucher_id ?>" />
		<div class="form-line">
			<div class="form-label" /><?= t('Voucher code:') ?><div class="form-input" /><span class="voucher-code"><?php echo $voucher->voucher_code ?></span></div>
		</div>
		<div class="form-line">
			<div class="form-label" /><?= t('Customer e-mail:') ?></div><div class="form-input" /><input type="text" name="customer_email" value="<?=$voucher->voucher_customer_email ?>" /></div>
		</div>
		<div class="form-line">
			<div class="form-label" /><?= t('Customer name:') ?> </div><div class="form-input" /><input type="text" name="customer_name" value="<?=$voucher->voucher_customer_name ?>" /></div>
		</div>
		<div class="form-line">
			<a href="/admin"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteVoucher();" class="btn btn-danger" value="Delete">
			<input type="submit" class="btn btn-success" value="Save">
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