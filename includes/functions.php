<?php


function has_add_to_cart_btn($has_sc_module, $call_for_pricing, $price, $ship_type, $weight, $is_free_shipping, $show_atc_btn_or_cfp){
	
	if($has_sc_module  
		&& !$call_for_pricing 
		&& $price > 0
		&& ((!($ship_type == 'carrier' && $weight == 0)) || $is_free_shipping)
		&& $show_atc_btn_or_cfp > 0){
							
		$has_add_btn = 1;
	
	}else{
		$has_add_btn = 0;	
	}
		
	return $has_add_btn;
}


function is_valid_email($email){
	
	$ret = 1;
		
	if(strpos($email, '@') === false){
		$ret = 0;
	}
	
	if(strpos($email, '.') === false){
		$ret = 0;
	}
	
	if(strlen($email) < 8){
		$ret = 0;
	}

	return $ret;

}



function getOS() { 

	$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

    $os_platform    =   "Unknown OS Platform";
	$os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );
						
	foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}




function getBrowser() {

	$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}

function getWordFromDigit($digit){
		
	switch ($digit) {
		case 0:
			$ret = 'zero';
			break;
		case 1:
			$ret = 'one';
			break;
		case 2:
			$ret = 'two';
			break;
		case 3:
			$ret = 'three';
			break;
		case 4:
			$ret = 'four';
			break;
		case 5:
			$ret = 'five';
			break;
		case 6:
			$ret = 'six';
			break;
		case 7:
			$ret = 'seven';
			break;
		case 8:
			$ret = 'eight';
			break;
		case 9:
			$ret = 'nine';
			break;
		default:
		   $ret = 'ten';
	}					
	
	return $ret;
}



function getCityStateFromZip($zip) {
	
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zip."&sensor=true";

	$address_info = file_get_contents($url);
    $json = json_decode($address_info);
    $city = '';
    $state = '';
    $country = '';
	$multi_cities = '';
    
	if (count($json->results) > 0) {

        $arrComponents = $json->results[0]->address_components;

        foreach($arrComponents as $index=>$component) {
            
			$type = $component->types[0];
			if ($city == "" && ($type == "locality" || $type == "neighborhood")){
                $city = trim($component->short_name);
				//echo $city;
            }
            if ($state == "" && $type=="administrative_area_level_1") {
                $state = trim($component->short_name);
				//echo $state;
            }
			if ($country == "" && $type=="country") {
                $country = trim($component->short_name);
				//echo $country;
            }
			if ($city != '' && $state != '' && $country != '') {
                break;
            }
        }
		
		if(isset($json->results[0]->postcode_localities)){
		
			$arr_multi_cities = $json->results[0]->postcode_localities;
			
			if(is_array($arr_multi_cities)){
				
				if(count($arr_multi_cities) > 1){
					
					$i = 0;
					foreach($arr_multi_cities as $val){
						
						
						if($i == 0){
							$multi_cities .= $val.' ';
						}else{
							$multi_cities .= ', '.$val;			
						}
						$i++;
					}
					
				}
				
			}
		
		}
		
    }
	
    $arrReturn = array("city"=>$city."   ".$zip, "state"=>$state, "country"=>$country, "multi_cities"=>$multi_cities);

	return $arrReturn;
}
	



function deleteDir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir"){ 
		 	deleteDir($dir."/".$object); 
		 }else{ 
		 	unlink($dir."/".$object);
		 }
	   }
     }
     reset($objects);
     rmdir($dir);
   }
} 


function arraySort2d (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}

// for multi dem arrays
function multi_unique($array) {
		
	$new = array();
	$new1 = array();	
	
	if(is_array($array)){
		//if(sizeof($array) > 1){	
		foreach ($array as $k=>$na) $new[$k] = serialize($na);
					
		$uniq = array_unique($new);
				
		foreach($uniq as $k=>$ser) $new1[$k] = unserialize($ser);
				
		return ($new1);
		
	}else{
		return $new;	
	}
}

function inArray($v, $array, $indx_name = ''){
	$ret = 0;
	
	if(is_array($array)){
		foreach($array as $value){
			if($indx_name == ''){
				if($value == $v) $ret = 1;
			}else{
				if(isset($value[$indx_name])){
					if($value[$indx_name] == $v) $ret = 1;
				}
			}
		}
	}
	
	return $ret;
	
}

