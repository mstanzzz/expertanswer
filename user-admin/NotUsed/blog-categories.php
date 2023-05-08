<?php
if(!isset($real_root)){
	if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
		$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
	}else{
		$real_root = '..'; 	
	}
}

require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');
require_once($real_root.'/includes/social_admin_functions.php');

$lgn = new CustomerLogin;

$page_title = "Blog Categories";
$page_group = "blog";


$profile_id = $lgn->getProfileId();

$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<link type="text/css" rel="stylesheet" href="../css/manageStyle.css" />

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>  

<script>
$(document).ready(function() {
	
});

tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	content_css : "../css/mce.css"
});



function sortby(thisfile, sortby){
	var url = thisfile+"?sortby="+sortby;
	location.href = url; 
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
		<?php 
		require_once("includes/class.user_bread_crumb.php");		
		$bread_crumb = new SocialBreadCrumb;
		$bread_crumb->reSet();
		$bread_crumb->add("Blog", "blog-landing.php");
		$bread_crumb->add("Blog Categories", "");
        echo $bread_crumb->output();

		?>
		<form name="form" action='blog-categories.php' method='post'>       
        	<input type="hidden" name="set_active_and_featured" value="1">

			<div class="page_actions">
				<a class="btn btn-large btn-primary fancybox fancybox.iframe" href="blog-new-category.php?ret_page=blog-category">
                <i class="icon-plus icon-white"></i> Request a New Blog Category </a>

			</div>
			<div class="data_table">

            <?php
			
			$truncate = (isset($_GET['truncate'])) ? $_GET['truncate'] : 1;
			$sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : '';
			$a_d = (isset($_GET['a_d'])) ? $_GET['a_d'] : 'a';
			$pagenum = (isset($_GET['pagenum'])) ? $_GET['pagenum'] : 0;
		
 			// get all questions for this profile (answered or not), and all unanswred questions (all profiles)
			$sql = "SELECT * 
					FROM category
					WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
			
			if(isset($_POST["product_search"])){
				$search_str = trim(addslashes($_POST["product_search"]));
				$sql .= " AND (name like '%".$search_str."%' || name like '%".$search_str."%')";
			}

			$nmx_res = $dbCustom->getResult($db,$sql);								
			
			$total_rows = $nmx_res->num_rows;
			$rows_per_page = 16;
			$last = ceil($total_rows/$rows_per_page); 
			
			if ($pagenum < 1){ 
				$pagenum = 1; 
			}elseif ($pagenum > $last){ 
				$pagenum = $last; 
			} 
		
			$limit = ' limit ' .($pagenum - 1) * $rows_per_page.','.$rows_per_page;
			
			if($sortby != ''){
				if($sortby == 'name'){
					if($a_d == 'd'){
						$sql .= " ORDER BY name DESC".$limit;
					}else{
						$sql .= " ORDER BY name".$limit;	
					}
				}
			}else{
				$sql .= " ORDER BY category_id".$limit;					
			}
				
			$result = $dbCustom->getResult($db,$sql);
			
			if($total_rows > $rows_per_page){
                echo getSocialAdminPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "blog-categories.php", $sortby, $a_d);
				echo "<br />";
			}
			
			require_once("includes/tablesort.php"); 
			?>




				<table cellpadding="10" cellspacing="0">
					<thead>
						<tr>
  							<th <?php addSortAttr('name',true); ?>>
                            Category Name
                            <i <?php addSortAttr('name',false); ?>></i>
                            </th>
							<th>Articles Total</th>
							<th>My Articles</th>
						</tr>
					</thead>
					<tbody>

                    <?php
					
                    $block = ""; 
                    while($row = $result->fetch_object()){
						$block .= "<tr>";
						$block .= "<td>$row->name</td>";
												
						$block .= "<td>".getNumBlogPostsPerCategory($row->category_id)."</td>";

						$block .= "<td>".getNumCategoryBlogPostsPerProfile($row->category_id, $profile_id)."</td>";

						
						$block .= "</tr>";

					}
                    echo $block;
					?>                    

					</tbody>
				</table>
			<?php
			if($total_rows > $rows_per_page){
                echo getSocialAdminPagination($total_rows, $rows_per_page, $pagenum, $truncate, $last, "blog-categories.php", $sortby, $a_d);
			}
			?>

			</div>
		</form>
</div>
<p class="clear"></p>
<?php 
require_once("includes/user-admin-footer.php");
?>
</div>
<!-- New Delete Confirmation Dialogue -->
<div id="content-delete" class="confirm-content">
	<h3>Are you sure you want to delete this post?</h3>
	<form name="del_blog_post_form" action="blog.php" method="post" target="_top">
		<input id="del_blog_post_id" class="itemId" type="hidden" name="del_blog_post_id" value="" />
		<a class="btn btn-large dismiss">No, Cancel</a>
		<button class="btn btn-danger btn-large" name="del_blog_post" type="submit" >Yes, Delete</button>
	</form>
</div>
<div class="disabledMsg">
	<p>Sorry, this item can't be deleted or inactive.</p>
</div>
</body>
</html>
