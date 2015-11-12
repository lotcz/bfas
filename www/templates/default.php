<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container">
		
			<div class="masthead clearfix">
				<div class="inner">
					<h1 class="masthead-brand">Born For A Storm</h1>
					<nav>
						<ul class="nav masthead-nav">
							<li class="active"><a href="http://tingband.com" target="_blank">tingband.com</a></li>
							<?php 
								if (isset($auth) && $auth->isAuth()) { 
									echo "<li>" . $auth->user['email'] . "</li>";
									echo "<li><a href=\"/logout\">Log out</a></li>";
								}
								if (isset($claim) && $claim->hasVoucher()) { 
									echo "<li><span class=\"voucher-code\">" . $claim->voucher->voucher_code . "</span></li>";
									echo "<li><a href=\"/forget\">Forget me</a></li>";
								}
							?>
						</ul>
					</nav>
				</div>
			</div>

			<?php
				include "..\\pages\\" . $page;
			?>

			<div class="mastfoot">
				<div class="inner">
					<p>This website was created for TiNG guys with love by <b><span style="color:purple">K</span><span style="color:red">a</span><span style="color:violet">r</span><span style="color:yellow">e</span><span style="color:green">l</span></b>.</p>
				</div>
			</div>

		</div>
	</div>
</div>