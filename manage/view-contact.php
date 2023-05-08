<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
	
$lgn = new CustomerLogin;

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$con_id = (isset($_GET['con_id']))? $_GET['con_id'] : 0;
if(!is_numeric($con_id)) $con_id = 0;

$sql = "SELECT * 
		FROM contact
		WHERE id = '".$con_id."'";
$result = $dbCustom->getResult($db,$sql);		

//echo "num_rows ".$result->num_rows; 
//echo "<br />";

if($result->num_rows > 0){
	$object = $result->fetch_object();
	$name = $object->name;
	$email = $object->email;
	$subject = $object->subject;
	$message = $object->message;
	$when_sent = $object->when_sent;	
}else{
	$name = '';
	$email = '';
	$subject = '';
	$message = '';
	$when_sent = time();	
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

<?php

echo "<a class='btn btn-danger' href='contact.php?del_id=".$con_id."'>Delete</a>";
echo "<br />";
echo "<a class='btn btn-info' href='contact.php'>Back</a>";
echo "<br />";



	echo "name ".$name;
	echo "<hr />";
	echo "email ".$email;
	echo "<hr />";
	echo "subject ".$subject;
	echo "<hr />";
	echo "message ".$message;
	echo "<hr />";	
	echo "when_sent ".date("F j, Y, g:i a", $when_sent);	
	echo "<hr />";	




?>
<a href="contact.php">Back</a>
          
<br />
<br />

<a href="contact.php?del_id=<?php echo $con_id; ?>">DELETE</a>

<br />
<br />

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
