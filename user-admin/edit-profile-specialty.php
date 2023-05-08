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
$id = (isset($_GET['id'])) ? $_GET['id'] : '';

$sql = sprintf("SELECT * FROM specialty 
				WHERE id = '%u'", $id);
$result = $dbCustom->getResult($db,$sql);

if($result->num_rows > 0){
	$object = $result->fetch_object();
	$name = $object->name;
	$description = $object->description;
}else{
	$name = '';
	$description = '';
	
}

?>
<!doctype html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Expert Answer</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

<script>
function validate(theform){
			
	return true;
}

</script>

</head>
<body style="background-color: #FFF1E5;">
<body style="background-color: #FFF1E5;">
<div style="margin-left:15px;">
	<img height="40" src="<?php echo SITEROOT;?>/img/nat.png" />
	<?php
	echo "<span>Welcome  ".$lgn->getFullName()."<span>";
	echo "<span style='margin-left:30px; color:red; font-size:1.3em;'>".$msg."</span>";
	echo "<br />";
	require_once('includes/user-admin-nav.php');
	?>
</div>
<div style='clear:both;'></div>

<div class="row">
	<div class="col-md-12">
		<div style="margin-right:20px; margin-left:10px;">

		<center>
		Edit Specialty
		</center>
		
		<form name="form" action="profile-specialties.php" method="post" target="_top" class="pure-form">
       	<input id="id" type="hidden" name="id" value="<?php echo $id;  ?>" />

		<div class="pure-u-1 pure-u-lg-1-2" style="padding:6px;">
		<label>Name</label>
		<input type="text" name="name" value="<?php echo $name ?>" maxlength="250"  />
		</div>

		<div class="pure-u-1" style="padding:6px;">    				
		<label>Description</label><br />
		<textarea  name="description" rows="5" cols="50"><?php echo stripslashes($description); ?></textarea>
		</div>		
            
            
	<button class="btn btn-primary" style="width:200px;" name="edit_specialty" type="submit">Save Changes</button>
	
    </form>

</div>
</div>
</div>

<script src="../js/jquery.min.js"></script>
	
</body>
</html>
