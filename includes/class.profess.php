<?php
class Professional {


	function __construct()
	{

	}
	
	function getProfName($profile_id){
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$ret = '';
		$sql = "SELECT name						
				FROM profile  
	 			WHERE id = '".$profile_id."'";		
		$result = $dbCustom->getResult($db,$sql);			
		if($result->num_rows){
			$object = $result->fetch_object();
			$ret = $object->name;
			
		}
		return $ret;
		
	}
	
	function getProfImg($profile_id){
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$ret = '';
		$active = 1;
		

		$sql = sprintf("SELECT image.file_name						
				FROM profile_to_img, image  
	 			WHERE image.id = profile_to_img.img_id
				AND profile_to_img.active = '%u'
				AND profile_to_img.profile_id = '%u'", 
				$active, $profile_id);		

		$sql = "SELECT image.file_name						
				FROM profile_to_img, image  
	 			WHERE image.id = profile_to_img.img_id
				AND profile_to_img.profile_id = '".$profile_id."'";
		
		$result = $dbCustom->getResult($db,$sql);			
		if($result->num_rows){
			$object = $result->fetch_object();
			$ret = $object->file_name;	
		}
		return $ret;
	}
			
	function getProfessBasicData($profile_id)
	{
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$ret_array['name'] = '';
		$ret_array['profession'] = '';
		$ret_array['img_file_name'] = '';			
				
		$sql = sprintf("SELECT name
						,profession
				FROM profile 
	 			WHERE id = '%u'", $profile_id);		
		$result = $dbCustom->getResult($db,$sql);			
		
		if($result->num_rows){
			$object = $result->fetch_object();
			
			$ret_array['name'] = $object->name;
			$ret_array['profession'] = $object->profession;
			$ret_array['img_file_name'] = $this->getProfImg($profile_id);
		}
		
		
		return 	$ret_array;	
		
	}

	function getProfessFullData($profile_id)
	{
		
		
		
		
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$ret_array['name'] = '';
		$ret_array['profession'] = '';
		$ret_array['img_file_name'] = '';			
		$ret_array['bio'] = '';
		$ret_array['company'] = '';
		$ret_array['website'] = '';
		$ret_array['address_one'] = '';
		$ret_array['address_two'] = '';
		$ret_array['city'] = '';
		$ret_array['state'] = '';
		
		$ret_array['public_email'] = '';
		$ret_array['twitter'] = '';
		$ret_array['facebook'] = '';
		
		
		$sql = sprintf("SELECT name
						,profession
						,bio 
						,company
						,website
						,address_one
						,address_two
						,city
						,state
						,public_email
						,twitter
						,facebook			
				FROM profile 
	 			WHERE id = '%u'", $profile_id);		
		$result = $dbCustom->getResult($db,$sql);			
		if($result->num_rows){
			$object = $result->fetch_object();
			$ret_array['name'] = $object->name;
			$ret_array['profession'] = $object->profession;
			$ret_array['img_file_name'] = $this->getProfImg($profile_id);
			$ret_array['bio'] = $object->bio;
			$ret_array['company'] = $object->company;
			$ret_array['website'] = $object->website;
			$ret_array['address_one'] = $object->address_one;
			$ret_array['address_two'] = $object->address_two;
			$ret_array['city'] = $object->city;
			$ret_array['state'] = $object->state;			
			$ret_array['public_email'] = $object->public_email;
			$ret_array['twitter'] = $object->twitter;
			$ret_array['facebook'] = $object->facebook;
			
		}
		
		return 	$ret_array;	
	}

	function getProfessSkills($profile_id)
	{
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		
		$ret_array = array();
		
		$i = 0;
		
		$sql = sprintf("SELECT skill.name									
				FROM skill, profile_to_skill 
	 			WHERE skill.id = profile_to_skill.skill_id				
				AND profile_id = '%u'", $profile_id);		
		$result = $dbCustom->getResult($db,$sql);			
		while($row = $result->fetch_object()){		
			$ret_array[$i]['name'] = $row->name;
			$i++;
		}
		
		return 	$ret_array;	
	}
		
	function getAllMembers($actives_only = 1)
	{
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$retArray = array();
		$sql = "SELECT id, name, profession, public_email
				FROM profile";
		if($actives_only > 0){
			$sql .= " WHERE active > 0";
		}	
				
		$result = $dbCustom->getResult($db,$sql);
		$i = 0;
		while($row = $result->fetch_object()){
			$retArray[$i]['id'] = $row->id;
			$retArray[$i]['name'] = $row->name;
			$retArray[$i]['profession'] = $row->profession;
			$retArray[$i]['public_email'] = $row->public_email;
			
			
			$i++;	
		}
		
		return $retArray;
	}


	function profIsActive($id)
	{
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$sql = sprintf("SELECT active
					FROM profile 
	 				WHERE id = '%u'", $id);
		$result = $dbCustom->getResult($db,$sql);
		
		if($result->num_rows > 0){
			$object = $result->fetch_object();
			
			return $object->active;
			 	
		}
		return 0;
	}


	function setProfIsActive($id, $active)
	{
		
		//echo "id: ".$id;
		//echo "<br />";
		//echo "active: ".$active;
		//echo "<br />";
		//exit;
		
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$sql = sprintf("UPDATE profile
						SET active = '%u' 
	 					WHERE id = '%u'", $active, $id);
		$result = $dbCustom->getResult($db,$sql);
	}
	
	
}

?>