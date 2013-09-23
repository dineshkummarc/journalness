<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/users.class.php' );

if(isset($_POST['save_config'])){
	$configfile = "../config.php";
	$adminconfigfile = "adminconfig.php";
	
	// Make sure config is writeable.
	if (!is_writable($configfile)) {
		@chmod ($configfile, 0766);
		if (!is_writable($configfile)) {
			echo "File not writeable";
		}
	}

	// Make sure adminconfig is writeable.
	if (!is_writable($adminconfigfile)) {
		@chmod ($adminconfigfile, 0766);
		if (!is_writable($adminconfigfile)) {
			echo "File not writeable";
		}
	}

	$handle = fopen($configfile, "r");
	$contents = fread($handle, filesize($configfile));
	fclose($handle);

	$adminhandle = fopen($adminconfigfile, "r");
	$admincontents = fread($adminhandle, filesize($adminconfigfile));
	fclose($adminhandle);

	if(!is_numeric($_POST['config_newest_entries'])) $_POST['config_newest_entries'] = 3;
	if(!is_numeric($_POST['config_list_limit'])) $_POST['config_list_limit'] = 15;
	if(!is_numeric($_POST['config_max_upload_size'])) $_POST['config_max_upload_size'] = 250;
	if($users->usernameTaken($_POST['config_guest_name'])) $_POST['config_guest_name'] = $journalnessConfig_guest_name;
	$_POST['config_type'] = $journalnessConfig_type;
	$_POST['config_password'] = $journalnessConfig_password;
	$_POST['config_absolute_path'] = $journalnessConfig_absolute_path;
	$_POST['config_live_site'] = $journalnessConfig_live_site;
	$_POST['config_secret_word'] = $journalnessConfig_secret_word;

	foreach ($_POST as $k=>$v) {
		if (is_array($v)) $v = implode("|*|", $v);
		if (strpos( $k, 'config_' ) === 0) {
			$v = htmlspecialchars($v, ENT_QUOTES);
			$varname = "journalnessConfig_" . substr( $k, 7 );
			$contents = preg_replace('/(\$' . $varname . ')\s*=\s*\'(.*?)\'\;/s', '${1} = \'' . $v . '\';', $contents);
		}elseif(strpos( $k, 'adminconfig_' ) === 0){
			$v = htmlspecialchars($v, ENT_QUOTES);
			$varname = "journalnessAdminConfig_" . substr( $k, 12 );
			$admincontents = preg_replace('/(\$' . $varname . ')\s*=\s*\'(.*?)\'\;/s', '${1} = \'' . $v . '\';', $admincontents);
		}
	}

	$result = false;
	if ($fp = fopen( $adminconfigfile, "w")) {
		$result = fwrite($fp, $admincontents, strlen($admincontents));
		fclose ($fp);
	}

	$result = false;
	if ($fp = fopen( $configfile, "w")) {
		$result = fwrite($fp, $contents, strlen($contents));
		fclose ($fp);
	}

	if ($result != false) {
		header( 'Location: configuration.php?msg=' . $lang['Config_saved'] );
		exit;
	} else {
		header( 'Location: configuration.php?msg=' . $lang['Config_not_opened'] );
		exit;
	}
}

$msg = "";
if(isset($_GET['msg'])){
	$msg = $_GET['msg'];
}

$smarty->assign(array(
			'L_JOURNALNESS_CONFIGURATION' => $lang['Journalness_configuration'],
			'L_SAVE_CONFIG' => $lang['Save_config'],
			'L_CURRENT_SETTING' => $lang['Current_setting'],
			'L_EXPLANATION' => $lang['Explanation'],
			'MSG' => $msg)
);

