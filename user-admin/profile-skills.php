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

if(isset($_POST['update_skill'])){

	$name = isset($_POST['name'])? trim(stripslashes($_POST['name'])) : '';
	$description = isset($_POST['description'])? trim(stripslashes($_POST['description'])) : '';
	
	$id = isset($_POST['id'])? $_POST['id'] : 0;  
	
	$stmt = $db->prepare("UPDATE skill
						SET name = ?
						,description = ?
						WHERE id = ?
						AND profile_id = ?");
						
		//echo 'Error '.$db->error;	
						
	if(!$stmt->bind_param('ssii'
						,$name
						,$description
						,$id
						,$profile_id)){
			
		echo 'Error-2 '.$db->error;					
	}else{
	
		$stmt->execute();
		$stmt->close();		

		$msg = 'success';
	}


}


if(isset($_POST['add_skill'])){
	 
	$name = isset($_POST['name'])? trim(stripslashes($_POST['name'])) : '';  
	$description = isset($_POST['description'])? trim(stripslashes($_POST['description'])) : '';  
	
	$stmt = $db->prepare("INSERT INTO skill 
						(name, description, profile_id)
						VALUES
						(?,?,?)");
						
		echo 'Error 1 '.$db->error;						
		echo "<br />";
	if(!$stmt->bind_param("ssi", $name, $description, $profile_id)){
		echo 'Error 2 '.$db->error;
		echo "<br />";
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
	$sql = "UPDATE skill SET active = '0' WHERE profile_id = '".$profile_id."'";
	$result = $dbCustom->getResult($db,$sql);

	foreach($actives as $key => $value){
		$sql = "UPDATE skill SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
			
		//echo "key: ".$key."   value: ".$value."<br />"; 
	}
			
	foreach($ids as $key=>$val){
	
		$sql = sprintf("UPDATE skill 
						SET display_order = '%u'
						WHERE id = '%u'",
						$display_orders[$key], $val);
		$result = $dbCustom->getResult($db,$sql);
	}
}
		

if(isset($_GET['del_id'])){

	$skill_id = (isset($_GET['del_id'])) ? $_GET['del_id'] : 0;
	if(!is_numeric($skill_id)) $skill_id = 0;
	
	$sql = sprintf("DELETE FROM skill 
					WHERE id = '%u'
					AND profile_id = '%u'", $skill_id, $profile_id);
	
	$result = $dbCustom->getResult($db,$sql);
	$msg = "Skill deleted.";

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
<main class="container my-3 p-0">
<div class="card shadow-sm">
<div class="card-header">SKILLS</div>
<div class="card-body">
<form name="skill_form" action="profile-skills.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="set_display_order" value="1" />            
	<div class="d-flex justify-content-end">
		<div>
		<button type="submit" name="set_active" class="btn btn-primary btn-sm"><i class="icon-ok"></i> Save</button>
		</div>
		<div class="ml-3">
		<a class="btn btn-info btn-sm" href="add-profile-skill.php?a=1">
		<i class="icon-plus"></i> Add Skill</a>
		</div>
	</div>
	<div class="card mt-3 shadow-sm">
		<div class="card-body">
			<div class="table-responsive">
			<table class="table">
			<thead>
			<tr class="table-secondary">
			<th scope="col">Skill</th>
			<th scope="col">Edit</th>
			<th scope="col">Delete</th>
			</tr>
			</thead>
			<tbody>
			<?php
				
			$sql = "SELECT id
						,name
					FROM skill
					WHERE profile_id = '".$profile_id."'";			
			$result = $dbCustom->getResult($db,$sql);
					
			$block = "";
			while($row = $result->fetch_object()) {
			$block .= "<tr height='40'>"; 				
			$block .= "<td>".stripslashes($row->name)."</td>";
			$block .= "<td>";
			$block .= "<a class='btn btn-info btn-sm' href='edit-profile-skill.php?id=".$row->id."'>Edit</a>";
			$block .= "</td>";
			$url_str = "profile-skills.php";
			$url_str .= "?del_id=".$row->id;				
			$block .= "<td>";
			$block .= "<a class='btn btn-danger btn-sm' href='".$url_str."' />Delete</a>";
			$block .= "</td>";	
			$block .= "</tr>"; 				
			}					
			$block .= "</table>";
			echo $block;
			?>

		</tbody>
		</table>
		</div>
	</div>
</div>
</form>
					
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
let activeNav="profile-skill";
</script>

<?php
require_once('navbar-effect.php');
?>
</body>
</html>


