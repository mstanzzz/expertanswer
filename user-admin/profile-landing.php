<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	ssheader($header_str);
}
	$page_title = "My Profile";
	$page_group = "profile";
?>
<!doctype html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

<title>Expert Answer</title>


<style>

</style>

</head>
<body style="background-color: #FFF1E5;">
<div style="margin-left:15px;">
	<img height="40" src="<?php echo SITEROOT;?>/img/nat.png" />
	<?php
	echo "<span>Welcome  ".$lgn->getFullName()."<span>";
	echo "<span style='margin-left:30px; color:red; font-size:1.3em;'>".$msg."</span>";
	echo "<br />";
	require_once('includes/user-admin-nav.php');
	?>
</div>
<div style='clear:both;'></div>


<div class="row">
	<div class="col-md-12>
		<div style="margin:10px;">		
	
			
	<h1>My Profile</h1>
	<ul>
		<li><a class="landingbtn banners" href="profile-image.php"><span>Profile Image</span></a></li>
    	<li><a class="landingbtn blogposts" href="profile-information.php"><span>About Me</span></a></li>
		<li><a class="landingbtn reviews" href="profile-skills.php"><span>Skills</span></a></li>
		<li><a class="landingbtn password" href="profile-change-password.php"><span>Change Password</span></a></li>
	</ul>

</div>
</div>
</div>


<script src="../js/jquery.min.js"></script>


</body>
</html>