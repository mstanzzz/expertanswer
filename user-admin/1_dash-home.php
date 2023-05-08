<?php
if(!isset($real_root)){
	if(strpos($_SERVER['REQUEST_URI'], 'expertnat/' )){    
		$real_root = $_SERVER['DOCUMENT_ROOT'].'/expertnat'; 
	}else{
		$real_root = '..'; 	
	}
}
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

$from = (isset($_GET['from'])) ? $_GET['from'] : ''; 
$li = (isset($_GET['li'])) ? $_GET['li'] : '';

$thr = (isset($_GET['thr'])) ? $_GET['thr'] : 999;

if($lgn->isLogedIn() == 0){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
	
}

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

?>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="description" content="ORDER FULFILLMENT DASHBOARD_MAIN PAGE_FULL">
    <title>MAIN DASHBOARD</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/base.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/personal-style.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/orders-style.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/media-query.css">
	<link rel="stylesheet" type="text/css" href="./admin-style/style_MS.css">

</head>

<body style="background-color: #FFF1E5;">
<div class="content-container">
  
	<?php
	$ln_active = '';
	require_once('left_nav.php');
	?>
		


</div>


</body>
</html>



