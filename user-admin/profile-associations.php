<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;
$profile_id = $lgn->getProfileId();
$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";

if(isset($_POST['add_association'])){
	 
	$name = trim(addslashes($_POST["name"]));
	$description = trim(addslashes($_POST["description"]));
	
	$stmt = $db->prepare("INSERT INTO association
							(name
							,description
							,profile_id)
							VALUES
							(?,?,?)"); 								
							//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("ssi",
		$name
		,$description 
		,$profile_id)){																
			
	}else{
		$stmt->execute();
		$stmt->close();
						
		$msg = "Your change is now live.";
	}		

	
}


if(isset($_POST["edit_association"])){
	$name = trim(addslashes($_POST["name"]));
	$description = trim(addslashes($_POST["description"]));
	$association_id = $_POST["association_id"];
					
	$stmt = $db->prepare("UPDATE association
							SET name = ?
							,description = ? 						
						WHERE association_id = ?");
								
					//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("ssi",
						$name
						,$description 
						,$association_id)){								
								
	}else{
		$stmt->execute();
		$stmt->close();
				
		$msg = "Your change is now live.";
	}

}


if(isset($_POST["del_association_id"])){

	$association_id = $_POST["del_association_id"];
		
	$sql = sprintf("DELETE FROM association WHERE association_id = '%u'", $association_id);
	$result = $dbCustom->getResult($db,$sql);

	$msg = "Association deleted.";

}

?>
<!doctype html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Expert Answer</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

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
		<div style="margin-right:20px; margin-left:10px;">


		<form>
			<div class="page_actions"> <a class="btn btn-large btn-primary fancybox fancybox.iframe" 
            href="add-profile-association.php"><i class="icon-plus icon-white"></i> Add a Association </a>
			</div>
			<div class="data_table">
				<table cellpadding="10" cellspacing="0">
					<thead>
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th width="12%">Edit</th>
							<th width="5%">Delete</th>
						</tr>
					</thead>
					<?php					

					$sql = "SELECT id
							,name
							,description 
							FROM association 
							WHERE profile_id = '".$profile_id."'";
					
					$result = $dbCustom->getResult($db,$sql);	

					$block = ""; 				
				
					while($row = $result->fetch_object()) {

    					$block .= "<tr>"; 				
						$block .= "<td>".$row->name."</td>";
						$block .= "<td>".$row->description."</td>";
						
						$block .= "<td><a class='btn btn-primary btn-small fancybox fancybox.iframe' 
						href='edit-profile-association.php?association_id=".$row->association_id."'>
						<i class='icon-cog icon-white'></i> Edit</a></td>";
						
						$block .= "<td valign='middle'><a class='btn btn-danger confirm'>
						<i class='icon-remove icon-white'></i>
						<input type='hidden' id='".$row->association_id."' class='itemId' value='".$row->association_id."' />
						</a>
						</td>";
 
						}
					echo $block;
					?>
					
				</table>
			</div>
		</form>
	
</div>
</div>
</div>
<script src="../js/jquery.min.js"></script>
</body>
</html>