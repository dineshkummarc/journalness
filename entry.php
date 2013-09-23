<?php

require_once( 'common.inc.php' );

if($session->logged_in && $session->useraccess >= $journalnessConfig_post_level){

	if(isset($_POST['submit'])){

      	$returnval = $entry->addEntry($_POST['title'], $_POST['entry_text'], $_POST['access'], $_POST['entrycategories']);
     
      	if($returnval > 0){
         		header("Location: past.php?id=" . $returnval);
      	}elseif($returnval == 0){
         		$_SESSION['value_array'] = $_POST;
         		$_SESSION['error_array'] = $form->getErrorArray();
			$_SESSION['entrycategories'] = $_POST['entrycategories'];
			$_SESSION['entrycategoriesdata'] = 1;
         		header("Location: entry.php");
      	}elseif($returnval == -1){
         		$_SESSION['entrysuccess'] = false;
         		header("Location: entry.php");
      	}
	}elseif(isset($_POST['preview'])){
		$_SESSION['entrycategories'] = NULL;
		if(isset($_POST['entrycategories'])){
			$_SESSION['entrycategories'] = $_POST['entrycategories'];
		}
		$_SESSION['entrycategoriesdata'] = 1;

		$preview = $entry->getEntryPreview($_POST['title'], $_POST['entry_text']);
		$pictures = $entry->getPictures();

		$show_preview = true;
		if(empty($preview['title']) || empty($preview['entry_text'])){
			$show_preview = false;
		}

		$access_opts = NULL;
		if($session->is_admin){
			$access_opts = array(0 => $lang['Public'], 1 => $lang['Registered'], 2 => $lang['Admin']);
		}elseif($session->logged_in){
			$access_opts = array(0 => $lang['Public'], 1 => $lang['Registered']);
		}

		$categories_options = $categories->getEntryCategories();

		if(isset($_SESSION['entrycategoriesdata'])){
			for($i=0; $i<count($categories_options); $i++){
				if(empty($_SESSION['entrycategories'])){
					$categories_options[$i]['def'] = 0;
				}elseif(in_array($categories_options[$i]['id'], $_SESSION['entrycategories'])){
					$categories_options[$i]['def'] = 1;
				}else{
					$categories_options[$i]['def'] = 0;
				}

				for($j=0; $j<count($categories_options[$i]['subcategories']); $j++){
					if(empty($_SESSION['entrycategories'])){
						$categories_options[$i]['subcategories'][$j]['def'] = 0;
					}elseif(in_array($categories_options[$i]['subcategories'][$j]['id'], $_SESSION['entrycategories'])){
						$categories_options[$i]['subcategories'][$j]['def'] = 1;
					}else{
						$categories_options[$i]['subcategories'][$j]['def'] = 0;
					}
				}
			}
			unset($_SESSION['entrycategoriesdata']);
			unset($_SESSION['entrycategories']);
		}

		$smarty->assign(array(
				"show_preview" => $show_preview,
				"title_preview" => $preview['title'],
				"entry_text_preview" => $preview['entry_text'],
				"L_POSTED_ON" => $lang['Posted_on'],
				"date_preview" => $preview['date'],
				"L_POSTED_BY" => $lang['Posted_by'],
				"username_preview" => $session->username,
				"L_CREATE_ENTRY_TITLE" => $lang['Create_entry_title'],
				"L_TITLE" => $lang['Title'],
				"L_ACCESS" => $lang['Access'],
				"L_CATEGORIES" => $lang['Categories'],
				"L_ENTRY" => $lang['Entry'],
				"picture_options" => $pictures,
				"pictures_selected" => $pictures['default'],
				"journalnessConfig_allow_uploads" => $journalnessConfig_allow_uploads,
				"L_UPLOAD_IMAGE" => $lang['Upload_image'],
				"L_SUBMIT" => $lang['Submit'],
				"L_PREVIEW" => $lang['Preview'],
				"entry_text_value" => $preview['entry_text_original'],
				"title_value" => $preview['title'],
				"show_create_entry" => "true",
				"access_options" => $access_opts,
				"access_selected" => $_POST['access'],
				"categories_options" => $categories_options)
		);
	}elseif(isset($_SESSION['entrysuccess'])){
		if($_SESSION['entrysuccess']){

		}else{
			// Problem occured
		}
		unset($_SESSION['entrysuccess']);
	}else{
		$pictures = $entry->getPictures();

		$access_opts = NULL;
		if($session->is_admin){
			$access_opts = array(0 => $lang['Public'], 1 => $lang['Registered'], 2 => $lang['Admin']);
		}elseif($session->logged_in){
			$access_opts = array(0 => $lang['Public'], 1 => $lang['Registered']);
		}

		$access_selected = $form->value("access");
		if(empty($access_selected)){
			$access_selected = 0;
		}

		$categories_options = $categories->getEntryCategories();

		if(isset($_SESSION['entrycategoriesdata'])){
			for($i=0; $i<count($categories_options); $i++){
				if(empty($_SESSION['entrycategories'])){
					$categories_options[$i]['def'] = 0;
				}elseif(in_array($categories_options[$i]['id'], $_SESSION['entrycategories'])){
					$categories_options[$i]['def'] = 1;
				}else{
					$categories_options[$i]['def'] = 0;
				}

				for($j=0; $j<count($categories_options[$i]['subcategories']); $j++){
					if(empty($_SESSION['entrycategories'])){
						$categories_options[$i]['subcategories'][$j]['def'] = 0;
					}elseif(in_array($categories_options[$i]['subcategories'][$j]['id'], $_SESSION['entrycategories'])){
						$categories_options[$i]['subcategories'][$j]['def'] = 1;
					}else{
						$categories_options[$i]['subcategories'][$j]['def'] = 0;
					}
				}
			}
			unset($_SESSION['entrycategoriesdata']);
			unset($_SESSION['entrycategories']);
		}

		$smarty->assign(array(
			"picture_options" => $pictures,
			"pictures_selected" => $pictures['default'],
			"journalnessConfig_allow_uploads" => $journalnessConfig_allow_uploads,
			"L_CREATE_ENTRY_TITLE" => $lang['Create_entry_title'],
			"L_TITLE" => $lang['Title'],
			"L_ENTRY" => $lang['Entry'],
			"L_ACCESS" => $lang['Access'],
			"L_CATEGORIES" => $lang['Categories'],
			"L_UPLOAD_IMAGE" => $lang['Upload_image'],
			"L_PREVIEW" => $lang['Preview'],
			"L_SUBMIT" => $lang['Submit'],
			"show_create_entry" => "true",
			"num_errors" => $form->num_errors,
			"title_value" => $form->value("title"),
			"title_error" => $form->error("title"),
			"entry_text_value" => $form->value("entry_text"),
			"entry_text_error" => $form->error("entry_text"),
			"access_options" => $access_opts,
			"access_selected" => $access_selected,
			"categories_options" => $categories_options)
		);
	}
}elseif($session->useraccess < $journalnessConfig_post_level){
	$smarty->assign(array(
			"show_not_allowed" => "true",
			"L_NOT_ALLOWED" => $lang['Not_allowed'])
	);
}else{
	$smarty->assign(array(
			"show_not_logged_in" => "true",
			"L_NOT_LOGGED_IN" => $lang['Not_logged_in'],
			"L_LOGIN_LINK" => $lang['Login_link'])
	);
}

$smarty->display("$theme/entry.tpl");

?>
