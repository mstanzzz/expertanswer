<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}

require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
require_once($real_root.'/includes/functions.php');
require_once('includes/user_admin_functions.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();

$page_title = 'Articles';

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$ts = time();

if(isset($_POST['add_article'])){
	
	$content = trim(addslashes($_POST['content'])); 
	$title = trim(addslashes($_POST['title']));	
	$sub_heading = trim(addslashes($_POST['sub_heading']));	
	$category_id = $_POST['category_id'];
	$type = $_POST['type'];	
	$img_id = $_POST['img_id'];
	$img_before_id = $_POST['img_before_id'];
	$img_after_id = $_POST['img_after_id'];
	
	
	$stmt = $db->prepare("INSERT INTO article 
						(when_entered
						,category_id
						,posted_by_profile_id
						,title
						,sub_heading
						,content
						,type
						,img_id
						,img_before_id
						,img_after_id
						,profile_account_id)
						VALUES
						(?,?,?,?,?,?,?,?,?,?,?)"); 
								
							//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("iiissssiiii",
					$ts
					,$category_id
					,$profile_id
					,$title
					,$sub_heading
					,$content
					,$type
					,$img_id
					,$img_before_id
					,$img_after_id
					,$_SESSION['profile_account_id'])){								
								
			
	}else{
		$stmt->execute();
		$stmt->close();
		
		$article_id = $db->insert_id;
						
		$msg = "Your change is now live.";
	}

	if(isset($_SESSION["article_img_gallery_array"])){
		foreach($_SESSION["article_img_gallery_array"] as $val){

			$stmt = $db->prepare("INSERT INTO article_gallery 
								(img_id
								,article_id
								,description)
								VALUES
								(?,?,?)"); 
										
									//echo 'Error-1 UPDATE   '.$db->error;
										
			if(!$stmt->bind_param("iis",
							$val['img_id']
							,$article_id
							,$val['description'])){								
										
					
			}else{
				$stmt->execute();
				$stmt->close();
								
				$msg = "Your change is now live.";
			}
		}
	}


}

if(isset($_POST['edit_article'])){
	
	$article_id = $_POST['article_id'];		
	$content = trim(addslashes($_POST['content'])); 
	$title = trim(addslashes($_POST['title']));
	$sub_heading = trim(addslashes($_POST['sub_heading']));	
	$category_id = $_POST['category_id'];
	$type = $_POST['type'];	
	$img_id = $_POST['img_id'];
	$img_before_id = $_POST['img_before_id'];
	$img_after_id = $_POST['img_after_id'];
	

	$stmt = $db->prepare("UPDATE article
							SET category_id = ?
								,title = ?
								,sub_heading = ?
								,content = ?
								,type = ?
								,img_id = ?
								,img_before_id = ?
								,img_after_id = ?
						WHERE id = ?");
								
								//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("issssiiii",
							$category_id
							,$title
							,$sub_heading
							,$content
							,$type
							,$img_id
							,$img_before_id
							,$img_after_id	 
							,$article_id)){								
								
	}else{
		$stmt->execute();
		$stmt->close();
				
		$msg = "Your change is now live.";
	}


	$sql = "DELETE FROM article_gallery WHERE article_id = '".$article_id."'";
	$result = $dbCustom->getResult($db,$sql);
	
	if(isset($_SESSION["article_img_gallery_array"])){
		foreach($_SESSION["article_img_gallery_array"] as $val){
							
			$stmt = $db->prepare("INSERT INTO article_gallery 
								(img_id
								,article_id
								,description)
								VALUES
								(?,?,?)"); 
										
									//echo 'Error-1 UPDATE   '.$db->error;
										
			if(!$stmt->bind_param("iis",
							$val['img_id']
							,$article_id
							,$val['description'])){								
										
					
			}else{
				$stmt->execute();
				$stmt->close();
								
				$msg = "Your change is now live.";
			}		
		}
	}

}

if(isset($_POST["del_article"])){

	$article_id = $_POST['del_article_id'];

	$sql = "SELECT article.img_id, image.file_name 
			FROM article, image 
			WHERE article.img_id = image.id 
			AND article.id = '".$article_id."'";
	$result = $dbCustom->getResult($db,$sql);
	
	if($result->num_rows > 0){
		$img_obj = $result->fetch_object();
		$sql = "DELETE FROM image WHERE id = '".$img_obj->img_id."'";		
		$res = $dbCustom->getResult($db,$sql);		
		
		$myFile = "../saascustuploads/".$_SESSION['profile_account_id']."/".$profile_id."/article/".$img_obj->file_name;
		
		if(file_exists($myFile)) unlink($myFile);
	}
	

	$sql = "SELECT article.img_before_id, image.file_name 
			FROM article, image 
			WHERE article.img_id = image.id 
			AND article.id = '".$article_id."'";
	
	$result = $dbCustom->getResult($db,$sql);
	if($result->num_rows > 0){
		$img_obj = $result->fetch_object();
		$sql = "DELETE FROM image WHERE id = '".$img_obj->img_before_id."'";

		$res = $dbCustom->getResult($db,$sql);		

		$myFile = "../saascustuploads/".$_SESSION['profile_account_id']."/".$profile_id."/article/beforafter/".$img_obj->file_name;

		if(file_exists($myFile)) unlink($myFile);
	}


	
	$sql = "SELECT article.img_after_id, image.file_name 
			FROM article, image 
			WHERE article.img_id = image.id 
			AND article.id = '".$article_id."'";
	$result = $dbCustom->getResult($db,$sql);
	if($result->num_rows > 0){
		$img_obj = $result->fetch_object();
		$sql = "DELETE FROM image WHERE id = '".$img_obj->img_after_id."'";

		$res = $dbCustom->getResult($db,$sql);		

		$myFile = "../saascustuploads/".$_SESSION['profile_account_id']."/".$profile_id."/article/beforafter/".$img_obj->file_name;

		if(file_exists($myFile)) unlink($myFile);
	}
		

	$sql = "SELECT image.file_name 
			FROM article_gallery, image 
			WHERE article_gallery.img_id = image.id 
			AND article_gallery.article_id = '".$article_id."'";
	$result = $dbCustom->getResult($db,$sql);
	if($result->num_rows > 0){
		$img_obj = $result->fetch_object();
		$sql = "DELETE FROM image WHERE id = '".$img_obj->img_after_id."'";

		$res = $dbCustom->getResult($db,$sql);		
	
		$myFile = "../saascustuploads/".$_SESSION['profile_account_id']."/".$profile_id."/article/gallery/".$img_obj->file_name;

		if(file_exists($myFile)) unlink($myFile);
	}


	$sql = sprintf("DELETE FROM article WHERE id = '%u'", $article_id);
	$result = $dbCustom->getResult($db,$sql);

	$sql = sprintf("DELETE FROM article_gallery WHERE article_id = '%u'", $article_id);
	$result = $dbCustom->getResult($db,$sql);

}

if(isset($_POST['set_active_and_featured'])){
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
	$featured = (isset($_POST['is_featured']))? $_POST['is_featured'] : array();

	$sql = "UPDATE article SET type = 'normal' WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
	$result = $dbCustom->getResult($db,$sql);		

	
	foreach($featured as $key => $value){
		$sql = "UPDATE article SET type = 'featured' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);		
		//echo "key: ".$key."   value: ".$value."<br />"; 
	}

	$sql = "UPDATE article SET active = '0' WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
	$result = $dbCustom->getResult($db,$sql);		
		
	foreach($actives as $key => $value){
		$sql = "UPDATE article SET active = '1' WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);		
		//echo "key: ".$key."   value: ".$value."<br />"; 
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

<div style="float:left;">
<img src="<?php echo SITEROOT;?>/img/nat.png" />
<?php
	echo "Welcome  ".$lgn->getFullName();		
?>
</div>

<div style="float:right; margin:30px;"><a class="btn btn-info" href="<?php echo SITEROOT;?>">Exit</a></div>

<div style="float:right; margin:30px;"><a class="btn btn-info" href="start.php">Back</a></div>
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
		<div style="margin-right:20px; margin-left:10px;">

			<form name="form" action="articles-all.php" method="post" enctype="multipart/form-data">              
        	<input type="hidden" name="set_active_and_featured" value="1">

			<div style="float:left;">
			<button class="btn btn-primary" type="submit"> Save Changes </button>			
			</div>

			<div style="float:left; margin-left:20px;">
			<a class="btn btn-info" href="add-article.php">Add a New Article </a>			
			</div>
			
			<div style="clear:both;"></div>
			
			<br /><br />
            <?php
			$truncate = (isset($_GET['truncate'])) ? $_GET['truncate'] : 1;
			$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : '';
			$a_d = (isset($_GET['a_d'])) ? $_GET['a_d'] : 'a';
			$pagenum = (isset($_GET['pagenum'])) ? $_GET['pagenum'] : 0;
 			
			$sql = "SELECT * FROM article 
					WHERE posted_by_profile_id = '".$profile_id."'";	
			if(isset($_POST['product_search'])){
				$search_str = trim(mysql_real_escape_string($_POST["product_search"]));
				$sql .= " AND (title like '%".$search_str."%' || title like '%".$search_str."%')";
			}
			$nmx_res = $dbCustom->getResult($db,$sql);							
			
			$total_rows = $nmx_res->num_rows;
			$rows_per_page = 16;
			$last = ceil($total_rows/$rows_per_page); 
			
			if ($pagenum < 1){ 
				$pagenum = 1; 
			}elseif ($pagenum > $last){ 
				$pagenum = $last; 
			} 
		
			$limit = ' limit ' .($pagenum - 1) * $rows_per_page.','.$rows_per_page;
			
			if($sortby != ''){
				if($sortby == 'title'){
					if($a_d == 'd'){
						$sql .= " ORDER BY title DESC".$limit;
					}else{
						$sql .= " ORDER BY title".$limit;	
					}
				}
				if($sortby == 'category_id'){
					if($a_d == 'd'){
						$sql .= " ORDER BY category_id DESC".$limit;
					}else{
						$sql .= " ORDER BY category_id".$limit;		
					}
				}
				if($sortby == 'type'){
					if($a_d == 'd'){
						$sql .= " ORDER BY type DESC".$limit;
					}else{
						$sql .= " ORDER BY type".$limit;		
					}
				}
				if($sortby == 'when_entered'){
					if($a_d == 'd'){
						$sql .= " ORDER BY when_entered DESC".$limit;
					}else{
						$sql .= " ORDER BY when_entered".$limit;		
					}
				}
				if($sortby == 'active'){
					if($a_d == 'd'){
						$sql .= " ORDER BY active DESC".$limit;
					}else{
						$sql .= " ORDER BY active".$limit;		
					}
				}
			}else{
				$sql .= " ORDER BY id".$limit;					
			}

			$result = $dbCustom->getResult($db,$sql);
			
			if($total_rows > $rows_per_page){
                echo getSocialAdminPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "blog-all.php", $sortby, $a_d);
				echo "<br />";
			}

			require_once("includes/tablesort.php"); 
			?>

			<table width="100%" cellpadding="6" border="1">
			<tr>
			<td <?php addSortAttr('title',true); ?>>
			Title
			<i <?php addSortAttr('title',false); ?>></i>
			</td>
			<td <?php addSortAttr('when_entered',true); ?>>
			Date
			<i <?php addSortAttr('when_entered',false); ?>></i>
			</td>
			<td>
			Featured
			</td>
			<td <?php addSortAttr('active',true); ?>>
			Active
			<i <?php addSortAttr('active',false); ?>></i>
			</td>
			<td width="12%">Edit</td>
			<td width="5%">Delete</td>
			</tr>
			<?php
			$block = ""; 
			while($row = $result->fetch_object()){
			$block .= "<tr>";
			$block .= "<td>$row->title</td>";
			$block .= "<td>".date("m/d/Y",$row->when_entered)."</td>";
			$checked = ($row->type == 'featured') ? "checked='checked'" : "";	
			$block .= "<td>";
			$block .= "<input type='checkbox' name='is_featured[]' value='".$row->id."' $checked />";
			$block .= "</td>";	
			$checked = ($row->active) ? "checked='checked'" : "";							
			$block .= "<td>";
			$block .= "<input type='checkbox' name='active[]' value='".$row->id."' $checked />";
			$block .= "</td>";	
			
			$url_str = "edit-article.php";
			$url_str .= "?article_id=".$row->id;
			$url_str .= "&ret_page=articles-me";
			
			$block .= "<td><a class='btn btn-info' href='".$url_str."'>Edit</a></td>";
			$block .= "<td><a class='btn btn-danger'>";
			$block .= "<input type='hidden' id='".$row->id."' class='itemId' value='".$row->id."' />Delete</a></td>";	
			}
			$block .= "</table>";
			echo $block;
			if($total_rows > $rows_per_page){
			echo getSocialAdminPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "blog-all.php", $sortby, $a_d);
			}
			?>
			</form>

		</div>
	</div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
