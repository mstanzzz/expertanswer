<?php

//define('__ROOT__', dirname(dirname(__FILE__)));
require_once('includes/config.php'); 										

require_once('includes/class.customer_login.php');
$lgn = new CustomerLogin;

$pid = (isset($_GET['pid'])) ? $_GET['pid'] : 0;
if(!is_numeric($pid)) $pid = 0; 

require_once('includes/functions.php');
require_once('includes/class.profess.php');
require_once('includes/class.search.php');
require_once('includes/class.view.php');
$visitor_profile_id = $lgn->getProfileId();
$prof = new Professional;
$search = new Search;
$view = new View;
$slug = (isset($_GET['slug'])) ? $_GET['slug'] : 'home';
if($slug == 'signout'){	
	$lgn->logOut();
	$slug = 'home';	
}
$msg = '';

if(isset($_POST['submit_question'])){
	$visitor_name = trim(addslashes($_POST['visitor_name'])); 
	$visitor_zip = trim(addslashes($_POST['visitor_zip'])); 
	$visitor_email = trim(addslashes($_POST['visitor_email'])); 
	$question = (isset($_POST['question'])) ? trim(addslashes($_POST['question'])) : '';
	$prof_profile_id = (isset($_POST['prof_profile_id'])) ? $_POST['prof_profile_id'] : 0;
	$pid = $prof_profile_id; 
	$is_private = (isset($_POST['is_private'])) ? $_POST['is_private'] : 0; 
	$ts = time();
	$stmt = $db->prepare("INSERT INTO question 
					(visitor_name
					,visitor_zip
					,visitor_email
					,question
					,q_date
					,prof_profile_id
					,is_private)
					VALUES(?,?,?,?,?,?,?)");	
		//echo 'Error 1'.$db->error;
					
	if(!$stmt->bind_param("ssssiii", 
					$visitor_name
					,$visitor_zip
					,$visitor_email
					,$question
					,$ts
					,$prof_profile_id
					,$is_private)){
		echo 'Error 2'.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
		$msg = "Your Question was Sent";
	}


		
	if(strlen($visitor_email) > 7){
		// Email to Customer
		$message = '';	
		$message .= "<html>";
		$message .= "<head>";
		$message .= "<title>Ask an Expert</title>";
		$message .= "</head>";
		$message .= "<body>";
		$message .= "<div style='color:#565656;'>";
		$message .= "<div style='background:#efefef; width:100%; padding:8px;'>";
		$message .= "Your Question ";
		$message .= "</div><br />";
		$message .= "<div style='clear:both;'></div>";
			
		if($visitor_name != ''){		
			$message .= stripslashes($visitor_name)."<br /><br />";
		}
		
		$message .= "Thank you for submiting your question."; 
			
		if(!$lgn->userNameExisis($visitor_email)){	
			$message .= " We would like to invite you to register ....";
				
		}
			
		$message .= "<br /><br /></div>";
		$message .= "</body>";
		$message .= "</html>";
		$subject_c = "Your Question";				
		$headers = "Content-type: text/html; charset=iso-8859-1";	
		$headers .= "\r\n";
		$headers .= "From: services@Expert Answer.com";
		$headers .= "\r\n";
		$headers .= "Return-path: services@Expert Answer.com";
		$headers .= "\r\n";
		$headers .= "CC: mark.stanz@gmail.com";		
		$headers .= "\r\n";
			
		$to = $visitor_email;
		
		if(!mail($to, $subject_c, $message, $headers)){
			
		}
					
	}

}


$p_fn = $prof->getProfImg($pid);

if(strlen($p_fn) < 2){
	$prof_img_path = SITEROOT."./img/noprofile.png"; 
	$prof_img = "<img src='".$prof_img_path." />";
}else{
	$prof_img = "<img src='./saascustuploads/".$pid."/round/".$p_fn."'>";
}

//$search_results_array =	$search->getResultsFromQA();
//$qa_block = $view->getQABlock($search_results_array, $prof);
$qa_block = '';

if(strlen($msg) > 0){
echo "<div style='color:red;'>".$msg."</div>";			
}
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
</head>
<body>

<?php


require_once('nav.php');
?>


<?php
//echo "prof_img: <div style='margin-left:10%;'>".$prof_img."</div>";
?>
<form name="ask_question_form" action="ask.php" method="post" 
	onsubmit="return validate(this)" enctype="multipart/form-data">                    
<section class="ftco-section ftco-no-pt"  style="background-color: #FFF1E5;">
<div class="container">
	<div class="row justify-content-center pb-5 mb-3">
		<h2>Ask a Question</h2>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-md-6">
		<label  for="input_name" style="font-size:1.4em;">
			Your Name or Alias       
		</label>
		<input type="text" name="visitor_name" class="form-control" placeholder="Your Name or Alias">   		
	</div>	
	<div class="form-group col-md-6">
		<label for="input_zip" style="font-size:1.4em;">
			Zip Code <span style="color:blue; font-size:0.7em;">(optional)</span>        
		</label>
		<input type="text" id="input_zip" name="visitor_zip"  class="form-control" 
		placeholder="Zip Code">
	</div>
</div>

<div class="form-row">
	<div class="form-group col-md-6">
		<label for="input_email" style="font-size:1.4em;">
		Email Address 
		<span style="color:blue; font-size:0.7em;">(optional)</span></label>
		<input type="text" id="input_email" name="visitor_email" class="form-control" 
		placeholder="Your Email Address">
	</div>
	<div class="form-group col-md-6">
		<label for="input_prof" style="font-size:1.4em;">
		Select a Member  
		<span style="color:blue; font-size:0.7em;">(optional)</span></label>
		<select id="input_prof" name="prof_profile_id" class="form-control">
		<option value="0">All Members</option>
		<?php
		$member_array = $prof->getAllMembers();
		$block = '';
		$sel = "";
		foreach($member_array as $val){
			$block .= "<option value='".$val['id']."' ".$sel.">".$val['name']."</option>"; 	
		}
		echo $block;
		?>  
		</select>   
	</div>
</div>
		
<div class="form-row">
	<div class="form-group col-md-8">
		<label for="input_question" style="font-size:1.4em;">Question</label>
		<textarea  id="input_question" name="question" class="form-control" rows="6" 
		placeholder="Question"></textarea>
	</div>
	<div class="form-group col-md-4">
		<div style="margin-top:50px;">
			<label for="is_private" style="margin-right:10px; margin-left:10px;">My question is private</label>
			<input id="is_private" name="is_private" type="checkbox" style="width:18px; height:18px;" />
		</div>
	<div style="margin-top:16px; margin-left:10px;">				
	<button type="submit" name="submit_question" class="btn btn-primary">Send Question</button>
	</div>				
</div>
</div>
</div>
</section>
</form>

<?php
if(strlen($qa_block) > 30){
	echo "<h3 class='content-head is-center'>Recent Questions & Answers</h3>";			
	echo $qa_block;
}          	  
?>

<?php
require_once('footer.php');
?>
    
</body>
</html>