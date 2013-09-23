<?php

require_once( 'common.inc.php' );

if(!$session->logged_in){

	if(isset($_POST['password_reset_submit'])){
		$returnval = $users->sendResetConfirmation($_POST['email']);
     
		if($returnval == 0){
			$_SESSION['resetemail'] = $_POST['email'];
			$_SESSION['resetsuccess'] = true;
			header("Location: forgotpassword.php");
		}elseif($returnval == 1){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: forgotpassword.php");
		}elseif($returnval == 2){
			$_SESSION['resetemail'] = $_POST['email'];
			$_SESSION['resetsuccess'] = false;
			header("Location: forgotpassword.php");
		}
	}elseif(isset($_SESSION['resetsuccess'])){
		$email = $_SESSION['resetemail'];
		if($_SESSION['resetsuccess']){
			$emailsent = sprintf($lang['Password_reset_email_sent'], $email);
			$smarty->assign(array(
				"email_sent_title" => $lang['Password_reset_email_sent_title'],
				"show_email_success" => "true",
				"email_sent" => $emailsent)
			);
		}else{
			$emailfailed = sprintf($lang['Password_reset_email_not_sent'], $email);
			$smarty->assign(array(
				"show_email_failed" => "true",
				"email_failed" => $emailfailed,
				"email_failed_title" => $lang['Password_reset_email_failed_title'])
			);
		}
		unset($_SESSION['resetsuccess']);
		unset($_SESSION['resetemail']);
	}elseif(isset($_GET['resetcode'])){
		$result = $users->sendResetPassword($_GET['resetcode']);

		if($result == 0){
			$smarty->assign(array(
				"show_reset_completed" => "true",
				"password_reset_completed_title" => $lang['Password_reset_completed_title'],
				"password_reset_completed" => $lang['Password_reset_completed'])
			);
		}elseif($result == 2){
			$smarty->assign(array(
				"show_reset_failed" => "true",
				"password_reset_failed_title" => $lang['Password_reset_failed_title'],
				"password_reset_failed" => $lang['Password_reset_failed'])
			);
		}
	}else{
		$smarty->assign(array(
				"show_password_reset" => "true",
				"email_value" => $form->value("email"),
				"email_error" => $form->error("email"),
				"L_EMAIL_ADDRESS" => $lang['Email_address'],
				"L_PASSWORD_RESET" => $lang['Password_reset'],
				"L_PASSWORD_RESET_EXPLAIN" => $lang['Password_reset_explain'],
				"L_SEND_PASSWORD_RESET_EMAIL" => $lang['Send_password_reset_email'])
		);
	}

}else{
	header("Location: index.php");
}

$smarty->display("$theme/forgotpassword.tpl");

?>