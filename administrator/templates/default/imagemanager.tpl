{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{if $adminsession_useraccess == "2"}
{section name=images show=$showimages}
<div class="templatemanagercontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left" colspan="2">
	  <h1>{$L_IMAGE_MANAGER}</h1>
	</td>
    </tr>
    <tr>
	<td align="left" class="description-text" colspan="2">
	  {$L_BROWSE_IMAGE_UPLOADS}
	</td>
    </tr>
  </table>
  <div class="templatedata">
    <table border="0" cellpadding="5" cellspacing="0">
	{if $viewing_user}
	<tr>
	  <td colspan="5">
	    <a href="imagemanager.php?uid=0"><img src="../images/folder_up.png" alt="Parent Folder" /></a>
	  </td>
	</tr>
	{/if}
    {section name="imageloop" loop=$image_list}
	{if $smarty.section.imageloop.index is div by 5} 
	<tr>
	{/if}
	  <td>
	    <table border="0" cellpadding="0" cellspacing="0" width="144">
		<tr>
		  <td style="vertical-align:top; padding: 5px;">
		    <div class="centered">
		    {if $viewing_user}
		    <a href="javascript:void(0);" onclick="javascript: window.open( '{$journalnessConfig_live_site}/{$image_list[imageloop].image_path}', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width={$image_list[imageloop].image_width_orig+100},height={$image_list[imageloop].image_height_orig+100},directories=no,location=no,left=120,top=80');"><img src="../{$image_list[imageloop].image_path}" alt="Image" class="folderimage" width="{$image_list[imageloop].image_width}" height="{$image_list[imageloop].image_height}" /></a><br/>
		    {$image_list[imageloop].image_name}<br/>
		      <a href="imagemanager.php?edit={$image_list[imageloop].id}"><img src="templates/{$theme}/images/edit.gif" alt="Edit"></a>
			<a href="imagemanager.php?delete={$image_list[imageloop].id}"><img src="templates/{$theme}/images/delete.png" alt="Delete"></a>
		    {else}
		    <a href="imagemanager.php?uid={$image_list[imageloop].uid}"><img src="../images/folder.png" alt="Folder" class="folderimage" /></a><br/>
		    {$image_list[imageloop].username}
		    {/if}
		    </div>
		  </td>
		</tr>
	    </table>
	  </td>
	{if $smarty.section.imageloop.iteration is div by 5 || $smarty.section.imageloop.last} 
	</tr>
	{/if}
    {/section}
    </table>
  </div>
</div>
{/section}
{section name="edit" show=$showedit}
<div class="categoryeditcontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1>{$L_EDIT_IMAGE}</h1>
	</td>
    </tr>
  </table>
  <div class="categoryeditdata">
  <form action="imagemanager.php" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td>
	    {$L_IMAGE_NAME}:<br/>
	    <input type="text" name="image_name" value="{$image_info.image_name}" size="30" />
	  </td>
	</tr> 		  
	<tr>
	  <td align="right">
	    <input type="hidden" name="id" value="{$image_info.id}" />
	    <input type="hidden" name="uid" value="{$image_info.uid}" />
	    <input type="submit" class="button2" name="edit_submit" value="{$L_SAVE_IMAGE}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/section}
{section name="delete" show=$showdelete}
<div class="categorydeletecontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1>{$L_DELETE_IMAGE}</h1>
	</td>
    </tr>
  </table>
  <div class="categorydeletedata">
  <form action="imagemanager.php" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td>
	    {$L_IMAGE_NAME}:
	    <strong>{$image_info.image_name}</strong>
	  </td>
	</tr>
	  <td align="right">
	    <input type="hidden" name="id" value="{$image_info.id}" />
	    <input type="hidden" name="uid" value="{$image_info.uid}" />
	    <input type="submit" name="delete_submit" value="{$L_DELETE_IMAGE}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/section}
{/if}
{include file="$theme/footer.tpl"}