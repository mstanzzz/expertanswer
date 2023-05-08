<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

$ts = time();
$msg = '';

$username = (isset($_POST["user_name"])) ? trim(addslashes($_POST["user_name"])) : '';
$password = (isset($_POST["password"])) ? trim(addslashes($_POST["password"])) : '';

$in = 0;

if($lgn->login($username,$password)){

	if($username == 'admin' || $username == 'mark.stanz@gmail.com'){
		
		$in = 1;
				
		$header_str =  "Location: start.php?l=1";
		header($header_str);			
	}

}

if($in == 0){
		$header_str =  "Location: index.php?w=1";
		header($header_str);			
}


?>