function multi_in_array($value, $array) 
{ 
    foreach ($array AS $item) 
    { 
        if (!is_array($item)) 
        { 
            if ($item == $value) 
            { 
                return true; 
            } 
            continue; 
        } 

        if (in_array($value, $item)) 
        { 
            return true; 
        } 
        else if (multi_in_array($value, $item)) 
        { 
            return true; 
        } 
    } 
    return false; 
} 



function get_logo() {
	
	return "saascustuploads/logo/logo.jpg";


/*
	if(!isset($_SESSION["logo_file_name"])){
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(SITE_DATABASE);
		
		$sql = "SELECT max(logo_id), image.file_name 
			FROM logo, image
			WHERE logo.img_id = image.img_id  
			AND active = '1'
			AND logo.profile_account_id = '".$_SESSION['profile_account_id']."'
			GROUP BY file_name";


		$result = $dbCustom->getResult($db,$sql);
		if($result->num_rows > 0){
			$object = $result->fetch_object();
			$_SESSION['logo_file_name'] = $object->file_name;	
		}else{
			$_SESSION['logo_file_name'] = '';	
		}	
	}
	
	
	return $_SESSION['logo_file_name'];

*/	
		
}


function getUrlText($str)
{
	$t = trim($str);
	$t = str_replace (" " ,"-" ,$t);
	
	if(substr($t,0) == '-'){
		$t = substr($t,1);	
	}
		
	$t = str_replace ("/" ,"-" ,$t);
	$t = preg_replace( '/[^a-zA-Z0-9-]+/', '', $t );	
	$t = str_replace ("--" ,"-" ,$t);
	return strtolower($t); 
}


function stripAllSlashes($str){
	while(!(strpos($str, "\\")  === false)){
		$str = stripslashes($str);
	}
	return $str;
}


function usort_sorter($a, $b){
	if ($a['child_count'] == $b['child_count']) {
		return 0;
	}
	return ($a['child_count'] < $b['child_count']) ? 1 : -1;
}


function getRatingClass($numeric_rating = 5, $star_size = ''){
	
	if($star_size == 'small'){
		$size_part = '_small';
	}else{
		$size_part = '';
	}
	
	if(floor($numeric_rating) - $numeric_rating < 0){	
		$half_part = '_half';
	}else{
		$half_part = '';
	}

	$rating_class = 'star_rating'.$size_part.$half_part;
	
	if($numeric_rating <= 1){
		$rating_class = 'star_rating'.$size_part.' one-star';
	}elseif($numeric_rating >= 1 &&  $numeric_rating < 2){
		$rating_class .= ' one-star';
	}elseif($numeric_rating >= 2 &&  $numeric_rating < 3){
		$rating_class .= ' two-star';
	}elseif($numeric_rating >= 3 &&  $numeric_rating < 4){
		$rating_class .= ' three-star';
	}elseif($numeric_rating >= 4 &&  $numeric_rating < 5){
		$rating_class .= ' four-star';
	}else{
		$rating_class .= ' five-star';
	}
	
	return $rating_class;
}



function is_answered($question_id){
	
	$dbCustom = new DbCustom();
	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);							
	
	$ret = 0;
	
	$sql = "SELECT id 
			FROM answer
			WHERE question_id = '".$question_id."'";
	$result = $dbCustom->getResult($db,$sql);
	
	if($result->num_rows > 0){
		$object = $result->fetch_object(); 
	
		$ret = 1;
	}
	
	return $ret;
	
	
}

function getProfStatesArray($dbCustom){

	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
	$i = 0;		
	$states_array = array();
	$i = 0;	
	$sql = "SELECT DISTINCT state 
			FROM profile";
	$result = $dbCustom->getResult($db,$sql);
	while($row = $result->fetch_object()){
		$states_array[$i]['state'] = $row->state;
		$i++;
		
	}
	return $states_array;
	
}

