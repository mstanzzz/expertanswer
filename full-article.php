<?php
//define('__ROOT__', dirname(dirname(__FILE__)));
require_once('includes/config.php');
require_once('includes/class.customer_login.php');
require_once('includes/class.profess.php');
$prof = new Professional;
$lgn = new CustomerLogin;

$profile_id = $lgn->getProfileId();

//echo "profile_id ".$profile_id;
//echo "<br />";

function get_file_name($img_id){
	$dbCustom = new DbCustom();
	$db = $dbCustom->getDbConnect(EXPERT_DATABASE);	
	$file_name = "didgetface.jpg";	
	$sql = "SELECT file_name 
			FROM image 
			WHERE id = '".$img_id."'";
	$img_result = $dbCustom->getResult($db,$sql);
	if($img_result->num_rows > 0){
		$img_obj = $img_result->fetch_object();                                
		$file_name = $img_obj->file_name;
	}	
	return $file_name;
}

$ts = time();

$art_id = (isset($_GET['art_id']))? $_GET['art_id'] : 0; 
if(!is_numeric($art_id)) $art_id = 0;

//echo "art_id ".$art_id;
//echo "<br />";						

if(isset($_POST['submit_comment'])){

	$c_name = isset($_POST['c_name'])? addslashes(trim($_POST['c_name'])) : '';
	$c_email = isset($_POST['c_email'])? addslashes(trim($_POST['c_email'])) : '';
	$c_comment = isset($_POST['c_comment'])? addslashes(trim($_POST['c_comment'])) : '';

	$stmt = $db->prepare("INSERT INTO article_comment 
						(name
						,email
						,comment
						,when_entered
						,article_id
						,entered_by_profile_id)
						VALUES
						(?,?,?,?,?,?)"); 
								
		//echo 'Error-1 UPDATE   '.$db->error;
		//echo "<br />";						
	if(!$stmt->bind_param("sssiii",
					$c_name
					,$c_email
					,$c_comment					
					,$ts					
					,$art_id
					,$profile_id)){								
								
		//echo 'Error-2 UPDATE   '.$db->error;
		//echo "<br />";						
			
	}else{
		$stmt->execute();
		$stmt->close();
		
		$c_id = $db->insert_id;						
		$msg = "Your comment was submitted.";
	}
	
	//echo $c_id;
	//echo "<br />";
}

$comments_array = array();
$sql = "SELECT name 
			,when_entered
			,comment			
		FROM article_comment 
		WHERE article_id = '".$art_id."'";				
		//AND active > '0'

$result = $dbCustom->getResult($db,$sql);

//echo $result->num_rows;

$i = 0;
while($row = $result->fetch_object()){
	$comments_array[$i]['name'] = $row->name;
	$comments_array[$i]['when_entered'] = $row->when_entered;
	$comments_array[$i]['comment'] = $row->comment;	
	$i++;
}


$sql = "SELECT * 
		FROM article 
		WHERE id = '".$art_id."'";				
$result = $dbCustom->getResult($db,$sql);
if($result->num_rows > 0){
	$object = $result->fetch_object();	
	$title = stripslashes($object->title);
	$sub_heading = stripslashes($object->sub_heading);
	$category_id = $object->category_id;
	$type = $object->type;
	$content = stripslashes(stripslashes($object->content));
	$img_id = $object->img_id;
	$img_before_id = $object->img_before_id;
	$img_after_id = $object->img_after_id;
	$posted_by_profile_id = $object->posted_by_profile_id;	
}else{
	$title = "";
	$sub_heading = "";
	$category_id = 0;
	$type = "";
	$content = "";
	$img_id = 0;
	$img_before_id = 0;
	$img_after_id = 0;
	$posted_by_profile_id = 0;	
}



$file_name = get_file_name($img_id); 

if($file_name == "didgetface.jpg"){
	$img = "<img src='./images/".$file_name."'>";		
}else{
	$img = "<img src='./saascustuploads/".$posted_by_profile_id."/article/".$file_name."'>";
}



$p_fn = $prof->getProfImg($posted_by_profile_id); 


if(strlen($p_fn) < 2){
	$prof_img_path = SITEROOT."./img/noprofile.png"; 
	$prof_img = "<img src='".$prof_img_path." />";
	
}else{
	//$prof_img_path = SITEROOT."/saascustuploads/".$posted_by_profile_id."/round/".$p_fn;
	
	//$prof_img = "<img src='".$prof_img_path." />";
	$prof_img = "<img src='./saascustuploads/".$posted_by_profile_id."/round/".$p_fn."'>";
	
}
/*
echo "posted_by_profile_id ".$posted_by_profile_id;
echo "<br />";
echo "p_fn ".$p_fn;
echo "<br />";
echo "prof_img: ".$prof_img;
echo "<br />";
*/



?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

<title><?php echo $title; ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
<meta name="google-signin-client_id" content="874343353343-qlj921hrcnvt8srlhmvk69i4t0ivti2q.apps.googleusercontent.com">  
<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/flat_icon.css">    	
<link rel="stylesheet" href="css/style.css">



<style>

.c_box{
	width:100%;
	margin-bottom:20px;
	padding-bottom:10px;
	padding-top:10px;
	padding-left:20px;
	padding-right:20px;		
	border-style:solid; 
	border-width:1px; 
	border-radius:5px; 
	border-color:#AEB6BF;
	background-color:#F2F4F4;	
	font-size:1.1em
}
.c_box_name{
	float:left;
	font-weight: bold;	
}
.c_box_date{
	float:right;
	font-weight: bold;
	margin-right:10px;
}

img {
  max-width: 460px;
  height: auto;
}

</style>



</head>
<body>
<?php
//require_once('top.php');
require_once('nav.php');
?>

<div style="color:black; max-width:90%; word-wrap:true; padding-left:20px; padding-right:20px;">
<?php

echo "<div style='float:left; padding-right:15px;'>".$img."</div>";
echo "<h1>".$title."</h1>";
echo "<h2>".$sub_heading."</h2>";

echo "<div style='font-size:1.4em;'>".$content."</div>";

$a_name = $prof->getProfName($posted_by_profile_id);
echo "<div style='font-size:1.2em; float:right;'>By: ".$a_name;
echo "<p style='color:#3333ff; font-size:18px;'>";
echo "<a href='".SITEROOT."/ask.php?pid=".$posted_by_profile_id."'>Ask ".$a_name." a question now</a></p>";
echo $prof_img;
echo "</div>";
echo "<div style='clear:both;'></div>";


$c_n = count($comments_array);

echo "<h3>".$c_n." Comments</h3>";

$c_block = '';
	foreach($comments_array as $c_val){
		 
		$c_block .= "<div class='c_box'>";
		$c_block .= "<div class='c_box_name'>".stripslashes($c_val['name'])."</div>";
		$c_block .= "<div class='c_box_date'>".date('m/d/Y g:i a',$c_val['when_entered'])."</div>";
		$c_block .= "<div style='clear:both;'></div>";
		$c_block .= stripslashes($c_val['comment']);
		$c_block .= "</div>";
		 		 
	}

	echo $c_block;
	
?>


<br />

<form name="c_form" action="full-article.php?art_id=<?php echo $art_id; ?>" method="post" > 
	<div class="form-group">
		<input style="border-color:#AEB6BF;" type="text" 
		class="form-control" name="c_name" id="c_name" placeholder="Name or Alias ">
	</div>
	<!--
	<div class="form-group">
		<input style="border-color:#AEB6BF;" type="text" class="form-control"  name="c_email" id="c_email" placeholder="Email Address">
		<small id="email" class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>
	-->	
	<div class="form-group">
		<textarea style="border-color:#AEB6BF;" class="form-control" name="c_comment" id="c_comment" rows="3" placeholder="Comment"></textarea>
	</div>
	<button type="submit" class="btn btn-primary" name="submit_comment">Submit Comment</button>
</form>
<br />


</div>

<?php
require_once('footer.php');
?>
    
</body>
</html>










