<?php

// Parent File
define( '_VALID_JOURNALNESS', 1 );

if (!file_exists( '../config.php' )) {
	header( 'Location: ../installation/index.php' );
	exit();
}

// If installation folder exists, request that user removes it
if (file_exists( '../installation')) {
	echo "Please remove Installation/ Directory";
	exit();
}

fix_magic_quotes();

require_once( '../config.php' );
require_once( '../includes/database.class.php');
require_once( '../includes/stats.class.php');
require_once( '../includes/version.php');
require_once( '../includes/smarty/Smarty.class.php');
require_once( '../includes/smarty/Config_File.class.php' );
require_once( 'adminconfig.php' );
require_once( 'includes/information.class.php' );
require_once( 'includes/adminsession.class.php' );
require_once( 'includes/config.class.php' );

if(!$adminsession->logged_in && basename($_SERVER['PHP_SELF']) != "login.php"){
	header( 'Location: login.php');
	exit();
}

// Start new template
$smarty = new Smarty;

$smarty->template_dir = $journalnessConfig_absolute_path . '/administrator/templates/';
$smarty->compile_dir = $journalnessConfig_absolute_path . '/administrator/templates_c/';

$theme = $journalnessAdminConfig_def_theme;
$language = $journalnessAdminConfig_def_lang;

// Load Language File
require_once( $journalnessConfig_absolute_path . '/language/lang_' . $language . '/lang_' . $language . '.php' );

$smarty->assign(array(
		"theme" => $theme,
		"journalnessConfig_sitename" => $journalnessConfig_sitename,
		"journalnessConfig_live_site" => $journalnessConfig_live_site,
		"adminsession_logged_in" => $adminsession->logged_in,
		"adminsession_useraccess" => $adminsession->useraccess,
		"adminsession_is_super_admin" => $adminsession->is_super_admin,
		"adminsession_username" => $adminsession->username)
);



function getLanguages(){
	global $journalnessConfig_absolute_path;

	$language_dir = $journalnessConfig_absolute_path . "/language";

	$handle = opendir($language_dir);
	$i=0;
	while($file = readdir($handle)) {
		if ($file=='.' || $file=='..'){

		}else{
   	 		$completepath = "$language_dir/$file";
        		if (is_dir($completepath)) {
				$handle2 = opendir($completepath);
				while($file2 = readdir($handle2)){
					if ($file2 == '.' || $file2 == '..'){
				
					}else{
						$completepath2="$completepath/$file2";

						if(is_dir($completepath2)){
				
						}elseif((substr($file2, 0, 4) == "lang") && !(strpos($file2,".php") === false)){
							$language = substr($file2, 0, -4);
							$language = strstr($language, '_');
							$language = str_replace("_", "", $language);
							$languages[$language] = ucfirst($language);
								
							$i++;
						}
					}
				}
			}
		}	
	}

	return $languages;
}

function getThemes(){
	global $journalnessConfig_absolute_path;

	$template_dir = $journalnessConfig_absolute_path . "/administrator/templates";

	$handle = opendir($template_dir);
	$i=0;
	while($file = readdir($handle)) {
		if ($file=='.' || $file=='..'){

		}else{
			$completepath = "$template_dir/$file";

			if (is_dir($completepath)) {
				$template = $file;
				$template_name = $file;
				$pieces = explode("_", $template);
				if(count($pieces) > 1){
					$templateName = $template;
					$template = NULL;
					foreach($pieces as $piece){
						$template .= ucfirst($piece) . " ";
					}
					$templates[$templateName] = $template;
				}else{
					$templates[$template] = ucfirst($template);
				}

				$i++;
			}
		}	
	}

	return $templates;
}

function fix_magic_quotes ($var = NULL, $sybase = NULL)
{
	// if sybase style quoting isn't specified, use ini setting
	if ( !isset ($sybase) )
	{
		$sybase = ini_get ('magic_quotes_sybase');
	}

	// if no var is specified, fix all affected superglobals
	if ( !isset ($var) )
	{
		// if magic quotes is enabled
		if ( get_magic_quotes_gpc () )
		{
			// workaround because magic_quotes does not change $_SERVER['argv']
			$argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : NULL; 

			// fix all affected arrays
			foreach ( array ('_ENV', '_REQUEST', '_GET', '_POST', '_COOKIE', '_SERVER') as $var )
			{
				$GLOBALS[$var] = fix_magic_quotes ($GLOBALS[$var], $sybase);
			}

			$_SERVER['argv'] = $argv;

			// turn off magic quotes, this is so scripts which
			// are sensitive to the setting will work correctly
			ini_set ('magic_quotes_gpc', 0);
		}

		// disable magic_quotes_sybase
		if ( $sybase )
		{
			ini_set ('magic_quotes_sybase', 0);
		}

		// disable magic_quotes_runtime
		set_magic_quotes_runtime (0);
		return TRUE;
	}

	// if var is an array, fix each element
	if ( is_array ($var) )
	{
		foreach ( $var as $key => $val )
		{
			$var[$key] = fix_magic_quotes ($val, $sybase);
		}

		return $var;
	}

	// if var is a string, strip slashes
	if ( is_string ($var) )
	{
		return $sybase ? str_replace ('\'\'', '\'', $var) : stripslashes ($var);
	}

	// otherwise ignore
	return $var;
}


?>