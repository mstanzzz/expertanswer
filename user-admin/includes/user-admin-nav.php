<?php
/*
if(!isset($lgn)){
	require_once('../includes/class.customer_login.php');
	require_once('../includes/class.profess.php');
	$lgn = new CustomerLogin;
	$prof = new Professional;
	$profile_id = $lgn->getProfileId();
	$name = $prof->getProfName($profile_id);	
}
*/
if(!isset($name)) $name = " Member "; 

//echo "HHHHHHHHHH";

?>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
<div class="container d-flex flex-column">
<div class="d-flex justify-content-between navbar-translate w-100">
	<div class="navbar-brand">
		<img src="../img/nat.png" height="40" />
		<span>Welcome
		<?php echo $name;?>
		</span>
	</div>
	<button type='button' class='navbar-toggler collapsed'					
		data-toggle='collapse'
		data-target='#navigation'
		aria-controls='navigation'
		aria-expanded='false'
		aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	</button>
</div>
<div class="navbar-collapse collapse" id="navigation">
	<ul class="nav nav-pills mt-4">
	<li class="nav-item admin-landing">
		<a href="user-admin-landing.php" class="nav-link small text-uppercase text-white">Home</a>
	</li>
	<li class="nav-item profile-info">
		<a href="profile-information.php" class="nav-link small text-uppercase text-white">About You</a>
	</li>
	<li class="nav-item profile-skill">
		<a href="profile-skills.php" class="nav-link small text-uppercase text-white">Skills</a>
	</li>
	<li class="nav-item profile-cred">
		<a href="profile-credentials.php" class="nav-link small text-uppercase text-white">Credentials</a>
	</li>
	<li class="nav-item profile-questions">
		<a href="questions-all.php" class="nav-link small text-uppercase text-white">Questions</a>
	</li>
	<li class="nav-item profile-article">
		<a href="articles-me.php" class="nav-link small text-uppercase text-white">Articles</a>
	</li>
	<li class="nav-item profile-video">
		<a href="profile-gallery.php" class="nav-link small text-uppercase text-white">Gallery</a>
	</li>
	<li class="nav-item social-links">
		<a href="social-links.php" class="nav-link small text-uppercase text-white">Social</a>
	</li>
	<!--
	<li class="nav-item social-links">
		<a href="profile-videos.php" class="nav-link small text-uppercase text-white">Videos</a>
	</li>
	-->
	
	
	<li class="nav-item profile-pass">
		<a href="change-password.php" class="nav-link small text-uppercase text-white">Password</a>
	</li>
	<li class="nav-item">
		<a href="index.php?signout=1" class="nav-link small text-uppercase text-white">Sign Out</a>
	</li>
	</ul>
</div>
</div>
</nav>
