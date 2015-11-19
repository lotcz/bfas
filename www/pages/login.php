<div class="inner cover">
	<h3 class="cover-heading">Login</h3>
	<form method="post" action="/admin" class="form-horizontal" style="max-width:320px;margin:auto">
		<span class="help-block">For TiNG guys only.</span>
		<div class="form-group">
			<label for="login" class="col-sm-3 control-label">Login:</label>
			<div class="col-sm-9">
				<input type="text" name="login" class="form-control" value="<?= (isset($_POST['login'])) ? $_POST['login'] : "" ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-3 control-label">Password:</label>
			<div class="col-sm-9">
				<input type="password" name="password" class="form-control"  />
			</div>
		</div>
		<div class="error-message">
			<?php echo $message ?>
		</div>
		<div class="form-group">
			<a class="form-button" href="/"><?= t('Back') ?></a>
			<input type="submit" class="btn btn-success form-button" value="Si!">			
		</div>
	</form>	
</div>