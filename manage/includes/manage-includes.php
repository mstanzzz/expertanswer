<?php

error_reporting(E_ALL);

require_once("../../includes/config.php"); 

require_once($real_root."/includes/class.admin_login.php");
require_once('../manage/includes/manage_functions.php');

$lgn = new CustomerLogin;
$module = new Module;
$admin_access = new AdminAccess;
require_once($real_root."/manage/includes/class.setup_progress.php");
require_once($real_root."/manage/includes/class.pages.php"); 
require_once($real_root."/includes/class.category.php"); 

?>