<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

require_once( $journalnessConfig_absolute_path . '/administrator/includes/form.class.php' );

class AdminSession
{
	var $logged_in; 		 // Whether the user is logged in or not
	var $uid; 			 // User id
	var $username;		 // Username of the user
	var $fingerprint;		 // Unique user fingerprint
	var $is_admin; 		 // Is the user an administrator
	var $is_super_admin;	 // Is the user a super administrator
	var $verified;		 // Has the user been verified?
	var $useraccess;		 // Access level of the user
	var $usertheme;		 // Default theme of the user
	var $userlanguage;	 // Default language of the user
	var $userdata = array(); // Array holding various user data

	/*
	** Class constructor
	*/
	function AdminSession(){
		global $database;

      	session_start();
		header("Cache-control: private"); // to overcome/fix a bug in IE 6.x

		/* Check if the user is logged in */
		$this->logged_in = $this->checkLogin();
	}


	function checkLogin(){
		global $database;

		if(isset($_SESSION['adminuid']) && isset($_SESSION['adminfingerprint']) && $_SESSION['adminfingerprint'] == $this->getFingerprint()){
			$this->userdata 		= $this->getUserData($_SESSION['adminuid']);
			$this->username 		= $this->userdata['username'];
			$this->uid 			= $this->userdata['id'];
			$this->is_admin		= $this->userdata['is_admin'];
			$this->is_super_admin	= $this->userdata['is_super_admin'];
			$this->useraccess		= $this->userdata['access_level'];
			$this->usertheme		= $this->userdata['def_user_theme'];
			$this->userlanguage 	= $this->userdata['def_user_lang'];
			$this->verified		= $this->userdata['verified'];
			$this->fingerprint	= $this->getFingerprint();		

			return true;
		}else{
			$this->useraccess = "0";
			return false;
		}
	}

	function login($username, $password){
		global $database, $form;
		global $journalnessConfig_absolute_path, $journalnessConfig_cookie_expire;

		$field = "username";
		if(!$username || strlen($username = trim($username)) == 0){
			$form->setError($field, "* Username not entered");
		}

      	$field = "password";
		if(!$password){
			$form->setError($field, "* Password not entered");
		}
     
		/* If errors exist go back */
		if($form->num_errors > 0){
			return false;
		}

		$username = stripslashes($username);
		$confirm = $this->confirmUserPass($username, $password);

		if($confirm == 1){
			$field = "username";
			$form->setError($field, "* Username not found");
		}else if($confirm == 2){
			$field = "password";
			$form->setError($field, "* Invalid password");
		}else if($confirm == 3){
			$field = "username";
			$form->setError($field, "* User is not admin");
		}

		if($form->num_errors > 0){
			return false;
		}

		/* Username and password are correct, register session variables */
		$this->userdata		= $this->getUserData('', $username);
		$this->fingerprint	= $_SESSION['adminfingerprint'] = $this->getFingerprint();
		$this->username  		= $this->userdata['username'];
		$this->uid			= $_SESSION['adminuid'] = $this->userdata['id'];
		$this->is_admin 		= $this->userdata['is_admin'];
		$this->is_super_admin	= $this->userdata['is_super_admin'];
		$this->useraccess		= $this->userdata['access_level'];
		$this->usertheme		= $this->userdata['def_user_theme'];
		$this->userlanguage 	= $this->userdata['def_user_lang'];
		$this->verified		= $this->userdata['verified'];

      	return true;
	}

	function logout(){
		global $database, $journalnessConfig_cookie_expire;

		unset($_SESSION['adminfingerprint']);
		unset($_SESSION['adminuid']);
		
		$this->username 		= NULL;
		$this->is_admin 		= NULL;
		$this->userdata 		= NULL;
		$this->fingerprint	= NULL;
		$this->uid			= NULL;
		$this->is_admin 		= NULL;
		$this->is_super_admin	= NULL;
		$this->useraccess		= NULL;
		$this->usertheme		= NULL;
		$this->userlanguage 	= NULL;
		$this->verified		= NULL;
		$this->logged_in 		= false;

	}

	// Modified from PHP SecureSession
	function getFingerprint(){
		global $journalnessConfig_secret_word;

		$fingerprint = $journalnessConfig_secret_word;
		$fingerprint .= "admin";
		$fingerprint .= $_SERVER['HTTP_USER_AGENT'];

      	$ipblocks = explode('.', $_SERVER['REMOTE_ADDR']);
      	for ($i=0; $i<2; $i++)
		{
			$fingerprint .= $ipblocks[$i] . '.';
		}

		return md5($fingerprint); 
	}

	function confirmUserPass($username, $password){
		global $database, $journalnessConfig_encrypt_type;

		$password = stripslashes($password);
		$phpver = phpversion();
		if(extension_loaded("mhash") && $journalnessConfig_encrypt_type == "sha1"){
			$tempPassword = $password . "7b949c8716";  // A very basic salting of the password
			$password = bin2hex(mhash(MHASH_SHA1, $tempPassword));
		}elseif($phpver >= "4.3.0" && $journalnessConfig_encrypt_type == "sha1"){
			$tempPassword = $password . "7b949c8716";  // A very basic salting of the password
			$password = sha1($tempPassword);
		}elseif($journalnessConfig_encrypt_type == "sha1"){
			die("Please load the MHASH extension or install PHP >= 4.3.0 to use SHA-1");
		}

		if(extension_loaded("mhash") && $journalnessConfig_encrypt_type == "md5"){
			$tempPassword = $password . "7b949c8716";  // A very basic salting of the password
			$password = bin2hex(mhash(MHASH_MD5, $tempPassword));
		}elseif($phpver >= "4.3.0" && $journalnessConfig_encrypt_type == "md5"){
			$tempPassword = $password . "7b949c8716";  // A very basic salting of the password
			$password = md5($tempPassword);
		}

		$username = $database->QMagic($username);

		$query = "SELECT password, is_admin FROM #__users WHERE username = $username";
		$result = $database->GetArray($query);
      	if(!$result || count($result) < 1){
			return 1; // Username failed
		}

		$dbpassword = stripslashes($result[0]['password']);

		if($password == $dbpassword){
			if($result[0]['is_admin']){
				return 0; // Confirmed
			}else{
				return 3; // Not admin
			}
		}else{
			return 2; // Password failed
		}
	}

	function getUserData($uid='', $username=''){
		global $database;

		if(!empty($username)){
			$username = $database->QMagic($username);
			$query = "SELECT * FROM #__users WHERE username = $username";
		}else{
			$uid = intval($uid);
			$query = "SELECT * FROM #__users WHERE id = '$uid'";
		}
		$userdata = $database->GetArray($query);

		if(!$userdata || count($userdata) < 1){
			return NULL;
		}

		$userdataarray = $userdata[0];

		// User access calculation
		if($userdataarray['is_admin']){
			$userdataarray['access_level'] = "2";
		}else{
			$userdataarray['access_level'] = "1";
		}

		return $userdataarray;
	}


}

$adminsession 	= new AdminSession();
$form = new Form();

?>