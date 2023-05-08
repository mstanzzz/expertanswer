=-e<?php
require_once('../includes/config.php');
require_once('../includes/class.profess.php');
require_once('../includes/functions.php');
require_once('../includes/class.customer_login.php');
	
$lgn = new CustomerLogin();

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

			$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : '';
			$a_d = (isset($_GET['a_d'])) ? $_GET['a_d'] : 'a';
			
			$pagenum = (isset($_GET['pagenum'])) ? addslashes($_GET['pagenum']) : 0;
			$truncate = (isset($_GET['truncate'])) ? addslashes($_GET['truncate']) : 1;
			
			$search_str = '';


if(isset($_POST['update_profile'])){
	
		
	$profile_id = (isset($_POST['profile_id']))? $_POST['profile_id'] : 0;
	$public_email = trim(addslashes($_POST['public_email']));
	$private_email = trim(addslashes($_POST['private_email']));
	$name = trim(addslashes($_POST['name']));
	$company = trim(addslashes($_POST['company']));
	$website = trim(addslashes($_POST['website']));
	$address_one = trim(addslashes($_POST['address_one']));
	$address_two = trim(addslashes($_POST['address_two']));
	$city = trim(addslashes($_POST['city']));
	$state = trim(addslashes($_POST['state']));
	$zip = trim(addslashes($_POST['zip']));
	$country = trim(addslashes($_POST['country']));
	$phone_one = trim(addslashes($_POST['phone_one']));
	$phone_two = trim(addslashes($_POST['phone_two']));
	$about = trim(addslashes($_POST['about']));
	$bio = trim(addslashes($_POST['bio']));
	//$user_type_id = $_POST['user_type_id'];
	
							/*
							echo "name: ".$name;
							echo "<br />";
							echo "profile_id: ".$profile_id;
							echo "<br />public_email: ".$public_email; 
							echo "<br />name: ".$name; 
							echo "<br />company: ".$company;
							echo "<br />website: ".$website; 
							echo "<br />address_one: ".$address_one; 
							echo "<br />address_two: ".$address_two; 
							echo "<br />city: ".$city;							
							echo "<br />state: ".$state;
							echo "<br />zip: ".$zip;
							echo "<br />country: ".$country;
							echo "<br />phone_one: ".$phone_one;
							echo "<br />phone_two: ".$phone_two; 
							echo "<br />about: ".$about;						
							echo "<br />";
							echo "<br />";
							*/
							

	$stmt = $db->prepare("UPDATE profile
							SET public_email = ?
								,private_email = ? 
								,name = ?
								,company = ?
								,website = ?
								,address_one = ? 
								,address_two = ?
								,city = ?							
								,state = ?
								,zip = ?
								,country = ?
								,phone_one = ?
								,phone_two = ?
								,about = ?
								,bio = ?
						WHERE id = ?");
								
		//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("sssssssssssssssi",
							$public_email
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
							,$about
							,$bio
							,$profile_id)){		

		//echo 'Error-1 UPDATE   '.$db->error;
											
								
	}else{
		$stmt->execute();
		$stmt->close();
				
		$msg = "Updated.";
	}
		
}

if(isset($_POST['add_profile'])){
	
	$active = (isset($_POST['active']))? $_POST['active'] : 0;
	$public_email = trim(addslashes($_POST['public_email']));
	$private_email = trim(addslashes($_POST['private_email']));
	$name = trim(addslashes($_POST['name']));
	$company = trim(addslashes($_POST['company']));
	$website = trim(addslashes($_POST['website']));
	$address_one = trim(addslashes($_POST['address_one']));
	$address_two = trim(addslashes($_POST['address_two']));
	$city = trim(addslashes($_POST['city']));
	$state = trim(addslashes($_POST['state']));
	$zip = trim(addslashes($_POST['zip']));
	$country = trim(addslashes($_POST['country']));
	$phone_one = trim(addslashes($_POST['phone_one']));
	$phone_two = trim(addslashes($_POST['phone_two']));
	$about = trim(addslashes($_POST['about']));

	$profile_id = $lgn->getProfileIdByEmail($username);

	if($profile_id == 0){
		
		if($lgn->create_user($password
							,$username
							,$name
							,$user_type_id				
							,$public_email 	
							,$private_email 	
							,$name 	
							,$company 	
							,$website 	
							,$city 	
							,$state 	
							,$country 	
							,$phone_one 	
							,$about 	
							,$profession)){
								
								$msg = "Account Created";
							}
		
	}else{
		$msg = "The Email Address Already Has Been Used";		
	}
}


function rrmdir($dir) { 
	if (is_dir($dir)) { 
		$objects = scandir($dir); 
			foreach ($objects as $object) { 
				if ($object != "." && $object != "..") { 
					if (is_dir($dir."/".$object)){
						rrmdir($dir."/".$object);
					}else{
						unlink($dir."/".$object);
					}						
				} 
			}
		rmdir($dir); 
	} 
}


