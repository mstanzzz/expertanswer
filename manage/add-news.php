<?php
require_once($real_root.'/manage/includes/manage-includes.php');


require_once($real_root.'/manage/includes/set-page.php');	

$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';

require_once($real_root.'/manage/includes/doc_header.php'); 


?>
<script>
		tinyMCE.init({
        // General options
        mode : "specific_textareas",
        editor_selector : "wysiwyg",
        theme : "advanced",
        skin : "o2k7",
        plugins : "table,advhr,advlink,emotions,inlinepopups,insertdatetime,searchreplace,paste,style",
        // Theme options
        theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,styleselect,formatselect,fontsizeselect,|,forecolor,backcolor",
        theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,link,unlink,",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        theme_advanced_resize_horizontal : false,
	content_css : "../../../css/mce.css"
	});

</script>
</head>
<body>

<div style="margin-left:20px;">
	<img height="40" src="<?php echo SITEROOT;?>/img/nat.png" />
	<?php
	echo "<span>Welcome  ".$lgn->getFullName()."<span>";
	echo "<span style='margin-left:30px; color:red; font-size:1.3em;'>".$msg."</span>";
	echo "<br />";
	require_once('includes/manage-nav.php');
	?>
</div>

<div class="row">		
	<div class="col-md-12">
		<div style="margin:10px;">

			<form name="add_news" action="news.php" method="post">
			<div class="page_actions edit_page">
				<button name="add_news" type="submit" class="btn btn-success btn-large"><i class="icon-ok icon-white"></i> Add News</button>
				<hr />
				<a href="news.php" target="_top" class="btn"><i class="icon-arrow-left"></i> Cancel &amp; Go Back</a> </div>
			<div class="page_content edit_page">
				<fieldset class="edit_content">
					<div class="colcontainer formcols">
						<?php if(getProfileType() == "master" || getProfileType() == "parent"){ ?>
						<div class="twocols">
							<label>News Type</label>
						</div>
						<div class="twocols">
							<select name="type">
								<option value="admin">admin</option>
								<option value="whats_new">admin what's new</option>
								<option value="public">public</option>
							</select>
						</div>
					</div>
					<div class="colcontainer formcols">
						<?php }else{ ?>
						<input type="hidden" name="type" value="public" />
						<?php } ?>
						<div class="twocols">
							<label>Author</label>
						</div>
						<div class="twocols">
							<input type="text" name="author"/>
						</div>
					</div>
					<div class="colcontainer formcols">
						<div class="twocols">
							<label>Title</label>
						</div>
						<div class="twocols">
							<input type="text" name="title" />
						</div>
					</div>
					<div class="colcontainer">
						<label>Content</label>
						<textarea  name="content" id="wysiwyg1" class="wysiwyg small"></textarea>
					</div>
				</fieldset>
			</div>
			</form>
		</div>	
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
