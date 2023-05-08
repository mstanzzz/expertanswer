<?php
if(!isset($real_root)){
	if(strpos($_SERVER['REQUEST_URI'], 'expertnat/' )){    
		$real_root = $_SERVER['DOCUMENT_ROOT'].'/expertnat'; 
	}else{
		$real_root = '..'; 	
	}
}
require_once('../includes/config.php'); 										
require_once('../includes/class.customer_login.php');
$lgn = new CustomerLogin;

$ts = time();
$msg = '';

if(isset($_POST['submit_signup'])){
	$name = (isset($_POST['name'])) ? trim($_POST['name']) : ''; 	
	$password = (isset($_POST['password'])) ? trim($_POST['password']) : ''; 	
	$username = (isset($_POST['username'])) ? trim($_POST['username']) : ''; 	
	$u_id = $lgn->getProfileIdByEmail($username);
	
	if($u_id == 0){
		if($lgn->create_user($password, $username, $name)){								
			header('Location: '.SITEROOT.'/user-admin/user-admin-landing.php?thr=365');
		}
	}else{
		$msg = "The Email Address Already Has Been Used";		
	}
	
}

if(isset($_POST['submit_signin'])){
	$username = isset($_POST['username'])? trim($_POST['username']) : '';
	$password = isset($_POST['password'])? trim($_POST['password']) : '';	
	if($lgn->login($username,$password)){
		header('Location: '.SITEROOT.'/user-admin/user-admin-landing.php?thr=365');
	}else{
		$msg = 'The username and password was not recognized';	
	}
}

require_once($real_root.'/includes/functions.php');
require_once('../includes/class.profess.php');
require_once($real_root.'/includes/class.search.php');
require_once($real_root.'/includes/class.view.php');

$visitor_profile_id = $lgn->getProfileId();
$prof = new Professional;
$search = new Search;
$view = new View;

$slug = (isset($_GET['slug'])) ? $_GET['slug'] : 'home';

if($slug == 'signout'){	
	$lgn->logOut();
	$slug = 'home';	
}

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="<?php echo SITEROOT;?>/css/style.css">

<title>Expert Nat</title>
	
	
<style>

</style>




<script>

function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}


function getScreenWidth(){
		
	//var w = screen.width;
	var w = window.innerWidth;
	
	alert("------- width:"+w);
	
}

</script>


</head>
<body>

<div class="container" style="background-color: #FDEBD0;  min-height:1200px;">


<br />

<a style="margin-right:20px;" href="index.php?slug=home"><img src="images/nat.png" /></a>
<a style="margin-right:20px;" href="index.php?slug=home" <?php if($slug == 'home') echo "class='active'"; ?>>Home</a>
<a style="margin-right:20px;" href="index.php?slug=ask" <?php if($slug == 'ask') echo "class='active'"; ?>>Ask</a>
<a style="margin-right:20px;" href="index.php?slug=explore" <?php if($slug == 'explore') echo "class='active'"; ?>>Explore</a>

<a style="margin-right:20px;" href="index.php?slug=articles" <?php if($slug == 'articles') echo "class='active'"; ?>>Articles</a>


<?php
if($lgn->isLogedIn()){
	echo "<a style='margin-right:20px; padding-top:30px;' href='index.php?slug=signout'>Sign Out</a>";
	echo "<a style='margin-right:20px; padding-top:30px;' href='user-admin/user-admin-landing.php?from=nav&li=6389'>My Admin</a>";
}else{					
	$sel = ($slug == 'signup')? 'active' : '';		
	echo "<a style='margin-right:20px; padding-top:30px;' href='index.php?slug=signin' class='pure-menu-link ".$sel."'>Sign In / Sign up</a>";				
}
?> 

<br /><br />

<?php

require_once($real_root.'/pages/'.$slug.'.php');

?> 








<?php
//require_once($real_root.'/pages/footer.php'); 
?>

</div>

<a onClick="getScreenWidth()" > ... Get Window Width ...</a>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
