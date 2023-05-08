<?php

if((!$lgn->isLogedIn())){
	
	if((strpos($_SERVER['REQUEST_URI'], "login.php" ) === false)&&(strpos($_SERVER['REQUEST_URI'], "index.php" ) === false)){
		
		$header_str =  "Location: ".SITEROOT."/user-admin/index.php?msg=Your session has timed out for your security. To continue, plese log in";
		header($header_str);	

	}
}

?>

