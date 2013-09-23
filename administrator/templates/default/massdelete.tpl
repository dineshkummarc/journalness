{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name="massdelete" show=$show_mass_delete}
{if $adminsession_useraccess == "2"}
{literal}
<script language="javascript">
<!--
function checkAll()
{
  	var ids = document.getElementsByName('id[]')
	for(i=0;i<ids.length;i++){
		ids[i].checked = true;
  	}
}

function uncheckAll()
{
  	var ids = document.getElementsByName('id[]')
	for(i=0;i<ids.length;i++){
		ids[i].checked = false;
  	}
}
// -->
</script>
{/literal}
<div class="massdeletecontainer">
  <form action="massdelete.php" method="post">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_MASS_ENTRY_DELETION}</h1>
	</td>
	<td align="right" valign="bottom">
	  <input class="button" type="submit" value="{$L_DELETE_SELECTED}" name="delete_selected"/>
	</td>
    </tr>
  </table>
  <div class="massdeletedata">
    <table border="0" cellpadding="4" cellspacing="0" class="massdeleterowheader">
	  <tr>
	    <th class="massdeletecolumn1">&nbsp;</th>
	    <th class="massdeletecolumn2"><div class="massdeletecolumn2overflow">{$L_TITLE}</div></th>
	    <th class="massdeletecolumn3">{$L_DATE}</th>
	    <th class="massdeletecolumn4"><div class="massdeletecolumn4overflow">{$L_PREVIEW}</div></th>
	    <th class="massdeletecolumn5">{$L_USER}</th>
	    <th class="massdeletecolumn6">{$L_COMMENTS}</th>
	    <th class="massdeletecolumn7">{$L_VIEWS}</th>
	  </tr>
    </table>
    {section name="loop" loop=$entries}
    <div>
	  <table border="0" cellpadding="4" cellspacing="0" class="massdeletetable">
	    <tr style="background-color: {cycle values="#FFFFFF, #E9E9E9"};">
		<td class="massdeletecolumn1">
		  <input type="checkbox" name="id[]" value="{$entries[loop].id}" />
		</td>
		<td class="massdeletecolumn2">
			<div class="massdeletecolumn2overflow">{$entries[loop].title}</div>
		</td>
		<td class="massdeletecolumn3">
			{$entries[loop].date}
		</td>
		<td class="massdeletecolumn4">
			<div class="massdeletecolumn4overflow">{$entries[loop].entry_text}</div>
		</td>
		<td class="massdeletecolumn5">
			<div class="massdeletecolumn5overflow">{$entries[loop].username}</div>
		</td>
		<td class="massdeletecolumn6">
			{$entries[loop].numcomments}
		</td>
		<td class="massdeletecolumn7">
			{$entries[loop].views}
		</td>
	    </tr>
	  </table>
    </div>
    {/section}
    <div style="padding: 5px; margin-top: 10px; border-top: 1px solid #A9A9A9;">
      <input type="button" name="checkall" value="Check All" class="button2" onclick="checkAll()" /><input type="button" name="uncheckall" value="Uncheck All" class="button2" onclick="uncheckAll()" />
    </div>
  </div>
  <table border="0" cellpadding="5" align="center" class="pagination">
    <tr>
	<td style="text-align:center;">
	  {$pageLinks}<br/>
	  {$pageCounter}<br/>
	  <a href="massdelete.php?showall">{$L_SHOW_ALL_ENTRIES}</a>
	</td>
    </tr>
  </table>
  </form>
</div>
{/if}
{/section}
{include file="$theme/footer.tpl"}