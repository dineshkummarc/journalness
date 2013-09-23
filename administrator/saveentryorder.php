<?php

require_once( 'common.admin.inc.php' );

$section_ordering = 1;

foreach($_POST as $key => $var){
	if(strspn("category", $key)){
		$catid = explode("_", $key);
		$catid = $catid[1];

		$subcat_ordering = 1;
		foreach($_POST[$key] as $subcat_id){

			$query = "UPDATE #__entry_categories SET ordering = '" . $subcat_ordering . "', parent = '" . $catid . "' WHERE id = '" . $subcat_id . "'";
			$database->Execute($query);

			$subcat_ordering++;
		}

		$query = "UPDATE #__entry_categories SET ordering = '" . $section_ordering . "' WHERE id = '" . $catid . "'";
		$database->Execute($query);

		$section_ordering++;
	}
}

?>