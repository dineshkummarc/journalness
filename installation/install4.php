<?php
/**
* Installer heavily based off of Joomla! (http://www.joomla.org) Installer
*/


// Includes
require_once( 'common.php' );
require_once( '../includes/database/adodb.inc.php' );
require_once( '../includes/database/adodb-errorpear.inc.php' ); 

$DBtype	= getParam( $_POST, 'DBtype', '');
$DBhostname = getParam( $_POST, 'DBhostname', '' );
$DBuserName = getParam( $_POST, 'DBuserName', '' );
$DBpassword = getParam( $_POST, 'DBpassword', '' );
$DBname  	= getParam( $_POST, 'DBname', '' );
$DBPrefix  	= getParam( $_POST, 'DBPrefix', '' );
$sitename  	= getParam( $_POST, 'sitename', '' );
$adminEmail = getParam( $_POST, 'adminEmail', '');
$siteUrl  	= getParam( $_POST, 'siteUrl', '' );
$absolutePath = getParam( $_POST, 'absolutePath', '' );
$adminPassword = getParam( $_POST, 'adminPassword', '');
$def_language = getParam( $_POST, 'def_language', '');
$user_activation = getParam( $_POST, 'user_activation', '');

$filePerms = '';
if (getParam($_POST,'filePermsMode',0))
	$filePerms = '0'.
		(getParam($_POST,'filePermsUserRead',0) * 4 +
		 getParam($_POST,'filePermsUserWrite',0) * 2 +
		 getParam($_POST,'filePermsUserExecute',0)).
		(getParam($_POST,'filePermsGroupRead',0) * 4 +
		 getParam($_POST,'filePermsGroupWrite',0) * 2 +
		 getParam($_POST,'filePermsGroupExecute',0)).
		(getParam($_POST,'filePermsWorldRead',0) * 4 +
		 getParam($_POST,'filePermsWorldWrite',0) * 2 +
		 getParam($_POST,'filePermsWorldExecute',0));

$dirPerms = '';
if (getParam($_POST,'dirPermsMode',0))
	$dirPerms = '0'.
		(getParam($_POST,'dirPermsUserRead',0) * 4 +
		 getParam($_POST,'dirPermsUserWrite',0) * 2 +
		 getParam($_POST,'dirPermsUserSearch',0)).
		(getParam($_POST,'dirPermsGroupRead',0) * 4 +
		 getParam($_POST,'dirPermsGroupWrite',0) * 2 +
		 getParam($_POST,'dirPermsGroupSearch',0)).
		(getParam($_POST,'dirPermsWorldRead',0) * 4 +
		 getParam($_POST,'dirPermsWorldWrite',0) * 2 +
		 getParam($_POST,'dirPermsWorldSearch',0));

if ((trim($adminEmail== "")) || (preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $adminEmail )==false)) {
	echo "<form name=\"stepBack\" method=\"post\" action=\"install3.php\">
		<input type=\"hidden\" name=\"DBtype\" value=\"$DBtype\" />
		<input type=\"hidden\" name=\"DBhostname\" value=\"$DBhostname\" />
		<input type=\"hidden\" name=\"DBuserName\" value=\"$DBuserName\" />
		<input type=\"hidden\" name=\"DBpassword\" value=\"$DBpassword\" />
		<input type=\"hidden\" name=\"DBname\" value=\"$DBname\" />
		<input type=\"hidden\" name=\"DBPrefix\" value=\"$DBPrefix\" />
		<input type=\"hidden\" name=\"DBcreated\" value=\"1\" />
		<input type=\"hidden\" name=\"sitename\" value=\"$sitename\" />
		<input type=\"hidden\" name=\"adminEmail\" value=\"$adminEmail\" />
		<input type=\"hidden\" name=\"siteUrl\" value=\"$siteUrl\" />
		<input type=\"hidden\" name=\"absolutePath\" value=\"$absolutePath\" />
		<input type=\"hidden\" name=\"def_language\" value=\"$def_language\" />
		<input type=\"hidden\" name=\"user_activation\" value=\"$user_activation\" />
		<input type=\"hidden\" name=\"filePerms\" value=\"$filePerms\" />
		<input type=\"hidden\" name=\"dirPerms\" value=\"$dirPerms\" />
		</form>";
	echo "<script>alert('You must provide a valid admin email address.'); window.onload=function(){ document.stepBack.submit(); } </script>";
	return;
}

