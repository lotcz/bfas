<?php
	global $db;
	$voucher = new Voucher($db);
	$voucher->voucher_code = Voucher::generateToken();
	$voucher->save();
?>
<div class="inner cover">	
	<form method="post" action="/voucher" class="code-form">
		<p>New voucher code is: <span class="voucher-code"><?php echo $voucher->voucher_code ?></span></p>
		<input type="hidden" name="voucher_code" value="<?php echo $voucher->voucher_code ?>" />
		<p>
			<input type="submit" class="btn btn-danger" value="Discard">
			<input type="submit" class="btn btn-success" value="Save">
		</p>
	</form>	
</div>
