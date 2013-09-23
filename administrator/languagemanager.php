<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/language.class.php' );
require_once( 'includes/pclzip.lib.php' );

if(isset($_POST['save_language'])){
	$configfile = "../config.php";
	
	// Make sure config is writeable.
	if (!is_writable($configfile)) {
		@chmod ($configfile, 0766);
		if (!is_writable($configfile)) {
			echo "File not writeable";
		}
	}

	$handle = fopen($configfile, "r");
	$contents = fread($handle, filesize($configfile));
	fclose($handle);

	$default_language = $_POST['selected_language'];
	$override_user_language = $_POST['override_user_language'];
	if($override_user_language){
		$override_user_language = '1';
	}else{
		$override_user_language = '0';
	}

	$contents = preg_replace('/(\$journalnessConfig_override_user_language)\s*=\s*\'(.*?)\'\;/s', '${1} = \'' . $override_user_language . '\';', $contents);
	$contents = preg_replace('/(\$journalnessConfig_def_language)\s*=\s*\'(.*?)\'\;/s', '${1} = \'' . $default_language . '\';', $contents);

	$result = false;
	if ($fp = fopen( $configfile, "w")) {
		$result = fwrite($fp, $contents, strlen($contents));
		fclose ($fp);
	}

	if ($result != false) {
		header( 'Location: languagemanager.php?msg=' . $lang['Settings_saved'] );
		exit;
	} else {
		header( 'Location: languagemanager.php?msg=' . $lang['Settings_not_saved'] );
		exit;
	}
}else{

	$msg = "";
	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];
	}

	if(isset($_POST['language_upload'])){
		$filetype = $_FILES['lang_file']['type'];

		if($filetype == 'application/zip' || $filetype == 'application/x-zip-compressed'){
  			$archive = new PclZip($_FILES['lang_file']['tmp_name']);
			if ($archive->extract(PCLZIP_OPT_PATH, '../language') == 0) {
				die("Error : ".$archive->errorInfo(true));
			}
			$msg = $lang['New_language_installed'];
		}
	}

	$language_list = $languages->getLanguages();

	$smarty->assign(array(
		"MSG" => $msg,
		"L_LANGUAGE_MANAGER" => $lang['Language_manager'],
		"L_OVERRIDE_USER_LANGUAGE" => $lang['Override_user_language'],
		"override_selected" => $journalnessConfig_override_user_language,
		"L_SAVE_SETTINGS" => $lang['Save_settings'],
		"language_list" => $language_list,
		"L_DEFAULT_LANGUAGE" => $lang['Default_language'],
		"L_LANGUAGE_NAME" => $lang['Language_name'],
		"L_LANGUAGE_AUTHOR" => $lang['Language_author'],
		"L_LANGUAGE_VERSION" => $lang['Language_version'],
		"L_LANGUAGE_DEFAULT" => $lang['Language_default'],
		"L_CHOOSE_DEFAULT_LANGUAGE" => $lang['Choose_default_language'],
		"L_SELECT" => $lang['Select'],
		"L_LANGUAGE_INSTALLER" => $lang['Language_installer'],
		"L_UPLOAD_LANGUAGE_FILE" => $lang['Upload_language_file'],
		"L_UPLOAD_AND_INSTALL" => $lang['Upload_and_install'],
		"L_PACKAGE_FILE" => $lang['Package_file'])
	);
}

$smarty->display("$theme/languagemanager.tpl");

?>