function getCatsArray($dbCustom){

	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
	$i = 0;		
	$cat_array = array();
	$i = 0;	
	$sql = "SELECT id, name 
			FROM category";
	
	$result = $dbCustom->getResult($db,$sql);
	while($row = $result->fetch_object()){
		
		$cat_array[$i]['id'] = $row->id;
		$cat_array[$i]['name'] = $row->name;
		$i++;
		
	}
	return $cat_array;
	
}
						
function getCategoryName($category_id){

	$dbCustom = new DbCustom();
	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);							
	
	$ret = '';
	
	$sql = "SELECT name 
			FROM category
			WHERE id = '".$category_id."'";
	$result = $dbCustom->getResult($db,$sql);
	
	if($result->num_rows > 0){
		$object = $result->fetch_object(); 
	
		$ret =	$object->name;
	}
	
	return $ret;
}

function getQaBlockHTML($dbCustom, $prof, $fullanswerid = 0, $cat = ''){

	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
			
	$qa_array = array();
	$i = 0;
	if(strlen($cat) > 1){
	
		$likeVar = "%".$cat."%";
	
		$stmt = $db->prepare("SELECT question.id as question_id 
								,question.question 
								,answer.id as answer_id
								,answer.answer
								,answer.answered_by_profile_id 
						FROM question, answer
						WHERE question.id = answer.question_id 
						AND question.question LIKE ?
						ORDER BY q_date DESC");
		
		if(!$stmt->bind_param("s",$likeVar)){
			//echo 'Error '.$db->error;
		}else{
			$stmt->execute();
			$stmt->bind_result($question_id, $question, $answer, $answered_by_profile_id);
			
			while ($stmt->fetch()) {
				$qa_array[$i]['question_id'] = $question_id;
				$qa_array[$i]['answer_id'] = $answer_id;
				$qa_array[$i]['question'] = $question;
				$qa_array[$i]['answer'] = $answer;
				$qa_array[$i]['answered_by_profile_id'] = $answered_by_profile_id;
				$i++;
			}
					
			$stmt->close();
		}
	}else{

		$sql = "SELECT question.id as question_id 
					,question.question 
					,answer.id as answer_id
					,answer.answer
					,answer.answered_by_profile_id 
			FROM question, answer
			WHERE question.id = answer.question_id			
			ORDER BY q_date DESC";
		$result = $dbCustom->getResult($db,$sql);
		
		while($row = $result->fetch_object()){
			$qa_array[$i]['question_id'] = $row->question_id;
			$qa_array[$i]['question'] = $row->question;
			$qa_array[$i]['answer_id'] = $row->answer_id;
			$qa_array[$i]['answer'] = $row->answer;
			$qa_array[$i]['answered_by_profile_id'] = $row->answered_by_profile_id;
			$i++;
		}
		
	}
	
	
	$qa_block = "";
	$question_id = 0;	
	foreach($qa_array as $v){
			
		$prof_array = $prof->getProfessBasicData($v['answered_by_profile_id']);
		
		if(strlen($prof_array['img_file_name']) < 4){
			$prof_img = SITEROOT."/img/noprofile.jpg"; 	
		}else{
			$prof_img = SITEROOT."/saascustuploads/1/profile/".$v['answered_by_profile_id']."/round/".$prof_array['img_file_name'];
		}
		
		if($question_id != $v['question_id']){
			
			$qa_block .= "<div class='large_col_avatar_ask_container'>
						<div class='large_col_avatar_ask_img_box'>
							<img src='".SITEROOT."/img/avatar.png' />            
							<img src='".SITEROOT."/img/med_icon_question.png' class='large_col_avatar_img_q'  />
						</div>
						<div class='large_col_avatar_ask_text'>
							".$v['question']."
						</div>
						<div class='clear'></div>
					</div>";
		}
				
	
		$this_page = $_SERVER['PHP_SELF']."?fullanswerid=".$v['answer_id']."#fullanswer_".$v['answer_id'];
		
		if($fullanswerid == $v['answer_id']){
			$answer = $v['answer'];
		}else{
			$answer = substr($v['answer'] ,0,100);
			if(strlen($answer) > 100){
				$answer .= "...";
			}
		}
		
			
		$qa_block .= "<div class='large_col_prof_answ_container'>  
						<div class='large_col_prof_answ_img_box'>
							<a href='profile.php?profile_id=".$v['answered_by_profile_id']."'>
							<img src='".$prof_img."' />
							</a>
						</div>
						<div class='large_col_prof_answ'> 
							<div class='large_col_prof_answ_name'>
								".$prof_array['name'].",                    
							</div>
							<div class='large_col_prof_answ_job'>
								".$prof_array['profession']."
							</div>
							<div class='clear'></div>
							<div id='fullanswer_".$v['answer_id']."' class='large_col_prof_answ_text'>
								".$answer."
							</div>
						</div>  
						<div class='clear'></div>
						<div class='large_col_prof_answ_more'>
							<a href='".$this_page."' >Read Full Answer</a>
						</div>
						<hr />
					</div>
				";
		
		$question_id = $v['question_id'];	
	}
	
	return $qa_block;	
	
}

/*
function getProfQaBlockHTML($dbCustom, $prof, $profile_id, $fullanswerid = 0, $cat = ''){

	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
			
	$qa_array = array();
	$i = 0;
	if(strlen($cat) > 1){
	
		$likeVar = "%".$cat."%";
	
		$stmt = $db->prepare("SELECT question.id as question_id 
								,question.question 
								,answer.id as answer_id
								,answer.answer
								,answer.answered_by_profile_id 
						FROM question, answer
						WHERE question.id = answer.question_id 
						AND answer.answered_by_profile_id = ?
						AND prof_profile_id = ?
						AND question.question LIKE ?
						ORDER BY q_date DESC");
		
		if(!$stmt->bind_param("iis",$_SESSION['profile_account_id'], $profile_id, $likeVar)){
			//echo 'Error '.$db->error;
		}else{
			$stmt->execute();
			$stmt->bind_result($question_id, $question, $answer, $answered_by_profile_id);
			
			while ($stmt->fetch()) {
				$qa_array[$i]['question_id'] = $question_id;
				$qa_array[$i]['answer_id'] = $answer_id;
				$qa_array[$i]['question'] = $question;
				$qa_array[$i]['answer'] = $answer;
				$qa_array[$i]['answered_by_profile_id'] = $answered_by_profile_id;
				$i++;
			}
					
			$stmt->close();
		}
	}else{
		
		$sql = sprintf("SELECT question.id as question_id 
					,question.question 
					,answer.id as answer_id
					,answer.answer
					,answer.answered_by_profile_id 
			FROM question, answer
			WHERE question.id = answer.question_id
			AND answer.answered_by_profile_id = '%u'
			AND question.profile_account_id = '%u'
			ORDER BY q_date DESC",
		$profile_id,$_SESSION['profile_account_id']);

		$result = $dbCustom->getResult($db,$sql);
		
		while($row = $result->fetch_object()){
			$qa_array[$i]['question_id'] = $row->question_id;
			$qa_array[$i]['question'] = $row->question;
			$qa_array[$i]['answer_id'] = $row->answer_id;
			$qa_array[$i]['answer'] = $row->answer;
			$qa_array[$i]['answered_by_profile_id'] = $row->answered_by_profile_id;
			$i++;
		}
		
	}
	
	
	$qa_block = "";
	$question_id = 0;	
	foreach($qa_array as $v){
			
		$prof_array = $prof->getProfessBasicData($v['answered_by_profile_id']);
		
		if(strlen($prof_array['img_file_name']) < 4){
			$prof_img = "../img/noprofile.jpg"; 	
		}else{
			$prof_img = "../saascustuploads/1/profile/".$v['answered_by_profile_id']."/round/".$prof_array['img_file_name'];
		}
		
		if($question_id != $v['question_id']){
			
			$qa_block .= "<div class='large_col_avatar_ask_container'>
						<div class='large_col_avatar_ask_img_box'>
							<img src='".SITEROOT."/img/avatar.png' />            
							<img src='".SITEROOT."/img/med_icon_question.png' class='large_col_avatar_img_q'  />
						</div>
						<div class='large_col_avatar_ask_text'>
							".$v['question']."
						</div>
						<div class='clear'></div>
					</div>";
		}
				
	
		$this_page = $_SERVER['PHP_SELF']."?profile_id=".$profile_id."&fullanswerid=".$v['answer_id']."#fullanswer_".$v['answer_id'];
		
		if($fullanswerid == $v['answer_id']){
			$answer = $v['answer'];
		}else{
			$answer = substr($v['answer'] ,0,100);
			if(strlen($answer) > 100){
				$answer .= "...";
			}
		}
		
			
		$qa_block .= "<div class='large_col_prof_answ_container'>  
						<div class='large_col_prof_answ_img_box'>
							<img src='".$prof_img."' />
						</div>
						<div class='large_col_prof_answ'> 
							<div class='large_col_prof_answ_name'>
								".$prof_array['name'].",                    
							</div>
							<div class='large_col_prof_answ_job'>
								".$prof_array['profession']."
							</div>
							<div class='clear'></div>
							<div id='fullanswer_".$v['answer_id']."' class='large_col_prof_answ_text'>
								".$answer."
							</div>
						</div>  
						<div class='clear'></div>
						<div class='large_col_prof_answ_more'>
							<a href='".$this_page."' >Read Full Answer</a>
						</div>
						<hr />
					</div>
				";
		
		$question_id = $v['question_id'];	
	}
	
	return $qa_block;	
	
}


function getQaBlockReact($dbCustom, $prof, $fullanswerid = 0, $cat = ''){

	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
			
	$qa_array = array();
	$i = 0;
	if(strlen($cat) > 1){
	
		$likeVar = "%".$cat."%";
	
		$stmt = $db->prepare("SELECT question.id as question_id 
								,question.question 
								,answer.id as answer_id
								,answer.answer
								,answer.answered_by_profile_id 
						FROM question, answer
						WHERE question.id = answer.question_id 
						AND question.profile_account_id = ?
						AND question.question LIKE ?
						ORDER BY id
						");
		
		if(!$stmt->bind_param("is",$_SESSION['profile_account_id'], $likeVar)){
			//echo 'Error '.$db->error;
		}else{
			$stmt->execute();
			$stmt->bind_result($question_id, $question, $answer, $answered_by_profile_id);
			
			while ($stmt->fetch()) {
				$qa_array[$i]['question_id'] = $question_id;
				$qa_array[$i]['answer_id'] = $answer_id;
				$qa_array[$i]['question'] = $question;
				$qa_array[$i]['answer'] = $answer;
				$qa_array[$i]['answered_by_profile_id'] = $answered_by_profile_id;
				$i++;
			}
					
			$stmt->close();
		}
	}else{
	
		$sql = "SELECT question.id as question_id 
					,question.question 
					,answer.id as answer_id
					,answer.answer
					,answer.answered_by_profile_id 
			FROM question, answer
			WHERE question.id = answer.question_id 
			AND question.profile_account_id = '".$_SESSION['profile_account_id']."'";
		$result = $dbCustom->getResult($db,$sql);
		
		while($row = $result->fetch_object()){
			$qa_array[$i]['question_id'] = $row->question_id;
			$qa_array[$i]['question'] = $row->question;
			$qa_array[$i]['answer_id'] = $row->answer_id;
			$qa_array[$i]['answer'] = $row->answer;
			$qa_array[$i]['answered_by_profile_id'] = $row->answered_by_profile_id;
			$i++;
			
			if($i > 0) break;
		}
		
	}
	
	$i = 0;
	$qa_block = "";
	$question_id = 0;	
	foreach($qa_array as $v){
			
		$prof_array = $prof->getProfessBasicData($v['answered_by_profile_id']);

		if(strlen($prof_array['img_file_name']) < 4){
			$prof_img = "img/noprofile.jpg"; 	
		}else{
			$prof_img = "saascustuploads/1/profile/".$v['answered_by_profile_id']."/round/".$prof_array['img_file_name'];
		}

		if($fullanswerid == $v['answer_id']){
			$answer = $v['answer'];
		}else{
			$answer = substr($v['answer'] ,0,100);
			if(strlen($answer) > 100){
				$answer .= "...";
			}
		}
		
		$answer = "";

		
		if($question_id != $v['question_id']){
			
			$qa_block .= 'React.createElement(
							"div",
							{ className: "large_col_avatar_ask_container" },
							React.createElement(
								"div",
								{ className: "large_col_avatar_ask_img_box" },
								React.createElement("img", { src: "img/avatar.png" }),
								React.createElement("img", { src: "img/med_icon_question.png", className: "large_col_avatar_img_q" })
							),
							React.createElement(
								"div",
								{ className: "large_col_avatar_ask_text" },
								"'.$v['question'].'"
							),
							React.createElement("div", { className: "clear" })
						),';

		}
			
		$qa_block .= 'React.createElement(
						"div",
						{ className: "large_col_prof_answ_container" },
						React.createElement(
							"div",
							{ className: "large_col_prof_answ_img_box" },
							React.createElement("img", { src: "'.$prof_img.'" })
						),
						React.createElement(
							"div",
							{ className: "large_col_prof_answ" },
							React.createElement(
								"div",
								{ className: "large_col_prof_answ_name" },
								"'.$prof_array['name'].'"
							),
							React.createElement(
								"div",
								{ className: "large_col_prof_answ_job" },
								"'.$prof_array['profession'].'"
							),
							React.createElement("div", { className: "clear" }),
							React.createElement(
								"div",
								{ className: "large_col_prof_answ_text" },
								"'.$answer.'"
							)
						),
						React.createElement("div", { className: "clear" }),
						React.createElement(
							"div",
							{ className: "large_col_prof_answ_more" },
							"_Read Full Answere_"
						),
						React.createElement("hr", null)
					)';
				
			if($i < sizeof($qa_array)){
				$qa_block .= ',';
			}
			$i++;


		
		$question_id = $v['question_id'];	
	}
	
	return $qa_block;	
	
}


function getArticleBlockHTML($dbCustom, $prof, $article_page = ''){

	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
			
	$art_array = array();
	$i = 0;
	
	if(strlen($article_page) < 4){		
		$article_page = $_SERVER['REQUEST_URI'];
	}
	
	$sql = "SELECT id
				,category_id 
				,title
				,sub_heading
				,category_id
				,content
				,type
				,posted_by_profile_id 
			FROM article
			WHERE profile_account_id = '".$_SESSION['profile_account_id']."'"; 

	$result = $dbCustom->getResult($db,$sql);
		
	while($row = $result->fetch_object()){
		
		$art_array[$i]['id'] = $row->id;
		$art_array[$i]['title'] = $row->title;
		$art_array[$i]['content'] = $row->content;
		$art_array[$i]['posted_by_profile_id'] = $row->posted_by_profile_id;
		$prof_array = $prof->getProfessBasicData($row->posted_by_profile_id);
		
		$art_array[$i]['img_file_name'] = $prof_array['img_file_name'];
		
		$sub_title = '';
		if(strlen($row->sub_heading) > 0){				
			$sub_title = $row->sub_heading;
		}else{
			if(strlen($prof_array['name']) > 0){
				$sub_title = "By ".$prof_array['name'];					
			}
			if($row->category_id > 0){
				$sub_title .= ' in '.getCategoryName($row->category_id);
			}								
		}
		
		$sub_title = trim($sub_title);
					
		if(strlen($sub_title) < 1){				
			$sub_title = substr($row->content, 0 ,80);				
		}
		
		$art_array[$i]['sub_title'] = $sub_title; 	
		
		$i++;
	}
		
	
	
	$art_block = "";	
	foreach($art_array as $v){
			
		
		$url_str = $article_page.'?article_id='.$v['id'];
		
		$art_block .= "<a class='body_link' href='".$url_str."'><div class='small_article_img_box'>
			<img class='prof_img_small' src='".SITEROOT."/saascustuploads/1/profile/".$v['posted_by_profile_id']."/round/".$v['img_file_name']."' />
			</div>
			<div class='small_article_article'>
				<div class='small_article_heading'>
					".$v['title']."
				</div>
				<div class='small_article_text'>
				".$v['sub_title']."
				</div> 
			</div>
			<div class='clear'></div></a>
			<hr />";
		
	}
	
	return $art_block;	
	
}


function getArticleBlockReact($dbCustom, $prof, $article_page = ''){

	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
			
	$art_array = array();
	$i = 0;
	
	$sql = "SELECT id
				,category_id 
				,title
				,sub_heading
				,category_id
				,content
				,type
				,posted_by_profile_id 
			FROM article
			WHERE profile_account_id = '".$_SESSION['profile_account_id']."'"; 

	$result = $dbCustom->getResult($db,$sql);
		
	while($row = $result->fetch_object()){
		
		$art_array[$i]['id'] = $row->id;
		$art_array[$i]['title'] = $row->title;
		$art_array[$i]['content'] = $row->content;
		$art_array[$i]['posted_by_profile_id'] = $row->posted_by_profile_id;
		$prof_array = $prof->getProfessBasicData($row->posted_by_profile_id);
		
		$art_array[$i]['img_file_name'] = $prof_array['img_file_name'];
		
		$sub_title = '';
		if(strlen($row->sub_heading) > 0){				
			$sub_title = $row->sub_heading;
		}else{
			if(strlen($prof_array['name']) > 0){
				$sub_title = "By ".$prof_array['name'];					
			}
			if($row->category_id > 0){
				$sub_title .= ' in '.getCategoryName($row->category_id);
			}								
		}
		
		$sub_title = trim($sub_title);
					
		if(strlen($sub_title) < 1){				
			$sub_title = substr($row->content, 0 ,80);				
		}
		
		$art_array[$i]['sub_title'] = $sub_title; 	
		
		$i++;
	}
	
	$i = 0;
	$art_block = "";	
	foreach($art_array as $v){
					
		$art_block .= 'React.createElement(
				"div",
				{ className: "small_article_img_box" },
				React.createElement("img", { className: "prof_img_small", src: "saascustuploads/'.$_SESSION['profile_account_id'].'/profile/'.$v['posted_by_profile_id'].'/round/'.$v['img_file_name'].'" })
			),
			React.createElement(
				"div",
				{ className: "small_article_article" },
				React.createElement(
					"div",
					{ className: "small_article_heading" },
					"'.$v['title'].'"
				),
				React.createElement(
					"div",
					{ className: "small_article_text" },
					"'.$v['sub_title'].'"
				)
			),
			React.createElement("div", { className: "clear" }),
			React.createElement("hr", null)';
		
		if($i < sizeof($art_block)){
			$art_block .= ',';
		}
		$i++;
	}
	
	return $art_block;	
	
}



function getFullArticleHTML($dbCustom, $article_id, $prof){
	
	$ret_array = array();
	
	if($article_id > 0){
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
			
		$stmt = $db->prepare("SELECT content
								,title
								,sub_heading
								,category_id
								,posted_by_profile_id 
							FROM article
							WHERE id = ? 
							AND profile_account_id = ?");
	
			
		if(!$stmt->bind_param("ii", $article_id, $_SESSION['profile_account_id'])){
			//echo 'Error '.$db->error;
		}else{
			$stmt->execute();
			$stmt->bind_result($content, $title, $category_id, $sub_heading, $posted_by_profile_id);
				
			$stmt->fetch();
			
			$prof_array = $prof->getProfessBasicData($posted_by_profile_id);
			
			$ret_array['name'] = $prof_array['name'];
			$ret_array['profession'] = $prof_array['profession'];
			$ret_array['img_file_name'] = $prof_array['img_file_name'];					
			$ret_array['posted_by_profile_id'] = $posted_by_profile_id;
			$ret_array['title'] = stripslashes(trim($title));
			
			$sub_title = '';
			
			if(strlen($sub_heading) > 0){				
				$sub_title .= $sub_heading;
			}else{
				if(strlen($prof_array['name']) > 0){
					$sub_title .= "By ".$prof_array['name'];					
				}
				if($category_id > 0){
					$sub_title .= ' in '.getCategoryName($category_id);
				}								
			}			
			
			$ret_array['sub_title'] = $sub_title; 	
			
			$ret_array['content'] = stripslashes(trim($content));	
						
			$stmt->close();
		}
	}
	return $ret_array;
	
}


function getFindProfBlockHTML($dbCustom, $prof, $state = '', $cat = ''){


	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		
	$find_prof_block = '';
	
	// Do Prepared Statment
	
	
	$sql = "SELECT id
				,name 
				,company
				,city
				,state
				,about
				,profession
			FROM profile
			WHERE user_type_id = '2'
			AND active = '1' 
			"; 
			
	if(strlen($state) > 2){
		$sql .= " AND state = '".$state."'";
	}
			
	$result = $dbCustom->getResult($db,$sql);
		
	while($row = $result->fetch_object()){
		
		$location = '';
		$has_city = 0;
		
		if(strlen($row->city) > 1){
			$location .= $row->city;
			$has_city = 1;
		}
		if(strlen($row->state > 1)){
			if($has_city){
				$location .= ', ';
			}
			$location .= $row->state;	
		}
		
		$prof_array = $prof->getProfessBasicData($row->id);
		
		$prof_img = "<img src='".SITEROOT."/saascustuploads/1/profile/".$row->id."/round/".$prof_array['img_file_name']."' />";
		
		$company = '';
		if(strlen($row->company) > 2){
			$company .= $row->company.'<br />';
		}
		
		$mission = substr($row->about,0,60);
		$mission .= '...';
		
		$find_prof_block .= "<div class='find_prof_container'>      	
                    <div class='find_prof_img_box'>
                    	<a href='profile.php'>
						".$prof_img."
                        </a>
                    </div>					
					<div class='find_profile_name'>
						".$row->name."
                    </div>
                    <div class='find_profile_local'>
							".$company."
							".$location."
                    </div>
                    <div class='find_profile_right_upper'>
                        <div class='find_prof_star'>
                            <img class='find_prof_star_img' src='".SITEROOT."/img/star_sq.png' />
                            <div class='find_prof_star_val'>	
                                8.2
                            </div>
                            <div class='clear'></div>
                            <div class='find_prof_star_v_small'>
                            	61 ratings
                            </div>
                        </div> 
                        <div class='find_prof_eq'>                           
                            <img class='find_prof_eq_img' src='".SITEROOT."/img/eq_sq.png' />
                            <div class='find_prof_eq_val'>	
                                94
                            </div> 
                            <div class='clear'></div> 
							<div class='find_prof_eg_v_small'>
                            	Answeres
                            </div>                    
                        </div>
                        <div class='find_prof_edit'>      
                            <img class='find_prof_edit_img' src='".SITEROOT."/img/edit_sq.png' />
                            <div class='find_prof_edit_val'>	
                                67
                            </div>
                            <div class='clear'></div> 
							<div class='find_prof_edit_v_small'>
                            	Articles
                            </div>
                        </div>                           
                    </div>
                    <div class='clear'></div>
                    <div class='find_profile_bottom'>
                        <div class='find_profile_icons_sq'>
                            <img class='find_prof_icon_left' src='".SITEROOT."/img/mail_sq.png' />
                            <img class='find_prof_icon_mid' src='".SITEROOT."/img/t_sq.png' />
                            <img class='find_prof_icon_right' src='".SITEROOT."/img/f_sq.png' />							
                        </div>
                        <div class='find_profile_mission'>
							".$mission."
                        </div>                       
                        
                        <a class='find_prof_list_ask_btn' href='#'>Ask Now</a>
						                        
                    	<div class='clear'></div>
                    </div>          
                    <hr />
				</div>";
	
		
		
	}

	return $find_prof_block;
	
	
}



function getProfSelectReact($dbCustom){

	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
	$i = 0;
	$prof_select_options = '';
	$sql = "SELECT id
				,name
			FROM  profile
			WHERE user_type_id = '2'
			AND active = '1'
			";					
					
	$result = $dbCustom->getResult($db,$sql);
	
	$num_rows = $result->num_rows;
	
	
	$prof_select_options .= 'React.createElement(
		"select",
		{ className: "ask_head_form_select", name: "prof_profile_id", onChange: this.handleChange },';
																				
	$prof_select_options .= 'React.createElement(
						"option",
						{ value: "0" },
						"Any Professional"
					)';
	
	if($num_rows > 0){
		$prof_select_options .= ',';
	}
	while($row = $result->fetch_object()){
				
		$prof_select_options .= 'React.createElement(
						"option",
						{ value: "'.$row->id.'" },
						"'.$row->name.'"
					)';	

		$i++;
		if($i < $num_rows){
			$prof_select_options .= ',';
		}
				
	}
	
	return $prof_select_options;	
	
}

*/

?>
