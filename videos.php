<?php
//define('__ROOT__', dirname(dirname(__FILE__)));
require_once('includes/config.php'); 
require_once('includes/class.customer_login.php');
require_once('includes/class.profess.php');
$prof = new Professional;
$lgn = new CustomerLogin;

$profile_id = $lgn->getProfileId();

$pid = isset($_GET['pid'])? $_GET['pid'] : 0;
if(!is_numeric($pid)) $pid = 0;

$msg = "";

$ts = time();

if(isset($_POST["comment"])){

	
}

$vid_array = array();



if($pid){
	
	$sql = "SELECT id, url, title, profile_id
			FROM video 
			WHERE profile_id = '".$pid."'
			ORDER BY display_order";
	$result = $dbCustom->getResult($db,$sql);
		
}else{

	$sql = "SELECT id, url, title, profile_id
			FROM video 
			WHERE active > '0'
			ORDER BY display_order";
	$result = $dbCustom->getResult($db,$sql);

}

$i = 0;
while($row = $result->fetch_object()) {

	$vid_array[$i]['id'] = $row->id;	
	$vid_array[$i]['title'] = $row->title;
	$vid_array[$i]['url'] = $row->url;
	
	$posted_by = $prof->getProfName($row->profile_id);
	$vid_array[$i]['posted_by'] = $posted_by;

	$i++;
}

/*
$i = 1;
while($i < 13){
	echo $i % 2;
	echo "<br />";
	if($i % 2 == 0){
		echo "<br />";
		echo "<hr />";
		echo "<br />";
	}
	$i++;
}
*/
					
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

<style>

.backgr{
	background-color: #003756;
	border-radius: 25px;
	margin-top:40px;
	padding:40px;
}
.vid_post_by{
	font-size:0.9em;
	color:#5FDDE2;
}
.vid_title{
	font-size:1.2em;
	color:#8FD0D2; 
}

.vid_box{
	height:92px;
}

</style>

</head>
<body style="background-color: #FFF;">
<?php
//require_once('top.php');
require_once('nav.php');
?>

<div class="container backgr">

<?php

$block = '';

$i = 1;

$block .= "<div class='row'>";

foreach($vid_array as $val){	
	

	$block .= "<div class='col-md-6 vid_box'>";
	$block .= "<a href='".$val['url']."' target='_blank'>";
	$block .= "<span class='vid_title'>".stripslashes($val['title'])."</span>";
	$block .= "</a>";
	$block .= "<div class='vid_post_by'>Posted By: ".$val['posted_by']."</div>";
	$block .= "</div>";

	
	if($i % 2 == 0){
		$block .= "</div>";
		$block .= "<div class='row'>";
	}	

	$i++;
		
}

$block .= "</div>";

echo $block;

?>

		
	
</div>			


<?php
require_once('footer.php');
?>
    
</body>
</html>


