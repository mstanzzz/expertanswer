<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
require_once('includes/user_admin_functions.php');

$lgn = new CustomerLogin;

$article_id=0;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";
	header($header_str);	
}
$profile_id = $lgn->getProfileId();



if(!isset($profile_id)) $profile_id = 0;
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';
echo $profile_id;
echo "<br />";

//exit;
$article_id=0;
if(isset($_POST['add_article'])){
	
	$content = (isset($_POST['content']))? trim(addslashes($_POST['content'])) : ''; 
	$title = (isset($_POST['title']))? trim(addslashes($_POST['title'])) : '';	
	$sub_heading = (isset($_POST['sub_heading']))? trim(addslashes($_POST['sub_heading'])) : '';	
	$img_id = (isset($_POST['img_id']))? $_POST['img_id'] : 0;

	if(!is_numeric($img_id)) $img_id = 0;

	$stmt = $db->prepare("INSERT INTO article 
						(when_entered
						,posted_by_profile_id
						,title
						,sub_heading
						,content
						,img_id)
						VALUES
						(?,?,?,?,?,?)"); 
								
		echo 'Error-1 UPDATE   '.$db->error;
		echo "<br />";
		
	if(!$stmt->bind_param("iisssi",
					$ts
					,$profile_id
					,$title
					,$sub_heading
					,$content
					,$img_id)){								
		
		echo 'Error-2 UPDATE   '.$db->error;
		echo "<br />";														
			
	}else{
		$stmt->execute();
		$stmt->close();
		
		$article_id = $db->insert_id;
						
		$msg = "Your change is now live.";
	}


}


if(isset($_POST['update_article'])){
	
	$article_id = $_POST['article_id'];		
	$content = (isset($_POST['content']))? trim(addslashes($_POST['content'])) : ''; 
	$title = (isset($_POST['title']))? trim(addslashes($_POST['title'])) : '';	
	$sub_heading = (isset($_POST['sub_heading']))? trim(addslashes($_POST['sub_heading'])) : '';	
	$img_id = (isset($_POST['img_id']))? $_POST['img_id'] : 0;
	
	if(!is_numeric($img_id)) $img_id = 0;
	

	$stmt = $db->prepare("UPDATE article
							SET title = ?
								,sub_heading = ?
								,content = ?
								,img_id = ?
						WHERE id = ?");
								
								//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("sssii",
							$title
							,$sub_heading
							,$content
							,$img_id
							,$article_id)){								
								
	}else{
		$stmt->execute();
		$stmt->close();
				
		$msg = "Your change is now live.";
	}

}

if(isset($_GET["del_article_id"])){

	$article_id = (isset($_GET['del_article_id']))? $_GET['del_article_id'] : 0;	
	if(!is_numeric($article_id)) $article_id = 0;

	$sql = "SELECT article.img_id
				,article.posted_by_profile_id
				,image.file_name				 
			FROM article, image 
			WHERE article.img_id = image.id 
			AND article.id = '".$article_id."'";
	$result = $dbCustom->getResult($db,$sql);
	
	if($result->num_rows > 0){
		$img_obj = $result->fetch_object();
		$sql = "DELETE FROM image WHERE id = '".$img_obj->img_id."'";		
		$res = $dbCustom->getResult($db,$sql);		
		
		$myFile = "../saascustuploads/".$_SESSION['profile_account_id']."/".$img_obj->posted_by_profile_id."/article/".$img_obj->file_name;
		
		if(file_exists($myFile)) unlink($myFile);
	}
		
	$sql = sprintf("DELETE FROM article WHERE id = '%u'", $article_id);
	$result = $dbCustom->getResult($db,$sql);

}