if(isset($_GET['del_profile_id'])){

	$profile_id = (isset($_GET['del_profile_id'])) ? $_GET['del_profile_id'] : 0;
	
	if(!is_numeric($profile_id)) $profile_id = 0;
	
	$dir_path = "../saascustuploads/profile/".$profile_id;			

	//echo $dir_path; 

	rrmdir($dir_path);
	
	$sql = "SELECT img_id
			FROM profile_to_img
			WHERE profile_id = '".$profile_id."'";
	$result = $dbCustom->getResult($db,$sql);
	while($row = $result->fetch_object()){

		$sql = "DELETE FROM image
				WHERE id = '".$row->img_id."'";		
		$res = $dbCustom->getResult($db,$sql);	
	}

	$sql = sprintf ("DELETE FROM answer
			WHERE answered_by_profile_id = '%u'",$profile_id);
	$result = $dbCustom->getResult($db,$sql);

	$sql = sprintf ("DELETE FROM skill
			WHERE profile_id = '%u'",$profile_id);
	$result = $dbCustom->getResult($db,$sql);

	$sql = sprintf ("DELETE FROM credential
			WHERE profile_id = '%u'",$profile_id);
	$result = $dbCustom->getResult($db,$sql);

	$sql = sprintf ("DELETE FROM specialty
			WHERE profile_id = '%u'",$profile_id);
	$result = $dbCustom->getResult($db,$sql);

	$sql = sprintf ("DELETE FROM article
			WHERE posted_by_profile_id = '%u'", $profile_id);
	$result = $dbCustom->getResult($db,$sql);

	$sql = sprintf ("DELETE FROM profile
			WHERE id = '%u'",$profile_id);
	$result = $dbCustom->getResult($db,$sql);

	$msg = 'Deleted';

}

if(isset($_POST['set_active'])){

	$actives = (isset($_POST["active"]))? $_POST["active"] : array();
	
	$sql = "UPDATE profile SET active = '0' WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
	$result = $dbCustom->getResult($db,$sql);
			
	foreach($actives as $value){
		$sql = "UPDATE profile SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
		
		
	}
	$msg = "Changes Saved.";
		
}

unset($_SESSION['temp_page_fields']);

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
			<center>
			<h3>Profiles</h3>
			</center>


			<form action="profess-profiles.php" method="post" enctype="multipart/form-data" class="pure-form">
			<div style="float:left; margin-right:16px;">
                <a class="btn btn-primary" href="add-profess-profile.php" >
                    Add a Professional Profile
                </a>  
			</div>
			<div style="float:left;">
                <button name="set_active" type="submit" class="btn btn-primary"> Save Changes </button>
			</div>

			<div style="clear:both;"></div>

			<?php

			$sql = "SELECT id as profile_id 
						,name
						,active
						,profession
						,username
					FROM profile
					ORDER BY profile_id DESC";
					
			$nmx_res = $dbCustom->getResult($db,$sql);
			
			$total_rows = $nmx_res->num_rows;
			$rows_per_page = 16;
			$last = ceil($total_rows/$rows_per_page); 
			
			if ($pagenum < 1){ 
				$pagenum = 1; 
			}elseif ($pagenum > $last){ 
				$pagenum = $last; 
			} 
			
			$result = $dbCustom->getResult($db,$sql);			
			
			if($total_rows > $rows_per_page){
               // echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "profess-profiles.php", $sortby, $a_d);
				echo "<br />";
			}
			?>
			<table cellpadding="10" cellspacing="1" colspan="1">
			<tr>
				<td></td>			
				<td width="15%">Name</th>
				<td width="15%">Profession</td>
				<td width="15%">Email</td>
				<td width="10%">ID</td>
				<td width="10%">Active</td>
				<td width="10%">Edit</td>
				<td>Delete</td>
			</tr>
			<?php
			$block = ''; 
			while($row = $result->fetch_object()){
				
				$sql = "SELECT file_name							
						FROM profile_to_img, image
						WHERE profile_to_img.img_id = image.id
						AND profile_to_img.profile_id = '".$row->profile_id."'";
				$res = $dbCustom->getResult($db,$sql);			
				if($res->num_rows > 0){
					$obj = $res->fetch_object();					
					$prof_img = SITEROOT."/saascustuploads/".$row->profile_id."/round/".$obj->file_name;
				}else{
					$prof_img = SITEROOT."/img/noprofile.png";
				}
				
				$block	.= "<input type='hidden' name='on_this_page[]' value='".$row->profile_id."' />";
				$block .= "<tr>";
				$block .= "<td><img src='".$prof_img."' /></td>";
				
				$block .= "<td>".$row->name."</td>";
				$block .= "<td>".$row->profession."</td>";
				$block .= "<td>".$row->username."</td>";
				$block .= "<td>".$row->profile_id."</td>";
				$checked = ($row->active)? "checked" : "";
				$block .= "<td>";
				$block .= "<div class='checkbox'>";
				$block .= "<label>";
				$block .= "<input type='checkbox' name='active[]' value='".$row->profile_id."' data-toggle='toggle' $checked>";
				$block .= "</label>";
				$block .= "</div>";
				$block .= "</td>";
				$block .= "<td><a class='btn btn-info' href='edit-profess-profile.php?profile_id=".$row->profile_id."'>Edit</a></td>";
				$block .= "<td><a class='btn btn-danger' href='profess-profiles.php?del_profile_id=".$row->profile_id."'>Delete</a></td>";	
				$block .= "</tr>";

			}
			$block .= "</table>";
			echo $block;

			if($total_rows > $rows_per_page){
				//echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "profess-profiles.php", $sortby, $a_d);
			}
			?>
    
			</form>
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
