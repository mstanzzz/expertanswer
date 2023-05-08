<?php
if(!isset($real_root)){
	if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
		$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
	}else{
		$real_root = '..'; 	
	}
}
require_once('../includes/config.php'); 										

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">

<!--
<link rel="stylesheet" type="text/css" href="../css/style.css">
-->

<title>Expert Answer</title>
	
<style>


</style>

</head>
<body>

<div style="padding:100px;">

	<div class="checkbox">
	  <label>
		<input type="checkbox" data-toggle="toggle">
		Option one is enabled
	  </label>
	</div>
	<div class="checkbox">
	  <label>
		<input type="checkbox" checked='checked' data-toggle="toggle">
		Option two is disabled
	  </label>
	</div>


</div>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


</body>
</html>