if($DBhostname && $DBuserName && $DBname) {
	$configArray['DBtype']		= $DBtype;
	$configArray['DBhostname']	= $DBhostname;
	$configArray['DBuserName']	= $DBuserName;
	$configArray['DBpassword']	= $DBpassword;
	$configArray['DBname']	 	= $DBname;
	$configArray['DBPrefix']	= $DBPrefix;
} else {
	echo "<form name=\"stepBack\" method=\"post\" action=\"install3.php\">
		<input type=\"hidden\" name=\"DBtype\" value=\"$DBtype\" />
		<input type=\"hidden\" name=\"DBhostname\" value=\"$DBhostname\" />
		<input type=\"hidden\" name=\"DBuserName\" value=\"$DBuserName\" />
		<input type=\"hidden\" name=\"DBpassword\" value=\"$DBpassword\" />
		<input type=\"hidden\" name=\"DBname\" value=\"$DBname\" />
		<input type=\"hidden\" name=\"DBPrefix\" value=\"$DBPrefix\" />
		<input type=\"hidden\" name=\"DBcreated\" value=\"1\" />
		<input type=\"hidden\" name=\"sitename\" value=\"$sitename\" />
		<input type=\"hidden\" name=\"adminEmail\" value=\"$adminEmail\" />
		<input type=\"hidden\" name=\"siteUrl\" value=\"$siteUrl\" />
		<input type=\"hidden\" name=\"absolutePath\" value=\"$absolutePath\" />
		<input type=\"hidden\" name=\"def_language\" value=\"$def_language\" />
		<input type=\"hidden\" name=\"user_activation\" value=\"$user_activation\" />
		<input type=\"hidden\" name=\"filePerms\" value=\"$filePerms\" />
		<input type=\"hidden\" name=\"dirPerms\" value=\"$dirPerms\" />
		</form>";

	echo "<script>alert('The database details provided are incorrect and/or empty'); document.stepBack.submit(); </script>";
	return;
}

if ($sitename) {
	if (!get_magic_quotes_gpc()) {
		$configArray['sitename'] = addslashes($sitename);
	} else {
		$configArray['sitename'] = $sitename;
	}
} else {
	echo "<form name=\"stepBack\" method=\"post\" action=\"install3.php\">
		<input type=\"hidden\" name=\"DBtype\" value=\"$DBtype\" />
		<input type=\"hidden\" name=\"DBhostname\" value=\"$DBhostname\" />
		<input type=\"hidden\" name=\"DBuserName\" value=\"$DBuserName\" />
		<input type=\"hidden\" name=\"DBpassword\" value=\"$DBpassword\" />
		<input type=\"hidden\" name=\"DBname\" value=\"$DBname\" />
		<input type=\"hidden\" name=\"DBPrefix\" value=\"$DBPrefix\" />
		<input type=\"hidden\" name=\"DBcreated\" value=\"1\" />
		<input type=\"hidden\" name=\"sitename\" value=\"$sitename\" />
		<input type=\"hidden\" name=\"adminEmail\" value=\"$adminEmail\" />
		<input type=\"hidden\" name=\"siteUrl\" value=\"$siteUrl\" />
		<input type=\"hidden\" name=\"absolutePath\" value=\"$absolutePath\" />
		<input type=\"hidden\" name=\"def_language\" value=\"$def_language\" />
		<input type=\"hidden\" name=\"user_activation\" value=\"$user_activation\" />
		<input type=\"hidden\" name=\"filePerms\" value=\"$filePerms\" />
		<input type=\"hidden\" name=\"dirPerms\" value=\"$dirPerms\" />
		</form>";

	echo "<script>alert('The sitename has not been provided'); document.stepBack2.submit();</script>";
	return;
}

if (file_exists( '../config.php' )) {
	$canWrite = is_writable( '../config.php' );
} else {
	$canWrite = is_writable( '..' );
}

