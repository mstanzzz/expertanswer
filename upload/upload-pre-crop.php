<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
$lgn = new CustomerLogin;	
if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

require_once('../includes/class.upload.php');

$msg = '';

// used when from manage
$cust_id = (isset($_GET['cust_id']))? $_GET['cust_id'] : 0;
if(!is_numeric($cust_id)) $cust_id = 0;

if($cust_id > 0){
	$profile_id = $cust_id;	
}else{
	$lgn = new CustomerLogin;
	$profile_id = $lgn->getProfileId();
}
$_SESSION['profile_id'] = $profile_id;

if(isset($_GET['caption'])) $_SESSION['temp_page_fields']['caption'] = $_GET['caption'];
if(isset($_GET['active'])) $_SESSION['temp_page_fields']['active'] = $_GET['active'];
if(isset($_GET['title'])) $_SESSION['temp_page_fields']['title'] = $_GET['title'];
if(isset($_GET['sub_heading'])) $_SESSION['temp_page_fields']['sub_heading'] = $_GET['sub_heading'];
if(isset($_GET['category_id'])) $_SESSION['temp_page_fields']['category_id'] = $_GET['category_id'];
if(isset($_GET['type'])) $_SESSION['temp_page_fields']['type'] = $_GET['type'];
if(isset($_GET['content'])) $_SESSION['temp_page_fields']['content'] = $_GET['content'];


$path = "../saascustuploads/";
if(!file_exists($path)) {
	mkdir($path);         
}

$path = "../saascustuploads/".$profile_id."/";
if(!file_exists($path)) {
	
	mkdir($path);         
}
$path = "../saascustuploads/".$profile_id."/full/";
if(!file_exists($path)) {
	mkdir($path);         
}
$path = "../saascustuploads/".$profile_id."/round/";
if(!file_exists($path)) {
	mkdir($path);         
}
$path = "../saascustuploads/".$profile_id."/round/large/";
if(!file_exists($path)) {
	mkdir($path);         
}
$path = "../saascustuploads/tmp/";
if(!file_exists($path)) {
	mkdir($path);         
}
$path = "../saascustuploads/tmp/pre-crop/";
if(!file_exists($path)) {
	mkdir($path);         
}
$path = "../saascustuploads/".$profile_id."/article/";
if(!file_exists($path)) {
	mkdir($path);         
}
	
function img_resize($cur_dir, $cur_file, $newwidth, $output_dir, $stretch = 0)
{
		
	if(!file_exists($output_dir)) {
		mkdir($output_dir);         
	}
	$dir = opendir($cur_dir);
     
	$format='';
	if(preg_match("/.jpg/i", "$cur_file"))
	{
		$format = 'image/jpeg';
	}
	if (preg_match("/.gif/i", "$cur_file"))
	{
		$format = 'image/gif';
	}
	if(preg_match("/.png/i", "$cur_file"))
	{
		$format = 'image/png';
	}
     
	if($format!='')
	{
		switch($format)
		{
			 case 'image/jpeg':
			 $source = imagecreatefromjpeg($cur_dir.$cur_file);
			 break;
			 case 'image/gif';
			 $source = imagecreatefromgif($cur_dir.$cur_file);
			 break;
			 case 'image/png':
			 $source = imagecreatefrompng($cur_dir.$cur_file);
			 break;
		}
		 
		list($src_w, $src_h) = getimagesize($cur_dir.$cur_file);
			 
		if($src_w > $newwidth || $stretch == 1){	 

			 $newheight=$src_h*$newwidth/$src_w;
			 $dst_img = imagecreatetruecolor($newwidth,$newheight);
			 $src_image = imagecreatefromjpeg($cur_dir.$cur_file);
			 imagecopyresampled($dst_img, $src_image, 0, 0, 0, 0, $newwidth, $newheight, $src_w, $src_h);
			 imagejpeg($dst_img, $output_dir.$cur_file, 100);
			 imagedestroy($src_image);
		
		}else{			
			//imagejpeg ($source, $output_dir.$cur_file, 100);
			copy($cur_dir.$cur_file,$output_dir.$cur_file);
		}
		 
	}
}



if(isset($_POST['submit'])){

	$foo = new \Verot\Upload\Upload($_FILES['uploadedfile']);
	$dir_dest = "../saascustuploads/tmp/pre-crop/";
	
	$foo->image_convert = 'jpg';
	$foo->jpeg_quality  = 100;
	$foo->process($dir_dest);
	$img_name = '';
	
	if($foo->uploaded) {		

		$foo->image_resize = false;
		$foo->file_overwrite	= false;
		$foo->image_convert = "jpg";		
		$foo->jpeg_quality  = 100;
		
		if ($foo->processed) {
			$img_name = $foo->file_dst_name;
			$r_path = "../saascustuploads/".$profile_id."/full/";
			img_resize($dir_dest, $img_name, 1024, $r_path);

			$_SESSION['pre_cropped_fn'] = $img_name;
			$_SESSION['msg'] = $msg;				
			$header_str = "Location: crop-tool.php";		
			header($header_str);

		}else{
			echo 'error : ' . $foo->error;
		}
		$foo->clean();

	}	
}


$msg = ""; 

if(isset($_GET['img_type'])){
	$_SESSION['img_type'] = trim($_GET['img_type']);
}
if(!isset($_SESSION['img_type'])) $_SESSION['img_type'] = 'profile';

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script>

var submitted = false;
function doSubmit() {
	if (!submitted) {
		submitted = true;
		ProgressImg = document.getElementById('inprogress_img');
		document.getElementById("inprogress").style.visibility = "visible";
		setTimeout("ProgressImg.src = ProgressImg.src",1000);
		return true;
	}else{
		return false;
	}
}
</script>
</head>
<body>

<div style="float:left;">
<img src="<?php echo SITEROOT;?>/img/nat.png" />
<?php
if(!isset($_SESSION['ret_dir'])) $_SESSION['ret_dir'] = "user-admin";
if(!isset($_SESSION['ret_page'])) $_SESSION['ret_page'] = "profile-image";
$back_url = "../".$_SESSION['ret_dir']."/".$_SESSION['ret_page'].".php";
?>
</div>
<div style="float:right; margin:30px;"><a class="btn btn-info" href="<?php echo SITEROOT;?>">Exit</a></div>
<div style="float:right; margin:30px;"><a class="btn btn-info" href="<?php echo $back_url; ?>">Back</a></div>
<div style="clear:both;"></div>

<center>	
<?php 
if($msg != ""){
	echo "<h4 style='color:red;'>".$msg."</h4>";	
}
?>	
</center>

<div class="row">
	<div class="col-md-12">
	<center>
	<form action="../upload/upload-pre-crop.php" method="post" enctype="multipart/form-data" target="_self">
			
	<table>			
	<tr>
	<td>
	<input type="file" name="uploadedfile">				
	</td>
	</tr>

	<tr height="40">
	<td> </td>
	</tr>
			
	<tr>
	<td>
	<button type="submit" name="submit" class="btn btn-primary" 
	onClick="document.getElementById('inprogress').style.visibility='visible'">Upload</button>
	</td>
	</tr>

	<tr height="30">
	<td> </td>
	</tr>
			
	<tr>
	<td>
	<p style="visibility:hidden" id="inprogress"> 
	<img id="inprogress_img" src="<?php echo SITEROOT; ?>/img/progress.gif"> Please Wait... </p>
	</td>
	</tr>
			
	</table>
		
	</form>
	</center>

</div>
</div>
</div>

</body>
</html>