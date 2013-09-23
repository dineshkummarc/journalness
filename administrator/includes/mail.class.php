<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Mailer
{

	function sendPassword($username, $email, $password){
		global $journalnessConfig_password_email_from_name;
		global $journalnessConfig_password_email_from_address;
		global $journalnessConfig_password_email_subject;
		global $journalnessConfig_password_email_msg;

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ' . $journalnessConfig_password_email_from_name . '<' . $journalnessConfig_password_email_from_address . ">\r\n";

		$vars['Username'] = $username;
		$vars['Password'] = $password;

		$message = $this->replaceVariables($journalnessConfig_password_email_msg, $vars);
		$result = mail($email, $journalnessConfig_password_email_subject, $message, $headers);

		return $result;
	}

	function replaceVariables($msg, $vars){
		global $journalnessConfig_sitename;

		$msg = $this->jstr_ireplace("[USERNAME]", $vars['Username'], $msg);
		$msg = $this->jstr_ireplace("[PASSWORD]", $vars['Password'], $msg);
		$msg = $this->jstr_ireplace("[SITENAME]", $journalnessConfig_sitename, $msg);

		return $msg;
	}

	// Provided by Community Builder (http://joomlapolis.com)
	function jstr_ireplace($search,$replace,$subject) { 
		if(function_exists('str_ireplace')) return str_ireplace($search,$replace,$subject);
		$srchlen=strlen($search);    // lenght of searched string 
     
		while ($find = stristr($subject,$search)) {    // find $search text in $subject - case insensitiv 
			$srchtxt = substr($find,0,$srchlen);    // get new search text  
			$subject = str_replace($srchtxt,$replace,$subject);    // replace founded case insensitive search text with $replace 
		} 
		return $subject; 
	}

	function mail_mash($address) {

		$address = 'mailto:'.$address;
		for($i=0;$i<strlen($address);$i++){
			$letters[]=$address[$i];
		}
  
		while (list($key, $val) = each($letters)) {
			$r = rand(0,20);
			if ($r > 9) { $letters[$key] = '&#'.ord(
				$letters[$key]).';';
			}
		}
  
		$mashed_email_address = implode('', $letters);

		return $mashed_email_address;

	}
};


$mailer = new Mailer;

?>