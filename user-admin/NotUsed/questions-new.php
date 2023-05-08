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

$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";


if(isset($_POST['del_question'])){
	
	
	$id = (isset($_POST['del_question_id'])) ? $_POST['del_question_id'] : 0;
	
	$sql = sprintf("DELETE FROM question 
			WHERE id = '%u'
			AND profile_account_id = '%u'",
			$id, $_SESSION['profile_account_id']); 
			
	$result = $dbCustom->getResult($db,$sql);
	
	$msg = 'Question deleted';
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<link type="text/css" rel="stylesheet" href="../css/manageStyle.css" />

<link type="text/css" rel="stylesheet" href="../css/base_sarah.css" />

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

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
<script>

$( function() {
    $("#datepicker1").datepicker();
	$("#datepicker2").datepicker();
} );

function regularSubmit() {
  document.form.submit(); 
}	
</script>
</head>

<body style="background-color: #FFF1E5;">
<?php

	require_once("includes/user-admin-header.php");
	require_once("includes/user-admin-top-nav.php");
?>
<div class="manage_page_container">
	<div class="manage_side_nav">
		<?php 
        require_once('includes/user-admin-nav.php');
        ?>
	</div>
	<div class="manage_main">
		<h1>Questions</h1>
		<?php 
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
		
		
		
		$sql = "SELECT * FROM question WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";

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

		
		$result = $dbCustom->getResult($db,$sql);
		
		?>

		<div class="page_actions">
				
                <table width="100%">
   	            <form name="search_form" action="questions.php" method="post" enctype="multipart/form-data">
                	
                    
                    <tr>
                    <td width="20%">
                    <label>Enter name or email address</label>
					<input type="text" name="search_str" class="searchbox" placeholder="Search Requests" />
                    </td>
                    <td width="10%">
                    <div style="padding-top:17px;">
                	<label>Date From</label>
					<input id="datepicker1" type="text" name="date_from" value="none" style='width:80px;'/>
                    </div>
                    </td>
                    <td width="10%">
                    <div style="padding-top:17px;">
					<label>Date To</label>
					<input id="datepicker2" type="text" name="date_to" value="today" style='width:100px;'/>
                    </div>
					</td>
                    <td>
                    <div style="padding-top:47px;">
					<button type="submit" value="search">Submit</button>
                    </div>
                    </td>
                    
                </form>
				    </tr>		
                </table>
        </div>
                
		<div class="clear"></div>	
            
		<div class="data_table">
        
        <?php 
		if($total_rows > $rows_per_page){
					
			echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "questions-all.php", $sortby, $a_d, 0, 0,  $search_str);
					
					
			echo "<br /><br /><br /><br />";
		}
		?>	
            
        <?php require_once("../manage/includes/tablesort.php"); ?>

		<table cellpadding="10" cellspacing="0">
					<thead>
						<tr>
          					<th <?php addSortAttr('name',true); ?>>
                            Name
                            <i <?php addSortAttr('name',false); ?>></i>
                            </th>

          					<th <?php addSortAttr('email',true); ?>>
                            Email Address
                            <i <?php addSortAttr('email',false); ?>></i>
                            </th>
          					<th <?php addSortAttr('date_submitted',true); ?>>
                            Date Submitted
                            <i <?php addSortAttr('date_submitted',false); ?>></i>
                            </th>
          					
	
							<th width="12%">View</th>
							<th width="5%">Delete</th>
						</tr>
					</thead>
					<?php
					
					$block = ''; 
					while($row = $result->fetch_object()) {
						
						$block .= "<tr>"; 
						// strip all slashes
						$block .= "<td valign='top'>".stripslashes($row->visitor_name)."</td>";			
						
						//$block .= "<td valign='top'>".stripAllSlashes($row->city)." ".$row->state."</td>";
							
						$block .= "<td valign='top'>".$row->visitor_email."</td>";								
							
							
						$block .= "<td valign='top'>".date("F j, Y, g:i a", $row->q_date)."</td>";			
						
						
						$url_str = "view-question.php";
						$url_str .= "?id=".$row->id;
						$url_str .= "&pagenum=".$pagenum;
						$url_str .= "&sortby=".$sortby;
						$url_str .= "&a_d=".$a_d;
						$url_str .= "&truncate=".$truncate;
						$url_str .= "&search_str=".$search_str;
						
						
						$block .= "</td>";	
						$block .= "<td valign='top'>";
						$block .= "<a class='btn btn-small' href='".$url_str."'><i class='idea-icon-eye-open'></i> View / Print</a></td>";
						$block .= "<td valign='middle'>";
						
						$block .= "<a class='btn btn-danger confirm'><i class='icon-remove icon-white'></i><input type='hidden' id='".$row->id."' class='itemId' value='".$row->id."' /></a></td>";
						
						$block .= "</tr>";
					}
					echo $block;
					?>
				</table>
				<?php 
				if($total_rows > $rows_per_page){
					echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "questions-all.php", $sortby, $a_d, 0, 0,  $search_str);

				}
				?>	                
			</div>
		
	
    </div>
	<p class="clear"></p>
	<?php 
	require_once("includes/user-admin-footer.php");
	
	
	$url_str = "questions.php";
	$url_str .= "?pagenum=".$pagenum;
	$url_str .= "&sortby=".$sortby;
	$url_str .= "&a_d=".$a_d;
	$url_str .= "&truncate=".$truncate;
	$url_str .= "&search_str=".$search_str;
	
	?>
</div>


<div id="content-delete" class="confirm-content">
	<h3>Are you sure you want to delete this design question?</h3>
	<form name="del_question" action="<?php echo $url_str; ?>" method="post" target="_top">
		<input id="question_id" class="itemId" type="hidden" name="del_question_id" value='' />
		
        <a class="btn btn-large dismiss">No, Cancel</a>
        
		<button class="btn btn-danger btn-large" name="del_question" type="submit" >Yes, Delete</button>
	</form>
</div>
<div class="disabledMsg">
	<p>Sorry, this item can't be deleted or inactive.</p>
</div>

</body>
</html>
