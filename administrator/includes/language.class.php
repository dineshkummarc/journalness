<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Languages {

	function Languages(){

	}

	function getLanguages(){
		global $journalnessConfig_absolute_path;
		global $journalnessConfig_def_language;
		global $journalnessAdminConfig_def_theme;

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
								$languages[$i]['name'] = $language;

								if($journalnessConfig_def_language == $language){
									$languages[$i]['is_default_image'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/enabled.png";
									$languages[$i]['is_default'] = 1;
								}else{
									$languages[$i]['is_default_image'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/disabled.png";
									$languages[$i]['is_default'] = 0;
								}

								$language_info = parse_ini_file($completepath . "/language.ini");
								$languages[$i]['displayname'] = $language_info['language'];
								$languages[$i]['author'] = $language_info['author'];
								$languages[$i]['version'] = $language_info['version'];
								
								$i++;
							}
						}
					}
				}
			}	
		}

		$languages = $this->arrayColumnSort("is_default", SORT_DESC, SORT_NUMERIC, "displayname", SORT_ASC, SORT_STRING, $languages);

		return $languages;
	}


	function getLanguagesList(){
		global $journalnessConfig_absolute_path;
		global $journalnessConfig_def_language;
		global $journalnessAdminConfig_def_theme;

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


	function arrayColumnSort(){
		$n = func_num_args();
		$ar = func_get_arg($n-1);
		if(!is_array($ar)){
     			return false;
		}

   		for($i = 0; $i < $n-1; $i++){
     			$col[$i] = func_get_arg($i);
		}

   		foreach($ar as $key => $val){
     			foreach($col as $kkey => $vval){
       			if(is_string($vval)){
         				${"subar$kkey"}[$key] = $val[$vval];
				}
			}
		}

   		$arv = array();
   		foreach($col as $key => $val){
     			$arv[] = (is_string($val) ? ${"subar$key"} : $val);
		}
   		$arv[] = $ar;

		call_user_func_array("array_multisort", $arv);

		return $ar;
	}
}

$languages = new Languages;