{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name=edit_profile show=$show_edit_profile}
<script src="scripts/forms.js" type="text/javascript"></script>
  <div class="centered">
  <span style="color:red; font-weight:bold;">{$msg}<br/><br/></span>
  <table border="0" width="75%" cellpadding="0" cellspacing="0">
    <tr>
	<td style="text-align:center;">
	  <h4>{$L_EDIT_PROFILE}</h4><br/>
	  {if $num_errors > 0}<p style="color:red;">{$num_errors} error(s) found</p>{/if}
	  <form action="profile.php?mode=editprofile" method="post">
	    <table class="default_table" border="0" cellspacing="2" cellpadding="0" width="100%">
		<tr class="default_tableheader">
		  <th colspan="2" style="text-align:left;">
		    <p>{$L_REGISTRATION_INFORMATION}</p>
		  </th>
		</tr>
		<tr class="default_tableheader_small">
		  <td colspan="2" style="text-align:left; width:50%;">
		    <p>{$L_REQUIRED_FIELDS}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_PROFILE_USERNAME}</p>
		  </td>
		  <td style="text-align:left; width:50%;">
		    {if $allow_username_change}
		    <p><input class="textinput" type="text" name="profile_username" maxlength="30" value="{$user_value}"/> {$user_error}</p>
		    {else}
		    <p>{$user_value}</p>
		    {/if}
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_PROFILE_EMAIL}</p>
		    <p>{$L_CHANGING_EMAIL}</p>
		  </td>
		  <td  style="text-align:left; width:50%;">
		    <p><input class="textinput" type="text" name="profile_email" maxlength="50" value="{$email_value}" /> {$email_error}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_EMAIL_VIEWABLE}</p>
		  </td>
		  <td   style="text-align:left; width:50%;">
		    <p><input type="radio" name="profile_email_public" value="1" {if $email_public_value}checked="checked"{/if} />{$L_YES} <input  type="radio" name="profile_email_public" value="0" {if !$email_public_value} checked="checked"{/if} />{$L_NO}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_NEW_PASSWORD}</p>
		    <p>{$L_CHANGING_PASSWORD}</p>
		  </td>
		  <td   style="text-align:left; width:50%;">
		    <p><input class="textinput" type="password" name="profile_newpassword" maxlength="30" value="{$newpass_value}"/> {$newpass_error}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_CONFIRM_NEW_PASSWORD}</p>
		    <p>{$L_CHANGING_PASSWORD}</p>
		  </td>
		  <td  style="text-align:left; width:50%;">
		    <p><input class="textinput" type="password" name="profile_newpassword_confirm" maxlength="30" value="{$conf_value}"/> {$conf_error}</p>
		  </td>
		</tr>
		<tr class="default_tableheader">
		  <th colspan="2" style="text-align:left;">
		    <p>{$L_PROFILE_INFORMATION}</p>
		  </th>
		</tr>
		 <tr class="default_tablecell_alt2">
	           <td  style="text-align:left; width:40%;">
                       <p>{$L_USER_THEME}</p>
                        </td>
                   <td  style="text-align:left; width:60%;">
                      <p>{html_options name=profile_def_user_theme options=$theme_options selected=$def_theme}</p>
                     </td>
                   </tr>
		<tr class="default_tablecell_alt1">
		  <td  style="text-align:left; width:40%;">
		    <p>{$L_USER_LANGUAGE}</p>
		  </td>
		  <td  style="text-align:left; width:60%;">
		    <p>{html_options name=profile_def_user_lang options=$lang_options selected=$def_lang}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_REAL_NAME}</p>
		  </td>
		  <td  style="text-align:left; width:50%;">
		    <p><input class="textinput" type="text" name="profile_realname" maxlength="30" value="{$realname_value}" /></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_DOB}: </p>
		  </td>
		  <td  style="text-align:left; width:50%;">
		    <p>{html_select_date prefix="profile_dob_" start_year="-90" end_year="+0" time=$dob_value year_empty="Year" month_empty="Month" day_empty="Day"}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_SEX}</p>
		  </td>
		  <td  style="text-align:left; width:50%;">
		    <p><input type="radio" name="profile_sex" value="M" {if $sex_value == "M"}checked{/if} />{$L_MALE} <input type="radio" name="profile_sex" value="F" {if $sex_value == "F"}checked{/if} />{$L_FEMALE}</p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td  style="text-align:left; width:50%;">
		    <p>{$L_ICQ}</p>
		  </td>
		  <td style="text-align:left; width:50%;">
		    <p><input class="textinput" type="text" name="profile_icq" maxlength="15" size="10" value="{$icq_value}" /></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:50%;">
		    <p>{$L_AIM}</p>
		  </td>
		  <td style="text-align:left; width:50%;">
		    <p><input class="textinput" type="text" name="profile_aim" maxlength="255" size="20" value="{$aim_value}" /></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:50%;">
		    <p>{$L_YIM}</p>
		  </td>
		  <td style="text-align:left; width:50%;">
		    <p><input class="textinput" type="text" name="profile_yim" maxlength="255" size="20" value="{$yim_value}" /></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:50%;">
		    <p>{$L_MSN}</p>
		  </td>
		  <td style="text-align:left; width:50%;">
		    <p><input class="textinput" type="text" name="profile_msn" maxlength="255" size="20" value="{$msn_value}" /></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt1">
		  <td style="text-align:left; width:50%;">
		    <p>{$L_WEBSITE} {$L_WEB_EXAMPLE}</p>
		  </td>
		  <td style="text-align:left; width:50%;">
		    <p><input class="textinput" type="text" name="profile_website" maxlength="255" size="25" value="{$website_value}" /></p>
		  </td>
		</tr>
		<tr class="default_tablecell_alt2">
		  <td style="text-align:left; width:50%;">
		    <p>{$L_LOCATION}</p>
		  </td>
		  <td style="text-align:left; width:50%;">
		    <p><input class="textinput" type="text" name="profile_location" maxlength="100" size="25" value="{$location_value}" /></p>
		  </td>
		</tr>
		<tr class="default_tablefooter">
		  <td colspan="2" align="center">
		    <p><input class="button" type="submit" name="editprofile" value="{$L_SUBMIT}"/></p>
		  </td>
		</tr>
	    </table>
	  </form>
	</td>
    </tr>
  </table>
  </div><br/>
{/section}
{section name=view_profile show=$show_view_profile}
  <div class="centered">
  <table border="0" width="80%" cellpadding="0" cellspacing="0">
    <tr>
	<td style="text-align:center;">
	  <h4>{$L_VIEWING_PROFILE}</h4><br/>
	    <table cellspacing="0" cellpadding="1" width="100%">
		<tr class="default_tableheader">
		  <th style="text-align:left; width:50%;">
		    <p>{$L_CONTACT_INFORMATION}</p>
		  </th>
		  <th style="text-align:left; width:50%;">
		    <p>{$L_VIEW_PROFILE_INFORMATION}</p>
		  </th>
		</tr>
		<tr>
		  <td  style="vertical-align:top;">
		    <table class="default_tablecell" border="0" cellpadding="2" cellspacing="0" width="100%">
			<tr>
			  <td  nowrap="nowrap" style="text-align:right;">
			    <p>{$L_EMAIL_ADDRESS}</p>
			  </td>
			  <td style="text-align:left; width:100%;">
			    <p>{$email}</p>
			  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
		    	    <p>{$L_ICQ}</p>
			  </td>
			  <td style="text-align:left;">
			    <p><a href="http://wwp.icq.com/scripts/search.dll?to={$icq}">{$icq}</a></p>
		  	  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
		    	    <p>{$L_AIM}</p>
			  </td>
			  <td style="text-align:left;">
			    <p><a href="aim:goim?screenname={$aim}&message=Hello+Are+you+there?">{$aim}</a></p>
		  	  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
		    	    <p>{$L_YIM}</p>
			  </td>
			  <td style="text-align:left;">
			    <p><a href="http://edit.yahoo.com/config/send_webmesg?.target={$yim}&.src=pg">{$yim}</a></p>
		  	  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
		    	    <p>{$L_MSN}</p>
			  </td>
			  <td style="text-align:left;">
			    <p>{$msn}</p>
		  	  </td>
			</tr>
		    </table>
		  </td>
		  <td>
		    <table class="default_tablecell" border="0" cellpadding="1" cellspacing="1">
			<tr>
			  <td   nowrap="nowrap" style="text-align:right;">
			    <p>{$L_TOTAL_ENTRIES}</p>
			  </td>
			  <td style="text-align:left; width:100%;">
			    <p>{$numentries}</p>
			  </td>
			</tr>
			<tr>
			  <td nowrap="nowrap" style="text-align:right;">
			  </td>
			  <td style="text-align:left;">
			    <p><a href="search.php?user={$username}">{$L_FIND_ALL_POSTS}</a></p>
			    <p><a href="index.php?{$username}">{$L_VIEW_RECENT_POSTS}</a></p>
			  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
		    	    <p>{$L_REAL_NAME}</p>
		  	  </td>
		  	  <td style="text-align:left;">
		    	    <p>{$realname}</p>
		  	  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
		    	    <p>{$L_AGE}</p>
		  	  </td>
		 	  <td style="text-align:left;">
		    	    <p>{$age}</p>
		  	  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
		    	    <p>{$L_SEX}</p>
		  	  </td>
		  	  <td style="text-align:left;">
		    	    <p>{if $sex == "M"}{$L_MALE} {elseif $sex == "F"}{$L_FEMALE} {/if}</p>
		  	  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
			    <p>{$L_WEBSITE}</p>
		  	  </td>
		  	  <td style="text-align:left;">
		    	    <p><a href="{$website}" target="_blank">{$website}</a></p>
		  	  </td>
			</tr>
			<tr>
		  	  <td nowrap="nowrap" style="text-align:right;">
		    	    <p>{$L_LOCATION}</p>
		  	  </td>
		  	  <td style="text-align:left;">
		    	    <p>{$location}</p>
		  	  </td>
			</tr>
		    </table>
		  </td>
		</tr>
	    </table>
	</td>
    </tr>
  </table>
  </div><br/>
{/section}
{section name=noprofile show=show_noprofile}
  <div class="centered">
    <p>{$L_USER_NO_EXIST}</p>
  </div>
{/section}
{section name=profileupdated show=$show_profile_updated}
  <div class="centered">
    <h4>{$L_PROFILE_UPDATED_TITLE}</h4>
    <p>{$L_PROFILE_UPDATED}</p><br/>
    <p>{$L_RETURN_TO_INDEX}</a></p>
  </div>
{/section}
    </td>
  </tr>
{include file="$theme/footer.tpl"}