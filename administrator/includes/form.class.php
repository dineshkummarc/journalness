<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Form
{
	var $values = array();  //Holds submitted form field values
	var $errors = array();  //Holds submitted form error messages
	var $num_errors;   	//The number of errors in submitted form

	function Form(){
		if(isset($_SESSION['value_array']) && isset($_SESSION['error_array'])){
			$this->values = $_SESSION['value_array'];
			$this->errors = $_SESSION['error_array'];
			$this->num_errors = count($this->errors);

			unset($_SESSION['value_array']);
			unset($_SESSION['error_array']);
		}else{
			$this->num_errors = 0;
		}
	}

	function setValue($field, $value){
		$this->values[$field] = $value;
	}

	function setError($field, $errmsg){
		$this->errors[$field] = $errmsg;
		$this->num_errors = count($this->errors);
	}


	function value($field){
		if(array_key_exists($field,$this->values)){
			return htmlspecialchars(stripslashes($this->values[$field]));
		}else{
			return "";
		}
	}

	function error($field){
		if(array_key_exists($field,$this->errors)){
			return "<span style=\"color:red\">".$this->errors[$field]."</span>";
		}else{
			return "";
		}
	}

	function getErrorArray(){
		return $this->errors;
	}
}
 
?>