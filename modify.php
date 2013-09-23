<?php

require_once( 'common.inc.php' );

if($session->logged_in){
	$entryData = NULL;

	$mode = "edit";
	if(isset($_GET['mode'])){
		$mode = $_GET['mode'];
	}

	if(isset($_REQUEST['id']) && $mode != "edit_comment" && !isset($_POST['edit_comment_submit']) && $mode != "delete_comment" && !isset($_POST['delete_comment_submit'])){
		$entryData = $entry->getEntry($_REQUEST['id'], 1);
	}else{
		$entryData = $entry->getEntry($_REQUEST['entryid'], 1);
	}

	if($entryData['uid'] == $session->uid || $session->is_admin){

		if(isset($_POST['edit_comment_submit'])){
      		$returnval = $entry->editComment($_POST['id'], $_POST['entryid'], $_POST['title'], $_POST['comment_text']);

      		if($returnval == 0){
				header("Location: past.php?id=" . $_POST['entryid'] . "#c" . $_POST['id']);
			}elseif($returnval == 1){
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				header("Location: modify.php?id=" . $_POST['entryid'] . "&mode=edit_comment");
			}elseif($returnval == 2){
				$_SESSION['editcommentsuccess'] = false;
				header("Location: modify.php?id=" . $_POST['entryid']);
			}
		}elseif(isset($_SESSION['editcommentsuccess'])){
			unset($_SESSION['editcommentsuccess']);
		}elseif(isset($_POST['edit_submit'])){
      		$returnval = $entry->editEntry($_POST['id'], $_POST['title'], $_POST['entry_text'], $_POST['access'], $_POST['entrycategories']);
     
      		if($returnval == 0){
				$_SESSION['editsuccess'] = true;
				header("Location: modify.php?id=" . $_POST['id']);
			}elseif($returnval == 1){
				$_SESSION['value_array'] = $_POST;
				$_SESSION['error_array'] = $form->getErrorArray();
				$_SESSION['entrycategories'] = $_POST['entrycategories'];
				$_SESSION['entrycategoriesdata'] = 1;
				header("Location: modify.php?id=" . $_POST['id'] . "&mode=edit");
			}elseif($returnval == 2){
				$_SESSION['editsuccess'] = false;
				header("Location: modify.php?id=" . $_POST['id']);
			}
		}elseif(isset($_SESSION['editsuccess'])){
			unset($_SESSION['editsuccess']);
			header("Location: past.php?id=" . $_REQUEST['id']);
		}elseif(isset($_POST['edit_preview'])){
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

			$title = $_POST['title'];
			$entry_text = $_POST['entry_text'];

			$access_opts = NULL;
			if($session->is_admin){
				$access_opts = array(0 => $lang['Public'], 1 => $lang['Registered'], 2 => $lang['Admin']);
			}elseif($session->logged_in){
				$access_opts = array(0 => $lang['Public'], 1 => $lang['Registered']);
			}

			$access_selected = $_POST['access'];
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
					"pictures" => $pictures['default'],
					"journalnessConfig_allow_uploads" => $journalnessConfig_allow_uploads,
					"show_modify_entry" => "true",
					"show_preview" => $show_preview,
					"id" => $_REQUEST['id'],
					"entry_text_preview" => $preview['entry_text'],
					"title_preview" => $preview['title'],
					"orig_title_value" => $entryData['title'],
					"date" => $preview['date'],
					"date_preview" => $preview['date'],
					"username_preview" => $session->username,
					"num_errors" => $form->num_errors,
					"title_value" => $title,
					"entry_text_value" => $entry_text,
					"access_options" => $access_opts,
					"access_selected" => $access_selected,
					"L_POSTED_ON" => $lang['Posted_on'],
					"L_POSTED_BY" => $lang['Posted_by'],
					"L_EDITING_ENTRY" => $lang['Editing_entry'],
					"L_ENTERED_ON" => $lang['Entered_on'],
					"L_TITLE" => $lang['Title'],
					"L_ENTRY" => $lang['Entry'],
					"L_UPLOAD_IMAGE" => $lang['Upload_image'],
					"L_ACCESS" => $lang['Access'],
					"L_CATEGORIES" => $lang['Categories'],
					"L_PREVIEW_CHANGES" => $lang['Preview_changes'],
					"L_PREVIEW" => $lang['Preview'],
					"L_SUBMIT_CHANGES" => $lang['Submit_changes'],
					"L_GO_BACK" => $lang['Go_back'],
					"categories_options" => $categories_options)
			);
		}elseif(isset($_POST['delete_submit'])){
			$result = $entry->removeEntry($_POST['id']);
			$smarty->assign(array(
					"show_main_page" => "true",
					"show_entry_deleted" => "true",
					"L_ENTRY_DELETED" => sprintf($lang['Entry_deleted'], $entryData['title']),
					"L_RETURN_TO_INDEX" => $lang['Return_to_index'])
			);
		}elseif(isset($_POST['delete_comment_submit'])){
			$result = $entry->removeComment($_POST['id'], $_POST['entryid']);
			$smarty->assign(array(
					"show_main_page" => "true",
					"show_comment_deleted" => "true",
					"L_RETURN_TO_COMMENTS" => sprintf($lang['Return_to_comments'], "<a href=\"past.php?id=" . $_POST['entryid'] . "#comments\">", "Go back to entry", "</a>"),
					"L_COMMENT_DELETED" => $lang['Comment_deleted'])
					);
		}elseif($mode == "delete"){
			$smarty->assign(array(
					"show_main_page" => "true",
					"show_delete_entry" => "true",
					"id" => $entryData['id'],
					"L_DELETE_CONFIRMATION" => sprintf($lang['Delete_confirmation'], $entryData['title']),
					"L_DELETE" => $lang['Delete'],
					"L_GO_BACK" => $lang['Go_back'])
			);
		}elseif($mode == "delete_comment"){
			$smarty->assign(array(
					"show_confirm_delete_comment" => "true",
					"L_COMMENT_DELETE_CONFIRMATION" => $lang['Comment_delete_confirmation'],
					"id" => $_REQUEST['id'],
					"entryid" => $_REQUEST['entryid'],
					"L_DELETE" => $lang['Delete'],
					"L_GO_BACK" => $lang['Go_back'])
			);
		}elseif($mode == "edit_comment"){
			$id = $form->value("id");
			if(empty($id)){
				$id = $_REQUEST['id'];
			}
			$commentData = $entry->getComment($id, 1);

			$title = $form->value("title");
			$title_error = $form->error("title");
			if(empty($title) && empty($title_error)){
				$title = $commentData['title'];
			}

			$comment_text = $form->value("comment_text");
			$comment_text_error = $form->error("comment_text");
			if(empty($comment_text) && empty($comment_text_error)){
				$comment_text = $commentData['comment_text'];
			}

			$smarty->assign(array(
					"show_modify_comment" => "true",
					"L_EDITING_COMMENT" => $lang['Editing_comment'],
					"L_ENTERED_ON" => $lang['Entered_on'],
					"L_TITLE" => $lang['Title'],
					"L_COMMENT" => $lang['Comment'],
					"L_SUBMIT_CHANGES" => $lang['Submit_changes'],
					"L_GO_BACK" => $lang['Go_back'],
					"date" => $commentData['date'],
					"entryid" => $commentData['entryid'],
					"id" => $commentData['id'],
					"num_errors" => $form->num_errors,
					"title_value" => $title,
					"orig_title_value" => $commentData['title'],
					"title_error" => $title_error,
					"comment_text_value" => $comment_text,
					"comment_text_error" => $comment_text_error)
			);
		}elseif($mode == "edit"){
			$pictures = $entry->getPictures();

			$title = $form->value("title");
			$title_error = $form->error("title");
			if(empty($title) && empty($title_error)){
				$title = $entryData['title'];
			}

			$entry_text = $form->value("entry_text");
			$entry_text_error = $form->error("entry_text");
			if(empty($entry_text) && empty($entry_text_error)){
				$entry_text = $entryData['entry_text'];
			}

			$access_selected = $form->value("access");
			if(empty($access_selected)){
				$access_selected = $entryData['access'];
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

			$catids = explode(",", $entryData['catids']);
			for($i=0; $i<count($categories_options); $i++){
				$categories_options[$i]['def'] = 0;
				if(in_array($categories_options[$i]['id'], $catids)){
					$categories_options[$i]['def'] = 1;
				}
				for($j=0; $j<count($categories_options[$i]['subcategories']); $j++){
					$categories_options[$i]['subcategories'][$j]['def'] = 0;
					if(in_array($categories_options[$i]['subcategories'][$j]['id'], $catids)){
						$categories_options[$i]['subcategories'][$j]['def'] = 1;
					}
				}
			}

			$smarty->assign(array(
				"picture_options" => $pictures,
				"pictures_selected" => $pictures['default'],
				"journalnessConfig_allow_uploads" => $journalnessConfig_allow_uploads,
				"L_EDITING_ENTRY" => $lang['Editing_entry'],
				"L_ENTERED_ON" => $lang['Entered_on'],
				"L_TITLE" => $lang['Title'],
				"L_ENTRY" => $lang['Entry'],
				"L_ACCESS" => $lang['Access'],
				"L_CATEGORIES" => $lang['Categories'],
				"L_UPLOAD_IMAGE" => $lang['Upload_image'],
				"L_PREVIEW_CHANGES" => $lang['Preview_changes'],
				"L_SUBMIT_CHANGES" => $lang['Submit_changes'],
				"L_GO_BACK" => $lang['Go_back'],
				"L_PREVIEW" => $lang['Preview'],
				"show_modify_entry" => "true",
				"num_errors" => $form->num_errors,
				"id" => $entryData['id'],
				"date" => $entryData['date'],
				"num_errors" => $form->num_errors,
				"title_value" => $title,
				"orig_title_value" => $title,
				"title_error" => $title_error,
				"entry_text_value" => $entry_text,
				"entry_text_error" => $entry_text_error,
				"access_options" => $access_opts,
				"access_selected" => $access_selected,
				"categories_options" => $categories_options)
			);
		}
	}else{
		$smarty->assign(array(
				"show_not_allowed" => "true",
				"L_NOT_ALLOWED" => $lang['Not_allowed'])
		);
	}
}else{
	$smarty->assign(array(
			"show_not_logged_in" => "true",
			"L_NOT_LOGGED_IN_EDIT" => $lang['Not_logged_in_edit'],
			"L_LOGIN_LINK" => $lang['Login_link'])
	);
}

$smarty->display("$theme/modify.tpl");

?>
