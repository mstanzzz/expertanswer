<?php

class SocialBreadCrumb{
	
	
	function __construct() {
		
		if(!isset($_SESSION['user_breadcrumb'])){
			$_SESSION['user_breadcrumb'] = array();
			$crumb = array();
			$crumb['label'] = "home";
			$crumb['url'] = "user-admin-landing.php";
			$_SESSION['user_breadcrumb'][0] = $crumb;
		}
	}

	
	function reSet()
	{
		//unset($_SESSION['admin_breadcrumb']);
		$_SESSION['user_breadcrumb'] = array();
		$crumb = array();
		$crumb['label'] = "home";
		$crumb['url'] = "user-admin-landing.php";
		$_SESSION['user_breadcrumb'][0] = $crumb;
	}

	function crumb_count()
	{
		return count($_SESSION['user_breadcrumb']);	
	}


	//function prune($level)
	function prune($label)
	{



      	foreach ($_SESSION['user_breadcrumb'] as $i => $crumb)
		{ 
		
			if($label == $crumb["label"]){
				
				while( $i < count($_SESSION['user_breadcrumb'])-1){
					array_pop($_SESSION['user_breadcrumb']);		
				}
							
			}
		
		}

		
	}


	function add($label, $url)
	{

		$crumb = array();
		$crumb['label'] = $label;
		$crumb['url'] = $url;

		$_SESSION['user_breadcrumb'][] = $crumb; 
		
		 
	}


	function output()
	{
		
		
		
		$ret = "";
		
		
      	foreach ($_SESSION['user_breadcrumb'] as $i => $crumb)
		{ 
		
				if($i > 0){
					$img = "<img src='../img/double_arrow.jpg'>";
				}else{
					$img = "";
				}
				
			if($i == (count($_SESSION['user_breadcrumb']) -1)){
					
						
	            	$ret .= $img."  ".$crumb['label']."";

			}else{
				
            	$ret .= $img."  <a href='".$crumb['url']."' title='".$crumb['label']."'>".$crumb['label']."</a>";


			}
			
			
		}
				
		return "<div class='breadcrumb'>".stripslashes($ret)."</div>";
	}

	
}




?> 