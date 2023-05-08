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

$page_title = "Social Media";



$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<link type="text/css" rel="stylesheet" href="../../../css/manageStyle.css" />

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  


<script>
function regularSubmit() {
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
		<h1>Social Media</h1>
		<?php 
		if($msg != ''){ ?>
		<div class="alert alert-success">
			<h4><?php echo $msg; ?></h4>
		</div>
		<?php } ?>
        
        <?php
		
		$sql = "SELECT url 
				FROM social_media_links 
				WHERE name = 'twitter'
				";
		$result = $dbCustom->getResult($db,$sql);
		
		if($result->num_rows > 0){
			$object = $result->fetch_object();
			$twitter_url = $object->url;	
		}else{
			$sql = "INSERT INTO social_media_links
					(url, name, profile_account_id)
					VALUES
					('http://twitter.com', 'twitter', '".$_SESSION['profile_account_id']."')";
			
			$result = $dbCustom->getResult($db,$sql);
			$twitter_url = 'http://twitter.com';	
		}
		

		$sql = "SELECT url 
				FROM social_media_links 
				WHERE name = 'facebook'
				";
		$result = $dbCustom->getResult($db,$sql);
		if($result->num_rows > 0){
			$object = $result->fetch_object();	
			$facebook_url = $object->url;
		}else{
			$sql = "INSERT INTO social_media_links
					(url, name, profile_account_id)
					VALUES
					('http://facebook.com', 'facebook', '".$_SESSION['profile_account_id']."')";
			$result = $dbCustom->getResult($db,$sql);	
			$facebook_url = 'http://facebook.com';
		}
		
		$sql = "SELECT url 
				FROM social_media_links 
				WHERE name = 'youtube'
				";
		$result = $dbCustom->getResult($db,$sql);
		if($result->num_rows > 0){
			$object = $result->fetch_object();
			$youtube_url = $object->url;	
		}else{
			$sql = "INSERT INTO social_media_links
					(url, name, profile_account_id)
					VALUES
					('http://youtube.com', 'youtube', '".$_SESSION['profile_account_id']."')";
			$result = $dbCustom->getResult($db,$sql);
			$youtube_url = 'http://youtube.com';	
		}
		
		$sql = "SELECT url 
				FROM social_media_links 
				WHERE name = 'pinterest'
				";
		$result = $dbCustom->getResult($db,$sql);
		if($result->num_rows > 0){
			$object = $result->fetch_object();
			$pinterest_url = $object->url;	
		}else{
			$sql = "INSERT INTO social_media_links
					(url, name, profile_account_id)
					VALUES
					('http://pinterest.com', 'pinterest', '".$_SESSION['profile_account_id']."')";
			$result = $dbCustom->getResult($db,$sql);
			$pinterest_url = 'http://pinterest.com';	
		}
		
		
		
		
		
		?>
            
        <form name="search_form" action="edit-social-media-links.php" method="post" enctype="multipart/form-data">
        
        <div class="colcontainer"> 
        <label>Twitter</label>
        <input style="width:80%;" type="text" name="twitter_url" value="<?php echo $twitter_url; ?>" />
		</div>    	

        <div class="colcontainer"> 
        <label>Facebook</label>
        <input style="width:80%;" type="text" name="facebook_url" value="<?php echo $facebook_url; ?>" />
		</div>    	

        <div class="colcontainer"> 
        <label>Youtube</label>
        <input style="width:80%;" type="text" name="youtube_url" value="<?php echo $youtube_url; ?>" />
		</div>    	
                    
        <div class="colcontainer"> 
        <label>Pinterest</label>
        <input style="width:80%;" type="text" name="pinterest_url" value="<?php echo $pinterest_url; ?>" />
		</div>    	
                    
        <div class="colcontainer"> 
		<input type="submit" name="submit" value="Submit" />
		</div>    	
                    
                    
		</form>
		
		
	
    </div>
	<p class="clear"></p>
	<?php 
	require_once($real_root.'/manage/includes/manage-footer.php');
	
	?>
</div>

</body>
</html>
