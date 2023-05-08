<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}

require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";
	header($header_str);	
}

$profile_id = $lgn->getProfileId();

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$article_id = (isset($_GET['article_id']))? $_GET['article_id'] : 0; 
if(!isset($_SESSION['article_id'])) $_SESSION['article_id'] = $article_id;

if(!isset($_SESSION['added_gallery_img_id'])) $_SESSION['added_gallery_img_id'] = 0;
if(!isset($_SESSION['article_img_gallery_array'])) $_SESSION['article_img_gallery_array'] = array();

$action = (isset($_GET['action']))? $_GET['action'] : '';
                
if($action == 'dmimg'){     
	// delete main img
	$_SESSION['img_id'] = 0;
}
if($action == 'dbimg'){     
	// delete before img
	$_SESSION['img_before_id'] = 0;
}
if($action == 'daimg'){     
	// delete before img
	$_SESSION['img_after_id'] = 0;
}

if($_SESSION['added_gallery_img_id'] > 0){
	
}

if(isset($_POST['change_img_description'])){
	
	$img_id = $_POST['img_id'];
	$description = nl2br($_POST['description']);
	$description = trim($description);
		
	foreach($_SESSION['article_img_gallery_array'] as $key => $val){
		if($val['img_id'] == $img_id){
			$_SESSION['article_img_gallery_array'][$key]['description'] = $description;
		}
	}
}

if(isset($_POST['remove_gallery_item'])){
	
	$img_id = $_POST['img_id'];
	$tmp_array = array();
	$i = 0;
	foreach($_SESSION['article_img_gallery_array'] as $val){
		if($val['img_id'] != $img_id){
			$tmp_array[$i]['img_id'] = $val['img_id'];
			$tmp_array[$i]['file_name'] = $val['file_name'];			
			$tmp_array[$i]['description'] = $val['description'];
			$i++;
		}
	}
	$_SESSION['article_img_gallery_array'] = $tmp_array;	
}


$sql = "SELECT * 
		FROM article 
		WHERE id = '".$_SESSION['article_id']."'";	
			
$result = $dbCustom->getResult($db,$sql);
if($result->num_rows > 0){
	$object = $result->fetch_object();	
	$title = $object->title;
	$sub_heading = $object->sub_heading;
	$category_id = $object->category_id;
	$type = $object->type;
	$content = $object->content;
	$img_id = $object->img_id;
	$img_before_id = $object->img_before_id;
	$img_after_id = $object->img_after_id;
	$posted_by_profile_id = $object->posted_by_profile_id;
	
	
}else{
	$title = "";
	$sub_heading = "";
	$category_id = 0;
	$type = "";
	$content = "";
	$img_id = 0;
	$img_before_id = 0;
	$img_after_id = 0;
	$posted_by_profile_id = 0;
	
}

if(!isset($_SESSION['img_id'])) $_SESSION['img_id'] = $img_id;
if(!isset($_SESSION['img_before_id'])) $_SESSION['img_before_id'] = $img_before_id;
if(!isset($_SESSION['img_after_id'])) $_SESSION['img_after_id'] = $img_after_id;

if(!isset($_SESSION['temp_page_fields']['title'])) $_SESSION['temp_page_fields']['title'] = $title;
if(!isset($_SESSION["temp_page_fields"]['sub_heading'])) $_SESSION['temp_page_fields']['sub_heading'] = $sub_heading;
if(!isset($_SESSION['temp_page_fields']['category_id'])) $_SESSION['temp_page_fields']['category_id'] = $category_id;
if(!isset($_SESSION['temp_page_fields']['type'])) $_SESSION['temp_page_fields']['type'] = $type;
if(!isset($_SESSION['temp_page_fields']['content'])) $_SESSION['temp_page_fields']['content'] = $content;

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

tinymce.init({
	selector: 'textarea',
	plugins: 'advlist link image lists code',
	forced_root_block : false

});

function validate(theform){			
	return true;
}

/*

$(document).ready(function() {

	$('.load').click(function(){
		ajax_set_blog_session();
	});
	
});

function ajax_set_blog_session(){
	
	var q_str = get_query_str();
	$.ajaxSetup({ cache: false}); 
	$.ajax({
		url: '../ajax/ajax_set_temp_session.php'+q_str,
		success: function(data) {
			//alert(data);
		}
	});
}

*/


