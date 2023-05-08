<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

require_once('../includes/class.profess.php');



$lgn = new CustomerLogin;

$prof = new Professional;



if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
	
}

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';


if(isset($_POST['set_profile_status'])){
	
	$active = isset($_POST['active'])? 1 : 0;
	
	//echo $active;
	
	//exit;
	
	
	$prof->setProfIsActive($lgn->getProfileId(), $active);
	
	if($active){
		$msg = "Your profile is now public";
	}else{
	
		$msg = "Your profile is now hidden";	
	}
}


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
<body style="background-color: black;">

<div class="container" style="background-color: #C0C0C0;  min-height:1200px;">

	<img src="<?php echo SITEROOT;?>/img/nat.png" />
	<?php
	echo "Welcome  ".$lgn->getFullName();		
	?>
	
	
	<?php 
	if($msg != ""){
		echo "<h4 style='color:red;'>".$msg."</h4>";	
	}
	?>
	
	
	
	
	<div class="row">
		<div class="col-md-3">
			<?php
			require_once("includes/user-admin-side-nav.php");
			?>
		</div>
		<div class="col-md-9" style="background-color: white;">

			<?php 
			echo "<div style='color:red;'>$msg</div>";
			$profile_state = $prof->profIsActive($lgn->getProfileId());
			$status_msg = ($profile_state) ? "Your Profile is Public" : "Your Profile is Hidden";
			echo $status_msg."<br /><br />";
			?>
			<form name="form" action="profile-settings.php" method="post" enctype="multipart/form-data">
			<?php
			$checked = ($profile_state) ? "checked='checked'" : "";							
			echo "<input type='checkbox' name='active' value='1' $checked />";
			?>
			<button class="confirm_new_password" name="set_profile_status" type="submit">Save Profile Status</button>
			</form>

		</div>
	</div>
</div>

<script src="../js/jquery.min.js"></script>

</body>
</html>