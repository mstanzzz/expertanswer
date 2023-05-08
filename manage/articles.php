<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/functions.php');

$lgn = new CustomerLogin;

$profile_id = $lgn->getProfileId();

$page_title = 'Articles';

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$ts = time();

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


if(isset($_POST['edit_article'])){
	
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
			SET active = '0'";
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



unset($_SESSION["article_id"]);
unset($_SESSION["article_img_type"]);
unset($_SESSION["temp_page_fields"]);
unset($_SESSION["img_id"]);
unset($_SESSION["img_before_id"]);
unset($_SESSION["img_after_id"]);
unset($_SESSION["blog_post_id"]);
unset($_SESSION["article_img_gallery_array"]);
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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
			<h1>Articles</h1>
			<form name="form" action="articles.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="set_active_and_featured" value="1">
				<a class="btn btn-info btn-sm" href="add-article.php">Add a New Article </a>
				<a class="btn btn-info btn-sm" href="all-article-comments.php">All Comments</a>
				<br />
				<br />				
				<button href="#" class="btn btn-primary btn-sm">Save Changes </button>
				<br />					
				<?php				
				$sql = "SELECT	article.id
							,article.title
							,article.when_entered
							,article.active
							,profile.name
							,display_order
						FROM article, profile 
						WHERE article.posted_by_profile_id = profile.id 
						ORDER BY article.display_order";							
				$result = $dbCustom->getResult($db,$sql);
				?>

<table width="100%" cellpadding="5">
<tr>
<td width="5%">ID</td>
<td width="35%">Title</td>
<td width="15%">Author</td>
<td width="10%">Date</td>
<td width="5%">Order</td>
<td width="5%">Active</td>
<td width="5%"></td>
<td width="5%"></td>
<td></td>
</tr>
<?php
$block = ""; 
while($row = $result->fetch_object()){
$block .= "<tr>";
$block .= "<td>".$row->id."</td>";
$block .= "<td>".stripslashes($row->title)."</td>";
$block .= "<td>".stripslashes($row->name)."</td>";
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

			
$url_str = "article-comments.php";
$url_str .= "?article_id=".$row->id;
$url_str .= "&ret_page=articles-me";			
$block .= "<td><a class='btn btn-info btn-sm' href='".$url_str."'>Comments</a></td>";

$block .= "<td>";
$block .= "<a class='btn btn-info btn-sm' href='edit-article.php?article_id=".$row->id."'>Edit</a>";
$block .= "</td>";
			
$block .= "<td><a href='articles.php?del_article_id=".$row->id."' 
class='btn btn-danger btn-sm'>DELETE</a>";
$block .= "</td>";
}
$block .= "</table>";
echo $block;

?>
			</form>			
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<?php
//phpinfo();
?>


</body>
</html>