function get_query_str(){
	
	var query_str = "";
	
	query_str += "?title="+document.form.title.value;
	query_str += "&sub_heading="+document.form.sub_heading.value;
	query_str += "&content="+document.form.content.value;
	
	//alert(query_str);
	
	return query_str;
}
function set_img_id_desc(img_id, gal_desc){
	var img_id_input = document.getElementById("img_id_input_desc");
	img_id_input.value = img_id;
	$("#gal_desc").val(gal_desc);
	ajax_set_blog_session();
}

function set_img_id_remove(img_id){
	var img_id_input = document.getElementById("img_id_input_remove");
	img_id_input.value = img_id;
	ajax_set_blog_session();

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
		
			<center>
			<h3>Edit Article</h3>
			</center>

			<form name="form" action="articles.php" method="post" onSubmit="ajax_set_blog_session();">
        
			<input type="hidden" name="article_id" value="<?php echo $_SESSION['article_id']; ?>" />
			<input type="hidden" name="img_id" value="<?php echo $_SESSION['img_id']; ?>" />
			<input type="hidden" name="img_before_id" value="<?php echo $_SESSION['img_before_id']; ?>" />
			<input type="hidden" name="img_after_id" value="<?php echo $_SESSION['img_after_id']; ?>" />
			
 			<button type="submit" class="btn btn-primary" name="edit_article" >Save </button>
			<br />
			
			<table width="100%" cellpadding="6" border="1">
			<tr>
			<td width="14%">Article Title</td>
			<td><input type="text" name="title" 
			value="<?php echo $_SESSION['temp_page_fields']['title']; ?>" 
			maxlength="250" 
			style="width:460px;" /></td>
			</tr>
			
			<tr>
			<td>Sub Title</td>
			<td><input type="text" name="sub_heading" 
			value="<?php echo $_SESSION['temp_page_fields']['sub_heading']; ?>" 
			maxlength="255" style="width:460px;" /></td>
			</tr>
			
			<tr valign="top">
			<td>Content</td>
			<td>			
			<textarea style="width:100%; height:500px;" id="wysiwyg" class="wysiwyg" name="content">
			<?php echo stripslashes(stripslashes($_SESSION['temp_page_fields']['content'])); ?>
			</textarea>
			</td>			
			</tr>			
			</table>
     		
            <br /><br />
			<?php
			$_SESSION['ret_dir'] = 'manage';
			$_SESSION['ret_page'] = 'edit-article';
			$url_str = "../upload/upload-pre-crop.php";
			$url_str .= "?img_type=article";
			$url_str .= "&cust_id=".$posted_by_profile_id;
			?>
			<a href="<?php echo $url_str; ?>"  class="btn btn-info">Upload Main Image</a>

			<?php
			$sql = "SELECT file_name FROM image WHERE id = '".$_SESSION['img_id']."'";
			$img_result = $dbCustom->getResult($db,$sql);
			if($img_result->num_rows > 0){
				$img_obj = $img_result->fetch_object();                                
				echo "<img src='../saascustuploads/".$posted_by_profile_id."/article/".$img_obj->file_name."'>";
			}

			if(sizeof($_SESSION['article_img_gallery_array']) < 6){						   
				$url_str = "../upload/upload-pre-crop.php";
				$url_str .= "?img_type=gallery";
				//echo  "<a id='add_img' href='".$url_str."' class='pure-button load'>Upload Gallary Image</a><br />";
			}

			foreach($_SESSION["article_img_gallery_array"] as $val){
											
				echo "<div style='float:left;'>";
				echo "<img src='../saascustuploads/profile/".$posted_by_profile_id."/article/gallery/".$val['file_name']."'  alt='gallery image'>";
				echo "</div>";
											
				echo "<div style='float:left; padding-left:20px; width:250px;'>";
				echo stripslashes($val['description'])."<br />";
				echo "<a class='fancybox' style='text-decoration:underline; cursor:pointer;' 
				href='#add_img_description' onclick='set_img_id_desc(\"".$val['img_id']."\", \"".$val['description']."\")'>Add or Edit Description</a>";
				echo "</div>";
											
				echo "<div style='float:left; padding-left:20px;'>";
				echo "<a onclick='set_img_id_remove(\"".$val['img_id']."\")' href='#' class='confirm btn btn-danger'><i class='icon-remove icon-white'></i></a>";	
				echo "</div>";
											
				echo "<div class='clear'><br /></div>";
										
			}
			?>

			</form>


		</div>
	</div>
</div>

<div style="width:100%; height:200px;">&nbsp;</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


</body>
</html>

