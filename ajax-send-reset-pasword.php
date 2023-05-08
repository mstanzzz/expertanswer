<?php 
require_once('includes/config.php'); 
require_once('includes/class.customer_login.php');
$lgn = new CustomerLogin;

if(!isset($site)) $site = 'live';

if($site == 'live'){
	$domain = 'http://www.Expert Answer.com';
}else{
	$domain = 'http://localhost/Expert Answer';
}

$email_addr = (isset($_GET["email_addr"]))? trim($_GET["email_addr"]) : '';

$ret = "n";

if($email_addr != ''){
	
	$sql = "SELECT password_salt FROM profile 
	 		WHERE username = '".$email_addr."' ";

	$result = $dbCustom->getResult($db,$sql);
	
	if($result->num_rows > 0){

		$object = $result->fetch_object();
		
		$link = $domain."/reset-password.php?ps=".$object->password_salt;
		
		$message= '';
		$message.= "Thank you for using Expert Answer";
		$message.= "\n\n\r To re-set your password,"; 
		$message.= "click this link or paste it into your web browser";
		$message.= "\n\n\r";
		$message.= $link;
		$message.= "\n\n\r";
		$message.= "\n\n\r NOTE: please check your spam folder";

		$subject = "Expert Answer Password Request";		

		//$headers = "From: mark@nazardesigns.com";
		$headers = "From: admin@Expert Answer.com";
		$headers .= "\r\n";
		//$headers .= "Content-type: text/html"; 
		//$headers .= "\r\n";
		$headers .= "CC: mark@nazardesigns.com";

		$to = $email_addr;		
		//$to = "mark.stanz@gmail.com";
		error_reporting(0);
		if(mail($to, $subject, $message, $headers)){
			$ret = 'y';
		}else{
			
			
		}
	}
}

echo $ret;

//echo $email_addr;

?>
