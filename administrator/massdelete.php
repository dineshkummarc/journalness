<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/entry.class.php' );

$msg = NULL;

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

$numEntries = $entry->getNumEntriesList();

if(isset($_GET['showall']) && $numEntries > 0){
	$limit = $numEntries;
}

$entrieslist = $entry->getEntriesList($offset, $limit);

// Create pagination
require_once( 'includes/pagination.class.php' );
$pagination = new Pagination($numEntries, $offset, $limit);

$link = "massdelete.php?";
$pageLinks = $pagination->getPageLinks($link);
$pageCounter = $pagination->getPageCounter();

$smarty->assign(array(
		"MSG" => $msg,
		"show_mass_delete" => "true",
		"L_MASS_ENTRY_DELETION" => $lang['Mass_entry_deletion'],
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


$smarty->display("$theme/massdelete.tpl");

?>
