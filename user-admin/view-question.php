<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
require_once('../includes/functions.php');
require_once('../includes/class.profess.php');
require_once('includes/user_admin_functions.php');

$lgn = new CustomerLogin;
$prof = new Professional;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';
$question_id = (isset($_GET['question_id']))? $_GET['question_id'] : 0; 

if(!isset($_SESSION['question_id'])) $_SESSION['question_id'] = $question_id;

$is = time();

if(isset($_POST['update_answer'])){

	$answer_id = (isset($_POST['answer_id']))? $_POST['answer_id'] : 0;
	$answer = (isset($_POST['answer']))? trim(stripslashes($_POST['answer'])) : '';

	$stmt = $db->prepare("UPDATE answer
							SET answer = ?
							WHERE id = ?
							AND answered_by_profile_id = ?");
		//echo 'Error-1 '.$db->error;	
	if(!$stmt->bind_param('sii'
						,$answer
						,$answer_id
						,$profile_id)){			
		//echo 'Error-2 '.$db->error;					
	}else{
	
		$stmt->execute();
		$stmt->close();				
		$msg = 'Answer Updated successful';
	}

}


if(isset($_POST['add_answer'])){

	$answer = (isset($_POST['answer']))? trim(stripslashes($_POST['answer'])) : '';

	$stmt = $db->prepare("INSERT INTO answer 
								(answer
								,question_id
								,answered_by_profile_id
								,a_date)
								VALUES(?,?,?,?)");	
					
	if(!$stmt->bind_param("siii", $answer, $_SESSION['question_id'], $profile_id, $is)){
		//echo 'Error-2 '.$db->error;
	}else{
		$stmt->execute();
		$stmt->close();
		$msg = "Answer added";
	}
}

if(isset($_POST['set_active'])){

	$actives = (isset($_POST['active'])) ? $_POST['active'] : array();
	$question_id = (isset($_POST['question_id'])) ? $_POST['question_id'] : 0;
	
	$sql = "UPDATE answer 
			SET active = '0' 
			WHERE answered_by_profile_id = '".$profile_id."'
			AND question_id = '".$question_id."'";
	$result = $dbCustom->getResult($db,$sql);

	foreach($actives as $key => $value){
		$sql = "UPDATE answer 
				SET active = '1' 
				WHERE id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
			
		//echo "key: ".$key."   value: ".$value."<br />"; 
	}
 

}


if(isset($_GET['del_id'])){

	$answer_id = (isset($_GET['del_id'])) ? $_GET['del_id'] : 0;
	if(!is_numeric($answer_id)) $answer_id = 0;
	
	$stmt = $db->prepare("DELETE FROM answer 
						WHERE id = ?
						AND answered_by_profile_id = ?");
		//echo 'Error-1 '.$db->error;	
	if(!$stmt->bind_param('ii'
						,$answer_id
						,$profile_id)){			
		//echo 'Error-2 '.$db->error;					
	}else{
	
		$stmt->execute();
		$stmt->close();				
		$msg = 'Answer Deleted';
	}

	
}
?>
<!doctype html>
<html lang="en">
	<head>
		<link rel="icon" 
			type="image/png" 
			href="<?php echo "../favicon.png"; ?>" >

		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
				<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./assets/css/base.css">

		<title>Expert Answer</title>

		<script>
		function validate(theform){			
			return true;
		}
		</script>

	</head>
	<body style="background-color: #FFF1E5;">
		<?php
			require_once('includes/user-admin-nav.php');
		?>

		<main class="container my-3 p-0">

			<div class="card shadow-sm mt-3">
				<div class="card-header">Question</div>
				<div class="card-body">
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
					
		$private = ($is_private)? 'This Question is Private' : 'This Question is Public'
					
		?>

					<div class="container">
						<div class="row">
							<div class="col-12 col-md-2">
								<h6>Visitor Name</h6>
							</div>
							<div class="col-12 col-md-10">
								Some User
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-2">
								<h6>Visitor Email</h6>
							</div>
							<div class="col-12 col-md-10">
								email@email.com
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-2">
								<h6>Visitor Zip</h6>
							</div>
							<div class="col-12 col-md-10">
								<?php echo $visitor_zip; ?>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-2">
								<h6>Privacy</h6>
							</div>
							<div class="col-12 col-md-10">
								This question is Public
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-2">
								<h6>Date Submitted</h6>
							</div>
							<div class="col-12 col-md-10">
								01/01/1970
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-md-2">
								<h6>Status</h6>
							</div>
							<div class="col-12 col-md-10">
								Some Status
							</div>
						</div>

						<div class="row mt-3">
							<div class="col">
								<h2>Question</h2>
							</div>
						</div>

						<div class="row">
							<div class="col">
								Question goes here
							</div>
						</div>

					</div>
				
					<hr />
				
					<div class="d-flex justify-content-end">
						<a class="btn btn-info" 
						href="answer-question.php?question_id=<?php echo $_SESSION['question_id']; ?>"><i class="icon-plus"></i> Add Answer</a>
					</div>
				
					<h2>Answers</h2>

					<form name="a_form" action="view-question.php" method="post" enctype="multipart/form-data">
				
						<input type="hidden" name="question_id" value="<?php echo $_SESSION['question_id']; ?>" />
					
						<div class="card shadow-sm mt-3">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr class="table-secondary">
												<th width="15%">Answered By</th>
												<th width="8%">Edit</th>
												<th width="8%">Delete</th>    
												<th>Answer</th>
											</tr>
										</thead>
										<tbody>
	<?php
	$sql = sprintf("SELECT id 
						,answered_by_profile_id	
						,answer	
						,a_date
						,active
					FROM answer 
					WHERE answered_by_profile_id = '%u' 
					AND question_id = '%u'", $profile_id, $_SESSION['question_id']);		
		$result = $dbCustom->getResult($db,$sql);
				
		$block = '';
			
		while($row = $result->fetch_object()){
				
			$block	.= "<input type='hidden' name='on_this_page[]' value='".$row->id."' />";
				
			$block .= "<tr>";
			$block .= "<td>".$prof->getProfName($row->answered_by_profile_id)."</td>";

			$block .= "<td><a class='btn btn-info btn-sm' href='edit-answer.php?answerid=".$row->id."'>Edit</a></td>";

			$block .= "<td>";
			
			$url_str = "view-question.php";
			$url_str .= "?del_id=".$row->id;
			$block .= "<a class='btn btn-danger btn-sm' href='".$url_str."'>Delete</a></td>";	
											
			$str = substr($row->answer,0,100);			
			if(strlen($row->answer) > 100){
				$str .= '...';
			}
				
			$block .= "<td>".$str."</td>";		
			$block .= "</tr>";
				
		}
		echo $block;

		?>
										
										
											<tr>
												<td>Some User</td>
												<td>Active</td>
												<td>Edit</td>
												<td>Delete</td>
												<td>A long answer</td>
											</tr>
											<tr>
												<td>Some User</td>
												<td>Active</td>
												<td>Edit</td>
												<td>Delete</td>
												<td>A long answer</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
						<div class="d-flex justify-content-end mt-5">
							<button class="btn btn-primary" type="submit" name="set_active"><i class="icon-ok"></i> Set Active Answers</button>
						</div>
					</form>
				</div>
			</div>
		</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	</body>
</html>
