<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";
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

<script>

$(document).ready(function() {

});

/*
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "safari",
	content_css : "../css/mce.css"
});
*/

function show_msg(msg){
	alert(msg);
}

</script>
</head>
<body style="background-color: #FFF1E5;">

<div style="float:left;">
<img src="<?php echo SITEROOT;?>/img/nat.png" />
<?php
	echo "Welcome  ".$lgn->getFullName();		
?>
</div>

<div style="float:right; margin:30px;"><a class="btn btn-info" href="<?php echo SITEROOT;?>">Exit</a></div>
<div style="float:right; margin:30px;"><a class="btn btn-info" href="articles-me.php">Back</a></div>
<div style="clear:both;"></div>
<center>	
<?php 
if($msg != ""){
	echo "<h4 style='color:red;'>".$msg."</h4>";	
}
?>	
</center>

<div class="row">
	<div class="col-md-2">
	<?php
	require_once('includes/user-admin-nav.php');
	?>
	</div>
		
	<div class="col-md-10">
		<div style="margin:10px;">
			<form name="form" action="profile-associations.php" method="post" target="_top">
				<div class="lightboxcontent">
				<h2>Add a New Association</h2>
				<fieldset>
				<div class="colcontainer formcols">
					<div class="twocols">
						<label>Name</label>
					</div>
					<div class="twocols">
						<input type="text" name="name" value="" maxlength="255" style="width:500;" />
					</div>
				</div>
				<div class="colcontainer formcols">
					<div class="twocols">
						<label>Description</label>
					</div>
					<div class="twocols">
						<textarea  name="description" rows="5" cols="50"></textarea>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="savebar">
			<button class="btn btn-large btn-success" name="add_association" type="submit"><i class="icon-ok icon-white"></i> Add New Association_id</button>
		</div>
	</form>
</div>
</div>
</div>

<script src="../js/jquery.min.js"></script>

</body>
</html>
