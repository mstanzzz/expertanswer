<?php


// lgn is initiated in manage-includes.php

//echo "isLogedIn=".$lgn->isLogedIn();

if(!$lgn->isLogedIn()){
	
	
	$_SESSION['profile_id'] = 0;
	unset($_SESSION['admin_access']);
	$lgn->logOut();
	
	
	if((strpos($_SERVER['REQUEST_URI'], "admin-login.php" ) === false)&&(strpos($_SERVER['REQUEST_URI'], "index.php" ) === false)){
		
		$header_str =  "Location: ".SITEROOT."/manage/index.php?nl";
		header($header_str);	

	}
}

?>