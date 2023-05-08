<?php

// uid1 and uid2 can be used for anything you want to pass on the url


function getSocialAdminPagination($total_rows=0
							,$rows_per_page=0
							,$pagenum=1
							,$truncate=1
							,$last=1
							,$path=''
							,$sortby=''
							,$a_d='a'
							,$uid1=0
							,$uid2=0){

	$previous = $pagenum-1;
	$next = $pagenum+1;
	if ($next > $last) $next = $last; 

	$block = "";
	$block .= "<div class='pagination'>";
	$block .= "<span>Displaying ".$rows_per_page." of ".$total_rows." Items</span>"; 
	$block .= "<span>Page ".$pagenum." of <a href='".$path."?pagenum=".$last."&sortby=".$sortby."&a_d=".$a_d."&uid1=".$uid1."&uid2=".$uid2."'>".$last."</a></span>"; 
	$block .= "<ul>";
	$block .= "<li class='back_arrow'><a href='".$path."?pagenum=".$previous."&sortby=".$sortby."&a_d=".$a_d."&uid1=".$uid1."&uid2=".$uid2."'><i class='icon-chevron-left'></i></a></li>";
	for($i = 1; $i <= $last; $i++){
		
		if($i > 8 && $truncate){
			
			$block .= "<li><a href='".$path."?pagenum=".$i."&truncate=0&sortby=".$sortby."&a_d=".$a_d."&uid1=".$uid1."&uid2=".$uid2."'>...</a></li>";
			break;
			
		}else{
		
			if($i == $pagenum){
				$block .= "<li class='current_page'>$i</li>";
			}else{
				$block .= "<li><a href='".$path."?pagenum=".$i."&truncate=0&sortby=".$sortby."&a_d=".$a_d."&uid1=".$uid1."&uid2=".$uid2."'>$i</a></li>";
			}
		
		}		
		
	}
	$block .= "<li class='next_arrow'><a href='".$path."?pagenum=".$next."&truncate=0&sortby=".$sortby."&a_d=".$a_d."&uid1=".$uid1."&uid2=".$uid2."'><i class='icon-chevron-right'></i></a></li>";
	$block .= "</ul>";
	$block .= "</div>";
	
	return $block;
		
}



function getNumBlogPostsPerCategory($category_id){

	
	$dbCustom = new DbCustom();
	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);			

	$ret = 0;
	
	$sql = "SELECT count(blog_post_id) as num_posts 
			FROM blog_post
			WHERE category_id = '".$category_id."'";
	$result = $dbCustom->getResult($db,$sql);
	
	if($result->num_rows > 0){
		$object = $result->fetch_object(); 
	
		$ret =	$object->num_posts;
	}
	
	return $ret;
	
}


function getNumCategoryBlogPostsPerProfile($category_id, $profile_id){

	$dbCustom = new DbCustom();
	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);							
	
	$ret = 0;
	
	$sql = "SELECT count(blog_post_id) as num_posts 
			FROM blog_post
			WHERE category_id = '".$category_id."'
			AND posted_by_profile_id = '".$profile_id."'";
	$result = $dbCustom->getResult($db,$sql);
	
	if($result->num_rows > 0){
		$object = $result->fetch_object(); 
	
		$ret =	$object->num_posts;
	}
	
	return $ret;

}





?>