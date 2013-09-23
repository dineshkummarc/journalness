<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Config {
	function Config(){

	}

	function getConfigVar($varname){
		$varname = "journalnessConfig_" . $varname;

		global ${$varname};

		$cfg_var = ${$varname};
		//$cfg_var = htmlspecialchars($cfg_var, ENT_QUOTES);
		//$cfg_var = $this->unhtmlentities($cfg_var);

		return $cfg_var;
	}

	function unhtmlentities($string)
	{
		// replace numeric entities
		$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
		$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
		// replace literal entities
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
		return strtr($string, $trans_tbl);
	}
}

$cfg = new Config;

?>