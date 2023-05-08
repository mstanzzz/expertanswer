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
	
$page_title = "Add Portfolio Item";

$msg = '';

if(!isset($_SESSION['img_id'])){$_SESSION['img_id'] = 0;}	

if(!isset($_SESSION["temp_page_fields"]["caption"])) $_SESSION["temp_page_fields"]["caption"] = "";
if(!isset($_SESSION["temp_page_fields"]["active"])) $_SESSION["temp_page_fields"]["active"] = 0;

?>
<!doctype html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Expert Answer</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

<style>

.fancybox-slide--iframe .fancybox-content {
	width  : 600px;
	height : 300px;
	margin: 0;
}

</style>

<script>


$(document).ready(function() {
	
	$(".upload").click(function(e){
		//e.preventDefault();		
		save_session();
	});

});

function save_session(){
	
	var q_str = "?action=portfolio"+get_query_str();
		
	$.ajaxSetup({ cache: false}); 
	$.ajax({
	  url: '../ajax/ajax_set_temp_session.php'+q_str,
	  success: function(data) {
			//$('#t').html(data);
			//alert(data);
			//alert('Load was performed.');
		  	//window.location=f_id;
	  }
	});
}

function get_query_str(){
	
	var query_str = "";
	query_str += "&caption="+$("#caption").val();
	query_str += (document.form.active.checked)? "&active=1" : "&active=0"; 
 
	return query_str;
}



</script>
</head>
<body style="background-color: #FFF1E5;">

<div style="float:left;">
<img src="<?php echo SITEROOT;?>/img/nat.png" />
<?php
	echo "Welcome  ".$lgn->getFullName();		
?>
</div>

<div style="float:right; margin:30px;"><a class="btn btn-info" href="<?php echo SITEROOT;?>">Exit</a></div>
<div style="float:right; margin:30px;"><a class="btn btn-info" href="#">Back</a></div>
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
		
    
		<form name="form" action="profile-portfolio.php" method="post">

		<input type="hidden" name="img_id" value="<?php echo $_SESSION['img_id']; ?>" />

		<h2><?php  echo $page_title; ?></h2>
        
			<fieldset class="colcontainer formcols">
				<div class="twocols">
					<label>Current Image</label>
				<?php
                    
					
					$sql = "SELECT file_name FROM image WHERE id = '".$_SESSION['img_id']."'";
					$img_result = $dbCustom->getResult($db,$sql);
					if($img_result->num_rows > 0){
						$img_obj = $img_result->fetch_object(); 
						echo "<img src='../saascustuploads/".$_SESSION['profile_account_id']."/".$profile_id."/portfolio/".$img_obj->file_name."'>";
					}
            	?>
                </div>
				<div class="twocols">
				<?php 
				//$url_str = "upload.php";
				$_SESSION['ret_page'] = 'add-profile-portfolio-item';
				
				$url_str = SITEROOT."/user-admin/../upload/upload-pre-crop.php";
				//$url_str .= "?ret_page=add-profile-portfolio-item";
				?>
 				<a id="upload" href="<?php echo $url_str; ?>" class="btn btn-primary">Upload new Image</a>
				</div>
			</fieldset>
			<fieldset class="colcontainer formcols">
				<div class="twocols">
					<label>Caption</label>
				</div>
				<div class="twocols">
            		<input id="caption" type="text" name="caption" value="<?php echo $_SESSION['temp_page_fields']['caption']; ?>">
				</div>
			</fieldset>

			<fieldset class="colcontainer formcols">
				<div class="twocols">
					<label>Active?</label>
				</div>
				<div class="twocols">
					<div class="checkboxtoggle on"> <span class="ontext">ON</span><a class="switch on" href="#"></a><span class="offtext">OFF</span>
                    <input type="checkbox" class="checkboxinput" name="active" value="1"
                    <?php if($_SESSION['temp_page_fields']['active']) echo "checked='checked'"; ?> /></div>
				</div>
			</fieldset>

            <button class="btn btn-large btn-success" name="add_portfolio_item" type="submit" > Save Changes </button>
		


        
	</form>

</div>
</div>
</div>

<script src="../js/jquery.min.js"></script>

</body>
</html>


