<div class="site-wrapper">
	<div class="">
		<div class="cover-container">
		
			<div class="clearfix scrollhead">
				<div class="inner">
					<h1 class="masthead-brand">Born For A Storm</h1>
					<nav>
						<ul class="nav masthead-nav">							
							<?php 
								include $home_dir . 'blocks/user.php';
							?>
						</ul>
					</nav>
				</div>
			</div>

			<?php
				include $home_dir . 'pages/' . $page;
			?>

			<div class="scrollfoot">
				<div class="inner">
					<?php
						include $home_dir . "blocks/foot.php";
					?>
				</div>
			</div>

		</div>
	</div>
</div>