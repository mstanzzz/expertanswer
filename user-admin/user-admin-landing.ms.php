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

$name = $prof->getProfName($profile_id);

//echo $profile_id;
//echo "<br />";
//echo $name;
//echo "<br />";

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
	$headers .= "\r\n";
	$headers .= "CC: mark@nazardesigns.com";

	$to = $email_addr;		
	//$to = "mark.stanz@gmail.com";
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
								
			
	}else{
		$stmt->execute();
		$stmt->close();
						
		$msg = "Your changes have been saved.";
	}
}


if(isset($_POST['set_active'])){
	
	$img_id = (isset($_POST["img_id"]))? $_POST["img_id"] : 0;
	$name = (isset($_POST['name']))? $_POST['name'] : array();
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
	$stmt = $db->prepare("UPDATE profile
						SET name = ?
					WHERE id = ?"); 
								
								//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("si",
					$name
					,$profile_id)){																
			
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


	//echo $_POST['prof_active'];
	//echo "<br />";
	//echo $lgn->getProfileId();
	//echo "<br />";


	$prof->setProfIsActive($lgn->getProfileId(), $prof_active);

	$msg = "Changes Saved.";

}
?><!DOCTYPE html>
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
				<div class="card-header">My Social Media</div>
				<div class="card-body">
					<form name="form_1" action="user-admin-landing.php" method="post" enctype="multipart/form-data">

						<div class="d-flex justify-content-end">
							<button class="btn btn-primary" type="submit" name="set_active">
							<i class="icon-ok"></i> Save Changes</button>
						</div>

						<div class="row">		
							
							<div class="col-md-8" style="padding-right:30px;">
								<label for="input_name">Name</label>
								<input type="text" name="name" 
								value="<?php echo stripslashes($name); ?>" 
								class="form-control" id="input_name" >
								<small class="form-text">This name and will be visable to the public.</small>
							</div>
						</div>


						<div class="row">		
							<div class="col-md-12" style="padding-left:30px; padding-right:30px;">
		<?php
		$_SESSION['ret_dir'] = "user-admin";		
		$_SESSION['ret_page'] = 'user-admin-landing';			
		$url_str = "../upload/upload-pre-crop.php";
		$url_str .= "?img_type=profile";
		?>            
							</div>
						</div>

						<div class="d-flex justify-content-end mt-5">           
<a class="btn btn-info" href="<?php echo $url_str; ?>" >
<i class="icon-cloud-upload"></i> Upload Profile Photo or Custom Avatar</a>
						</div>
		
		<table border="1" width="100%;">
			<tr>
				<td width="50%">&nbsp;</td>
				<td width="30%">Active</td>
				<td>Delete</th>
			</tr>
			<?php

			$sql = "SELECT image.file_name
						,image.id
						,profile_to_img.active
						,profile_to_img.id AS pi_id 
					FROM profile_to_img, image 
					WHERE profile_to_img.img_id = image.id
					AND image.slug LIKE '%profile%'
					AND profile_to_img.profile_id = '".$profile_id."'"; 
			$result = $dbCustom->getResult($db,$sql);					
					
			$num_rows = $result->num_rows;		
					
			echo "You Have ".$num_rows." Profile Photos";
					
			$block = "";
			while($row = $result->fetch_object()) {

			$block .= "<tr height='130px;'>";
									
			$block .= "<td align='center'>"; 
$block .= "<img src='../saascustuploads/profile/".$profile_id."/round/".$row->file_name."'  />";
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

