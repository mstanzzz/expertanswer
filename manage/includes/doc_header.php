<?php 
	//helper function to set active class on appropriate nav items
	function isPageType($href) 
	{
	//get current page URI
		$uri = $_SERVER['REQUEST_URI'];
		if(strpos($uri,$href) > 0){
			return true;	
		}
		else {
			return false;	
		}
	}
	//$isEditPage = isPageType("manage/cms/pages/");
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo (isset($page_title)) ? $page_title : '' ?> | Site Management</title>

<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/js/fancybox2/source/jquery.fancybox.css?v=2.1.4" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/manageStyle.css?v=1" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/js/chosen/chosen.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/mce.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/jquery.multiselect.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/jquery.multiselect.filter.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/custom-theme/jquery-ui-1.8.23.custom.css" media="screen"/>

<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/print.css" media="print"/>

<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/forms.css" media="print"/>

<!--
<link rel="Stylesheet" type="text/css" href="<?php //echo SITEROOT; ?>/colorpicker/jPicker.css" />
<link rel="Stylesheet" type="text/css" href="<?php //echo SITEROOT; ?>/colorpicker/css/jPicker-1.1.6.css" />
-->


<!--[if lte IE 8]>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/ie.css" media="screen"/>
<![endif]-->
<!--[if IE 8]>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/ie8.css" media="screen" />
<![endif]-->
<!--[if gte IE 9]>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT; ?>/css/ie9.css" media="screen" />
<![endif]-->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
-->




<script src="<?php echo SITEROOT;?>/js/jquery-1.8.1.js"></script>



<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>

<!--
<script type="text/javascript" src="<?php // echo SITEROOT; ?>/js/jquery-ui-1.8.23/jquery-ui.js"></script>
<script type="text/javascript" src="<?php // echo SITEROOT; ?>/js/jquery-1.8.1.js"></script>
-->

<!--  don't use chosen.jquery.min.js because chosen.jquery.ms.otg.js has been modified to allow tool tip (title) -->
<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/chosen/chosen.jquery.ms.otg.js"></script>

<!--  don't use jquery.StickyForms.js because jquery.StickyForms.ms.otg.js has been modified to allow stiky cookie remove -->
<!--
<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/jquery.StickyForms.ms.otg.js"></script>
-->

<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/formtoggles.js"></script>
<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/inlineConfirmation.js"></script>

<!--
<script type="text/javascript" src="<?php //echo SITEROOT; ?>/js/scrollAffix.js"></script>
-->

<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/fancybox2/source/jquery.fancybox.js?v=2.1.4"></script>
<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/ui/jquery.ui.datepicker.js"></script>

<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/jquery.multiselect.min.js" ></script>
<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/jquery.multiselect.filter.min.js"></script>

<!--
<script type="text/javascript" src="<?php //echo SITEROOT;?>/js/jquery.valid8.js"></script>
-->

<script type="text/javascript" src="<?php echo SITEROOT;?>/js/bootstrapcustom.min.js"></script>







<!--
  <script src="<?php //echo SITEROOT; ?>/colorpicker/jpicker-1.1.6.min.js" type="text/javascript"></script>
-->

<!--
<script src="<?php //echo SITEROOT;?>/manage/manage-js/util.js"></script>
-->

<script type="text/javascript">

$(document).ready(function(){
	
	//$('.fancybox').fancybox();
	
	$('.fancybox').fancybox({
		autoSize : false,
		height : 800,
		width : 1060	
	});	

	
		
});

</script>

