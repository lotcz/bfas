<div class="site-wrapper">
	<div class="">
		<div class="cover-container">
		
			<div class="clearfix scrollhead">
				<div class="inner">
					<h1 class="masthead-brand">Born For A Storm</h1>
					<nav>
						<ul class="nav masthead-nav">
							<li class="active"><a href="http://tingband.com" target="_blank">tingband.com</a></li>
							<?php 
								include '../blocks/user.php';
							?>
						</ul>
					</nav>
				</div>
			</div>

			<?php
				include "../pages/" . $page;
			?>

			<div class="scrollfoot">
				<div class="inner">
					<p>This website was created for TiNG guys with love by <b><span style="color:purple">K</span><span style="color:red">a</span><span style="color:violet">r</span><span style="color:yellow">e</span><span style="color:green">l</span></b>.</p>
				</div>
			</div>

		</div>
	</div>
</div>