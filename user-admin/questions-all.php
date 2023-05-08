<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
require_once('../includes/functions.php');
require_once('includes/user_admin_functions.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";
	header($header_str);	
}

$profile_id = $lgn->getProfileId();
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';




if(isset($_POST['update_question'])){

	$question_id = (isset($_POST['question_id'])) ? $_POST['question_id'] : 0;
    $cat_id = (isset($_POST['cat_id']))? $_POST['cat_id'] : 0;
	$is_private = (isset($_POST['is_private']))? $_POST['is_private'] : 1;
	$active = (isset($_POST['active']))? $_POST['active'] : 0;  
	$question = (isset($_POST['question']))? trim(stripslashes($_POST['question'])) : '';

	$stmt = $db->prepare("UPDATE question
							SET question = ?
							,cat_id = ?
							,is_private = ?
							,active = ?
							WHERE id = ?
							AND profile_account_id = ?");
						
		//echo 'Error-1 '.$db->error;	
	if(!$stmt->bind_param('siiiii'
						,$question
						,$cat_id
						,$is_private
						,$active
						,$_SESSION['question_id']
						,$_SESSION['profile_account_id'])){			
		//echo 'Error-2 '.$db->error;					
	}else{
	
		$stmt->execute();
		$stmt->close();		
		
		$msg = 'Question Updated successful';
	}

}

if(isset($_POST['set_active'])){
		
	$on_this_page = (isset($_POST['on_this_page']))? $_POST['on_this_page'] : array();
	
	if(is_array($on_this_page)){	
		foreach($on_this_page as $value){
			$sql = "UPDATE question SET active = '0' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}
	}
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
	if(is_array($actives)){	
		foreach($actives as $value){
			$sql = "UPDATE question SET active = '1' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}
	}

	$msg = 'Changes Saved.';
}

if(isset($_GET['del_question_id'])){
	
	$id = (isset($_GET['del_question_id'])) ? $_GET['del_question_id'] : 0;
	
	if(!is_numeric($id)) $id = 0;
	
	$sql = sprintf("DELETE FROM question 
			WHERE id = '%u'
			AND prof_profile_id = '%u'",
			$id, $profile_id); 		
	//echo $sql;		
	$result = $dbCustom->getResult($db,$sql);
	
	$sql = sprintf("DELETE FROM answer 
			WHERE question_id = '%u'", $id); 		
	//echo $sql;		
	$result = $dbCustom->getResult($db,$sql);
	
	$msg = 'Question deleted';
	
}

$q_to_me = (isset($_POST['q_to_me']))? 1 : 0;
		
$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : '';
$a_d = (isset($_GET['a_d'])) ? $_GET['a_d'] : 'a';
		
$pagenum = (isset($_GET['pagenum'])) ? addslashes($_GET['pagenum']) : 0;
$truncate = (isset($_GET['truncate'])) ? addslashes($_GET['truncate']) : 1;
		
$search_str = isset($_REQUEST['search_str']) ? trim(addslashes($_REQUEST['search_str'])) : '';
		
if(isset($_REQUEST["date_from"])){
	$date_from = strpos($_REQUEST['date_from'], '-') ? strtotime(trim($_REQUEST['date_from'])) : '';
}else{
	$date_from = ''; 
}
	
if(isset($_REQUEST['date_to'])){
	$date_to = strpos($_REQUEST['date_to'], '-') ? strtotime(trim($_REQUEST['date_to'])) : '';
}else{
	$date_to = ''; 
}	
	
$sql = "SELECT * 
		FROM question
		WHERE id > 0";


if($q_to_me){
	$sql .= sprintf(" AND prof_profile_id = '%u'", $profile_id);
}

if($search_str != ''){
	if(is_numeric($search_str)){
		$sql .= sprintf(" AND visitor_zip = '%u'", $search_str);
	}else{			
		$search_str = addslashes($search_str);				
		$sql .= sprintf(" AND (visitor_name like '%%%s%%' OR visitor_email like '%%%s%%' )", $search_str, $search_str);			
	}			
}		

if($date_from != ''){		
	$sql .= sprintf(" AND q_date >= '%u'", $date_from);
}

if($date_to != ''){		
	$sql .= sprintf(" AND q_date <= '%u'", $date_to);
}
			
$nmx_res = $dbCustom->getResult($db,$sql);
		
$total_rows = $nmx_res->num_rows;
$rows_per_page = 16;
$last = ceil($total_rows/$rows_per_page); 
							
if ($pagenum > $last){ 
	$pagenum = $last; 
}
if ($pagenum < 1){ 
	$pagenum = 1; 
}
						
$limit = ' limit ' .($pagenum - 1) * $rows_per_page.','.$rows_per_page;

if($sortby != ''){
	if($sortby == 'visitor_name'){
		if($a_d == 'd'){
			$sql .= " ORDER BY visitor_name DESC".$limit;
		}else{
			$sql .= " ORDER BY visitor_name".$limit;		
		}
	}
	if($sortby == 'visitor_email'){
		if($a_d == 'd'){
			$sql .= " ORDER BY visitor_email DESC".$limit;
		}else{
			$sql .= " ORDER BY visitor_email".$limit;		
		}
	}
	if($sortby == 'q_date'){
		if($a_d == 'd'){
			$sql .= " ORDER BY q_date DESC".$limit;
		}else{
			$sql .= " ORDER BY q_date".$limit;		
		}
	}

}else{
	$sql .= " ORDER BY id DESC".$limit;
}
			
$result = $dbCustom->getResult($db,$sql);
			
$q_array = array();
$i = 0;
while($row = $result->fetch_object()) {
	$q_array[$i]['id'] = $row->id;
	$q_array[$i]['visitor_name'] = $row->visitor_name;
	$q_array[$i]['q_date'] = $row->q_date;
	$q_array[$i]['active'] = $row->active;
	$i++;
}

unset($_SESSION['question_id']);





?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
			type="image/png" 
			href="<?php echo "../favicon.png"; ?>" >
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
</head>
<body style="background-color: #FFF1E5;">
<?php
require_once('includes/user-admin-nav.php');
?>

<main class="container my-3 p-0">
	<div class="card shadow-sm">
		<div class="card-header">QUESTIONS</div>
		<div class="card-body">	
			<div class="card p-3 mt-3 shadow-sm">
				<div class="container">
					<div class="h3">Search</div>
					<hr class="mt-3 mb-3" />
				</div>
				<div class="card-body">
				<form name="search_form" action="questions-all.php" method="post">
				<div class="form-group">
					<label for="input_search_str">Enter</label>
					<input type="text" name="search_str" class="form-control" id="input_search_str" >
					<small class="form-text text-muted">Enter text for your search.</small>
				</div>
				<div class="row">					
					<div class="col-6">							
						<div class="form-group">
							<label for="input_date_from">Date From</label>
							<input type="date" name="date_from" class="form-control" id="input_date_from" >
							<small class="form-text text-muted">Enter or select start date</small>
						</div>
					</div>
					<div class="col-6">				
						<div class="form-group">
							<label for="input_date_to">Date To</label>
							<input type="date" name="date_to" class="form-control" id="input_date_to" >
							<small class="form-text text-muted">Enter or select end date</small>
						</div>
					</div>			
				</div>
				<div class="row mt-3">
					<div class="col-6 form-check">
						<label class="form-check-label" for="q_to_me">Only Questions to Me</label>
						<input class="form-check-input ml-2" type="checkbox" name="q_to_me" id="q_to_me" value="1" <?php if($q_to_me) echo "checked"; ?> />
					</div>
					<div class="col-6 d-flex justify-content-end">
						<button class="btn btn-primary" type="submit" value="search">
						<i class="icon-search"></i> Search
						</button>
					</div>
				</div>
				</form>
				</div>
			</div>				
			<div class="card p-3 shadow-sm mt-5">
				
				<form action="questions-all.php" method="post" enctype="multipart/form-data">
				<div class="card-body">				
				<div class="table-responsive">

                <table class="table">
				<tr>
				<td colspan="5">
<input class="btn btn-primary" type="submit" name="set_active" value="Save" />
				
				</td>
				</tr>				

				<tr class="table-secondary">
				<td>Visitor</td>
				<td>Date</td>
				<td width="10%">Active</td>
				<td width="10%">View</td>
				<td width="10%">Delete</td>
				</tr>
				<input type="hidden" name="on_this_page[]" value="2" />

				
				
<?php
$on_this_page = array();
$block = ''; 
		
foreach($q_array as $val){			
$on_this_page[] = $val['id'];
$block	.= "<input type='hidden' name='on_this_page[]' value='".$val['id']."' />";
$block .= "<tr>"; 
$block .= "<td>".stripslashes($val['visitor_name'])."</td>";			
$block .= "<td>".date("F j, Y", $val['q_date'])."</td>";			
			
$checked = ($val['active']) ? "checked='checked'" : "";										
$block .= "<td align='center'>";
$block .= "<div class='custom-control custom-switch'>";			
$block .= "<input type='checkbox' name='active[]' value='".$val['id']."'";
$block .= " class='custom-control-input' id='".$val['id']."' $checked>";
$block .= "<label class='custom-control-label' for='".$val['id']."'></label>";	
$block .= "</div>";		
$block .= "</td>";	
			
$url_str = "view-question.php";
$url_str .= "?question_id=".$val['id'];
$url_str .= "&pagenum=".$pagenum;
$url_str .= "&sortby=".$sortby;
$url_str .= "&a_d=".$a_d;
$url_str .= "&truncate=".$truncate;
$url_str .= "&search_str=".$search_str;
$block .= "<td><a class='btn btn-info btn-sm' href='".$url_str."'>View</a></td>";

$url_str = "questions-all.php";
$url_str .= "?del_question_id=".$val['id'];
$url_str .= "&pagenum=".$pagenum;
$url_str .= "&sortby=".$sortby;
$url_str .= "&a_d=".$a_d;
$url_str .= "&truncate=".$truncate;
$url_str .= "&search_str=".$search_str;			
$block .= "<td><a class='btn btn-danger btn-sm' href='".$url_str."'>Delete</a></td>";
			
$block .= "</tr>";

}
$block .= "</table>";
echo $block;
?>

				
				
				
<!--				
				
				<tr>
				<td>Ticker Track</td>
				<td>March 1, 2021</td>
				<td align="center">
				<div class="custom-control custom-switch">
				<input type="checkbox" name="active[]" value="2" class="custom-control-input" id="2" />
				<label class="custom-control-label" for="2"></label>
				</div>
				</td>
				
				<td>
				<a class="btn btn-info btn-sm" href="view-question.php?question_id=2&amp;pagenum=1&amp;sortby=&amp;a_d=a&amp;truncate=1&amp;search_str="><i class="icon-eye-open"></i> View</a>
				</td>
				<td>
				<a class="btn btn-danger btn-sm" href="questions-all.php?del_question_id=2&amp;pagenum=1&amp;sortby=&amp;a_d=a&amp;truncate=1&amp;search_str="><i class="icon-minus-sign"></i> Delete</a>
				</td>
				</tr>
				<input type="hidden" name="on_this_page[]" value="1" />
											
				<tr>
				<td>Portlandian</td>
				<td>January 9, 2021</td>
				<td align="center">
				<div class="custom-control custom-switch">
				<input type="checkbox" name="active[]" value="1" class="custom-control-input" id="1" />
				<label class="custom-control-label" for="1"></label>
				</div>
				</td>
								
				<td>
				<a class="btn btn-info btn-sm" 
				href="view-question.php?question_id=1truncate=1&amp;search_str="><i class="icon-eye-open"></i> View</a>
				</td>
				<td>
				<a class="btn btn-danger btn-sm" href="questions-all.php?del_question_id=1&amp;pagenum=1&amp;sortby=&amp;a_d=a&amp;truncate=1&amp;search_str="><i class="icon-minus-sign"></i> Delete</a>
				</td>
				</tr>
				-->
				
				</table>
				
				</div>				
				</div>
				
				</form>
				
				
			</div>
		</div>
	</div>
</main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

		<script>
			let activeNav="profile-questions";
		</script>

		<?php
			require_once('navbar-effect.php');
		?>

	</body>
</html>





