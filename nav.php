<?php
if(!isset($msg)) $msg = '';
?>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" 
id="ftco-navbar">
	<div class="container">
		<a class="navbar-brand" href="<?php echo SITEROOT; ?>">
		<img width="100" src="know.png"/>		
		Ask an Expert
		</a>
		

		
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="fa fa-bars"></span> Menu
		</button>
		<div class="collapse navbar-collapse" id="ftco-nav">
			<ul class="navbar-nav m-auto">

			<li class="nav-item <?php if(strpos($_SERVER['REQUEST_URI'],"about") !== false) echo "active"; ?> ">
			<a href="about.html" class="nav-link">About</a>
			</li>
			
			<li class="nav-item <?php if(strpos($_SERVER['REQUEST_URI'],"ask") !== false) echo "active"; ?> ">
			<a href="ask.html" class="nav-link">Ask</a>
			</li>
			
			<li class="nav-item <?php if(strpos($_SERVER['REQUEST_URI'],"explore") !== false) echo "active"; ?> ">
			<a href="explore.html" class="nav-link">Explore</a>
			</li>
			<!--
			profiles
			-->
			<li class="nav-item <?php if(strpos($_SERVER['REQUEST_URI'],"profiles") !== false) echo "active"; ?> ">
			<a href="profiles.html" class="nav-link">Members</a>
			</li>
			
			
			<li class="nav-item <?php if(strpos($_SERVER['REQUEST_URI'],"articles") !== false) echo "active"; ?> ">
			<a href="articles.html" class="nav-link">Articles</a>
			</li>
			
			<li class="nav-item <?php if(strpos($_SERVER['REQUEST_URI'],"videos") !== false) echo "active"; ?> ">			
			<a href="videos.html" class="nav-link">Videos</a>
			</li>
			
			<li class="nav-item">
			<a href="#lgn" class="nav-link">Login Signup</a>
			</li>			
			
			</ul>
		</div>
	</div>
</nav>