// General Tab
$smarty->assign(array(
			'L_CONFIG_GENERAL' => $lang['Config_general'],
			'L_CONFIG_OFFLINE' => $lang['Config_offline'],
			'L_CONFIG_OFFLINE_EXPLAIN' => $lang['Config_offline_explain'],
			'yes_no_radio' => array(1 => $lang['Yes'], 0 => $lang['No']),
			'config_offline_selected' => $cfg->getConfigVar('offline'),
			'L_CONFIG_OFFLINE_MSG' => $lang['Config_offline_msg'],
			'L_CONFIG_OFFLINE_MSG_EXPLAIN' => $lang['Config_offline_msg_explain'],
			'config_offline_msg_value' => $cfg->getConfigVar('offline_msg'),
			'L_CONFIG_ADMIN_NAME' => $lang['Config_admin_name'],
			'L_CONFIG_ADMIN_NAME_EXPLAIN' => $lang['Config_admin_name_explain'],
			'config_admin_name_value' => $cfg->getConfigVar('admin_name'),
			'L_CONFIG_ADMIN_EMAIL' => $lang['Config_admin_email'],
			'L_CONFIG_ADMIN_EMAIL_EXPLAIN' => $lang['Config_admin_email_explain'],
			'config_admin_email_value' => $cfg->getConfigVar('admin_email'),
			'L_CONFIG_JOURNALTYPE' => $lang['Config_journaltype'],
			'L_MOUSEOVER' => $lang['Mouseover'],
			'journaltype_radio' => array(0 => '<a href="#" onmouseover="this.T_DELAY=0;return escape(\'' . $lang['Config_open_explain'] . '\')">' . $lang['Open'] . '</a>', 1 => '<a href="#" onmouseover="this.T_DELAY=0;return escape(\'' . $lang['Config_closed_explain'] . '\')">' . $lang['Closed'] . '</a>', 2 => '<a href="#" onmouseover="this.T_DELAY=0;return escape(\'' . $lang['Config_private_explain'] . '\')">' . $lang['Private'] . '</a>'),
			'config_journaltype_selected' => $cfg->getConfigVar('journaltype'),
			'L_CONFIG_POST_LEVEL' => $lang['Config_post_level'],
			'L_CONFIG_POST_LEVEL_EXPLAIN' => $lang['Config_post_level_explain'],
			'post_level_radio' => array(1 => $lang['Registered_and_above'], 2 => $lang['Admins_only']),
			'config_post_level_selected' => $cfg->getConfigVar('post_level'),
			'L_CONFIG_RSS' => $lang['Config_rss'],
			'L_CONFIG_RSS_EXPLAIN' => $lang['Config_rss_explain'],
			'config_rss_selected' => $cfg->getConfigVar('rss'),
			'L_CONFIG_ATOM' => $lang['Config_atom'],
			'L_CONFIG_ATOM_EXPLAIN' => $lang['Config_atom_explain'],
			'config_atom_selected' => $cfg->getConfigVar('atom'),
			'L_CONFIG_ALLOW_COMMENTS' => $lang['Config_allow_comments'],
			'L_CONFIG_ALLOW_COMMENTS_EXPLAIN' => $lang['Config_allow_comments_explain'],
			'config_allow_comments_selected' => $cfg->getConfigVar('allow_comments'),
			'L_CONFIG_ANON_COMMENTS' => $lang['Config_anon_comments'],
			'L_CONFIG_ANON_COMMENTS_EXPLAIN' => $lang['Config_anon_comments_explain'],
			'config_anon_comments_selected' => $cfg->getConfigVar('anon_comments'),
			'L_CONFIG_USER_ACTIVATION' => $lang['Config_user_activation'],
			'L_CONFIG_USER_ACTIVATION_EXPLAIN' => $lang['Config_user_activation_explain'],
			'config_user_activation_selected' => $cfg->getConfigVar('user_activation'),
			'L_CONFIG_ALLOW_USERNAME_CHANGE' => $lang['Config_allow_username_change'],
			'L_CONFIG_ALLOW_USERNAME_CHANGE_EXPLAIN' => $lang['Config_allow_username_change_explain'],
			'config_allow_username_change_selected' => $cfg->getConfigVar('allow_username_change'),
			'L_CONFIG_NEXT_PREV' => $lang['Config_next_prev'],
			'L_CONFIG_NEXT_PREV_EXPLAIN' => $lang['Config_next_prev_explain'],
			'config_next_prev_selected' => $cfg->getConfigVar('next_prev'),
			'L_CONFIG_SHOW_USER_SIDEBAR' => $lang['Config_show_user_sidebar'],
			'L_CONFIG_SHOW_USER_SIDEBAR_EXPLAIN' => $lang['Config_show_user_sidebar_explain'],
			'config_show_user_sidebar_selected' => $cfg->getConfigVar('show_user_sidebar'),
			'L_CONFIG_SHOW_HIT_COUNT' => $lang['Config_show_hit_count'],
			'L_CONFIG_SHOW_HIT_COUNT_EXPLAIN' => $lang['Config_show_hit_count_explain'],
			'config_show_hit_count_selected' => $cfg->getConfigVar('show_hit_count'),
			'L_CONFIG_SHOW_RECENT_ENTRIES_SIDEBAR' => $lang['Config_show_recent_entries_sidebar'],
			'L_CONFIG_SHOW_RECENT_ENTRIES_SIDEBAR_EXPLAIN' => $lang['Config_show_recent_entries_sidebar_explain'],
			'config_show_recent_entries_sidebar_selected' => $cfg->getConfigVar('show_recent_entries_sidebar'),
			'L_CONFIG_NUM_RECENT_ENTRIES_SIDEBAR' => $lang['Config_num_recent_entries_sidebar'],
			'L_CONFIG_NUM_RECENT_ENTRIES_SIDEBAR_EXPLAIN' => $lang['Config_num_recent_entries_sidebar_explain'],
			'config_num_recent_entries_sidebar_value' => $cfg->getConfigVar('num_recent_entries_sidebar'),
			'L_CONFIG_NEWEST_ENTRIES' => $lang['Config_newest_entries'],
			'L_CONFIG_NEWEST_ENTRIES_EXPLAIN' => $lang['Config_newest_entries_explain'],
			'config_newest_entries_value' => $cfg->getConfigVar('newest_entries'),
			'L_CONFIG_LIST_LIMIT' => $lang['Config_list_limit'],
			'L_CONFIG_LIST_LIMIT_EXPLAIN' => $lang['Config_list_limit_explain'],
			'config_list_limit_value' => $cfg->getConfigVar('list_limit'))
);


