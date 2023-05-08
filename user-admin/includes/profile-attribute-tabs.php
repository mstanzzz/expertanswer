<?php 
	//helper function to set active class on appropriate nav items
	function setActiveTab($tab) 
	{
	//get current page URI
		$url = $_SERVER['REQUEST_URI'];
		if(strpos($url,$tab) > 0){
			return "class='active'";	
		}
		else {
			return "";	
		}
	}
?>


		<ul class="nav nav-tabs">
			<li <?php echo setActiveTab("skills.php"); ?>><a href="profile-skills.php">Skills</a></li>
			<li <?php echo setActiveTab("specialties.php"); ?>><a href="profile-specialties.php">Specialties</a></li>
			<li <?php echo setActiveTab("credentials.php"); ?>><a href="profile-credentials.php">?? Credentials</a></li>
			<li <?php echo setActiveTab("associations.php"); ?>><a href="profile-associations.php">?? Associations</a></li>
		</ul>