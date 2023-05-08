<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();

$ts = time();

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";

if(isset($_GET['del_video_id'])){

	$id = $_GET["del_video_id"];
	if(!is_numeric($id)) $id = 0;	
		
	$sql ="DELETE FROM video 
			WHERE id = '".$id."'";
	$result = $dbCustom->getResult($db,$sql);

	$msg = "Image deleted.";
}

if(isset($_POST['set_active'])){
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	$display_orders = (isset($_POST['display_order'])) ? $_POST['display_order'] : array();
	$ids = (isset($_POST['id'])) ? $_POST['id'] : array();
	
	$sql = "UPDATE video SET active = '0'";
	$result = $dbCustom->getResult($db,$sql);

	foreach($actives as $key => $value){
		$sql = "UPDATE video 
				SET active = '1' 
				WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
	}
	foreach($ids as $key=>$val){	
		$sql = sprintf("UPDATE video 
						SET display_order = '%u'
						WHERE id = '%u'",
						$display_orders[$key], $val);
		$result = $dbCustom->getResult($db,$sql);
	}

	
	$msg = "Changes Saved.";

}


if(isset($_POST['add_video'])){
	
	$title = (isset($_POST['title']))? addslashes($_POST['title']) : '';
	$url = (isset($_POST['url']))? addslashes($_POST['url']) : '';

	$stmt = $db->prepare("INSERT INTO video 
						(title
						,url
						,profile_id
						,when_entered)
						VALUES
						(?,?,?,?)"); 
								
		//echo 'Error-1 UPDATE   '.$db->error;
		//echo "<br />";
								
	if(!$stmt->bind_param("ssii",
					$title
					,$url
					,$profile_id
					,$ts)){								
								
		//echo 'Error-2 UPDATE   '.$db->error;
		//echo "<br />";
			
	}else{
		$stmt->execute();
		$stmt->close();
		
		$v_id = $db->insert_id;
						
		$msg = "Your video was added.";
	}

}


if(isset($_POST['update_video'])){
	
	$title = (isset($_POST['title']))? addslashes($_POST['title']) : '';
	$url = (isset($_POST['url']))? addslashes($_POST['url']) : '';
	$id = (isset($_POST['id']))? addslashes($_POST['id']) : '';

	$stmt = $db->prepare("UPDATE video 
						SET title = ?
							,url = ?
						WHERE id = ?"); 
								
		//echo 'Error-1 UPDATE   '.$db->error;
		//echo "<br />";
								
	if(!$stmt->bind_param("ssi",
					$title
					,$url
					,$id)){								
								
		//echo 'Error-2 UPDATE   '.$db->error;
		//echo "<br />";
			
	}else{
		$stmt->execute();
		$stmt->close();
						
		$msg = "Your video was added.";
	}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

<style>

</style>

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
<div style='clear:both;'></div>
<br />
<div class="row">		
	<div class="col-md-12">
		<div style="margin-left:15px;">		
			<form name="form" action="videos.php" method="post">
            <input type="hidden" name="set_active" value="1" />
			<div style="float:left;">
			<button class="btn btn-primary btn-sm" type="submit"> Save Changes </button>			
			</div>

			<div style="float:left; margin-left:20px;">
			<a class="btn btn-info btn-sm" href="add-video.php">Add a New Video </a>			
			</div>
				
			<br />
			<br />			
			<table border="1" width="100%;">
			<tr>
			<td width="50%">&nbsp;</td>
			<td width="10%">Order</td>
			<td width="10%">Active</td>
			<td width="10%">&nbsp;</th>			
			<td>&nbsp;</th>
			</tr>
			<?php
					
$sql = "SELECT id, url, title, active, display_order
		FROM video
		ORDER BY display_order";
$result = $dbCustom->getResult($db,$sql);
$num_rows = $result->num_rows;
					
$block = "";
while($row = $result->fetch_object()) {

$block .= "<tr height='50px;'>";

$block .= "<td><a href='".stripslashes($row->url)."' target='_blank'>".stripslashes($row->title)."</a></td>";						
						
$block .= "<td>";
$block .= "<input type='text' size='3' name='display_order[]' value='".$row->display_order."' />";
$block .= "<input type='hidden' name='id[]' value='".$row->id."' />";
$block .= "</td>";


$checked = ($row->active || $num_rows < 2)? "checked" : "";
						
$block .= "<td align='center'>";
$block .= "<div class='custom-control custom-switch'>";			
$block .= "<input type='checkbox' name='active[]' value='".$row->id."'";
$block .= " class='custom-control-input' id='".$row->id."' $checked>";
$block .= "<label class='custom-control-label' for='".$row->id."'></label>";	
$block .= "</div>";		
$block .= "</td>";	

$block .= "<td align='center'>";
$block .= "<a href='edit-video.php?v_id=".$row->id."' class='btn btn-info btn-sm'>";
$block .= "Edit</a>";							
$block .= "</td>";
						

$block .= "<td align='center'>";
$block .= "<a href='videos.php?del_video_id=".$row->id."' class='btn btn-danger btn-sm'>";
$block .= "Delete</a>";							
$block .= "</td>";

$block .= "</tr>";

}
echo $block;
?>

		


				</table>

			</form>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
