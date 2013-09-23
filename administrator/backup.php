<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/backup.class.php' );

$type = "";
if(isset($_GET['type'])){
	$type = $_GET['type'];
}

if($adminsession->is_super_admin){
	if(isset($_POST['database_backup_submit'])){
		$backup_type = "all";
		if(isset($_POST['backup_type'])){
			$backup_type = $_POST['backup_type'];
		}

		$enable_gzip = false;
		if(isset($_POST['enable_gzip'])){
			if(extension_loaded("zlib")){
				$enable_gzip = true;
			}
		}
		header("Pragma: no-cache");

		$tables = array('auth', 'categories', 'comments', 'entries', 'entry_categories', 'links', 'passwordreset', 'sessions', 'stats', 'uploads', 'users');
		$drop = 0;

		if($enable_gzip){
			@ob_start();
			@ob_implicit_flush(0);
			header("Content-Type: application/x-gzip; name=\"journalness_db_backup.sql.gz\"");
			header("Content-disposition: attachment; filename=journalness_db_backup.sql.gz");
		}else{
			header("Content-Type: text/x-delimtext; name=\"journalness_db_backup.sql\"");
			header("Content-disposition: attachment; filename=journalness_db_backup.sql");
		}

		echo "#\n";
		echo "# Journalness Backup Script\n";
		echo "# Dump of tables for " . $journalnessConfig_dbname . "\n";
		echo "#\n# DATE : " . gmdate("d-m-Y H:i:s", time()) . " GMT\n";
		echo "#\n";

		if($journalnessConfig_type == "postgres"){
			echo "\n" . $backup->pg_get_sequences("\n", $backup_type);
		}
		for($i = 0; $i < count($tables); $i++) {
			$table_name = $tables[$i];

			if ($backup_type != 'data') {
				if($journalnessConfig_type == "mysql"){
					echo "#\n# Table structure for table: " . $journalnessConfig_dbprefix . $table_name . "\n#\n";
					echo $backup->get_table_def_mysql($journalnessConfig_dbprefix . $table_name, "\n", $drop) . "\n";
				}elseif($journalnessConfig_type == "postgres"){
					echo "#\n# Table structure for table: " . $journalnessConfig_dbprefix . $table_name . "\n#\n";
					echo $backup->get_table_def_postgresql($journalnessConfig_dbprefix . $table_name, "\n") . "\n";
				}
			}

			if ($backup_type != 'structure') {
				if($journalnessConfig_type == "mysql"){
					$backup->get_table_content_mysql($journalnessConfig_dbprefix . $table_name, "output_table_content");
				}elseif($journalnessConfig_type == "postgres"){
					$backup->get_table_content_postgresql($journalnessConfig_dbprefix . $table_name, "output_table_content");
				}
			}
		}

		if($enable_gzip){
			$Size = ob_get_length();
			$Crc = crc32(ob_get_contents());
			$contents = gzcompress(ob_get_contents());
			ob_end_clean();
			echo "\x1f\x8b\x08\x00\x00\x00\x00\x00".substr($contents, 0, strlen($contents) - 4).$backup->gzip_PrintFourChars($Crc).$backup->gzip_PrintFourChars($Size);
		}
		exit;

	}elseif(isset($_POST['config_backup_submit'])){
		$enable_gzip = false;
		if(isset($_POST['enable_gzip'])){
			if(extension_loaded("zlib")){
				$enable_gzip = true;
			}
		}
		header("Pragma: no-cache");

		if($enable_gzip){
			@ob_start();
			@ob_implicit_flush(0);
			header("Content-Type: application/x-gzip; name=\"config.php.gz\"");
			header("Content-disposition: attachment; filename=config.php.gz");
		}else{
			header("Content-Type: text/x-delimtext; name=\"config.php\"");
			header("Content-disposition: attachment; filename=config.php");
		}
			
		$config = file('../config.php');
		foreach($config as $line_num => $line) {
			echo $line;
		}

		if($enable_gzip){
			$Size = ob_get_length();
			$Crc = crc32(ob_get_contents());
			$contents = gzcompress(ob_get_contents());
			ob_end_clean();
			echo "\x1f\x8b\x08\x00\x00\x00\x00\x00".substr($contents, 0, strlen($contents) - 4).$backup->gzip_PrintFourChars($Crc).$backup->gzip_PrintFourChars($Size);
		}
		exit;

	}else{
		if($journalnessConfig_type == "mysql"){
			$database_type = "MySQL";
		}else{
			$database_type = "PostgreSQL";
		}

		$gzip_compression = "<span class=\"red-bold\">Disabled</span>";
		$show_gzip = false;
		if (extension_loaded("zlib")) {
			$gzip_compression = "<span class=\"green-bold\">Enabled</span>";
			$show_gzip = true;
		}

		$show_database_backup = false;
		if($type == "database"){
			$show_database_backup = true;
		}

		$smarty->assign(array(
				"show_database_backup" => $show_database_backup,
				"L_CONFIG_BACKUP" => $lang['Config_backup'],
				"L_DATABASE_BACKUP" => $lang['Database_backup'],
				"L_DETECTED_DATABASE" => $lang['Detected_database'],
				"database_type" => $database_type,
				"L_GZIP_COMPRESSION" => $lang['Gzip_compression'],
				"gzip_compression" => $gzip_compression,
				"show_gzip" => $show_gzip,
				"L_GZIP_BACKUP" => $lang['Gzip_backup'],
				"L_BACKUP_OPTIONS" => $lang['Backup_options'],
				"backup_types" => array(
					'all' => $lang['Structure_and_data'],
					'structure' => $lang['Structure_only'],
					'data' => $lang['Data_only']),
				"backup_type_selected" => 'all',
				"L_DOWNLOAD_BACKUP" => $lang['Download_backup'])
		);

	}

}else{
	$smarty->assign(array(
			"L_NOT_SUPER_ADMIN" => $lang['Not_super_admin'])
	);
}

$smarty->display("$theme/backup.tpl");

?>