if ($siteUrl) {
	$configArray['siteUrl']=$siteUrl;
	// Fix for Windows
	$absolutePath= str_replace("\\\\","/", $absolutePath);
	$configArray['absolutePath']=$absolutePath;
	$configArray['secret_word'] = generateSecret(15);
	$configArray['filePerms']=$filePerms;
	$configArray['dirPerms']=$dirPerms;
	$configArray['def_language']=$def_language;
	$configArray['user_activation']=$user_activation;
	$configArray['adminEmail']=$adminEmail;
	$configArray['adminName']="admin";

	$config = "<?php\n";
	$config .= "\$journalnessConfig_offline = '0';\n";
	$config .= "\$journalnessConfig_offline_msg = 'This journal is currently offline. Please try back later.

Thank you';\n";
	$config .= "\$journalnessConfig_admin_name = '{$configArray['adminName']}';\n";
	$config .= "\$journalnessConfig_admin_email = '{$configArray['adminEmail']}';\n";
	$config .= "\$journalnessConfig_journaltype = '1';\n";
	$config .= "\$journalnessConfig_post_level = '1';\n";
	$config .= "\$journalnessConfig_allow_comments = '1';\n";
	$config .= "\$journalnessConfig_rss = '1';\n";
	$config .= "\$journalnessConfig_atom = '0';\n";
	$config .= "\$journalnessConfig_anon_comments = '1';\n";
	$config .= "\$journalnessConfig_user_activation = '{$configArray['user_activation']}';\n";
	$config .= "\$journalnessConfig_allow_username_change = '1';\n";
	$config .= "\$journalnessConfig_next_prev = '1';\n";
	$config .= "\$journalnessConfig_show_user_sidebar = '1';\n";
	$config .= "\$journalnessConfig_show_hit_count = '0';\n";
	$config .= "\$journalnessConfig_show_recent_entries_sidebar = '1';\n";
	$config .= "\$journalnessConfig_num_recent_entries_sidebar = '5';\n";
	$config .= "\$journalnessConfig_newest_entries = '3';\n";
	$config .= "\$journalnessConfig_list_limit = '15';\n";
	$config .= "\$journalnessConfig_type = '{$configArray['DBtype']}';\n";
	$config .= "\$journalnessConfig_host = '{$configArray['DBhostname']}';\n";
	$config .= "\$journalnessConfig_user = '{$configArray['DBuserName']}';\n";
	$config .= "\$journalnessConfig_password = '{$configArray['DBpassword']}';\n";
	$config .= "\$journalnessConfig_dbname = '{$configArray['DBname']}';\n";
	$config .= "\$journalnessConfig_dbprefix = '{$configArray['DBPrefix']}';\n";
	$config .= "\$journalnessConfig_sitename = '{$configArray['sitename']}';\n";
	$config .= "\$journalnessConfig_guest_name = 'Anonymous User';\n";
	$config .= "\$journalnessConfig_absolute_path = '{$configArray['absolutePath']}';\n";
	$config .= "\$journalnessConfig_live_site = '{$configArray['siteUrl']}';\n";
	$config .= "\$journalnessConfig_secret_word = '{$configArray['secret_word']}';\n";
	$config .= "\$journalnessConfig_encrypt_type = 'sha1';\n";
	$config .= "\$journalnessConfig_send_welcome_email = '1';\n";
	$config .= "\$journalnessConfig_welcome_email_from_name = 'Your Name';\n";
	$config .= "\$journalnessConfig_welcome_email_from_address = 'youremail@yourwebsite.com';\n";
	$config .= "\$journalnessConfig_welcome_email_subject = 'Welcome to [SITENAME]';\n";
	$config .= "\$journalnessConfig_welcome_email_msg = '[USERNAME],

Thank you for signing up at [SITENAME]. We hope you enjoy your stay.


For future reference the website is located at [SITELINK].


Regards,

-[WELCOMEEMAILNAME]';\n";
	$config .= "\$journalnessConfig_user_activation_email_from_name = 'Your Name';\n";
	$config .= "\$journalnessConfig_user_activation_email_from_address = 'youremail@yourwebsite.com';\n";
	$config .= "\$journalnessConfig_user_activation_email_subject = 'Journalness Account Validation';\n";
	$config .= "\$journalnessConfig_user_activation_email_msg = 'Congratulations, you have successfully registered in the journal at [SITELINK], but this journal requires validation before you can use it.

To complete your registration please click the link below:

_________________________________

[AUTHLINK]
_________________________________


Thank you,

-[ACTIVATIONEMAILNAME]';\n";
	$config .= "\$journalnessConfig_password_email_from_name = 'Your Name';\n";
	$config .= "\$journalnessConfig_password_email_from_address = 'youremail@yourwebsite.com';\n";
	$config .= "\$journalnessConfig_password_email_subject = 'User Account Details';\n";
	$config .= "\$journalnessConfig_password_email_msg = 'Your user account at [SITENAME] has been successfully created. You can log in using the credentials provided below.

_________________________

Username: [USERNAME]
Password: [PASSWORD]
_________________________


Thank you.

-Site Admin';\n";
	$config .= "\$journalnessConfig_password_reset_confirm_email_from_name = 'Your Name';\n";
	$config .= "\$journalnessConfig_password_reset_confirm_email_from_address = 'youremail@yourwebsite.com';\n";
	$config .= "\$journalnessConfig_password_reset_confirm_email_subject = 'Confirm Password Reset';\n";
	$config .= "\$journalnessConfig_password_reset_confirm_email_msg = 'A password reset request for your username ([USERNAME]) at [SITENAME] has been requested. If you want to reset your password please follow the link below.

_________________________

[RESETLINK]
_________________________


Thank you.

-Site Admin';\n";
	$config .= "\$journalnessConfig_password_reset_email_from_name = 'Your Name';\n";
	$config .= "\$journalnessConfig_password_reset_email_from_address = 'youremail@yourwebsite.com';\n";
	$config .= "\$journalnessConfig_password_reset_email_subject = 'Your new account details';\n";
	$config .= "\$journalnessConfig_password_reset_email_msg = 'The password for your username ([USERNAME]) at [SITENAME] has been reset. You can log in with the account details listed below.

_________________________

Username: [USERNAME]
Password: [PASSWORD]
_________________________


Thank you.

-Site Admin';\n";
	$config .= "\$journalnessConfig_allow_uploads = '1';\n";
	$config .= "\$journalnessConfig_upload_type = '0';\n";
	$config .= "\$journalnessConfig_max_upload_size = '250';\n";
	$config .= "\$journalnessConfig_resize_images = '0';\n";
	$config .= "\$journalnessConfig_resize_images_height = '800';\n";
	$config .= "\$journalnessConfig_resize_images_width = '600';\n";
	$config .= "\$journalnessConfig_show_calendar = '1';\n";
	$config .= "\$journalnessConfig_def_language = '{$configArray['def_language']}';\n";
	$config .= "\$journalnessConfig_override_user_language = '0';\n";
	$config .= "\$journalnessConfig_def_theme = 'classic';\n";
	$config .= "\$journalnessConfig_override_user_theme = '0';\n";
	$config .= "\$journalnessConfig_cookie_expire = '31536000';\n";
	$config .= "?>";

	if ($canWrite && ($fp = fopen("../config.php", "w"))) {
		fputs( $fp, $config, strlen( $config ) );
		fclose( $fp );
	} else {
		$canWrite = false;
	} // if

	$phpver = phpversion();

	if(extension_loaded("mhash")){
		$tempAdminPassword = $adminPassword . "7b949c8716";  // A very basic salting of the password
		$sha1pass = bin2hex(mhash(MHASH_SHA1, $tempAdminPassword));
	}elseif($phpver >= "4.3.0"){
		$tempAdminPassword = $adminPassword . "7b949c8716";  // A very basic salting of the password
		$sha1pass = sha1($tempAdminPassword);
	}else{
		die("Please load the MHASH extension or install PHP >= 4.3.0 to use SHA-1");
	}

	// For use with replacePrefix
	$journalnessConfig_dbprefix = $DBPrefix;

	$database = ADONewConnection($DBtype);
	$result = $database->Connect("$DBhostname", "$DBuserName", "$DBpassword", "$DBname");

	// create the admin user
	$query = "INSERT INTO #__users (id, username, password, is_admin, is_super_admin, email, email_public, verified, def_user_lang, def_user_theme) VALUES ('1', 'admin', '$sha1pass', '1', '1', '$adminEmail', '0', '1', '$def_language', 'classic')";
	$database->Execute( $query );

	// chmod files and directories if desired
	$chmod_report = "Directory and file permissions left unchanged.";
	if ($filePerms != '' || $dirPerms != '') {
		$mosrootfiles = array(
			'images',
			'language',
			'templates',
			'templates_c',
			'uploads',
			'config.php'
		);
		$filemode = NULL;
		if ($filePerms != '') $filemode = octdec($filePerms);
		$dirmode = NULL;
		if ($dirPerms != '') $dirmode = octdec($dirPerms);
		$chmodOk = TRUE;
		foreach ($mosrootfiles as $file) {
			if (!mosChmodRecursive($absolutePath.'/'.$file, $filemode, $dirmode)) {
				$chmodOk = FALSE;
			}
		}
		if ($chmodOk) {
			$chmod_report = 'File and directory permissions successfully changed.';
		} else {
			$chmod_report = 'File and directory permissions could not be changed.<br />'.
							'Please CHMOD Journalness files and directories manually.';
		}
	} // if chmod wanted
} else {
?>
	<form action="install3.php" method="post" name="stepBack3" id="stepBack3">
	  <input type="hidden" name="DBtype" value="<?php echo $DBtype; ?>" />
	  <input type="hidden" name="DBhostname" value="<?php echo $DBhostname;?>" />
	  <input type="hidden" name="DBusername" value="<?php echo $DBuserName;?>" />
	  <input type="hidden" name="DBpassword" value="<?php echo $DBpassword;?>" />
	  <input type="hidden" name="DBname" value="<?php echo $DBname;?>" />
	  <input type="hidden" name="DBPrefix" value="<?php echo $DBPrefix;?>" />
	  <input type="hidden" name="DBcreated" value="1" />
	  <input type="hidden" name="sitename" value="<?php echo $sitename;?>" />
	  <input type="hidden" name="adminEmail" value="$adminEmail" />
	  <input type="hidden" name="siteUrl" value="$siteUrl" />
	  <input type="hidden" name="absolutePath" value="$absolutePath" />
	  <input type="hidden" name="filePerms" value="$filePerms" />
	  <input type="hidden" name="dirPerms" value="$dirPerms" />
	</form>
	<script>alert('The site url has not been provided'); document.stepBack3.submit();</script>
<?php
}


