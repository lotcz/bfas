<div class="inner cover">
	<h3 class="cover-heading">Login (for TiNG guys only)</h3>
	<form method="post" action="/admin">
		<p><div class="form-label" />Login: </div><input type="text" name="login" /></p>
		<p><div class="form-label" />Password: </div><input type="password" name="password" /></p>
		<p>
			<input type="submit" class="btn btn-success" value="TiNG">					
		</p>
	</form>
	<div class="error-message">
		<?php echo $message ?>
	</div>
</div>