<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Templates {

	function Templates(){

	}

	function getTemplates($include_default=1){
		global $journalnessConfig_absolute_path;
		global $journalnessConfig_def_theme;
		global $journalnessAdminConfig_def_theme;

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
						$templates[$i]['name'] = $template;
						$template = NULL;
						foreach($pieces as $piece){
							$template .= ucfirst($piece) . " ";
						}
						$templates[$i]['displayname'] = $template;
					}else{
						$templates[$i]['name'] = $template;
						$templates[$i]['displayname'] = ucfirst($template);
					}

					if(file_exists($template_dir . "/" . $template_name . "/images/preview.png")){
						$templates[$i]['previewimage'] = "../templates/" . $template_name . "/images/preview.png";
					}else{
						$templates[$i]['previewimage'] = "../images/preview_not_available.png";
					}

					if($journalnessConfig_def_theme == $template_name){
						//$templates[$i]['is_default_image'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/enabled.png";
						$templates[$i]['is_default'] = 1;
					}else{
						//$templates[$i]['is_default_image'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/disabled.png";
						$templates[$i]['is_default'] = 0;
					}

					$template_info = parse_ini_file($completepath . "/template.ini");
					$templates[$i]['author'] = $template_info['author'];
					$templates[$i]['version'] = $template_info['version'];
					
					if($templates[$i]['is_default'] && !$include_default){
						unset($templates[$i]);
					}else{
						$i++;
					}
				}
			}	
		}

		$templates = $this->arrayColumnSort("is_default", SORT_DESC, SORT_NUMERIC, "displayname", SORT_ASC, SORT_STRING, $templates);

		return $templates;
	}

	function getDefaultTemplate(){
		global $journalnessConfig_absolute_path;
		global $journalnessConfig_def_theme;
		global $journalnessAdminConfig_def_theme;

		$template_dir = $journalnessConfig_absolute_path . "/templates";

		$handle = opendir($template_dir);
		while($file = readdir($handle)) {
			if ($file=='.' || $file=='..'){

			}else{
 		  	 	$completepath = "$template_dir/$file";

 	 	         	if (is_dir($completepath)) {
					$template = $file;
					$template_name = $file;
					if($template_name == $journalnessConfig_def_theme){
						$pieces = explode("_", $template);
						if(count($pieces) > 1){
							$deftemplate['name'] = $template;
							$template = NULL;
							foreach($pieces as $piece){
								$template .= ucfirst($piece) . " ";
							}
							$deftemplate['displayname'] = $template;
						}else{
							$deftemplate['name'] = $template;
							$deftemplate['displayname'] = ucfirst($template);
						}

						if(file_exists($template_dir . "/" . $template_name . "/images/preview.png")){
							$deftemplate['previewimage'] = "../templates/" . $template_name . "/images/preview.png";
						}else{
							$deftemplate['previewimage'] = "../images/preview_not_available.png";
						}

						//$deftemplate['is_default_image'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/enabled.png";
						$deftemplate['is_default'] = 1;
						$template_info = parse_ini_file($completepath . "/template.ini");
						$deftemplate['author'] = $template_info['author'];
						$deftemplate['version'] = $template_info['version'];
					}
				}
			}	
		}

		//$templates = $this->arrayColumnSort("is_default", SORT_DESC, SORT_NUMERIC, "displayname", SORT_ASC, SORT_STRING, $templates);

		return $deftemplate;
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

	function getTemplatesList(){
		global $journalnessConfig_absolute_path;
		global $journalnessConfig_def_theme;
		global $journalnessAdminConfig_def_theme;

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
}

$templates = new Templates;