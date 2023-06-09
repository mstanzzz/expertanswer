<?php

class CustomMetaTags {

	public $meta_tags;

	public function CustomMetaTags() {
		
		if(!isset($_SESSION['custom_meta_tags'])){		
			
			$_SESSION['custom_meta_tags'] = array();
			$dbCustom = new DbCustom();
			$db = $dbCustom->getDbConnect(SITE_DATABASE);	
					
			$sql = "SELECT tag  
						FROM custom_meta_tags 
						WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";

			
			$result = $dbCustom->getResult($db,$sql);			
			while($row = $result->fetch_object()){
				$_SESSION['custom_meta_tags'][] = $row->tag; 	
			}
		}				
		$this->meta_tags = $_SESSION['custom_meta_tags'];
	}

	public function getCustomMetaTagsBlock() {
		$block = '';
		foreach($this->meta_tags as $tag){
			$block .= $tag;	
		}
		return $block;
	}

}

?>
