<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/category.class.php' );

$msg = NULL;
if(isset($_GET['msg'])){
	$msg = $_GET['msg'];
}

$mode = NULL;
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
}

if(isset($_POST['add_category_submit']) && !empty($_POST['category_name'])){
	$result = $categories->addEntryCategory($_POST['category_name'], $_POST['category_parent'], $_POST['category_description']);
}elseif(isset($_POST['default_category_submit']) && !empty($_POST['category_default'])){
	$result = $categories->setDefaultEntryCategory($_POST['category_default']);
}elseif(isset($_POST['not_default_category_submit']) && !empty($_POST['category_default'])){
	$result = $categories->setNotDefaultEntryCategory($_POST['category_default']);
}elseif(isset($_POST['delete_cat_submit'])){
	$result = $categories->removeEntryCategory($_POST['id']);
}elseif(isset($_POST['edit_cat_submit'])){
	$result = $categories->editEntryCategory($_POST['id'], $_POST['category_name'], $_POST['category_parent'], $_POST['category_description']);
}

if($mode == "edit"){
	$categorydata = $categories->getEntryCategoryData($_GET['catid']);
	$parent_options = $categories->getParentEntryCategories($categorydata['id']);

	$smarty->assign(array(
		"showedit" => "true",
		"L_EDIT_CATEGORY" => $lang['Edit_category'],
		"L_CATEGORY_NAME" => $lang['Category_name'],
		"L_CATEGORY_PARENT" => $lang['Category_parent'],
		"L_CATEGORY_DESCRIPTION" => $lang['Category_description'],
		"L_OPTIONAL" => $lang['Optional'],
		"L_SAVE_CATEGORY" => $lang['Save_category'],
		"parent_options" => $parent_options,
		"category" => $categorydata)
	);
}elseif($mode == "delete"){
	$smarty->assign(array(
		"showdelete" => "true",
		"L_DELETE_CATEGORY" => $lang['Delete_category'],
		"L_CATEGORY_NAME" => $lang['Category_name'],
		"L_CATEGORY_PARENT" => $lang['Category_parent'],
		"L_CATEGORY_DESCRIPTION" => $lang['Category_description'],
		"category" => $categories->getEntryCategoryData($_GET['catid']))
	);
}else{

	$category_list = $categories->getEntryCategories();

	$smarty->assign(array(
		"MSG" => $msg,
		"show_category_manager" => "true",
		"L_ENTRY_CATEGORY_MANAGER" => $lang['Entry_category_manager'],
		"L_SAVE_ORDERING" => $lang['Save_ordering'],
		"L_DELETE_NOTICE" => $lang['Delete_notice'],
		"L_CATEGORY_NAME" => $lang['Category_name'],
		"L_CATEGORY_PARENT" => $lang['Category_parent'],
		"L_CATEGORY_DESCRIPTION" => $lang['Category_description'],
		"L_OPTIONAL" => $lang['Optional'],
		"L_ADD_CATEGORY" => $lang['Add_category'],
		"L_CATEGORY_ID" => $lang['Category_id'],
		"L_CATEGORY_DEFAULT" => $lang['Category_default'],
		"L_CATEGORY_NUM_ENTRIES" => $lang['Category_num_entries'],
		"L_CATEGORY_ORDERING" => $lang['Category_ordering'],
		"L_ORDERING_SAVED" => $lang['Ordering_saved'],
		"category_list" => $category_list,
		"parent_options" => $categories->getParentEntryCategories(),
		"L_DEFAULT_CATEGORY" => $lang['Default_category'],
		"L_SET_DEFAULT" => $lang['Set_default'],
		"L_SET_NOT_DEFAULT" => $lang['Set_not_default'],
		"default_options" => $categories->getDefaultEntryCategories())
	);
}


$smarty->display("$theme/entrycategorymanager.tpl");

?>