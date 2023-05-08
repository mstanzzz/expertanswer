<?php

class CustomerLogin {


	function __construct()
	{
		if(!isset($_SESSION['customer_logged_in'])) $_SESSION['customer_logged_in'] = 0;
		if(!isset($_SESSION['user_type'])) $_SESSION['user_type'] = 1;
		if(!isset($_SESSION['username'])) $_SESSION['username'] = '';
		if(!isset($_SESSION['name'])) $_SESSION['name'] = '';
		if(!isset($_SESSION['email'])) $_SESSION['email'] = '';
		if(!isset($_SESSION['profile_id'])) $_SESSION['profile_id'] = 0;

	}
			
	function generateSalt()
	{
		return sha1(uniqid(rand()));
	}

	function get_hash($password, $salt)
	{
		return sha1($password.$salt);
	}
	
	function login_google($username) {
		
		$username = str_replace("\"","",$username);
		$username = str_replace("'","",$username);
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		
		$ret = 0;
		$stmt = $db->prepare("SELECT name, id 
					FROM profile
					WHERE username = ?"); 
			
			echo 'Error 1 '.$db->error;
			
		if(!$stmt->bind_param("s", $username)){
			echo 'Error 2 '.$db->error;
		}else{
			$stmt->execute();
			
			$stmt->bind_result($name, $id);
	
			if($stmt->fetch()){
					
				$ret = 1;
		
				$_SESSION['user_type'] = 2;	
				$_SESSION['customer_logged_in'] = 1;
				$_SESSION['username'] = $username;						
				$_SESSION['name'] = $name;
				$_SESSION['email'] = $username;
				$_SESSION['profile_id'] = $id;
										
			}else{
				$_SESSION['user_type'] = 0;	
				$_SESSION['customer_logged_in'] = 0;
				$_SESSION['username'] = '';						
				$_SESSION['name'] = '';
				$_SESSION['email'] = '';
				$_SESSION['profile_id'] = 0;					
			}
		
			$stmt->close();
		}
		
		return $ret;
	}	
	
	function login($username,$password) {
		$username = str_replace("\"","",$username);
		$username = str_replace("'","",$username);
			
		$password = str_replace("\"","",$password);
		$password = str_replace("'","",$password);

		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		
		$ret = 0;

		$stmt = $db->prepare("SELECT name
					,id 
					,user_type_id
					,password_hash
					,password_salt
					,oauth_provider
					,oauth_uid
					FROM profile
					WHERE username = ?"); 
			
			//echo 'Error 1 '.$db->error;
			
		if(!$stmt->bind_param("s", $username)){
			
			echo 'Error 2 '.$db->error;
			
		}else{
			$stmt->execute();
			
			$stmt->bind_result($name
						,$id
						,$user_type_id
						,$password_hash
						,$password_salt
						,$oauth_provider
						,$oauth_uid);
			
	
			if($stmt->fetch()){
				
				if(strlen($oauth_uid) > 0  && strlen($id) > 0  &&  strlen($oauth_provider)){
					
					$ret = 1;
		
					$_SESSION['user_type'] = $user_type_id;	
					$_SESSION['customer_logged_in'] = 1;
					$_SESSION['username'] = $username;						
					$_SESSION['name'] = $name;
					$_SESSION['email'] = $username;
					$_SESSION['profile_id'] = $id;
					
					
				}elseif($password_hash == $this->get_hash($password, $password_salt)){
					
					$ret = 1;
		
					$_SESSION['user_type'] = $user_type_id;	
					$_SESSION['customer_logged_in'] = 1;
					$_SESSION['username'] = $username;						
					$_SESSION['name'] = $name;
					$_SESSION['email'] = $username;
					$_SESSION['profile_id'] = $id;
				}else{
					$_SESSION['user_type'] = 0;	
					$_SESSION['customer_logged_in'] = 0;
					$_SESSION['username'] = '';						
					$_SESSION['name'] = '';
					$_SESSION['email'] = '';
					$_SESSION['profile_id'] = 0;					
					
					$ret = 0;
				}
			}
		
			$stmt->close();
		
		}
		
		return $ret;
	}


	function getProfileId(){	
		return $_SESSION['profile_id'];			
	}
	

	function getProfileIdByEmail($username){

		$dbCustom = new DbCustom();		
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);	
		
		$ret = 0;
		
		$stmt = $db->prepare("SELECT id
							FROM profile
							WHERE username = ?");		
				
		if(!$stmt->bind_param("s", $username)){
			//echo 'Error '.$db->error;
		}else{
			
			$stmt->execute();
			$stmt->bind_result($id);
			$stmt->fetch();
			if($id != ''){
				$ret = $id;	
			}
			
			$stmt->close();
		}
			
		return $ret;		
	}
	
	
	function getUserTypeByID($user_type_id){

		$dbCustom = new DbCustom();		
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);	
		
		$ret = 0;
		
		$stmt = $db->prepare("SELECT name
							FROM user_type
							WHERE id = ?");		
				
		if(!$stmt->bind_param("i", $user_type_id)){
			//echo 'Error '.$db->error;
		}else{
			
			$stmt->execute();			
			$stmt->bind_result($name);
			$stmt->fetch();
			if($name != ''){
				$ret = $name;	
			}
			$stmt->close();
		}
			
		return $ret;		
					
	}
	
	
	function logOut(){	

		//echo "HHHHHHHHH";
		//exit;
		
		$_SESSION['customer_logged_in'] = 0;
		$_SESSION['profile_id'] = 0;
		$_SESSION['user_type'] = 0;						
		$_SESSION['username'] = '';						
		$_SESSION['name'] = '';
		$_SESSION['email'] = 0;
		
		$_SESSION['oauth_status'] = 0;

	}
	

	function getUserName() {
		$ret = (isset($_SESSION['username'])) ? $_SESSION['username'] : '';	
		if($ret == ''){
			$dbCustom = new DbCustom();
			$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
			$sql = "SELECT username
				FROM profile 
	 			WHERE profile_id = '".$this->getProfileId()."'";
			$result = $dbCustom->getResult($db,$sql);			
			if($result->num_rows){
				$object = $result->fetch_object();
				$_SESSION['username'] = $object->username;
				$ret = $object->username;
			}
		}
		
		return $ret;
	}
	
	
	function getFullName($profile_id = 0) {
		
		if($profile_id == 0){
			$profile_id = $this->getProfileId();
		}
		
		$ret = $_SESSION['name'];
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
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



	function isLogedIn(){
		
		return $_SESSION['customer_logged_in'];	
	}
	
	function varifyPassword($password, $username){
		$ret = 0;
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$sql = "SELECT 
				password_hash
				,password_salt
				FROM profile 
	 			WHERE username = '".$username."'";
		$result = $dbCustom->getResult($db,$sql);		
		if($result->num_rows > 0){
			$object = $result->fetch_object();
			if($object->password_hash == $this->get_hash($password, $object->password_salt)){
				$ret = 1;
			}
		}
		
		return $ret;
	}
	
	function resetPassword($password_new, $username){		
		$password_salt = $this->generateSalt();
		$password_hash = $this->get_hash($password_new, $password_salt);

		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$sql = "UPDATE profile 
				SET password_hash = '".$password_hash."' ,password_salt = '".$password_salt."' 
	 			WHERE username = '".$username."'";
		$result = $dbCustom->getResult($db,$sql);		
		return 1;
	}

	function resetPasswordById($password_new, $profile_id){		
		
		$password_salt = $this->generateSalt();
		$password_hash = $this->get_hash($password_new, $password_salt);

		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$sql = "UPDATE profile 
				SET password_hash = '".$password_hash."' ,password_salt = '".$password_salt."' 
	 			WHERE id = '".$profile_id."'";
		$result = $dbCustom->getResult($db,$sql);		
		return 1;
	}

	
	function getUserType() {
		return $_SESSION['user_type'];
	}


	function isActiveSocialAccount() {
		$ret = 0;
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$sql = "SELECT id 
				FROM profile
				WHERE active = '1' 
				AND id = '".$this->getProfileId()."'";
		$result = $dbCustom->getResult($db,$sql);		
		if($result->num_rows > 0){
			$ret = 1;
		}
		return $ret;
	}


	function create_google_user($username,$name, $oauth_uid = 0){
		
		$username = str_replace("\"","",$username);
		$username = str_replace("'","",$username);
		
		$name = trim(addslashes($name));

		if(!isset($_SESSION['ip'])) $_SESSION['ip'] = 0;

		$dbCustom = new DbCustom();		
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);	
		
		$active = 1;
		$ts = time();
		$user_type_id = 2;		
		$oauth_provider = 'google';
		
		$stmt = $db->prepare("INSERT INTO profile  
								(username
								,name
								,ip
								,oauth_provider
								,oauth_uid							
								,active
								,user_type_id
								,created)
							VALUES
							(?,?,?,?,?,?,?,?)"); 	
														
			//echo 'Error-1 UPDATE   '.$db->error;
			
		if(!$stmt->bind_param("sssssiii", $username
							,$name
							,$_SESSION['ip']
							,$oauth_provider 
							,$oauth_uid
							,$active
							,$user_type_id 
							,$ts)){	
								
			echo 'Error-2 bind_param   '.$db->error;																		
				
		}else{
			$stmt->execute();

			$profile_id = $db->insert_id;

			$_SESSION['user_type'] = 2;	
			$_SESSION['customer_logged_in'] = 1;
			$_SESSION['username'] = $username;										
			$_SESSION['name'] = $name;
			$_SESSION['email'] = $username;
			$_SESSION['profile_id'] = $profile_id;

			$stmt->close();

			return 1;
		}		
			
		return 0;							
	}




	
	function create_user($password,$username,$name){
		
		$username = str_replace("\"","",$username);
		$username = str_replace("'","",$username);
			
		$password = str_replace("\"","",$password);
		$password = str_replace("'","",$password);
		
		$name = trim(addslashes($name));

		if(!isset($_SESSION['ip'])) $_SESSION['ip'] = 0;

		$dbCustom = new DbCustom();		
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);	
		
		$active = 1;
		$ts = time();
		$user_type_id = 2;		

		$stmt = $db->prepare("INSERT INTO profile  
								(username
								,name
								,ip
								,active
								,user_type_id
								,created)
							VALUES
							(?,?,?,?,?,?)"); 	
														
				//echo 'Error-1 UPDATE   '.$db->error;
			
		if(!$stmt->bind_param("sssiii",$username, $name, $_SESSION['ip'], $active, $user_type_id ,$ts)){	
								
				echo 'Error-2 bind_param   '.$db->error;																		
				
		}else{
			$stmt->execute();

			$profile_id = $db->insert_id;

			$this->resetPassword($password, $username);

			$_SESSION['user_type'] = 2;	
			$_SESSION['customer_logged_in'] = 1;
			$_SESSION['username'] = $username;										
			$_SESSION['name'] = $name;
			$_SESSION['email'] = $username;
			$_SESSION['profile_id'] = $profile_id;

			$stmt->close();

			return 1;
		}		

			
		return 0;		
					
	}



	function userNameExisis($username){
		
		$username = str_replace("\"","",$username);
		$username = str_replace("'","",$username);
		
		$username_exists = 0;
		
		$dbCustom = new DbCustom();		
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		
		$stmt = $db->prepare("SELECT id
						FROM profile
						WHERE username = ?"); 
		if(!$stmt->bind_param("s", $username)){			
			//echo 'Error '.$db->error;			
		}else{
			
			$stmt->execute();
			
			if($stmt->fetch()){
				$username_exists = 1;
			}
		}

		return $username_exists;
	}

	
}

?>