{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{if $adminsession_useraccess == "2"}

<div class="templatemanagercontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <form action="templatemanager.php" method="post">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_TEMPLATE_MANAGER}</h1>
	</td>
	<td align="right" valign="bottom">
	  <input class="button2" type="submit" value="{$L_SAVE_SETTINGS}" name="save_template"/>
	</td>
    </tr>
    <tr>
	<td align="left" class="description-text">
	  {$L_CHOOSE_DEFAULT_TEMPLATE}
	</td>
	<td align="right" class="description-text">
	  <label><input type="checkbox" name="override_user_theme" {if $override_selected}checked="checked"{/if} />{$L_OVERRIDE_USER_THEME}</label>
	</td>
    </tr>
    <tr>
	<td align="left" style="font-size: 14px; padding-top: 25px;">
	  <strong>{$L_DEFAULT_TEMPLATE}:</strong><br/><br/>
	</td>
    </tr>
    <tr>
	<td align="left">
	    <table border="0" cellpadding="0" cellspacing="0" width="180" style="margin-left: 20px; font-size: 11px;">
		<tr>
		  <td colspan="2">
		    <div class="centered">
		    <strong>{$default_template.displayname}</strong>
		    <img src="{$default_template.previewimage}" alt="Template Preview" class="templateimage" />
		    </div>
		  </td>
		</tr>
		<tr>
		  <td colspan="2" style="padding-bottom:2px;">
		    <label class="bold"><input type="radio" name="selected_template" value="{$default_template.name}" {if $default_template.is_default}checked="checked"{/if} />{$L_SELECT}</label>
		  </td>
		</tr>
		<tr>
		  <td class="templatecolumn1">
		    {$L_TEMPLATE_NAME}
		  </td>
		  <td class="templatecolumn2">
		    {$default_template.displayname}
		  </td>
		</tr>
		<tr>
		  <td class="templatecolumn1">
		    {$L_TEMPLATE_AUTHOR}
		  </td>
		  <td class="templatecolumn2">
		    {$default_template.author}
		  </td>
		</tr>
		<tr>
		  <td class="templatecolumn1" style="padding-bottom: 20px;">
		    {$L_TEMPLATE_VERSION}
		  </td>
		  <td class="templatecolumn2" style="padding-bottom: 20px;">
		    {$default_template.version}
		  </td>
		</tr>
	    </table>
	</td>
    </tr>
  </table>
  <div class="templatedata">
    <table border="0" cellpadding="5" cellspacing="0">
    {section name="templateloop" loop=$template_list}
	{if $smarty.section.templateloop.index is div by 4} 
	<tr>
	{/if}
	  <td>
	    <table border="0" cellpadding="0" cellspacing="0" width="180">
		<tr>
		  <td colspan="2">
		    <div class="centered">
		    <strong>{$template_list[templateloop].displayname}</strong>
		    <img src="{$template_list[templateloop].previewimage}" alt="Template Preview" class="templateimage" />
		    </div>
		  </td>
		</tr>
		<tr>
		  <td colspan="2" style="padding-bottom:2px;">
		    <label class="bold"><input type="radio" name="selected_template" value="{$template_list[templateloop].name}" {if $template_list[templateloop].is_default}checked="checked"{/if} />{$L_SELECT}</label>
		  </td>
		</tr>
		<tr>
		  <td class="templatecolumn1">
		    {$L_TEMPLATE_NAME}
		  </td>
		  <td class="templatecolumn2">
		    {$template_list[templateloop].displayname}
		  </td>
		</tr>
		<tr>
		  <td class="templatecolumn1">
		    {$L_TEMPLATE_AUTHOR}
		  </td>
		  <td class="templatecolumn2">
		    {$template_list[templateloop].author}
		  </td>
		</tr>
		<tr>
		  <td class="templatecolumn1" style="padding-bottom: 20px;">
		    {$L_TEMPLATE_VERSION}
		  </td>
		  <td class="templatecolumn2" style="padding-bottom: 20px;">
		    {$template_list[templateloop].version}
		  </td>
		</tr>
	    </table>
	  </td>
	{if $smarty.section.templateloop.iteration is div by 4 || $smarty.section.templateloop.last} 
	</tr>
	{/if}
    {/section}
    </table>
  </div>
  </form>
  <form action="templatemanager.php" method="post" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_TEMPLATE_INSTALLER}</h1>
	</td>
    </tr>
    <tr>
	<td align="left" class="description-text">
	  {$L_UPLOAD_TEMPLATE_FILE}
	</td>
    </tr>
  </table>
  <div class="templatedata" style="padding: 10px;">
    {$L_PACKAGE_FILE}: <input name="lang_file" type="file" /> <input type="submit" value="{$L_UPLOAD_AND_INSTALL}" name="template_upload"/></
  </div>
  </form>
</div>
{/if}
{include file="$theme/footer.tpl"}