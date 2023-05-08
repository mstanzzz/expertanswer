<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();

$page_title = "Skills";



$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$is_private = (isset($_GET['is_private'])) ? $_GET['is_private'] : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
<script src="../js/tinymce/tinymce.min.js"></script>

<script>
tinymce.init({
	selector: 'textarea'
});
</script>
</head>
<body>

<div style="margin-left:20px;">
	<img height="40" src="<?php echo SITEROOT;?>/img/nat.png" />
	<?php
	echo "<span>Welcome  ".$lgn->getFullName()."<span>";
	echo "<span style='margin-left:30px; color:red; font-size:1.3em;'>".$msg."</span>";
	echo "<br />";
	require_once('includes/manage-nav.php');
	?>
</div>

<div class="row">		
	<div class="col-md-12">
		<div style="margin:10px;">
	
			<?php
			$stmt = $db->prepare("SELECT question
							,visitor_name
							,visitor_email
							,contact_directly
							,q_date	
							FROM question 
							WHERE id = ?");
								
				//echo 'Error-1 '.$db->error;				
						
			if(!$stmt->bind_param("i", $_SESSION['question_id'])){
				echo 'Error-2 '.$db->error;
			}else{
						
				$stmt->execute();
							 
				$stmt->bind_result($question
						,$visitor_name
						,$visitor_email
						,$contact_directly
						,$q_date);
							 
				$stmt->fetch();
							 
				$stmt->close();	
			}

		?>

		<a class="btn btn-small" href="view-question.php">Go Back</a>

		<form name="form" action="edit-question.php" method="post" target="_top">
    
        	<h2 class="center-text">Answer Question</h2>
				<div class="colcontainer formcols">
					<div class="twocols">
						<label>Customer Name</label>
						<label>Customer Email</label>
						<label>Date Submitted</label>
					</div>
					<div class="twocols matchlabels">
                        <?php
							echo "<p>$visitor_name</p>";
							if($contact_directly){
								echo "<p><a href='mailto:".$visitor_email."'>$visitor_email</a></p>";
							}else{
								echo "<p>$visitor_email</p>";								
							}							
							echo "<p>".date("m/d/Y",$q_date)."</p>";
						?>
					</div>
				</div>
            
            <label>Question</label>
            <?php echo $question ?>
            
			<hr />
			<br />
			
            <label>Your Answer</label>
			
			<textarea style="width:100%; height:300px;" name="answer"></textarea>
			
			<br />
			
            <button class="btn btn-success" name="add_answer" type="submit">Submit Answer </button>

	
			</form>
		
		</div>
    </div>
</div>

<div style="width:100%; height:200px;">&nbsp;</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>

