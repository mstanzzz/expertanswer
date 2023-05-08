<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
	
$lgn = new CustomerLogin;
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

/*
		$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : '';
		$a_d = (isset($_GET['a_d'])) ? $_GET['a_d'] : 'a';
		
		$pagenum = (isset($_GET['pagenum'])) ? addslashes($_GET['pagenum']) : 0;
		$truncate = (isset($_GET['truncate'])) ? addslashes($_GET['truncate']) : 1;
		
		$search_str = isset($_REQUEST['search_str']) ? trim(addslashes($_REQUEST['search_str'])) : '';
		
		if(isset($_REQUEST["date_from"])){
			$date_from = strpos($_REQUEST['date_from'], '/') ? strtotime(trim($_REQUEST['date_from'])) : '';
		}else{
			$date_from = ''; 
		}
		if(isset($_REQUEST['date_to'])){
			$date_to = strpos($_REQUEST['date_to'], '/') ? strtotime(trim($_REQUEST['date_to'])) : '';
		}else{
			$date_to = ''; 
		}
*/

if(isset($_POST['update_question'])){

	$question_id = (isset($_POST['question_id'])) ? $_POST['question_id'] : 0;
	
	$is_private = (isset($_POST['is_private'])) ? $_POST['is_private'] : 0;
	
	$visitor_name = (isset($_POST['visitor_name'])) ? trim(addslashes($_POST['visitor_name'])) : '';
	
	$question = (isset($_POST['question'])) ? trim(addslashes($_POST['question'])) : '';
	
	$stmt = $db->prepare("UPDATE question
						SET question = ?
							,visitor_name = ?
							,is_private = ?
						WHERE id = ?");
						
		//echo 'Error '.$db->error;	
													
	if(!$stmt->bind_param('ssii'
						,$question
						,$visitor_name
						,$is_private
						,$question_id)){
										
		echo 'Error-2 '.$db->error;					
	}else{
	
		$stmt->execute();
		$stmt->close();		
		
		$msg = 'Update successful';
	}
	
	$msg = 'Updated';

}

if(isset($_POST['set_active'])){
		
	$on_this_page = explode(',',$_POST['on_this_page']);
	
	//print_r($on_this_page);
	
		foreach($on_this_page as $value){
			
			//echo "<br />".$value;
			
			$sql = "UPDATE question SET active = '0' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}

	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
		foreach($actives as $value){
			$sql = "UPDATE question SET active = '1' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}


	$msg = 'Changes Saved.';
}

if(isset($_GET['del_id'])){
	
	
	$id = (isset($_GET['del_id'])) ? $_GET['del_id'] : 0;
	
	$sql = sprintf("DELETE FROM question 
			WHERE id = '%u'",
			$id); 		
	$result = $dbCustom->getResult($db,$sql);
	
	$sql = sprintf("DELETE FROM answer 
			WHERE question_id = '%u'",
			$id); 		
	$result = $dbCustom->getResult($db,$sql);
	
	
	$msg = 'Question deleted';
	
}

unset($_SESSION['question_id']);

?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
<script src="../js/tinymce/tinymce.min.js"></script>

<script>
function validate(theform){
			
	return true;
}

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
			<h3>Questions</h3>
			</center>

	<?php 

		
		$sql = "SELECT * 
		FROM question";

/*
		if($search_str != ''){
			if(is_numeric($search_str)){
				$sql .= " AND visitor_zip = '".$search_str."'";
			}else{			
				$search_str = addslashes($search_str);
				$sql .= " AND (visitor_name like '%".$search_str."%' OR visitor_email like '%".$search_str."%' )" ;			
			}
			
		}
		
		if($date_from != ''){		
			$sql .= " AND q_date >= '".$date_from."'";
		}
		if($date_to != ''){		
			$sql .= " AND q_date <= '".$date_to."'";
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
			if($sortby == 'name'){
				if($a_d == 'd'){
					$sql .= " ORDER BY visitor_name DESC".$limit;
				}else{
					$sql .= " ORDER BY visitor_name".$limit;		
				}
			}
			if($sortby == 'email'){
				if($a_d == 'd'){
					$sql .= " ORDER BY visitor_email DESC".$limit;
				}else{
					$sql .= " ORDER BY visitor_email".$limit;		
				}
			}
			if($sortby == 'date_submitted'){
				if($a_d == 'd'){
					$sql .= " ORDER BY q_date DESC".$limit;
				}else{
					$sql .= " ORDER BY q_date".$limit;		
				}
			}


		}else{
			$sql .= " ORDER BY id DESC".$limit;
		}
		
		*/
		
		$result = $dbCustom->getResult($db,$sql);
		
		?>

		<!--		
		<form name="search_form" action="questions.php" method="post" enctype="multipart/form-data" class="pure-form">
			
			
				<div class="form-group">
					<label for="input_search_str">Enter name or email address</label>
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
				<button class="btn btn-primary" type="submit" value="search">Search</button>
			
		</form>
        
		-->
		
		<br />
		
		
                
        <?php
		/*		
		if($total_rows > $rows_per_page){
			echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "questions.php", $sortby, $a_d, 0, 0,  $search_str);
			echo "<br /><br /><br /><br />";
		}
		*/
		?>	
        
		<form action="questions.php" method="post" enctype="multipart/form-data">
		<table width="100%" cellpadding="6">
		<tr>
		<td>Name</td>
		<td>Email</td>
		<td>Date</td>
		<td>Active</td>
		<td width="12%">Edit</td>
		<td width="5%">Delete</td>
		</tr>
		<?php
		$on_this_page = '';
		$block = ''; 
		while($row = $result->fetch_object()) {
		$on_this_page .= $row->id.",";
		$block .= "<tr>"; 
		$block .= "<td valign='top'>".stripslashes($row->visitor_name)."</td>";			
		$block .= "<td valign='top'>".$row->visitor_email."</td>";								
		$block .= "<td valign='top'>".date("F j, Y, g:i a", $row->q_date)."</td>";			

$checked = ($row->active)? "checked" : "";
$block .= "<td align='center'>";
$block .= "<div class='custom-control custom-switch'>";			
$block .= "<input type='checkbox' name='active[]' value='".$row->id."'";
$block .= " class='custom-control-input' id='".$row->id."' $checked>";
$block .= "<label class='custom-control-label' for='".$row->id."'>Active</label>";	
$block .= "</div>";		
$block .= "</td>";	
								
								
		$url_str = "edit-question.php";
		$url_str .= "?question_id=".$row->id;
		//$url_str .= "&pagenum=".$pagenum;
		//$url_str .= "&sortby=".$sortby;
		//$url_str .= "&a_d=".$a_d;
		//$url_str .= "&truncate=".$truncate;
		//$url_str .= "&search_str=".$search_str;
								
		$block .= "</td>";	
		$block .= "<td valign='top'>";
		$block .= "<a class='btn btn-primary btn-sm' href='".$url_str."'>Edit</a></td>";
		$block .= "<td valign='top'>";
		$block .= "<a class='btn btn-danger btn-sm' href='questions.php?del_id=".$row->id."'>Delete</a></td>";
		$block .= "</tr>";
		}
		$block .= "</table>";
		echo $block;				
		echo "<input type='hidden' name='on_this_page' value='".$on_this_page."' />";
		?>
<input class="btn btn-primary" type="submit" name="set_active" value="Save" />
</form>
<?php 
/*
if($total_rows > $rows_per_page){
echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "questions.php", $sortby, $a_d, 0, 0,  $search_str);
}
*/
?>	                

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
</html>
