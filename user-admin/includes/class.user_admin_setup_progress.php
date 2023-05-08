<?php

// Please add new code for Organizer roles to check profile completeness.
// The criteria for organizer profile completeness are:

// - Profile Image uploaded and active.
// - All fields in 'About Me' filled out.
// - At least one portfolio image uploaded with a caption/description.
// - At least one blog entry written.
// - At least one question answered.
// - At least one before/after blog entry written.
// - At least two skills added.
// - At least one specialty added.

// Additionally, I have put in some dummy code for checking to see if the 
// user role is admin/organizer, and to add a page to check progress if the
// user role is an organizer. This can be found in /organizers/complete-profile.php

class SocialNetworkSetupProgress{


	function newProgressSetup($profile_account_id){
		
		$sql = "SELECT id 
				FROM setup_steps
				WHERE profile_account_id = '".$profile_account_id."'";
		$result = mysql_query ($sql);
		if(!$result)die(mysql_error());
		if(mysql_num_rows($result) < 1){
			
			
			$this->addStep("profile", $profile_account_id);
			$this->addStep("logo", $profile_account_id);
			$this->addStep("banner", $profile_account_id);
			$this->addStep("password", $profile_account_id);
			
			$db_selected = dbSelect(USER_DATABASE); 
			$sql = "SELECT module.name 
					FROM module, profile_account_to_module 
					WHERE module.id = profile_account_to_module.module_id 
					AND profile_account_to_module.profile_account_id = '".$profile_account_id."'";
			$result = mysql_query ($sql);
			if(!$result)die(mysql_error());
			while($row = mysql_fetch_object($result)){
			
				if($row->name == "shopping cart"){
					$this->addStep("category", $profile_account_id);		
					$this->addStep("item", $profile_account_id);		
					$this->addStep("brand", $profile_account_id);					
				}
				
				if($row->name == "custom payment processing"){
					$this->addStep("payment", $profile_account_id);		
					
				}
			}
		}
	}



	function addStep($step ,$profile_account_id){

		$db_selected = dbSelect(USER_DATABASE); 		

		$sql = "SELECT id 
				FROM setup_steps
				WHERE profile_account_id = '".$profile_account_id."'
				AND step = '".$step."'";
		$result = mysql_query ($sql);
		if(!$result)die(mysql_error());
		if(mysql_num_rows($result) < 1){
	
			$sql = "INSERT INTO setup_steps
					(step
					,profile_account_id)
					VALUES
					('".$step."'
					,'".$profile_account_id."')";
			$result = mysql_query ($sql);
			if(!$result)die(mysql_error());
		}
	}

	function completeStep($step ,$profile_account_id){

		$db_selected = dbSelect(USER_DATABASE); 		

		$sql = "UPDATE setup_steps
				SET completed = '1' 
				WHERE step = '".$step."'
				AND profile_account_id = '".$profile_account_id."'
				";
		$result = mysql_query ($sql);
		if(!$result)die(mysql_error());
		
	}

	function getNumCompletedSteps($profile_account_id){

		$db_selected = dbSelect(USER_DATABASE); 		
		$sql = "SELECT id 
				FROM setup_steps
				WHERE profile_account_id = '".$profile_account_id."'
				AND completed = '1'";
		$result = mysql_query ($sql);
		if(!$result)die(mysql_error());
		
		return mysql_num_rows($result);

	}

	function getNumInCompleteSteps($profile_account_id){

		$db_selected = dbSelect(USER_DATABASE); 		
		$sql = "SELECT id 
				FROM setup_steps
				WHERE profile_account_id = '".$profile_account_id."'
				AND completed = '0'";
		$result = mysql_query ($sql);
		if(!$result)die(mysql_error());
		
		return mysql_num_rows($result);

	}



	function getNumRequiredSteps($profile_account_id){

		$db_selected = dbSelect(USER_DATABASE); 		
		$sql = "SELECT id 
				FROM setup_steps
				WHERE profile_account_id = '".$profile_account_id."'";
		$result = mysql_query ($sql);
		if(!$result)die(mysql_error());
		
		return mysql_num_rows($result);

	}


	function setupComplete($profile_account_id){
		
		$ret = 1;
		if($this->getNumInCompleteSteps($profile_account_id) > 0){
			$ret = 0;
		}
		
		return $ret;
	}



}


?>