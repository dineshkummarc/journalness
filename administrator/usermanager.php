<?php

require_once( 'common.admin.inc.php' );
require_once( 'includes/users.class.php' );
require_once( 'includes/templates.class.php' );
require_once( 'includes/language.class.php' );

$mode = "";
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
}

if($mode == "adduser"){
	if(isset($_POST['add_user_submit'])){
		foreach($_POST as $key => $value){
			$newkey = substr($key, 0, 5);
			if($newkey == "user_"){
				$key = substr($key, 5);
				$vars[$key] = $value;
			}
			
		}

		$returnval = $users->addUser($vars);
     
		if($returnval == 0){
			header("Location: usermanager.php?msg=" . $lang['User_added']);
		}elseif($returnval == 1){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: usermanager.php?mode=adduser");
		}elseif($returnval == 2){
			header("Location: usermanager.php?msg=" . $lang['User_not_added']);
		}

	}else{

		$smarty->assign(array(
				"showadd" => "true",
				"L_ADD_USER" => $lang['Add_user'],
				"L_USERNAME" => $lang['Username'],
				"L_USER_PASSWORD" => $lang['User_password'],
				"L_USER_PASSWORD_CONFIRM" => $lang['User_password_confirm'],
				"L_USER_EMAIL" => $lang['User_email'],
				"L_USER_PUBLIC_EMAIL" => $lang['User_public_email'],
				"yes_no_options" => array(1 => $lang['Yes'], 0 => $lang['No']),
				"L_USER_VERIFIED" => $lang['User_verified'],
				"L_USER_GROUP" => $lang['User_group'],
				"L_AUTO_GENERATE_PASSWORD" => $lang['Auto_generate_password'],
				"L_SEND_PASSWORD_EMAIL" => $lang['Send_password_email'],
				"num_errors" => $form->num_errors,
				"username_value" => $form->value("user_username"),
				"username_error" => $form->error("user_username"),
				"password_value" => $form->value("user_password"),
				"password_error" => $form->error("user_password"),
				"password_confirm_value" => $form->value("user_password_confirm"),
				"password_confirm_error" => $form->error("user_password_confirm"),
				"email_value" => $form->value("user_email"),
				"email_error" => $form->error("user_email"),
				"email_public_value" => $form->value("user_email_public"),
				"verified_value" => $form->value("user_verified"),
				"group_value" => $form->value("user_group"))
		);

		if($adminsession->is_super_admin){
			$smarty->assign(array(
				"group_options" => array(1 => $lang['Administrator'], 0 => $lang['Registered']))
			);
		}else{
			$smarty->assign(array(
				"group_options" => array(0 => $lang['Registered']))
			);
		}
	}
}elseif($mode == "edituser"){
	if(isset($_POST['edit_user_submit'])){
		foreach($_POST as $key => $value){
			$newkey = substr($key, 0, 5);
			if($newkey == "user_"){
				$key = substr($key, 5);
				$vars[$key] = $value;
			}
			
		}


		// Create Date-of-birth value
		if(empty($vars['dob_Year']) || empty($vars['dob_Day']) || empty($vars['dob_Month'])){
			$dob_date = "NULL";
		}else{
			$dob_date = $vars['dob_Year'];
			$dob_date .= "-" . $vars['dob_Month'];
			$dob_date .= "-" . $vars['dob_Day'];
		}
		$vars['dob'] = $dob_date;
		unset($vars['dob_Year']);
		unset($vars['dob_Day']);
		unset($vars['dob_Month']);


		if(!empty($_POST['password']) && !empty($_POST['password_confirm'])){
			if($_POST['password'] == $_POST['password_confirm']){
				$vars['password'] = $_POST['password'];
			}
		}

		if($_POST['group'] == "2"){
			$vars['is_super_admin'] = '1';
			$vars['is_admin'] = '1';
		}elseif($_POST['group'] == "1"){
			$vars['is_super_admin'] = '0';
			$vars['is_admin'] = '1';
		}else{
			$vars['is_super_admin'] = '0';
			$vars['is_admin'] = '0';
		}

		$result = $users->saveUser($_POST['id'], $vars);

		if($result){
			header("Location: usermanager.php?msg=" . $lang['User_saved']);
		}else{
			header("Location: usermanager.php?msg=" . $lang['User_not_saved']);
		}
	}elseif(isset($_GET['id'])){

		$userinfo = $users->getUserInfo($_GET['id']);

		if((($userinfo['group'] == "2" || $userinfo['group'] == "1") && $adminsession->is_super_admin) || $userinfo['group'] == "0"){
			$template_list = $templates->getTemplatesList();
			$language_list = $languages->getLanguagesList();

			if(empty($userinfo['dob'])){
				$userinfo['dob'] = "0000-00-00";
			}

			$smarty->assign(array(
				"showedit" => "true",
				"L_EDIT_USER" => $lang['Edit_user'],
				"L_SAVE_CHANGES" => $lang['Save_changes'],
				"userinfo" => $userinfo,
				"L_USERNAME" => $lang['Username'],
				"L_NEW_PASSWORD" => $lang['New_password'],
				"L_NEW_PASSWORD_CONFIRM" => $lang['New_password_confirm'],
				"L_USER_EMAIL" => $lang['User_email'],
				"L_USER_PUBLIC_EMAIL" => $lang['User_public_email'],
				"yes_no_options" => array(1 => $lang['Yes'], 0 => $lang['No']),
				"public_email_selected" => $userinfo['email_public'],
				"L_USER_VERIFIED" => $lang['User_verified'],
				"verified_selected" => $userinfo['verified'],
				"L_USER_GROUP" => $lang['User_group'],
				"L_USER_INFO" => $lang['User_info'],
				"L_ADDITIONAL_INFO" => $lang['Additional_info'],
				"L_USER_TEMPLATE" => $lang['User_template'],
				"L_USER_LANGUAGE" => $lang['User_language'],
				"user_language_options" => $language_list,
				"user_language_selected" => $userinfo['def_user_lang'],
				"user_template_options" => $template_list,
				"user_template_selected" => $userinfo['def_user_theme'],
				"L_USER_REALNAME" => $lang['User_realname'],
				"L_USER_DOB" => $lang['User_dob'],
				"dob_value" => $userinfo['dob'],
				"L_USER_SEX" => $lang['User_sex'],
				"sex_options" => array("M" => $lang['Male'], "F" => $lang['Female']),
				"sex_selected" => $userinfo['sex'],
				"L_USER_ICQ" => $lang['User_icq'],
				"L_USER_AIM" => $lang['User_aim'],
				"L_USER_MSN" => $lang['User_msn'],
				"L_USER_YIM" => $lang['User_yim'],
				"L_USER_WEBSITE" => $lang['User_website'],
				"L_USER_LOCATION" => $lang['User_location'],
				"L_USER_SIGNATURE" => $lang['User_signature'])
			);

			if($userinfo['group'] == "2"){
				$smarty->assign(array(
					"group_options" => array(2 => $lang['Superadmin']),
					"group_selected" => $userinfo['group'])
				);
			}else{
				$smarty->assign(array(
					"group_options" => array(1 => $lang['Administrator'], 0 => $lang['Registered']),
					"group_selected" => $userinfo['group'])
				);
			}
		}else{
			$smarty->assign(array(
				"shownotallowed" => "true",
				"L_NOT_ALLOWED_TO_EDIT_USER" => $lang['Not_allowed_to_edit_user'])
			);
		}
	}
}elseif($mode == "deleteuser"){
	if(isset($_POST['delete_user_submit'])){
		$result = $users->deleteUser($_POST['id']);

		if($result){
			header("Location: usermanager.php?msg=" . $lang['User_deleted']);
		}else{
			header("Location: usermanager.php?msg=" . $lang['User_not_deleted']);
		}
	}elseif(isset($_GET['id'])){
		$userinfo = $users->getUserInfo($_GET['id']);

		if(((($userinfo['group'] == "2" || $userinfo['group'] == "1") && $adminsession->is_super_admin) || $userinfo['group'] == "0") && $userinfo['group'] != "2"){

			if($userinfo['group'] == "2"){
				$userinfo['group'] = $lang['Superadmin'];
			}elseif($userinfo['group'] == "1"){
				$userinfo['group'] = $lang['Administrator'];
			}else{
				$userinfo['group'] = $lang['Registered'];
			}

			$smarty->assign(array(
				"MSG" => $lang['Confirm_delete_user'],
				"userinfo" => $userinfo,
				"showdelete" => "true",
				"L_DELETE_USER" => $lang['Delete_user'],
				"L_USERNAME" => $lang['Username'],
				"L_USER_EMAIL" => $lang['User_email'],
				"L_USER_GROUP" => $lang['User_group'])
			);
		}else{
			$smarty->assign(array(
				"shownotallowed" => "true",
				"L_NOT_ALLOWED_TO_DELETE_USER" => $lang['Not_allowed_to_delete_user'])
			);
		}
	}
}else{

	if(isset($_SESSION['add_username']) && isset($_SESSION['add_password'])){
		$new_username = $_SESSION['add_username'];
		$new_password = $_SESSION['add_password'];
		unset($_SESSION['add_username']);
		unset($_SESSION['add_password']);

		$smarty->assign(array(
			"new_username" => $new_username,
			"new_password" => $new_password)
		);
	}

	$msg = "";
	if(isset($_GET['msg'])){
		$msg = $_GET['msg'];

		if(isset($_SESSION['email_sent'])){
			$msg .= "<br/>" . $lang['Email_password_sent'];
			unset($_SESSION['email_sent']);
		}
	}

	if(!empty($_GET['offset'])){
		$offset = intval($_GET['offset']);
	}else{
		$offset = '0';
	}

	if(!empty($_GET['limit']) && $_GET['limit'] != "30"){
		$limit  = intval($_GET['limit']);
	}else{
		$limit  = "30";
	}

	$user_list = $users->getUserList($offset, $limit);
	$numUsers = $users->getNumUserList();

	// Create pagination
	$link = "usermanager.php?";
	require_once( 'includes/pagination.class.php' );
	$pagination = new Pagination($numUsers, $offset, $limit);

	$pageLinks = $pagination->getPageLinks($link);
	$pageCounter = $pagination->getPageCounter();

	$smarty->assign(array(
		"MSG" => $msg,
		"showmainpage" => "true",
		"user_list" => $user_list,
		"pageLinks" => $pageLinks,
		"pageCounter" => $pageCounter,
		"L_NEW_USER" => $lang['New_user'],
		"L_USER_MANAGER" => $lang['User_manager'],
		"L_USER_ID" => $lang['User_id'],
		"L_USERNAME" => $lang['Username'],
		"L_USER_PASSWORD" => $lang['User_password'],
		"L_USER_EMAIL" => $lang['User_email'],
		"L_USER_PUBLIC_EMAIL" => $lang['User_public_email'],
		"L_USER_GROUP" => $lang['User_group'],
		"L_USER_VERIFIED" => $lang['User_verified'],
		"L_USER_NUM_POSTS" => $lang['User_num_posts'])
	);

}

$smarty->display("$theme/usermanager.tpl");


?>