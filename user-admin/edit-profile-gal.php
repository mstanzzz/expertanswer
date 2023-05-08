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
$id = (isset($_GET['id'])) ? $_GET['id'] : 0;


//print_r($_GET['id']);
//echo "<br />";
//echo $id;
//echo "<br />";

if(!is_numeric($id)) $id = 0;
$_SESSION['img_id'] = $id;	


$sql = "SELECT image.description  
		FROM image 
		WHERE image.id = '".$id."'";
$result = $dbCustom->getResult($db,$sql);

//echo "<br />";
//echo "num_rows ".$result->num_rows;
//exit;

if($result->num_rows > 0){
	$object = $result->fetch_object();
	$description = $object->description;
}else{
	$description = '';
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

<div class="container my-3 p-0">
<div class="d-flex justify-content-end">
<a class="btn btn-info" href="profile-gallery.php">
<i class="icon-arrow-left"></i> Back
</a>
</div>
</div>

<main class="container my-3 p-0">
<div class="card shadow-sm">
<div class="card-header">
Update Gallery Item
</div>
<div class="card-body">

<?php
if(!isset($_SESSION['img_id'])) $_SESSION['img_id'] = 0;

if($_SESSION['img_id'] > 0){
	$sql = "SELECT image.file_name
			FROM image, profile_to_img 
			WHERE image.id = profile_to_img.img_id
			AND profile_to_img.profile_id = '".$profile_id."'
			AND image.id = '".$_SESSION['img_id']."'";
	
	$sql = "SELECT file_name
			FROM image 
			WHERE id = '".$_SESSION['img_id']."'";
		
	
	$result = $dbCustom->getResult($db,$sql);
	

	
	if($result->num_rows > 0){
		$img_obj = $result->fetch_object();			
		$fn = "../saascustuploads/".$profile_id."/".$img_obj->file_name;			

		echo "<img id='pre_cropped' src='".$fn."' />";				

	}

}

$_SESSION['ret_dir'] = "user-admin";		
$_SESSION['ret_page'] = 'edit-profile-gal';
$_SESSION['img_type'] = 'gallery';
			
$url_str = "../upload/upload-pre-crop.php";
$url_str .= "?img_type=gallery";				
				
?>
<a href="<?php echo $url_str; ?>" class="btn btn-info btn-sm">
Upload Image
</a>

<form name="form" action="profile-gallery.php" method="post">
	<input id="id" type="hidden" name="img_id" value="<?php echo $_SESSION['img_id'];  ?>" />
	<input type="hidden" name="update_gal" value="1" />

	<div class="form-group">
		<label for="description">Description</label><br />
		<textarea class="form-control" name="description" 
		rows="8" cols="100"><?php echo $description; ?></textarea>
	</div>

	<div class="d-flex justify-content-end mt-3">
	<button class="btn btn-primary" name="edit_skill" type="submit">
		<i class="icon-ok"></i> Save </button>
	</div>

</form>
</div>		
</div>		
</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>

