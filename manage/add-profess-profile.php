<?php
require_once('../includes/config.php');
require_once('../includes/class.profess.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/functions.php');
require_once('../includes/class.customer_login.php');
require_once('../manage/includes/manage_functions.php');
$lgn = new CustomerLogin;
$lgn = new CustomerLogin;
$prof = new Professional;

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';


	if(!isset($_SESSION['temp_page_fields']['profession'])) $_SESSION['temp_page_fields']['profession'] = 0;
	if(!isset($_SESSION['temp_page_fields']['active'])) $_SESSION['temp_page_fields']['active'] = 0;
	if(!isset($_SESSION['temp_page_fields']['bio'])) $_SESSION['temp_page_fields']['bio'] = '';
	if(!isset($_SESSION['temp_page_fields']['public_email'])) $_SESSION['temp_page_fields']['public_email'] = '';

	if(!isset($_SESSION['temp_page_fields']['private_email'])) $_SESSION['temp_page_fields']['private_email'] = '';
	
	if(!isset($_SESSION['temp_page_fields']['name'])) $_SESSION['temp_page_fields']['name'] = '';
	if(!isset($_SESSION['temp_page_fields']['company'])) $_SESSION['temp_page_fields']['company'] = '';
	if(!isset($_SESSION['temp_page_fields']['website'])) $_SESSION['temp_page_fields']['website'] = '';
	if(!isset($_SESSION['temp_page_fields']['address_one'])) $_SESSION['temp_page_fields']['address_one'] = '';
	if(!isset($_SESSION['temp_page_fields']['address_two'])) $_SESSION['temp_page_fields']['address_two'] = '';
	if(!isset($_SESSION['temp_page_fields']['city'])) $_SESSION['temp_page_fields']['city'] = '';	
	if(!isset($_SESSION['temp_page_fields']['state'])) $_SESSION['temp_page_fields']['state'] = '';
	if(!isset($_SESSION['temp_page_fields']['zip'])) $_SESSION['temp_page_fields']['zip'] = '';
	if(!isset($_SESSION['temp_page_fields']['country'])) $_SESSION['temp_page_fields']['country'] = '';
	if(!isset($_SESSION['temp_page_fields']['phone_one'])) $_SESSION['temp_page_fields']['phone_one'] = '';
	if(!isset($_SESSION['temp_page_fields']['phone_two'])) $_SESSION['temp_page_fields']['phone_two'] = '';
	if(!isset($_SESSION['temp_page_fields']['country'])) $_SESSION['temp_page_fields']['country'] = '';
	if(!isset($_SESSION['temp_page_fields']['about'])) $_SESSION['temp_page_fields']['about'] = '';
	if(!isset($_SESSION['temp_page_fields']['bio'])) $_SESSION['temp_page_fields']['bio'] = '';


?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Expert Answer</title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
<script src="../js/tinymce/tinymce.min.js"></script>

<script>
function validate(theform){
			
	return true;
}

</script>

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

<div class="row">		
	<div class="col-md-12">
		<div style="margin:10px;">
		
			<center>
			<h3>Add Profile</h3>
			</center>
        
			<form action="profess-profiles.php" method="post" enctype="multipart/form-data" class="pure-form">
			<div style="float:right; margin:20px;">    	
				<button name="add_profile" type="submit" class="btn btn-primary"> Save </button>
			</div>
				
			<table width="100%">
			<tr>
			<td width="10%">Name</td>
			<td><input id="name" name="name" value="<?php echo stripslashes($_SESSION['temp_page_fields']['name']); ?>" type="text"></td>
			</tr>
				
			<tr>
			<td>Public Email</td>
			<td><input id="public_email" name="public_email" value="<?php echo $_SESSION['temp_page_fields']['public_email']; ?>" type="email"></td>
			</tr>

			<tr>
			<td>Private Email</td>
			<td><input id="public_email" name="private_email" value="<?php echo $_SESSION['temp_page_fields']['private_email']; ?>" type="email"></td>
			</tr>

			<tr>
			<td>Company</td>
			<td><input id="company" name="company" value="<?php echo $_SESSION['temp_page_fields']['company']; ?>" type="text"></td>
			</tr>
				
			<tr>
			<td>Website</td>
			<td><input id="website" name="website" value="<?php echo $_SESSION['temp_page_fields']['website']; ?>" type="text"></td>
			</tr>
				
			<tr>
			<td>Address one</td>
			<td><input id="address_one" name="address_one" value="<?php echo $_SESSION['temp_page_fields']['address_one']; ?>" type="text"></td>
			</tr>

			<tr>
			<td>Address two</td>
			<td><input id="address_two" name="address_two" value="<?php echo $_SESSION['temp_page_fields']['address_two']; ?>" type="text"></td>
			</tr>

			<tr>
			<td>City</td>
			<td><input id="city" name="city" value="<?php echo $_SESSION['temp_page_fields']['city']; ?>" type="text"></td>
			</tr>

			<tr>
			<td>State</td>
			<td><input id="state" name="state" value="<?php echo $_SESSION['temp_page_fields']['state']; ?>" type="text"></td>
			</tr>

			<tr>
			<td>Zip</td>
			<td><input id="zip" name="zip" value="<?php echo $_SESSION['temp_page_fields']['zip']; ?>" type="text"></td>
			</tr>

			<tr>
			<td>Country</td>
			<td><input id="country" name="country" value="<?php echo $_SESSION['temp_page_fields']['country']; ?>" type="text"></td>
			</tr>

			<tr>
			<td>Phone one</td>
			<td><input id="phone_one" name="phone_one" value="<?php echo $_SESSION['temp_page_fields']['phone_one']; ?>" type="text"></td>
			</tr>

			<tr>
			<td>Phone two</td>
			<td><input id="phone_two" name="phone_two" value="<?php echo $_SESSION['temp_page_fields']['phone_two']; ?>" type="text"></td>
			</tr>

			<tr>
			<td>About</td>
			<td>
			<textarea  name="about" style="width:100%; height:210px;"><?php echo $_SESSION['temp_page_fields']['about']; ?></textarea>
			</td>
			</tr>

			<tr>
			<td>Bio</td>
			<td>
			<textarea  name="bio" style="width:100%; height:210px;"><?php echo $_SESSION['temp_page_fields']['bio']; ?></textarea>
			</td>
			</tr>
			</table>

		</form>

		</div>
	</div>
</div>

<div style="width:100%; height:200px;">&nbsp;</div>	

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>


