<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/dbmaintenance.class.php' );

$msg = NULL;

if(isset($_POST['dbmaintenance_submit'])){

	$tables = array('auth', 'categories', 'comments', 'entries', 'entry_categories', 'links', 'passwordreset', 'sessions', 'stats', 'uploads', 'users');

	for($i = 0; $i < count($tables); $i++) {
		$table_name = $tables[$i];

		if($journalnessConfig_type == "mysql"){
			$result = $dbmaintenance->optimize_mysql($journalnessConfig_dbprefix . $table_name);
		}elseif($journalnessConfig_type == "postgres"){
			$result = $dbmaintenance->optimize_postgresql($journalnessConfig_dbprefix . $table_name);
		}
	}

	$msg = $lang['Database_optimized'];
}

if($journalnessConfig_type == "mysql"){
	$database_type = "MySQL";
}else{
	$database_type = "PostgreSQL";
}

$smarty->assign(array(
		"MSG" => $msg,
		"show_database_maintenance" => "true",
		"L_DATABASE_MAINTENANCE" => $lang['Database_maintenance'],
		"L_DETECTED_DATABASE" => $lang['Detected_database'],
		"database_type" => $database_type,
		"L_OPTIMIZE_DATABASE" => $lang['Optimize_database'])
);


$smarty->display("$theme/databasemaintenance.tpl");

?>