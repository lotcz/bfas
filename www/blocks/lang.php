<?php

	if (!( (isset($auth) && $auth->isAuth()) or (isset($claim) && $claim->hasVoucher()) )) {
		?>
			<a href="#" onclick="javascript:setLang('cs');return false" class="<?= t('cs_css') ?>"><img src="/images/cs.jpg" alt="<?= t('Czech') ?>"  title="<?= t('Czech') ?>" /></a>
			<a href="#" onclick="javascript:setLang('en');return false" class="<?= t('en_css') ?>"><img src="/images/en.jpg" alt="<?= t('English') ?>" title="<?= t('English') ?>" /></a>
			<a href="#" onclick="javascript:setLang('es');return false" class="<?= t('es_css') ?>"><img src="/images/es.jpg" alt="<?= t('Mexican') ?>" title="<?= t('Mexican') ?>" /></a>
		<?php
	}