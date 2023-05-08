<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
	
$lgn = new CustomerLogin;

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

if(isset($_GET['del_id'])){
	
	$id = (isset($_GET['del_id'])) ? $_GET['del_id'] : 0;
	
	$sql = sprintf("DELETE FROM contact 
			WHERE id = '%u'", $id); 
			
	$result = $dbCustom->getResult($db,$sql);
	
	$msg = 'Deleted';
	
}


if(isset($_GET['clear'])){
	$sql = "DELETE FROM contact";
	$result = $dbCustom->getResult($db,$sql);
	$msg = 'Deleted';
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

		<a class='btn btn-danger' href='contact.php?clear=1'>Clear</a>

		
			<center>
			<h3>Contacts</h3>
			</center>

	<?php 
	$sql = "SELECT * 
		FROM contact
		ORDER BY id DESC";
	$result = $dbCustom->getResult($db,$sql);		
	?>
			        
		<table width="100%" cellpadding="6" border="1" >
		<tr>
		<td></td>		
		<td>Name</td>
		<td>Email</td>
		<td>Date</td>
		<td></td>
		<td></td>
		</tr>
		<?php
		$block = ''; 
		while($row = $result->fetch_object()) {

		$block .= "<tr>";
		$block .= "<td>".$row->id."</td>";					
		$block .= "<td>".stripslashes($row->name)."</td>";					
		$block .= "<td>".$row->id."</td>";					
		$block .= "<td>".$row->id."</td>";	

		$block .= "<td>";
		$block .= "<a class='btn btn-danger' href='contact.php?del_id=".$row->id."'>Delete</a>";
		$block .= "</td>";
		
		

		$block .= "<td>";
		$block .= "<a class='btn btn-info' href='view-contact.php?con_id=".$row->id."'>View</a>";
		$block .= "</td>";
		
		$block .= "</tr>";
		
		

/*		
		$block .= "<tr>";
		$block .= "<td>".$row->id."</td>";					
		$block .= "<td>".stripslashes($row->name)."</td>";			
		$block .= "<td>".$row->email."</td>";								
		$block .= "<td>none</td>";
		$block .= "<td>none</td>";
		$block .= "<td>none</td>";
		$block .= "</tr>";
		
				
		if($row->when_sent > 0){
		$block .= "<td valign='top'>".date("F j, Y, g:i a", $row->when_sent)."</td>";			
		}else{
		$block .= "<td>none</td>";						
		}
		
		$block .= "<td>";
		$block .= "<a class='btn btn-danger' href='contact.php?del_id=".$row->id."'>Delete</a>";
		$block .= "</td>";

		$block .= "<td>";
		$block .= "<a class='btn btn-info' href='view-contact.php?con_id=".$row->id."'>View</a>";
		$block .= "</td>";

		$block .= "</tr>";
*/
		
		}
		
		$block .= "</table>";
		echo $block;				
		?>

		</div>
	</div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
