<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class DBMaintenance {

	function DBMaintenance(){

	}

	function optimize_mysql($tablename){
		global $database;

		$query = "OPTIMIZE TABLE " . $tablename;
		$result = $database->Execute($query);

		return $result;
	}

	function optimize_postgresql($tablename){
		global $database;

		$query = "VACUUM ANALYZE " . $tablename;
		$result = $database->Execute($query);

		return $result;
	}
}

$dbmaintenance = new DBMaintenance();

?>