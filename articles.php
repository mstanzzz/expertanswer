<?php
require_once('includes/config.php'); 										

$msg = '';

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

$arts_array = array();

$sql = "SELECT id
			,title
			,sub_heading
			,when_entered
			,img_id
			,posted_by_profile_id
		FROM article
		WHERE active > 0
		ORDER BY display_order"; 
$result = $dbCustom->getResult($db,$sql);

$i = 0;
while($row = $result->fetch_object()){
	$arts_array[$i]['art_id'] = $row->id;	
	$arts_array[$i]['title'] = stripslashes($row->title);	
	$arts_array[$i]['sub_heading'] = stripslashes($row->sub_heading);
	$arts_array[$i]['when_entered'] = date("M d Y",$row->when_entered);
	$arts_array[$i]['img_id'] = $row->img_id;
	$arts_array[$i]['posted_by_profile_id'] = $row->posted_by_profile_id;
	$i++;
}


$art_block = "";

foreach($arts_array as $val){

	$file_name = get_file_name($val['img_id']);
	
	if($file_name == "didgetface.jpg"){
		$img = "./images/".$file_name;		
	}else{
		$img = "./saascustuploads/".$val['posted_by_profile_id']."/article/".$file_name;
	}

	$art_block .= "<div class='col-md-4 d-flex'>";
	$art_block .= "<div class='blog-entry align-self-stretch'>";
	$art_block .= "<a href='full-article.php?art_id=".$val['art_id']."' class='block-20 rounded'"; 
	$art_block .= "style='width:300px; background-image: url(".$img.");'>";
	$art_block .= "</a>";	
	$art_block .= "<div class='text p-4' style='margin-left:-20px;'>";	
	$art_block .= "<a href='full-article.php?art_id=".$val['art_id']."'>";
	$art_block .= "<div class='meta mb-2'>".$val['when_entered']."</div>";
	$art_block .= "<h3 class='heading'>";
	$art_block .= $val['title'];
	$art_block .= "</h3>";
	$art_block .= "</a>";
	$art_block .= "</div>";
	$art_block .= "</div>";
	$art_block .= "</div>";
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" 
      type="image/png" 
      href="<?php echo SITEROOT."/favicon.png"; ?>" >

<title>Expert Answer</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
<meta name="google-signin-client_id" content="874343353343-qlj921hrcnvt8srlhmvk69i4t0ivti2q.apps.googleusercontent.com">   
<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/flat_icon.css">    	
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
//require_once('top.php');
require_once('nav.php');
?>
<section class="ftco-section">
	<div class="container">
		<div class="row d-flex">
			<?php
	echo $art_block;
			?>
		</div>			
	</div>
</section>
<?php
require_once('footer.php');
?>

  <script src="js_orig/jquery.min.js"></script>

</body>
</html>
