{include file="$theme/header.tpl"}
{include file="$theme/leftnav.tpl"}
{section name=register show=$show_register}
  <div class="centered">
  <table border="0" width="97%" cellpadding="0" cellspacing="0">
    <tr>
	<td style="text-align:center;">
	  <h4>{$L_REGISTER}</h4><br/>
	  {if $num_errors > 0}<p style="color:red;">{$num_errors} error(s) found</p>{/if}
	  <form action="register.php" method="post">
	    <table class="default_table" cellspacing="2" cellpadding="2px" width="100%">
		<tr>
		  <th class="default_tableheader_small" colspan="2">
		    <p>{$L_REGISTRATION_INFORMATION}</p>
		  </th>
		</tr>
		<tr class="default_tableheader_small">
		  <td colspan="2">
		    <p style="font-size:9px;">{$L_REQUIRED_FIELDS}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="width:45%;">
		    <p>{$L_PROFILE_USERNAME}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_username" maxlength="30" size="30" value="{$user_value}"/><br/>
		    {$user_error}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_PROFILE_EMAIL}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_email" maxlength="50" size="30" value="{$email_value}"/><br/>
		    {$email_error}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_EMAIL_VIEWABLE}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input type="radio" name="register_email_public" value="1" {if $email_public_value == "1"}checked="checked"{/if}/>{$L_YES} <input type="radio" name="register_email_public" value="0" {if $email_public_value == "0"}checked="checked"{/if}/>{$L_NO}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_REGISTRATION_PASSWORD}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="password" name="register_password" maxlength="30" size="25" value="{$pass_value}"/><br/>
		    {$pass_error}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_CONFIRM_REGISTRATION_PASSWORD}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="password" name="register_password_confirm" maxlength="30" size="25" value="{$conf_value}"/><br/>
		    {$conf_error}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <th class="adminpanel_tableheader_small" colspan="2">
		    <p>{$L_PROFILE_INFORMATION}</p>
		  </th>
		</tr>
		
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_USER_THEME}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p>{html_options name="register_def_user_theme" options=$theme_options selected=$theme_value}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_USER_LANGUAGE}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p>{html_options name="register_def_user_lang" options=$cust_options selected=$language_value}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_REAL_NAME}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_realname" maxlength="30" value="{$realname_value}"/></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_DOB}: </p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p>{html_select_date prefix="register_dob_" start_year="-90" end_year="+0" time=$dob_value year_empty="Year" month_empty="Month" day_empty="Day"}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_SEX}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input type="radio" name="register_sex" value="M" {if $sex_value == "M"}checked="checked"{/if}/>{$L_MALE} <input type="radio" name="register_sex" value="F" {if $sex_value == "F"}checked="checked"{/if}/>{$L_FEMALE} </p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_ICQ}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_icq" maxlength="15" size="10" value="{$icq_value}"/></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_AIM}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_aim" maxlength="255" size="20" value="{$aim_value}"/></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_YIM}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_yim" maxlength="255" size="20" value="{$yim_value}"/></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_MSN}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_msn" maxlength="255" size="20" value="{$msn_value}"/></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_WEBSITE} {$L_WEB_EXAMPLE}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_website" maxlength="255" size="25" value="{$website_value}"/></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:45%;">
		    <p>{$L_LOCATION}</p>
		  </td>
		  <td style="text-align:left; width:55%;">
		    <p><input class="textinput" type="text" name="register_location" maxlength="100" size="25" value="{$location_value}"/></p>
		  </td>
		</tr>
		<tr class="default_tablefooter">
		  <td colspan="2" align="center">
		    <p><input class="button" type="submit" name="register" value="{$L_REGISTER}"/></p>
		  </td>
		</tr>
	    </table>
	  </form>
	</td>
    </tr>
  </table>
  </div><br/>
{/section}
{section name=notadmin show=$show_not_admin}
  <div class="centered">
    <br/>
    <h4>{$L_ERROR}</h4>
    <p>{$L_NOT_ADMIN}</p><br/>
    <p>{$L_LOGIN_LINK}</p>
  </div>
{/section}
{section name=regsuccess show=$show_reg_success}
  <div class="centered">
    <br/>
    <h4>{$success_title}</h4><br/>
    <p>{$regsuccessful}<br/><br/></p>
    {if $journalnessConfig_user_activation}
	<p>{$validation_email_sent}</p>
    {/if}
  </div>
{/section}
{section name=regfailed show=$show_reg_failed}
  <br/>
  <div class="centered">
    <h4>{$failed_title}</h4>
    <p>{$regfailed}</p>
  </div>
{/section}
    </td>
{include file="$theme/rightnav.tpl"}
{include file="$theme/footer.tpl"}