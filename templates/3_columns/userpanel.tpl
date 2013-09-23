{include file="$theme/header.tpl"}
{include file="$theme/leftnav.tpl"}
{section name=clipboard show=$show_clipboard}
  <div class="centered">
    <br/>
    {if $msg}<p style="color:red;">{$msg}<br/><br/></p>{/if}
    <h4>{$L_TITLE}</h4><br/><br/>
	<table class="default_table" border="0" width="90%" cellpadding="2px">
	  <tr>
	    <th style="text-align:center;">
	      <p>{$L_CLIP_TITLE}</p>
	    </th>
	  </tr>
	  <tr>
	    <td>
		<form action="user.php?mode=clipboard" method="post">
		<div class="centered"><textarea class="textinput" name="clipboard" cols="65" rows="15">{$clip_data}</textarea><br/><br/>
		<input type="submit" class="button" value="{$L_UPDATE}" name="submit"/></div>
		</form>
	    </td>
	  </tr>
	</table>
  </div>
{/section}
{section name=signature show=$show_signature}
  <div class="centered">
    <br/>
    {if $msg}<p style="color:red;">{$msg}<br/><br/></p>{/if}
    <h4>{$L_SIG_TITLE}</h4>
    <table class="default_table" border="0" width="95%" cellpadding="2px">
	<tr>
	  <td>
	    <h4>{$L_CURRENT_SIG}:</h4>
	  </td>
      </tr>
      <tr>
	  <td style="text-align:left;">
	   {$sig_html}<br/><br/><br/>
	  </td>
      </tr>
	<tr>
	  <td>
	    <h4>{$L_EDIT_SIG}:</h4>
	  </td>
      </tr>
      <tr>
        <td>
	    <div class="centered">
		<form action="user.php?mode=signature" method="post">
		<p><input type="button" class="button" value=" u " onclick="ins_styles(this.form.signature,'u','')" />
		<input type="button" class="button" value=" b " onclick="ins_styles(this.form.signature,'b','')" />
		<input type="button" class="button" value=" i " onclick="ins_styles(this.form.signature,'i','')" />
		<input type="button" class="button" value="img" onclick="ins_image(this.form.signature,'http://')"/>
		<input type="button" class="button" value="url" onclick="ins_url(this.form.signature)" /><br/>
		<input class="button" type="button" value="code" style="margin-top:2px;" onclick="ins_styles(this.form.signature,'code','')" />
		<input class="button" type="button" value="quote" style="margin-top:2px;" onclick="ins_quote(this.form.signature)" />
		<input class="button" type="button" value="color" style="margin-top:2px;" onclick="ins_color(this.form.signature)" />
		<input class="button" type="button" value="size" style="margin-top:2px;" onclick="ins_size(this.form.signature)"/><br/>
		<textarea name="signature" class="textinput" cols="70" rows="15">{$sig_data}</textarea><br/>
		<input type="submit" class="button" value="{$L_UPDATE}" name="submit"/><br/><br/></p>
		</form>
	    </div>
	  </td>
      </tr>
    </table>
  </div>
{/section}
{section name=massdelete show=$show_mass_delete}

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
<div style="margin-left: 7px;">
<form action="user.php?mode=massdelete" method="post">
  <div style="padding-top:2em;">
    {if $msg}<p style="color:red;">{$msg}<br/><br/></p>{/if}
    <h4>{$L_MASS_ENTRY_DELETE}</h4><br/><br/>
   <input class="button" type="submit" value="{$L_DELETE_SELECTED}" name="delete_selected"/><br/><br/>
  <div style="width: 470px; border: 1px solid #000; font-size: 11px;">
    <table border="0" cellpadding="4" cellspacing="0">
	  <tr>
	    <th style="width:20px; text-align: center;">&nbsp;</th>
	    <th style="width:130px; text-align: left;">{$L_TITLE}</th>
	    <th style="width:100px; text-align: center;">{$L_DATE}</th>
	    <th style="width:215px; text-align: left;">{$L_PREVIEW}</th>
	  </tr>
    {section name="loop" loop=$entries}
	  <tr style="background-color: {cycle values="#E9E9E9, #FFFFFF"};">
	    <td style="width:20px; text-align: center;">
		<input type="checkbox" name="id[]" value="{$entries[loop].id}" />
	    </td>
	    <td style="width:130px; text-align: left;">
		<div style="width:130px; overflow:hidden;">{$entries[loop].title}</div>
	    </td>
	    <td style="width:100px; text-align: center;">
		{$entries[loop].date}
	    </td>
	    <td style="width:215px; text-align: left;">
		<div style="width:215px; overflow:hidden;">{$entries[loop].entry_text}</div>
	    </td>
	  </tr>
    {/section}
	</table>
    <div style="padding: 5px; margin-top: 10px; border-top: 1px solid #A9A9A9;">
      <input type="button" name="checkall" value="Check All" class="button" onclick="checkAll()" /> <input type="button" name="uncheckall" value="Uncheck All" class="button" onclick="uncheckAll()" />
    </div>
  </div>
  <div style="width: 470px;">
  <table border="0" cellpadding="5" align="center" class="pagination">
    <tr>
	<td style="text-align:center;">
	  {$pageLinks}<br/>
	  {$pageCounter}<br/>
	  <a href="user.php?mode=massdelete&showall">{$L_SHOW_ALL_ENTRIES}</a>
	</td>
    </tr>
  </table>
  </div>
  </form>
  </div>
{/section}
{section name=imagemanager show=$show_image_manager}
<div style="margin-left: 7px;">
<form action="user.php?mode=imagemanager" method="post">
  <div style="padding-top:2em;">
    {if $msg}<p style="color:red;">{$msg}<br/><br/></p>{/if}
    <h4>{$L_IMAGE_MANAGER}</h4><br/><br/>
    <p>{$L_BROWSE_USER_IMAGES}</p><br/>
  <div style="width: 470px; border: 1px solid #000; font-size: 11px;">
    <table border="0" cellpadding="5" cellspacing="0">
    {section name="imageloop" loop=$image_list}
	{if $smarty.section.imageloop.index is div by 3} 
	<tr>
	{/if}
	  <td>
	    <table border="0" cellpadding="0" cellspacing="0" width="144">
		<tr>
		  <td style="vertical-align:top; padding: 5px;">
		    <div class="centered">
		    <a href="javascript:void(0);" onclick="javascript: window.open( '{$journalnessConfig_live_site}/{$image_list[imageloop].image_path}', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width={$image_list[imageloop].image_width_orig+100},height={$image_list[imageloop].image_height_orig+100},directories=no,location=no,left=120,top=80');"><img src="{$image_list[imageloop].image_path}" alt="Image" style="border: 1px solid #e0dfe3;" width="{$image_list[imageloop].image_width}" height="{$image_list[imageloop].image_height}" /></a><br/>
		    {$image_list[imageloop].image_name}<br/>
		      <a href="user.php?mode=imagemanager&amp;edit={$image_list[imageloop].id}"><img src="images/edit.gif" alt="Edit"></a>
			<a href="user.php?mode=imagemanager&amp;delete={$image_list[imageloop].id}"><img src="images/delete.png" alt="Delete"></a>
		    </div>
		  </td>
		</tr>
	    </table>
	  </td>
	{if $smarty.section.imageloop.iteration is div by 3 || $smarty.section.imageloop.last} 
	</tr>
	{/if}
    {/section}
    </table>
  </div>
  </form>
  </div>
{/section}
{section name="edit" show=$showedit}
<div style="margin-left: 25px; padding-bottom: 3em; width: 400px;">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1 style="color: #000000; margin: 0px; text-align:left; font-size: 18px; padding-bottom: 5px; padding-top: 2em;">{$L_EDIT_IMAGE}</h1>
	</td>
    </tr>
  </table>
  <div style="border: 1px solid #000; font-size: 11px; padding: 15px; margin-top: 10px;">
  <form action="user.php?mode=imagemanager" method="post">
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
	    <input type="submit" class="button" name="edit_submit" value="{$L_SAVE_IMAGE}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/section}
{section name="delete" show=$showdelete}
<div style="margin-left: 25px; padding-bottom: 3em; width: 400px;">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1 style="color: #000000; margin: 0px; text-align:left; font-size: 18px; padding-bottom: 5px; padding-top: 2em;">{$L_DELETE_IMAGE}</h1>
	</td>
    </tr>
  </table>
  <div style="border: 1px solid #000; font-size: 11px; padding: 15px; margin-top: 10px;">
  <form action="user.php?mode=imagemanager" method="post">
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
	    <input type="submit" class="button" name="delete_submit" value="{$L_DELETE_IMAGE}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/section}
</td>
{include file="$theme/rightnav.tpl"}
{include file="$theme/footer.tpl"}