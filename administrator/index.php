<?php

require_once( 'common.admin.inc.php' );

if(isset($_GET['mode'])){
	if($_GET['mode'] == "resethitcount"){
		$stats->resetHitCount();
	}
}

$totalentries = $information->getNumRows("entries");
$totalusers = $information->getNumRows("users");
$totalcomments = $information->getNumRows("comments");
$dbsize = $information->getDBSize();
$uploadtablesize = $information->getUploadTableSize();
$uploadfoldersize = $information->getUploadFolderSize();
$php_version = phpversion();
$database_version = $information->getDatabaseVersion();

$smarty->assign(array(
		"show_main_page" => "true",
		"L_WELCOME" => $lang['Welcome'],
		"L_SUBMIT" => $lang['Submit'],
		"L_STATISTICS_TITLE" => sprintf($lang['Statistics_title'], $journalnessConfig_sitename),
		"L_TOTAL_JOURNAL_POSTS" => $lang['Total_journal_posts'],
		"TOTAL_JOURNAL_POSTS" => $totalentries,
		"L_TOTAL_COMMENTS" => $lang['Total_comments'],
		"TOTAL_COMMENTS" => $totalcomments,
		"L_TOTAL_USERS" => $lang['Total_users'],
		"TOTAL_USERS" => $totalusers,
		"L_TOTAL_TABLE_SIZE" => $lang['Total_table_size'],
		"TOTAL_TABLE_SIZE" => $dbsize,
		"L_PHP_VER" => $lang['PHP_version'],
		"PHP_VER" => $php_version,
		"L_J_VER" => $lang['Journalness_version'],
		"J_VER" => $version,
		"L_DB_INFO" => $lang['DB_type'],
		"DB_INFO" => $database_version,
		"L_UPLOAD_FOLDER_SIZE" => $lang['Upload_folder_size'],
		"UPLOAD_FOLDER_SIZE" => $uploadfoldersize,
		"L_DB_UPLOAD_SIZE" => $lang['DB_upload_size'],
		"DB_UPLOAD_SIZE" => $uploadtablesize,
		"L_HIT_COUNT" => $lang['Hit_count'],
		"L_RESET" => $lang['Reset'],
		"HIT_COUNT" => $stats->getHitCount())
);

$smarty->display("$theme/index.tpl");

?>