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

$page_title = "Find";

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;



// add if not exist
$sql = "SELECT id 
		FROM pages 
		WHERE page = 'find' 
		"; 
$result = $dbCustom->getResult($db,$sql);

if($result->num_rows == 0){
	$sql = "INSERT INTO pages 
		(page, profile_account_id) 
		VALUES ('find', '".$_SESSION['profile_account_id']."')"; 
	$result = $dbCustom->getResult($db,$sql);
	
	
	$id = $db->insert_id;
	
}


$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

if(isset($_POST['edit_page'])){

	$head_upper_text = trim(addslashes($_POST['head_upper_text']));
	$id = $_POST['id'];
	
	$stmt = $db->prepare("UPDATE pages
						SET head_upper_text = ?
						WHERE id = ?");
						
		//echo 'Error '.$db->error;	
													
	if(!$stmt->bind_param('si'
						,$head_upper_text
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
}else{
	$head_upper_text = '';
}

if(!isset($_SESSION['temp_page_fields']['id'])) $_SESSION['temp_page_fields']['id'] = $id;
if(!isset($_SESSION['temp_page_fields']['head_upper_text'])) $_SESSION['temp_page_fields']['head_upper_text'] = $head_upper_text;

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


<script
  src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>




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
		<h1>Find Page</h1>
		<?php 
		if($msg != ''){ ?>
		<div class="alert alert-success">
			<h4><?php echo $msg; ?></h4>
		</div>
		<?php } ?>
        
        <a href="page.php" >Back</a>
		<form action="find.php" method="post" enctype="multipart/form-data" >
        
        	<input type="hidden" name="id" value="<?php echo $_SESSION['temp_page_fields']['id']; ?>" />
            
            <input type="hidden" name="edit_page" value="1" />
        
        
            <div class="colcontainer"> 
                <label>Upper Text</label>
                <textarea style="width:600px; height:200px;" name="head_upper_text"><?php echo stripslashes($_SESSION['temp_page_fields']['head_upper_text']); ?></textarea>
            </div>
    
            
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