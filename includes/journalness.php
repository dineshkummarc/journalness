<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

require_once( $journalnessConfig_absolute_path . '/includes/calendar.class.php' );
require_once( $journalnessConfig_absolute_path . '/includes/database.class.php' );
require_once( $journalnessConfig_absolute_path . '/includes/entry.class.php' );
require_once( $journalnessConfig_absolute_path . '/includes/users.class.php' );
require_once( $journalnessConfig_absolute_path . '/includes/mail.class.php' );
require_once( $journalnessConfig_absolute_path . '/includes/categories.class.php' );
require_once( $journalnessConfig_absolute_path . '/includes/session.class.php' );
require_once( $journalnessConfig_absolute_path . '/includes/stats.class.php' );
require_once( $journalnessConfig_absolute_path . '/includes/smarty/Smarty.class.php');
require_once( $journalnessConfig_absolute_path . '/includes/smarty/Config_File.class.php' );

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

	$template_dir = $journalnessConfig_absolute_path . "/templates";

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

?>