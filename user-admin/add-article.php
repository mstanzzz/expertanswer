<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

	$title = '';
	$sub_heading = "";
	$category_id = 0;
	$type = "";
	$content = "";
	$img_id = 0;
	$img_before_id = 0;
	$img_after_id = 0;

if(!isset($_SESSION['img_id'])) $_SESSION['img_id'] = 0;
if(!isset($_SESSION['img_before_id'])) $_SESSION['img_before_id'] = $img_before_id;
if(!isset($_SESSION['img_after_id'])) $_SESSION['img_after_id'] = $img_after_id;
if(!isset($_SESSION['temp_page_fields']['title'])) $_SESSION['temp_page_fields']['title'] = $title;
if(!isset($_SESSION["temp_page_fields"]['sub_heading'])) $_SESSION['temp_page_fields']['sub_heading'] = $sub_heading;
if(!isset($_SESSION['temp_page_fields']['category_id'])) $_SESSION['temp_page_fields']['category_id'] = $category_id;
if(!isset($_SESSION['temp_page_fields']['type'])) $_SESSION['temp_page_fields']['type'] = $type;
if(!isset($_SESSION['temp_page_fields']['content'])) $_SESSION['temp_page_fields']['content'] = $content;



$sql = sprintf("SELECT * FROM image WHERE id = '%u'", $_SESSION['img_id']);
$result = $dbCustom->getResult($db,$sql);
if($result->num_rows > 0){
	$object = $result->fetch_object();
	$file_name = $object->file_name;
}else{
	$file_name = '';
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="icon" 
			type="image/png" 
			href="<?php echo "../favicon.png"; ?>" >

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Expert Answer</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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


</script>

	</head>
	<body style="background-color: #FFF1E5;">
		<?php
			require_once('includes/user-admin-nav.php');
		?>

		<div class="container my-3 p-0">
			<div class="d-flex justify-content-end">
				<a class="btn btn-info" href="articles-me.php"><i class="icon-arrow-left"></i> Back</a>
			</div>
		</div>



		<main class="container my-3 p-0">
			<div class="card shadow-sm">
				<div class="card-header">Edit Article</div>
				<div class="card-body">

					<form name="form" action="articles-me.php" method="post">
				
						<input type="hidden" name="add_article" value="1" />
						<input type="hidden" name="img_id" value="<?php echo $_SESSION['img_id']; ?>" />
						<input type="hidden" name="img_before_id" value="<?php echo $_SESSION['img_before_id']; ?>" />
						<input type="hidden" name="img_after_id" value="<?php echo $_SESSION['img_after_id']; ?>" />
						
						<div class="d-flex justify-content-end mt-3">
							<button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
						</div>
						
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" 
							value="<?php echo stripslashes($_SESSION['temp_page_fields']['title']); ?>" 
							maxlength="250" 
							class="form-control" />
						</div>

						<div class="form-group">
							<label for="sub_heading">Sub Title</label>
							<input type="text" name="sub_heading" 
							value="<?php echo stripslashes($_SESSION['temp_page_fields']['sub_heading']); ?>" 
							maxlength="250" 
							class="form-control" />
						</div>

						<div class="form-group">
							<label for="content">Content</label>
							<textarea class="form-control" name="content"
							rows="20"><?php echo stripslashes($_SESSION['temp_page_fields']['content']); ?>
							</textarea>
						</div>
					
						<div class="d-flex justify-content-end mt-3">
<?php
$_SESSION['ret_dir'] = "user-admin";
$_SESSION['ret_page'] = "edit-article";
$f_path = "../saascustuploads/".$profile_id."/article/";
?>						
						
						
<!--  onClick="ajax_set_session(1);" -->
<a href="../upload/upload-pre-crop.php"  class="btn btn-info">
<i class="icon-cloud-upload"></i> 
Upload Image
</a>
						</div>
					</form>
				</div>
			</div>
			
<img src="<?php echo $f_path.$file_name; ?>">			
			
			
		</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>

function ajax_set_session(){
	
	url_str = "ajax/ajax-set-session-data.php";
	
	//Salert("set");
	
}

</script>

		
	</body>
</html>