// Database Tab
$smarty->assign(array(
			'L_CONFIG_DATABASE' => $lang['Config_database'],
			'L_CONFIG_HOST' => $lang['Config_host'],
			'L_CONFIG_HOST_EXPLAIN' => $lang['Config_host_explain'],
			'config_host_value' => $cfg->getConfigVar('host'),
			'L_CONFIG_USER' => $lang['Config_user'],
			'L_CONFIG_USER_EXPLAIN' => $lang['Config_user_explain'],
			'config_user_value' => $cfg->getConfigVar('user'),
			'L_CONFIG_PASSWORD' => $lang['Config_password'],
			'L_CONFIG_PASSWORD_EXPLAIN' => $lang['Config_password_explain'],
			'L_CONFIG_PASSWORD_VIEW' => $lang['Config_password_view'],
			'L_CONFIG_DBNAME' => $lang['Config_dbname'],
			'L_CONFIG_DBNAME_EXPLAIN' => $lang['Config_dbname_explain'],
			'config_dbname_value' => $cfg->getConfigVar('dbname'),
			'L_CONFIG_DBPREFIX' => $lang['Config_dbprefix'],
			'L_CONFIG_DBPREFIX_EXPLAIN' => $lang['Config_dbprefix_explain'],
			'config_dbprefix_value' => $cfg->getConfigVar('dbprefix'))
);

// Server Tab
$smarty->assign(array(
			'L_CONFIG_SERVER' => $lang['Config_server'],
			'L_ABSOLUTE_PATH' => $lang['Config_absolute_path'],
			'config_absolute_path_value' => $cfg->getConfigVar('absolute_path'),
			'L_LIVE_SITE' => $lang['Config_live_site'],
			'config_live_site_value' => $cfg->getConfigVar('live_site'),
			'L_SECRET_WORD' => $lang['Config_secret_word'],
			'config_secret_word_value' => $cfg->getConfigVar('secret_word'),
			'L_CONFIG_SITENAME' => $lang['Config_sitename'],
			'L_CONFIG_SITENAME_EXPLAIN' => $lang['Config_sitename_explain'],
			'config_sitename_value' => $cfg->getConfigVar('sitename'),
			'L_CONFIG_GUEST_NAME' => $lang['Config_guest_name'],
			'L_CONFIG_GUEST_NAME_EXPLAIN' => $lang['Config_guest_name_explain'],
			'config_guest_name_value' => $cfg->getConfigVar('guest_name'))
);

