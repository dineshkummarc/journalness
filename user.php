<?php

require_once( 'common.inc.php' );
require_once( 'includes/images.class.php' );

if($session->logged_in){

	if(isset($_GET['mode'])){
		$mode = $_GET['mode'];
	}else{
		$mode = "clipboard";
	}

	if($mode == "signature"){
		$msg = "";

		if(isset($_POST['submit'])){
			$signature = $_POST['signature'];
			$users->updateSignature($signature);
			$msg = "Profile updated";
		}

		$signature = $users->getSignature();

		$smarty->assign(array(
			"sig_html" => $signature['html'],
			"sig_data" => $signature['text'],
			"L_SIG_TITLE" => $lang['Sig_title'],
			"L_UPDATE" => $lang['Update'],
			"L_CURRENT_SIG" => $lang['Current_sig'],
			"msg" => $msg,
			"show_user_links" => "true",
			"show_signature" => "true")
		);
	}elseif($mode == "clipboard"){
		$msg = "";

		if(isset($_POST['submit'])){
			$clipboard = $_POST['clipboard'];
			$users->updateClipboard($clipboard);
			$msg = "Clipboard updated";
		}

		$clipboard = $users->getClipboard();

		$smarty->assign(array(
			"clip_data" => $clipboard,
			"L_TITLE" => $lang['My_panel_title'],
			"L_CLIP_TITLE" => $lang['Clip_title'],
			"L_INFO" => $lang['Clip_info'],
			"L_UPDATE" => $lang['Update'],
			"msg" => $msg,
			"show_main_page" => "true",
			"show_clipboard" => "true",
			"show_user_links" => "true")
		);

	}elseif($mode == "massdelete"){

		if(isset($_POST['delete_selected'])){
			if(isset($_POST['id'])){
				$result = $entry->removeEntries($_POST['id']);
				if($result){
					$msg = $lang['Selected_entries_removed'];
				}
			}
		}

		if(!empty($_GET['offset'])){
			$offset = intval($_GET['offset']);
		}else{
			$offset = '0';
		}

		if(!empty($_GET['limit'])){
			$limit  = intval($_GET['limit']);
		}else{
			$limit  = $journalnessConfig_list_limit;
		}

		$numEntries = $entry->getNumUserEntries();

		if(isset($_GET['showall']) && $numEntries > 0){
			$limit = $numEntries;
		}

		$entrieslist = $entry->getUserEntriesList($offset, $limit);

		// Create pagination
		require_once( 'includes/pagination.class.php' );
		$pagination = new Pagination($numEntries, $offset, $limit);

		$link = "user.php?mode=massdelete";
		$pageLinks = $pagination->getPageLinks($link);
		$pageCounter = $pagination->getPageCounter();

		$smarty->assign(array(
			"show_mass_delete" => "true",
			"show_user_links" => "true",
			"L_DELETE_SELECTED" => $lang['Delete_selected'],
			"L_TITLE" => $lang['Past_title'],
			"L_DATE" => $lang['Posted_on'],
			"L_PREVIEW" => $lang['Preview'],
			"L_USER" => $lang['User'],
			"L_COMMENTS" => $lang['Comments'],
			"L_VIEWS" => $lang['Views'],
			"entries" => $entrieslist,
			"pageLinks" => $pageLinks,
			"pageCounter" => $pageCounter,
			"L_SHOW_ALL_ENTRIES" => $lang['Show_all_entries'])
		);
	}elseif($mode == "imagemanager"){
		$msg = NULL;
		if(isset($_GET['msg'])){
			$msg = $_GET['msg'];
		}

		if(isset($_POST['edit_submit'])){
			$images->saveImageInfo($_POST['id'], $_POST['image_name']);

			if ($result != false) {
				header( 'Location: user.php?mode=imagemanager&msg=' . $lang['Image_data_saved'] );
				exit;
			} else {
				header( 'Location: user.php?mode=imagemanager&msg=' . $lang['Image_data_not_saved'] );
				exit;
			}
		}elseif(isset($_POST['delete_submit'])){
			$images->deleteImage($_POST['id']);

			if ($result != false) {
				header( 'Location: user.php?mode=imagemanager&msg=' . $lang['Image_removed'] );
				exit;
			} else {
				header( 'Location: user.php?mode=imagemanager&msg=' . $lang['Image_not_removed'] );
				exit;
			}
		}

		if(isset($_GET['edit'])){
			$pid = intval($_GET['edit']);

			$image_info = $images->getImageInfo($pid);	

			$smarty->assign(array(
					"showedit" => "true",
					"show_user_links" => "true",
					"L_EDIT_IMAGE" => $lang['Edit_image'],
					"L_IMAGE_NAME" => $lang['Image_name'],
					"L_SAVE_IMAGE" => $lang['Save_image'],
					"image_info" => $image_info)
			);
		}elseif(isset($_GET['delete'])){
			$pid = intval($_GET['delete']);

			$image_info = $images->getImageInfo($pid);

			$smarty->assign(array(
					"MSG" => $lang['Confirm_delete_image'],
					"showdelete" => "true",
					"show_user_links" => "true",
					"L_DELETE_IMAGE" => $lang['Delete_image'],
					"L_IMAGE_NAME" => $lang['Image_name'],
					"image_info" => $image_info)
			);
		}else{
			$image_list = $images->getUploads();

			$smarty->assign(array(
				"msg" => $msg,
				"show_image_manager" => "true",
				"show_user_links" => "true",
				"L_IMAGE_MANAGER" => $lang['Image_manager'],
				"L_BROWSE_USER_IMAGES" => $lang['Browse_user_images'],
				"image_list" => $image_list)
			);
		}
	}

}else{
	$smarty->assign(array(
		"show_not_logged_in" => "true",
		"L_NOT_LOGGED_IN" => $lang['Not_logged_in'],
		"L_LOGIN_LINK" => $lang['Login_link'])
	);
}

$smarty->display("$theme/userpanel.tpl");

?>