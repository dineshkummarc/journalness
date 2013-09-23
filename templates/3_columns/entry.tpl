{include file="$theme/header.tpl"}
{include file="$theme/leftnav.tpl"}
{section name=preview show=$show_preview}
  <div class="centered">
    <h4 style="margin-top:1.0em;">{$L_PREVIEW}</h4>
    <table border="0" width="95%" cellspacing="0" cellpadding="0" style="padding:5px;">
	<tr>
	  <td align="left" colspan="2"><br/>
	    <h2 class="entry_title">{$title_preview}</h2>
	  </td>
	</tr>
	<tr>
	  <td colspan="2">
	    <div class="entry_date">{$date_preview} {$L_POSTED_BY} <strong>{$username_preview}</strong></div>
	  </td>
	</tr>
	<tr>
	  <td colspan="2" class="entry">
	    {$entry_text_preview}
	  </td>
	</tr>
  </table>
  </div><br/><br/><br/>
{/section}
{section name=createentry show=$show_create_entry}
	<div class="centered">
	<form id="entryform" action="entry.php" method="post">
	<table cellpadding="0" cellspacing="0" border="0" width="95%">
	  <tr>
	    <td align="center">
		<h4>{$L_CREATE_ENTRY_TITLE}</h4><br/>
		{if $num_errors > 0}<p style="color:red;">{$num_errors} error(s) found</p>{/if}
	    </td>
	  </tr>
	  <tr>
 	    <td>
		<h5 class="titletext">{$L_TITLE} {$title_error}</h5>
		<p><input name="title" class="textinput" size="50" maxlength="45" value="{$title_value}"/><br/></p>
		<h5 class="titletext">{$L_ENTRY} {$entry_text_error}</h5>
		<p><input class="button" type="button" value=" u " onclick="ins_styles(this.form.entry_text,'u','')" />
		<input class="button" type="button" value=" b " onclick="ins_styles(this.form.entry_text,'b','')" />
		<input class="button" type="button" value=" i " onclick="ins_styles(this.form.entry_text,'i','')" />
		<input class="button" type="button" value="img" onclick="ins_image(this.form.entry_text,'http://')"/>
		<input class="button" type="button" value="url" onclick="ins_url(this.form.entry_text)" /><br/>
		<input class="button" type="button" value="code" style="margin-top:2px;" onclick="ins_styles(this.form.entry_text,'code','')" />
		<input class="button" type="button" value="quote" style="margin-top:2px;" onclick="ins_quote(this.form.entry_text)" />
		<input class="button" type="button" value="color" style="margin-top:2px;" onclick="ins_color(this.form.entry_text)" />
		<input class="button" type="button" value="size" style="margin-top:2px;" onclick="ins_size(this.form.entry_text)"/><br/>
		<select class="textinput" name="pictures" style="margin-top:2px;" onchange="ins_image_dropdown(this.form.entry_text,this.form.pictures);">
		{html_options options=$picture_options selected=$pictures_selected}
		</select>
		{if $journalnessConfig_allow_uploads}
		<a href="upload.php" style="vertical-align:middle;" onclick="window.open('upload.php', 'Upload', 'width=400, height=150'); return false;">{$L_UPLOAD_IMAGE}</a>
		{/if}<br/>
		<textarea name="entry_text" class="textinput" cols="70" rows="15">{$entry_text_value}</textarea><br/></p>
		{if $categories_options}
		<h5 class="titletext">{$L_CATEGORIES}:</h5>
		{section name="loop" loop=$categories_options}
		<label><input type="checkbox" name="entrycategories[]" value="{$categories_options[loop].id}" {if $categories_options[loop].def}checked="checked"{/if} />{$categories_options[loop].name}</label><br/>
		  {section name="loop2" loop=$categories_options[loop].subcategories}
		  <label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="entrycategories[]" value="{$categories_options[loop].subcategories[loop2].id}" {if $categories_options[loop].subcategories[loop2].def}checked="checked"{/if} />{$categories_options[loop].subcategories[loop2].name}</label><br/>
		  {/section}
		{/section}
		{/if}
		<h5 class="titletext">{$L_ACCESS}:</h5>
		<p>{html_options name=access options=$access_options selected=$access_selected}<br/><br/><br/>
		<input class="button" type="submit"  value="{$L_SUBMIT}" name="submit"/>
		<input class="button" type="submit"  value="{$L_PREVIEW}" name="preview"/></p>
  	    </td>
 	  </tr>
	</table>
	</form>
	</div><br/>
{/section}
{section name=commentsubmitted show=$show_comment_submitted}
  <div class="centered">
    <p><br/>{$L_COMMENT_ENTERED}</p>
    <p><br/>{$L_RETURN_TO_ENTRY}</p>
    <p>{$L_RETURN_TO_INDEX}</p>
  </div>
{/section}
{section name=entrysubmitted show=$show_entry_submitted}
  <div class="centered">
    <p><br/>{$L_MESSAGE_ENTERED}</p>
    <p><br/>{$L_GO_TO_ENTRY}</p>
    <p>{$L_RETURN_TO_INDEX}</p>
  </div>
{/section}
{section name=notloggedin show=$show_not_logged_in}
  <div class="centered">
    <br/><h5>{$L_NOT_LOGGED_IN}</h5><br/>
    <p>{$L_LOGIN_LINK}</p>
  </div>
{/section}
{section name=notallowed show=$show_not_allowed}
  <div class="centered">
    <br/><h5>{$L_NOT_ALLOWED}</h5><br/>
  </div>
{/section}
    </td>
{include file="$theme/rightnav.tpl"}
{include file="$theme/footer.tpl"}
