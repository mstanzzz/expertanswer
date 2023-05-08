<?php

require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
require_once('../includes/functions.php');
require_once('../manage/includes/manage_functions.php');
require_once('includes/user_admin_functions.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";
	header($header_str);	
}

$profile_id = $lgn->getProfileId();

$page_title = 'Questions';

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

if(isset($_POST['del_question'])){
	
	
	$id = (isset($_POST['del_question_id'])) ? $_POST['del_question_id'] : 0;
	
	$sql = sprintf("DELETE FROM question 
			WHERE id = '%u'
			AND profile_account_id = '%u'",
			$id, $_SESSION['profile_account_id']); 
			
	$result = $dbCustom->getResult($db,$sql);
	
	$msg = 'Question deleted';
	
}

unset($_SESSION['question_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/pure-release-1.0.0/pure.css" media="screen"/>
<!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo SITEROOT; ?>/css/pure-release-1.0.0/grids-responsive-old-ie-min.css" media="screen"/>
<![endif]-->
<!--[if gt IE 8]><!-->
    <link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/pure-release-1.0.0/grids-responsive.css" media="screen"/>
<!--<![endif]-->
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/pure-release-1.0.0/buttons.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/pure-release-1.0.0/forms.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/expert.css?v=1.0.0" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/manage_side_menu.css" media="screen"/>
<!--
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
-->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  

<script type="text/javascript" src="<?php echo SITEROOT;?>/js/inlineConfirmation.js"></script>
<script type="text/javascript" src="<?php echo SITEROOT;?>/js/formtoggles.js"></script>



<script>
$(function(){
	$("#datepicker1").datepicker();
	$("#datepicker2").datepicker();
});
</script>

</head>
<body style="background-color: #FFF1E5;">

<div class="splash-container">
    <div class="splash">
		Open Question
	</div>
</div>

<div id="layout">

<?php 
        require_once('includes/user-admin-nav.php');
?>    
	<div id="main" class="admin_content" onClick="doMenuToggle('main');">
		
		<?php 
		
		echo "<h1>Questions For ".$lgn->getFullName()."</h1>";
		
		if($msg != ''){ ?>
		<div class="alert alert-success">
			<h4><?php echo $msg; ?></h4>
		</div>
		<?php } ?>
        
        
        <?php
		
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
		
		$sql = "SELECT * 
				FROM question 
				WHERE prof_profile_id = '".$profile_id."'  
				";
		
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
		
		?>
				
                <form name="search_form" action="questions-me.php" method="post" enctype="multipart/form-data" class="pure-form">
                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-lg-1-3" style="padding:6px;">
                        <label>Enter name or email address</label>
                        <input type="text" name="search_str" placeholder="Search" />
                        </div>
                        
                        <div class="pure-u-1 pure-u-lg-1-3" style="padding:6px;">
                        <label>Date From</label>
                        <input id="datepicker1" type="text" name="date_from" value="none" />
                        </div>
                        
                        <div class="pure-u-1 pure-u-lg-1-3" style="padding:6px;">
                        <label>Date To</label>
                        <input id="datepicker2" type="text" name="date_to" value="today" />
                        </div>
                    </div>
                    <button class="pure-button pure-button-primary" type="submit" value="search">Search</button>
                </form>
                
        <br /><br /><br />
        <?php 
		if($total_rows > $rows_per_page){
			echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "questions-me.php", $sortby, $a_d, 0, 0,  $search_str);
			echo "<br /><br /><br /><br />";
		}
		?>	
            
        <?php require_once("../manage/includes/tablesort.php"); ?>
        
		<form action="questions-me.php" method="post" enctype="multipart/form-data">
        
				<table class="pure-table">
                	<thead>
						<tr>
          					<th <?php addSortAttr('visitor_name',true); ?>>
                            Visitor Name
                            <i <?php addSortAttr('visitor_name',false); ?>></i>
                            </th>

          					<th <?php addSortAttr('q_date',true); ?>>
                            Date Submitted
                            <i <?php addSortAttr('q_date',false); ?>></i>
                            </th>
							
                            <th>
                            Answered?
                            </th>
          					
          					<th>
                            Active
                            </th>
          					
							<th width="12%">View</th>
							<th width="5%">Delete</th>
						</tr>
					<thead>                        
					<tbody>
					
					<?php
					$on_this_page = array();
					
					$block = ''; 
					while($row = $result->fetch_object()) {
						
						$on_this_page[] = $row->id;
						
						$block	.= "<input type='hidden' name='on_this_page[]' value='".$row->id."' />";
						
						$block .= "<tr>"; 

						$block .= "<td>".stripslashes($row->visitor_name)."</td>";			
							
						$block .= "<td>".date("F j, Y, g:i a", $row->q_date)."</td>";			
						
						$has_answer = (is_answered($row->id) > 0)? 'Yes' : 'No';						
						$block .= "<td>".$has_answer."</td>";								
						
						
						$checked = ($row->active)? "checked" : "";
						
						$block .= "<td>
									<label class='switch'>
									<input type='checkbox' name='active[]' value='".$row->id."' $checked />
									<span class='slider round'></span>
									</label>
									</td>";	
						
						
						$url_str = "view-question.php";
						$url_str .= "?question_id=".$row->id;
						$url_str .= "&ret_type=me";
						$url_str .= "&pagenum=".$pagenum;
						$url_str .= "&sortby=".$sortby;
						$url_str .= "&a_d=".$a_d;
						$url_str .= "&truncate=".$truncate;
						$url_str .= "&search_str=".$search_str;
						
						$block .= "<td><a class='pure-button' href='".$url_str."'>View</a></td>";
						
						$block .= "<td><a class='pure-button button-warning confirm'><input type='hidden' id='".$row->id."' class='itemId' value='".$row->id."' />Delete</a></td>";	

						$block .= "</tr>";
					}
					$block .= "</tbody>";
					$block .= "</table>";
					echo $block;
					?>
                
                <br />
                 <input class="pure-button pure-button-primary" type="submit" name="set_active" value="Save" />
                 
                </form>
				<?php 
				if($total_rows > $rows_per_page){
					echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "questions-me.php", $sortby, $a_d, 0, 0,  $search_str);

				}

				$url_str = "questions-me.php";
				$url_str .= "&pagenum=".$pagenum;
				$url_str .= "&sortby=".$sortby;
				$url_str .= "&a_d=".$a_d;
				$url_str .= "&truncate=".$truncate;
				$url_str .= "&search_str=".$search_str;

				?>	                
   
</div>
</div>


<div id="content-delete" class="confirm-content">
	<h3>Are you sure you want to delete this question?</h3>
	<form name="del_question_form" action="<?php echo $url_str; ?>" method="post" target="_top">
		<input id="del_question_id" class="itemId" type="hidden" name="del_question_id" value='' />
		<a class="pure-button dismiss" style="width:140px;">No, Cancel</a>
		<button class="pure-button button-warning" style="width:140px; margin-left:15px;" name="del_answer" type="submit" >Yes, Delete</button>
	</form>
</div>


<div style="width:100%; height:200px;">&nbsp;</div>


<script src="../js/jquery.min.js"></script>

</body>
</html>
