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

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

</head>
<body style="background-color: #FFF1E5;">

<img src="<?php echo SITEROOT;?>/img/nat.png" />
<?php
	echo "Welcome  ".$lgn->getFullName();	
	require_once('includes/user-admin-nav.php');
	echo "<h4 style='color:red;'>".$msg."</h4>";	
	
?>

<div style="float:right; margin:30px;"><a class="btn btn-info" href="<?php echo SITEROOT;?>">Exit</a></div>
<div style="float:right; margin:30px;"><a class="btn btn-info" href="profile-skills.php">Back</a></div>
<div style="clear:both;"></div>

<div class="row">
	<div class="col-md-12">
		<div style="margin-right:20px; margin-left:10px;">
	
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

	<form name="form" action="view-open-question.php" method="post" target="_top">
        	<h2 class="center-text">Answer Question</h2>
            <table>
            <tr>
            	<td>Customer Name</td>
                <td width="10%">&nbsp;</td>
            	<td><?php echo $visitor_name; ?></td>
            </tr>    
            <tr>
            	<td>Customer Email</td>
                <td>&nbsp;</td>
            	<td><?php echo $visitor_email; ?></td>
            </tr>    
            <tr>
            	<td>Date of Question</td>
                <td>&nbsp;</td>
            	<td><?php 
				
					$d = date("F j, Y, g:i a", $q_date);
					echo $d; 
				
				?></td>
            </tr>    

            </table>

			<fieldset>
            <label>Question</label>
            <?php echo $question ?>
			</fieldset>
            
			<br />
			
            <label>Your Answer</label>
			<textarea style="width:100%;"  name="answer" rows="10"></textarea>
			<br />
			
            <button class="btn btn-large btn-success" name="add_answer" type="submit">Submit Answer </button>


	</form>
 
     
</div>
</div>
</div>

<script src="../js/jquery.min.js"></script>

</body>
</html>
