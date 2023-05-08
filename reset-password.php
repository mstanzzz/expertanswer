<?php 
require_once('includes/config.php'); 
require_once('includes/class.customer_login.php');
$lgn = new CustomerLogin;

$msg =  (isset($_GET['msg'])) ? $_GET['msg'] : '';

if(isset($_POST['password_salt'])){
		
	$password = trim(addslashes($_POST['password']));
	$password_salt = trim($_POST['password_salt']);
	
	$sql = "SELECT id FROM profile 
			WHERE password_salt = '".$password_salt."' ";
				
	$result = $dbCustom->getResult($db,$sql);
		
	$object = $result->fetch_object();
	
	if($result->num_rows > 0){
			
		$new_password_salt = $lgn->generateSalt();
		$password_hash = $lgn->get_hash($password, $new_password_salt);
		$sql = "UPDATE profile 
				SET password_salt = '".$new_password_salt."'
				,password_hash = '".$password_hash."' 
				WHERE id = '".$object->id."'";
		$result = $dbCustom->getResult($db,$sql);
			
		$msg = "Your password has been re-set";
	}else{
		$msg

		= "";
	}
}

$password_salt = (isset($_GET["ps"]))? trim($_GET["ps"]) : ''; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ExpertNat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">


</head>
<body>

<?php

echo "<center>";
echo "<div style='background-color:#8FD0D2; min-width:500px; width:50%; height:60px; padding-top:40px;'>";
echo "<div style='color:blue;'>".$msg."</div>";  
echo "</div>";
echo "</center>";	
	
if($password_salt == ''){
	echo "<center>";
	echo "<br /><a class='btn btn-info' href='".SITEROOT."'>Continue</a>";	
	echo "</center>";			
}else{
?>

<center>
<div style="background-color:#8FD0D2; min-width:500px; width:50%; height:360px; padding-top:60px;">

<form action="<?php echo SITEROOT; ?>/reset-password.php" 
		method="post" enctype="multipart/form-data" onSubmit="return is_valid_lenth();">
	
	<input type="hidden" name="password_salt" value="<?php echo $password_salt; ?>" />

	<div style="color:red;" id="invalid-msg"></div>		
				
	<div style="font-size:1.1em">Enter your new password</div>

	<input style="width:300px; height:32px; margin-left:-16px;" 
	type="password" name="password" id="input_password">
	
	<div style="font-size:0.9em; margin-top:16px;">
		Your password must be 6-20 characters.
	</div>	
	<div style="margin-top:16px;">
		<input class="btn btn-success" type="submit" value="Submit" />
	</div>	

<span style="cursor:pointer; position:relative; top:-123px; left:120px;" 
onclick="show_this_password();">
<img src="images/cartoon-eye.png"
</span>

</form>

</div>
</center>
	

<?php 
} 
?>

<script>

function is_valid_lenth(){	
	var str = document.getElementById("input_password").value;
	var x = document.getElementById("invalid-msg");
	var n = str.length;	
	if(n < 6){
		x.innerHTML = "Please use at least 6 characters";
		return false;
	}
	
	return true;
	
	//alert(n);
	
}

function show_this_password(){
	
	var x = document.getElementById("input_password");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}
}
</script>
    
</body>
</html>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

