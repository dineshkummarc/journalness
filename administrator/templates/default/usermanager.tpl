{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name="mainpage" show=$showmainpage}
{if $adminsession_useraccess == "2"}

<div class="usermanagercontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  {if $new_username && $new_password}
  <div class="centered" style="margin-top:2em; padding: 5px; background-color: #E9E9E9;">
    <span style="color:red; font-weight:bold;">{$L_NEW_USER}:</span><br/><br/>
    <strong>{$L_USERNAME}:</strong> {$new_username} <strong>{$L_USER_PASSWORD}:</strong> {$new_password}
  </div>
  {/if}
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1>{$L_USER_MANAGER}</h1>
	</td>
    </tr>
  </table>
  <div class="userdata">
    <table border="0" cellpadding="4" cellspacing="0" class="userrowheader">
	  <tr>
	    <th class="usercolumn1">{$L_USER_ID}</th>
	    <th class="usercolumn2"><div class="usercolumn2overflow">{$L_USERNAME}</div></th>
	    <th class="usercolumn3"><div class="usercolumn3overflow">{$L_USER_EMAIL}</div></th>
	    <th class="usercolumn4">{$L_USER_GROUP}</th>
	    <th class="usercolumn5">{$L_USER_PUBLIC_EMAIL}</th>
	    <th class="usercolumn6">{$L_USER_VERIFIED}</th>
	    <th class="usercolumn7">{$L_USER_NUM_POSTS}</th>
	    <th class="usercolumn8">&nbsp;</th>
	  </tr>
    </table>
    {section name="userloop" loop=$user_list}
    <div>
	  <table border="0" cellpadding="4" cellspacing="0" class="usertable">
	    <tr style="{if $smarty.section.userloop.index % 2 == 0}background-color: #FFFFFF{else}background-color: #E9E9E9{/if};">
		<td class="usercolumn1">
			{$user_list[userloop].iteration}
		</td>
		<td class="usercolumn2">
			<div class="usercolumn2overflow"><a href="usermanager.php?mode=edituser&amp;id={$user_list[userloop].id}">{$user_list[userloop].username}</a></div>
		</td>
		<td class="usercolumn3">
			<div class="usercolumn3overflow"><a href="mailto:{$user_list[userloop].email}">{$user_list[userloop].email}</a></div>
		</td>
		<td class="usercolumn4">
			{$user_list[userloop].group}
		</td>
		<td class="usercolumn5">
			{$user_list[userloop].email_public}
		</td>
		<td class="usercolumn6">
			{$user_list[userloop].verified}
		</td>
		<td class="usercolumn7">
			{$user_list[userloop].num_posts}
		</td>
		<td class="usercolumn8">
			<a href="usermanager.php?mode=edituser&amp;id={$user_list[userloop].id}"><img src="templates/{$theme}/images/edit.gif" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;<a href="usermanager.php?mode=deleteuser&amp;id={$user_list[userloop].id}"><img src="templates/{$theme}/images/delete.png" alt="Delete" /></a>
		</td>
	    </tr>
	  </table>
    </div>
    {/section}
  </div>
  <table border="0" cellpadding="5" align="center" class="pagination">
    <tr>
	<td style="text-align:center;">
	  {$pageLinks}<br/>
	  {$pageCounter}
	</td>
    </tr>
  </table>
