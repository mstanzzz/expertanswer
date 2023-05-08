<?php
/*
IN BOOLEAN MODE
https://dev.mysql.com/doc/refman/5.5/en/fulltext-boolean.html




*/

class Search {

	function getWords($search_string)
	{
		$search_string = strtolower($search_string);
		$search_string = preg_replace('/\s\s+/', ' ', $search_string);
		$search_word_array = explode(" " ,$search_string);
		
		$i = 0;
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
	
		foreach($search_word_array as $word){
			$word = trim(addslashes($word));
			
		}
	}
	
	function prepareWords($search_string)
	{
		
		
	}


	function getQuestionData($question_id){
		
		$ret_array = array();
		$ret_array['question'] = '';
		$ret_array['visitor_name'] = ''; 

		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$i = 0;
		
		$sql = "SELECT question, visitor_name  
				FROM question
				WHERE id = '".$question_id."'";	
		$result = $dbCustom->getResult($db,$sql);
		
		if($result->num_rows > 0){
			$object = $result->fetch_object(); 	
			$ret_array['question'] = $object->question;
			$ret_array['visitor_name'] = $object->visitor_name; 
		}
		
		return $ret_array;
	}
	
	
	function getVideos($profile_id){
		
		$ret_array = array();
		$ret_array['id'] = 0;

		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$i = 0;
		
		$sql = "SELECT id, url, title, profile_id
		FROM video
		WHERE profile_id = '".$profile_id."'";	
 		$result = $dbCustom->getResult($db,$sql);
		if($result->num_rows > 0){
			$object = $result->fetch_object(); 	
			$ret_array['id'] = $object->id;
			$i++;
		}
		return $ret_array;
		
	}
	
	
	function getResultsFromProfiles($search_string = '')
	{		
	
		$ret_array = array();
		$active = 1;
		$i = 0;
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		
		if(strlen($search_string) > 2){
			
			//$param = "%{$search_string}%";
			
			$param = $search_string;
			
			$stmt = $db->prepare("SELECT id
						,name
						,profession
						,company
						,website
						,bio 
						FROM profile
						WHERE match(name) AGAINST ( ? IN BOOLEAN MODE)
						OR match(profession) AGAINST ( ? IN BOOLEAN MODE)
						OR match(company) AGAINST ( ? IN BOOLEAN MODE)
						OR match(bio) AGAINST ( ? IN BOOLEAN MODE)
						AND active = ?"); 
						
			if(!$stmt->bind_param("ssssi",
				$param,$param,$param,$param,$active)){
				echo 'Error-2 '.$db->error;
			}else{
				$stmt->execute();
							
				$stmt->bind_result($id, $name, $profession, $company, $website, $bio);
				while($stmt->fetch()) {
					$ret_array[$i]['id'] = $id;
					$ret_array[$i]['name'] = $name;
					$ret_array[$i]['profession'] = $profession;
					$ret_array[$i]['company'] = $company;
					$ret_array[$i]['website'] = $website;
					$ret_array[$i]['bio'] = $bio;					
					$ret_array[$i]['img_file_name'] = $this->getProfImgFilename($id);

					//$ret_array[$i]['has_videos'] = $this->getVideos($id);
					$ret_array[$i]['has_videos'] = 1;
				
					$ret_array[$i]['has_gallery'] = $this->has_gallery($row->id);

					
					$i++;
				}
			}	
							
			$stmt->close();

		}else{

			$sql = "SELECT id
						,name
						,profession
						,company
						,website
						,bio 
					FROM profile
					WHERE active > '0'
					LIMIT 200";	
			$result = $dbCustom->getResult($db,$sql);
			$i = 0;
			while($row = $result->fetch_object()){			

				$ret_array[$i]['id'] = $row->id;
				$ret_array[$i]['name'] = $row->name;
				$ret_array[$i]['profession'] = $row->profession;
				$ret_array[$i]['company'] = $row->company;
				$ret_array[$i]['website'] = $row->website;
				$ret_array[$i]['bio'] = $row->bio; 
				$ret_array[$i]['img_file_name'] = $this->getProfImgFilename($row->id);				
				
				$ret_array[$i]['has_videos'] = 1;
				
				$ret_array[$i]['has_gallery'] = $this->has_gallery($row->id);
				
				
				$i++;
			}			
		}

		return $ret_array;			
	
	}

	function has_gallery($profile_id){
	
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

		$sql = "SELECT image.id 
				FROM image, profile_to_img
				WHERE image.id = profile_to_img.img_id
				AND profile_to_img.profile_id = '".$profile_id."'
				AND image.slug LIKE '%aller%'";
	
		$result = $dbCustom->getResult($db,$sql);
		if($result->num_rows > 0){
			return 1;
		}
		return 0;
		
	}
		


	
	function getProfImgFilename($profile_id){
		
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

		$sql = "SELECT img_id
				FROM profile_to_img
				WHERE profile_id = '".$profile_id."'
				AND active >= '0'";
		$result = $dbCustom->getResult($db,$sql);
		if($result->num_rows > 0){
			$object = $result->fetch_object();
			return $this->getImgFilename($object->img_id);
		}
		return '';
		
	}
	
	
	function getImgFilename($img_id){
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		
		$sql = "SELECT file_name
				FROM image
				WHERE id = '".$img_id."'";		
		$result = $dbCustom->getResult($db,$sql);
		if($result->num_rows > 0){
			$object = $result->fetch_object();
			return $object->file_name;
		}
		return '';
	}

	function getResultsFromArticles($search_string = '')
	{
		$ret_array = array();
		$active = 1;
		$i = 0;
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

		if(strlen($search_string) > 1){
			
			//echo $search_string;
			//echo "<br />";

			$stmt = $db->prepare("SELECT DISTINCT article.id
							,article.posted_by_profile_id
							,article.title
							,article.sub_heading
							,article.content
							,article.img_id 
					FROM article, profile
					WHERE article.posted_by_profile_id = profile.id
					AND match(article.title) AGAINST ( ? IN BOOLEAN MODE)
					OR match(article.sub_heading) AGAINST ( ? IN BOOLEAN MODE)
					OR match(article.content) AGAINST ( ? IN BOOLEAN MODE)
					AND profile.active = ?
					AND article.active = ?");

				//echo 'Error-1 '.$db->error;
			if(!$stmt->bind_param("sssii",
				$search_string, $search_string, $search_string, $active, $active)){
				echo 'Error-2 '.$db->error;
			}else{
				$stmt->execute();
							
				$stmt->bind_result($id, $posted_by_profile_id, $title, $sub_heading, $content, $img_id);
				while($stmt->fetch()){
					$ret_array[$i]['id'] = $id;
					$ret_array[$i]['posted_by_profile_id'] = $posted_by_profile_id;
					$ret_array[$i]['title'] = $title;
					$ret_array[$i]['sub_heading'] = $sub_heading;
					$ret_array[$i]['content'] = $content;				
					$ret_array[$i]['img_file_name'] = $this->getImgFilename($img_id);
					
					$i++;
				}
			}	
						
			$stmt->close();

		}else{

			$sql = "SELECT DISTINCT article.id
						,article.posted_by_profile_id
						,article.title
						,article.sub_heading
						,article.content
						,article.img_id  
					FROM article, profile
					WHERE article.posted_by_profile_id = profile.id 
					AND profile.active = '1'
					AND article.active = '1'
					LIMIT 10";	
			$result = $dbCustom->getResult($db,$sql);
			while($row = $result->fetch_object()){			
				$ret_array[$i]['id'] = $row->id;
				$ret_array[$i]['posted_by_profile_id'] = $row->posted_by_profile_id;
				$ret_array[$i]['title'] = $row->title;
				$ret_array[$i]['sub_heading'] = $row->sub_heading;
				$ret_array[$i]['content'] = $row->content;
				$ret_array[$i]['img_file_name'] = $this->getImgFilename($row->img_id);				
				$i++;
			}
		}
		
		return $ret_array;			
	}

	
	function getResultsFromQA($search_string = ''){

		$ret_array = array();
		$quest_array = array();
		$answ_array = array();
		
		$active = 1;
		$is_private = 0;
		$i = 0;
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

		if(strlen($search_string) > 2){
			
			$stmt = $db->prepare("SELECT DISTINCT id
								,visitor_name
								,question 
						FROM question
						WHERE MATCH(question) AGAINST (? IN BOOLEAN MODE)
						AND is_private = ?
						AND active = ?");
				//echo 'Error-1   '.$db->error;
			if(!$stmt->bind_param("sii",
				$search_string, $is_private, $active)){
				echo 'Error-2   '.$db->error;
			}else{
				$stmt->execute();
				$stmt->bind_result($id, $visitor_name, $question);
				while($stmt->fetch()) {
					
					$quest_array[$i]['question_id'] = $id;
					$quest_array[$i]['visitor_name'] = $visitor_name;
					$quest_array[$i]['question'] = $question;
					
					$i++; 
				}
			}
			$stmt->close();
		
		}else{
		
			$sql = "SELECT DISTINCT id
						,visitor_name
						,question 
					FROM question
					WHERE is_private = '0'
					AND active = '1'
					LIMIT 10";	
			$result = $dbCustom->getResult($db,$sql);
			while($row = $result->fetch_object()){
				
	//echo "<br />".$row->question;
							
				$quest_array[$i]['question_id'] = $row->id;
				$quest_array[$i]['visitor_name'] = $row->visitor_name;
				$quest_array[$i]['question'] = $row->question;
				
				$i++;
			}
			
		}
								
		return $quest_array;			
		
	}
	
	
	function GetSearchResultsNewsArticles($search_string)
	{
	
		$search_string = preg_replace('/\s\s+/', ' ', $search_string);
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(SITE_DATABASE);
		$items_array = array();
		$i = -1;

		$stmt = $db->prepare("SELECT news_id 
					FROM news
					WHERE hide = '0' 
					AND type != 'admin'
					AND content LIKE ?");
			
		$param = "%{$search_string}%";
					
		if(!$stmt->bind_param("s",$param)){

		}else{
			$stmt->execute();
						
			$stmt->bind_result($news_id);
			while($stmt->fetch()) {
				$items_array[++$i] = $news_id;
			}
		}	
						
		$stmt->close();

		return multi_unique($items_array);				
	}


	function getAnswer($question_id){

		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);
		$active = 1;
		$answ_array = array();

				//AND profile.active = '1'
				//AND answer.active = '1'

		
		$sql = "SELECT DISTINCT answer.id
							,answer.answered_by_profile_id
							,answer.answer 
				FROM answer, profile
				WHERE answer.answered_by_profile_id = profile.id
				AND answer.question_id = '".$question_id."'
				ORDER BY answer.id";
		$result = $dbCustom->getResult($db,$sql);
		
		//echo $result->num_rows;
		//echo "<br />";	
		
		$i = 0;
		while($row = $result->fetch_object()){
			$answ_array[$i]['answer_id'] = $row->id;
			$answ_array[$i]['answered_by_profile_id'] = $row->answered_by_profile_id;
			$answ_array[$i]['answer'] = $row->answer;
					
			$i++; 
		}
		
		return $answ_array;
	}

	
	
}


/*
	function getResultsFromQA($search_string = ''){

		$ret_array = array();
		$quest_array = array();
		$answ_array = array();
		
		$active = 1;
		$is_private = 0;
		$i = 0;
		$dbCustom = new DbCustom();
		$db = $dbCustom->getDbConnect(EXPERT_DATABASE);

		if(strlen($search_string) > 2){
			
			$stmt = $db->prepare("SELECT DISTINCT id
								,visitor_name
								,question 
						FROM question
						WHERE MATCH(question) AGAINST (? IN BOOLEAN MODE)
						AND is_private = ?
						AND active = ?");
						 
				//echo 'Error-1   '.$db->error;
			if(!$stmt->bind_param("sii",
				$search_string, $is_private, $active)){
				echo 'Error-2   '.$db->error;
			}else{
				$stmt->execute();
							
				$stmt->bind_result($id, $visitor_name, $question);
				while($stmt->fetch()) {
					
					$quest_array[$i]['id'] = $id;
					$quest_array[$i]['visitor_name'] = $visitor_name;
					$quest_array[$i]['question'] = $question;
					
					$i++; 
				}
			}
			$stmt->close();
		
		}else{
		
			$sql = "SELECT DISTINCT id
						,visitor_name
						,question 
					FROM question
					WHERE is_private = '0'
					AND active = '1'
					
					LIMIT 10";	
			$result = $dbCustom->getResult($db,$sql);
			
			while($row = $result->fetch_object()){
				
				//echo "<br />".$row->question;
							
				$quest_array[$i]['id'] = $row->id;
				$quest_array[$i]['visitor_name'] = $row->visitor_name;
				$quest_array[$i]['question'] = $row->question;
				$i++;
			}
			
		}
						
		$i = 0;

		if(strlen($search_string) > 2){
	
			$stmt = $db->prepare("SELECT DISTINCT answer.id
								,answer.question_id
								,answer.answered_by_profile_id
								,answer.answer 
						FROM answer, profile
						WHERE answer.answered_by_profile_id = profile.id 
						AND profile.active = ?
						AND match(answer.answer) AGAINST ( ? IN BOOLEAN MODE)
						AND answer.active = ?
						ORDER BY answer.question_id");
						 
				//echo 'Error-1   '.$db->error;
			if(!$stmt->bind_param("isi",
				$active, $search_string, $active)){
				echo 'Error-2   '.$db->error;
			}else{
				$stmt->execute();
							
				$stmt->bind_result($id, $question_id, $answered_by_profile_id, $answer);
				while($stmt->fetch()) {
					$answ_array[$i]['id'] = $id;
					$answ_array[$i]['question_id'] = $question_id;
					$answ_array[$i]['answered_by_profile_id'] = $answered_by_profile_id;
					$answ_array[$i]['answer'] = $answer;
					
					$i++; 
				}
			}	
							
			$stmt->close();
		}else{

						
			$sql = "SELECT DISTINCT answer.id
							,answer.question_id
							,answer.answered_by_profile_id
							,answer.answer 
					FROM answer, profile
					WHERE answer.answered_by_profile_id = profile.id 
					AND profile.active = '1'
					AND answer.active = '1'
					
					LIMIT 10";	
			$result = $dbCustom->getResult($db,$sql);
			
			while($row = $result->fetch_object()){			
					$answ_array[$i]['id'] = $row ->id;
					$answ_array[$i]['question_id'] = $row ->question_id;
					$answ_array[$i]['answered_by_profile_id'] = $row->answered_by_profile_id;
					$answ_array[$i]['answer'] = $row ->answer;
				$i++;
			}			
			
		}

		$i = 0;
		foreach($answ_array as $a_val){
			
			$q_id = array_search($a_val['question_id'], array_column($quest_array, 'id'));
			if($q_id !== false){
				foreach($quest_array as $q_val){
					if($a_val['question_id'] == $q_val['id']){
						$ret_array[$i]['visitor_name'] = $q_val['visitor_name'];
						$ret_array[$i]['question'] = $q_val['question'];		
					}
				}
			}else{			
				$q_data = $this->getQuestionData($a_val['question_id']);
				$ret_array[$i]['visitor_name'] = $q_data ['visitor_name'];
				$ret_array[$i]['question'] = $q_data ['question'];		
			
			}			
			$ret_array[$i]['answer_id'] = $a_val['id']; 
			$ret_array[$i]['question_id'] = $a_val['question_id'];
			$ret_array[$i]['answered_by_profile_id'] = $a_val['answered_by_profile_id'];
			$ret_array[$i]['answer'] = $a_val['answer'];

			$i++;
		}


		return $ret_array;			
		
	}

*/


?>
