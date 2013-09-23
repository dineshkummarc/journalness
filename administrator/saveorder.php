<?php

require_once( 'common.admin.inc.php' );

$section_ordering = 1;
foreach($_POST as $key => $var){
	if(strspn("category", $key)){
		$catid = explode("_", $key);
		$catid = $catid[1];

		$link_ordering = 1;
		foreach($_POST[$key] as $link_id){

			$query = "UPDATE #__links SET ordering = '" . $link_ordering . "', catid = '" . $catid . "' WHERE id = '" . $link_id . "'";
			$database->Execute($query);

			$link_ordering++;
		}

		$query = "UPDATE #__categories SET ordering = '" . $section_ordering . "' WHERE id = '" . $catid . "'";
		$database->Execute($query);

		$section_ordering++;
	}
}

?>