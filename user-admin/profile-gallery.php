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

if(isset($_POST['update_gal'])){
	
	$description = (isset($_POST['description'])) ? addslashes($_POST['description']) : ''; 
	$img_id = (isset($_POST['img_id'])) ? $_POST['img_id'] : 0; 
	if(!is_numeric($img_id)) $img_id = 0;
	
	$stmt = $db->prepare("UPDATE image 
							SET description = ?
							WHERE id = ?"); 
		//echo 'Error-1 UPDATE   '.$db->error;
	if(!$stmt->bind_param("si",
					$description, $img_id)){		
		echo 'Error-2 UPDATE   '.$db->error;			
	}else{
		$stmt->execute();
		$stmt->close();
		$msg = "Your changes have been saved.";

	}

	$sql = "SELECT id 
			FROM profile_to_img
			WHERE img_id = '".$img_id."'
			AND profile_id = '".$profile_id."'";
	$result = $dbCustom->getResult($db,$sql);
	if($result->num_rows < 1){
		
		$sql = "INSERT INTO profile_to_img
				(img_id, profile_id)
				VALUES
				('".$img_id."', '".$profile_id."')";
		$res = $dbCustom->getResult($db,$sql);		
	}else{

		
	}
/*	
	echo $result->num_rows;
	echo "<br />";
	echo "img_id ".$img_id;
	echo "<br />";	
	echo "<hr />";
	echo "<br />";
	echo "<br />";
*/	



}



if(isset($_POST['add_gal'])){
	
	$description = (isset($_POST['description'])) ? addslashes($_POST['description']) : ''; 
	$img_id = (isset($_POST['img_id'])) ? $_POST['img_id'] : 0; 
	if(!is_numeric($img_id)) $img_id = 0;
		$stmt = $db->prepare("UPDATE image
						SET description = ?
					WHERE id = ?"); 
		//echo 'Error-1 UPDATE   '.$db->error;
	if(!$stmt->bind_param("si",
					$description, $img_id)){		
		echo 'Error-2 UPDATE   '.$db->error;			
	}else{
		$stmt->execute();
		$stmt->close();
		$msg = "Your changes have been saved.";

	}
	
		
	$sql = "INSERT INTO profile_to_img
			(img_id, profile_id)
			VALUES
			('".$img_id."', '".$profile_id."')";
	$result = $dbCustom->getResult($db,$sql);

	
	
}



//echo $_GET['del_id'];
//exit;


if(isset($_GET['del_id'])){

	$id = $_GET["del_id"];
	if(!is_numeric($id)) $id = 0;	


	$sql = "SELECT image.file_name
		FROM image
		WHERE image.id = '".$id."'";
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


		$fn_path = "../saascustuploads/profile/".$profile_id."/".$img_obj->file_name;			
		if(file_exists($fn_path)){
		unlink ($fn_path);
		}


		$sql ="DELETE FROM image WHERE id = '".$id."'";
		$result = $dbCustom->getResult($db,$sql);

		$sql ="DELETE FROM profile_to_img WHERE img_id = '".$id."'";
		$result = $dbCustom->getResult($db,$sql);

	}


	$msg = "";
}


/*

$sql = "DELETE  
		FROM image
		WHERE id > 0 ";
$r = $dbCustom->getResult($db,$sql);
$sql = "DELETE  
		FROM profile_to_img
		WHERE id > 0 ";
$r = $dbCustom->getResult($db,$sql);

 */


//gallery
$gal_array = array();


$sql = "SELECT image.file_name
				,image.id
		FROM image, profile_to_img 
		WHERE image.id = profile_to_img.img_id
		AND profile_to_img.profile_id = '".$profile_id."'
		AND image.slug LIKE '%aller%'";

$sql = "SELECT image.id as img_id
		,file_name 
		FROM image, profile_to_img
		WHERE image.id = profile_to_img.img_id
		AND profile_to_img.profile_id = '".$profile_id."'
		AND image.slug LIKE '%aller%'";
		

$result = $dbCustom->getResult($db,$sql);

$i = 0;

while($row = $result->fetch_object()){	

	$gal_array[$i]['file_name'] = $row->file_name;	
	$gal_array[$i]['img_id'] = $row->img_id;	
	$i++;	
}

//print_r($gal_array);
//exit;
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
	<div class="card-header">GALLERY</div>
	<div class="card-body">
		<div class="d-flex justify-content-end">
			<div class="ml-3">
			<a class="btn btn-info btn-sm" href="add-profile-gal.php">
			<i class="icon-plus"></i> Add a New Gallery Item
			</a>
			</div>
		</div>
		<div class="card mt-3 shadow-sm">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table" id="table">
					<thead>
					<tr class="table-secondary">
					<th>Image</th>
					<th width="10%">Edit</th>
					<th width="10%">Delete</th>
					</tr>
					</thead>
					<tbody>
<?php

$block = '';
foreach($gal_array as $val){

	
	$fn_path = "../saascustuploads/".$profile_id."/".$val['file_name'];
	
	$block .= "<tr>";
	$block .= "<td>";
	$block .= "<a data-fancybox='gallery' href='".$fn_path."'>";
	$block .= "<img width='200' class='fancybox' src='".$fn_path."'>";
	$block .= "</a>";
	$block .= "</td>";	
	$block .= "<td>";
	$block .= "<a class='btn btn-info btn-sm'"; 
	$block .= "href='edit-profile-gal.php?id=".$val['img_id']."'>";
	$block .= "<i class='icon-eye-open'></i> Edit";
	$block .= "</a>";
	$block .= "</td>";

	$block .= "<td>";
	$block .= "<a class='btn btn-danger btn-sm'"; 
	$block .= "href='profile-gallery.php?del_id=".$val['img_id']."'>";
	$block .= "<i class='icon-minus-sign'></i> Delete";
	$block .= "</a>";
	$block .= "</td>";

	$block .= "</tr>";
}

echo $block;

?>			
</tbody>
</table>


</div>
</div>
</div>
</div>
</div>

</main>

<!--
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
-->

<!--

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
-->

</body>
</html>
