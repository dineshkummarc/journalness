<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Information {

	function Information(){

	}

	function getDBSize(){
		global $database, $journalnessConfig_type, $journalnessConfig_dbname;
		global $journalnessConfig_dbprefix, $lang;

		$total_table_size = "0";

		if($journalnessConfig_type == "mysql"){
			$query = "SHOW TABLE STATUS FROM " . $journalnessConfig_dbname . " LIKE '" . $journalnessConfig_dbprefix . "%'";
			$result = $database->GetArray($query);

			for($i=0; $i<count($result); $i++){
				$total_table_size += $result[$i]['Data_length'] + $result[$i]['Index_length'];
			}

			$total_table_size = $this->size_hum_read($total_table_size);

			return $total_table_size;
		}else{
			return $lang['Not_available'];
		}

	}

	function getUploadTableSize(){
		global $database, $journalnessConfig_type, $journalnessConfig_dbname;
		global $journalnessConfig_dbprefix, $lang;

		$total_table_size = "0";

		if($journalnessConfig_type == "mysql"){
			$query = "SHOW TABLE STATUS FROM " . $journalnessConfig_dbname . " LIKE '" . $journalnessConfig_dbprefix . "uploads'";
			$result = $database->GetArray($query);

			for($i=0; $i<count($result); $i++){
				$total_table_size += $result[$i]['Data_length'] + $result[$i]['Index_length'];
			}

			$total_table_size = $this->size_hum_read($total_table_size);
			
			return $total_table_size;
		}else{
			return $lang['Not_available'];
		}
	}

	function getNumRows($tablename){
		global $database;

		$query = "SELECT * FROM #__" . $tablename;
		$results = $database->GetArray($query);

		return count($results);
	}

	function getDatabaseVersion(){
		global $database, $journalnessConfig_type;

		if($journalnessConfig_type == "mysql"){
			$query = "SELECT VERSION()";
			$result = $database->GetArray($query);
			$version = "MySQL " . $result[0][0];
		}else{
			$query = "SHOW SERVER VERSION";
			$result = $database->GetArray($query);
			$version = "PostgreSQL " . $result[0][0];
		}

		return $version;
	}

	function getUploadFolderSize(){
		global $journalnessConfig_absolute_path, $lang;

		$upload_folder_size = $this->get_size($journalnessConfig_absolute_path . '/uploads');
		$upload_folder_size = $this->size_hum_read($upload_folder_size);

		return $upload_folder_size;
	}

	function get_size($path){
		if(!is_dir($path)) return filesize($path);

		if ($handle = opendir($path)) {
			$size = 0;
			while (false !== ($file = readdir($handle))) {
				if($file!='.' && $file!='..'){
					$size += filesize($path.'/'.$file);
					$size += $this->get_size($path.'/'.$file);
				}
			}
			closedir($handle);
			return $size;
		}
	}

	function size_hum_read($size){
		$i=0;
		$iec = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		while (($size/1024)>1) {
			$size=$size/1024;
			$i++;
		}
		return substr($size,0,strpos($size,'.')+4).$iec[$i];
	}

}

$information = new Information();