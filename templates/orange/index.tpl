{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name=noentries show=$show_no_entries}
  <div class="centered"><br/>
    <h4>{$L_NO_ENTRIES}</h4><br/>
  </div>
{sectionelse}
	{section name=entryloop loop=$entries}
	  <div class="centered">
	  <table border="0" width="80%">
	    <tr>
		<td class="entry_title" align="left"><br/>
		  <span><strong><a href="past.php?id={$entries[entryloop].id}">{$entries[entryloop].title}</a></strong></span>
	    	</td>
		{if $entries[entryloop].uid == $session_uid || $session_useraccess == "2"}
		<td align="right"><br/>
		  <form style="margin-bottom:0;" action="modify.php" method="post" enctype="multipart/form-data">
		  <p><a href="modify.php?mode=edit&amp;id={$entries[entryloop].id}"><img src="templates/{$theme}/images/edit_post.gif" alt="Edit" /></a>
		  <a href="modify.php?mode=delete&amp;id={$entries[entryloop].id}"><img src="templates/{$theme}/images/delete_post.gif" alt="Delete" /></a></p></form>
		</td>
		{/if}
	    </tr>
	    <tr>
	    	<td colspan="2" class="entry">
		  {$entries[entryloop].entry_text}
		  {if $entries[entryloop].modify_date}
		    <div class="modify_date">{$L_EDITED_ON} {$entries[entryloop].modify_date}</div>
		  {/if}
	    	</td>
	    </tr>
	    <tr>
	    	<td colspan="2" class="entry_footer">
	  	  {$L_POSTED_ON} {$entries[entryloop].date} {$L_POSTED_BY} <a href="profile.php?mode=viewprofile&amp;user={$entries[entryloop].uid}"><strong>{$entries[entryloop].username}</strong></a> {section name=entrycatloop loop=$entries[entryloop].categories}{if $smarty.section.entrycatloop.first}{$L_POSTED_IN} {/if}<a href="past.php?catid={$entries[entryloop].categories[entrycatloop].id}">{$entries[entryloop].categories[entrycatloop].name}</a>{if !$smarty.section.entrycatloop.last}, {/if}{/section} {if $journalnessConfig_allow_comments}| <a href="past.php?id={$entries[entryloop].id}#comments">{$L_COMMENTS} ({$entries[entryloop].numcomments})</a>{/if}
		  {if $session_useraccess == "2"}
		    <span>| <b>IP:</b> {$entries[entryloop].ip_address}</span>
		  {/if}
	    	</td>
	    </tr>
	  </table>
	  </div>
	{/section}
  	<br/>
	{if $showall}
      <div class="centered">
	  <p><a href="past.php">{$VIEWALL}</a></p>
	</div>
	{/if}
  	<br/><br/>
{/section}
    </td>
  </tr>
{include file="$theme/footer.tpl"}
