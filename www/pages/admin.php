<div class="inner cover">	
	<form method="post" action="/voucher" class="code-form">		
		<input type="submit" class="btn btn-success" value="Create new voucher" style="margin-bottom:25px;">
	</form>	
	<table style="margin:auto;border:solid 1px white;">
		<tr><th>voucher code</th><th>customer e-mail</th><th>created at</th><th>created by</th><th>claimed at</th></tr>
		<?php
			global $db;
			$result = $db->query("SELECT * FROM vouchers");
			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row['voucher_code'] . "</td></tr>";
			}
		?>
	</table>
</div>
