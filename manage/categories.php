<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
	
$lgn = new CustomerLogin;

$page_title = "Categories";



$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';


if(isset($_POST['add_cat'])){

	$name = trim(addslashes($_POST['name'])); 
	//$description = trim(addslashes($_POST['description'])); 

	$cat_exists = 0;
		
	$stmt = $db->prepare("SELECT id FROM category 
							WHERE name = ?
							AND profile_account_id = ?");
	
	if(!$stmt->bind_param("si", $name, $_SESSION['profile_account_id'])){
		//echo 'Error '.$db->error;
	}else{
		$stmt->execute();
		$stmt->bind_result($id);
		if($stmt->fetch()){
			$msg = "This category already exists";
			$stmt->close();
			$cat_exists = 1;	
		}		
	}
	
	if(!$cat_exists){

		$stmt = $db->prepare("INSERT INTO category 
								(name, profile_account_id)
								VALUES(?,?)");	
					
		if(!$stmt->bind_param("si", $name, $_SESSION['profile_account_id'])){
			//echo 'Error '.$db->error;
		}else{
			$stmt->execute();
			$stmt->close();
			$msg = "Category added";
		}
	}
			

}


if(isset($_POST['edit_cat'])){

	$name = trim(addslashes($_POST['name'])); 
	//$description = trim(addslashes($_POST['description'])); 
	$id = $_POST["id"]; 


	$stmt = $db->prepare("UPDATE category
						SET name = ?
						WHERE id = ?
						AND profile_account_id = ?");
						
		//echo 'Error '.$db->error;	
													
	if(!$stmt->bind_param('sii'
						,$name
						,$id
						,$_SESSION['profile_account_id'])){			
		//echo 'Error-2 '.$db->error;					
	}else{
	
		$stmt->execute();
		$stmt->close();		
		
		$msg = 'Update successful';
	}


}


if(isset($_POST['del_category'])){

	$id = $_POST["del_category_id"]; 
	
	$sql = sprintf ("DELETE FROM category
			WHERE id = '%u'
			AND profile_account_id = '%u'",$id, $_SESSION['profile_account_id']);
	$result = $dbCustom->getResult($db,$sql);
	$msg = 'Deleted';
}


if(isset($_POST['set_active'])){
	
	
	$on_this_page = (isset($_POST['on_this_page']))? $_POST['on_this_page'] : array();
	
	if(is_array($on_this_page)){	
		foreach($on_this_page as $value){
			$sql = "UPDATE category SET active = '0' WHERE id = '".$value."'";
			$result = $dbCustom->getResult($db,$sql);
			
		}
	}
	
	$actives = (isset($_POST['active']))? $_POST['active'] : array();
	
	if(is_array($actives)){	
		foreach($actives as $value){
			$sql = "UPDATE category SET active = '1' WHERE id = '".$value."'";
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
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
<script src="../js/tinymce/tinymce.min.js"></script>

<style>

.fancybox-slide--iframe .fancybox-content {
	width  : 600px;
	height : 300px;
	margin: 0;
}

</style>

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  
  
<script src="<?php echo SITEROOT; ?>/js/jquery.fancybox.min.js"></script>  

<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/inlineConfirmation.js"></script>

<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/formtoggles.js"></script>

<script>

$( function() {
    $("#datepicker1").datepicker();
	$("#datepicker2").datepicker();
} );
</script>
</head>

<body>

<?php
	require_once('includes/manage-header.php');
	//require_once('/includes/manage-top-nav.php');
?>
<div class="manage_page_container">
	<div class="manage_side_nav">

	</div>

    <form action="categories.php" method="post" enctype="multipart/form-data">

	<div class="manage_main">
		<?php 
        //require_once($real_root."/manage/includes/ask-category-section-tabs.php");
		
			$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : '';
			$a_d = (isset($_GET['a_d'])) ? $_GET['a_d'] : 'a';
			
			$pagenum = (isset($_GET['pagenum'])) ? addslashes($_GET['pagenum']) : 0;
			$truncate = (isset($_GET['truncate'])) ? addslashes($_GET['truncate']) : 1;
			
			$search_str = '';
		
		?>
        
        
			<div class="page_actions"> 
            <a class="btn btn-large" data-fancybox data-type="iframe" data-src="add-category.php" href="#">
                Add a Category
            </a>
                
            <button name="set_active" type="submit" class="btn btn-success btn-large"> Save Changes </button>

			</div>
			<div class="data_table">
             <?php
			
		


			$sql = "SELECT * 
					FROM category
					WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
			
			$nmx_res = $dbCustom->getResult($db,$sql);
			

			$total_rows = $nmx_res->num_rows;
			$rows_per_page = 16;
			$last = ceil($total_rows/$rows_per_page); 
			
			if ($pagenum < 1){ 
				$pagenum = 1; 
			}elseif ($pagenum > $last){ 
				$pagenum = $last; 
			} 
		
			
			$result = $dbCustom->getResult($db,$sql);			
			
			if($total_rows > $rows_per_page){
                echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "categories.php", $sortby, $a_d);
				echo "<br />";
			}
			?>
				<table cellpadding="10" cellspacing="0">
					<thead>
						<tr>
                        
                        
  							<th>
                            Category Name
                            </th>
                            <th>Active</th>
							<th width="12%">Edit</th>
							<th width="5%">Delete</th>
						</tr>
					</thead>
					<tbody>
                    <?php
					//<i class='icon-cog icon-white'></i>
					//<i class='icon-remove icon-white'></i>
                    $block = ''; 
                    while($row = $result->fetch_object()){
						
						$block	.= "<input type='hidden' name='on_this_page[]' value='".$row->id."' />";
						
						$block .= "<tr>";
						$block .= "<td>$row->name</td>";
						
						
						$status = ($row->active)? "checked='checked'" : '';
						$block	.= "<td><div class='checkboxtoggle on'> 
						<span class='ontext'>ON</span>
						<a class='switch on' href='#'></a>
						<span class='offtext'>OFF</span>
						<input type='checkbox' class='checkboxinput' name='active[]' value='".$row->id."' $status /></div></td>";
							
												
						$block .= "<td><a class='btn btn-primary btn-small' 
									data-fancybox data-type='iframe' 
									data-src='edit-category.php?id=".$row->id."' href='#'>Edit</a></td>";

						$block .= "<td valign='middle'><a class='btn btn-danger confirm'>Delete
						<input type='hidden' id='".$row->id."' class='itemId' value='".$row->id."' /></a></td>";
						
						
						$block .= "</tr>";

					}
                    echo $block;
					?>                    
					</tbody>
				</table>
			<?php
			if($total_rows > $rows_per_page){
                echo getPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "categories.php", $sortby, $a_d);
			}
			?>

			</div>
		
	</div>
    
    </form>
    
	
	
	
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
