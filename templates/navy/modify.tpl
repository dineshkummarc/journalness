{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name=mainpage show=$show_main_page}
  <div class="centered">
  <table border="0">
    <tr>
	<td colspan="2">
{/section}
{section name=deleteentry show=$show_delete_entry}
	  <div class="centered">
	    <p>{$L_DELETE_CONFIRMATION}</p><br/><br/>
	    <form action="modify.php" method="post">
	    <p><input class="textinput" type="hidden" value="{$id}" name="id"/>
	    <input class="button" type="submit" value="{$L_DELETE}" name="delete_submit"/>
	    <input class="button" type="button" value="{$L_GO_BACK}" name="cancel" onclick="javascript:history.back()"/></p>
	    </form>
	  </div>
	</td>
    </tr>
  </table>
  </div>
{/section}
{section name=deletecomment show=$show_confirm_delete_comment}
	  <div class="centered">
	    <p>{$L_COMMENT_DELETE_CONFIRMATION}</p><br/><br/>
	    <form action="modify.php" method="post">
	    <p><input class="textinput" type="hidden" value="{$id}" name="id"/>
	    <input class="textinput" type="hidden" value="{$entryid}" name="entryid"/>
	    <input class="button" type="submit" value="{$L_DELETE}" name="delete_comment_submit"/>
	    <input class="button" type="button" value="{$L_GO_BACK}" name="cancel" onclick="javascript:history.back()"/></p>
	    </form>
	  </div>
	</td>
    </tr>
  </table>
  </div>
{/section}
{section name=entrydeleted show=$show_entry_deleted}
	  <p>{$L_ENTRY_DELETED}</p><br/>
	  <p>{$L_RETURN_TO_INDEX}</p>
	</td>
    </tr>
  </table>
  </div>
{/section}
{section name=commentdeleted show=$show_comment_deleted}
	  <div class="centered">
	    <p>{$L_COMMENT_DELETED}</p><br/>
	    <p>{$L_RETURN_TO_COMMENTS}</p>
	  </div>
	</td>
    </tr>
  </table>
  </div>
{/section}
{section name=preview show=$show_preview}
  <div class="centered">
  <table border="0" width="80%">
    <tr>
	<td class="entry_title" align="left"><br/>
	  <span><strong>{$title_preview}</strong></span>
    	</td>
    </tr>
    <tr>
    	<td colspan="2" class="entry">
	  <p>{$entry_text_preview}</p>
    	</td>
    </tr>
    <tr>
    	<td colspan="2" class="entry_footer">
  	  <p class="modify_entryfooter">{$L_POSTED_ON} {$date_preview} {$L_POSTED_BY} <strong>{$username_preview}</strong>
	  </p>
    	</td>
    </tr>
  </table>
  </div><br/><br/><br/>
{/section}
{section name=modifyentry show=$show_modify_entry}
	  <div class="centered">
	    <form id="entryform" action="modify.php" method="post">
	    <table border="0">
		<tr>
		  <td style="width:70%;" colspan="2">
		    <p>{$L_EDITING_ENTRY}<strong>{$orig_title_value}</strong><br/><br/></p>
		    <h5 class="titletext">{$L_ENTERED_ON}</h5>
		    <p>{$date}<br/><br/></p>
		    {if $num_errors > 0}<p style="color:red; text-align:center;">{$num_errors} error(s) found<br/><br/></p>{/if}
		    <h5 class="titletext">{$L_TITLE}</h5>
		    <p>{$title_error}</p>
		    <p><input class="textinput" name="title" value="{$title_value}" size="50" maxlength="56"/><br/><br/></p>
		    <h5 class="titletext">{$L_ENTRY}</h5>
		    <p>{$entry_text_error}</p>
		    <p><input class="button" type="button" value=" u " onclick="ins_styles(this.form.entry_text,'u','')" />
		    <input class="button" type="button" value=" b " onclick="ins_styles(this.form.entry_text,'b','')" />
		    <input class="button" type="button" value=" i " onclick="ins_styles(this.form.entry_text,'i','')" />
		    <input class="button" type="button" value="img" onclick="ins_image(this.form.entry_text,'http://')"/>
		    <input class="button" type="button" value="url" onclick="ins_url(this.form.entry_text)" />
		    <select class="textinput" name="pictures" onchange="ins_image_dropdown(this.form.entry_text,this.form.pictures);">
		    {html_options options=$picture_options selected=$pictures}
		    </select>
		    {if $journalnessConfig_allow_uploads}
		    <a href="upload.php" onclick="window.open('upload.php', 'Upload', 'width=400, height=150'); return false;" target="newWin">{$L_UPLOAD_IMAGE}</a>
		    {/if}<br/>
		<input class="button" type="button" value="code" style="margin-top:2px;" onclick="ins_styles(this.form.entry_text,'code','')" />
		<input class="button" type="button" value="quote" style="margin-top:2px;" onclick="ins_quote(this.form.entry_text)" />
		<input class="button" type="button" value="color" style="margin-top:2px;" onclick="ins_color(this.form.entry_text)" />
		<input class="button" type="button" value="size" style="margin-top:2px;" onclick="ins_size(this.form.entry_text)"/><br/>
		    <input class="textinput" type="hidden" name="id" value="{$id}"/>
		    <textarea class="textinput" name="entry_text" cols="80" rows="15">{$entry_text_value}</textarea><br/><br/></p>
		    <h5 class="titletext">{$L_ACCESS}:</h5>
		    {html_options name=access options=$access_options selected=$access_selected}<br/><br/>
 		</td>
	    <td style="width:30%; vertical-align:top; text-align:left;">
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
	    <tr>
		<td valign="top">
		  <div style="text-align:left">
		    <p><input class="button" type="submit" value="{$L_SUBMIT_CHANGES}" name="edit_submit"/>
		    <input class="button" type="submit" value="{$L_PREVIEW_CHANGES}" name="edit_preview"></p>
		  </div>
		</td>
		<td valign="top">
		  <div style="text-align:right">
		    <p><input class="button" type="button" value="{$L_GO_BACK}" name="cancel" onclick="javascript:history.back()"/></p>
		  </div>
		</td>
	    </tr>
	  </table>
	  </form>
	</div>
{/section}
{section name=modifycomment show=$show_modify_comment}
	  <div class="centered">
	    <form action="modify.php" method="post">
	    <table border="0">
		<tr>
		  <td colspan="2">
		    <p>{$L_EDITING_COMMENT}<strong>{$orig_title_value}</strong><br/><br/></p>
		    <p><strong>{$L_ENTERED_ON}</strong> <br/>{$date}<br/><br/></p>
		    {if $num_errors > 0}<p style="color:red; text-align:center;">{$num_errors} error(s) found<br/><br/></p>{/if}
		    <p><strong>{$L_TITLE}</strong> {$title_error}</p>
		    <p><input class="textinput" name="title" value="{$title_value}" size="50" maxlength="56"/><br/></p>
		    <p><br/><strong>{$L_COMMENT}</strong> {$comment_text_error}</p>
		    <p><input class="textinput" type="hidden" name="entryid" value="{$entryid}"/>
		    <input class="textinput" type="hidden" name="id" value="{$id}" />
		    <textarea class="textinput" name="comment_text" cols="75" rows="15">{$comment_text_value}</textarea><br/><br/></p>
 		  </td>
		</tr>
		<tr>
		  <td valign="top">
		    <div style="text-align:left">
			<p><input class="button" type="submit" value="{$L_SUBMIT_CHANGES}" name="edit_comment_submit"/></p>
		    </div>
		  </td>
		  <td valign="top">
		    <div style="text-align:right">
			<p><input class="button" type="button" value="{$L_GO_BACK}" name="cancel" onclick="javascript:history.back()"/></p>
		    </div>
		  </td>
		</tr>
	    </table>
	    </form>
	  </div>
{/section}
{section name=notallowed show=$show_not_allowed}
	  <div class="centered">
	    <p>{$L_NOT_ALLOWED}</p>
	  </div>
{/section}
{section name=entrymodified show=$show_entry_modified}
	  <div class="centered">
	    <p>{$L_ENTRY_CHANGES_MADE}</p><br/>
	    <p>{$L_RETURN_TO_ENTRY}</p>
	  </div>
{/section}
{section name=commentmodified show=$show_comment_modified}
	  <div class="centered">
	    <p>{$L_COMMENT_CHANGES_MADE}</p><br/>
	    <p>{$L_RETURN_TO_ENTRY}</p>
	  </div>
{/section}
{section name=notloggedin show=$show_not_logged_in}
	  <div class="centered">
	    <h2>{$L_NOT_LOGGED_IN_EDIT}</h2><br/>
	    <p>{$L_LOGIN_LINK}</p>
	  </div>
{/section}
    </td>
  </tr>
{include file="$theme/footer.tpl"}
