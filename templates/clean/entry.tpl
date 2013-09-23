{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name=preview show=$show_preview}
  <div class="centered">
  <table class="entry_table" border="0" width="80%">
    <tr>
	<td class="entry_title" align="left">
	  <strong>{$title_preview}</strong>
    	</td>
    </tr>
    <tr>
    	<td class="entry" colspan="2">
	  {$entry_text_preview}
    	</td>
    </tr>
    <tr>
    	<td colspan="2" class="entry_footer">
  	  {$L_POSTED_ON} {$date_preview} {$L_POSTED_BY} <strong>{$username_preview}</strong>
    	</td>
    </tr>
  </table>
  </div><br/><br/><br/>
{/section}
{section name=createentry show=$show_create_entry}
	<script src="scripts/forms.js" type="text/javascript"></script>
	<div class="centered">
	<form id="entryform" action="entry.php" method="post">
	<table cellpadding="0" cellspacing="0" border="0" width="70%">
	  <tr>
	    <td colspan="3" align="center">
		<h4>{$L_CREATE_ENTRY_TITLE}</h4><br/>
		{if $num_errors > 0}<p style="color:red;">{$num_errors} error(s) found</p>{/if}
	    </td>
	  </tr>
	  <tr>
 	    <td style="width:70%;">
		<h5 class="titletext">{$L_TITLE} {$title_error}</h5>
		<p><input name="title" class="textinput" size="50" maxlength="45" value="{$title_value}"/><br/></p>
		<h5 class="titletext">{$L_ENTRY} {$entry_text_error}</h5>
		<p><input class="button" type="button" value=" u " onclick="ins_styles(this.form.entry_text,'u','')" />
		<input class="button" type="button" value=" b " onclick="ins_styles(this.form.entry_text,'b','')" />
		<input class="button" type="button" value=" i " onclick="ins_styles(this.form.entry_text,'i','')" />
		<input class="button" type="button" value="img" onclick="ins_image(this.form.entry_text,'http://')"/>
		<input class="button" type="button" value="url" onclick="ins_url(this.form.entry_text)" />
		<select class="textinput" name="pictures" onchange="ins_image_dropdown(this.form.entry_text,this.form.pictures);">
		{html_options options=$picture_options selected=$pictures_selected}
		</select>
		{if $journalnessConfig_allow_uploads}
		<a href="upload.php" onclick="window.open('upload.php', 'Upload', 'width=400, height=150'); return false;">{$L_UPLOAD_IMAGE}</a>
		{/if}<br/>
		<input class="button" type="button" value="code" style="margin-top:2px;" onclick="ins_styles(this.form.entry_text,'code','')" />
		<input class="button" type="button" value="quote" style="margin-top:2px;" onclick="ins_quote(this.form.entry_text)" />
		<input class="button" type="button" value="color" style="margin-top:2px;" onclick="ins_color(this.form.entry_text)" />
		<input class="button" type="button" value="size" style="margin-top:2px;" onclick="ins_size(this.form.entry_text)"/><br/>
		<textarea name="entry_text" class="textinput" cols="75" rows="15">{$entry_text_value}</textarea><br/></p>
		<h5 class="titletext">{$L_ACCESS}:</h5>
		<p>{html_options name=access options=$access_options selected=$access_selected}<br/><br/>
		<input class="button" type="submit"  value="{$L_SUBMIT}" name="submit"/>
		<input class="button" type="submit"  value="{$L_PREVIEW}" name="preview"/><br/><br/></p>
  	    </td>
	    <td colspan="2" style="width:30%; vertical-align:top; text-align:left;">
		{if $categories_options}
		<h5 class="titletext">{$L_CATEGORIES}:</h5>
		{section name="loop" loop=$categories_options}
		<label><input type="checkbox" name="entrycategories[]" value="{$categories_options[loop].id}" {if $categories_options[loop].def}checked="checked"{/if} />{$categories_options[loop].name}</label><br/>
		  {section name="loop2" loop=$categories_options[loop].subcategories}
		  <label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="entrycategories[]" value="{$categories_options[loop].subcategories[loop2].id}" {if $categories_options[loop].subcategories[loop2].def}checked="checked"{/if} />{$categories_options[loop].subcategories[loop2].name}</label><br/>
		  {/section}
		{/section}
		{/if}
	    </td>
 	  </tr>
	</table>
	</form>
	</div><br/>
{/section}
{section name=commentsubmitted show=$show_comment_submitted}
  <div class="centered">
    <p>{$L_COMMENT_ENTERED}</p>
    <p><br/>{$L_RETURN_TO_ENTRY}</p>
    <p>{$L_RETURN_TO_INDEX}</p>
  </div>
{/section}
{section name=entrysubmitted show=$show_entry_submitted}
  <div class="centered">
    <p>{$L_MESSAGE_ENTERED}</p>
    <p><br/>{$L_GO_TO_ENTRY}</p>
    <p>{$L_RETURN_TO_INDEX}</p>
  </div>
{/section}
{section name=notloggedin show=$show_not_logged_in}
  <div class="centered">
    <h5>{$L_NOT_LOGGED_IN}</h5><br/>
    <p>{$L_LOGIN_LINK}</p>
  </div>
{/section}
{section name=notallowed show=$show_not_allowed}
  <div class="centered">
    <h5>{$L_NOT_ALLOWED}</h5><br/>
  </div>
{/section}
    </td>
  </tr>
{include file="$theme/footer.tpl"}
