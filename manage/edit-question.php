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

//require_once("includes/class.setup_progress.php");

$lgn = new CustomerLogin;
$prof = new Professional;
	
$lgn = new CustomerLogin;

$page_title = "View Question";

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$question_id = (isset($_GET['question_id']))? $_GET['question_id'] : 0;
if(!isset($_SESSION['question_id'])) $_SESSION['question_id'] = $question_id;



if(isset($_POST['add_answer'])){

	$answer = (isset($_POST['answer']))? trim(stripslashes($_POST['answer'])) : '';
	
	$profile_id = 0;
	
	$ts = time();

	$stmt = $db->prepare("INSERT INTO answer 
								(answer
								,question_id
								,answered_by_profile_id
								,a_date)
								VALUES(?,?,?,?)");	
					
	if(!$stmt->bind_param("siii", $answer, $_SESSION['question_id'], $profile_id, $ts)){
		echo 'Error-2 '.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
		$msg = "Answer added";
	}

}


if(isset($_POST['update_answer'])){
	
	$answer_id = isset($_POST['answer_id'])? $_POST['answer_id'] : 0; 

	$answer = isset($_POST['answer'])? addslashes($_POST['answer']) : ''; 
	
	//echo "<br />answer_id:  ".$answer_id;
	//echo "<br />answer:  ".$answer;
	//echo "<br />question_id:  ".$_SESSION['question_id'];
	//echo "<br />profile_account_id:  ".$_SESSION['profile_account_id'];
	//echo "<br />";
	
	
	$stmt = $db->prepare("UPDATE answer
						SET answer = ?
						WHERE id = ?
						AND question_id = ?");
						
		//echo 'Error '.$db->error;	
													
	if(!$stmt->bind_param('sii'
						,$answer
						,$answer_id
						,$_SESSION['question_id'])){
										
		echo 'Error-2 '.$db->error;					
	}else{
	
		$stmt->execute();
		$stmt->close();		
		
		$msg = 'Update successful';
	}
	
	
}


if(isset($_POST['set_active'])){
		
	$sql = "UPDATE answer SET active = '0' 
			WHERE question_id = '".$_SESSION['question_id']."'";
	$result = $dbCustom->getResult($db,$sql);
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();	
	if(is_array($actives)){	
		foreach($actives as $value){
			$sql = "UPDATE answer SET active = '1' 
					WHERE id = '".$value."'
					AND question_id = '".$_SESSION['question_id']."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}
	}

	$msg = 'Changes Saved.';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Expert Answer</title>

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
		
			<center>
			<h3>Add Question</h3>
			</center>
			<?php

			$stmt = $db->prepare("SELECT cat_id	
							,prof_profile_id	
							,visitor_profile_id	
							,visitor_name	
							,visitor_email	
							,visitor_zip	
							,question	
							,contact_directly	
							,is_private	
							,active	
							,q_date
							,active
							FROM question 
							WHERE id = ?");
								
								
						
			if($stmt->bind_param("i", $_SESSION['question_id'])){
						
				$stmt->execute();
							 
				$stmt->bind_result($cat_id
							,$prof_profile_id	
							,$visitor_profile_id	
							,$visitor_name	
							,$visitor_email	
							,$visitor_zip	
							,$question	
							,$contact_directly	
							,$is_private	
							,$active	
							,$q_date
							,$active);
							 
				$stmt->fetch();
							 
				$stmt->close();	
			}

			
			$prof_name = $prof->getProfName($prof_profile_id);
					
			$private = ($is_private)? 'This Question is Private' : 'This Question is Public';
					
					
			?>
        
			<a class="btn btn-info btn-sm" href="questions.php">Go Back</a>
	
			<form name="q_form" action="questions.php" method="post" enctype="multipart/form-data">
	
			<input type="hidden" name="question_id" value="<?php echo $_SESSION['question_id']; ?>" />
			
			<table cellpadding="6">
			<tr>
				<td width="60%">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Selected Professional</td>
				<td><?php echo stripslashes($prof_name); ?></td>
			</tr>
			<tr>
				<td>Visitor Name</td>
				<td>
				<input type="text" name="visitor_name" value="<?php echo stripslashes($visitor_name); ?>" />
				</td>
			</tr>
			<tr>
				<td>Visitor Email</td>
				<td><?php echo $visitor_email; ?></td>
			</tr>
			<tr>
				<td>Visitor Zip</td>
				<td><?php echo $visitor_zip; ?></td>
			</tr>
			<tr>
				<td>Privacy</td>
				<td>
					<select name="is_private">       
						<option value="0" <?php if(!$is_private) echo 'selected'; ?>>Public</option>
						<option value="1" <?php if($is_private) echo 'selected'; ?>>Private</option>
					</select>
				
				</td>
			</tr>
			<tr>
				<td>Date Submitted</td>
				<td><?php echo date("F j, Y, g:i a", $q_date); ?></td>
			</tr>
			
			</table>    
			
			<hr />
			Question: <br />

			<textarea style="width:100%; height:300px;" name="question"><?php echo stripslashes($question); ?></textarea>

			<br /><br />    
			<input type="submit" class="btn btn-info" name="update_question" value="Update Question" />
			</form>

			
			<hr />
			<br /><br />
			
			
			
	<a class="btn btn-info btn-sm" 
	href="answer-question.php?question_id=<?php echo $_SESSION['question_id']; ?>">Add Answer</a>
			
			
			<br /><br />
			
			<h2>Answers</h2>
			
			<br />

			<form  name="a_form" action="edit-question.php" method="post" enctype="multipart/form-data">
				
				<table>
								<tr>
									<th width="15%">
									Answered By    
									</th>
									<th width="8%">
									Active
									</th>
									<th>
									Answer
									</th>
								</tr>

			<?php
			
			//echo $_SESSION['id'];
			
			$sql = sprintf("SELECT id 
								,answered_by_profile_id	
								,answer	
								,a_date
								,active
							FROM answer 
							WHERE question_id = '%u'", $_SESSION['question_id']);
			
			$result = $dbCustom->getResult($db,$sql);
			
			//echo "num_rows:  ".$result->num_rows;
		//		$block .= "<td>".date("F j, Y, g:i a", $row->a_date)."</td>";
			
			$block = '';
			
			while($row = $result->fetch_object()){
				
				$block	.= "<input type='hidden' name='on_this_page[]' value='".$row->id."' />";
				
				$block .= "<tr>";
				$block .= "<td>".$prof->getProfName($row->answered_by_profile_id)."</td>";
				
$checked = ($row->active)? "checked" : "";
$block .= "<td align='center'>";
$block .= "<div class='custom-control custom-switch'>";			
$block .= "<input type='checkbox' name='active[]' value='".$row->id."'";
$block .= " class='custom-control-input' id='".$row->id."' $checked>";
$block .= "<label class='custom-control-label' for='".$row->id."'>Active</label>";	
$block .= "</div>";		
$block .= "</td>";	

							
				$block .= "<td><a class='btn btn-info btn-sm ' 
							href='edit-answer.php?answerid=".$row->id."'>Edit</a></td>";
								
							
				$str = substr($row->answer,0,100);			
				if(strlen($row->answer) > 100){
					$str .= '...';
				}
				
				$block .= "<td>".$str."</td>";		
				$block .= "</tr>";
					
				
			}
			echo $block;

			?>   
			 
			</table>
			<br />
			<input type="submit" class="btn btn-info btn-sm" name="set_active" value="Set Active Answers" />
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
