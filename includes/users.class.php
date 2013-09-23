<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Users
{

	/*
	** Class constructor
	*/
	function Users(){
		global $database;
	}

	function getUserList(){
		global $database;

		$query = "SELECT id, username FROM #__users ORDER BY username ASC";
		$userlist = $database->getArray($query);

		return $userlist;
	}

	function getUserInfo($uid){
		global $database;

		$uid = intval($uid);
		$uid = $database->QMagic($uid);
		$query = "SELECT * FROM #__users WHERE id = $uid";
		$result = $database->GetArray($query);
		$row = NULL;

		if(isset($result[0])){
			$row = $result[0];
		}

		return $row;
	}

	function register($vars){
		global $database, $form, $mailer;
		global $journalnessConfig_guest_name, $journalnessConfig_send_welcome_email;

      	$field = "register_username";
		$subuser = $vars['register_username'];
      	if(!$subuser || strlen($subuser = trim($subuser)) == 0){
        		$form->setError($field, "* Username has not been entered");
      	}else{
         		$subuser = stripslashes($subuser);
         		if(strlen($subuser) < 4){
				$form->setError($field, "* Username is too small");
			}elseif(strlen($subuser) > 20){
				$form->setError($field, "* Username is too big");
         		}elseif(strcasecmp($subuser, $journalnessConfig_guest_name) == 0){
				$form->setError($field, "* Username is reserved");
			}elseif($this->usernameTaken($subuser)){
				$form->setError($field, "* Username is already in use");
			}
			$vars['register_username'] = $subuser;
      	}

      	$field = "register_password";
		$subpass = $vars['register_password'];
		$subconf = $vars['register_password_confirm'];
		if(!$subpass){
			$form->setError($field, "* Password has not been entered");
		}else{
			$subpass = stripslashes($subpass);
			if(strlen($subpass) < 4){
				$form->setError($field, "* Password is too small");
			}elseif(strcasecmp($subpass, $subconf) != 0){
				$form->setError($field, "* Passwords do not match");
			}
			$subpass = trim($subpass);
		}

		$field = "register_password_confirm";
		if(!$subconf){
			$form->setError($field, "* Password has not been entered");
		}else{
			$subconf = stripslashes($subconf);
			if(strlen($subconf) < 4){
				$form->setError($field, "* Password is too small");
			}elseif(strcasecmp($subconf, $subpass) != 0){
				$form->setError($field, "* Passwords do not match");
			}
			$conf = trim($subconf);
		}
		$vars['register_password'] = $subpass;
		unset($vars['register_password_confirm']);
      
		$field = "register_email";
		$subemail = $vars['register_email'];
		if(!$subemail || strlen($subemail = trim($subemail)) == 0){
			$form->setError($field, "* Email has not been entered");
		}else{
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
			."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
			."\.([a-z]{2,}){1}$";
			if(!eregi($regex,$subemail)){
				$form->setError($field, "* Invalid email address");
			}elseif($this->emailTaken($subemail)){
				$form->setError($field, "* Email address is already taken");
			}
			$subemail = stripslashes($subemail);
		}

		if($form->num_errors > 0){
			return 1;
		}else{
			if($this->addUser($vars)){
				if($journalnessConfig_send_welcome_email){
					$mailer->sendWelcome($subuser, $subemail);
				}
				return 0;
			}else{
				return 2;
			}
		}
	}

	function editprofile($vars){
		global $database, $form, $session;
		global $journalnessConfig_guest_name, $journalnessConfig_send_welcome_email;

		if(isset($vars['profile_username'])){
      		$field = "profile_username";
			$subuser = $vars['profile_username'];
      		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
        			$form->setError($field, "* Username has not been entered");
      		}else{
         			$subuser = stripslashes($subuser);
         			if(strlen($subuser) < 4){
					$form->setError($field, "* Username is too small");
				}elseif(strlen($subuser) > 20){
					$form->setError($field, "* Username is too big");
         			}elseif(strcasecmp($subuser, $journalnessConfig_guest_name) == 0){
					$form->setError($field, "* Username is reserved");
				}elseif($this->usernameTaken($subuser) && $subuser != $session->username){
					$form->setError($field, "* Username is already in use");
				}
      		}
			$vars['profile_username'] = $subuser;
		}

      	$field = "profile_newpassword";
		$subnewpass = $vars['profile_newpassword'];
		$subconf = $vars['profile_newpassword_confirm'];
		if($subnewpass){
			$subnewpass = stripslashes($subnewpass);
			if(strlen($subnewpass) < 4){
				$form->setError($field, "* Password is too small");
			}elseif(strcasecmp($subnewpass, $subconf) != 0){
				$form->setError($field, "* Passwords do not match");
			}
			$subnewpass = trim($subnewpass);
		}
		$vars['profile_newpassword_confirm'] = $subnewpass;

		$field = "profile_newpassword_confirm";
		if($subconf || $subnewpass){
			$subconf = stripslashes($subconf);
			if(strlen($subconf) < 4){
				$form->setError($field, "* Password is too small");
			}elseif(strcasecmp($subconf, $subnewpass) != 0){
				$form->setError($field, "* Passwords do not match");
			}
			$subconf = trim($subconf);
		}
		$vars['profile_newpassword_confirm'] = $subconf;
      
		$field = "profile_email";
		$subemail = $vars['profile_email'];
		if(!$subemail || strlen($subemail = trim($subemail)) == 0){
			$form->setError($field, "* Email has not been entered");
		}else{
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
			."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
			."\.([a-z]{2,}){1}$";
			if(!eregi($regex,$subemail)){
				$form->setError($field, "* Invalid email address");
			}elseif($this->emailTaken($subemail) && $session->userdata['email'] != $subemail){
				$form->setError($field, "* Email address is already taken");
			}
			$subemail = stripslashes($subemail);
		}
		$vars['profile_email'] = $subemail;

		if($form->num_errors > 0){
			return 1;
		}else{
			if($this->submitProfile($vars)){
				return 0;
			}else{
				return 2;
			}
		}
	}

	function submitProfile($vars){
		global $database, $session, $mailer, $journalnessConfig_user_activation, $journalnessConfig_encrypt_type;

		// Create Date-of-birth value
		if(empty($vars['profile_dob_Year']) || empty($vars['profile_dob_Day']) || empty($vars['profile_dob_Month'])){
			$dob_date = "NULL";
		}else{
			$dob_date = $vars['profile_dob_Year'];
			$dob_date .= "-" . $vars['profile_dob_Month'];
			$dob_date .= "-" . $vars['profile_dob_Day'];
		}
		$vars['profile_dob'] = $dob_date;
		unset($vars['profile_dob_Year']);
		unset($vars['profile_dob_Day']);
		unset($vars['profile_dob_Month']);

		// Encrypt password if neccessary
		$subpass = $vars['profile_newpassword'];
		$subconf = $vars['profile_newpassword_confirm'];
		if(($subpass && $subconf) && (strcmp($subpass, $subconf) == 0)){
			$phpver = phpversion();
			if(extension_loaded("mhash") && $journalnessConfig_encrypt_type == "sha1"){
				$tempPassword = $subpass . "7b949c8716";  // A very basic salting of the password
				$subpass = bin2hex(mhash(MHASH_SHA1, $tempPassword));
			}elseif($phpver >= "4.3.0" && $journalnessConfig_encrypt_type == "sha1"){
				$tempPassword = $subpass . "7b949c8716";  // A very basic salting of the password
				$subpass = sha1($tempPassword);
			}elseif($journalnessConfig_encrypt_type == "sha1"){
				die("Please load the MHASH extension or install PHP >= 4.3.0 to use SHA-1");
			}

			if(extension_loaded("mhash") && $journalnessConfig_encrypt_type == "md5"){
				$tempPassword = $subpass . "7b949c8716";  // A very basic salting of the password
				$subpass = bin2hex(mhash(MHASH_MD5, $tempPassword));
			}elseif($phpver >= "4.3.0" && $journalnessConfig_encrypt_type == "md5"){
				$tempPassword = $subpass . "7b949c8716";  // A very basic salting of the password
				$subpass = md5($tempPassword);
			}
			$vars['profile_password'] = $subpass;
		}
		unset($vars['profile_newpassword']);
		unset($vars['profile_newpassword_confirm']);

		// Check if email has changed
		$query = "SELECT email FROM #__users WHERE id = '" . $session->uid . "'";
		$result = $database->GetArray($query);
		$originalemail = $result[0]['email'];

		$subemail = $vars['profile_email'];
		if(strcasecmp($originalemail, $subemail) !== 0){
			if($journalnessConfig_user_activation && !$session->is_admin){
				$query = "UPDATE #__users SET email = '$subemail', verified = '0' WHERE id = '" . $session->uid . "'";
				$database->Execute($query);
				$mailer->sendAuthEmail($session->uid);
				$session->logout();
			}else{
				$query = "UPDATE #__users SET email = $subemail WHERE id = '" . $session->uid . "'";
				$database->Execute($query);
			}
		}

		foreach($vars as $key => $value){
			$newkey = substr($key, 8);
			$key = substr($key, 0, 8);
			if($key == "profile_"){
				if($value == "NULL"){
					$submit_vars[$newkey] = "NULL";
				}else{
					$submit_vars[$newkey] = $database->QMagic(htmlspecialchars($value));
				}
			}
		}

		$query = "UPDATE #__users SET ";
		$count = count($submit_vars);
		$i=1;
		foreach($submit_vars as $key => $value){
			if($count == $i){
				$query .= "" . $key . " = " . $value . " ";
			}else{
				$query .= "" . $key . " = " . $value . ", ";
			}
			$i++;
		}
		$query .= "WHERE id = '" . $session->uid . "'";
		$database->Execute($query);

		if ($database->ErrorNo()) {
			return 0;
		}

		return 1;
	}

	function addUser($vars){
		global $database, $mailer, $journalnessConfig_user_activation, $journalnessConfig_encrypt_type;

		// Create Date-of-birth value
		if(empty($vars['register_dob_Year']) || empty($vars['register_dob_Day']) || empty($vars['register_dob_Month'])){

		}else{
			$dob_date = $vars['register_dob_Year'];
			$dob_date .= "-" . $vars['register_dob_Month'];
			$dob_date .= "-" . $vars['register_dob_Day'];
			$vars['register_dob'] = $dob_date;
		}
		unset($vars['register_dob_Year']);
		unset($vars['register_dob_Day']);
		unset($vars['register_dob_Month']);

		// Encrypt password
		$subpass = $vars['register_password'];
		$phpver = phpversion();
		if(extension_loaded("mhash") && $journalnessConfig_encrypt_type == "sha1"){
			$tempPassword = $subpass . "7b949c8716";  // A very basic salting of the password
			$subpass = bin2hex(mhash(MHASH_SHA1, $tempPassword));
		}elseif($phpver >= "4.3.0" && $journalnessConfig_encrypt_type == "sha1"){
			$tempPassword = $subpass . "7b949c8716";  // A very basic salting of the password
			$subpass = sha1($tempPassword);
		}elseif($journalnessConfig_encrypt_type == "sha1"){
			die("Please load the MHASH extension or install PHP >= 4.3.0 to use SHA-1");
		}

		if(extension_loaded("mhash") && $journalnessConfig_encrypt_type == "md5"){
			$tempPassword = $subpass . "7b949c8716";  // A very basic salting of the password
			$subpass = bin2hex(mhash(MHASH_MD5, $tempPassword));
		}elseif($phpver >= "4.3.0" && $journalnessConfig_encrypt_type == "md5"){
			$tempPassword = $subpass . "7b949c8716";  // A very basic salting of the password
			$subpass = md5($tempPassword);
		}
		$vars['register_password'] = $subpass;

		if($journalnessConfig_user_activation){
			$vars['register_verified'] = "0";
		}else{
			$vars['register_verified'] = "1";
		}

		$vars['register_is_admin'] = "0";
		$vars['register_is_super_admin'] = "0";

		foreach($vars as $key => $value){
			$newkey = substr($key, 9);
			$key = substr($key, 0, 9);
			if($key == "register_"){
				$register_vars[$newkey] = $database->QMagic(htmlspecialchars($value));
			}
		}

		$query = "INSERT INTO #__users (";
		$count = count($register_vars);
		$i=1;
		foreach($register_vars as $key => $value){
			if($count == $i){
				$query .= "" . $key . ") VALUES (";
			}else{
				$query .= "" . $key . ", ";
			}
			$i++;
		}
		$i=1;
		foreach($register_vars as $key => $value){
			if($count == $i){
				$query .= $value . ")";
			}else{
				$query .= $value . ", ";
			}
			$i++;
		}
		$database->Execute($query);

		if ($database->ErrorNo()) {
			return 0;
		}

		if($journalnessConfig_user_activation){
			$uid = $database->Insert_ID();
			if(empty($uid)){
				$query = "SELECT max(id) as id FROM #__users";
				$result = $database->GetArray($query);
				$uid = $result[0]['id'];
			}
			$mailer->sendAuthEmail($uid);
		}

		return 1;
	}

	function usernameTaken($username){
		global $database;

		$username = $database->QMagic($username);
		$query = "SELECT username FROM #__users WHERE username = $username";
		$result = $database->GetArray($query);

		return (count($result) > 0);
	}

	function emailTaken($email){
		global $database;

		$email = $database->QMagic($email);
		$query = "SELECT email FROM #__users WHERE email = $email";
		$result = $database->GetArray($query);

		return (count($result) > 0);
	}

	function updateSignature($signature){
		global $entry, $session, $database;

		$signature = $entry->prepareTextInput($signature, "0");
		$query = "UPDATE #__users SET sig = " . $signature . " WHERE id = '" . $session->uid . "'";
		$database->Execute($query);

	}

	function getSignature(){
		global $session, $entry, $database;

		$query = "SELECT sig FROM #__users WHERE id = '" . $session->uid . "'";
		$result = $database->GetArray($query);
		$row['text'] = $result[0]['sig'];
		$row['html'] = $entry->prepareText($row['text']);

		return $row;
	}

	function updateClipboard($clipboard){
		global $entry, $session, $database, $lang;

		$clipboard = $entry->prepareTextInput($clipboard, "0");
		$query = "UPDATE #__users SET clip = " . $clipboard . " WHERE id = '" . $session->uid . "'";
		$result = $database->Execute($query);

	}

	function getClipboard(){
		global $session, $database;

		$query = "SELECT clip FROM #__users WHERE id = '" . $session->uid . "'";
		$result = $database->GetArray($query);
		$row = $result[0]['clip'];

		return $row;
	}

	function generatePassword($length) {
		$_vowels = array ('a', 'e', 'i', 'o', 'u');   
		$_consonants = array ('b', 'c', 'd', 'f', 'g', 'h', 'k', 'm', 'n','p', 'r', 's', 't', 'v', 'w', 'x', 'z');   
		$_syllables = array ();   
		foreach ($_vowels as $v) {
			foreach ($_consonants as $c) {   
				array_push($_syllables,"$c$v");   
				array_push($_syllables,"$v$c");
			}
		}

		$newpass = NULL;
		for( $i=0;$i<=($length/2);$i++){
			$newpass = $newpass . $_syllables[array_rand($_syllables)];
		}

		return $newpass;

	}

	function sendResetConfirmation($subemail){
		global $mailer, $form;

		$field = "email";
		if(!$subemail || strlen($subemail = trim($subemail)) == 0){
			$form->setError($field, "* Email has not been entered");
		}else{
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
			."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
			."\.([a-z]{2,}){1}$";
			if(!eregi($regex,$subemail)){
				$form->setError($field, "* Invalid email address");
			}elseif(!$this->emailTaken($subemail)){
				$form->setError($field, "* Email address does not exist");
			}
			$subemail = stripslashes($subemail);
		}

		if($form->num_errors > 0){
			return 1;
		}else{
			if($mailer->sendPasswordResetConfirm($subemail)){
				return 0;
			}else{
				return 2;
			}
		}
	}

	function sendResetPassword($resetcode){
		global $mailer, $database;

		$resetcode = $database->QMagic($resetcode);
		$query = "SELECT * FROM #__passwordreset WHERE resetcode = $resetcode";
		$result = $database->GetArray($query);

		if(count($result) > 0){
			$uid = $result[0]['uid'];
			$uid = $database->QMagic($uid);
			$query = "SELECT email FROM #__users WHERE id = $uid";
			$result = $database->GetArray($query);

			if($mailer->sendPasswordReset($result[0]['email'])){
				return 0;
			}else{
				return 2;
			}
		}else{
			return 2;
		}
	}

}

$users 	= new Users();

?>