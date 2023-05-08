<?php
require_once('../includes/config.php');
require_once('../includes/class.admin_login.php');
	
$lgn = new CustomerLogin;

$page_title = "Ask Organizer Profiles";

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$profile_id = (isset($_GET['profile_id'])) ? $_GET['profile_id'] : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>

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

					$block = '';
					
					
					
					if ($stmt = $db->prepare("SELECT 	
												active
												,bio	
												,public_email
												,name
												,company
												,website
												,address_one
												,address_two
												,city
												,state
												,zip
												,country
												,phone_one
												,phone_two
												,about
     											FROM profile WHERE profile_id = ?")) {
						
						$stmt->bind_param("i", $profile_id);
						
						 $stmt->execute();
						 
						 $stmt->bind_result($active
											,$bio	
											,$public_email
											,$name
											,$company
											,$website
											,$address_one
											,$address_two
											,$city
											,$state
											,$zip
											,$country
											,$phone_one
											,$phone_two
											,$about);
						 
						 $stmt->fetch();
						 
						 $stmt->close();	
					}
					?>
	
	<table>
    <tr>
    	<td width="40%">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td>Bio</td>
        <td><?php echo $bio; ?></td>
    </tr>
    <tr>
    	<td>Public Email Address</td>
        <td><?php echo $public_email; ?></td>
    </tr>
    <tr>
    	<td>Company</td>
        <td><?php echo $company; ?></td>
    </tr>
    <tr>
    	<td>Website</td>
        <td><?php echo $website; ?></td>
    </tr>
    <tr>
    	<td>Address Line 1</td>
        <td><?php echo $address_one; ?></td>
    </tr>
    <tr>
    	<td>Address Line 2</td>
        <td><?php echo $address_two; ?></td>
    </tr>
    <tr>
    	<td>About</td>
        <td><?php echo $about; ?></td>
    </tr>
    
    </table>    
    
            
<br />
<br />
<br />
<br />

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
