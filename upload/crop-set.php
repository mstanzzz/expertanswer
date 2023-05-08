<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

//$profile_id = $lgn->getProfileId();
$profile_id = $_SESSION['profile_id'];

$x1 = $_POST['x1'];
$y1 = $_POST['y1'];
$x2 = $_POST['x2'];
$y2 = $_POST['y2'];

$orig_img_path = $_POST['orig_img_path'];
$orig_img_fn = $_POST['orig_img_fn'];

list($orig_width, $orig_height) = getimagesize($orig_img_path.$orig_img_fn);

$new_width = $x2 - $x1;

$new_height = $y2 - $y1;

$temp_cropped = '../saascustuploads/tmp/new_cropped'.time().'.jpg';

//$ext = end(explode(".",$orig_img_fn));

$canvas = imagecreatetruecolor($new_width, $new_height);
$src = imagecreatefromjpeg($orig_img_path.$orig_img_fn);
imagecopy($canvas, $src, 0, 0, $x1, $y1, $x2, $y2);
imagejpeg($canvas, $temp_cropped);

$src_w = $new_width;
$src_h = $new_height;

$apath = "../saascustuploads/".$profile_id."/";
if(!file_exists($apath)){
	mkdir($apath);
}

$preview = '';


if(!isset($_SESSION['ret_dir'])) $_SESSION['ret_dir'] = "user-admin";
if(!isset($_SESSION['ret_page'])) $_SESSION['ret_page'] = "profile-image";
if(!isset($_SESSION['img_type'])) $_SESSION['img_type'] = 'profile';

