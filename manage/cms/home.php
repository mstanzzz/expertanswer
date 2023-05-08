<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
		$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
		$real_root = '..'; 	
	}
}

require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
//require_once("includes/class.setup_progress.php");
	
$lgn = new CustomerLogin;


//$progress = new SetupProgress;

$page_title = "Home";

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;



// add if not exist
$sql = "SELECT id 
		FROM pages 
		WHERE page = 'home' 
		"; 
$result = $dbCustom->getResult($db,$sql);

if($result->num_rows == 0){
	$sql = "INSERT INTO pages 
		(page, profile_account_id) 
		VALUES ('home', '".$_SESSION['profile_account_id']."')"; 
	$result = $dbCustom->getResult($db,$sql);
	
	$id = $db->insert_id;
	
}

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

if(isset($_POST['edit_page'])){

	$head_upper_text = trim(addslashes($_POST['head_upper_text']));
	$upper_mid_extra_text = trim(addslashes($_POST['upper_mid_extra_text']));
	$color_box_left_text = trim(addslashes($_POST['color_box_left_text']));
	$color_box_mid_text = trim(addslashes($_POST['color_box_mid_text']));
	$color_box_right_text = trim(addslashes($_POST['color_box_right_text']));




	$id = (isset($_POST['id'])) ? $_POST['id'] : 0;

	$stmt = $db->prepare("UPDATE pages
						SET head_upper_text = ?
						,upper_mid_extra_text = ?
						,color_box_left_text = ?
						,color_box_mid_text = ?
						,color_box_right_text = ?
						WHERE id = ?");
						
		//echo 'Error '.$db->error;	
													
	if(!$stmt->bind_param('sssssi'
						,$head_upper_text
						,$upper_mid_extra_text
						,$color_box_left_text
						,$color_box_mid_text
						,$color_box_right_text
						,$id)){
			
		//echo 'Error-2 '.$db->error;
					
	}else{
	
		$stmt->execute();
		$stmt->close();		
		
		$msg = 'success';
	}
	
	unset($_SESSION['temp_page_fields']);
	
}


$sql = "SELECT *  
		FROM pages
		WHERE id = '".$id."'";
$result = $dbCustom->getResult($db,$sql);

if($result->num_rows > 0){
	$object = $result->fetch_object();
	$head_upper_text = $object->head_upper_text;
	$upper_mid_extra_text = $object->upper_mid_extra_text;
	$color_box_left_text = $object->color_box_left_text;
	$color_box_mid_text = $object->color_box_mid_text;
	$color_box_right_text = $object->color_box_right_text;

}else{
	$head_upper_text = '';
	$upper_mid_extra_text = '';
	$color_box_left_text = '';
	$color_box_mid_text = '';
	$color_box_right_text = '';
	
}


if(!isset($_SESSION['temp_page_fields']['id'])) $_SESSION['temp_page_fields']['id'] = $id;
if(!isset($_SESSION['temp_page_fields']['head_upper_text'])) $_SESSION['temp_page_fields']['head_upper_text'] = $head_upper_text;
if(!isset($_SESSION['temp_page_fields']['upper_mid_extra_text'])) $_SESSION['temp_page_fields']['upper_mid_extra_text'] = $upper_mid_extra_text;

if(!isset($_SESSION['temp_page_fields']['color_box_left_text'])) $_SESSION['temp_page_fields']['color_box_left_text'] = $color_box_left_text;
if(!isset($_SESSION['temp_page_fields']['color_box_mid_text'])) $_SESSION['temp_page_fields']['color_box_mid_text'] = $color_box_mid_text;
if(!isset($_SESSION['temp_page_fields']['color_box_right_text'])) $_SESSION['temp_page_fields']['color_box_right_text'] = $color_box_right_text;



?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/manageStyle.css" />

<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/base_sarah.css" />

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>


<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  


<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/tiny_mce/tiny_mce.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>

<script>
$(document).ready(function() {

/*
	$(".fancybox").click(function(e){
		
		var q_str = "?page=policy"+get_query_str();
		$.ajaxSetup({ cache: false}); 
		$.ajax({
		  url: 'ajax_set_page_session.php'+q_str,
		  success: function(data) {
			//alert(data);
		  }
		});
	});
*/	

});

/*
	tinyMCE.init({
        // General options
        mode : "specific_textareas",
		selector: '.wysiwyg',
        //editor_selector : "wysiwyg_1",
        theme : "advanced",
        skin : "o2k7",
        plugins : "table,advhr,advlink,emotions,inlinepopups,insertdatetime,searchreplace,paste,style",
        // Theme options
        theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,styleselect,formatselect,fontsizeselect,|,forecolor,backcolor",
        theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,link,unlink,",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,code",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false
	});
*/


function get_query_str(){
	
	var query_str = '';
	query_str += "&page_heading="+$("#page_heading").val().replace('&', '%26');
	query_str += "&img_alt_text="+$("#img_alt_text").val().replace('&', '%26'); 
	query_str += "&content="+escape(tinyMCE.get('content').getContent());

	return query_str;
}


function regularSubmit() {
  document.form.action = 'policy.php';
  document.form.target = '_self';
  document.form.submit(); 
}	

</script>

</head>

<body>
<?php

	require_once('includes/manage-header.php');
	//require_once('/includes/manage-top-nav.php');
?>
<div class="manage_page_container">
	<div class="manage_side_nav">
		<?php 
        require_once($real_root.'/manage/includes/manage-side-nav.php');
        ?>
	</div>
	<div class="manage_main">
		<h1>Home Page</h1>
		<?php 
		if($msg != ''){ ?>
		<div class="alert alert-success">
			<h4><?php echo $msg; ?></h4>
		</div>
		<?php } ?>
        
        <a href="page.php" >Back</a>
		<br />
        
        <form action="home.php" method="post" enctype="multipart/form-data" >
        
        	<input type="hidden" name="id" value="<?php echo $_SESSION['temp_page_fields']['id']; ?>" />
            
            <input type="hidden" name="edit_page" value="1" />
        
        
            <div class="colcontainer"> 
                <label style="font-size:18px;">Upper Text</label>
                <textarea style="width:600px; height:200px;" name="head_upper_text"><?php echo stripslashes($_SESSION['temp_page_fields']['head_upper_text']); ?></textarea>
            </div>
    		<br /><br />
            <div class="colcontainer"> 
                <label style="font-size:18px;">Under Header Text</label>
                <textarea style="width:600px; height:200px;" name="upper_mid_extra_text"><?php echo stripslashes($_SESSION['temp_page_fields']['upper_mid_extra_text']); ?></textarea>
            </div>
            <br /><br />

            <div class="colcontainer"> 
                <label style="font-size:18px;">Color Third Box Left Text</label>
                <textarea style="width:600px; height:200px;" name="color_box_left_text"><?php echo stripslashes($_SESSION['temp_page_fields']['color_box_left_text']); ?></textarea>
            </div>
            <br /><br />
            <div class="colcontainer"> 
                <label style="font-size:18px;">Color Third Box Mid Text</label>
                <textarea style="width:600px; height:200px;" name="color_box_mid_text"><?php echo stripslashes($_SESSION['temp_page_fields']['color_box_mid_text']); ?></textarea>
            </div>
            <br /><br />
            <div class="colcontainer"> 
                <label style="font-size:18px;">Color Third Box Right Text</label>
                <textarea style="width:600px; height:200px;" name="color_box_right_text"><?php echo stripslashes($_SESSION['temp_page_fields']['color_box_right_text']); ?></textarea>
            </div>
            
			<br /><br />
            
            <input type="submit" name="submit" value="Submit" />



        
        </form>

	</div>
	<p class="clear"></p>
	<?php
	require_once($real_root.'/manage/includes/manage-footer.php');
	?>
</div>

</body>
</html>