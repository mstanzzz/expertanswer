<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/functions.php');
require_once('../includes/class.profess.php');

$lgn = new CustomerLogin;
$prof = new Professional;

$page_title = "Skills";

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$answerid = (isset($_GET['answerid'])) ? $_GET['answerid'] : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
<script src="../js/tinymce/tinymce.min.js"></script>

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
								,$contact_directly);							 
				$stmt->fetch();				 
				$stmt->close();	
			}


			$stmt = $db->prepare("SELECT answer
							FROM answer 
							WHERE question_id = ? 
							AND id = ?");
				//echo 'Error-1 '.$db->error;				
			if(!$stmt->bind_param("ii", $_SESSION['question_id'], $answerid)){
				//echo 'Error-2 '.$db->error;
			}else{
				$stmt->execute();
				$stmt->bind_result($answer);
				$stmt->fetch();
				$stmt->close();	
			}
			?>
    
    
			<a href="view-question.php">Go Back</a>
    
			<form name="form" action="edit-question.php" method="post" target="_top">
			<input type="hidden" name="answer_id" value="<?php echo $answerid; ?>" />
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
				?>
				</div>
			</div>
			
            <label>Question</label>
            <?php echo $question ?>
            
			<hr />
			<br />
			
            <label>Your Answer</label>
			<textarea style="width:100%; height:300px;"  name="answer"><?php echo $answer; ?></textarea>
			<br />
			
            <button class="pure-button" name="update_answer" type="submit">Submit Answer </button>

			</form>
    
		</div>
	</div>
</div>
                
<br />
<br />
<br />
<br />

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


</body>
</body>
</html>

