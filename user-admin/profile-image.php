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

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";

if(isset($_GET['del_img_id'])){

	$id = $_GET["del_img_id"];
	if(!is_numeric($id)) $id = 0;	
		
	$sql = "SELECT image.file_name
			FROM image, profile_to_img 
			WHERE image.id = profile_to_img.img_id
			AND profile_to_img.profile_id = '".$profile_id."'
			AND image.id = '".$id."'";
	$result = $dbCustom->getResult($db,$sql);
		
	if($result->num_rows > 0){
		$img_obj = $result->fetch_object();			
			
		$fn_path = "../saascustuploads/profile/".$profile_id."/tmp/pre-crop/".$img_obj->file_name;			
		if(file_exists($fn_path)){
			unlink ($fn_path);
		}
			
		$fn_path = "../saascustuploads/profile/".$profile_id."/full/".$img_obj->file_name;			
		if(file_exists($fn_path)){
			unlink ($fn_path);
		}

		$fn_path = "../saascustuploads/profile/".$profile_id."/round/".$img_obj->file_name;			
		if(file_exists($fn_path)){
			unlink ($fn_path);
		}
			
		$fn_path = "../saascustuploads/profile/".$profile_id."/round/large/".$img_obj->file_name;			
		if(file_exists($fn_path)){
			unlink ($fn_path);
		}
			
		$fn_path = "../saascustuploads/profile/".$profile_id."/".$img_obj->file_name;			
		if(file_exists($fn_path)){
			unlink ($fn_path);
		}
			
		$sql ="DELETE FROM image WHERE id = '".$id."'";
		$result = $dbCustom->getResult($db,$sql);

		$sql ="DELETE FROM profile_to_img WHERE img_id = '".$id."'";
		$result = $dbCustom->getResult($db,$sql);

	}

	$msg = "Image deleted.";
}

if(isset($_POST['set_active'])){
	
	$img_id = (isset($_POST["img_id"]))? $_POST["img_id"] : 0;

	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
	$sql = "UPDATE profile_to_img SET active = '0' WHERE profile_id = '".$profile_id."'";
	$result = $dbCustom->getResult($db,$sql);

	foreach($actives as $key => $value){
		$sql = "UPDATE profile_to_img SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
	}
	$msg = "Changes Saved.";

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

<style>

</style>

</head>
<body style="background-color: #FFF1E5;">
<div style="margin:15px;">
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
		<div style="margin-left:15px;">		
			<form name="form" action="user-admin-landing.php" method="post">
			
				<?php
				$_SESSION['ret_dir'] = "user-admin";		
				$_SESSION['ret_page'] = 'profile-image';			
				$url_str = "../upload/upload-pre-crop.php";
				$url_str .= "?img_type=profile";
				
				?>
            
<a class="btn btn-info btn-sm" href="<?php echo $url_str; ?>" >Upload Profile Photo</a>
				
<button class="btn btn-primary btn-sm" type="submit" name="set_active">Set Actives</button>
				
				<br /><br />
			
				<table border="1" width="100%;">
						<tr>
							<td width="50%">&nbsp;</td>
							<td width="30%">Active</td>
							<td>Delete</th>
						</tr>
					<?php
					

					$sql = "SELECT 
							image.file_name
								,image.id
								,profile_to_img.active
								,profile_to_img.id AS pi_id 
							FROM profile_to_img, image 
							WHERE profile_to_img.img_id = image.id
							AND profile_to_img.profile_id = '".$profile_id."'"; 
					$result = $dbCustom->getResult($db,$sql);
					
					$num_rows = $result->num_rows;
					
					echo "num_images: ".$num_rows;

					
$block = "";
while($row = $result->fetch_object()) {

$block .= "<tr height='130px;'>";
						
$block .= "<td align='center'>";

$block .= SITEROOT."/saascustuploads/profile/".$profile_id."/round/".$row->file_name;
$block .= "<br />";
$block .= "<img src='".SITEROOT."/saascustuploads/profile/".$profile_id."/round/".$row->file_name."'  />";
$block .= "</td>";

$checked = ($row->active || $num_rows < 2)? "checked" : "";
						
$block .= "<td align='center'>";
$block .= "<div class='custom-control custom-switch'>";			
$block .= "<input type='radio' name='active[]' value='".$row->pi_id."'";
$block .= " class='custom-control-input' id='".$row->pi_id."' $checked>";
$block .= "<label class='custom-control-label' for='".$row->pi_id."'>Active</label>";	
$block .= "</div>";		
$block .= "</td>";	
						
$block .= "<td align='center'>";
$block .= "<a href='profile-image.php?del_img_id=".$row->id."' class='btn btn-danger btn-sm'>";
$block .= "Delete</a>";							
$block .= "</td>";

$block .= "</tr>";

}
echo $block;
?>

		


				</table>

			</form>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
