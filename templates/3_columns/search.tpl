{include file="$theme/header.tpl"}
{include file="$theme/leftnav.tpl"}
{section name=searchpage show=$show_search_page}
  <div class="centered">
    <br/>
    <form action="search.php" method="post">
    <table border="0" cellpadding="0" cellspacing="1" width="90%" class="searchtable">
	<tr>
	  <th colspan="2" class="searchheader">
	    {$L_SEARCH_QUERY}
	  </th>
	</tr>
	<tr class="searchrow1">
	  <td class="searchcell" width="50%">
	    <strong>{$L_SEARCH_BY_KEYWORD}:</strong><br/>
	    {$L_SEARCH_BY_KEYWORD_EXPLAIN}
	  </td>
	  <td class="searchcell" width="50%">
	    <input type="text" name="search_text" class="textinput" size="30" maxlength="40" />
	  </td>
	<tr>
	<tr class="searchrow2">
	  <td class="searchcell" width="50%">
	    <strong>{$L_SEARCH_BY_AUTHOR}:</strong><br/>
	    {$L_SEARCH_BY_AUTHOR_EXPLAIN}
	  </td>
	  <td class="searchcell" width="50%">
	    <input type="text" name="user" class="textinput" size="30" maxlength="25" />
	  </td>
	<tr>
	  <th colspan="2" class="searchheader">
	    {$L_SEARCH_OPTIONS}
	  </th>
	</tr>
	<tr class="searchrow1">
	  <td class="searchcell2-right" width="25%">
	    <strong>{$L_SEARCH_IN}:</strong><br/>
	  </td>
	  <td class="searchcell2-left" width="25%">
	    <label><input type="checkbox" name="search_in[]" checked="checked" value="title" /> {$L_SEARCH_IN_TITLE}</label><br/>
	    <label><input type="checkbox" name="search_in[]" checked="checked" value="entry_text" /> {$L_SEARCH_IN_ENTRY}</label><br/>
	    <label><input type="checkbox" name="search_in[]" value="comments" /> {$L_SEARCH_IN_COMMENTS}</label><br/>
	  </td>
	</tr>
	<tr class="searchrow2">
	  <td class="searchcell2-right" width="25%">
	    <strong>{$L_SEARCH_IN_CATEGORY}:</strong><br/>
	  </td>
	  <td class="searchcell2-left" width="25%">
	    {html_options name=search_category options=$category_options selected=$category_selected}
	  </td>
	</tr>
	<tr class="searchrow1">
	  <td class="searchcell2-right" width="25%">
	    <strong>{$L_POSTED_WITHIN}:</strong><br/>
	  </td>
	  <td class="searchcell2-left" width="25%">
	    {html_options name=search_date options=$time_options selected=$time_selected}
	  </td>
	</tr>
	<tr class="searchrow2">
	  <td class="searchcell2-right" width="25%">
	    <strong>{$L_SORT_BY}:</strong><br/>
	  </td>
	  <td class="searchcell2-left" width="25%">
	    {html_options name=search_sort_type options=$sort_options selected=$sort_selected}<br/>
	    <label><input type="radio" name="search_sort_direction" value="1" /> {$L_ASCENDING}</label><br/>
	    <label><input type="radio" name="search_sort_direction" value="0" checked="checked" /> {$L_DESCENDING}</label>
	  </td>
	</tr>
	<tr class="searchrow1">
	  <td class="searchcell2-right" width="25%">
	    <strong>{$L_SHOW_RESULTS_AS}:</strong><br/>
	  </td>
	  <td class="searchcell2-left" width="25%">
	    <label><input type="radio" name="search_result_type" value="0" checked="checked" /> List</label><br/>
	    <label><input type="radio" name="search_result_type" value="1" /> Small Previews</label>
	  </td>
	</tr> 
	<tr class="searchrow2">
	  <td class="searchcell2-right" width="25%">
	  </td>
	  <td class="searchcell2-left" width="25%">
	  </td>
	</tr>
	<tr>
	  <td colspan="2" class="searchheader">
	    <input type="submit" name="search_advanced" class="button" value="{$L_SEARCH}" />
	  </td>
	</tr>
    </table>
    </form>
  </div>
{sectionelse}
  {section name=noresults show=$show_no_results}
  <div class="centered">
    <br/><br/><h4>{$L_NO_RESULTS}</h4><br/>
  </div>
  {sectionelse}
	{section name=smallpreview show=$show_small_preview}
	  <div class="centered">
	    <h4>{$L_SEARCH_RESULTS}</h4><br/>
	    <table border="0" cellpadding="0" cellspacing="0" class="searchpreviewtable">
		{section name=entrylist loop=$entries}
		<tr>
		  <td class="searchpreviewtableheader-left">
		    #{$smarty.section.entrylist.iteration+$offset} &nbsp;<a href="past.php?id={$entries[entrylist].id}">{$entries[entrylist].title}</a>
		  </td>
		  <td class="searchpreviewtableheader-right">
		    <a href="past.php?id={$entries[entrylist].id}#comments">{$entries[entrylist].numcomments} {$L_COMMENTS}</a> | {$entries[entrylist].views} {$L_VIEWS}
		  </td>
		</tr>
		<tr>
		  <td colspan="2" class="searchpreviewtableinfo">
		    {$L_POSTED_ON} {$entries[entrylist].date} {$L_POSTED_BY} <a href="profile.php?mode=viewprofile&amp;user={$entries[entrylist].uid}"><strong>{$entries[entrylist].username}</strong></a>
		  </td>
		</tr>
		<tr style="background-color: {cycle values="#E9E9E9,#FFFFFF"}">
		  <td colspan="2" class="searchpreviewtablecell">
		    {$entries[entrylist].preview}
		  </td>
		</tr>
		<tr style="background-color: #FFFFFF;">
		  <td colspan="2">
		    &nbsp;
		  </td>
		</tr>
		{/section}
	    </table><br/>
	    <table border="0" cellpadding="5" align="center">
		<tr>
		  <td style="text-align:center;">
		    {$pageLinks}<br/>
		    {$pageCounter}
		  </td>
		</tr>
	    </table>
	  </div>
	{sectionelse}
	{section name=titles}
	  <div class="centered"><table border="0" cellpadding="5" width="95%">
 	   <tr>
		<td colspan="3" align="center">
		  <h4>{$L_SEARCH_RESULTS}</h4>
		</td>
 	   </tr>
           <tr>
             <td>
               <table class="default_table" border="0" cellpadding="5" align="center" width="100%">
 	   <tr class="default_tableheader">
		<td>
		  <div class="centered">
		    <strong>
			  {$L_DATE}
		    </strong>
		  </div>
		</td>
		<td>
		  <div class="centered">
		    <strong>
			  {$L_TITLE}
		    </strong>
		  </div>
		</td>
		<td>
		  <div class="centered">
		    <strong>
			  {$L_AUTHOR}
		    </strong>
		  </div>
		</td>
		<td>
		  <div class="centered">
		    <strong>
			{$L_COMMENTS}
		    </strong>
		  </div>
		</td>
		<td>
		  <div class="centered">
		    <strong>
			{$L_VIEWS}
		    </strong>
		  </div>
		</td>
	{/section}
	{section name=entrylist loop=$entries}
 	    </tr>
 	    <tr style="background-color:{cycle values="#BBBBBB,#FFFFFF"}">
 		<td>
		  <div class="centered">
		    <p>{$entries[entrylist].smalldate}</p>
		  </div>
		</td>
		<td align="center">
		 <div class="titleoverflow">
		  <p><a href="past.php?id={$entries[entrylist].id}">{$entries[entrylist].title}</a></p>
		 </div>
		</td>
 		<td>
		  <div class="centered">
		    <p><a href="profile.php?mode=viewprofile&amp;user={$entries[entrylist].uid}">{$entries[entrylist].username}</a></p>
		  </div>
		</td>
		<td>
		  <div class="centered">
		    <p><a href="past.php?id={$entries[entrylist].id}#comments">{$entries[entrylist].numcomments}</a></p>
		  </div>
		</td>
		<td colspan="2">
		  <div class="centered">
		    <p>{$entries[entrylist].views}</p>
		  </div>
		</td>
	{/section}
 	    </tr> 
	  </table><br/>
	  <table border="0" cellpadding="5" align="center">
	    <tr>
		<td style="text-align:center;">
		{$pageLinks}<br/>
		{$pageCounter}
	</td>
	</tr>
	</table>
        </td>
        </tr>
        </table>
	</div>
	{/section}
  {/section}
{/section}
</td>
{include file="$theme/rightnav.tpl"}
{include file="$theme/footer.tpl"}