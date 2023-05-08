<?php
class View {

	function getQABlock($qa_array, $prof){

		if(!isset($search)){
			$search = new Search;
		}			
		if(!isset($prof)){
			$prof = new Professional;
		}				
		
		$block = '';
		
		foreach($qa_array as $v){
							
			$block .= "<div class='row' style='margin-top:40px; background-color: white;'>";
			$block .= "<div class='col-2'>";			
			$block .= "<img src='".SITEROOT."/img/avatar.png' />";
			$block .= "<img src='".SITEROOT."/img/med_icon_question.png' />";			
			$block .= "<br />";
			$block .= $v['visitor_name'];
			
			$block .= "</div>";							
			$block .= "<div class='col-10' style='margin-top:20px; padding-bottom:20px; background-color: white;'>";				
			$res = preg_replace("/[^a-zA-Z0-9\s]/", "", $v['question']);				
			$block .= $res;
			$block .= "</div>";
			$block .= "</div>";				

			$a_array = $search->getAnswer($v['question_id']);
			
			//print_r($a_array);
			
			foreach($a_array as $av){
				
				$prof_array = $prof->getProfessBasicData($av['answered_by_profile_id']);			
				
				if(strlen($prof_array['img_file_name']) < 4){
					$prof_img = SITEROOT."/img/noprofile.png"; 	
				}else{
					$prof_img = SITEROOT."/saascustuploads/profile/".$av['answered_by_profile_id']."/round/".$prof_array['img_file_name'];
				}

				//$av['answer_id']
				$block .= "<div class='row'"; 
				$block .= "style='margin-top:20px; margin-left:20px; '>";
				$block .= "<div class='col-2'><br />";
				$block .= "<img style='width:60px' src='".$prof_img."' />";
				
				
				$block .= "<br />".$prof_array['name'];
				$block .= "<br />".$prof_array['profession'];			
				$block .= "</div>";				
				$block .= "<div class='col-10' 
									style='margin-top:20px; 
									padding-bottom:20px; 
									background-color:white;'>";
				$block .= $av['answer'];
				$block .= "</div>";
				$block .= "</div>";
								
			}
			
			$block .= "<div class='row'>";
			$block .= "<div class='col-2'>";			
			$block .= "</div>";
			$block .= "<div class='col-10'>";			
			
			$block .= "<div id='exp_answ_box'>";
			
			$block .= "<button type='button' onClick='exp_add_answer(".$v['question_id'].")'";
			
			$block .= " class='btn btn-info btn-sm'>Add Answer</button>";			
			$block .= "</div>";
			
			$block .= "</div>";
			$block .= "</div>";
			$block .= "<hr />";
			
		}
		
		return $block;	
		
	}
	
	
	function getArticBlock($art_array, $prof)
	{
		$block = "";
		
		foreach($art_array as $v){
				
			$prof_array = $prof->getProfessBasicData($v['posted_by_profile_id']);
			if(strlen($prof_array['img_file_name']) < 4){
				$prof_img = SITEROOT."/img/noprofile.png"; 	
			}else{
				$prof_img = SITEROOT."/saascustuploads/profile/".$v['posted_by_profile_id']."/round/".$prof_array['img_file_name'];
			}

			$block .= "<div class='row'>";
			$block .= "<div class='col-md-2' style='margin-top:60px;'>";
			$block .= "<img width='60' src='".$prof_img."' />";

			$block .= "<br />".$prof_array['name'];
			$block .= "<br />".$prof_array['profession'];			
			$block .= "</div>";
			
			$block .= "<div class='col-md-10' style='margin-top:60px;'>";			
						
			if(strlen($v['img_file_name']) > 3){
$block .= "<div style='margin-right:15px; float:left;'>";
$block .= "<img src='".SITEROOT."/saascustuploads/profile/".$v['posted_by_profile_id']."/article/".$v['img_file_name']."'>";
$block .= "</div>";
			}
			
			if(strlen($v['title']) > 3){
				$block .= "<h4>".$v['title']."</h4>";
			}
			if(strlen($v['sub_heading']) > 3){			
				$block .= "<br /><h5>".$v['sub_heading']."</h5>";
			}

			$block .= $v['content'];
			
			$block .= "<div style='clear:both;'></div>";
			$block .= "</div>";
			$block .= "</div>";
			
		}

		return $block;	
		
	}
	
	function getMemProfBlock($mp_array, $prof)
	{
		
		$block = "";
		
		foreach($mp_array as $v){
				
			if(strlen($v['img_file_name']) < 2){
				$prof_img = SITEROOT."/img/noprofile.png"; 	
			}else{
				$prof_img = SITEROOT."/saascustuploads/".$v['id']."/round/".$v['img_file_name'];
			}
			
			//$block .= $prof_img;
			
$block .= "<div class='row'";
$block .= " style='margin-top:10px; background-color: white;'>";
$block .= "<div class='col-md-2' style='padding-top:20px;'>";

$block .= "<a href='profile.html?profile_id=".$v['id']."'>";
$block .= "<img src='".$prof_img."' />";
$block .= "</a>";

$block .= "</div>";
$block .= "<div class='col-10' style='padding-top:20px;'>";

if(strlen($v['name']) > 3){
	$block .= "<div style='float:left; margin-right:10px;'><b>".$v['name']."</b></div>";	
}

			if(strlen($v['profession']) > 3){
				$block .= "<div style='float:left; margin-right:10px;'> - <i>".$v['profession']."</i></div>";	
			}

			if(strlen($v['company']) > 3){
				$block .= "<div style='float:left; margin-right:10px;'> - <i>".$v['company']."</i></div>";	
			}

			if(strlen($v['website']) > 3){			
$block .= "<div style='float:left;'> - <i><a href='".$v['website']."' target='_blank'>Website</a></i></div>";	
			}
			//if($v['has_videos']){
				//$block .= "<div style='float:left;'> - <i><a href='videos.php?pid=".$v['id']."' target='_blank'>Videos</a></i></div>";		
			//}
			
			
			$block .= "<div style='clear:both;'></div>";
			
$block .= "<div style='text-align:left; min-height:120px;'>".$v['bio']."<p style='color:#3333ff; font-size:18px;'>";
$block .= "<a href='".SITEROOT."/ask.html?pid=".$v['id']."'>Ask ".$v['name']." a question now</a></p></div>";
if($v['has_gallery']){						
	$block .= "<br /><a href='gallery.php?pid=".$v['id']."'>Gallery</a>";
}			
			
			$block .= "</div>";
			$block .= "</div>";
			
		}

		return $block;	
		
	}
	
	
	
	
}

?>

