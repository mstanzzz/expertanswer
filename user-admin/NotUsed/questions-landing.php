<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();

$page_title = "Questions";

$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<link type="text/css" rel="stylesheet" href="../css/manageStyle.css" />

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  


</head>
<body style="background-color: #FFF1E5;">
<?php 
	require_once("includes/user-admin-header.php");
	require_once("includes/user-admin-top-nav.php");
?>
<div class="manage_page_container">
		<div class="manage_side_nav">
		<?php 
        require_once('includes/user-admin-nav.php');
        ?>
		</div>
		<div class="manage_main"> 
			
			<h1>Questions</h1>
			<div class="subnav_buttons">
				<ul>
					<li><a class="landingbtn designer" href="questions-all.php"><span>All Questions</span></a></li>
					<li><a class="landingbtn newquestions" href="questions-new.php"><span>New Questions</span></a></li>
				</ul>
			</div>
		</div>
		<p class="clear"></p>
	<?php 
	require_once("includes/user-admin-footer.php");
?>
</div>
</body>
</html>