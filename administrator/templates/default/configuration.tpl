{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{if $adminsession_useraccess == "2"}

<div class="centered" style="padding-top:2em;">
  <span style="color:red; font-weight:bold;">{$MSG}</span>
</div>

<div class="configtabs">
  <form action="configuration.php" method="post">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_JOURNALNESS_CONFIGURATION}</h1>
	</td>
	<td align="right" valign="bottom">
	  <input class="button2" type="submit" value="{$L_SAVE_CONFIG}" name="save_config"/>
	</td>
    </tr>
  </table>
  <div class="tabber">

    <div class="tabbertab" title="{$L_CONFIG_GENERAL}">
	<table cellpadding="5" cellspacing="0" border="0" width="100%" class="configform">
	  <tr align="center" valign="middle">
	    <th class="config_column1">&nbsp;</th>
	    <th class="config_column2">{$L_CURRENT_SETTING}</th>
	    <th class="config_column3">{$L_EXPLANATION}</th>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_OFFLINE}</td>
	    <td align="left" valign="top">
		{html_radios name="config_offline" options=$yes_no_radio selected=$config_offline_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_OFFLINE_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_OFFLINE_MSG}</td>
	    <td align="left" valign="top">
		<textarea cols="52" rows="5" name="config_offline_msg">{$config_offline_msg_value}</textarea>
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_OFFLINE_MSG_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_ADMIN_NAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_admin_name" value="{$config_admin_name_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_ADMIN_NAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_ADMIN_EMAIL}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_admin_email" value="{$config_admin_email_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_ADMIN_EMAIL_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_JOURNALTYPE}</td>
	    <td align="left" valign="top">
		{html_radios name="config_journaltype" options=$journaltype_radio selected=$config_journaltype_selected separator="<br/>"}
	    </td>
	    <td align="left" valign="top">
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_POST_LEVEL}</td>
	    <td align="left" valign="top">
		{html_radios name="config_post_level" options=$post_level_radio selected=$config_post_level_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_POST_LEVEL_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_RSS}</td>
	    <td align="left" valign="top">
		{html_radios name="config_rss" options=$yes_no_radio selected=$config_rss_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_RSS_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_ATOM}</td>
	    <td align="left" valign="top">
		{html_radios name="config_atom" options=$yes_no_radio selected=$config_atom_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_ATOM_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_ALLOW_COMMENTS}</td>
	    <td align="left" valign="top">
		{html_radios name="config_allow_comments" options=$yes_no_radio selected=$config_allow_comments_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_ALLOW_COMMENTS_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_ANON_COMMENTS}</td>
	    <td align="left" valign="top">
		{html_radios name="config_anon_comments" options=$yes_no_radio selected=$config_anon_comments_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_ANON_COMMENTS_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION}</td>
	    <td align="left" valign="top">
		{html_radios name="config_user_activation" options=$yes_no_radio selected=$config_user_activation_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_ALLOW_USERNAME_CHANGE}</td>
	    <td align="left" valign="top">
		{html_radios name="config_allow_username_change" options=$yes_no_radio selected=$config_allow_username_change_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_ALLOW_USERNAME_CHANGE_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_NEXT_PREV}</td>
	    <td align="left" valign="top">
		{html_radios name="config_next_prev" options=$yes_no_radio selected=$config_next_prev_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_NEXT_PREV_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_SHOW_USER_SIDEBAR}</td>
	    <td align="left" valign="top">
		{html_radios name="config_show_user_sidebar" options=$yes_no_radio selected=$config_show_user_sidebar_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_SHOW_USER_SIDEBAR_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_SHOW_HIT_COUNT}</td>
	    <td align="left" valign="top">
		{html_radios name="config_show_hit_count" options=$yes_no_radio selected=$config_show_hit_count_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_SHOW_HIT_COUNT_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_SHOW_RECENT_ENTRIES_SIDEBAR}</td>
	    <td align="left" valign="top">
		{html_radios name="config_show_recent_entries_sidebar" options=$yes_no_radio selected=$config_show_recent_entries_sidebar_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_SHOW_RECENT_ENTRIES_SIDEBAR_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_NUM_RECENT_ENTRIES_SIDEBAR}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_num_recent_entries_sidebar" size="3" value="{$config_num_recent_entries_sidebar_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_NUM_RECENT_ENTRIES_SIDEBAR_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_NEWEST_ENTRIES}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_newest_entries" size="3" value="{$config_newest_entries_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_NEWEST_ENTRIES_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_LIST_LIMIT}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_list_limit" size="3" value="{$config_list_limit_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_LIST_LIMIT_EXPLAIN}</td>
	  </tr>
	</table>
    </div>

    <div class="tabbertab" title="{$L_CONFIG_DATABASE}">
	<table cellpadding="5" cellspacing="0" border="0" width="100%" class="configform">
	  <tr align="center" valign="middle">
	    <th class="config_column1">&nbsp;</th>
	    <th class="config_column2">{$L_CURRENT_SETTING}</th>
	    <th class="config_column3">{$L_EXPLANATION}</th>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_HOST}</td>
	    <td align="left" valign="top">
		<input type="hidden" name ="config_type" value="" />
		<input type="text" name="config_host" value="{$config_host_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_HOST_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_USER}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_user" value="{$config_user_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_USER_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password" value="{$L_CONFIG_PASSWORD_VIEW}" readonly="readonly" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_DBNAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_dbname" value="{$config_dbname_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_DBNAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_DBPREFIX}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_dbprefix" value="{$config_dbprefix_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_DBPREFIX_EXPLAIN}</td>
	  </tr>
	</table>
    </div>

    <div class="tabbertab" title="{$L_CONFIG_SERVER}">
	<table cellpadding="5" cellspacing="0" border="0" width="100%" class="configform">
	  <tr align="center" valign="middle">
	    <th class="config_column1">&nbsp;</th>
	    <th class="config_column2">{$L_CURRENT_SETTING}</th>
	    <th class="config_column3">{$L_EXPLANATION}</th>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_SITENAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_sitename" value="{$config_sitename_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_SITENAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_GUEST_NAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_guest_name" value="{$config_guest_name_value}" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_GUEST_NAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_ABSOLUTE_PATH}</td>
	    <td align="left" valign="top" colspan="2">
		<input type="hidden" name="config_absolute_path" value="" />
		<strong>{$config_absolute_path_value}</strong>
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_LIVE_SITE}</td>
	    <td align="left" valign="top" colspan="2">
		<input type="hidden" name="config_live_site" value="" />
		<strong>{$config_live_site_value}</strong>
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_SECRET_WORD}</td>
	    <td align="left" valign="top" colspan="2">
		<input type="hidden" name="config_secret_word" value="" />
		<strong>{$config_secret_word_value}</strong>
	    </td>
	  </tr>
	</table>
    </div>

    <div class="tabbertab" title="{$L_CONFIG_MAIL}">
	<table cellpadding="5" cellspacing="0" border="0" width="100%" class="configform">
	  <tr align="center" valign="middle">
	    <th class="config_column1">&nbsp;</th>
	    <th class="config_column2">{$L_CURRENT_SETTING}</th>
	    <th class="config_column3">{$L_EXPLANATION}</th>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_SEND_WELCOME_EMAIL}</td>
	    <td align="left" valign="top">
		{html_radios name="config_send_welcome_email" options=$yes_no_radio selected=$config_send_welcome_email_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_SEND_WELCOME_EMAIL_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_WELCOME_EMAIL_FROM_NAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_welcome_email_from_name" value="{$config_welcome_email_from_name_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_WELCOME_EMAIL_FROM_NAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_WELCOME_EMAIL_FROM_ADDRESS}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_welcome_email_from_address" value="{$config_welcome_email_from_address_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_WELCOME_EMAIL_FROM_ADDRESS_EXPLAIN}</td>
	  </tr>
	  <tr align="left" valign="middle">
	    <td align="left" valign="top"></td>
	    <td align="left" valign="top" colspan="2">
		{$L_CONFIG_WELCOME_EMAIL_MSG_EXPLAIN}
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_WELCOME_EMAIL_SUBJECT}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_welcome_email_subject" value="{$config_welcome_email_subject_value}" size="40" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_WELCOME_EMAIL_SUBJECT_EXPLAIN}</td>
	  </tr>
        <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_WELCOME_EMAIL_MSG}</td>
	    <td align="left" valign="top" colspan="2">
		<textarea name="config_welcome_email_msg" cols="70" rows="10">{$config_welcome_email_msg_value}</textarea>
	    </td>
        </tr>
	  <tr>
	    <td colspan="3">
		<hr/>
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION_EMAIL_FROM_NAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_user_activation_email_from_name" value="{$config_user_activation_email_from_name_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION_EMAIL_FROM_NAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION_EMAIL_FROM_ADDRESS}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_user_activation_email_from_address" value="{$config_user_activation_email_from_address_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION_EMAIL_FROM_ADDRESS_EXPLAIN}</td>
	  </tr>
	  <tr align="left" valign="middle">
	    <td align="left" valign="top"></td>
	    <td align="left" valign="top" colspan="2">
		{$L_CONFIG_USER_ACTIVATION_EMAIL_MSG_EXPLAIN}
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION_EMAIL_SUBJECT}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_user_activation_email_subject" value="{$config_user_activation_email_subject_value}" size="40" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION_EMAIL_SUBJECT_EXPLAIN}</td>
	  </tr>
        <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_USER_ACTIVATION_EMAIL_MSG}</td>
	    <td align="left" valign="top" colspan="2">
		<textarea name="config_user_activation_email_msg" cols="70" rows="10">{$config_user_activation_email_msg_value}</textarea>
	    </td>
        </tr>
	  <tr>
	    <td colspan="3">
		<hr/>
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_EMAIL_FROM_NAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_email_from_name" value="{$config_password_email_from_name_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_EMAIL_FROM_NAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_EMAIL_FROM_ADDRESS}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_email_from_address" value="{$config_password_email_from_address_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_EMAIL_FROM_ADDRESS_EXPLAIN}</td>
	  </tr>
	  <tr align="left" valign="middle">
	    <td align="left" valign="top"></td>
	    <td align="left" valign="top" colspan="2">
		{$L_CONFIG_PASSWORD_EMAIL_MSG_EXPLAIN}
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_EMAIL_SUBJECT}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_email_subject" value="{$config_password_email_subject_value}" size="40" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_EMAIL_SUBJECT_EXPLAIN}</td>
	  </tr>
        <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_EMAIL_MSG}</td>
	    <td align="left" valign="top" colspan="2">
		<textarea name="config_password_email_msg" cols="70" rows="10">{$config_password_email_msg_value}</textarea>
	    </td>
        </tr>
	  <tr>
	    <td colspan="3">
		<hr/>
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_FROM_NAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_reset_confirm_email_from_name" value="{$config_password_reset_confirm_email_from_name_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_FROM_NAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_FROM_ADDRESS}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_reset_confirm_email_from_address" value="{$config_password_reset_confirm_email_from_address_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_FROM_ADDRESS_EXPLAIN}</td>
	  </tr>
	  <tr align="left" valign="middle">
	    <td align="left" valign="top"></td>
	    <td align="left" valign="top" colspan="2">
		{$L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_MSG_EXPLAIN}
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_SUBJECT}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_reset_confirm_email_subject" value="{$config_password_reset_confirm_email_subject_value}" size="40" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_SUBJECT_EXPLAIN}</td>
	  </tr>
        <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_CONFIRM_EMAIL_MSG}</td>
	    <td align="left" valign="top" colspan="2">
		<textarea name="config_password_reset_confirm_email_msg" cols="70" rows="10">{$config_password_reset_confirm_email_msg_value}</textarea>
	    </td>
        </tr>
	  <tr>
	    <td colspan="3">
		<hr/>
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_EMAIL_FROM_NAME}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_reset_email_from_name" value="{$config_password_reset_email_from_name_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_EMAIL_FROM_NAME_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_EMAIL_FROM_ADDRESS}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_reset_email_from_address" value="{$config_password_reset_email_from_address_value}" size="25" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_EMAIL_FROM_ADDRESS_EXPLAIN}</td>
	  </tr>
	  <tr align="left" valign="middle">
	    <td align="left" valign="top"></td>
	    <td align="left" valign="top" colspan="2">
		{$L_CONFIG_PASSWORD_RESET_EMAIL_MSG_EXPLAIN}
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_EMAIL_SUBJECT}</td>
	    <td align="left" valign="top">
		<input type="text" name="config_password_reset_email_subject" value="{$config_password_reset_email_subject_value}" size="40" />
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_EMAIL_SUBJECT_EXPLAIN}</td>
	  </tr>
        <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_PASSWORD_RESET_EMAIL_MSG}</td>
	    <td align="left" valign="top" colspan="2">
		<textarea name="config_password_reset_email_msg" cols="70" rows="10">{$config_password_reset_email_msg_value}</textarea>
	    </td>
        </tr>
	</table>
    </div>

    <div class="tabbertab" title="{$L_CONFIG_UPLOADS}">
	<table cellpadding="5" cellspacing="0" border="0" width="100%" class="configform">
	  <tr align="center" valign="middle">
	    <th class="config_column1">&nbsp;</th>
	    <th class="config_column2">{$L_CURRENT_SETTING}</th>
	    <th class="config_column3">{$L_EXPLANATION}</th>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_ALLOW_UPLOADS}:</td>
	    <td align="left" valign="top">
		{html_radios name="config_allow_uploads" options=$yes_no_radio selected=$config_allow_uploads_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_ALLOW_UPLOADS_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_UPLOAD_TYPE}:</td>
	    <td align="left" valign="top">
		{html_radios name="config_upload_type" options=$upload_type_radio selected=$config_upload_type_selected separator=" "}
	    </td>
	    <td align="left" valign="top">
		<a href="#" onmouseover="this.T_DELAY=0;return escape('{$L_CONFIG_FILES_EXPLAIN}')">{$L_CONFIG_FILES}</a><br/>
		<a href="#" onmouseover="this.T_DELAY=0;return escape('{$L_CONFIG_DATABASE_EXPLAIN}')">{$L_CONFIG_DATABASE}</a><br/>
		{$L_MOUSEOVER}
	    </td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_MAX_UPLOAD_SIZE}:</td>
	    <td align="left" valign="top">
		<input type="text" name="config_max_upload_size" size="3" value="{$config_max_upload_size_value}" /> {$L_KB}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_MAX_UPLOAD_SIZE_EXPLAIN}</td>
	  </tr>
	  <tr align="left" valign="middle">
	    <td colspan="3" align="left" valign="top" style="padding:10px;"><span style="font-size:12px; font-weight:bold; text-decoration:underline;">{$L_CONFIG_IMAGE_RESIZE_OPTIONS}</span></td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_GD_LIBRARY}:</td>
	    <td align="left" valign="top">
		{$gd_detection}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_GD_LIBRARY_EXPLAIN}</td>
	  </tr>
	  {if $no_gd}
	    <input type="hidden" name="config_resize_images" value="{$config_resize_images_selected}" />
	    <input type="hidden" name="config_resize_images_height" value="{$config_resize_images_height_value}" />
	    <input type="hidden" name="config_resize_images_width" value="{$config_resize_images_width_value}" />
	  {else}
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_RESIZE_IMAGES}:</td>
	    <td align="left" valign="top">
		{html_radios name="config_resize_images" options=$yes_no_radio selected=$config_resize_images_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_RESIZE_IMAGES_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_RESIZE_IMAGES_SIZE}:</td>
	    <td align="left" valign="top">
		<table border="0" cellpadding="2" cellspacing="0">
		  <tr>
		    <td>
			{$L_HEIGHT}: 
		    </td>
		    <td>
			<input type="text" name="config_resize_images_height" size="3" value="{$config_resize_images_height_value}" /> {$L_PIXELS}
		    </td>
		  </tr>
		  <tr>
		    <td>
			{$L_WIDTH}: 
		    </td>
		    <td>
			<input type="text" name="config_resize_images_width" size="3" value="{$config_resize_images_width_value}" /> {$L_PIXELS}
		    </td>
		  </tr>
		</table>
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_RESIZE_IMAGES_SIZE_EXPLAIN}</td>
	  </tr>
	  {/if}
	</table>
    </div>

    <div class="tabbertab" title="{$L_CONFIG_CALENDAR}">
	<table cellpadding="5" cellspacing="0" border="0" width="100%" class="configform">
	  <tr align="center" valign="middle">
	    <th class="config_column1">&nbsp;</th>
	    <th class="config_column2">{$L_CURRENT_SETTING}</th>
	    <th class="config_column3">{$L_EXPLANATION}</th>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_CONFIG_SHOW_CALENDAR}</td>
	    <td align="left" valign="top">
		{html_radios name="config_show_calendar" options=$yes_no_radio selected=$config_show_calendar_selected separator=" "}
	    </td>
	    <td align="left" valign="top">{$L_CONFIG_SHOW_CALENDAR_EXPLAIN}</td>
	  </tr>
	</table>
    </div>

    <div class="tabbertab" title="{$L_CONFIG_ADMIN}">
	<table cellpadding="5" cellspacing="0" border="0" width="100%" class="configform">
	  <tr align="center" valign="middle">
	    <th class="config_column1">&nbsp;</th>
	    <th class="config_column2">{$L_CURRENT_SETTING}</th>
	    <th class="config_column3">{$L_EXPLANATION}</th>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_ADMINCONFIG_DEFAULT_LANGUAGE}</td>
	    <td align="left" valign="top">
		{html_options name=adminconfig_def_lang options=$lang_options selected=$def_lang}
	    </td>
	    <td align="left" valign="top">{$L_ADMINCONFIG_DEFAULT_LANGUAGE_EXPLAIN}</td>
	  </tr>
	  <tr align="center" valign="middle">
	    <td align="left" valign="top">{$L_ADMINCONFIG_DEFAULT_THEME}</td>
	    <td align="left" valign="top">
		{html_options name=adminconfig_def_theme options=$theme_options selected=$def_theme}
	    </td>
	    <td align="left" valign="top">{$L_ADMINCONFIG_DEFAULT_THEME_EXPLAIN}</td>
	  </tr>
	</table>
    </div>
  </div>
  </form>
</div>
<script type="text/javascript" src="includes/js/wz_tooltip.js"></script>
{/if}
{include file="$theme/footer.tpl"}