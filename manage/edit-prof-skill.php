<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}

require_once($real_root.'/includes/config.php'); 
require_once($real_root.'/includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();

$page_title = 'Edit Skill';

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;


$sql = sprintf("SELECT * FROM skill 
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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

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
	require_once("includes/manage-nav.php");
	?>
</div>

<div class="row">		
	<div class="col-md-12">
		<div style="margin:10px;">

			<center>
			<h3>Edit Skill</h3>
			</center>



			<form name="form" action="edit-profess-profile.php" method="post" target="_top" class="pure-form">
			<input id="id" type="hidden" name="id" value="<?php echo $id;  ?>" />
			<input type="hidden" name="edit_skill" value="1" />

			<div class="pure-u-1 pure-u-lg-1-2" style="padding:6px;">
			<label>Name</label>
			<input type="text" name="name" value="<?php echo $name ?>" maxlength="250"  />
			</div>

			<div class="pure-u-1" style="padding:6px;">    				
			<label>Description</label><br />
			<textarea  name="description" rows="5" cols="90"><?php echo stripslashes($description); ?></textarea>
			</div>		
            
					
			<button class="pure-button pure-button-primary" style="width:200px;" name="edit" type="submit">Save Changes</button>
			
			</form>
			
			<br />
			<a class="pure-button button-secondary" href="edit-profess-profile.php">Cancel</a>    
    
		</div>
	</div>    
</div>    
            
<br />
<br />
<br />
<br />

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
