<?php

require_once( 'common.inc.php' );

if($session->logged_in){

	if(isset($_POST['submit'])){

      	$returnval = $entry->addComment($_POST['entryid'], $_POST['title'], $_POST['comment_text']);
     
      	if($returnval > 0){
         		header("Location: past.php?id=" . $_POST['entryid'] . "#c" . $returnval);
      	}elseif($returnval == 0){
         		$_SESSION['value_array'] = $_POST;
         		$_SESSION['error_array'] = $form->getErrorArray();
         		header("Location: past.php?id=" . $_POST['entryid'] . "#addcomment");
      	}elseif($returnval == -1){
         		$_SESSION['commentsuccess'] = false;
         		header("Location: past.php?id=" . $_POST['entryid'] . "#addcomment");
      	}
	}elseif(isset($_SESSION['commentsuccess'])){
		if($_SESSION['commentsuccess']){

		}else{
			// Problem occured
		}
		unset($_SESSION['commentsuccess']);
	}else{
		$pictures = $entry->getPictures();

		$smarty->assign(array(
			"picture_options" => $pictures,
			"pictures_selected" => $pictures['default'],
			"L_CREATE_ENTRY_TITLE" => $lang['Create_entry_title'],
			"L_TITLE" => $lang['Title'],
			"L_ENTRY" => $lang['Entry'],
			"L_UPLOAD_IMAGE" => $lang['Upload_image'],
			"L_PREVIEW" => $lang['Preview'],
			"L_SUBMIT" => $lang['Submit'],
			"show_create_entry" => "true",
			"num_errors" => $form->num_errors,
			"title_value" => $form->value("title"),
			"title_error" => $form->error("title"),
			"entry_text_value" => $form->value("entry_text"),
			"entry_text_error" => $form->error("entry_text"))
		);
	}
}else{
	$smarty->assign(array(
			"show_not_logged_in" => "true",
			"L_NOT_LOGGED_IN" => $lang['Not_logged_in'],
			"L_LOGIN_LINK" => $lang['Login_link'])
	);
}

$smarty->display("$theme/entry.tpl");

?>