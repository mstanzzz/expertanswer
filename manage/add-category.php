<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
$lgn = new CustomerLogin;
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

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

			<form  name="form" action="categories.php" method="post" target="_top">
			<input type="hidden" name="add_cat" value="1" />
        
        
        	<br />
			Add Category
			<br /><br />
            <label>Name</label>
            <br />
			<input type="text" name="name" value='' maxlength="255" style="width:400px;" />
            <br />
			<button class="btn btn-large btn-success" name="add_category" type="submit">Add</button>
            <br /><br />
			</form>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>



