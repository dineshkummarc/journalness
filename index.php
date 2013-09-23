<?php

require_once( 'common.inc.php' );

$parts = explode("&", $_SERVER['QUERY_STRING']);

if(!empty($parts[0])){
	$entries = $entry->getEntries($parts[0]);
	$showall = false;
}else{
	$entries = $entry->getEntries();
	$numentries = $entry->numEntries();
	$showall = true;
	if($numentries == $journalnessConfig_newest_entries){
		$showall = false;
	}
}

if(count($entries) < 1){
	$smarty->assign(array(
		"show_no_entries" => "true",
		"L_NO_ENTRIES" => $lang['No_entries'])
	);
}else{
	$smarty->assign(array(
			"entries" => $entries,
			"showall" => $showall,
			"L_POSTED" => $lang['Posted'],
			"L_POSTED_ON" => $lang['Posted_on'],
			"L_POSTED_IN" => $lang['Posted_in'],
			"L_EDITED_ON" => $lang['Edited_on'],
			"L_POSTED_BY" => $lang['Posted_by'],
			"L_COMMENTS" => $lang['Comments'],
			"L_COMMENTS_DISABLED" => $lang['Comments_disabled'],
			"journalnessConfig_allow_comments" => $journalnessConfig_allow_comments,
			"VIEWALL" => $lang['Viewall'])
	);
}

$smarty->display("$theme/index.tpl");


?>