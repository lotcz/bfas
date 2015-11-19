<?php 
	if (isset($auth) && $auth->isAuth()) { 
		echo "<li>" . $auth->user->user_email . "</li>";
		echo "<li><a href=\"/logout\">" . t('Log out') . "</a></li>";
	} else {
		?>
		<li class="active"><a href="http://tingband.com" target="_blank">tingband.com</a></li>
		<?php
	}
	if (isset($claim) && $claim->hasVoucher()) { 
		echo "<li><span class=\"voucher-code\">" . $claim->voucher->voucher_code . "</span></li>";
		echo "<li><a href=\"/forget\">" . t('Leave') . "</a></li>";
	}
