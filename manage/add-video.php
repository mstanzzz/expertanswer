<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

<style>

</style>

</head>
<body>
<div style="margin-left:20px;">
	<img height="40" src="<?php echo SITEROOT;?>/img/nat.png" />
	<?php
	echo "<span>Welcome  ".$lgn->getFullName()."<span>";
	echo "<span style='margin-left:30px; color:red; font-size:1.3em;'>".$msg."</span>";
	echo "<br />";
	require_once('includes/manage-nav.php');
	?>
</div>
<div style="float:right; margin:30px;">
<a class="btn btn-info btn-sm" href="videos.php">Back</a></div>
<div style="clear:both;"></div>

<div class="row">		
	<div class="col-md-12">
		<div style="margin-left:15px;">		
		
			<center>
			<h3>Add Video Link</h3>
			</center>

			<form name="form" action="videos.php" method="post" >
			<input type="hidden" name="add_video" value="1" />
			<table width="100%" cellpadding="6">
			<tr>
			<td width="20%;">Title of Video</td>
			<td><input type="text" name="title" value="" maxlength="250" style="width:100%;"  /></td>
			</tr>
			
			<tr>
			<td>Url (copy from source like youtube or bitchute)</td>
			<td><input type="text" name="url" value="" maxlength="250"  style="width:100%;" /></td>
			</tr>

			<tr>
			<td></td>
			<td><button class="btn btn-primary" name="add" type="submit">ADD</button></td>
			</tr>
			
			</table>
						
			</form>
		
		</div>
	</div>
</div>


<br />
<br />
<br />
<br />

<script src="../js/jquery.min.js"></script>

</body>
</html>

