<?php
require_once('../../includes/config.php'); 
require_once('../../includes/class.customer_login.php');
require_once('../includes/user_admin_functions.php');

$lgn = new CustomerLogin;

$profile_id = $lgn->getProfileId();


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


if(!isset($_SESSION['temp_page_fields']['title'])) $_SESSION['temp_page_fields']['title'] = '';
if(!isset($_SESSION["temp_page_fields"]['sub_heading'])) $_SESSION['temp_page_fields']['sub_heading'] = '';
if(!isset($_SESSION['temp_page_fields']['category_id'])) $_SESSION['temp_page_fields']['category_id'] = '';
if(!isset($_SESSION['temp_page_fields']['type'])) $_SESSION['temp_page_fields']['type'] = '';
if(!isset($_SESSION['temp_page_fields']['content'])) $_SESSION['temp_page_fields']['content'] = '';

?>
