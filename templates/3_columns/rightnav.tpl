  <td id="rightnavigation">
    {if $journalnessConfig_journaltype == "2" && !$session_logged_in}
    {else}
	<ul class="navigationlist">
	{if $journalnessConfig_show_calendar}
	  <li>
	  <h6>{$L_CALENDAR}</h6><br/>
		{$calendar}<br/>
	  </li>
	{/if}
	{if $sidebar_entries}
	  <li>
	  <h6>{$L_RECENT_ENTRIES}</h6>
	  <ul class="recententrieslist" style="font-size: 10px;">
		{section name=sideentriesloop loop=$sidebar_entries}
		  <li class="recententries"><div class="navoverflow"><a href="past.php?id={$sidebar_entries[sideentriesloop].id}">{$sidebar_entries[sideentriesloop].date_notime}: {$sidebar_entries[sideentriesloop].title}</a></div>
		  </li>
		{/section}
	  </ul>
	  <br/>
	  </li>
	{/if}
	{if $categorylist}
	  <li>
	  <h6>{$L_CATEGORIES}</h6>
	  <ul class="categorieslist" style="font-size: 10px;">
		{section name=catloop loop=$categorylist}
		  <li class="categories"><div class="navoverflow">&raquo; <a href="past.php?catid={$categorylist[catloop].id}">{$categorylist[catloop].name}</a> ({$categorylist[catloop].numentries})</div>
		  </li>
		  {section name=subcatloop loop=$categorylist[catloop].subcategories}
		  <li class="categories"><div class="navoverflow">&nbsp;&nbsp;&nbsp;&raquo; <a href="past.php?catid={$categorylist[catloop].subcategories[subcatloop].id}">{$categorylist[catloop].subcategories[subcatloop].name}</a> ({$categorylist[catloop].subcategories[subcatloop].numentries})</div>
		  </li>
		  {/section}
		{/section}
	  </ul>
	  <br/>
	  </li>
	{/if}
	</ul>
    {/if}
  </td>
 </tr>
