<?php

require_once( 'common.inc.php' );

if($session->logged_in || $journalnessConfig_journaltype != 0){
	header("Location: index.php");
}elseif(isset($_POST['register'])){
	if(!isset($_POST['sex'])){
		$_POST['sex'] = "";
	}

      $returnval = $users->register($_POST);
     
      if($returnval == 0){
         $_SESSION['reguname'] = $_POST['register_username'];
         $_SESSION['regsuccess'] = true;
         header("Location: register.php");
      }elseif($returnval == 1){
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: register.php");
      }elseif($returnval == 2){
         $_SESSION['reguname'] = $_POST['register_username'];
         $_SESSION['regsuccess'] = false;
         header("Location: register.php");
      }
}elseif(isset($_SESSION['regsuccess'])){
	$username = $_SESSION['reguname'];
	if($_SESSION['regsuccess']){
		$regsuccessful = sprintf($lang['User_successfully_added'], $username);
		$smarty->assign(array(
				"success_title" => $lang['Registration_success_title'],
				"show_reg_success" => "true",
				"regsuccessful" => $regsuccessful,
				"journalnessConfig_user_activation" => $journalnessConfig_user_activation,
				"validation_email_sent" => $lang['Register_validation_email_sent'])
		);
	}else{
		$regfailed = sprintf($lang['Registration_failed'], $username);
		$smarty->assign(array(
				"show_reg_failed" => "true",
				"regfailed" => $regfailed,
				"failed_title" => $lang['Registration_failed_title'])
		);
	}
	unset($_SESSION['regsuccess']);
	unset($_SESSION['reguname']);
}else{
	$email_public = $form->value("register_email_public");
	if(empty($email_public)){
		$email_public = "0";
	}

	$theme_value = $form->value("register_def_user_theme");
	if(empty($theme_value)){
		$theme_value = $journalnessConfig_def_theme;
	}

	$language_value = $form->value("register_def_user_lang");
	if(empty($language_value)){
		$langauge_value = $journalnessConfig_def_language;
	}

	$dob_month_value = $form->value("register_dob_Month");
	$dob_day_value = $form->value("register_dob_Day");
	$dob_year_value = $form->value("register_dob_Year");
	if(empty($dob_month_value) && empty($dob_day_value) && empty($dob_year_value)){
		$form->setValue("register_dob", "--");
	}else{
		$form->setValue("register_dob", $dob_year_value . "-" . $dob_month_value . "-" . $dob_day_value);
	}

	$smarty->assign(array(
		"show_register" => "true",
		"L_REGISTER" => $lang['Register'],
		"L_REGISTRATION_INFORMATION" => $lang['Registration_information'],
		"L_REQUIRED_FIELDS" => $lang['Required_fields'],
		"L_PROFILE_USERNAME" => $lang['Profile_username'],
		"L_PROFILE_EMAIL" => $lang['Profile_email'],
		"L_EMAIL_VIEWABLE" => $lang['Email_viewable'],
		"L_YES" => $lang['Yes'],
		"L_NO" => $lang['No'],
		"L_REGISTRATION_PASSWORD" => $lang['Registration_password'],
		"L_CONFIRM_REGISTRATION_PASSWORD" => $lang['Confirm_registration_password'],
		"L_PROFILE_INFORMATION" => $lang['Profile_information'],
		"L_USER_LANGUAGE" => $lang['User_language'],
		"L_USER_THEME" => $lang['User_theme'],
		"theme_options" => getThemes(),
		"cust_options" => getLanguages(),
		"def_lang" => $journalnessConfig_def_language,
		"def_theme" => $journalnessConfig_def_theme,
		"L_REAL_NAME" => $lang['Real_name'],
		"L_DOB" => $lang['DOB'],
		"L_SEX" => $lang['Sex'],
		"L_MALE" => $lang['Male'],
		"L_FEMALE" => $lang['Female'],
		"L_ICQ" => $lang['ICQ'],
		"L_AIM" => $lang['AIM'],
		"L_YIM" => $lang['YIM'],
		"L_MSN" => $lang['MSN'],
		"L_WEBSITE" => $lang['Website'],
		"L_WEB_EXAMPLE" => $lang['Web_example'],
		"L_LOCATION" => $lang['Location'],
		"num_errors" => $form->num_errors,
		"user_value" => $form->value("register_username"),
		"user_error" => $form->error("register_username"),
		"pass_value" => $form->value("register_password"),
		"pass_error" => $form->error("register_password"),
		"conf_value" => $form->value("register_password_confirm"),
		"conf_error" => $form->error("register_password_confirm"),
		"email_value" => $form->value("register_email"),
		"email_error" => $form->error("register_email"),
		"email_public_value" => $email_public,
		"theme_value" => $theme_value,
		"language_value" => $language_value,
		"realname_value" => $form->value("register_realname"),
		"dob_value" => $form->value("register_dob"),
		"sex_value" => $form->value("register_sex"),
		"icq_value" => $form->value("register_icq"),
		"aim_value" => $form->value("register_aim"),
		"yim_value" => $form->value("register_yim"),
		"msn_value" => $form->value("register_msn"),
		"website_value" => $form->value("register_website"),
		"location_value" => $form->value("register_location"))
	);

}

$smarty->display("$theme/register.tpl");

?>