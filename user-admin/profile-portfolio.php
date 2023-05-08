<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

if(!$lgn->isLogedIn()){
	$header_str =  "Location: index.php?msg=You are not logged in";	
	header($header_str);
}

$profile_id = $lgn->getProfileId();


$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";

//$sn_setup_progress->completeStep("profile_image" ,$_SESSION["profile_account_id"]);

if(isset($_POST['add_portfolio_item'])){
	
	$caption = trim(addslashes($_POST['caption'])); 

	$active = trim($_POST['active']); 
	
	$img_id = $_POST['img_id'];
	
	
	$stmt = $db->prepare("INSERT INTO portfolio_item
							(caption
							,img_id
							,active
							,profile_id)
							VALUES
							(?,?,?,?)"); 
								
							//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("siii",
		$caption
		,$img_id 
		,$profile_id
		,$active)){								
								
			
	}else{
		$stmt->execute();
		$stmt->close();
						
		$msg = "Your change is now live.";
	}
	
}

if(isset($_POST['edit_portfolio_item'])){
	
	$caption = trim(addslashes($_POST['caption'])); 

	$portfolio_item_id = $_POST['portfolio_item_id'];
	$active = $_POST['active'];
	
	$img_id = $_POST['img_id'];
	
	$stmt = $db->prepare("UPDATE portfolio_item
							SET caption = ?
							,img_id = ? 
							,profile_id = ?
							,active = ? 								
						WHERE portfolio_item_id = ?");
								
								//echo 'Error-1 UPDATE   '.$db->error;
								
	if(!$stmt->bind_param("siiii",
						$caption
						,$img_id 
						,$profile_id
						,$active	 
						,$portfolio_item_id)){								
								
	}else{
		$stmt->execute();
		$stmt->close();
				
		$msg = "Your change is now live.";
	}
	

}


if(isset($_POST["del_portfolio_item"])){

		$portfolio_item_id = $_POST["del_portfolio_item_id"];

		$sql = "SELECT image.file_name, image.img_id
				FROM portfolio_item, image 
				WHERE portfolio_item.img_id = image.img_id
				AND portfolio_item.portfolio_item_id = '".$portfolio_item_id."'";	
		$result = $dbCustom->getResult($db,$sql);		
		
		if($result->num_rows > 0){
			
			$img_obj = $result->fetch_object();			
			
			$sql ="DELETE FROM image WHERE img_id = '".$img_obj->img_id."'";
			$result = $dbCustom->getResult($db,$sql);
			
			
			
			$fn_path = "../saascustuploads/".$_SESSION['profile_account_id']."/portfolio/".$profile_id."/thumb/".$img_obj->file_name;			
			if(file_exists($fn_path)){
				unlink ($fn_path);
			}
			
			$fn_path = "../saascustuploads/".$_SESSION['profile_account_id']."/portfolio/".$profile_id."/".$img_obj->file_name;			
			if(file_exists($fn_path)){
				unlink ($fn_path);
			}
			
		}
		
		$sql = "DELETE FROM portfolio_item WHERE portfolio_item_id = '".$portfolio_item_id."'";
		$result = $dbCustom->getResult($db,$sql);		

	
	$msg = "Image deleted.";

}


if(isset($_POST['set_active'])){
	
	$featured_portfolio_item_id = (isset($_POST['featured_portfolio_item_id']))? $_POST['featured_portfolio_item_id'] : 0;
	
	$sql = "UPDATE portfolio_item SET active = '0', featured = '0' WHERE profile_id = '".$profile_id."'";
			$result = $dbCustom->getResult($db,$sql);
	
	$sql = "UPDATE portfolio_item SET featured = '1' WHERE id = '".$featured_portfolio_item_id."'";		
			$result = $dbCustom->getResult($db,$sql);

	$actives = isset($_POST['active'])? $_POST['active'] : array();

	foreach($actives as $key => $value){
		$sql = "UPDATE portfolio_item SET active = '1' WHERE portfolio_item_id = '".$value."'";
		$result = $dbCustom->getResult($db,$sql);
		//echo "key: ".$key."   value: ".$value."<br />"; 
	}

	$msg = "Changes Saved.";

}

unset($_SESSION['temp_page_fields']);
unset($_SESSION['img_id']);

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

<script>
function validate(theform){
			
	return true;
}

</script>

</head>
<body style="background-color: #FFF1E5;">
<div style="margin-left:15px;">
	<img height="40" src="<?php echo SITEROOT;?>/img/nat.png" />
	<?php
	echo "<span>Welcome  ".$lgn->getFullName()."<span>";
	echo "<span style='margin-left:30px; color:red; font-size:1.3em;'>".$msg."</span>";
	echo "<br />";
	require_once('includes/user-admin-nav.php');
	?>
</div>
<div style='clear:both;'></div>


<div class="row">
	<div class="col-md-12">
		<div style="margin:10px;">		

		Portfolio
        
		<form name="form" action="profile-portfolio.php" method="post">    
            <a class="pure-button" href="add-profile-portfolio-item.php">Add Portfolio Item</a>
                
            <input  class="pure-button" type="submit" name="set_active" value="Save Actives" />

				<table class="pure-table">
                	<thead>
						<tr>
							<th width="15%">Image</th>
							<th width="45%">Caption</th>
							<th width="10%">Featured</th>
                			<th width="10%">Active</th>            
                            <th width="10%">Edit</th>
							<th width="10%">Delete</th>
						</tr>
					<thead>                        
					<tbody>
					<?php
					

					$sql = sprintf("SELECT image.file_name
							,portfolio_item.caption
							,portfolio_item.featured
							,portfolio_item.id
							,portfolio_item.active	 
							FROM portfolio_item, image 
							WHERE portfolio_item.img_id = image.id
							AND portfolio_item.profile_id = '%u'", 
							$profile_id);
					$result = $dbCustom->getResult($db,$sql);
					           
					$block = "";
					while($row = $result->fetch_object()) {
						
						//$block	.= "<input type='hidden' name='on_this_page[]' value='".$row->id."' />";
						
						$block .= "<tr>";						
						$block .= "<td><img src='".SITEROOT."/saascustuploads/".$_SESSION['profile_account_id']."/".$profile_id."/portfolios/thumb/".$row->file_name."'  /></td>";

						$block .= "<td>".$row->caption."</td>";
						
						$is_featured = ($row->featured)? "checked" : "";
						$block .= "<td valign='top'>
						<div class='radiotoggle on'> 
						<span class='ontext'>ON</span>
						<a class='switch on' href='#'></a>
						<span class='offtext'>OFF</span>
						<input type='radio' class='radioinput' name='featured_portfolio_item_id' value='".$row->id."' $is_featured />
						</div>
						</td>";		

					
						$status = ($row->active)? "checked='checked'" : '';
						$block	.= "<td><div class='checkboxtoggle on'> 
						<span class='ontext'>ON</span>
						<a class='switch on' href='#'></a>
						<span class='offtext'>OFF</span>
						<input type='checkbox' class='checkboxinput' name='active[]' value='".$row->id."' $status /></div></td>";
							
												
						$block .= "<td><a class='btn btn-primary btn-small' 
									data-fancybox data-type='iframe' 
									data-src='edit-profile-portfolio-item.php?id=".$row->id."' href='#'>Edit</a></td>";

						$block .= "<td valign='middle'><a class='btn btn-danger confirm'>Delete
						<input type='hidden' id='".$row->id."' class='itemId' value='".$row->id."' /></a></td>";


						$block .= "</tr>";

					}
					
					echo $block;
					
					?>
                    
                    
					</tbody>
				</table>
			
	
    </form>
</div>
</div>
</div>

<script src="../js/jquery.min.js"></script>

</body>
</html>
