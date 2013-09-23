{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{if $adminsession_useraccess == "2"}

<div class="languagemanagercontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <form action="languagemanager.php" method="post">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_LANGUAGE_MANAGER}</h1>
	</td>
	<td align="right" valign="bottom">
	  <input class="button2" type="submit" value="{$L_SAVE_SETTINGS}" name="save_language"/>
	</td>
    </tr>
    <tr>
	<td align="left" class="description-text">
	  {$L_CHOOSE_DEFAULT_LANGUAGE}
	</td>
	<td align="right" class="description-text">
	  <label><input type="checkbox" name="override_user_language" {if $override_selected}checked="checked"{/if} />{$L_OVERRIDE_USER_LANGUAGE}</label>
	</td>
    </tr>
  </table>
  <div class="languagedata">
    <table border="0" cellpadding="4" cellspacing="0">
	  <tr align="left">
	    <th class="languagecolumn1">&nbsp;</th>
	    <th class="languagecolumn2">{$L_LANGUAGE_NAME}</th>
	    <th class="languagecolumn3">{$L_LANGUAGE_AUTHOR}</th>
	    <th class="languagecolumn4">{$L_LANGUAGE_VERSION}</th>
	    <th class="languagecolumn5" align="center">{$L_LANGUAGE_DEFAULT}</th>
	  </tr>
    {section name="languageloop" loop=$language_list}
	  <tr>
	    <td>
		<input type="radio" name="selected_language" value="{$language_list[languageloop].name}" {if $language_list[languageloop].is_default}checked="checked"{/if} />
	    </td>
	    <td>
		{$language_list[languageloop].displayname}
	    </td>
	    <td>
		{$language_list[languageloop].author}
	    </td>
	    <td>
		{$language_list[languageloop].version}
	    </td>
	    <td class="centered">
		<img src="{$language_list[languageloop].is_default_image}" alt="{$language_list[languageloop].is_default}" class="is_default_image" />
	    </td>
	</tr>
    {/section}
    </table>
  </div>
  </form><br/><br/>
  <form action="languagemanager.php" method="post" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_LANGUAGE_INSTALLER}</h1>
	</td>
    </tr>
    <tr>
	<td align="left" class="description-text">
	  {$L_UPLOAD_LANGUAGE_FILE}
	</td>
    </tr>
  </table>
  <div class="languagedata" style="padding: 10px;">
    {$L_PACKAGE_FILE}: <input name="lang_file" type="file" /> <input type="submit" value="{$L_UPLOAD_AND_INSTALL}" name="language_upload"/></
  </div>
  </form>
</div>
{/if}
{include file="$theme/footer.tpl"}