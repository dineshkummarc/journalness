<?php

require_once( 'common.inc.php' );
require_once( 'includes/search.class.php' );

$search = new Search();

if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
}else{
	$mode = "viewprofile";
}

if(isset($_POST['editprofile'])){
	$editprofile = $_POST['editprofile'];
}else{
	$editprofile = false;
}

if($mode == "editprofile"){

	if($session->logged_in && $editprofile){

      	$returnval = $users->editprofile($_POST);
     
      	if($returnval == 0){
			$_SESSION['updatesuccess'] = true;
			header("Location: profile.php?mode=editprofile&msg=" . $lang['Profile_updated_title']);
		}elseif($returnval == 1){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: profile.php?mode=editprofile");
		}elseif($returnval == 2){
			$_SESSION['updatesuccess'] = false;
			header("Location: profile.php?mode=editprofile");
		}

	/*}elseif(isset($_SESSION['updatesuccess'])){
		$smarty->assign(array(
				"show_profile_updated" => "true",
				"show_user_links" => "true",
				"L_PROFILE_UPDATED_TITLE" => $lang['Profile_updated_title'],
				"L_PROFILE_UPDATED" => $lang['Profile_updated'],
				"L_RETURN_TO_INDEX" => $lang['Return_to_index'])
		);
		unset($_SESSION['updatesuccess']);
*/
	}elseif($session->logged_in){
		$row = $users->getUserInfo($session->uid);

		$username = $form->value("profile_username");
		$username_error = $form->error("profile_username");
		if(empty($username) && empty($username_error)){
			$form->setValue("profile_username", $row['username']);
		}

		$email = $form->value("profile_email");
		$email_error = $form->error("profile_email");
		if(empty($email) && empty($email_error)){
			$form->setValue("profile_email", $row['email']);
		}

		$dob = $form->value("profile_dob");
		if(empty($dob)){
			$form->setValue("profile_dob", '0000-00-00');
		}

		if(!$form->num_errors){
			if(empty($row['dob'])){
				$row['dob'] = '0000-00-00';
			}

			$form->setValue("profile_def_user_lang", $row['def_user_lang']);
			$form->setValue("profile_def_user_theme", $row['def_user_theme']);
			$form->setValue("profile_email_public", $row['email_public']);
			$form->setValue("profile_realname", $row['realname']);
			$form->setValue("profile_dob", $row['dob']);
			$form->setValue("profile_sex", $row['sex']);
			$form->setValue("profile_icq", $row['icq']);
			$form->setValue("profile_aim", $row['aim']);
			$form->setValue("profile_yim", $row['yim']);
			$form->setValue("profile_msn", $row['msn']);
			$form->setValue("profile_website", $row['website']);
			$form->setValue("profile_location", $row['location']);
		}

		$msg = NULL;
		if(isset($_GET['msg'])){
			$msg = $_GET['msg'];
		}

		$smarty->assign(array(
			"msg" => $msg,
			"show_edit_profile" => "true",
			"show_user_links" => "true",
			"allow_username_change" => $journalnessConfig_allow_username_change,
			"L_EDIT_PROFILE" => $lang['Edit_profile'],
			"L_REGISTRATION_INFORMATION" => $lang['Registration_information'],
			"L_REQUIRED_FIELDS" => $lang['Required_fields'],
			"L_PROFILE_USERNAME" => $lang['Profile_username'],
			"L_PROFILE_EMAIL" => $lang['Profile_email'],
			"L_EMAIL_VIEWABLE" => $lang['Email_viewable'],
			"L_YES" => $lang['Yes'],
			"L_NO" => $lang['No'],
			"L_NEW_PASSWORD" => $lang['New_password'],
			"L_CONFIRM_NEW_PASSWORD" => $lang['Confirm_new_password'],
			"L_CHANGING_PASSWORD" => $lang['Changing_password'],
			"L_PROFILE_INFORMATION" => $lang['Profile_information'],
			"L_USER_LANGUAGE" => $lang['User_language'],
			"L_USER_THEME" => $lang['User_theme'],
			"lang_options" => getLanguages(),
			"theme_options" => getThemes(),
			"def_lang" => $form->value("profile_def_user_lang"),
			"def_theme" => $form->value("profile_def_user_theme"),
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
			"L_SUBMIT" => $lang['Submit'],
			"num_errors" => $form->num_errors,
			"user_value" => $form->value("profile_username"),
			"user_error" => $form->error("profile_username"),
			"newpass_value" => $form->value("profile_newpassword"),
			"newpass_error" => $form->error("profile_newpassword"),
			"conf_value" => $form->value("profile_newpassword_confirm"),
			"conf_error" => $form->error("profile_newpassword_confirm"),
			"email_value" => $form->value("profile_email"),
			"email_error" => $form->error("profile_email"),
			"email_public_value" => $form->value("profile_email_public"),
			"theme_value" => $form->value("profile_def_user_theme"),
			"language_value" => $form->value("profile_def_user_lang"),
			"realname_value" => $form->value("profile_realname"),
			"dob_value" => $form->value("profile_dob"),
			"sex_value" => $form->value("profile_sex"),
			"icq_value" => $form->value("profile_icq"),
			"aim_value" => $form->value("profile_aim"),
			"yim_value" => $form->value("profile_yim"),
			"msn_value" => $form->value("profile_msn"),
			"website_value" => $form->value("profile_website"),
			"location_value" => $form->value("profile_location"))
		);

		if($journalnessConfig_user_activation){
			$smarty->assign("L_CHANGING_EMAIL", $lang['Changing_email']);
		}
	}else{
		header('Location: login.php');
		exit;
	}

}elseif($mode == "viewprofile"){
	
	if(isset($_GET['user'])){
		$userid = intval($_GET['user']);
	}else{
		$userid = "";
	}
	$userinfo = $users->getUserInfo($userid);

	if(isset($userinfo)){
	
		if($userinfo['email_public'] == "0"){
			$userinfo['email'] = $lang['Email_not_public'];
		}else{
			$userinfo['email'] = $mailer->mail_mash($userinfo['email']);
			$userinfo['email'] = "<a href=\"" . $userinfo['email'] . "\">" . $lang['Email_title'] . " " . $userinfo['username'] . "</a>";
		}

		if($userinfo['dob'] == "0000-00-00" || $userinfo['dob'] == NULL){
			$userinfo['age'] = NULL;
		}else{
			$date = explode("-", $userinfo['dob']);
			$year_diff = date("Y") - ($date[0]);
			$month_diff = date("m") - ($date[1]);
			$day_diff = date("d") - ($date[2]);
			if ($month_diff < 0){
				$year_diff--;
			}elseif ($month_diff == 0 && $day_diff < 0){
      			$year_diff--;
			}
			$userinfo['age'] = $year_diff;
		}

		$numEntries = $search->getNumUserEntries($userinfo['username']);

		$smarty->assign($userinfo);
		$smarty->assign(array(
				"show_view_profile" => "true",
				"numentries" => $numEntries,
				"L_VIEWING_PROFILE" => sprintf($lang['Viewing_profile'], $userinfo['username']),
				"L_CONTACT_INFORMATION" => sprintf($lang['Contact_information'], $userinfo['username']),
				"L_VIEW_PROFILE_INFORMATION" => sprintf($lang['View_profile_information'], $userinfo['username']),
				"L_EMAIL_ADDRESS" => $lang['Email_address'],
				"L_ICQ" => $lang['ICQ'],
				"L_AIM" => $lang['AIM'],
				"L_YIM" => $lang['YIM'],
				"L_MSN" => $lang['MSN'],
				"L_TOTAL_ENTRIES" => $lang['Total_entries'],
				"L_FIND_ALL_POSTS" => sprintf($lang['Find_all_posts'], $userinfo['username']),
				"L_VIEW_RECENT_POSTS" => sprintf($lang['View_recent_posts'], $userinfo['username']),
				"L_REAL_NAME" => $lang['Real_name'],
				"L_AGE" => $lang['Age'],
				"L_SEX" => $lang['Sex'],
				"L_MALE" => $lang['Male'],
				"L_FEMALE" => $lang['Female'],
				"L_WEBSITE" => $lang['Website'],
				"L_LOCATION" => $lang['Location'])
		);
	}else{
		$smarty->assign(array(
			"show_noprofile" => "true",
			"L_USER_NO_EXIST" => $lang['User_no_exist'])
		);
	}

}

$smarty->display("$theme/profile.tpl");

?>
