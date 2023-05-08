<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/class.profess.php');
	
$lgn = new CustomerLogin;

$prof = new Professional;

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : '';
$a_d = (isset($_GET['a_d'])) ? $_GET['a_d'] : 'a';
				
$pagenum = (isset($_GET['pagenum'])) ? addslashes($_GET['pagenum']) : 0;
$truncate = (isset($_GET['truncate'])) ? addslashes($_GET['truncate']) : 1;
				
$search_str = '';

if(isset($_POST["add_skill"])){
	 
	$name = isset($_POST['name'])? trim(addslashes($_POST['name'])) : '';
	$description = isset($_POST['description'])? trim(addslashes($_POST['description'])) : '';

	$stmt = $db->prepare("INSERT INTO skill 
						(name, description)
						VALUES(?,?)");	
		
		echo 'Error 1'.$db->error;
					
	if(!$stmt->bind_param("ss", $name, $description)){

		echo 'Error 2'.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
		$msg = "Skill added";
	}

	echo "<br />";
}

if(isset($_POST['edit_skill'])){
	
	$name = trim(addslashes($_POST['name']));
	$description = trim(addslashes($_POST['description']));
	$skill_id = isset($_POST['skill_id']) ? $_POST['skill_id'] : 0;
	//$member_id = isset($_POST['member_id']) ? $_POST['member_id'] : 0;

	$stmt = $db->prepare("UPDATE skill
						SET name = ?
							,description = ?
						WHERE id = ?");
						
		//echo 'Error '.$db->error;	
													
	if(!$stmt->bind_param('ssi'
						,$name
						,$description
						,$skill_id)){
							
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
			$sql = "UPDATE skill SET active = '0' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}
	}
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
	if(is_array($actives)){	
		foreach($actives as $value){
			$sql = "UPDATE skill SET active = '1' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}
	}

	$msg = 'Changes Saved.';
}

if(isset($_GET["del_id"])){

	$id = isset($_GET['del_id']) ? $_GET['del_id'] : 0;
	if(!isset($id)) $id = 0;
	
	$sql = sprintf("DELETE FROM skill WHERE id = '%u'", $id);
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
			<h3>Skills</h3>
			</center>

			<form action="profess-skills.php" method="post">

			<div style="float:left;">
				<button class="btn btn-primary" name="set_active" type="submit" > Save Changes </button>
			</div>
			<div style="float:left; margin-left:20px;">
				<a class="btn btn-info" href="add-profess-skill.php">Add New Skill</a>
			</div>
			<div style="clear:both;"></div>


			<table cellpadding="10" cellspacing="1" colspan="1">
			<tr>
				<td>Name</td>
				<td>Active</td>
				<td width="12%">Edit</td>
				<td width="5%">Delete</td>
			</tr>
			<?php
			/*
			$sql = "SELECT skill.id
					,skill.name AS skill_name
					,skill.active 
					FROM skill, profile
					WHERE skill.profile_id = profile.id 
					AND profile.profile_account_id = '".$_SESSION['profile_account_id']."'
					ORDER BY profile.name";
			*/
			
			$sql = "SELECT id
					,name AS skill_name
					,active 
					FROM skill
					ORDER BY skill_name";
			
			
			
			$result = $dbCustom->getResult($db,$sql);					
	
			$block = '';
			while($row = $result->fetch_object()) {
						
				$block	.= "<input type='hidden' name='on_this_page[]' value='".$row->id."' />";
						
				$block .= "<tr>"; 				
				//$block .= "<td>".$row->memebr_name."</td>";						
				$block .= "<td>".$row->skill_name."</td>";

				$checked = ($row->active)? "checked" : "";
				$block .= "<td>";
				$block .= "<div class='checkbox'>";
				$block .= "<label>";
				$block .= "<input type='checkbox' name='active[]' value='".$row->id."' data-toggle='toggle' $checked>";
				$block .= "</label>";
				$block .= "</div>";
				$block .= "</td>";
				$block .= "<td><a class='btn btn-info' href='edit-profess-skill.php?skill_id=".$row->id."' >Edit</a></td>"; 
				$block .= "<td><a class='btn btn-danger' href='profess-skills.php?del_id=".$row->id."'>Delete</a></td>";	
				$block .= "</tr>"; 				
			}
			$block .= "</table>";
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
