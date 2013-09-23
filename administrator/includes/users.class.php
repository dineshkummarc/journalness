<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

require_once( 'mail.class.php' );

class Users {

	function Users(){

	}

	function getUserList($offset, $limit){
		global $database, $lang;


		$query = "SELECT u.id, u.username, u.email, u.is_admin, u.is_super_admin, u.email_public, u.verified, COUNT(en.id) AS num_posts FROM #__users AS u LEFT JOIN #__entries AS en ON en.uid = u.id GROUP BY u.id ORDER BY u.id LIMIT $limit OFFSET $offset";
		$userlist = $database->getArray($query);

		for($i=0, $j=$offset; $i<count($userlist); $i++, $j++){
			$userlist[$i]['iteration'] = $j+1;

			if($userlist[$i]['is_super_admin']){
				$userlist[$i]['group'] = $lang['Superadmin'];
			}elseif($userlist[$i]['is_admin']){
				$userlist[$i]['group'] = $lang['Administrator'];
			}else{
				$userlist[$i]['group'] = $lang['Registered'];
			}
		}

		return $userlist;
	}

	function getNumUserList(){
		global $database;

		$query = "SELECT u.id, u.username, u.email, u.is_admin, u.is_super_admin, u.email_public, u.verified, COUNT(en.id) AS num_posts FROM #__users AS u LEFT JOIN #__entries AS en ON en.uid = u.id GROUP BY u.id ORDER BY u.id";
		$numResults = $database->GetArray($query);

		return count($numResults);
	}

	function getUserInfo($uid){
		global $database;

		$uid = $database->QMagic($uid);
		$query = "SELECT * FROM #__users WHERE id = $uid";
		$userInfo = $database->GetArray($query);

		if($userInfo[0]['icq'] == "0"){
			$userInfo[0]['icq'] = NULL;
		}

		if($userInfo[0]['is_super_admin']){
			$userInfo[0]['group'] = "2";
		}elseif($userInfo[0]['is_admin']){
			$userInfo[0]['group'] = "1";
		}else{
			$userInfo[0]['group'] = "0";
		}

		return $userInfo[0];
	}

	function saveUser($uid, $vars){
		global $database, $journalnessConfig_guest_name, $journalnessConfig_encrypt_type;

		$username = $database->QMagic($vars['username']);
		$email = $database->QMagic($vars['email']);
		$uid = $database->QMagic($uid);
		$query = "SELECT * FROM #__users WHERE ((username = $username OR email = $email) AND id != $uid)";
		$userdata = $database->GetArray($query);
		if(count($userdata) < 1 && $vars['username'] != $journalnessConfig_guest_name){

			$total = count($vars);
			$counter=1;

			$phpver = phpversion();
			if(extension_loaded("mhash") && !empty($vars['password']) && $journalnessConfig_encrypt_type == "sha1"){
				$tempPassword = $vars['password'] . "7b949c8716";  // A very basic salting of the password
				$vars['password'] = bin2hex(mhash(MHASH_SHA1, $tempPassword));
			}elseif($phpver >= "4.3.0" && !empty($vars['password']) && $journalnessConfig_encrypt_type == "sha1"){
				$tempPassword = $vars['password'] . "7b949c8716";  // A very basic salting of the password
				$vars['password'] = sha1($tempPassword);
			}elseif(!empty($vars['password']) && $journalnessConfig_encrypt_type == "sha1"){
				die("Please load the MHASH extension or install PHP >= 4.3.0 to use SHA-1");
			}

			if(extension_loaded("mhash") && !empty($vars['password']) && $journalnessConfig_encrypt_type == "md5"){
				$tempPassword = $vars['password'] . "7b949c8716";  // A very basic salting of the password
				$vars['password'] = bin2hex(mhash(MHASH_MD5, $tempPassword));
			}elseif($phpver >= "4.3.0" && !empty($vars['password']) && $journalnessConfig_encrypt_type == "md5"){
				$tempPassword = $vars['password'] . "7b949c8716";  // A very basic salting of the password
				$vars['password'] = md5($tempPassword);
			}

			$query = "UPDATE #__users SET";
			foreach($vars as $key => $value){
				if($value != "NULL"){
					$value = $database->QMagic($value);
				}
				if($counter == $total){
					$query .= " " . $key . " = " . $value . " ";
				}else{
					$query .= " " . $key . " = " . $value . ", ";
				}

				$counter++;
			}
			$query .= "WHERE id = $uid";

			$result = $database->Execute($query);

			return $result;
		}else{
			return false;
		}
	}

	function deleteUser($uid){
		global $database;

		$uid = $database->QMagic($uid);

		$query = "DELETE FROM #__auth WHERE uid = $uid";
		$result = $database->Execute($query);

		$query = "DELETE FROM #__users WHERE id = $uid";
		$result = $database->Execute($query);

		return $result;
	}

