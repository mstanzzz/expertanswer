<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";

if(isset($_POST['edit_specialty'])){

	$name = isset($_POST['name'])? trim(stripslashes($_POST['name'])) : '';
	$description = isset($_POST['description'])? trim(stripslashes($_POST['description'])) : '';
	
	$id = isset($_POST['id'])? $_POST['id'] : 0;  
	
	$stmt = $db->prepare("UPDATE specialty
						SET name = ?
						,description = ?
						WHERE id = ?");
						
		//echo 'Error 1 '.$db->error;	
													
	if(!$stmt->bind_param('ssi'
						,$name
						,$description
						,$id)){
			
		echo 'Error-2 '.$db->error;
							
	}else{
	
		$stmt->execute();
		$stmt->close();		

		$msg = 'success';
	}


	//echo "<br />name:   ".$name;
	//echo "<br />description:   ".$description;
	//echo "<br />id:   ".$id;
	
}


if(isset($_POST['add_specialty'])){
	 
	$name = isset($_POST['name'])? trim(stripslashes($_POST['name'])) : '';
	$description = isset($_POST['description'])? trim(stripslashes($_POST['description'])) : '';
		
	$stmt = $db->prepare("INSERT INTO specialty 
						(name, description, profile_id, profile_account_id)
						VALUES
						(?,?,?,?)");
						
						//echo 'Error '.$db->error;						
	
	if(!$stmt->bind_param("ssii", $name, $description, $profile_id, $_SESSION['profile_account_id'])){
		echo 'Error 2'.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
		$msg = "Skill Added";
	}
}

if(isset($_POST['set_display_order'])){
		
	$display_orders = (isset($_POST['display_order'])) ? $_POST['display_order'] : array();
	$ids = (isset($_POST['id'])) ? $_POST['id'] : array();
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	$sql = "UPDATE specialty SET active = '0' WHERE profile_id = '".$profile_id."'";
	$result = $dbCustom->getResult($db,$sql);

	foreach($actives as $key => $value){
		$sql = "UPDATE specialty SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
	}

			
	foreach($ids as $key=>$val){
		$sql = sprintf("UPDATE specialty 
						SET display_order = '%u'
						WHERE id = '%u'",
						$display_orders[$key], $val);
		$result = $dbCustom->getResult($db,$sql);
	}
}
		

if(isset($_POST['del_specialty'])){

	$specialty_id = $_POST['del_specialty_id'];
	$sql = sprintf("DELETE FROM specialty WHERE id = '%u'", $specialty_id);
	$result = $dbCustom->getResult($db,$sql);
	
}

$msg = '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

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
		<div style="margin:10px;">		
		My Specialties

		<form name="specialty_form" action="profile-specialties.php" method="post" enctype="multipart/form-data">
        	<input type="hidden" name="set_display_order" value="1" />
            <a  class="pure-button confirm confirm-add"  href="#">Add a Specialty </a>
            <input  class="pure-button" type="submit" name="submit" value="Save Actives and Display Order" /> 
			<br /><br />

				<table class="pure-table">
                	<thead>
						<tr>
							<th>Name</th>
							<th width="20%">Display Order</th>
                            <th width="20%">Active</th>
                            <th width="12%">Edit</th>    
							<th>Remove</th>
						</tr>
					<thead>                        
					<tbody>
					<?php
				
					$sql = "SELECT id
								,name
								,display_order 
								,active 
							FROM specialty
							WHERE profile_id = '".$profile_id."'
							ORDER BY display_order";
							
					$result = $dbCustom->getResult($db,$sql);
					
					$block = "";
					while($row = $result->fetch_object()) {
						$block .= "<tr>"; 				
						$block .= "<td>".$row->name."</td>";
						
						$block .= "<td>";
						$block .= "<input class='input_tiny' type='text' name='display_order[]' value='".$row->display_order."' />";
						
						$block .= "<input type='hidden' name='id[]' value='".$row->id."' />";
						$block .= "</td>";

						$checked = ($row->active)? 'checked' : '';

						$block .= "<td valign='top'>
									<label class='switch'>
									<input type='checkbox' name='active[]' value='".$row->id."' $checked />
									<span class='slider round'></span>
									</label>
									</td>";	
						
						$block .= "<td><a class='pure-button' href='edit-profile-specialty.php?id=".$row->id."' >Edit</a></td>";
						
						$block .= "<td><a class='pure-button button-warning confirm'><input type='hidden' id='".$row->id."' class='itemId' value='".$row->id."' />Delete</a></td>";	

						$block .= "</tr>"; 				
					}
					
					$block .= "</tbody>";
					echo $block;
					?>
				</table>
		</form>

</div>
</div>
</div>



<script src="../js/jquery.min.js"></script>

</body>
</html>
