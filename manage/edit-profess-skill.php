<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/class.profess.php');
//require_once("includes/class.setup_progress.php");
	
$lgn = new CustomerLogin;

$prof = new Professional;

$page_title = "Edit Skill";

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$skill_id = (isset($_GET['skill_id'])) ? $_GET['skill_id'] : '';

$name = '';
$description = '';

$stmt = $db->prepare("SELECT name, description, profile_id 
					FROM skill 
					WHERE id = ?
					AND profile_account_id = ?");
	
if(!$stmt->bind_param("ii", $skill_id, $_SESSION['profile_account_id'])){
	//echo 'Error '.$db->error;
}else{
	$stmt->execute();
	$stmt->bind_result($name, $description, $profile_id);
	if($stmt->fetch()){
		
		echo "jjjjjjjjjjjjj   ".$name;
		
		
		
		$stmt->close();
	}		
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
			<h3>Edit Skill</h3>
			</center>

			<form  name="form" action="profess-skills.php" method="post" target="_top">
			<input type="hidden" name="skill_id" value="<?php echo $skill_id; ?>" />
			
			<table width="100%" cellpadding="6" border="1">
			<tr>
				<td>Name</td>
				<td><input type="text" name="name" value="<?php echo $name; ?>" maxlength="255" style="width:400px;" /></td>
			</tr>
			<tr valign="top">
				<td>Description</td>
				<td>			
				<textarea style="width:100%; height:200px;" name="description">
				<?php echo $description; ?>
				</textarea>
				</td>			
			</tr>			
			</table>
						
			<br />
            
			<button class="btn btn-primary" name="edit_skill" type="submit">Save</button>
            <br /><br />
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