// Mail Tab
$smarty->assign(array(
			'L_CONFIG_MAIL' => $lang['Config_mail'],
			'L_CONFIG_SEND_WELCOME_EMAIL' => $lang['Config_send_welcome_email'],
			'L_CONFIG_SEND_WELCOME_EMAIL_EXPLAIN' => $lang['Config_send_welcome_email_explain'],
			'config_send_welcome_email_selected' => $cfg->getConfigVar('send_welcome_email'),
			'L_CONFIG_WELCOME_EMAIL_FROM_NAME' => $lang['Config_welcome_email_from_name'],
			'L_CONFIG_WELCOME_EMAIL_FROM_NAME_EXPLAIN' => $lang['Config_welcome_email_from_name_explain'],
			'config_welcome_email_from_name_value' => $cfg->getConfigVar('welcome_email_from_name'),
			'L_CONFIG_WELCOME_EMAIL_FROM_ADDRESS' => $lang['Config_welcome_email_from_address'],
			'L_CONFIG_WELCOME_EMAIL_FROM_ADDRESS_EXPLAIN' => $lang['Config_welcome_email_from_address_explain'],
			'config_welcome_email_from_address_value' => $cfg->getConfigVar('welcome_email_from_address'),
			'L_CONFIG_WELCOME_EMAIL_SUBJECT' => $lang['Config_welcome_email_subject'],
			'L_CONFIG_WELCOME_EMAIL_SUBJECT_EXPLAIN' => $lang['Config_welcome_email_subject_explain'],
			'config_welcome_email_subject_value' => $cfg->getConfigVar('welcome_email_subject'),
			'L_CONFIG_WELCOME_EMAIL_MSG' => $lang['Config_welcome_email_msg'],
			'L_CONFIG_WELCOME_EMAIL_MSG_EXPLAIN' => $lang['Config_welcome_email_msg_explain'],
			'config_welcome_email_msg_value' => $cfg->getConfigVar('welcome_email_msg'),
			'L_CONFIG_USER_ACTIVATION_EMAIL_FROM_NAME' => $lang['Config_user_activation_email_from_name'],
			'L_CONFIG_USER_ACTIVATION_EMAIL_FROM_NAME_EXPLAIN' => $lang['Config_user_activation_email_from_name_explain'],
			'config_user_activation_email_from_name_value' => $cfg->getConfigVar('user_activation_email_from_name'),
			'L_CONFIG_USER_ACTIVATION_EMAIL_FROM_ADDRESS' => $lang['Config_user_activation_email_from_address'],
			'L_CONFIG_USER_ACTIVATION_EMAIL_FROM_ADDRESS_EXPLAIN' => $lang['Config_user_activation_email_from_address_explain'],
			'config_user_activation_email_from_address_value' => $cfg->getConfigVar('user_activation_email_from_address'),
			'L_CONFIG_USER_ACTIVATION_EMAIL_SUBJECT' => $lang['Config_user_activation_email_subject'],
			'L_CONFIG_USER_ACTIVATION_EMAIL_SUBJECT_EXPLAIN' => $lang['Config_user_activation_email_subject_explain'],
			'config_user_activation_email_subject_value' => $cfg->getConfigVar('user_activation_email_subject'),
			'L_CONFIG_USER_ACTIVATION_EMAIL_MSG' => $lang['Config_user_activation_email_msg'],
			'L_CONFIG_USER_ACTIVATION_EMAIL_MSG_EXPLAIN' => $lang['Config_user_activation_email_msg_explain'],
			'config_user_activation_email_msg_value' => $cfg->getConfigVar('user_activation_email_msg'),
			'L_CONFIG_PASSWORD_EMAIL_FROM_NAME' => $lang['Config_password_email_from_name'],
			'L_CONFIG_PASSWORD_EMAIL_FROM_NAME_EXPLAIN' => $lang['Config_password_email_from_name_explain'],
			'config_password_email_from_name_value' => $cfg->getConfigVar('password_email_from_name'),
			'L_CONFIG_PASSWORD_EMAIL_FROM_ADDRESS' => $lang['Config_password_email_from_address'],
			'L_CONFIG_PASSWORD_EMAIL_FROM_ADDRESS_EXPLAIN' => $lang['Config_password_email_from_address_explain'],
			'config_password_email_from_address_value' => $cfg->getConfigVar('password_email_from_address'),
			'L_CONFIG_PASSWORD_EMAIL_SUBJECT' => $lang['Config_password_email_subject'],
			'L_CONFIG_PASSWORD_EMAIL_SUBJECT_EXPLAIN' => $lang['Config_password_email_subject_explain'],
			'config_password_email_subject_value' => $cfg->getConfigVar('password_email_subject'),
			'L_CONFIG_PASSWORD_EMAIL_MSG' => $lang['Config_password_email_msg'],
			'L_CONFIG_PASSWORD_EMAIL_MSG_EXPLAIN' => $lang['Config_password_email_msg_explain'],
			'config_password_email_msg_value' => $cfg->getConfigVar('password_email_msg'),
			'L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_FROM_NAME' => $lang['Config_password_reset_confirm_email_from_name'],
			'L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_FROM_NAME_EXPLAIN' => $lang['Config_password_reset_confirm_email_from_name_explain'],
			'config_password_reset_confirm_email_from_name_value' => $cfg->getConfigVar('password_reset_confirm_email_from_name'),
			'L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_FROM_ADDRESS' => $lang['Config_password_reset_confirm_email_from_address'],
			'L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_FROM_ADDRESS_EXPLAIN' => $lang['Config_password_reset_confirm_email_from_address_explain'],
			'config_password_reset_confirm_email_from_address_value' => $cfg->getConfigVar('password_reset_confirm_email_from_address'),
			'L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_SUBJECT' => $lang['Config_password_reset_confirm_email_subject'],
			'L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_SUBJECT_EXPLAIN' => $lang['Config_password_reset_confirm_email_subject_explain'],
			'config_password_reset_confirm_email_subject_value' => $cfg->getConfigVar('password_reset_confirm_email_subject'),
			'L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_MSG' => $lang['Config_password_reset_confirm_email_msg'],
			'L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_MSG_EXPLAIN' => $lang['Config_password_reset_confirm_email_msg_explain'],
			'config_password_reset_confirm_email_msg_value' => $cfg->getConfigVar('password_reset_confirm_email_msg'),
			'L_CONFIG_PASSWORD_RESET_EMAIL_FROM_NAME' => $lang['Config_password_reset_email_from_name'],
			'L_CONFIG_PASSWORD_RESET_EMAIL_FROM_NAME_EXPLAIN' => $lang['Config_password_reset_email_from_name_explain'],
			'config_password_reset_email_from_name_value' => $cfg->getConfigVar('password_reset_email_from_name'),
			'L_CONFIG_PASSWORD_RESET_EMAIL_FROM_ADDRESS' => $lang['Config_password_reset_email_from_address'],
			'L_CONFIG_PASSWORD_RESET_EMAIL_FROM_ADDRESS_EXPLAIN' => $lang['Config_password_reset_email_from_address_explain'],
			'config_password_reset_email_from_address_value' => $cfg->getConfigVar('password_reset_email_from_address'),
			'L_CONFIG_PASSWORD_RESET_EMAIL_SUBJECT' => $lang['Config_password_reset_email_subject'],
			'L_CONFIG_PASSWORD_RESET_EMAIL_SUBJECT_EXPLAIN' => $lang['Config_password_reset_email_subject_explain'],
			'config_password_reset_email_subject_value' => $cfg->getConfigVar('password_reset_email_subject'),
			'L_CONFIG_PASSWORD_RESET_EMAIL_MSG' => $lang['Config_password_reset_email_msg'],
			'L_CONFIG_PASSWORD_RESET_EMAIL_MSG_EXPLAIN' => $lang['Config_password_reset_email_msg_explain'],
			'config_password_reset_email_msg_value' => $cfg->getConfigVar('password_reset_email_msg'))
);

