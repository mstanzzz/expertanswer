<?php
require_once('includes/config.php'); 
require_once('includes/class.customer_login.php');
$lgn = new CustomerLogin;
require_once('includes/functions.php');
require_once('includes/class.profess.php');

$visitor_profile_id = $lgn->getProfileId();
$prof = new Professional;
$profile_id = (isset($_GET['pid'])) ? trim(addslashes($_GET['pid'])): 0; 

//echo $profile_id;
//echo "<br />";
//echo "<br />";

$sql = "SELECT image.id
			,image.file_name
			,image.description 			
		FROM image, profile_to_img
		WHERE image.id = profile_to_img.img_id
		AND profile_to_img.profile_id = '".$profile_id."'
		AND image.slug LIKE '%aller%'";
$result = $dbCustom->getResult($db,$sql);

$i = 0;

while($row = $result->fetch_object()){	

	$gal_array[$i]['file_name'] = $row->file_name;	
	$gal_array[$i]['id'] = $row->id;
	$gal_array[$i]['description'] = $row->description;
	
	$i++;	
}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/flat_icon.css">    	
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/magnific-popup.css">    

<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 2; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: relative;
  top: 45px;
  right: 25px;
  color: red;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
</head>
<body style="background-color: #FFF1E5;">
<?php
require_once('nav.php');

$gal_block = '';

foreach($gal_array as $val){
	
	if($val['file_name'] == ""){
		$img = "./images/didgetface.jpg";		
	}else{
		$img = "./saascustuploads/".$profile_id."/".$val['file_name'];
	}


	$gal_block .= "<div style='float:left; width:470px; margin:10px;'>";
		
	$gal_block .= "<img onclick='open_gal_modal(".$val['id'].");' 
	id='myImg_".$val['id']."' 
	src='".$img."' 
	alt='sss' 
	style='width:100%;max-width:470px'>"; 


	$gal_block .= "<br />";	
	$gal_block .= $val['description'];
	
	
	$gal_block .= "</div>";

	
}
$gal_block .= "<div style='clear:both;'></div>";


echo $gal_block;
?>


<!-- The Modal -->
<div id="myModal" class="modal" style="">


  <span class="close" style="color:red;">&times;</span>


  <img class="modal-content" id="img01">


 <div id="caption"></div>



</div>

<script>


function open_gal_modal(img_id){

	var modal = document.getElementById("myModal");

	var img = document.getElementById("myImg_"+img_id);

	var modalImg = document.getElementById("img01");

	var captionText = document.getElementById("caption");
	
	modal.style.display = "block";
	
	modalImg.src = img.src;
	
	captionText.innerHTML = img.alt;
	
	var span = document.getElementsByClassName("close")[0];

	span.onclick = function() { 
		modal.style.display = "none";
	}


}


</script>

</body>
</html>
