<div class="site-wrapper">
	<div class="site-wrapper-inner">
		<div class="cover-container">
		
			<div class="masthead clearfix">
				<div class="inner">
					<h1 class="masthead-brand">Born For A Storm</h1>					
					<nav>
						<ul class="nav masthead-nav">
							<?php								
								include $home_dir . 'blocks/user.php';
							?>
							<?php								
								include $home_dir . 'blocks/lang.php';
							?>
						</ul>
					</nav>
				</div>
			</div>

			<?php
				include $home_dir . "pages/" . $page;
			?>

			<div class="mastfoot">
				<div class="inner">
					<?php
						include $home_dir . "blocks/foot.php";
					?>
				</div>
			</div>

		</div>
	</div>
</div>