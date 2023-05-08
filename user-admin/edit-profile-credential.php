<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';
$id = (isset($_GET['id'])) ? $_GET['id'] : '';

$sql = sprintf("SELECT * FROM credential 
				WHERE id = '%u'", $id);
$result = $dbCustom->getResult($db,$sql);

if($result->num_rows > 0){
	$object = $result->fetch_object();
	$name = $object->name;
	$institution = $object->institution;
	$description = $object->description;
}else{
	$name = '';
	$institution = '';
	$description = '';
	
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
<div class="container my-3 p-0">
	<div class="d-flex justify-content-end">
		<a class="btn btn-info" href="profile-credentials.php">
			<i class="icon-arrow-left"></i> Back
		</a>
	</div>
</div>

<main class="container my-3 p-0">
	<div class="card shadow-sm">
		<div class="card-header">Edit Credential</div>
			<div class="card-body">

			<form name="form" action="profile-credentials.php" method="post">
			<input id="id" type="hidden" name="id" value="<?php echo $id;  ?>" />
			<input type="hidden" name="update_credential" value="1" />
			<div class="form-group">
				<label for="name">(degree, certificate etc)</label>
				<input type="text" name="name" value="<?php echo $name ?>" maxlength="250" class="form-control" />
			</div>
			<div class="form-group">
				<label for="institution">Institution</label>
				<input type="text" name="institution" value="<?php echo $institution ?>" maxlength="250" class="form-control" />
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				<textarea  name="description" class="form-control"><?php echo stripslashes($description); ?></textarea>
			</div>
			<div class="d-flex justify-content-end mt-3">
				<button class="btn btn-primary" name="edit_credential" type="submit">
				<i class="icon-ok"></i> Save Changes
				</button>
			</div>	
			</form>
		</div>
	</div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>

