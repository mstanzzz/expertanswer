<?php
if(!isset($real_root)){
	if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
		$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
	}else{
		$real_root = '..'; 	
	}
}

require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();


$page_title = "Change Password";

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";
	
if(isset($_POST['change_password'])){		

		//$current_password = trim(addslashes($_POST["current_password"]));
		$new_password = trim(addslashes($_POST["new_password"]));
		
		$lgn->resetPasswordById($new_password, $profile_id);
		
		$msg = "Your password has been re-set";
		
		/*
		if($lgn->varifyPassword($current_password, $username)){
			$lgn->resetPassword($new_password, $username);
			$msg = "Your password has been re-set";
		}else{
			$msg = "The current password given is not valid";			
		}
		*/
}

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Expert Answer</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

<style>

</style>

<script>
function validate(theform){
			
	return true;
}

</script>

</head>
<body style="background-color: #FFF1E5;">

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
	<div class="col-md-2">
		<?php
		require_once('includes/user-admin-nav.php');
		?>
	</div>
		
	<div class="col-md-10">
		<div style="margin-right:20px; margin-left:10px;">
			Change Password		
					
			<form name="form" action="profile-change-password.php" onsubmit="return validate()" method="post" enctype="multipart/form-data" class="pure-form">
			
			<div class="form-group">
				<label for="input_new_password">New Password</label>
				<input type="password" name="new_password" class="form-control" id="input_new_password" >
				<small class="form-text">Enter the link to your Twitter page.</small>
			</div>
			
			
			<div class="form-group">
				<label for="input_confirm_new_password">Confirm New Password</label>
				<input type="password" name="confirm_new_password" class="form-control" id="input_confirm_new_password" >
				<small class="form-text">Enter the link to your Twitter page.</small>
			</div>
			
			<button style="margin-left:15px;" type="submit" class="btn btn-primary" name="change_password">Change Password</button>
			</form>

		</div>
	</div>
</div>

<script src="../js/jquery.min.js"></script>

</body>
</html>