<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
require_once('../includes/class.profess.php');

$lgn = new CustomerLogin;
if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$prof = new Professional;

$profile_id = $lgn->getProfileId();

//$name = $prof->getProfName($profile_id);

$name = 'New User';

$sql = "SELECT name						
		FROM profile  
	 	WHERE id = '".$profile_id."'";		
$result = $dbCustom->getResult($db,$sql);			
if($result->num_rows){
	$object = $result->fetch_object();
	$name = $object->name;
}



$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$thr = (isset($_GET['thr'])) ? $_GET['thr'] : 0;
if($thr == 365){

	$email_addr = $lgn->getUserName();
	
	$link = "https://www.expertanswer.org/";

	$message = '';
	$message.= "Thank you for joining Expert Answer";
	$message.= "\n\n\r If you haven't completed your setup, please sign in"; 
	$message.= "\n\n\r";
	$message.= $link;
	$message.= "\n\n\r";
	$subject = "Your Expert Answer Profile";		

	//$headers = "From: mark@nazardesigns.com";
	$headers = "From: admin@expertnat.com";
	//$headers .= "\r\n";
	//$headers .= "CC: mark@nazardesigns.com";

	$to = $email_addr;		
	error_reporting(0);
	if(mail($to, $subject, $message, $headers)){

	}else{
				
	}

	

}


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

		$fn_path = "../saascustuploads/profile/tmp/".$img_obj->file_name;			
		if(file_exists($fn_path)){
			unlink ($fn_path);
		}
			
		$fn_path = "../saascustuploads/profile/tmp/pre-crop/".$img_obj->file_name;			
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


if(isset($_POST['update_profile'])){
	
	$bio = (isset($_POST['bio']))? trim(addslashes($_POST['bio'])) : '';
	$name = (isset($_POST['name']))? trim(addslashes($_POST['name'])) : '';
	$company = (isset($_POST['company']))? trim(addslashes($_POST['company'])) : '';
	$website = (isset($_POST['website']))? trim(addslashes($_POST['website'])) : '';
	$profession = (isset($_POST['profession']))? trim(addslashes($_POST['profession'])) : '';
	$public_email = (isset($_POST['public_email']))? trim(addslashes($_POST['public_email'])) : '';
	$private_email = (isset($_POST['private_email']))? trim(addslashes($_POST['private_email'])) : '';	
	$phone_one = (isset($_POST['phone_one']))? trim(addslashes($_POST['phone_one'])) : '';
	$phone_two = (isset($_POST['phone_two']))? trim(addslashes($_POST['phone_two'])) : '';
	$address_one = (isset($_POST['address_one']))? trim(addslashes($_POST['address_one'])) : '';
	$address_two = (isset($_POST['address_two']))? trim(addslashes($_POST['address_two'])) : '';
	$zip = (isset($_POST['zip']))? trim(addslashes($_POST['zip'])) : '';
	
	
	
	
	
	$stmt = $db->prepare("UPDATE profile
						SET bio = ?
						,name = ?
						,company = ? 
						,website = ?	
						,public_email = ?
						,private_email = ?
						,phone_one = ?
						,phone_two = ?
						,address_one = ?
						,address_two = ?
						,zip = ?
						,profession = ?
					WHERE id = ?"); 
								
		//echo 'Error-1 UPDATE   '.$db->error;



								
	if(!$stmt->bind_param("ssssssssssssi",
					$bio
					,$name
					,$company
					,$website
					,$public_email
					,$private_email
					,$phone_one
					,$phone_two
					,$address_one
					,$address_two
					,$zip
					,$profession
					,$profile_id)){		
		
		echo 'Error-2 UPDATE   '.$db->error;
					
	}else{
		$stmt->execute();
		$stmt->close();
		$msg = "Your changes have been saved.";

	}
}




/*
if(isset($_POST['set_active'])){
	$img_id = (isset($_POST["img_id"]))? $_POST["img_id"] : 0;
	$name = (isset($_POST['name']))? $_POST['name'] : array();
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	$stmt = $db->prepare("UPDATE profile
						SET name = ?
					WHERE id = ?"); 
	echo 'Error-1 UPDATE   '.$db->error;
	if(!$stmt->bind_param("si",
					$name
					,$profile_id)){		
	echo 'Error-2 UPDATE   '.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
						
		$msg = "Your changes have been saved.";
	}
	$sql = "UPDATE profile_to_img SET active = '0' WHERE profile_id = '".$profile_id."'";
	$result = $dbCustom->getResult($db,$sql);
	foreach($actives as $key => $value){
		$sql = "UPDATE profile_to_img SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
	}
	$prof_active = isset($_POST['prof_active'])? 1 : 0;
	$prof->setProfIsActive($lgn->getProfileId(), $prof_active);
	$msg = "Changes Saved.";
}
*/

if(isset($_POST['set_active'])){
	$name = (isset($_POST['name']))? $_POST['name'] : array();
	$stmt = $db->prepare("UPDATE profile
						SET name = ?
					WHERE id = ?"); 
		//echo 'Error-1 UPDATE   '.$db->error;
	if(!$stmt->bind_param("si",
					$name
					,$profile_id)){		
		//echo 'Error-2 UPDATE   '.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
						
		$msg = "Your changes have been saved.";
	}
	
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
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
function validate(){
}
</script>
</head>

<body style="background-color: #FFF1E5;">
<?php
require_once('includes/user-admin-nav.php');
?>

<main class="container my-3 p-0">
	<div class="card shadow-sm">
		<div class="card-header">My Admin Dashboard</div>
			<div class="card-body">
				<form name="form_1" action="user-admin-landing.php" method="post" enctype="multipart/form-data">
				
				<div class="d-flex justify-content-end">
					<button class="btn btn-primary" type="submit" name="set_active">
					<i class="icon-ok"></i> Save Changes
					</button>
				</div>

				<div class="row">									
					<div class="col-md-8" style="padding-right:30px;">
						<label for="input_name">Name</label>
<input type="text" name="name" value="<?php echo stripslashes($name); ?>" class="form-control" id="input_name" >
						<small class="form-text">This name will be visable to the public.</small>
					</div>
				</div>

				<div class="row">		
					<div class="col-md-12" style="padding-left:30px; padding-right:30px;">
<?php
$_SESSION['ret_dir'] = "user-admin";		
$_SESSION['ret_page'] = 'user-admin-landing';
$_SESSION['img_type'] = 'profile';
						
$url_str = "../upload/upload-pre-crop.php";
$url_str .= "?img_type=profile";
?>
<div class="d-flex justify-content-end mt-5">           
<a class="btn btn-info" href="<?php echo $url_str; ?>" >
<i class="icon-cloud-upload"></i> Upload Profile Photo or Custom Avatar</a>
</div>
		            
					</div>
				</div>

			<?php

			$sql = "SELECT file_name
					FROM profile_to_img, image 
					WHERE profile_to_img.img_id = image.id
					AND image.slug LIKE '%profile%'
					AND profile_to_img.profile_id = '".$profile_id."'"; 
			$result = $dbCustom->getResult($db,$sql);					
			if($result->num_rows > 0){
				$object = $result->fetch_object(); 
				$file_name = $object->file_name;
				echo "<img src='../saascustuploads/".$profile_id."/round/".$file_name."'  />";			
			}else{
				$file_name = '';
			}				
			?>
			</form>
		</div>
	</div>
</main>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
let activeNav="admin-landing";
</script>

<?php
require_once('navbar-effect.php');
?>

</body>
</html>

