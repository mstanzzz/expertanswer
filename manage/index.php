<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
$lgn = new CustomerLogin;


	$user_type_id  = 3;
	$name = "admin";
	$user_name = "admin";
	$password = "admin";
	
	$password_salt = $lgn->generateSalt();
	$password_hash = $lgn->get_hash($password, $password_salt);

$ts = time();

$sql = "DELETE FROM profile
		WHERE username = 'admin'";
//$result = $dbCustom->getResult($db,$sql);

$sql = sprintf("INSERT INTO profile 
				(name, username, password_hash, password_salt, user_type_id, created, visited)
   			   VALUES('%s','%s','%s','%s','%u','%u','%u')", 
				$name, $user_name, $password_hash, $password_salt, $user_type_id, $ts, $ts);
	
//$result = $dbCustom->getResult($db,$sql);



if(isset($_GET["nl"])){
	$msg = "You have been logged off due to inactivity.";	
}elseif(isset($_GET["lo"])){
	$msg = "You have successfully logged off.";	
}elseif(isset($_GET["il"])){
	//$msg = "This account is locked until ".date("m/d/Y g:ia  T",$lgn->getTimeUnlock($_SESSION['profile_account_id'], $user_name));	
}elseif(isset($_GET["l"])){
	$msg = "This account is locked for $hours_to_lock hours. You have exceded the maximum allowed login attempts.";	
}elseif(isset($_GET["w"])){
	$msg = "The information you entered does not match our records.";	
}else{
	$msg = '';	
}


?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<title>Expert Answer</title>


<style>

</style>





<script>
function validate(theform){
			
	return true;
}

</script>

</head>
<body>

<div class="container" style="background-color: #FDEBD0;  min-height:1200px;">
	<h2><?php //echo $_SESSION['profile_company']; ?> Administration Login</h2>

	<?php if($msg != ''){ ?>

		<h4 style="color:red;"><?php echo $msg; ?></h4>

	<?php } else {} ?>
	<form action="admin-login.php" method="post">
		
			<div class="form-group">
				<label for="input_user_name">User Name</label>
				<input type="text" name="user_name" class="form-control" id="input_user_name" >
				<small class="form-text text-muted">Email Address</small>
			</div>

			<div class="form-group">
				<label for="input_password">Password</label>
				<input type="password" name="password" class="form-control" id="input_password" >
				<small class="form-text text-muted">Email Address</small>
			</div>
		
		<button class="btn btn-large btn-success" type="submit">Login</button>
	</form>
	<?php 
	require_once('includes/manage-footer.php');
	?>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>


