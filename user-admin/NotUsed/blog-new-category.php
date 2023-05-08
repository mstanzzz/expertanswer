<?php



require_once("../manage/includes/manage-includes.php");

$progress = new SetupProgress;
$module = new Module;


$page_title = "Request New Blog Category";
$page_group = "blog";


require_once("../manage/includes/set-page.php");	

$db = $dbCustom->getDbConnect(EXPERT_DATABASE);


$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";


require_once("../manage/includes/doc_header.php"); 

?>
<script>

$(document).ready(function() {

});

/*
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "safari",
	content_css : "../css/mce.css"
});
*/

function show_msg(msg){
	alert(msg);
}

</script>
</head>
<body style="background-color: #FFF1E5;">
<div class="lightboxholder">
	<?php if($msg != ""){ ?>
	<div class="alert">
		<p><?php echo $msg ?></p>
	</div>
	<?php 
		} 
	?>
	<form name="request_new_category_form" action="blog-categories.php" method="post" target="_top">
		<div class="lightboxcontent">
			<h2>Request a New Blog Category</h2>
			<fieldset>
				<div class="colcontainer formcols">
					<div class="twocols">
						<label>Category Name</label>
					</div>
					<div class="twocols">
						<input type="text" name="category_name" value="" maxlength="255" style="width:500;" />
					</div>
				</div>
				<div class="colcontainer formcols">
					<div class="twocols">
						<label>Description / Reason</label>
					</div>
					<div class="twocols">
						<textarea  name="description" rows="5" cols="50"></textarea>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="savebar">
			<button class="btn btn-large btn-success" name="request_new_category" type="submit"><i class="icon-ok icon-white"></i> Submit Request </button>
		</div>
	</form>
</div>
</body>
</html>
<?php $db_dis = dbDisconnect(); ?>
