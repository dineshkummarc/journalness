<?php

require_once( 'common.inc.php' );

if($session->logged_in){

	header("Location: index.php");
}else{
	if(isset($_POST['login'])){
      	$returnval = $session->login($_POST['username'], $_POST['password'], isset($_POST['remember']));

      	if($returnval){
         		header("Location: index.php");
			exit();
      	}else{
         		$_SESSION['value_array'] = $_POST;
         		$_SESSION['error_array'] = $form->getErrorArray();

         		header("Location: login.php");
			exit();
     		}
	}else{
		if(isset($_SESSION['not_authorized'])){
			$smarty->assign(array(
				"show_not_authorized" => "true",
				"not_authorized" => $_SESSION['not_authorized'])
			);
			unset($_SESSION['not_authorized']);
		}else{

			$smarty->assign(array(
				"show_log_in" => "true",
				"num_errors" => $form->num_errors,
				"username_value" => $form->value("username"),
				"username_error" => $form->error("username"),
				"password_value" => $form->value("password"),
				"password_error" => $form->error("password"),
				"remember_value" => $form->value("remember"),
				"L_LOGIN" => $lang['Login'],
				"L_USERNAME" => $lang['Username'],
				"L_PASSWORD" => $lang['Password'],
				"L_REMEMBER_ME" => $lang['Remember_me'])
			);
		}
	}
}

$smarty->display("$theme/login.tpl");
?>