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

if($where == 'mp'){
	$search_results_array =	$search->getResultsFromProfiles($search_string);
	$main_content = "".$view->getMemProfBlock($search_results_array, $prof);

}

if($where == 'ar'){
	
	if(strlen($search_string) > 2){
		$search_results_array =	$search->getResultsFromArticles($search_string);	
		$main_content = $view->getArticBlock($search_results_array, $prof);
	}
}

if($where == 'qa'){
	$search_results_array = $search->getResultsFromQA($search_string);
	$main_content = $view->getQABlock($search_results_array, $prof);
}

if($where == 'all'){

	$search_results_array =	$search->getResultsFromProfiles($search_string);
	$main_content = $view->getMemProfBlock($search_results_array, $prof);

	if(strlen($search_string) > 2){
		$search_results_array =	$search->getResultsFromArticles($search_string);	
		$main_content .= $view->getArticBlock($search_results_array, $prof);
		
		$search_results_array =	$search->getResultsFromQA($search_string);	
		$main_content .= $view->getQABlock($search_results_array, $prof);
		
	}	

}

$article_id = (isset($_GET['article_id'])) ? trim(addslashes($_GET['article_id'])): 0; 
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
<section>
	<div class="container" style="margin-top:40px; margin-bottom:40px; margin-left:40px;">
		<div class="row">
			<div class="col-lg-12 ">
					<form action="explore.php" method="post" onsubmit="return validate(this)" enctype="multipart/form-data">
					<div class="form-group">
						<span class="fa fa-search"></span>
<input type="text" 
id="input_search_string" 
class="form-control" 
name="search_string" 
placeholder="Type a keyword or phrase and hit enter">    

					</div>
					Optionally select area to explore
					<br />
					<select name="where" class="black_select">
						<!--<option value="0">Select What to Explore</option>-->
						<option value="all">All Data</option>
						<option value="qa">Questions and Answers</option>
						<option value="ar">Articles</option>
						<option value="mp">Member Profiles</option>     
					</select>   
					<br />
					<br />
					<button type="submit" class="btn btn-primary">Explore Now</button>
					</form>		
			</div>
		</div>
	</div>
</section>

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
	
<script>

function exp_submit_answer(quid){
	var answ = $("#input_exp_answer").val();
	
	//alert("vvvvvvvv |"+quid+"|");
	//alert("xxxxxxxx "+answ);
	
	/*
	var url_str = "ajax/ajax-send-exp-answer.php?answ="+answ+"&quid="+quid;
	$.ajax({
	  url: url_str,
	  cache: false
	})
	.done(function(data) {
		alert(data);
	
	});
	*/
		
	$.ajaxSetup({ cache: false}); 
		
	$.ajax({
		method: "GET",
		url: "ajax/ajax-send-exp-answer.php",
		data: { answ: answ, quid: quid }
	})
	.done(function( msg ) {
		//alert( "Data Saved: "+msg);
		exp_close_answer();
	});
	
	exp_close_answer();
	
	
}


function exp_close_answer(){
	
	var str = "";
	str += "<button type='button' onClick='exp_add_answer()' class='btn btn-info btn-sm'>Add Answer</button>";	
	
	var x = document.getElementById('exp_answ_box');
	x.innerHTML = str;
		
}

function exp_add_answer(quid){  

	//alert(quid);

	var str = "";
	
	str += "<div style='z-index:7; height:160px; width:100%;'>";	
	str += "<textarea id='input_exp_answer' name='exp_answer' style='width:100%;' rows='4' ></textarea>";		
	str += "<button type='button' onClick='exp_submit_answer("+quid+")' class='btn btn-primary btn-sm'>Submit</button>";	
	str += "<button style='margin-left:20px;' type='button' onClick='exp_close_answer()' class='btn btn-info btn-sm'>Cancel</button>";	
	str += "</div>";
	
	var x = document.getElementById('exp_answ_box');
	x.innerHTML = str;
	
}	
</script>	
	
	
</section>
<?php
require_once('footer.php');
?>
    
</body>
</html>




