<?php
require_once("../../../includes/config.php");
require_once("../../includes/class.admin_login.php");
//require_once("includes/class.setup_progress.php");
	
$lgn = new CustomerLogin;


//$progress = new SetupProgress;

$page_title = "Footer";

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;




// add if not exist
$sql = "SELECT id 
		FROM footer 
		WHERE profile_account_id = '".$_SESSION['profile_account_id']."'"; 
$result = $dbCustom->getResult($db,$sql);

if($result->num_rows == 0){
	$sql = "INSERT INTO footer 
		(profile_account_id) 
		VALUES ('".$_SESSION['profile_account_id']."')"; 
	$result = $dbCustom->getResult($db,$sql);
		
	//$id = $db->insert_id;	
}


$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

if(isset($_POST['edit_footer'])){

	$left_text = trim(addslashes($_POST['left_text']));
	$id = $_POST['id'];
	
	$stmt = $db->prepare("UPDATE footer
						SET left_text = ?
						WHERE profile_account_id = ?");
						
		//echo 'Error '.$db->error;	
													
	if(!$stmt->bind_param('si'
						,$left_text
						,$_SESSION['profile_account_id'])){
			
		//echo 'Error-2 '.$db->error;
					
	}else{
	
		$stmt->execute();
		$stmt->close();		
		
		$msg = 'success';
	}

	
	
	

}

$sql = "SELECT *  
		FROM footer
		WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
$result = $dbCustom->getResult($db,$sql);

if($result->num_rows > 0){
	$object = $result->fetch_object();
	$left_text = $object->left_text;
}else{
	$left_text = '';
}

if(!isset($_SESSION['temp_page_fields']['left_text'])) $_SESSION['temp_page_fields']['left_text'] = $left_text;


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<link type="text/css" rel="stylesheet" href="../../../css/manageStyle.css" />



<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>


<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  


<script
  src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>


<script type="text/javascript" language="javascript" src="<?php echo SITEROOT; ?>/js/fancybox2/source/jquery.fancybox.pack.js?v=2.1"></script>



<script type="text/javascript">

$(document).ready(function() {

	$(".fancybox").fancybox({

	});

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

/*

	tinyMCE.init({
        // General options
        mode : "specific_textareas",
        editor_selector : "wysiwyg",
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

function regularSubmit() {
  document.form.action = 'policy.php';
  document.form.target = '_self';
  document.form.submit(); 
}	

</script>


</head>

<body>
<?php


	require_once('../../includes/manage-header.php');
	//require_once('/includes/manage-top-nav.php');
?>
<div class="manage_page_container">
	<div class="manage_side_nav">
		<?php 
        require_once('../../includes/manage-side-nav.php');
        ?>
	</div>
	<div class="manage_main">
		<h1>Footer</h1>
		<?php 
		if($msg != ''){ ?>
		<div class="alert alert-success">
			<h4><?php echo $msg; ?></h4>
		</div>
		<?php } ?>

        <form action="ask.php" method="post" enctype="multipart/form-data" >
        
            <input type="hidden" name="edit_footer" value="1" />
        
        
            <div class="colcontainer"> 
                <label>Left Side Text</label>
                <textarea class="" name="left_text"><?php echo stripslashes($_SESSION['temp_page_fields']['left_text']); ?></textarea>
            </div>
    
            
            <a class='fancybox' href="ask.php">KKKKKKKKKKKKKKKKKKKK</a>
            
            
            <input type="submit" name="submit" value="Submit" />

        
        </form>

	</div>
	<p class="clear"></p>
	<?php
	require_once('../../includes/manage-footer.php');
	?>
</div>

</body>
</html>