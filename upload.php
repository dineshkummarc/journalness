<?php

require_once( 'common.inc.php' );
require_once( 'includes/upload.class.php' );

if($session->logged_in && $journalnessConfig_allow_uploads){
	if(isset($_POST['file_uploaded'])){
		$filetype = $_FILES['userfile']['type'];

		if($filetype == 'image/gif' || $filetype == 'image/jpg' || $filetype == 'image/pjpeg' || $filetype == 'image/jpeg' || $filetype == 'image/png'){
			if($_FILES['userfile']['size'] < ($journalnessConfig_max_upload_size * 1000)){
				if($journalnessConfig_upload_type){
					$value = $upload->addPicture(1);
				}else{
					$value = $upload->addPicture(0);
				}
				
				$smarty->assign(array(
					"show_image_uploaded" => "true",
					"L_IMAGE_UPLOADED" => sprintf($lang['Image_uploaded'], $_FILES['userfile']['name']),
					"L_CLOSE_WINDOW" => $lang['Close_window'],
					"text" => $_FILES['userfile']['name'],
					"value" => $value)
				);
			}else{
				$maxsize = $journalnessConfig_max_upload_size;
				$kbsize = $_FILES['userfile']['size'] / 1000;
				$smarty->assign(array(
					"show_image_too_large" => "true",
					"L_ERROR" => $lang['Error'],
					"L_IMAGE_TOO_LARGE" => sprintf($lang['Image_too_large'], $kbsize, $maxsize))
				);
			}
		}else{
			$smarty->assign(array(
				"show_invalid_filetype" => "true",
				"L_ERROR" => $lang['Error'],
				"L_INVALID_FILETYPE" => $lang['Invalid_filetype'])
			);
		}
	}else{
		$smarty->assign(array(
				"show_upload_form" => "true",
				"L_UPLOAD_PICTURE" => $lang['Upload_picture'],
				"L_UPLOAD" => $lang['Upload'])
		);
	}
}

$smarty->display("$theme/upload.tpl");

?>