if(strpos($_SESSION['img_type'], 'rofile') !== false){
		
	$stmt = $db->prepare("INSERT INTO image 
			(file_name, slug)
			VALUES
			(?,?)"); 
		//echo 'Error-1 UPDATE   '.$db->error;
	if(!$stmt->bind_param("ss",
		$orig_img_fn
		,$_SESSION['img_type']
		)){
		//echo 'Error-2 UPDATE   '.$db->error;
			
	}else{
		$stmt->execute();
		$stmt->close();		
		//echo 'good';
		
	}		
	
	$_SESSION['img_id'] = $db->insert_id;

	$sql = "DELETE FROM profile_to_img
			WHERE profile_id = '".$profile_id."'";
	$r = $dbCustom->getResult($db,$sql);

	$sql = "INSERT INTO profile_to_img (img_id, profile_id) 
			VALUES ('".$_SESSION['img_id']."', '".$profile_id."')";
	$r = $dbCustom->getResult($db,$sql);


	$new_path_fn = "../saascustuploads/".$profile_id."/".$orig_img_fn;
	$dst_w = 233;
	$dst_h = 233;
	$dst_img = imageCreateTrueColor($dst_w,$dst_h);
	imagecopyresampled($dst_img, $canvas, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	imagejpeg($dst_img,$new_path_fn,88);
	// add white round overlay
	$p_img = $new_path_fn;
	$o_img = '../img/roundWhiteLargeGrey.png';
	$im = imagecreatefromjpeg($p_img);    
	$condicion = GetImageSize($o_img);	
	if($condicion[2] == 1) //gif
	$im2 = imagecreatefromgif($o_img);
	if($condicion[2] == 2) //jpg
	$im2 = imagecreatefromjpeg($o_img);
	if($condicion[2] == 3) //png
	$im2 = imagecreatefrompng($o_img);
	imagecopy($im, $im2, (imagesx($im)/2)-(imagesx($im2)/2), (imagesy($im)/2)-(imagesy($im2)/2), 0, 0, imagesx($im2), imagesy($im2));

	
	$new_path_fn_overlay = "../saascustuploads/".$profile_id."/round/large/".$orig_img_fn;
	imagejpeg($im,$new_path_fn_overlay,90);
	imagedestroy($im);
	imagedestroy($im2);


	$dst_w = 102;
	$dst_h = 102;
	$dst_img = imageCreateTrueColor($dst_w,$dst_h);
	imagecopyresampled($dst_img, $canvas, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	imagejpeg($dst_img,$new_path_fn,88);
	// add white round overlay
	$p_img = $new_path_fn;
   	$o_img = '../img/roundWhite.png'; 
	$im = imagecreatefromjpeg($p_img);    
	$condicion = GetImageSize($o_img);	
	if($condicion[2] == 1) //gif
	$im2 = imagecreatefromgif($o_img);
	if($condicion[2] == 2) //jpg
	$im2 = imagecreatefromjpeg($o_img);
	if($condicion[2] == 3) //png
	$im2 = imagecreatefrompng($o_img);
	imagecopy($im, $im2, (imagesx($im)/2)-(imagesx($im2)/2), (imagesy($im)/2)-(imagesy($im2)/2), 0, 0, imagesx($im2), imagesy($im2));

	
	$new_path_fn_overlay = "../saascustuploads/".$profile_id."/round/".$orig_img_fn;
	imagejpeg($im,$new_path_fn_overlay,90);
	imagedestroy($im);
	imagedestroy($im2);
	
	$preview = $new_path_fn;

}



// gallery
if(strpos($_SESSION['img_type'], 'aller') !== false){

	$new_path_fn = "../saascustuploads/".$profile_id."/".$orig_img_fn;
	if($new_width > 800){
		$dst_w = 800;	
		$dst_h = 800;	
	}else{
		$dst_w = $new_width;	
		$dst_h = $new_height;	
	}

	$dst_img = imageCreateTrueColor($dst_w,$dst_h);
	imagecopyresampled($dst_img, $canvas, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	imagejpeg($dst_img,$new_path_fn,88);
	
	$preview = $new_path_fn;

	$slug = 'gallery';

	$stmt = $db->prepare("INSERT INTO image 
			(file_name, slug)
			VALUES
			(?,?)"); 
		//echo 'Error-1 UPDATE   '.$db->error;
	if(!$stmt->bind_param("ss",
		$orig_img_fn
		,$slug
		)){
		//echo 'Error-2 UPDATE   '.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
		
	}		
	
	$_SESSION['img_id'] = $db->insert_id;


	$stmt = $db->prepare("INSERT INTO profile_to_img 
			(profile_id, img_id)
			VALUES
			(?,?)"); 
		echo 'Error-1 UPDATE   '.$db->error;
	if(!$stmt->bind_param("ii",
		$profile_id
		,$img_id
		)){
		echo 'Error-2 UPDATE   '.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
		
	}		
	
}


if(strpos($_SESSION['ret_page'], 'rticle') !== false){

	$new_path_fn = "../saascustuploads/".$profile_id."/article/".$orig_img_fn;
	
	$slug = 'article';

	if($new_width > 600){
		$dst_w = 600;	
		$dst_h = 600;	
	}else{
		$dst_w = $new_width;	
		$dst_h = $new_height;	
	}
	
	$dst_img = imageCreateTrueColor($dst_w,$dst_h);
	imagecopyresampled($dst_img, $canvas, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	imagejpeg($dst_img,$new_path_fn,88);
	
	$preview = $new_path_fn;

	$stmt = $db->prepare("INSERT INTO image 
			(file_name, slug)
			VALUES
			(?,?)"); 
		//echo 'Error-1 UPDATE   '.$db->error;
	if(!$stmt->bind_param("ss",
		$orig_img_fn
		,$slug
		)){
		//echo 'Error-2 UPDATE   '.$db->error;
			
	}else{
		$stmt->execute();
		$stmt->close();
		
	}		
	
	$_SESSION['img_id'] = $db->insert_id;

}



imagedestroy($src);
imagedestroy($canvas);


	$ret_dest = "../".$_SESSION['ret_dir']."/".$_SESSION['ret_page'].".php?is_new_img=1";

	header('Location: '.$ret_dest);

?>


