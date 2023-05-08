<?php
if(strpos($_SERVER['REQUEST_URI'], 'Expert Answer/' )){    
	$real_root = $_SERVER['DOCUMENT_ROOT'].'/Expert Answer'; 
}else{
	$real_root = '..'; 	
}

if(isset($_POST["add_news"])){

	$author = trim(addslashes($_POST["author"]));
	$content = trim(addslashes($_POST["content"])); 
	$title = trim(addslashes($_POST['title']));
	$type = trim($_POST["type"]);
	$ts = time();
	
	$sql = "SELECT count(news_id) AS num FROM news WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
		   $result = $dbCustom->getResult($db,$sql);		   $n_object = $result->fetch_object();
		   $list_order = $n_object->num + 1;

	$sql = sprintf("INSERT INTO news (author, title, content, list_order, type, last_update, profile_account_id) 
					VALUES ('%s','%s','%s','%u','%s','%u','%u')", $author, $title, $content, $list_order, $type, $ts, $_SESSION['profile_account_id']);
	$result = $dbCustom->getResult($db,$sql);
	

}

if(isset($_POST["edit_news"])){
	
	$author = trim(addslashes($_POST["author"]));	
	$content = trim(addslashes($_POST["content"])); 
	$title = trim(addslashes($_POST['title']));
	$type = trim($_POST["type"]);
	$news_id = $_POST["news_id"];
	//$hide = $_POST["hide"];
	$ts = time();

	$sql = sprintf("UPDATE news 
					SET author = '%s', title = '%s', content = '%s', type = '%s', last_update = '%u' 
					WHERE news_id = '%u'
					AND profile_account_id  = '%u'", 
	$author, $title, $content, $type, $ts, $news_id, $_SESSION['profile_account_id']);
		
	$result = $dbCustom->getResult($db,$sql);
	
	
}

if(isset($_POST["del_news_id"])){

	$news_id = $_POST["del_news_id"];

//	$backup = new Backup;
//	$dbu = $backup->doBackup($news_id,$profile_id,"news","delete");	

	$sql = sprintf("DELETE FROM news WHERE news_id = '%u'", $news_id);
	$result = $dbCustom->getResult($db,$sql);
	
}



if(isset($_POST["set_active_and_display_order"])){
	
	$list_orders = $_POST["list_order"];
	$news_ids  = $_POST["news_id"];
	$actives = (isset($_POST["active"]))? $_POST["active"] : array();

	$sql = "UPDATE news SET hide = '1' WHERE profile_account_id = '".$_SESSION['profile_account_id']."'";
$result = $dbCustom->getResult($db,$sql);	

	if(is_array($actives)){	
		foreach($actives as $key => $value){
			$sql = "UPDATE news SET hide = '0' WHERE news_id = '".$value."'";
	$result = $dbCustom->getResult($db,$sql);			
				//echo "key: ".$key."   value: ".$value."<br />"; 
		}
	}

	
	//print_r($display_orders);
	//echo "<br />";
	//print_r($navbar_label_ids);
	//exit;
	
	if(is_array($list_orders)){

		for($i = 0; $i < count($list_orders); $i++){
			
			//echo "display_orders".$display_orders[$i];
			//echo "<br />";
			//echo "navbar_label_id".$navbar_label_ids[$i];
			//echo "-----------------------<br />";
			
			$sql = sprintf("UPDATE news 
				SET list_order = '%u' 
				WHERE news_id = '%u'",
				$list_orders[$i], $news_ids[$i]);

			$result = $dbCustom->getResult($db,$sql);
			


		}
	}


}
?>
</head>
<body>

</body>
</html>