function generateSecret($length){
	$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
	for($i=0;$i<$length;$i++){
		if(isset($key)){
			$key .= $pattern{rand(0,35)};
		}else{
			$key = $pattern{rand(0,35)};
		}
	}
	return $key;
}


echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Journalness Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../images/favicon.ico" />
<link rel="stylesheet" href="install.css" type="text/css" />
</head>
<body>
<div id="wrapper">
	<div id="header">
		Journalness Installer
	</div>
</div>
<div id="ctr" align="center">
	<form action="dummy" name="form" id="form">
	<div class="install">
		<div id="stepbar">
			<div class="step-off">pre-installation check</div>
			<div class="step-off">license</div>
			<div class="step-off">step 1</div>
			<div class="step-off">step 2</div>
			<div class="step-off">step 3</div>
			<div class="step-on">step 4</div>
		</div>
		<div id="right">
			<div id="step">step 4</div>
			<div class="far-right">
				<input class="button" type="button" name="runSite" value="View Site"
<?php
				if ($siteUrl) {
					echo "onClick=\"window.location.href='$siteUrl/index.php' \"";
				} else {
					echo "onClick=\"window.location.href='".$configArray['siteURL']."/index.php' \"";
				}
?>/>
				<input class="button" type="button" name="Admin" value="Administration"
