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

$article_id = (isset($_GET['article_id'])) ? $_GET['article_id'] : 0;

if(isset($_POST['set_active'])){
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
	$sql = "UPDATE article_comment 
			SET active = '0' 
			WHERE article_id = '".$article_id."'";
	$result = $dbCustom->getResult($db,$sql);
		
	foreach($actives as $value){
		$sql = "UPDATE article_comment 
				SET active = '1' 
				WHERE id = '".$value."'";				
		$result = $dbCustom->getResult($db,$sql);
	}

	$msg = "Changes Saved.";

}


if(isset($_GET['del_id'])){

	$id = $_GET['del_id'];
	if(!is_numeric($id)) $id = 0;

	$sql = "DELETE FROM article_comment 
			WHERE id = '".$id."'
			AND article_id = '".$article_id."'";
	$result = $dbCustom->getResult($db,$sql);

}

$c_array = array();
$sql = "SELECT id
			,entered_by_profile_id
			,name
			,email
			,comment
			,when_entered
			,active
		FROM article_comment 
		WHERE article_id = '".$article_id."'";		
$result = $dbCustom->getResult($db,$sql);
$i = 0;
while($row = $result->fetch_object()){
	$c_array[$i]['id'] = $row->id;
	$c_array[$i]['entered_by_profile_id'] = $row->entered_by_profile_id;
	$c_array[$i]['name'] = $row->name;
	$c_array[$i]['email'] = $row->email;	
	$c_array[$i]['comment'] = $row->comment;
	$c_array[$i]['when_entered'] = $row->when_entered;
	$c_array[$i]['active'] = $row->active;
	$i++;	
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

<script>

tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	content_css : "../css/mce.css"
});

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

			<form name="form" action="article-comments.php?article_id=<?php echo $article_id; ?>" method="post" enctype="multipart/form-data">       
        	<input type="hidden" name="set_active" value="1">
			<input class="btn btn-primary btn-sm" type="submit" value="Set Actives" />
			<table cellpadding="10" cellspacing="0">
			<tr>
			<td width="40%">Comment</td>
			<td width="20%">Name</td>
			<td width="20%">Email</td>
			<td width="10%">Date</td>
			<td width="5%">Active</td>
			<td width="5%"></td>
			</tr>
			<?php
			$block = '';
			foreach($c_array as $val){
							
				$block .= "<tr>";
				$block .= "<td>".$val['comment']."</td>";
				$block .= "<td>".$val['name']."</td>";
				$block .= "<td>".$val['email']."</td>";
				$block .= "<td>".date("m/d/Y",$val['when_entered'])."</td>";
				
$checked = ($val['active']) ? "checked='checked'" : '';							
$block .= "<td align='center'>";
$block .= "<div class='custom-control custom-switch'>";			
$block .= "<input type='checkbox' name='active[]' value='".$val['id']."'";
$block .= " class='custom-control-input' id='".$val['id']."' $checked>";
$block .= "<label class='custom-control-label' for='".$val['id']."'></label>";	
$block .= "</div>";		

						
$url_str = "article-comments.php";
$url_str .= "?article_id=".$article_id;
$url_str .= "&del_id=".$val['id'];
	
$block .= "<td><a href='".$url_str."'"; 
$block .= " class='btn btn-danger btn-sm'>DELETE</a>";
$block .= "</td>";
$block .= "</tr>";
			
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
</html>

