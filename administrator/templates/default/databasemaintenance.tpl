{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name="databasemaintenance" show=$show_database_maintenance}
<div class="backupcontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_DATABASE_MAINTENANCE}</h1>
	</td>
    </tr>
  </table>
  <div class="backupdata">
	<form action="databasemaintenance.php" method="post">
	<table border="0" cellpadding="3" cellspacing="0" width="185">
	  <tr>
	    <td>
		{$L_DETECTED_DATABASE}:
	    </td>
	    <td>
		<span class="green-bold">{$database_type}</span>
	    </td>
	  </tr>
	</table>
	<table border="0" cellpadding="10" cellspacing="0" width="100%">
	  <tr>
	    <td colspan="2" align="center">
		<input class="button2" type="submit" value="{$L_OPTIMIZE_DATABASE}" name="dbmaintenance_submit"/>
	    </td>
	  </tr>
	</table>
	</form>
  </div>
</div>
{/section}
{include file="$theme/footer.tpl"}