<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}

require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
//require_once("includes/class.setup_progress.php");
	
	
//echo $real_root;	
	
	
$lgn = new CustomerLogin;
	
//$progress = new SetupProgress;
	
$page_title = "Master Administion";

$msg = '';
	
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
			<h1>Add Credential</h1>

			<form name="form" action="edit-profess-profile.php" method="post" target="_top" class="pure-form">
				<input type="hidden" name="add_credential" value="1" />
				<table>
				<tr>
				<td>Name</td>
				<td><input type="text" name="name" value="" maxlength="250"  /></td>
				<tr>
				
				<tr>
				<td>Institution</td>
				<td><input type="text" name="institution" value="" maxlength="250"  /></td>
				<tr>

				<tr>
				<td>Description</td>
				<td>
				<textarea  name="description" rows="5" cols="90"></textarea>
				</td>
				<tr>

				<tr>
				<td></td>
				<td>
				<button style="width:200px;" name="add" type="submit">Add Credential</button>
				</td>
				<tr>

				<table>
			</form>
			
			<br />
			<a href="edit-profess-profile.php">Cancel</a>    

		</div>			
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


</body>
</html>
