<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
	
$lgn = new CustomerLogin;

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : '';
$a_d = (isset($_GET['a_d'])) ? $_GET['a_d'] : 'a';
			
$pagenum = (isset($_GET['pagenum'])) ? addslashes($_GET['pagenum']) : 0;
$truncate = (isset($_GET['truncate'])) ? addslashes($_GET['truncate']) : 1;
			
$search_str = '';

if(isset($_POST["add_specialty"])){
	 
	$name = trim(addslashes($_POST['name']));
	$description = trim(addslashes($_POST['description']));

	$sql = sprintf("INSERT INTO specialty (name, description, profile_account_id) 
					VALUES ('%s','%s','%u')", 
					$name, $description, $_SESSION['profile_account_id']);
	$result = $dbCustom->getResult($db,$sql);


	$specialty_exists = 0;
		
	$stmt = $db->prepare("SELECT id FROM specialty 
							WHERE name = ?
							AND profile_account_id = ?");
	
	if(!$stmt->bind_param("si", $name, $_SESSION['profile_account_id'])){
		//echo 'Error '.$db->error;
	}else{
		$stmt->execute();
		$stmt->bind_result($id);
		if($stmt->fetch()){
			$msg = "This specialty already exists";
			$stmt->close();
			$specialty_exists = 1;	
		}		
	}
	

	if(!$specialty_exists){

		$stmt = $db->prepare("INSERT INTO specialty 
								(name, description, profile_account_id)
								VALUES(?,?,?)");	
					
		if(!$stmt->bind_param("ssi", $name, $description, $_SESSION['profile_account_id'])){
			//echo 'Error '.$db->error;
		}else{
			$stmt->execute();
			$stmt->close();
			$msg = "specialty added";
		}
	}

}

if(isset($_POST['edit_specialty'])){
	
	$name = trim(addslashes($_POST['name']));
	$description = trim(addslashes($_POST['description']));
	$id = $_POST["id"];

	$stmt = $db->prepare("UPDATE specialty
						SET name = ?
							,description = ?
						WHERE id = ?
						AND profile_account_id = ?");
						
		//echo 'Error '.$db->error;	
													
	if(!$stmt->bind_param('ssii'
						,$name
						,$description
						,$id
						,$_SESSION['profile_account_id'])){			
		//echo 'Error-2 '.$db->error;					
	}else{
	
		$stmt->execute();
		$stmt->close();		
		
		$msg = 'Update successful';
	}
	
}


if(isset($_POST['set_active'])){
	
	$on_this_page = (isset($_POST['on_this_page']))? $_POST['on_this_page'] : array();
	
	if(is_array($on_this_page)){	
		foreach($on_this_page as $value){
			$sql = "UPDATE specialty SET active = '0' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}
	}
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
	if(is_array($actives)){	
		foreach($actives as $value){
			$sql = "UPDATE specialty SET active = '1' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}
	}

	$msg = 'Changes Saved.';
}


if(isset($_GET["del_id"])){
	
	$id = isset($_GET["del_id"])? $_GET["del_id"] : 0;
	if(!is_numeric($id)) $id = 0;

	$sql = sprintf("DELETE FROM specialty WHERE id = '%u'", $id);
	$result = $dbCustom->getResult($db,$sql);	
}

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
			<h3>Add Specialty</h3>
			</center>

			<form action="profess-specialties.php" method="post" enctype="multipart/form-data">
			<div style="float:left;">
				<button class="btn btn-primary" name="set_active" type="submit" > Save Changes </button>
			</div>
			<div style="float:left; margin-left:20px;">
				<a class="btn btn-info" href="add-profess-specialty.php">Add New Specialty</a>
			</div>
			<div style="clear:both;"></div>
			
			<table cellpadding="10" cellspacing="1">
			<tr>
				<td>Name</td>
				<td>Active</td>
				<td width="12%">Edit</td>
				<td width="5%">Delete</td>
			</tr>
			<?php
			$sql = "SELECT * 
			FROM specialty";
			$result = $dbCustom->getResult($db,$sql);					
			$block = '';
			while($row = $result->fetch_object()) {			
			$block	.= "<input type='hidden' name='on_this_page[]' value='".$row->id."' />";
			$block .= "<tr>"; 				
			$block .= "<td>".$row->name."</td>";
			$checked = ($row->active)? "checked" : "";
			$block .= "<td>";
			$block .= "<div class='checkbox'>";
			$block .= "<label>";
			$block .= "<input type='checkbox' name='active[]' value='".$row->id."' data-toggle='toggle' $checked>";
			$block .= "</label>";
			$block .= "</div>";
			$block .= "</td>";
			$block .= "<td><a class='btn btn-info' href='edit-profess-specialty.php?id=".$row->id."' >Edit</a></td>";
			$block .= "<td><a class='btn btn-danger' href='profess-specialties.php?del_id=".$row->id."'>Delete</a></td>";
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
