<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}

require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
//require_once("includes/class.setup_progress.php");
	
$lgn = new CustomerLogin;

$page_title = "Edit Job Title";



$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$id = (isset($_GET['id'])) ? $_GET['id'] : '';

$name = '';
$description = '';

$stmt = $db->prepare("SELECT name, description 
					FROM job_title 
					WHERE id = ?
					AND profile_account_id = ?");
	
if(!$stmt->bind_param("ii", $id, $_SESSION['profile_account_id'])){
	//echo 'Error '.$db->error;
}else{
	$stmt->execute();
	$stmt->bind_result($name, $description);
	if($stmt->fetch()){
		$stmt->close();
	}		
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
<script src="../js/tinymce/tinymce.min.js"></script>

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

			
			<form  name="form" action="profess-jobtitles.php" method="post" target="_top">        
			<input type="hidden" name="id" value="<?php echo $id; ?>"
			<br />
            Add Skill
            <br /><br />
			<label>Name</label>
			<br />
			<input type="text" name="name" value='<?php echo $name; ?>' maxlength="255" style="width:400px;" />
			<br />
			<br />
			<label>Description</label>
			<br />
            <textarea name="description"><?php echo $description; ?></textarea>
			<br />
			<br />
			<button class="btn btn-large btn-success" name="edit_job_title" type="submit">Save</button>
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
