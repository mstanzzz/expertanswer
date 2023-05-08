<?php
require_once('../includes/config.php'); 

class Pages{
	
	function newProfileSetup($new_profile_account_id)
	{
		$ts = time();

		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
	


		


		
		$sql = "INSERT INTO testimonial_page 
			(content, last_update, profile_account_id) 
			VALUES ('Some content goes here', '".$ts."', '".$new_profile_account_id."')"; 
		$result = $dbCustom->getResult($db,$sql);
		


	
	
	
}



	function recurse_copy($src,$dst) { 
		$dir = opendir($src); 
		@mkdir($dst); 
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' )) { 
				if ( is_dir($src . '/' . $file) ) { 
					$this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
				} 
				else { 
					copy($src . '/' . $file,$dst . '/' . $file); 
				} 
			} 
		} 
		closedir($dir); 
	} 




	
		
	function undoProfileSetup($profile_account_id)
	{
		$ts = time();
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(SITE_DATABASE);
				

		$sql = "DELETE FROM logo WHERE profile_account_id = '".$profile_account_id."'"; 		
		$result = $dbCustom->getResult($db,$sql);		


		$sql = "DELETE FROM contact_us 
				WHERE profile_account_id = '".$profile_account_id."'";
		$result = $dbCustom->getResult($db,$sql);
		

		
		
		

	}






	function getPageListArray($profile_account_id)
	{
		$page_list_array = array();	
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(SITE_DATABASE);	

        $sql = "SELECT max(home_id) AS id FROM home 
		WHERE profile_account_id = '".$profile_account_id."'";
		
		$p_res = $dbCustom->getResult($db,$sql);
		
		$p_obj = $p_res->fetch_object();
		
		
		$page_list_array[0]["page_id"] = $p_obj->id;
		$page_list_array[0]["page_manage_path"] = "home.php?home_id=".$p_obj->id;							
		$page_list_array[0]['page_name'] = "home";
		$page_list_array[0]['url'] = "/home.html";							
		$page_list_array[0]["active"] = 1;

        $sql = "SELECT * FROM page_seo 
		WHERE profile_account_id = '".$profile_account_id."'
		AND added_page_id = '0'		
		AND page_name != 'account'
		AND page_name != 'order-history'
		AND page_name != 'order-receipt'
		AND page_name != 'account-designs'
		AND page_name != 'app'
		AND page_name != 'blog-more'
		AND page_name != 'checkout'
		AND page_name != 'default'
		AND page_name != 'design'
		AND page_name != 'email-us'
		AND page_name != 'give-testimonial'
		AND page_name != 'home'
		AND page_name != 'item-details'
		AND page_name != 'news'
		AND page_name != 'news-more'
		AND page_name != 'quick-installation'
		AND page_name != 'shop'
		AND page_name != 'showroom-details'
		AND page_name != 'signup-form'
		AND page_name != 'social-network'
		AND page_name != 'social-network-about'
		AND page_name != 'social-network-answer'
		AND page_name != 'social-network-answers'
		AND page_name != 'social-network-before-after'
		AND page_name != 'social-network-blog'
		AND page_name != 'social-network-blog-article'
		AND page_name != 'social-network-gallery'
		AND page_name != 'social-network-members'
		AND page_name != 'social-network-profile'
		AND page_name != 'social-network-results'
		AND page_name != 'signin-form'
		AND page_name != 'search-results'
		AND page_name != 'email-design'
		AND page_name != 'in-home-consultation'
		AND page_name != 'we-design-fax'";


		$sql .= "ORDER BY page_name";

		
		$result = $dbCustom->getResult($db,$sql);
		
		$i = 1;
        while($row = $result->fetch_object()) {
		
			if(!$module->hasSeoModule($profile_account_id)){
				$page_list_array[$i]['url'] = "/".$row->seo_name.".html";			
			}else{
				$page_list_array[$i]['url'] = "/".$row->page_name.".html";							
			}

			$page_list_array[$i]["optional"] = $row->optional;
			$page_list_array[$i]["available"] = $row->available;
			
			$page_list_array[$i]["active"] = $row->active;
			$page_list_array[$i]["page_seo_id"] = $row->page_seo_id;
			$page_list_array[$i]["page_id"] = 0;
			$page_list_array[$i]["page_manage_path"] = '';							
			$page_list_array[$i]['page_name'] = $row->page_name;

			$page_list_array[$i]['mssl'] = $row->mssl;


			if($row->page_name == 'about-us'){
		        $sql = "SELECT max(about_us_id) AS id FROM about_us 
				WHERE profile_account_id = '".$profile_account_id."'";
				
				$p_res = $dbCustom->getResult($db,$sql);
				if($p_res->num_rows > 0){
					
					$p_obj = $p_res->fetch_object();
					
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/about-us.php?about_us_id=".$page_id;							

			}

			if($row->page_name == 'our-guarantee'){
		        $sql = "SELECT max(guarantee_id) AS id FROM guarantee 
				WHERE profile_account_id = '".$profile_account_id."'";
				
				$p_res = $dbCustom->getResult($db,$sql);
				if($p_res->num_rows > 0){
					
					$p_obj = $p_res->fetch_object();
					
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/our-guarantee.php?guarantee_id=".$page_id;							

			}



			if($row->page_name == 'contact-us'){
		        $sql = "SELECT max(contact_us_id) AS id FROM contact_us 
				WHERE profile_account_id = '".$profile_account_id."'";
				
				$p_res = $dbCustom->getResult($db,$sql);
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/contact-us.php?contact_us_id=".$page_id;							

			}
			
			if($row->page_name == 'discounts'){
		        $sql = "SELECT max(discount_id) AS id FROM discount 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/discount.php?discount_id=".$page_id;							

			}

			if($row->page_name == 'discounts-how'){
		        $sql = "SELECT max(discount_how_id) AS id FROM discount_how 
				WHERE profile_account_id = '".$profile_account_id."'";
				
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/discount-how.php?discount_how_id=".$page_id;							

			}

			if($row->page_name == 'downloads'){
		        $sql = "SELECT max(downloads_page_id) AS id FROM downloads_page 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				
				//$page_id = 999;
				
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/downloads-page.php?downloads_page_id=".$page_id;							

			}
			
			if($row->page_name == "guides-and-tips"){
		        
		        $sql = "SELECT max(guides_tips_page_id) AS id FROM guides_tips_page 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/guides-tips.php?guides_tips_page_id=".$page_id;							

			}
			

			if($row->page_name == 'installation'){
		        $sql = "SELECT max(installation_id) AS id FROM installation 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/installation.php?installation_id=".$page_id;							

			}
			

			if($row->page_name == 'privacy-statement'){
		        $sql = "SELECT max(privacy_statement_id) AS id FROM privacy_statement 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/privacy-statement.php?privacy_statement_id=".$page_id;							
				
			}

			if($row->page_name == 'policies'){
		        $sql = "SELECT max(policy_page_id) AS id FROM policy_page 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/policy.php?policy_page_id=".$page_id;							

			}

			if($row->page_name == 'shipping'){
		        $sql = "SELECT max(shipping_term_id) AS id FROM shipping_term 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/shipping-term.php?shipping_term_id=".$page_id;	
			}

			if($row->page_name == 'shipping-time'){
		        $sql = "SELECT max(shipping_time_id) AS id FROM shipping_time 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/shipping-time.php?shipping_time_id=".$page_id;							

			}

			if($row->page_name == 'specs'){
		        $sql = "SELECT max(specs_content_id) AS id FROM specs_content 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/specs.php?specs_content_id=".$page_id;							

			}

			if($row->page_name == 'terms-of-use'){
		        $sql = "SELECT max(terms_of_use_id) AS id FROM terms_of_use 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/terms-of-use.php?terms_of_use_id=".$page_id;							

			}

			if($row->page_name == 'testimonials'){
		        $sql = "SELECT max(testimonial_page_id) AS id FROM testimonial_page
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/testimonial-page.php?testimonial_page_id=".$page_id;							

			}

			if($row->page_name == 'showroom'){
		        $sql = "SELECT max(showroom_id) AS id FROM showroom
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/showroom.php?showroom_id=".$page_id;							

			}


			if($row->page_name == 'faq'){
		        $sql = "SELECT max(faq_page_id) AS id FROM faq_page 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/faq.php?faq_page_id=".$page_id;							

			}


			if($row->page_name == 'process'){
		        $sql = "SELECT max(process_page_id) AS id FROM process_page 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]['page_manage_path'] = SITEROOT."/manage/cms/pages/process.php?process_page_id=".$page_id;							
			}

			
			if($row->page_name == "feedback"){
		        $sql = "SELECT max(feedback_page_id) AS id FROM feedback_page 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/feedback-page.php?feedback_page_id=".$page_id;							

			}

			
			/*
			if($row->page_name == "keyword-landing"){
		        $sql = "SELECT max(keyword_landing_id) AS id FROM keyword_landing 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_id = $p_obj->id;	
				}else{
					$page_id = 0;
				}
				$page_list_array[$i]['page_id'] = $page_id;
				$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/keyword-landing.php?keyword_landing_id=".$page_id;							
			}
			*/
	
			if($row->page_name == "blog"){
				$page_list_array[$i]["page_id"] = 0;
				// No edit page yet
				$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/blog_page_id=".$p_obj->id;							

			}

			if($row->page_name == "shopping-cart"){
				$page_list_array[$i]["page_id"] = 0;
				// No edit page yet
				$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/shopping-cart_id=".$p_obj->id;							

			}


			$i++;
		}

		// initialize
		$added_page_seo_id = 0;
		$added_page_active = "none";
		$added_page_ssl = 0;
		$this->resetPagesSession();

		$sql = "SELECT page_name, added_page_id 
				FROM added_page
				WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
		$result = $dbCustom->getResult($db,$sql);		
		while($row = $result->fetch_object()) {


			foreach($_SESSION["pages"] as $p_val){
				
				if($p_val['page_name'] == $row->page_name){						
					$added_page_seo_id = $p_val["page_seo_id"];
					$added_page_active = $p_val["active"];
					$added_page_ssl = $p_val["ssl"];
				}
			}		

			$page_list_array[$i]['url'] = "/".$row->page_name.".html";									
			$page_list_array[$i]["active"] = $added_page_active; 
			$page_list_array[$i]["page_seo_id"] = $added_page_seo_id;
			$page_list_array[$i]["page_id"] = $row->added_page_id;
			$page_list_array[$i]['page_name'] = $row->page_name;
			$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/custom-pages/added-page.php?added_page_id=".$row->added_page_id;							
			$page_list_array[$i]["optional"] = 0;
			$page_list_array[$i]["available"] = 1;
			$page_list_array[$i]['mssl'] = $added_page_ssl;

			$i++;

		}

		return $page_list_array;

	}
	
	/*
	function getKeywordLandingPagesArray($profile_account_id)
	{
		$ret_array = array();
        $sql = "SELECT keyword_landing_id 
				FROM keyword_landing 
				WHERE profile_account_id = '".$profile_account_id."'";
		$result = $dbCustom->getResult($db,$sql);
		while($row = $result->fetch_object()){
			$ret_array[] = $row->keyword_landing_id;
		}
		return $ret_array;	
	}
	*/
	
	
	
	function getPageDesignListArray($profile_account_id)
	{
		
		$module = new Module;	

		$page_list_array = array();	
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(SITE_DATABASE);	

        $sql = "SELECT * FROM page_seo 
		WHERE profile_account_id = '".$profile_account_id."'
		AND added_page_id = '0'		
		AND (page_name = 'email-design'
		OR page_name = 'we-design-fax'
		OR page_name = 'in-home-consultation'
		OR page_name = 'design'
	
		)";
		
				
		
		
		$sql .= "ORDER BY page_name";

		$db = $dbCustom->getDbConnect(SITE_DATABASE);
        $result = $dbCustom->getResult($db,$sql);        
		$i = 0;
        while($row = $result->fetch_object()) {
		
			if(!$module->hasSeoModule($profile_account_id)){
				$page_list_array[$i]['url'] = "/".$row->seo_name.".html";			
			}else{
				$page_list_array[$i]['url'] = "/".$row->page_name.".html";							
			}

			$page_list_array[$i]["optional"] = $row->optional;
			$page_list_array[$i]["available"] = $row->available;
			
			$page_list_array[$i]["active"] = $row->active;
			$page_list_array[$i]["page_seo_id"] = $row->page_seo_id;
			$page_list_array[$i]["page_id"] = 0;
			$page_list_array[$i]["page_manage_path"] = '';							
			$page_list_array[$i]['page_name'] = $row->page_name;

			$page_list_array[$i]['mssl'] = $row->mssl;
			
			if($row->page_name == "in-home-consultation"){
		        $sql = "SELECT max(in_home_consultation_id) AS id FROM in_home_consultation 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				$p_obj = $p_res->fetch_object();
				$page_list_array[$i]["page_id"] = $p_obj->id;
				$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/in-home-consultation.php?in_home_consultation_id=".$p_obj->id;							

			}

			if($row->page_name == "email-design"){
		        $sql = "SELECT max(design_email_content_id) AS id FROM design_email_content 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				if($p_res->num_rows > 0){
					$p_obj = $p_res->fetch_object();
					$page_list_array[$i]["page_id"] = $p_obj->id;
					$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/design-email-content.php?design_email_content_id=".$p_obj->id;							
				}else{
					$page_list_array[$i]['page_id'] = 1;
					$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/design-email-content.php?design_email_content_id=1";
				}
			}

			
			if($row->page_name == "we-design-fax"){
		        $sql = "SELECT max(we_design_fax_id) AS id FROM we_design_fax 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				$p_obj = $p_res->fetch_object();
				$page_list_array[$i]["page_id"] = $p_obj->id;
				$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/we-design-fax.php?we_design_fax_id=".$p_obj->id;							

			}


			if($row->page_name == "design"){
		        $sql = "SELECT max(design_id) AS id FROM design 
				WHERE profile_account_id = '".$profile_account_id."'";
				$p_res = $dbCustom->getResult($db,$sql);
				
				$p_obj = $p_res->fetch_object();
				$page_list_array[$i]["page_id"] = $p_obj->id;
				$page_list_array[$i]["page_manage_path"] = SITEROOT."/manage/cms/pages/design.php?design_id=".$p_obj->id;							
			}
			
			

			$i++;
		}

		return $page_list_array;

	}
	
	function resetPagesSession(){
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(SITE_DATABASE);
		$_SESSION["pages"] = array();
		$sql = "SELECT page_seo_id, page_name, seo_name, mssl, active  
				FROM page_seo
				WHERE profile_account_id = '".$_SESSION['profile_account_id']."'
				ORDER BY page_name
				";		 		
		$res = $dbCustom->getResult($db,$sql);
		
		$i = 0;			
		while($row = $res->fetch_object()){
			$_SESSION["pages"][$i]['page_name'] = $row->page_name;
			$_SESSION["pages"][$i]['seo_name'] = $row->seo_name;
			$_SESSION["pages"][$i]["page_seo_id"] = $row->page_seo_id;
			$_SESSION["pages"][$i]["ssl"] = $row->mssl;
			$_SESSION["pages"][$i]["active"] = $row->active;

			$i++;
		}	
	}
	
}
?>