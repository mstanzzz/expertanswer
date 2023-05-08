<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
		$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
		$real_root = '..'; 	
	}
}

require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
//require_once("includes/class.setup_progress.php");
	
$lgn = new CustomerLogin;


$page_title = "Pages";



$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';


$sql = "SELECT id 
		FROM pages 
		WHERE page = 'home' 
		";
$result = $dbCustom->getResult($db,$sql);
if($result->num_rows > 0){
	$object = $result->fetch_object();
	$home_page_id = $object->id;  
}else{
	$home_page_id = 0;	
}

$sql = "SELECT id 
		FROM pages 
		WHERE page = 'ask' 
		";
$result = $dbCustom->getResult($db,$sql);
if($result->num_rows > 0){
	$object = $result->fetch_object();
	$ask_page_id = $object->id;  
}else{
	$ask_page_id = 0;	
}

$sql = "SELECT id 
		FROM pages 
		WHERE page = 'find' 
		";
$result = $dbCustom->getResult($db,$sql);
if($result->num_rows > 0){
	$object = $result->fetch_object();
	$find_page_id = $object->id;  
}else{
	$find_page_id = 0;	
}


$sql = "SELECT id 
		FROM pages 
		WHERE page = 'explore' 
		";
$result = $dbCustom->getResult($db,$sql);
if($result->num_rows > 0){
	$object = $result->fetch_object();
	$explore_page_id = $object->id;  
}else{
	$explore_page_id = 0;	
}

unset($_SESSION['temp_page_fields']);
//unset($_SESSION['pages']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/manageStyle.css" />

<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/base_sarah.css" />

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  


<script>
function regularSubmit() {
  document.form.submit(); 
}	
</script>
</head>

<body>
<?php

	require_once('includes/manage-header.php');
	//require_once('/includes/manage-top-nav.php');
?>
<div class="manage_page_container">
	<div class="manage_side_nav">
		<?php 
        require_once($real_root.'/manage/includes/manage-side-nav.php');
        ?>
	</div>
	<div class="manage_main">
		<h1>Pages</h1>
		<?php 
		if($msg != ''){ ?>
		<div class="alert alert-success">
			<h4><?php echo $msg; ?></h4>
		</div>
		<?php } ?>

		<div class="data_table">
			<table cellpadding="15" cellspacing="0">
				<thead>
				<tr>
					<th width="80%">Page Name</th>
                    <th>Edit</th>
				</tr>
				</thead>

				<tr> 
					<td>Home</td>						
                    <td><a class='btn btn-primary' href='home.php?id=<?php echo $home_page_id; ?>'> Edit</a></td>
				</tr>
				<tr> 
					<td>Ask</td>						
                    <td><a class='btn btn-primary' href='ask.php?id=<?php echo $ask_page_id; ?>'> Edit</a></td>
				</tr>
				<tr> 
					<td>Find</td>						
                    <td><a class='btn btn-primary' href='find.php?id=<?php echo $find_page_id; ?>'> Edit</a></td>
				</tr>
				<tr> 
					<td>Explore</td>						
                    <td><a class='btn btn-primary' href='explore.php?id=<?php echo $explore_page_id; ?>'> Edit</a></td>
				</tr>
			</table>
		</div>


	</div>
	<p class="clear"></p>
	<?php
	require_once($real_root.'/manage/includes/manage-footer.php');
	?>
</div>

</body>
</html>