<?php
//if(strpos($_SERVER['SCRIPT_URI'], 'xpertansw') !== false ){    
	
	$site = 'live';
//}else{
	//$site = 'local';
//}
/*
if($site == "live"){
	header("Location: https://www.musicradar.com/");
	die();
}
*/

// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 7200);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(7200);
if(!session_id()){
	session_start();
}
$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}

// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 7200;

date_default_timezone_set('America/Vancouver');

error_reporting(E_ALL);
ini_set('display_errors','On');


//echo $site;	
//echo "<br />";
//phpinfo();
//exit;

if($site == "local"){


	//define('DB_HOST', 'localhost');
	define('DB_HOST', '127.0.0.1');	
	//define('DB_HOST', 'localhost:8080');	
	//define('DB_HOST', '127.0.0.1:8080');	
	//define('DB_HOST', 'localhost:3306');	
	
	
	define('DB_USERNAME', 'root');
	//define('DB_USERNAME', 'mstanzzz');
	
	define('DB_PSWD', '');
	define('EXPERT_DATABASE', 'weareexperts');
	define("SITEROOT", "http://localhost/");
	
	
	
}else{

	define("DB_HOST", "208.109.41.235");
	
	define('DB_USERNAME', 'mstanzzz');
	define('DB_PSWD', 'nathannn1A@@');
	define('EXPERT_DATABASE', 'weareexperts');	
	define("SITEROOT", "https://www.expertanswer.org");
	
	
	
}


$_SESSION['profile_company'] = 'We Are Experts';
$_SESSION['profile_account_id'] = 1;
require_once('class.dbcustom.php');


$dbCustom = new DbCustom();





$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

if(!isset($_SESSION['ip'])) $_SESSION['ip'] = 0;

$ts = time();
$ip = getRealIP();




if($_SESSION['ip'] != $ip){

	$_SESSION['ip'] = $ip;

	$sql = "INSERT INTO hit
			(ip, when_hit)
			VALUES
			('".$ip."', '".$ts."')";
	$result = $dbCustom->getResult($db,$sql);
}

function getRealIP() {
	$ipaddress = '';
	if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
		$ipaddress =  $_SERVER['HTTP_CF_CONNECTING_IP'];		
		//echo "HTTP_CF_CONNECTING_IP";
		//echo "<br />"; 	
	}else if(isset($_SERVER['HTTP_X_REAL_IP'])) {
		$ipaddress = $_SERVER['HTTP_X_REAL_IP'];
		//echo "HTTP_X_REAL_IP";
		//echo "<br />"; 
	}else if(isset($_SERVER['HTTP_CLIENT_IP'])){
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		//echo "HTTP_CLIENT_IP";
		//echo "<br />"; 
	}else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		//echo "HTTP_X_FORWARDED_FOR";
		//echo "<br />"; 
	}else if(isset($_SERVER['HTTP_X_FORWARDED'])){
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		//echo "HTTP_X_FORWARDED";
		//echo "<br />"; 
	}else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		//echo "HTTP_X_FORWARDED";
		//echo "<br />"; 
	}else if(isset($_SERVER['HTTP_FORWARDED'])){
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
		//echo "HTTP_X_FORWARDED";
		//echo "<br />"; 
	}else if(isset($_SERVER['REMOTE_ADDR'])){
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		//echo "REMOTE_ADDR";
		//echo "<br />"; 
	}else{
		$ipaddress = 'UNKNOWN';
		//echo "UNKNOWN";
		//echo "<br />"; 
	}
	return $ipaddress;
}





?>