</div>
{/if}
{/section}
{section name="edit" show=$showedit}
{if $adminsession_useraccess == "2"}
<div class="usereditcontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1>{$L_EDIT_USER}</h1>
	</td>
    </tr>
  </table>
  <div class="usereditdata">
  <form action="usermanager.php?mode=edituser" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td style="font-size:12px;">
	    <strong>{$L_USER_INFO}</strong><br/>
	    <hr/>
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USERNAME}:<br/>
	    <input type="text" name="user_username" value="{$userinfo.username}" size="20" maxlength="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_NEW_PASSWORD}:<br/>
	    <input type="password" name="password" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_NEW_PASSWORD_CONFIRM}:<br/>
	    <input type="password" name="password_confirm" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_EMAIL}:<br/>
	    <input type="text" name="user_email" value="{$userinfo.email}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_PUBLIC_EMAIL}:<br/>
	    {html_options name=user_email_public options=$yes_no_options selected=$public_email_selected}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_VERIFIED}:<br/>
	    {html_options name=user_verified options=$yes_no_options selected=$verified_selected}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_GROUP}:<br/>
	    {html_options name=group options=$group_options selected=$group_selected}
	  </td>
	</tr>
	<tr>
	  <td style="font-size:12px;">
	    <br/>
	    <strong>{$L_ADDITIONAL_INFO}</strong><br/>
	    <hr/>
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_TEMPLATE}:<br/>
	    {html_options name=user_def_user_theme options=$user_template_options selected=$user_template_selected}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_LANGUAGE}:<br/>
	    {html_options name=user_def_user_lang options=$user_language_options selected=$user_language_selected}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_REALNAME}:<br/>
	    <input type="text" name="user_realname" value="{$userinfo.realname}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_DOB}:<br/>
	    {html_select_date prefix="user_dob_" start_year="-90" end_year="+0" time=$dob_value year_empty="Year" month_empty="Month" day_empty="Day"}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_SEX}:<br/>
	    {html_radios name=user_sex options=$sex_options selected=$sex_selected}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_ICQ}:<br/>
	    <input type="text" name="user_icq" value="{$userinfo.icq}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_AIM}:<br/>
	    <input type="text" name="user_aim" value="{$userinfo.aim}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_YIM}:<br/>
	    <input type="text" name="user_yim" value="{$userinfo.yim}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_MSN}:<br/>
	    <input type="text" name="user_msn" value="{$userinfo.msn}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_WEBSITE}:<br/>
	    <input type="text" name="user_website" value="{$userinfo.website}" size="20" />
	  </td>
	</tr>	
	<tr>
	  <td>
	    {$L_USER_LOCATION}:<br/>
	    <input type="text" name="user_location" value="{$userinfo.location}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_SIGNATURE}:<br/>
	    <textarea name="user_sig" class="textinput" cols="40" rows="10">{$userinfo.sig}</textarea>
	  </td>
	</tr>

	<tr>
	  <td align="right">
	    <input type="hidden" name="id" value="{$userinfo.id}" />
	    <input type="submit" class="button2" name="edit_user_submit" value="{$L_SAVE_CHANGES}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/if}
{/section}
{section name="delete" show=$showdelete}
{if $adminsession_useraccess == "2"}
<div class="usereditcontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1>{$L_DELETE_USER}</h1>
	</td>
    </tr>
  </table>
  <div class="usereditdata">
  <form action="usermanager.php?mode=deleteuser" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td>
	    {$L_USERNAME}:<br/>
	    <strong>{$userinfo.username}</strong>
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_EMAIL}:<br/>
	    <strong>{$userinfo.email}</strong>
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_GROUP}:<br/>
	    <strong>{$userinfo.group}</strong>
	  </td>
	</tr>

	<tr>
	  <td align="right">
	    <input type="hidden" name="id" value="{$userinfo.id}" />
	    <input type="submit" class="button2" name="delete_user_submit" value="{$L_DELETE_USER}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/if}
{/section}
{section name="add" show=$showadd}
{if $adminsession_useraccess == "2"}
<div class="usereditcontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1>{$L_ADD_USER}</h1>
	</td>
    </tr>
  </table>
  <div class="usereditdata">
  {if $num_errors > 0}<p style="color:red;">{$num_errors} error(s) found</p>{/if}
  <form action="usermanager.php?mode=adduser" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td>
	    {$L_USERNAME}: {$username_error}<br/>
	    <input type="text" name="user_username" value="{$username_value}" size="20" maxlength="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_PASSWORD}: {$password_error}<br/>
	    <input type="password" name="user_password" value="{$password_value}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_PASSWORD_CONFIRM}: {$password_confirm_error}<br/>
	    <input type="password" name="user_password_confirm" value="{$password_confirm_value}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_EMAIL}: {$email_error}<br/>
	    <input type="text" name="user_email" value="{$email_value}" size="20" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_PUBLIC_EMAIL}: <br/>
	    {html_options name=user_email_public options=$yes_no_options selected=$email_public_value}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_VERIFIED}:<br/>
	    {html_options name=user_verified options=$yes_no_options selected=$verified_value}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_USER_GROUP}:<br/>
	    {html_options name=user_group options=$group_options selected=$group_value}
	  </td>
	</tr>
	<tr>
	  <td>
	    <label><input type="checkbox" name="user_auto_generate_password" value="1" />{$L_AUTO_GENERATE_PASSWORD}</label>
	  </td>
	</tr>
	<tr>
	  <td>
	    <label><input type="checkbox" name="user_send_password_email" value="1" />{$L_SEND_PASSWORD_EMAIL}</label>
	  </td>
	</tr>
	<tr>
	  <td align="right">
	    <input type="submit" class="button2" name="add_user_submit" value="{$L_ADD_USER}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/if}
{/section}
{section name="notallowed" show=$shownotallowed}
<div class="centered">
  {if $L_NOT_ALLOWED_TO_EDIT_USER}
  <p class="errormsg">{$L_NOT_ALLOWED_TO_EDIT_USER}</p>
  {else}
  <p class="errormsg">{$L_NOT_ALLOWED_TO_DELETE_USER}</p>
  {/if}
</div>
{/section}
{include file="$theme/footer.tpl"}