// Upload Tab
$smarty->assign(array(
			'L_CONFIG_UPLOADS' => $lang['Config_uploads'],
			'L_CONFIG_ALLOW_UPLOADS' => $lang['Config_allow_uploads'],
			'L_CONFIG_ALLOW_UPLOADS_EXPLAIN' => $lang['Config_allow_uploads_explain'],
			'config_allow_uploads_selected' => $cfg->getConfigVar('allow_uploads'),
			'L_CONFIG_UPLOAD_TYPE' => $lang['Config_upload_type'],
			'upload_type_radio' => array(0 => $lang['Config_files'], 1 => $lang['Config_database']),
			'config_upload_type_selected' => $cfg->getConfigVar('upload_type'),
			'L_CONFIG_FILES' => $lang['Config_files'],
			'L_CONFIG_FILES_EXPLAIN' => $lang['Config_files_explain'],
			'L_CONFIG_DATABASE' => $lang['Config_database'],
			'L_CONFIG_DATABASE_EXPLAIN' => $lang['Config_database_explain'],
			'L_CONFIG_MAX_UPLOAD_SIZE' => $lang['Config_max_upload_size'],
			'L_CONFIG_MAX_UPLOAD_SIZE_EXPLAIN' => $lang['Config_max_upload_size_explain'],
			'L_KB' => $lang['KB'],
			'config_max_upload_size_value' => $cfg->getConfigVar('max_upload_size'),
			'L_CONFIG_IMAGE_RESIZE_OPTIONS' => $lang['Config_image_resize_options'],
			'L_CONFIG_GD_LIBRARY' => $lang['Config_gd_library'],
			'gd_detection' => gdDetect(),
			'L_CONFIG_GD_LIBRARY_EXPLAIN' => $lang['Config_gd_library_explain'],
			'L_CONFIG_RESIZE_IMAGES' => $lang['Config_resize_images'],
			'config_resize_images_selected' => $cfg->getConfigVar('resize_images'),
			'L_CONFIG_RESIZE_IMAGES_EXPLAIN' => $lang['Config_resize_images_explain'],
			'L_CONFIG_RESIZE_IMAGES_SIZE' => $lang['Config_resize_images_size'],
			'L_CONFIG_RESIZE_IMAGES_SIZE_EXPLAIN' => $lang['Config_resize_images_size_explain'],
			'L_WIDTH' => $lang['Width'],
			'L_HEIGHT' => $lang['Height'],
			'L_PIXELS' => $lang['Pixels'],
			'config_resize_images_height_value' => $cfg->getConfigVar('resize_images_height'),
			'config_resize_images_width_value' => $cfg->getConfigVar('resize_images_width'))
);

