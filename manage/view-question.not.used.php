<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/functions.php');
require_once('../includes/class.profess.php');

$lgn = new CustomerLogin;
$prof = new Professional;
	
$lgn = new CustomerLogin;

$page_title = "View Question";

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

$question_id = (isset($_GET['question_id']))? $_GET['question_id'] : 0;
if(!isset($_SESSION['question_id'])) $_SESSION['question_id'] = $question_id;

if(isset($_POST['add_answer'])){

	$answer = (isset($_POST['answer']))? trim(stripslashes($_POST['answer'])) : '';

	$stmt = $db->prepare("INSERT INTO answer 
								(answer
								,question_id
								,answered_by_profile_id
								,a_date)
								VALUES(?,?,?,?)");	
					
	if(!$stmt->bind_param("siii", $answer, $_SESSION['question_id'], $profile_id, $is)){
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
<title></title>
<link type="text/css" rel="stylesheet" href="../css/manageStyle.css" />

<link type="text/css" rel="stylesheet" href="../css/base_sarah.css" />


<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  

<script type="text/javascript" src="../js/inlineConfirmation.js"></script>

<script type="text/javascript" src="../js/formtoggles.js"></script>

</head>

<body>
<?php

	require_once('includes/manage-header.php');
	//require_once('includes/manage-top-nav.php');
?>
<div class="manage_page_container">
	<div class="manage_side_nav">
		<?php 
        require_once('includes/manage-side-nav.php');
        ?>
	</div>
	
	<div class="manage_main">
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
					
					

			echo "<br />question_id:  ".$_SESSION['question_id']."    ";		
					
		?>
        
	<a class="btn btn-small" href="questions.php">Go Back</a>
	
   	<form name="q_form" action="questions.php" method="post" enctype="multipart/form-data">
	
    <input type="hidden" name="question_id" value="<?php echo $_SESSION['question_id']; ?>" />
    
	<table cellpadding="6">
    <tr>
    	<td width="60%">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td>Category</td>
        <td>
        
		    <select name="cat_id" >
            <option value="0">Select</option>
            <?php
			$sql = "SELECT id, name
					FROM category
					WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
			$result = $dbCustom->getResult($db,$sql);
			while($row = $result->fetch_object()){
				$sel = ($row->id == $cat_id)? 'selected' : '';
				echo "<option value='".$row->id."' $sel>".$row->name."</option>";					
			}
			?>
            </select>
        </td>
    </tr>
    <tr>
    	<td>Selected Professional</td>
        <td><?php echo stripslashes($prof_name); ?></td>
    </tr>
    <tr>
    	<td>Visitor Name</td>
        <td><?php echo stripslashes($visitor_name); ?></td>
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

	<textarea style="width:600px; height:300px;" name="question"><?php echo stripslashes($question); ?></textarea>

	<br /><br />    
    <input type="submit" name="update_question" value="Update Question" />
    </form>

    
    <hr />
    <br /><br />
    
    
    
    <a class="btn btn-large" href="answer-question.php?question_id=<?php echo $_SESSION['question_id']; ?>">Add Answer</a>
    
    
    <br /><br />
    
    Answers
	
    <br />

	<form  name="a_form" action="view-question.php" method="post" enctype="multipart/form-data">
        
		<table cellpadding="6" style="width:100%" >
					<thead>
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
		</thead>


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
		$block .= "<td valign='top'>
					<div class='checkboxtoggle on'> 
					<span class='ontext'>ON</span>
					<a class='switch on' href='#'></a>
					<span class='offtext'>OFF</span>
					<input type='checkbox' class='checkboxinput' name='active[]' value='".$row->id."' ".$checked." />
					</div>
					</td>";	
					
		$block .= "<td><a class='btn btn-primary btn-small' 
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
    
    <input type="submit" name="set_active" value="Set Active Answers" />
    </form>
    
    </div>

	<p class="clear"></p>
</div>
</body>
</html>
