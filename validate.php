<?php

require_once( 'common.inc.php' );

$authcode = NULL;
if(isset($_GET['authcode'])){
	$authcode = $_GET['authcode'];
}
$mode = NULL;
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
}

if($mode == "resendvalidation"){
	if(isset($_GET['uid'])){
		$mailer->resendAuthEmail($_GET['uid']);

		$smarty->assign(array(
				"show_validation_sent" => "true",
				"L_VALIDATION_EMAIL_SENT" => $lang['Validation_email_sent'])
		);
	}
}elseif($authcode){
	$authcode = $database->QMagic($authcode);
	$query = "SELECT uid FROM #__auth WHERE authcode = $authcode";
	$result = $database->GetArray($query);
	$uid = $result[0]['uid'];

	if($uid){
		$uid = $database->QMagic($uid);
		$query = "UPDATE #__users SET verified = '1' WHERE id = $uid";
		$result = $database->Execute($query);

		$query = "DELETE FROM #__auth WHERE uid = $uid";
		$result = $database->Execute($query);

		$smarty->assign(array(
				"show_validation_complete" => "true",
				"L_VALIDATION_COMPLETED" => $lang['Validation_completed'])
		);
	}
}

$smarty->display("$theme/validate.tpl");

?>