<?php
				if ($siteUrl) {
					echo "onClick=\"window.location.href='$siteUrl/administrator/index.php' \"";
				} else {
					echo "onClick=\"window.location.href='".$configArray['siteURL']."/administrator/index.php' \"";
				}
?>/>
			</div>
			<div class="clr"></div>
			<h1>Congratulations! Journalness is installed</h1>
			<div class="install-text">
				<p>Click the "View Site" button to start Journalness or "Administration"
					to take you to administrator login.</p>
			</div>
			<div class="install-form">
				<div class="form-block">
					<table width="100%">
						<tr><td class="error" align="center">PLEASE REMEMBER TO COMPLETELY<br/>REMOVE THE INSTALLATION DIRECTORY</td></tr>
						<tr><td align="center"><h5>Administration Login Details</h5></td></tr>
						<tr><td align="center" class="notice"><b>Username : admin</b></td></tr>
						<tr><td align="center" class="notice"><b>Password : <?php echo $adminPassword; ?></b></td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td align="right">&nbsp;</td></tr>
<?php						if (!$canWrite) { ?>
						<tr>
							<td class="small">
								Your config file or directory is not writeable,
								or there was a problem creating the configuration file. You'll have to
								upload the following code by hand. Click in the textarea to highlight
								all of the code.
							</td>
						</tr>
						<tr>
							<td align="center">
								<textarea rows="5" cols="60" name="configcode" onclick="javascript:this.form.configcode.focus();this.form.configcode.select();" ><?php echo htmlspecialchars( $config );?></textarea>
							</td>
						</tr>
<?php						} ?>
						<tr><td class="small"><?php /*echo $chmod_report*/; ?></td></tr>
					</table>
				</div>
			</div>
			<div id="break"></div>
		</div>
		<div class="clr"></div>
	</div>
	</form>
</div>
<div class="clr"></div>
</html>