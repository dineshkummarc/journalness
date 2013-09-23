<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Mailer
{

	function sendPasswordResetConfirm($email){
		global $database, $lang;
		global $journalnessConfig_password_reset_confirm_email_from_name;
		global $journalnessConfig_password_reset_confirm_email_from_address;
		global $journalnessConfig_password_reset_confirm_email_subject;
		global $journalnessConfig_password_reset_confirm_email_msg;
		global $journalnessConfig_live_site;

		$email_address = $email;
		$email = $database->QMagic($email);
		$query = "SELECT id, username FROM #__users WHERE email = $email";
		$data = $database->GetArray($query);
		$uid = $data[0]['id'];
		$username = $data[0]['username'];

		$query = "SELECT * FROM #__passwordreset WHERE uid = '$uid'";
		$data = $database->GetArray($query);
		if(count($data) > 0){
			$resetcode = $data[0]['resetcode'];
		}else{
			$resetcode = md5(uniqid(rand(), true));
			$resetcode_insert = $database->QMagic($resetcode);
			$uid_insert = $database->QMagic($uid);
			$query = "INSERT INTO #__passwordreset (uid, resetcode) VALUES ($uid_insert, $resetcode_insert)";
			$result = $database->Execute($query);
		}

		$vars['Resetlink'] = $journalnessConfig_live_site . "/forgotpassword.php?resetcode=" . $resetcode;
		$vars['Username'] = $username;
		$message = nl2br($this->replaceVariables($journalnessConfig_password_reset_confirm_email_msg, $vars));

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= 'From: ' . $journalnessConfig_password_reset_confirm_email_from_name . '<' . $journalnessConfig_password_reset_confirm_email_from_address . ">\r\n";

		ini_set("sendmail_from", $journalnessConfig_password_reset_confirm_email_from_address);
		$result = $this->sendEmail($email_address, $journalnessConfig_password_reset_confirm_email_subject, $message, $headers);
		ini_restore("sendmail_from");

		return $result;
	}

	function sendPasswordReset($email){
		global $database, $lang, $users;
		global $journalnessConfig_password_reset_email_from_name;
		global $journalnessConfig_password_reset_email_from_address;
		global $journalnessConfig_password_reset_email_subject;
		global $journalnessConfig_password_reset_email_msg;
		global $journalnessConfig_live_site;
		global $journalnessConfig_encrypt_type;

		$email_address = $email;
		$email = $database->QMagic($email);
		$query = "SELECT id, username FROM #__users WHERE email = $email";
		$data = $database->GetArray($query);
		$uid = $data[0]['id'];
		$username = $data[0]['username'];

		$newpassword = $users->generatePassword(8);
		$phpver = phpversion();
		if(extension_loaded("mhash") && $journalnessConfig_encrypt_type == "sha1"){
			$tempPassword = $newpassword . "7b949c8716";  // A very basic salting of the password
			$newpassword_insert = bin2hex(mhash(MHASH_SHA1, $tempPassword));
		}elseif($phpver >= "4.3.0" && $journalnessConfig_encrypt_type == "sha1"){
			$tempPassword = $newpassword . "7b949c8716";  // A very basic salting of the password
			$newpassword_insert = sha1($tempPassword);
		}elseif($journalnessConfig_encrypt_type == "sha1"){
			die("Please load the MHASH extension or install PHP >= 4.3.0 to use SHA-1");
		}

		if(extension_loaded("mhash") && $journalnessConfig_encrypt_type == "md5"){
			$tempPassword = $newpassword . "7b949c8716";  // A very basic salting of the password
			$newpassword_insert = bin2hex(mhash(MHASH_MD5, $tempPassword));
		}elseif($phpver >= "4.3.0" && $journalnessConfig_encrypt_type == "md5"){
			$tempPassword = $newpassword . "7b949c8716";  // A very basic salting of the password
			$newpassword_insert = md5($tempPassword);
		}

		$newpassword_insert = $database->QMagic($newpassword_insert);

		$query = "UPDATE #__users SET password = $newpassword_insert WHERE id = '$uid'";
		$result = $database->Execute($query);

		$query = "DELETE FROM #__passwordreset WHERE uid = '$uid'";
		$result = $database->Execute($query);

		$vars['Username'] = $username;
		$vars['Password'] = $newpassword;
		$message = nl2br($this->replaceVariables($journalnessConfig_password_reset_email_msg, $vars));

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= 'From: ' . $journalnessConfig_password_reset_email_from_name . '<' . $journalnessConfig_password_reset_email_from_address . ">\r\n";

		ini_set("sendmail_from", $journalnessConfig_password_reset_email_from_address);
		$result = $this->sendEmail($email_address, $journalnessConfig_password_reset_email_subject, $message, $headers);
		ini_restore("sendmail_from");

		return $result;
	}

	function sendAuthEmail($uid){
		global $database, $lang;
		global $journalnessConfig_user_activation_email_from_name;
		global $journalnessConfig_user_activation_email_from_address;
		global $journalnessConfig_user_activation_email_subject;
		global $journalnessConfig_user_activation_email_msg;
		global $journalnessConfig_live_site;

		$uid = $database->QMagic($uid);
		$query = "SELECT email FROM #__users WHERE id = $uid";
		$email = $database->GetArray($query);
		$email = $email[0]['email'];

		$authcode = md5(uniqid(rand(), true));
		$authcode_insert = $database->QMagic($authcode);
		$query = "INSERT INTO #__auth (uid, authcode) VALUES ($uid, $authcode_insert)";
		$result = $database->Execute($query);

		$vars['Authlink'] = $journalnessConfig_live_site . "/validate.php?authcode=" . $authcode;
		$message = nl2br($this->replaceVariables($journalnessConfig_user_activation_email_msg, $vars));

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= 'From: ' . $journalnessConfig_user_activation_email_from_name . '<' . $journalnessConfig_user_activation_email_from_address . ">\r\n";

		ini_set("sendmail_from", $journalnessConfig_user_activation_email_from_address);
		$result = $this->sendEmail($email, $journalnessConfig_user_activation_email_subject, $message, $headers);
		ini_restore("sendmail_from");
	}

	function resendAuthEmail($uid){
		global $database, $lang;
		global $journalnessConfig_user_activation_email_from_name;
		global $journalnessConfig_user_activation_email_from_address;
		global $journalnessConfig_user_activation_email_subject;
		global $journalnessConfig_user_activation_email_msg;
		global $journalnessConfig_live_site;

		$query = "SELECT u.email, a.authcode FROM #__users AS u"
		. "\n LEFT JOIN #__auth AS a ON a.uid = u.id"
		. "\n WHERE u.id = $uid";
		$result = $database->GetArray($query);
		$email = $result[0]['email'];
		$authcode = $result[0]['authcode'];
		
		$vars['Authlink'] = $journalnessConfig_live_site . "/validate.php?authcode=" . $authcode;
		$message = nl2br($this->replaceVariables($journalnessConfig_user_activation_email_msg, $vars));

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= 'From: ' . $journalnessConfig_user_activation_email_from_name . '<' . $journalnessConfig_user_activation_email_from_address . ">\r\n";

		ini_set("sendmail_from", $journalnessConfig_user_activation_email_from_address);
		$result = $this->sendEmail($email, $journalnessConfig_user_activation_email_subject, $message, $headers);
		ini_restore("sendmail_from");
	}

	function sendWelcome($username, $email){
		global $database, $lang;
		global $journalnessConfig_welcome_email_from_name;
		global $journalnessConfig_welcome_email_from_address;
		global $journalnessConfig_welcome_email_subject;
		global $journalnessConfig_welcome_email_msg;
		global $journalnessConfig_live_site;
		
		$vars['Username'] = $username;
		$journalnessConfig_welcome_email_subject = $this->replaceVariables($journalnessConfig_welcome_email_subject, $vars);
		$message = nl2br($this->replaceVariables($journalnessConfig_welcome_email_msg, $vars));

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= 'From: ' . $journalnessConfig_welcome_email_from_name . '<' . $journalnessConfig_welcome_email_from_address . ">\r\n";

		ini_set("sendmail_from", $journalnessConfig_welcome_email_from_address);
		$result = $this->sendEmail($email, $journalnessConfig_welcome_email_subject, $message, $headers);
		ini_restore("sendmail_from");
	}

	function sendEmail($to, $subject, $message, $headers){
		$result = mail($to, $subject, $message, $headers);

		return $result;
	}

	function replaceVariables($msg, $vars){
		global $journalnessConfig_sitename;
		global $journalnessConfig_live_site;
		global $journalnessConfig_user_activation_email_from_name;
		global $journalnessConfig_welcome_email_from_name;

		if(isset($vars['Username'])){
			$msg = $this->jstr_ireplace("[USERNAME]", $vars['Username'], $msg);
		}
		if(isset($vars['Password'])){
			$msg = $this->jstr_ireplace("[PASSWORD]", $vars['Password'], $msg);
		}
		$msg = $this->jstr_ireplace("[SITELINK]", $journalnessConfig_live_site, $msg);
		if(isset($vars['Authlink'])){
			$msg = $this->jstr_ireplace("[AUTHLINK]", "<a href=\"" . $vars['Authlink'] . "\">" . $vars['Authlink'] . "</a>", $msg);
		}
		if(isset($vars['Resetlink'])){
			$msg = $this->jstr_ireplace("[RESETLINK]", "<a href=\"" . $vars['Resetlink'] . "\">" . $vars['Resetlink'] . "</a>", $msg);
		}
		$msg = $this->jstr_ireplace("[WELCOMEEMAILNAME]", $journalnessConfig_welcome_email_from_name, $msg);
		$msg = $this->jstr_ireplace("[ACTIVATIONEMAILNAME]", $journalnessConfig_user_activation_email_from_name, $msg);
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