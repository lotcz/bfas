<div class='inner cover'>	
	<form method='post' action='/voucher' class='code-form'>		
		<input type='submit' class='btn btn-success' value='Create new voucher' style='margin-top:25px;'>
		<div>
			<table>
				<tr><th>code</th><th>e-mail</th><th>name</th><th>created at</th><th>claimed at</th><th></th></tr>
				<?php
					global $db;
					$result = $db->query('SELECT * FROM vouchers ORDER BY voucher_created ASC');
					while ($row = $result->fetch_assoc()) {
						echo '<tr>';
						echo '<td style="color:white">' . $row['voucher_code'] . '</td>';
						echo '<td>' . $row['voucher_customer_email'] . '</td>';
						echo '<td>' . $row['voucher_customer_name'] . '</td>';
						echo '<td>' . $row['voucher_created'] . '</td>';
						echo '<td>' . $row['voucher_used'] . '</td>';
						echo '<td><a href="/voucher/edit/' . $row['voucher_id'] . '">edit</a></td>';
						echo '</tr>';
					}
				?>
			</table>
		</div>
	</form>	
</div>
