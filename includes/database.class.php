<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

require_once( $journalnessConfig_absolute_path . '/includes/database/adodb.inc.php' );
require_once( $journalnessConfig_absolute_path . '/includes/database/session/adodb-session.php' );
require_once( $journalnessConfig_absolute_path . '/includes/database/session/adodb-encrypt-sha1.php' );
require_once( $journalnessConfig_absolute_path . '/includes/database/session/adodb-encrypt-md5.php' );
if($journalnessConfig_encrypt_type == "sha1"){
	ADODB_Session::filter(new ADODB_Encrypt_SHA1());
}elseif($journalnessConfig_encrypt_type == "md5"){
	ADODB_Session::filter(new ADODB_Encrypt_MD5());
}

$ADODB_SESSION_DRIVER=$journalnessConfig_type;
$ADODB_SESSION_CONNECT=$journalnessConfig_host;
$ADODB_SESSION_USER =$journalnessConfig_user;
$ADODB_SESSION_PWD =$journalnessConfig_password;
$ADODB_SESSION_DB =$journalnessConfig_dbname;
$ADODB_SESSION_TBL =$journalnessConfig_dbprefix . 'sessions';

/*
$ADODB_SESSION_EXPIRE_NOTIFY = array('','ExpiredSession');

adodb_sess_open(false,false,false);

function ExpiredSession($expireref, $sesskey)
{
	return;
}
*/

// Set up database object
$database = ADONewConnection($journalnessConfig_type);
$result = $database->Connect("$journalnessConfig_host", "$journalnessConfig_user", "$journalnessConfig_password", "$journalnessConfig_dbname");
if(!($result)){
	echo "Unable to connect to database.";
	exit();
}

?>