	function addUser($vars){
		global $database, $journalnessConfig_guest_name, $form, $mailer;
		global $journalnessConfig_def_theme, $journalnessConfig_def_language;
		global $journalnessConfig_encrypt_type;

      	$field = "user_username";
		$subuser = $vars['username'];
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
			$vars['username'] = $subuser;
      	}

		if(isset($vars['auto_generate_password'])){
			$vars['password'] = $this->generatePassword(6);
			unset($vars['auto_generate_password']);
			unset($vars['password_confirm']);
		}else{

      		$field = "user_password";
			$subpass = $vars['password'];
			$subconf = $vars['password_confirm'];
			if(!$subpass){
				$form->setError($field, "* Password has not been entered");
			}else{
				$subpass = stripslashes($subpass);
				if(strlen($subpass) < 4){
					$form->setError($field, "* Password is too small");
				}elseif(strcasecmp($subpass, $subconf) != 0){
					$form->setError($field, "* Passwords do not match");
				}
				$vars['password'] = trim($subpass);
			}

			$field = "user_password_confirm";
			if(!$subconf){
				$form->setError($field, "* Password has not been entered");
			}else{
				$subconf = stripslashes($subconf);
				if(strlen($subconf) < 4){
					$form->setError($field, "* Password is too small");
				}elseif(strcasecmp($subconf, $subpass) != 0){
					$form->setError($field, "* Passwords do not match");
				}
				//$vars['password_confirm'] = trim($subconf);
				unset($vars['password_confirm']);
			}
		}
		$originalPassword = $vars['password'];

		$field = "user_email";
		$subemail = $vars['email'];
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
			$vars['email'] = stripslashes($subemail);
		}

		$phpver = phpversion();
		if(extension_loaded("mhash") && !empty($vars['password']) && $journalnessConfig_encrypt_type == "sha1"){
			$tempPassword = $vars['password'] . "7b949c8716";  // A very basic salting of the password
			$vars['password'] = bin2hex(mhash(MHASH_SHA1, $tempPassword));
		}elseif($phpver >= "4.3.0" && !empty($vars['password']) && $journalnessConfig_encrypt_type == "sha1"){
			$tempPassword = $vars['password'] . "7b949c8716";  // A very basic salting of the password
			$vars['password'] = sha1($tempPassword);
		}elseif(!empty($vars['password']) && $journalnessConfig_encrypt_type == "sha1"){
			die("Please load the MHASH extension or install PHP >= 4.3.0 to use SHA-1");
		}

		if(extension_loaded("mhash") && !empty($vars['password']) && $journalnessConfig_encrypt_type == "md5"){
			$tempPassword = $vars['password'] . "7b949c8716";  // A very basic salting of the password
			$vars['password'] = bin2hex(mhash(MHASH_MD5, $tempPassword));
		}elseif($phpver >= "4.3.0" && !empty($vars['password']) && $journalnessConfig_encrypt_type == "md5"){
			$tempPassword = $vars['password'] . "7b949c8716";  // A very basic salting of the password
			$vars['password'] = md5($tempPassword);
		}

		if($vars['group'] == "1"){
			$vars['is_admin'] = '1';
		}else{
			$vars['is_admin'] = '0';
		}
		unset($vars['group']);

		$vars['def_user_lang'] = $journalnessConfig_def_language;
		$vars['def_user_theme'] = $journalnessConfig_def_theme;

		$sendPassword = 0;
		if(isset($vars['send_password_email'])){
			$sendPassword = $vars['send_password_email'];
		}
		unset($vars['send_password_email']);

		if($form->num_errors > 0){
			return 1;
		}else{
			$query = "INSERT INTO #__users (";
			$count = count($vars);
			$i=1;
			foreach($vars as $key => $value){
				if($i == $count){
					$query .= "" . $key . ") VALUES (";
				}else{
					$query .= "" . $key . ",";
				}
				$i++;
			}

			$i=1;
			foreach($vars as $key => $value){
				$value = $database->QMagic($value);
				if($i == $count){
					$query .= $value . ")";
				}else{
					$query .= $value . ", ";
				}
				$i++;
			}

			if($database->Execute($query)){
				if($sendPassword){
					$result = $mailer->sendPassword($vars['username'],$vars['email'],$originalPassword);
					if($result){
						$_SESSION['email_sent'] = '1';
					}else{
						$_SESSION['email_sent'] = '0';
					}
				}
				$_SESSION['add_username'] = $vars['username'];
				$_SESSION['add_password'] = $originalPassword;
				return 0;
			}else{
				return 2;
			}
		}

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

}

$users = new Users;
