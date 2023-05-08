<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
require_once('includes/user_admin_functions.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

unset($_SESSION['img_id']);
unset($_SESSION['img_before_id']);
unset($_SESSION['img_after_id']);
unset($_SESSION['added_gallery_img_id']);
unset($_SESSION['article_img_gallery_array']);
unset($_SESSION['temp_page_fields']);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

<meta charset="utf-8">
<title></title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

</head>
<body style="background-color: #FFF1E5;">

<div style="float:left;">
<img src="<?php echo SITEROOT;?>/img/nat.png" />
<?php
	echo "Welcome  ".$lgn->getFullName();		
?>
</div>

<div style="float:right; margin:30px;"><a class="btn btn-info" href="<?php echo SITEROOT;?>">Exit</a></div>
<div style="float:right; margin:30px;"><a class="btn btn-info" href="profile-skills.php">Back</a></div>
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

			<h1>Blog Articles</h1>
			<div class="subnav_buttons">
				<ul>
					<li><a class="landingbtn add" href="add-article.php"><span>New Blog Article</span></a></li>
					<li><a class="landingbtn blogposts" href="article-all.php"><span>All Articles</span></a></li>
					<li><a class="landingbtn categories" href="categories.php"><span>Categories</span></a></li>
				</ul>
			</div>
</div>
</div>
</div>

<script src="../js/jquery.min.js"></script>
</body>
</html>
