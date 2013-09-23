{include file="$theme/header.tpl"}
{include file="$theme/leftnav.tpl"}
{section name=noentries show=$show_no_entries}
  <div class="centered"><br/>
    <h4>{$L_NO_ENTRIES}</h4><br/>
  </div>
{sectionelse}
	{section name=entryloop loop=$entries}
	  <div class="centered">
	  <table border="0" width="95%" cellspacing="0" cellpadding="0" style="padding:5px;">
	    <tr>
		<td align="left"><br/>
		  <h2 class="entry_title"><a href="past.php?id={$entries[entryloop].id}">{$entries[entryloop].title}</a></h2>
	    	</td>
		{if $entries[entryloop].uid == $session_uid || $session_useraccess == "2"}
		<td align="right"><br/>
		  <form style="margin-bottom:0;" action="modify.php" method="post" enctype="multipart/form-data">
		  <p style="font-weight:bold;"><a href="modify.php?mode=edit&amp;id={$entries[entryloop].id}">(-)</a>
		  <a href="modify.php?mode=delete&amp;id={$entries[entryloop].id}">(X)</a></p></form>
		</td>
		{/if}
	    </tr>
	    <tr>
		<td>
		  <div class="entry_date">{$entries[entryloop].date} {$L_POSTED_BY} <a href="profile.php?mode=viewprofile&amp;user={$entries[entryloop].uid}"><strong>{$entries[entryloop].username}</strong></a></div>
		</td>
	    </tr>
	    <tr>
	    	<td colspan="2" class="entry">
		  {$entries[entryloop].entry_text}
		  {if $entries[entryloop].modify_date}
		    <div class="modify_date">{$L_EDITED_ON} {$entries[entryloop].modify_date} </div>
		  {/if}
	    	</td>
	    </tr>
	    <tr>
	    	<td colspan="2" class="entry_footer">
	  	  {section name=entrycatloop loop=$entries[entryloop].categories}{if $smarty.section.entrycatloop.first}{$L_POSTED} {$L_POSTED_IN} {/if}<a href="past.php?catid={$entries[entryloop].categories[entrycatloop].id}">{$entries[entryloop].categories[entrycatloop].name}</a>{if !$smarty.section.entrycatloop.last}, {/if}{/section} {if $journalnessConfig_allow_comments}| <a href="past.php?id={$entries[entryloop].id}#comments">{$L_COMMENTS} ({$entries[entryloop].numcomments})</a>{/if}
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
{include file="$theme/rightnav.tpl"}
{include file="$theme/footer.tpl"}