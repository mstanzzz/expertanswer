<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(isset($_POST['from_google'])){

	$id = (isset($_POST['id']))? $_POST['id'] : 0;
	$name = (isset($_POST['name']))? $_POST['name'] : 0;
	$image = (isset($_POST['image']))? $_POST['image'] : 0;
	$email = (isset($_POST['email']))? $_POST['email'] : 0;
	
	if($lgn->login_google($email)){		
		$header_str =  "Location: user-admin-landing.php?msg=";
		header($header_str);		
	}else{
		$lgn->create_google_user($email, $name, $id);
		$header_str =  "Location: user-admin-landing.php?msg=";
		header($header_str);		
	}

}

$user_name = (isset($_POST["user_name"])) ? trim($_POST["user_name"]) : "";
$password = (isset($_POST["password"])) ? trim($_POST["password"]) : "";

if($lgn->login($user_name,$password)){	
	$header_str =  "Location: user-admin-landing.php?from=login"; 
}else{
	$header_str =  "Location: index.php?msg=na"; 
}

header($header_str);

?>
