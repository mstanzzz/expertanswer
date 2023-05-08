<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";
$association_id = (isset($_GET["association_id"])) ? $_GET["association_id"] : 0;

$sql = sprintf("SELECT * FROM association WHERE association_id = '%u'", $association_id);
$result = mysql_query ($sql);
if(!$result)die(mysql_error());
if(mysql_num_rows($result) > 0){
	$object = mysql_fetch_object($result);
	$name = $object->name;
	$description = $object->description;
}else{
	$name = "";
	$description = "";	
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
		
		<form name="edit_form" action="profile-associations.php" method="post" target="_top">
       	<input id="association_id" type="hidden" name="association_id" value="<?php echo $association_id;  ?>" />
		<div class="lightboxcontent">
			<h2>Edit Specialty</h2>
			<fieldset>
				<div class="colcontainer formcols">
					<div class="twocols">
						<label>Name</label>
					</div>
					<div class="twocols">
						<input type="text" name="name" value="<?php echo $name ?>" maxlength="255" style="width:500;" />
					</div>
				</div>
				<div class="colcontainer formcols">
					<div class="twocols">
						<label>Description</label>
					</div>
					<div class="twocols">
						<textarea  name="description" rows="5" cols="50"><?php echo stripslashes($description); ?></textarea>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="savebar">
			<button class="btn btn-large btn-success" name="edit_association" type="submit"><i class="icon-ok icon-white"></i> Save Changes</button>
		</div>
	</form>
</div>
</div>
</div>
<script src="../js/jquery.min.js"></script>
</body>
</html>

