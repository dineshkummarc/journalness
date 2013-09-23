<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/category.class.php' );

$mode = "";
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
}

if($mode == "edit"){

	if(isset($_POST['edit_cat_submit'])){
		$result = $categories->saveCategory($_POST['id'], $_POST['title'], $_POST['access'], $_POST['visible']);

		if($result){
			header("Location: categorymanager.php?msg=" . $lang['Category_saved']);
		}else{
			header("Location: categorymanager.php?msg=" . $lang['Category_not_saved']);
		}
	}elseif(isset($_POST['edit_link_submit'])){
		$result = $categories->saveLink($_POST['id'], $_POST['title'], $_POST['url'], $_POST['incategory'], $_POST['access'], $_POST['visible']);

		if($result){
			header("Location: categorymanager.php?msg=" . $lang['Link_saved']);
		}else{
			header("Location: categorymanager.php?msg=" . $lang['Link_not_saved']);
		}
	}elseif(isset($_GET['catid'])){

		$category = $categories->getCategory($_GET['catid']);

		$smarty->assign(array(
			"showedit" => "true",
			"L_EDIT_CATEGORY" => $lang['Edit_category'],
			"category" => $category,
			"L_TITLE" => $lang['Category_title'],
			"L_ACCESS" => $lang['Category_access'],
			"L_VISIBLE" => $lang['Category_visible'],
			"access_options" => array(0 => $lang['Public'], 1 => $lang['Registered'], 2 => $lang['Admin']),
			"access_selected" => $category['access'],
			"visible_options" => array(1 => $lang['Yes'], 0 => $lang['No']),
			"visible_selected" => $category['visible'],
			"L_SAVE_CATEGORY" => $lang['Save_category'])
		);

	}elseif(isset($_GET['linkid'])){

		$link = $categories->getLink($_GET['linkid']);
		$categorylist = $categories->getCategoriesList();

		$smarty->assign(array(
			"showedit" => "true",
			"L_EDIT_LINK" => $lang['Edit_link'],
			"link" => $link,
			"L_TITLE" => $lang['Category_title'],
			"L_URL" => $lang['Category_url'],
			"L_IN_CATEGORY" => $lang['In_category'],
			"incategory_options" => $categorylist,
			"incategory_selected" => $link['catid'],
			"L_ACCESS" => $lang['Category_access'],
			"L_VISIBLE" => $lang['Category_visible'],
			"access_options" => array(0 => $lang['Public'], 1 => $lang['Registered'], 2 => $lang['Admin']),
			"access_selected" => $link['access'],
			"visible_options" => array(1 => $lang['Yes'], 0 => $lang['No']),
			"visible_selected" => $link['visible'],
			"L_SAVE_LINK" => $lang['Save_link'])
		);


	}

}elseif($mode == "add"){

	if(isset($_POST['add_cat_submit'])){
		$result = $categories->addCategory($_POST['title'], $_POST['access'], $_POST['visible']);

		if($result){
			header("Location: categorymanager.php?msg=" . $lang['Category_added']);
		}else{
			header("Location: categorymanager.php?msg=" . $lang['Category_not_added']);
		}
	}elseif(isset($_POST['add_link_submit'])){
		$result = $categories->addLink($_POST['title'], $_POST['url'], $_POST['incategory'], $_POST['access'], $_POST['visible']);

		if($result){
			header("Location: categorymanager.php?msg=" . $lang['Link_added']);
		}else{
			header("Location: categorymanager.php?msg=" . $lang['Link_not_added']);
		}
	}

}elseif($mode == "delete"){

	if(isset($_POST['delete_cat_submit'])){
		$result = $categories->deleteCategory($_POST['id']);

		if($result){
			header("Location: categorymanager.php?msg=" . $lang['Category_deleted']);
		}else{
			header("Location: categorymanager.php?msg=" . $lang['Category_not_deleted']);
		}
	}elseif(isset($_POST['delete_link_submit'])){
		$result = $categories->deleteLink($_POST['id']);

		if($result){
			header("Location: categorymanager.php?msg=" . $lang['Link_deleted']);
		}else{
			header("Location: categorymanager.php?msg=" . $lang['Link_not_deleted']);
		}
	}elseif(isset($_GET['catid'])){

		$category = $categories->getCategory($_GET['catid']);

		$smarty->assign(array(
			"MSG" => $lang['Confirm_delete_cat'],
			"showdelete" => "true",
			"L_DELETE_CATEGORY" => $lang['Delete_category'],
			"category" => $category,
			"L_TITLE" => $lang['Category_title'],
			"L_ACCESS" => $lang['Category_access'],
			"L_VISIBLE" => $lang['Category_visible'])
		);

	}elseif(isset($_GET['linkid'])){

		$link = $categories->getLink($_GET['linkid']);
		$categorylist = $categories->getCategoriesList();
		$link['category'] = $categorylist[$link['catid']];

		$smarty->assign(array(
			"MSG" => $lang['Confirm_delete_link'],
			"showdelete" => "true",
			"L_DELETE_LINK" => $lang['Delete_link'],
			"link" => $link,
			"L_TITLE" => $lang['Category_title'],
			"L_URL" => $lang['Category_url'],
			"L_IN_CATEGORY" => $lang['In_category'],
			"L_ACCESS" => $lang['Category_access'],
			"L_VISIBLE" => $lang['Category_visible'],
			"L_SAVE_LINK" => $lang['Save_link'])
		);


	}

}else{

	$msg = "";
	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];
	}

	$category_list = $categories->getCategories();

	$smarty->assign(array(
		"showmainpage" => "true",
		"MSG" => $msg,
		"L_CATEGORY_MANAGER" => $lang['Category_manager'],
		"L_DRAG_AND_DROP_ORDERING" => $lang['Drag_and_drop_ordering'],
		"L_SAVE_ORDERING" => $lang['Save_ordering'],
		"category_list" => $category_list,
		"L_CATEGORY_ID" => $lang['Category_id'],
		"L_CATEGORY_TITLE" => $lang['Category_title'],
		"L_CATEGORY_URL" => $lang['Category_url'],
		"L_CATEGORY_ACCESS" => $lang['Category_access'],
		"L_CATEGORY_VISIBLE" => $lang['Category_visible'],
		"L_CATEGORY_ORDERING" => $lang['Category_ordering'],
		"L_CATEGORY_LINKS" => $lang['Category_links'],
		"L_IN_CATEGORY" => $lang['In_category'],
		"L_VIEW_LINKS" => $lang['View_links'],
		"L_ORDERING_SAVED" => $lang['Ordering_saved'],
		"L_PUBLIC" => $lang['Public'],
		"L_REGISTERED" => $lang['Registered'],
		"L_ADMIN" => $lang['Admin'],
		"L_ADD_CATEGORY" => $lang['Add_category'],
		"L_ADD_LINK" => $lang['Add_link'],
		"incategory_options" => $categories->getCategoriesList(),
		"access_options" => array(0 => $lang['Public'], 1 => $lang['Registered'], 2 => $lang['Admin']),
		"visible_options" => array(1 => $lang['Yes'], 0 => $lang['No']))
	);
}

$smarty->display("$theme/categorymanager.tpl");

?>