if(isset($_POST['set_active_and_featured'])){
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();

	$display_orders = (isset($_POST['display_order'])) ? $_POST['display_order'] : array();
	$ids = (isset($_POST['id'])) ? $_POST['id'] : array();

	/*	
	$featured = (isset($_POST['is_featured']))? $_POST['is_featured'] : array();
	$sql = "UPDATE article SET type = 'normal' WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
	$result = $dbCustom->getResult($db,$sql);		
	foreach($featured as $key => $value){
		$sql = "UPDATE article SET type = 'featured' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);		
	}
	*/

	$sql = "UPDATE article 
			SET active = '0'
			WHERE posted_by_profile_id = '".$profile_id."'";
	$result = $dbCustom->getResult($db,$sql);		
		
	foreach($actives as $key => $value){
		$sql = "UPDATE article 
				SET active = '1' 
				WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);		
		//echo "key: ".$key."   value: ".$value."<br />"; 
	}
	
	foreach($ids as $key=>$val){
	
		$sql = sprintf("UPDATE article 
						SET display_order = '%u'
						WHERE id = '%u'",
						$display_orders[$key], $val);
		$result = $dbCustom->getResult($db,$sql);
	}

	$msg = "Changes Saved.";

}



unset($_SESSION["article_img_type"]);
unset($_SESSION["temp_page_fields"]);
unset($_SESSION["img_id"]);
unset($_SESSION["img_before_id"]);
unset($_SESSION["img_after_id"]);
unset($_SESSION["blog_post_id"]);
unset($_SESSION["article_img_gallery_array"]);

$sql = "SELECT	article.id
			,article.title
			,article.when_entered
			,article.active
			,display_order
FROM article 
WHERE article.posted_by_profile_id = '".$profile_id."' 
ORDER BY article.display_order";	

//echo $sql;
						
$result = $dbCustom->getResult($db,$sql);

$block = ""; 
while($row = $result->fetch_object()){
	$block .= "<tr>";
	$block .= "<td>".$row->id."</td>";
	$block .= "<td>".stripslashes($row->title)."</td>";
	$block .= "<td>".date("m/d/Y",$row->when_entered)."</td>";

	$block .= "<td>";
	$block .= "<input size='3' type='text' name='display_order[]' value='".$row->display_order."' />";
	$block .= "<input type='hidden' name='id[]' value='".$row->id."' />";
	$block .= "</td>";
					
	$checked = ($row->active) ? "checked='checked'" : "";

	$block .= "<td align='center'>";
	$block .= "<div class='custom-control custom-switch'>";			
	$block .= "<input type='checkbox' name='active[]' value='".$row->id."'";
	$block .= " class='custom-control-input' id='".$row->id."' $checked>";
	$block .= "<label class='custom-control-label' for='".$row->id."'></label>";	
	$block .= "</div>";		
	$block .= "</td>";

	$block .= "<td>";
	$block .= "<a class='btn btn-info btn-sm' href='edit-article.php?article_id=".$row->id."'>Edit</a>";
	$block .= "</td>";
				
	$block .= "<td><a href='articles-me.php?del_article_id=".$row->id."' 
	class='btn btn-danger btn-sm'>DELETE</a>";
	$block .= "</td>";
}
//echo $block;



?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="<?php echo "../favicon.png"; ?>" >
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
</head>
<body style="background-color: #FFF1E5;">
<?php
	require_once('includes/user-admin-nav.php');
?>
<main class="container my-3 p-0">
<div class="card shadow-sm">
	<div class="card-header">Articles Me</div>
		<div class="card-body">			
			<form name="form" action="articles-me.php" method="post" enctype="multipart/form-data">              
				<input type="hidden" name="set_active_and_featured" value="1">
				<div class="d-flex justify-content-end mb-3">
					<div>
						<button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save Changes</button>			
					</div>
					<div class="ml-3">
						<a class="btn btn-info" href="add-article.php"><i class="icon-plus"></i> Add a New Article </a>			
					</div>
				</div>
<div class="card mt-3 shadow-sm">
<div class="card-body">
<div class="table-responsive">
<table class="table">
<thead>
<tr class="table-secondary">
<th>Title</th>
<th>Date</th>
<th>Active</th>
<th width="12%">Comments</th>
<th width="12%">Edit</th>
<th width="5%">Delete</th>
</tr>
</thead>
<tbody>
<?php
echo $block;
?>
</tbody>
</table>
</div>
</div>
</div>
</form>
</div>
</div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
let activeNav="profile-article";
</script>
<?php
require_once('navbar-effect.php');
?>
</body>
</html>




