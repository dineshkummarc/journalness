<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/templates.class.php' );
require_once( 'includes/pclzip.lib.php' );

if(isset($_POST['save_template'])){
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

	$default_template = $_POST['selected_template'];
	$override_user_theme = $_POST['override_user_theme'];
	if($override_user_theme){
		$override_user_theme = '1';
	}else{
		$override_user_theme = '0';
	}

	$contents = preg_replace('/(\$journalnessConfig_override_user_theme)\s*=\s*\'(.*?)\'\;/s', '${1} = \'' . $override_user_theme . '\';', $contents);
	$contents = preg_replace('/(\$journalnessConfig_def_theme)\s*=\s*\'(.*?)\'\;/s', '${1} = \'' . $default_template . '\';', $contents);

	$result = false;
	if ($fp = fopen( $configfile, "w")) {
		$result = fwrite($fp, $contents, strlen($contents));
		fclose ($fp);
	}

	if ($result != false) {
		header( 'Location: templatemanager.php?msg=' . $lang['Settings_saved'] );
		exit;
	} else {
		header( 'Location: templatemanager.php?msg=' . $lang['Settings_not_saved'] );
		exit;
	}

}else{

	$msg = "";
	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];
	}

	if(isset($_POST['template_upload'])){
		$filetype = $_FILES['lang_file']['type'];

		if($filetype == 'application/zip' || $filetype == 'application/x-zip-compressed'){
  			$archive = new PclZip($_FILES['lang_file']['tmp_name']);
			if ($archive->extract(PCLZIP_OPT_PATH, '../templates') == 0) {
				die("Error : ".$archive->errorInfo(true));
			}
			$msg = $lang['New_template_installed'];
		}
	}

	$template_list = $templates->getTemplates(0);
	$default_template = $templates->getDefaultTemplate();

	$smarty->assign(array(
		"MSG" => $msg,
		"L_TEMPLATE_MANAGER" => $lang['Template_manager'],
		"L_OVERRIDE_USER_THEME" => $lang['Override_user_theme'],
		"override_selected" => $journalnessConfig_override_user_theme,
		"L_SAVE_SETTINGS" => $lang['Save_settings'],
		"template_list" => $template_list,
		"default_template" => $default_template,
		"L_DEFAULT_TEMPLATE" => $lang['Default_template'],
		"L_TEMPLATE_NAME" => $lang['Template_name'],
		"L_TEMPLATE_AUTHOR" => $lang['Template_author'],
		"L_TEMPLATE_VERSION" => $lang['Template_version'],
		"L_CHOOSE_DEFAULT_TEMPLATE" => $lang['Choose_default_template'],
		"L_SELECT" => $lang['Select'],
		"L_TEMPLATE_INSTALLER" => $lang['Template_installer'],
		"L_UPLOAD_TEMPLATE_FILE" => $lang['Upload_template_file'],
		"L_UPLOAD_AND_INSTALL" => $lang['Upload_and_install'],
		"L_PACKAGE_FILE" => $lang['Package_file'])
	);
}

$smarty->display("$theme/templatemanager.tpl");

?>