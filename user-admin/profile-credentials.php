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

if(isset($_POST['add_credential'])){
	 
	$name = isset($_POST['name'])? trim(addslashes($_POST['name'])) : '';
	$institution = isset($_POST['institution'])? trim(addslashes($_POST['institution'])) : '';
	$description = isset($_POST['description'])? trim(addslashes($_POST['description'])) : '';

	$stmt = $db->prepare("INSERT INTO credential
							(name
							,institution
							,description
							,profile_id)
							VALUES
							(?,?,?,?)"); 								
							
	//echo 'Error-1 UPDATE   '.$db->error;
	//echo "<br />";
								
	if(!$stmt->bind_param("sssi",
		$name
		,$institution
		,$description 
		,$profile_id)){							
											
	//echo 'Error-2 UPDATE   '.$db->error;
	//echo "<br />";
	
	}else{
		$stmt->execute();
		$stmt->close();
						
		$msg = "Your change is now live.";
	}		

}

if(isset($_POST["update_credential"])){
	$name = isset($_POST['name'])? trim(addslashes($_POST['name'])) : '';
	$institution = isset($_POST['institution'])? trim(addslashes($_POST['institution'])) : '';
	$description = isset($_POST['description'])? trim(addslashes($_POST['description'])) : '';
	$id = isset($_POST['id'])? trim(addslashes($_POST['id'])) : '';

	$stmt = $db->prepare("UPDATE credential
							SET name = ?
							,institution = ?
							,description = ? 						
						WHERE id = ?");
								
					echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("sssi",
						$name
						,$institution
						,$description 
						,$id)){				
						
				echo 'Error-2 UPDATE   '.$db->error;						
								
	}else{
		$stmt->execute();
		$stmt->close();
				
		$msg = "Your change is now live.";
	}
}


if(isset($_GET['del_id'])){

	$credential_id = (isset($_GET['del_id'])) ? $_GET['del_id'] : 0;
	if(!is_numeric($credential_id)) $credential_id = 0;
	
	$sql = sprintf("DELETE FROM credential 
					WHERE id = '%u'
					AND profile_id = '%u'", $credential_id, $profile_id);
	
	$result = $dbCustom->getResult($db,$sql);
	$msg = "Credential deleted.";
	
}

$msg = '';
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
		<div class="card-header">Credentials can be degrees, certificates, etc.</div>
		<div class="card-body">
						
		<div class="d-flex justify-content-end">
			<div class="ml-3">
			<a class="btn btn-info btn-sm" href="add-profile-credential.php"><i class="icon-plus"></i> Add Credential</a>
			</div>
		</div>
						
		<div class="card mt-3 shadow-sm">
			<div class="card-body">
				<div class="table-responsive">
				<table class="table">
				<thead>
				<tr class="table-secondary">
				<th>Credential</th>
				<th width="10%">Edit</th>    
				<th width="10%">Remove</th>
				</tr>
				</thead>
<?php
$sql = "SELECT id
	,name
	,description 
	FROM credential 
	WHERE profile_id = '".$profile_id."'";				
$result = $dbCustom->getResult($db,$sql);
$block = "<tbody>";
while($row = $result->fetch_object()) {
$block .= "<tr height='40'>";
$block .= "<td>".stripslashes($row->name)."</td>";
$block .= "<td><a class='btn btn-info btn-sm' href='edit-profile-credential.php?id=".$row->id."'><i class='icon-edit'></i> Edit</a></td>";				
$block .= "<td>";					
$url_str = "profile-credentials.php";
$url_str .= "?del_id=".$row->id;					
$block .= "<a class='btn btn-danger btn-sm' href='".$url_str."'><i class='icon-minus-sign'></i> Delete</a>";
$block .= "</td>";	
$block .= "</tr>"; 				
}
$block .= "</tbody>";
$block .= "</table>";
echo $block;
?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
let activeNav="profile-cred";
</script>

<?php
require_once('navbar-effect.php');
?>
</body>
</html>




