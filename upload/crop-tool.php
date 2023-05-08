<?php
require_once('../includes/config.php'); 
require_once('../includes/class.customer_login.php');

$lgn = new CustomerLogin;

$page_title = "Profile Image";

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";

$profile_id = $_SESSION['profile_id'];

if(!isset($_SESSION['img_id'])) $_SESSION['img_id'] = 0;

$op_b = "minWidth: 250, minHeight: 250, maxWidth: 800, maxHeight: 800, aspectRatio: '1:1', handles: true,";

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="../jquery.imgareaselect-0.9.10/css/imgareaselect-default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../jquery.imgareaselect-0.9.10/scripts/jquery.min.js"></script>
<script type="text/javascript" src="../jquery.imgareaselect-0.9.10/scripts/jquery.imgareaselect.pack.js"></script>

<script>

$(document).ready(function () {
	
    var ias = $('#pre_cropped').imgAreaSelect({
		 
		<?php echo 	$op_b; ?>
		
		onSelectEnd: function (img, selection) {
			
			$('input[name="x1"]').val(selection.x1);
			$('input[name="y1"]').val(selection.y1);
            $('input[name="x2"]').val(selection.x2);
            $('input[name="y2"]').val(selection.y2);            
        }
		
    });
	
	//ias.setSelection(600, 600, 700, 700);
	
});

</script>

<style type="text/css">
#img_to_crop {
	-webkit-user-drag: element;
	-webkit-user-select: none;
}

.center_this_block{
	
	display:inline-block;
	
}

body{
	text-align:center;
}

</style>


<script>

function validate(){

	var x1 = $('input[name="x1"]').val();
	var y1 = $('input[name="y1"]').val();
	var x2 = $('input[name="x2"]').val();
	var y2 = $('input[name="y2"]').val();

	//alert("x1"+x1+"    y1"+y1+"     x2"+x2+"    y2"+y2);
	
	var ret = 1;
	
	if(x1 == ""){
		ret = 0;
	}
	if(y1 == ""){
		ret = 0;	
	}
	if(x2 == ""){
		ret = 0;	
	}
	if(y2 == ""){
		ret = 0;	
	}	
	if(!ret){		
		alert("Please click inside the image and select a crop area");
		return false;	
	}
	
	return true;
	
}

</script>


</head>
<body>
<?php

$f_path = "../saascustuploads/".$profile_id."/full/";
//echo "fuul path and file name: ".$f_path.$_SESSION['pre_cropped_fn'];			
//echo "<br />";
$back_url = "../".$_SESSION['ret_dir']."/".$_SESSION['ret_page'].".php";

?>

Click inside the photo to select a the crop area.
<p style="font-size:16px;">
You can resize and move the box as needed.
</p>

<br />


<form action="./crop-set.php" onsubmit="return validate();" method="post">
  <input type="hidden" name="x1" value="" />
  <input type="hidden" name="y1" value="" />
  <input type="hidden" name="x2" value="" />
  <input type="hidden" name="y2" value="" />
  
  <input type="hidden" name="orig_img_path" 
  value="<?php echo $f_path; ?>" />
  
  <input type="hidden" name="orig_img_fn" value="<?php echo $_SESSION['pre_cropped_fn']; ?>" />
   
	<div style="float:left; margin-right:16px; margin-left:42%; margin-top:10px;">
		<a class="btn btn-info" href="<?php echo $back_url; ?>"> Cancel </a>
	</div>
  	<div style="float:left; margin-top:10px;">
		<input class="btn btn-info" type="submit" name="submit" value="Submit" />
	</div>
    <div style="clear:both;">&nbsp;</div>
   
    
</form>

<?php				
echo "<img id='pre_cropped' src='".$f_path.$_SESSION['pre_cropped_fn']."' />";
?>
            
<br />
<br />
<br />
<br />           
           
</body>
</html>



