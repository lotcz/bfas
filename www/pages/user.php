<?php
	
	global $db;
	
	if (isset($_POST['user_id'])) {
		// save user values
		if ($_POST['user_id'] > 0) {
			$user = User::LoadById($db, $_POST['user_id']);
		} else {
			$user = new User($db);
		}
		$user->user_login = $_POST['user_login'];
		$user->user_email = $_POST['user_email'];
		if (isset($_POST['user_password']) and strlen($_POST['user_password']) > 0) {
			$user->user_password_hash = Authentication::hashPassword($_POST['user_password']);
		}
		$user->save();
		redirect('/users');
	} elseif (isset($path[1]) && $path[1] == 'edit') {
		// load for edit
		$user = User::LoadById($db, $path[2]);
	} elseif (isset($path[1]) && $path[1] == 'delete') {
		User::deleteById($db, $path[2]);
		redirect('/users');
	} else {
		// new user
		$user = new User($db);
		$user->user_id = 0;
	}
	
?>
<div class="inner cover">	
	<form method="post" action="/user" class="code-form">
		<input type="hidden" name="user_id" value="<?php echo $user->user_id ?>" />
		<div class="form-line">
			<div class="form-label" /><?= t('Login:') ?><div class="form-input" /><input type="text" name="user_login" value="<?=$user->user_login ?>" /></div>
			<span id="user_login_validation" class="form-validation"><?= t('Login or Email required.') ?></span>
		</div>		
		<div class="form-line">
			<div class="form-label" /><?= t('E-mail:') ?></div><div class="form-input" /><input type="text" name="user_email" value="<?=$user->user_email ?>" /></div>
			<span id="user_email_validation" class="form-validation"><?= t('Login or Email required.') ?></span>
		</div>
		<div class="form-line">
			<div class="form-label" /><?= t('Password:') ?> </div><div class="form-input" /><input type="text" name="user_password" /></div>
			<span id="user_password_validation" class="form-validation"><?= t('Required.') ?></span>
		</div>
		<div class="form-line">
			<a href="/users"><?= t('Back') ?></a>
			<input type="button" onclick="javascript:deleteUser();" class="btn btn-danger" value="Delete">
			<input type="button" onclick="javascript:validate();" class="btn btn-success" value="Save">
		</div>
	</form>	
</div>

<script>
	function validate() {
		var isValid = true;
		var login = document.forms[0]['user_login'].value;
		var email = document.forms[0]['user_email'].value;
		if (login.length == 0 && email.length == 0) {
			showFieldValidation('user_login');
			showFieldValidation('user_email');			
			isValid = false;
		} else {
			 hideFieldValidation('user_login');
			 hideFieldValidation('user_email');
		}
		var id = document.forms[0]['user_id'].value;
		if (id == '0') {
			isValid = validateField('user_password') && isValid;
		}
		if (isValid) {
			document.forms[0].submit();
		}
	}
	
	function deleteUser() {
		if (confirm('<?= t('Are you sure to delete this user?') ?>')) {
			document.location = '<?= $base_url ?>/user/delete/<?php echo $user->user_id ?>';
		}
	}	
</script>