<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/images.class.php' );

if(isset($_POST['edit_submit'])){
	$images->saveImageInfo($_POST['id'], $_POST['image_name']);

	if ($result != false) {
		header( 'Location: imagemanager.php?uid=' . $_POST['uid'] . '&msg=' . $lang['Image_data_saved'] );
		exit;
	} else {
		header( 'Location: imagemanager.php?uid=' . $_POST['uid'] . '&msg=' . $lang['Image_data_not_saved'] );
		exit;
	}
}elseif(isset($_POST['delete_submit'])){
	$images->deleteImage($_POST['id']);

	if ($result != false) {
		header( 'Location: imagemanager.php?uid=' . $_POST['uid'] . '&msg=' . $lang['Image_removed'] );
		exit;
	} else {
		header( 'Location: imagemanager.php?uid=' . $_POST['uid'] . '&msg=' . $lang['Image_not_removed'] );
		exit;
	}
}

if(isset($_GET['edit'])){
	$pid = intval($_GET['edit']);

	$image_info = $images->getImageInfo($pid);	

	$smarty->assign(array(
			"showedit" => "true",
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
			"L_DELETE_IMAGE" => $lang['Delete_image'],
			"L_IMAGE_NAME" => $lang['Image_name'],
			"image_info" => $image_info)
	);
}else{

	$msg = "";
	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];
	}

	$uid = 0;
	if(isset($_GET['uid'])){
		$uid = $_GET['uid'];
	}

	$image_list = $images->getUploads($uid);

	$smarty->assign(array(
		"MSG" => $msg,
		"showimages" => "true",
		"L_IMAGE_MANAGER" => $lang['Image_manager'],
		"image_list" => $image_list,
		"viewing_user" => $uid,
		"L_BROWSE_IMAGE_UPLOADS" => $lang['Browse_image_uploads'])
	);
}

$smarty->display("$theme/imagemanager.tpl");

?>