<?php
//define('__ROOT__', dirname(dirname(__FILE__)));
require_once('includes/config.php'); 
require_once('includes/class.customer_login.php');
$lgn = new CustomerLogin;
require_once('includes/functions.php');
require_once('includes/class.profess.php');
require_once('includes/class.search.php');
require_once('includes/class.view.php');
$visitor_profile_id = $lgn->getProfileId();
$prof = new Professional;
$search = new Search;
$view = new View;
$msg = '';
$main_content = "";
$search_string = (isset($_POST['search_string']))? trim(addslashes($_POST['search_string'])): ''; 
$where = (isset($_POST['where'])) ? trim(addslashes($_POST['where'])): 'all'; 
$search_results_array = array();
if($where == 'all'){
	$search_results_array =	$search->getResultsFromProfiles($search_string);
	$main_content = $view->getMemProfBlock($search_results_array, $prof);
}


$state = '';
$cat = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

<title>Expert Answer</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
<meta name="google-signin-client_id" content="874343353343-qlj921hrcnvt8srlhmvk69i4t0ivti2q.apps.googleusercontent.com">   
<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/flat_icon.css">    	
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/magnific-popup.css">    
    <!-- owl.carousel -->
    <!-- owl.theme -->
	

<style>

img {
  max-width: 460px;
  height: auto;
}

</style>
	
	
</head>
<body>

</head>
<body style="background-color: #FFF1E5;">
<?php
//require_once('top.php');
require_once('nav.php');
?>
<!--
<section>
	<div class="container" style="margin-top:40px; margin-bottom:40px; margin-left:40px;">
		<div class="row">
			<div class="col-lg-12 ">
					<form action="profiles.php" method="post" enctype="multipart/form-data">

					Optionally Select Specially or Profession
					<br />

					<select name="where" class="black_select">
						
						<option value="0">Select What to Explore</option>
						
						<option value="all">All Members</option>     
				
					</select>   

					<br />
					<br />
					<button type="submit" class="btn btn-primary">Explore Now</button>
					</form>		
			</div>
		</div>
	</div>
</section>
-->
<section>
<div class="container" style="margin-top:40px; margin-bottom:40px; margin-left:40px;">
	<div class="row">
	
	
	
	
		<div class="col-lg-12 ">

<?php
echo stripAllSlashes($main_content);
?>


		</div>
	</div>
</div>
	
</section>
<?php
require_once('footer.php');
?>
    
</body>
</html>