if(!function_exists("gd_info")){
	$smarty->assign(array(
			"no_gd" => "true")
	);
}

// Calendar Tab
$smarty->assign(array(
			'L_CONFIG_CALENDAR' => $lang['Config_calendar'],
			'L_CONFIG_SHOW_CALENDAR' => $lang['Config_show_calendar'],
			'L_CONFIG_SHOW_CALENDAR_EXPLAIN' => $lang['Config_show_calendar_explain'],
			'config_show_calendar_selected' => $cfg->getConfigVar('show_calendar'))
);

// Admin Tab
$smarty->assign(array(
			'L_CONFIG_ADMIN' => $lang['Config_admin'],
			'L_ADMINCONFIG_DEFAULT_LANGUAGE' => $lang['Adminconfig_default_language'],
			'L_ADMINCONFIG_DEFAULT_LANGUAGE_EXPLAIN' => $lang['Adminconfig_default_language_explain'],
			"def_lang" => $journalnessAdminConfig_def_lang,
			"lang_options" => getLanguages(),
			'L_ADMINCONFIG_DEFAULT_THEME' => $lang['Adminconfig_default_theme'],
			'L_ADMINCONFIG_DEFAULT_THEME_EXPLAIN' => $lang['Adminconfig_default_theme_explain'],
			"def_theme" => $journalnessAdminConfig_def_theme,
			"theme_options" => getThemes())
);

// From PHP.net
function gdDetect() {
	global $lang;

	$html = "<span>GD support: ";
	if(function_exists("gd_info")){
		$html .= "<span style=\"color:green; font-weight:bold;\">" . $lang['Yes'] . "</span><br/></span>";
		$info = gd_info();
		$keys = array_keys($info);
		for($i=0; $i<count($keys); $i++) {
			if(is_bool($info[$keys[$i]])){
				$html .= "<span>" . $keys[$i] .": " . yesNo($info[$keys[$i]]) . "<br/></span>";
			}else{
				$html .= "<span>" . $keys[$i] .": <span style=\"font-weight:bold\">" . ucfirst($info[$keys[$i]]) . "</span><br/></span>";
			}
		}
	}else{
		$html .= "<span style=\"color:red; font-weight:bold;\">" . $lang['No'] . "</span><br/></span>";
	}

	return $html;
}

function yesNo($bool){
	global $lang;

	if($bool) return "<span style=\"color:green; font-weight:bold;\"> " . $lang['Yes'] . "</span>";
	else return "<span style=\"color:red; font-weight:bold;\"> " . $lang['No'] . "</span>";
}

$smarty->display("$theme/configuration.tpl");


?>