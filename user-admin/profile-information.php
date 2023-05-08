<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
require_once('../includes/class.profess.php');
$prof = new Professional;
$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();


$sql = "SELECT *
		FROM profile 
		WHERE id = '".$profile_id."'";
$result = $dbCustom->getResult($db,$sql);
if($result->num_rows > 0){
	$obj = $result->fetch_object();	
	$bio = $obj->bio;
	$name = $obj->name;
	$company = $obj->company; 
	$website = $obj->website;	
	$public_email = $obj->public_email;
	$private_email = $obj->private_email;
	$phone_one = $obj->phone_one;
	$phone_two = $obj->phone_two;
	$address_one = $obj->address_one;
	$address_two = $obj->address_two;
	$zip = $obj->zip;
	$profession = $obj->profession;	
}else{
	$bio = '';
	$name = '';
	$company = ''; 
	$website = '';	
	$public_email = '';
	$private_email = '';
	$phone_one = '';
	$phone_two = '';
	$address_one = '';
	$address_two = '';
	$zip = '';
	$profession = '';	
}


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="icon" 
			type="image/png" 
			href="<?php echo "../favicon.png"; ?>" >

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Expert Answer</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
	
	</head>

	<body style="background-color: #FFF1E5;">
		<?php
			require_once('includes/user-admin-nav.php');
		?>



		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">ABOUT YOU</div>
				<div class="card-body">

				
<form name="form" action="user-admin-landing.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="update_profile" value="1">
	<input type="hidden" name="address_one" />
	<input type="hidden" name="address_two" />
	<div class="d-flex justify-content-end">
	<button type="submit" class="btn btn-sm btn-primary"><i class="icon-ok"></i> Submit Changes</button>
	</div>
	<div class="form-group mt-3">
		<label for="input_bio">Your Bio</label>
		<textarea class="form-control" name="bio" id="input_bio" rows="4"><?php echo $bio; ?></textarea>
	</div>
	<div class="row">
	<div class="col-md-6 form-group">
		<label for="input_name">Name or Alias</label>
		<input type="text" name="name" value="<?php echo $name; ?>" class="form-control" id="input_name" >
		<small class="form-text">This your name and will be visable to the public.</small>
	</div>
	<div class="col-md-6 form-group">
		<label for="input_company">Company</label>
		<input type="text" name="company" value="<?php echo $company; ?>" class="form-control" id="input_company" >
		<small class="form-text">This your company name and will be visable to the public.</small>
	</div>
	</div>
	<div class="row">							
	<div class="col-md-6 form-group">
		<label for="input_website">Website</label>
		<input type="url" name="url" value="<?php echo $website; ?>" class="form-control" id="input_website" >
		<small class="form-text">This your website address and will be visable to the public.</small>
	</div>
	<div class="col-md-6 form-group">
		<label for="input_profession">Area of Expertise / Profession / Occupation</label>
		<input type="text" name="profession" value="<?php echo $profession; ?>" class="form-control" id="input_profession" >
		<small class="form-text">This is what you do or know and will be visable to the public.</small>
	</div>
	</div>
	<div class="row">
	<div class="col-md-6 form-group">
		<label for="input_public_email">Public Email Address</label>
		<input type="email" name="public_email" value="<?php echo $public_email; ?>" class="form-control" id="input_public_email" >
		<small class="form-text">This email will be visable to the public.</small>
	</div>
	<div class="col-md-6 form-group">
		<label for="input_private_email">Private Email Address</label>
		<input type="email" name="private_email" value="<?php echo $private_email; ?>" class="form-control" id="input_private_email">
		<small class="form-text">We'll never share your email with anyone else.</small>
	</div>
	</div>
	<div class="row">
	<div class="col-md-4 form-group">
		<label for="input_phone_one">Phone Number</label>
		<input type="text" name="phone_one" value="<?php echo $phone_one; ?>" class="form-control" id="input_phone_one">
		<small class="form-text">This is your phone number visable to the public.</small>
	</div>
	<div class="col-md-4 form-group">
		<label for="input_phone_two">Alt Phone Number</label>
		<input type="text" name="phone_two" value="<?php echo $phone_two; ?>" class="form-control" id="input_phone_two">
		<small class="form-text">This is your alternate phone number visable to the public.</small>
	</div>
	<div class="col-md-4 form-group">
		<label for="input_zip">Zip Code</label>
		<input type="text" name="zip" value="<?php echo $zip; ?>" class="form-control" id="input_zip">
		<small class="form-text">This is your zip code visable to the public.</small>
	</div>
	</div>
	<div class="d-flex justify-content-end mt-5">
		<button type="submit" class="btn btn-sm btn-primary"><i class="icon-ok"></i> Submit Changes</button>
	</div>
</form>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

		<script>
			let activeNav="profile-info";
		</script>

		<?php
			require_once('navbar-effect.php');
		?>

	</body>
</html>






