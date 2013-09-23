{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{if $adminsession_is_super_admin}
{section name="databasebackup" show=$show_database_backup}
<div class="backupcontainer">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_DATABASE_BACKUP}</h1>
	</td>
    </tr>
  </table>
  <div class="backupdata">
	<form action="backup.php" method="post">
	<table border="0" cellpadding="3" cellspacing="0" width="185">
	  <tr>
	    <td>
		{$L_DETECTED_DATABASE}:
	    </td>
	    <td>
		<span class="green-bold">{$database_type}</span>
	    </td>
	  </tr>
	  <tr>
	    <td>
		{$L_GZIP_COMPRESSION}: 
	    </td>
	    <td>
		{$gzip_compression}
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2" class="underlined-title">
		{$L_BACKUP_OPTIONS}
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2">
		{html_radios name="backup_type" options=$backup_types selected=$backup_type_selected separator="<br />"}
	    </td>
	  </tr>
	  {if $show_gzip}
	  <tr>
	    <td colspan="2">
		<label><input type="checkbox" name="enable_gzip" value="1" />{$L_GZIP_BACKUP}</label>
	    </td>
	  </tr>
	  {/if}
	</table>
	<table border="0" cellpadding="10" cellspacing="0" width="100%">
	  <tr>
	    <td colspan="2" align="center">
		<input class="button2" type="submit" value="{$L_DOWNLOAD_BACKUP}" name="database_backup_submit"/>
	    </td>
	  </tr>
	</table>
	</form>
  </div>
</div>
{sectionelse}
<div class="backupcontainer">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_CONFIG_BACKUP}</h1>
	</td>
    </tr>
  </table>
  <div class="backupdata">
	<form action="backup.php" method="post">
	<table border="0" cellpadding="3" cellspacing="0" width="185">
	  <tr>
	    <td>
		{$L_GZIP_COMPRESSION}: 
	    </td>
	    <td>
		{$gzip_compression}
	    </td>
	  </tr>
	  <tr>
	    <td colspan="2" class="underlined-title">
		{$L_BACKUP_OPTIONS}
	    </td>
	  </tr>
	  {if $show_gzip}
	  <tr>
	    <td colspan="2">
		<label><input type="checkbox" name="enable_gzip" value="1" />{$L_GZIP_BACKUP}</label>
	    </td>
	  </tr>
	  {/if}
	</table>
	<table border="0" cellpadding="10" cellspacing="0" width="100%">
	  <tr>
	    <td colspan="2" align="center">
		<input class="button2" type="submit" value="{$L_DOWNLOAD_BACKUP}" name="config_backup_submit"/>
	    </td>
	  </tr>
	</table>
	</form>
  </div>
</div>
{/section}
{else}
<div class="centered">
  <p class="errormsg">{$L_NOT_SUPER_ADMIN}</p>
</div>
{/if}
{include file="$theme/footer.tpl"}