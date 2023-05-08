<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}
require_once('../includes/config.php');
require_once('../includes/class.profess.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/functions.php');
require_once('../includes/class.customer_login.php');
require_once('../manage/includes/manage_functions.php');

//require_once("includes/class.setup_progress.php");
	
$lgn = new CustomerLogin;
$lgn = new CustomerLogin;
$prof = new Professional;

$page_title = "Professional Profile";

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$profile_id = (isset($_GET['profile_id'])) ? $_GET['profile_id'] : 0;
if(!isset($_SESSION['temp_page_fields']['profile_id'])) $_SESSION['temp_page_fields']['profile_id'] = $profile_id;

echo $_SESSION['temp_page_fields']['profile_id'];
echo "<br />";



if(isset($_POST['add_skill'])){
	
	$name = (isset($_POST['name'])) ? addslashes(trim($_POST['name'])) : '';
	$description = (isset($_POST['description'])) ? addslashes(trim($_POST['description'])) : '';
	
	$sql = sprintf("INSERT INTO skill
					(name, description, profile_id, profile_account_id)
					VALUES
					('%s','%s','%u','%u')", $name, $description, $_SESSION['temp_page_fields']['profile_id'], $_SESSION['profile_account_id']);
	$result = $dbCustom->getResult($db,$sql);
	
}


if(isset($_POST['edit_skill'])){
	
	$name = (isset($_POST['name'])) ? addslashes(trim($_POST['name'])) : '';
	$description = (isset($_POST['description'])) ? addslashes(trim($_POST['description'])) : '';
	$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
	
	$sql = sprintf("UPDATE skill
					SET name = '%s'
					,description = '%s'					
					WHERE profile_id = '%u' 
					AND id = '%u'", $name, $description, $_SESSION['temp_page_fields']['profile_id'], $id);					
	$result = $dbCustom->getResult($db,$sql);
	
}


if(isset($_POST['edit_credential'])){
	
	
	$name = (isset($_POST['name'])) ? addslashes(trim($_POST['name'])) : '';
	$description = (isset($_POST['description'])) ? addslashes(trim($_POST['description'])) : '';
	$institution = (isset($_POST['institution'])) ? addslashes(trim($_POST['institution'])) : '';	
	$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
	
	$sql = sprintf("UPDATE credential
					SET name = '%s'
					,description = '%s'
					,institution = '%s'					
					WHERE profile_id = '%u' 
					AND id = '%u'", $name, $description, $institution, $_SESSION['temp_page_fields']['profile_id'], $id);					
	$result = $dbCustom->getResult($db,$sql);
}

if(isset($_POST['add_credential'])){
	
	$name = (isset($_POST['name'])) ? addslashes(trim($_POST['name'])) : '';
	$description = (isset($_POST['description'])) ? addslashes(trim($_POST['description'])) : '';
	$institution = (isset($_POST['institution'])) ? addslashes(trim($_POST['institution'])) : '';	
	
	$sql = sprintf("INSERT INTO credential
					(name, description, institution, profile_id, profile_account_id)
					VALUES
					('%s','%s','%s','%u','%u')", $name, $description, $institution, $_SESSION['temp_page_fields']['profile_id'], $_SESSION['profile_account_id']);
	$result = $dbCustom->getResult($db,$sql);
}

if(isset($_POST['del_skill'])){

	$del_skill_id = (isset($_POST['del_skill_id'])) ? $_POST['del_skill_id'] : 0;
	
	$sql = sprintf("DELETE FROM skill
					WHERE profile_id = '%u' 
					AND id = '%u'", $_SESSION['temp_page_fields']['profile_id'], $del_skill_id);					
	$result = $dbCustom->getResult($db,$sql);
	
}


if(isset($_GET['del_image_id'])){

		$id = $_GET["del_image_id"];
				
		$sql = "SELECT file_name
				FROM image 
				WHERE id = '".$id."'";
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
			
			$fn_path = "../saascustuploads/".$_SESSION['profile_account_id']."/profile/".$profile_id."/".$img_obj->file_name;			
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




if(isset($_POST['del_credential'])){

	$del_credential_id = (isset($_POST['del_credential_id'])) ? $_POST['del_credential_id'] : 0;
	
	$sql = sprintf("DELETE FROM credential
					WHERE profile_id = '%u' 
					AND id = '%u'", $_SESSION['temp_page_fields']['profile_id'], $del_credential_id);					
	$result = $dbCustom->getResult($db,$sql);
	
}


if(isset($_POST['set_active_img'])){

	$actives = (isset($_POST["active"]))? $_POST["active"] : array();

	$sql = "UPDATE profile_to_img 
			SET active = '0' 
			WHERE profile_id = '".$_SESSION['temp_page_fields']['profile_id']."'";
	$result = $dbCustom->getResult($db,$sql);
	foreach($actives as $value){
		$sql = "UPDATE profile_to_img SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
		
		
	}
	$msg = "Changes Saved.";


}


if(isset($_POST['set_active_skills'])){

	$actives = (isset($_POST["active"]))? $_POST["active"] : array();
	
	$sql = "UPDATE skill 
			SET active = '0' 
			WHERE profile_id = '".$_SESSION['temp_page_fields']['profile_id']."'";
	$result = $dbCustom->getResult($db,$sql);
	
		
	foreach($actives as $value){
		$sql = "UPDATE skill SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
		
		
	}
	$msg = "Changes Saved.";
		
}


if(isset($_POST['set_active_credentials'])){

	$actives = (isset($_POST["active"]))? $_POST["active"] : array();
	
	$sql = "UPDATE credential 
			SET active = '0' 
			WHERE profile_id = '".$_SESSION['temp_page_fields']['profile_id']."'";
	$result = $dbCustom->getResult($db,$sql);
	
		
	foreach($actives as $value){
		$sql = "UPDATE credential SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
		
		
	}
	$msg = "Changes Saved.";
		
}


if($_SESSION['temp_page_fields']['profile_id'] > 0){
	
	$stmt = $db->prepare("SELECT profession 
					,active
					,public_email
					,private_email
					,name
					,company
					,website
					,address_one
					,address_two
					,city
					,state
					,zip
					,country	
					,phone_one
					,phone_two
					,country					
					,about
					,bio
					,user_type_id
					,id
					FROM profile 
					WHERE id = ?");
	
	if(!$stmt->bind_param("i", $_SESSION['temp_page_fields']['profile_id'])){
		//echo 'Error '.$db->error;
	}else{
		$stmt->execute();
	
		$stmt->bind_result($profession
					,$active
					,$public_email
					,$private_email
					,$name
					,$company
					,$website
					,$address_one
					,$address_two
					,$city
					,$state
					,$zip
					,$country	
					,$phone_one
					,$phone_two
					,$country					
					,$about
					,$bio
					,$user_type_id
					,$id);
						
		if($stmt->fetch()){
			$stmt->free_result();
			$stmt->close();
		}
		
		
		
		
		echo $name;
		echo "<br />";
		
		echo $public_email;
		echo "<br />";
		echo $private_email;
		echo "<br />";
		echo $_SESSION['temp_page_fields']['profile_id'];
		echo "<br />";
		echo "<br />";
		
		
	
		if(!isset($_SESSION['temp_page_fields']['profession'])) $_SESSION['temp_page_fields']['profession'] = $profession;
		if(!isset($_SESSION['temp_page_fields']['active'])) $_SESSION['temp_page_fields']['active'] = $active;
		if(!isset($_SESSION['temp_page_fields']['bio'])) $_SESSION['temp_page_fields']['bio'] = $bio;
		if(!isset($_SESSION['temp_page_fields']['public_email'])) $_SESSION['temp_page_fields']['public_email'] = $public_email;
		if(!isset($_SESSION['temp_page_fields']['private_email'])) $_SESSION['temp_page_fields']['private_email'] = $private_email;
		if(!isset($_SESSION['temp_page_fields']['name'])) $_SESSION['temp_page_fields']['name'] = $name;
		if(!isset($_SESSION['temp_page_fields']['company'])) $_SESSION['temp_page_fields']['company'] = $company;
		if(!isset($_SESSION['temp_page_fields']['website'])) $_SESSION['temp_page_fields']['website'] = $website;
		if(!isset($_SESSION['temp_page_fields']['address_one'])) $_SESSION['temp_page_fields']['address_one'] = $address_one;
		if(!isset($_SESSION['temp_page_fields']['address_two'])) $_SESSION['temp_page_fields']['address_two'] = $address_two;
		if(!isset($_SESSION['temp_page_fields']['city'])) $_SESSION['temp_page_fields']['city'] = $city;	
		if(!isset($_SESSION['temp_page_fields']['state'])) $_SESSION['temp_page_fields']['state'] = $state;
		if(!isset($_SESSION['temp_page_fields']['zip'])) $_SESSION['temp_page_fields']['zip'] = $zip;
		if(!isset($_SESSION['temp_page_fields']['country'])) $_SESSION['temp_page_fields']['country'] = $country;
		if(!isset($_SESSION['temp_page_fields']['phone_one'])) $_SESSION['temp_page_fields']['phone_one'] = $phone_one;
		if(!isset($_SESSION['temp_page_fields']['phone_two'])) $_SESSION['temp_page_fields']['phone_two'] = $phone_two;
		if(!isset($_SESSION['temp_page_fields']['country'])) $_SESSION['temp_page_fields']['country'] = $country;
		if(!isset($_SESSION['temp_page_fields']['about'])) $_SESSION['temp_page_fields']['about'] = $about;
		if(!isset($_SESSION['temp_page_fields']['bio'])) $_SESSION['temp_page_fields']['bio'] = $bio;
		
		//if(!isset($_SESSION['temp_page_fields']['user_type_id'])) $_SESSION['temp_page_fields']['user_type_id'] = $user_type_id;
		
	}
}else{

	exit;
	
}

	
	
	$sql = "UPDATE profile_to_img
			SET active = '1'
			WHERE profile_id = '32'";
	//$result = $dbCustom->getResult($db,$sql);		


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
		
			
			<form name="form_img" action="edit-profess-profile.php" method="post">
				<?php
					$_SESSION['ret_dir'] = "manage";						
					$_SESSION['ret_page'] = 'edit-profess-profile';			
					$url_str = "../upload/upload-pre-crop.php";
					$url_str .= "?img_type=profile";
					$url_str .= "&cust_id=".$_SESSION['temp_page_fields']['profile_id'];
					
	echo "<br />";
	echo "<br />";
	echo "public_email:  ".$public_email;
	echo "<br />";
	echo "private_email:  ".$private_email;
	echo "<br />";

				?>
				
				<table>
				<tr>
<td><button type="submit" name="set_active_img" class="btn btn-info btn-sm">Update Image Active settings</button></td>
					<td><a class="btn btn-info btn-sm" href="<?php echo $url_str; ?>" >Upload Profile Photo</a></td>					
				</tr>	
				</table>
					
					

				<table>
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
						AND profile_to_img.profile_id = '".$_SESSION['temp_page_fields']['profile_id']."'"; 
				$result = $dbCustom->getResult($db,$sql);
				$num_rows = $result->num_rows;
				$block = "";
				while($row = $result->fetch_object()) {
					$block .= "<tr>";						
					$block .= "<td>";
$block .= "<img src='../saascustuploads/".$_SESSION['temp_page_fields']['profile_id']."/round/".$row->file_name."'  />";
					$block .= $row->file_name;
					$block .= "</td>";
						
					$checked = ($row->active || $num_rows < 2)? "checked" : "";
											
					$block .= "<td>
					<label class='switch'>
<input style='width:20px; height:20px;' type='radio' name='active[]' value='".$row->pi_id."' $checked />
					<span class='slider round'></span>
					</label>
					</td>";	
						
			$block .= "<td><a class='btn btn-danger' href='edit-profess-profile.php?del_image_id=".$row->id."'>Delete</a></td>";
							
					$block .= "</tr>";
				}
				echo $block;
				?>
				</table>
				</form>
			</div>
			

			<form name="form_data" action="profess-profiles.php" method="post">
        
			<input id="profile_id" type="hidden" name="profile_id" value="<?php echo $_SESSION['temp_page_fields']['profile_id'];  ?>" />
			<input type="hidden" name="update_profile" value="1" />
        
		
			<button name="edit_profile" type="submit" class="btn btn-primary"> Save </button>
			
			<table width="100%" border="0" cellpadding="6">
			<tr>
			<td width="16%">Name</td>
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

			<br />

			<fieldset>
			<legend>Skills</legend>
			<form name="set_skills" action="edit-profess-profile.php" method="post" enctype="multipart/form-data" class="pure-form">
			
			<div style="float:left; margin-right:20px;">
				<button class="btn btn-primary" name="set_active_skills" type="submit"> Set Actives </button>
			</div>
			<div style="float:left; margin-right:20px;">
				<a class="btn btn-info" href="add-profess-skill.php?profile_id=<?php echo $_SESSION['temp_page_fields']['profile_id']; ?>">Add Skill </a>
			</div>
			<div style="clear:both;">&nbsp;</div>

			<table>
			<tr>
				<th width="70%">Skill</th>
				<th width="10%">Actice</th>
				<th width="10%">Edit</th>
				<th>Delete</th>
			</tr>
			<?php                    
  			$block = '';

			$sql = "SELECT skill.id
						,skill.name
						,skill.active
					FROM skill, profile 
					WHERE skill.profile_id = profile.id
					AND profile.id = '".$_SESSION['temp_page_fields']['profile_id']."'";
			$result = $dbCustom->getResult($db,$sql);
			while($row = $result->fetch_object()){
		
				$block .= "<tr>";
				$block .= "<td>".stripslashes($row->name)."</td>";

				$checked = ($row->active)? "checked" : "";
				$block .= "<td valign='top'>
								<label class='switch'>
								<input type='checkbox' name='active[]' value='".$row->id."' $checked />
								<span class='slider round'></span>
								</label>
								</td>";	


				$url_str = "edit-prof-skill.php";
				$url_str .= "?id=".$row->id;
				$block .= "<td><a class='btn btn-info  btn-sm' href='".$url_str."'>Edit</a></td>";
										
				$block .= "<td><a class='btn btn-danger btn-sm'><input type='hidden' id='".$row->id."' class='itemId' value='".$row->id."' />Delete</a></td>";
				$block .= "</tr>";
			}

			echo $block;
			?>                    
			</table>
			</form>
			</fieldset>

			<br />
			<fieldset>
			<legend>Credentials</legend>
			<form name="set_credentials" action="edit-profess-profile.php" method="post" enctype="multipart/form-data" class="pure-form">
			
			<div style="float:left; margin-right:20px;">
				<button class="btn btn-primary" name="set_active_credentials" type="submit" > Set Actives </button>
			</div>
			<div style="float:left; margin-right:20px;">
				
				<a class="btn btn-info" 
				href="add-prof-credential.php?profile_id=<?php echo $_SESSION['temp_page_fields']['profile_id']; ?>">Add Credential </a>
			</div>
			<div style="clear:both;">&nbsp;</div>

			<table>
			<tr>
				<th width="70%">Credential</th>
				<th width="10%">Actice</th>
				<th width="10%">Edit</th>
				<th>Delete</th>
			</tr>
			<?php                    
  			$block = '';

			$sql = "SELECT credential.id
						,credential.name
						,credential.active
					FROM credential, profile 
					WHERE credential.profile_id = profile.id
					AND profile.id = '".$_SESSION['temp_page_fields']['profile_id']."'";
			$result = $dbCustom->getResult($db,$sql);
			while($row = $result->fetch_object()){
		
				$block .= "<tr>";
				$block .= "<td>".stripslashes($row->name)."</td>";

				$checked = ($row->active)? "checked" : "";
				$block .= "<td valign='top'>
								<label class='switch'>
								<input type='checkbox' name='active[]' value='".$row->id."' $checked />
								<span class='slider round'></span>
								</label>
								</td>";	


				$url_str = "edit-prof-credential.php";
				$url_str .= "?id=".$row->id;
				$block .= "<td><a class='btn btn-info btn-sm' href='".$url_str."'>Edit</a></td>";
										
				$block .= "<td><a class='btn btn-danger btn-sm'><input type='hidden' id='".$row->id."' class='itemId' value='".$row->id."' />Delete</a></td>";					
				$block .= "</tr>";

			}

			echo $block;
			?>                    
			</table>
			</form>
			
			</fieldset>

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
