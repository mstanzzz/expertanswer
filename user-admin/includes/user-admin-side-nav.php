<?php 
$uri = $_SERVER['REQUEST_URI'];
?>

<script>


function toggleMenu() {
	
	var w = window.innerWidth;
	var menu_is_open = document.getElementById("menu_is_open");

	if(menu_is_open.value == 2){
		if(w > 888){
			menu_is_open.value = 1;
		}else{
			menu_is_open.value = 0;				
		}
	}

	var x = document.getElementById("l_s_m_c");

	if(menu_is_open.value == 1){
		x.style.display = "none";
		menu_is_open.value = 0;
	}else{
		x.style.display = "block";
		menu_is_open.value = 1;		
	}

}

</script>

<!--
<input id="menu_is_open" type="hidden" name="menu_is_open" value="2">
<a href="about.php" <?php //if(strpos($uri,"about") !== false) echo "class='active'"; ?>>ABOUT</a>
<div class="hamburger-menu-button">
	<img src="../images/menu.png" alt="Menu" onClick="toggleMenu();"  >
</div>

<div id="l_s_m_c" class="left-sidebar-container">
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/user-admin-landing.php">Home</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/profile-image.php">Profile Image</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/profile-information.php">About</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/profile-skills.php">Skills</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/profile-credentials.php">Credentials</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/questions-all.php">Questions</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/articles-me.php">Articles</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/social-links.php">Social Network</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/profile-change-password.php">Change Password</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/profile-settings.php">Profile Settings</a>
	</div>
	<div class="btn-info-container">
		<a href="<?php echo SITEROOT; ?>/user-admin/index.php?slug=signout">Sign Out</a>
	</div>

</div>

-->

		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/user-admin-landing.php">Home</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/profile-image.php">Profile Pic</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/profile-information.php">About You</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/profile-skills.php">Skills</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/profile-credentials.php">Credentials</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/questions-all.php">Questions</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/articles-me.php">Articles</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/social-links.php">Social</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/profile-change-password.php">Password</a>
		</div>
		<div class="btn-info-container-2">
			<a href="<?php echo SITEROOT; ?>/user-admin/index.php?slug=signout">Sign Out</a>
		</div>

<div style="clear:both;"></div>