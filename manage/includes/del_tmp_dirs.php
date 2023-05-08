<?php
	
	if(!isset($real_root)) $real_root = '../..';

	$yesterday = time() - (24 * 60 * 60);

	if($handle = @opendir($real_root.'/temp_uploads')) {
		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			if(is_numeric($entry)){
				if($entry < $yesterday){
					if (file_exists($real_root.'/temp_uploads/'.$entry)) {
						deleteDir($real_root.'/temp_uploads/'.$entry);
					}
				}
			}
		}
		closedir($handle);
	}
?>