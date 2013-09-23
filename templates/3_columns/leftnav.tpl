  <tr>
    <td id="leftnavigation">
	<h6>{$L_JOURNAL_LINKS}</h6>
	<ul class="leftnavigationlist">
	{if $journalnessConfig_journaltype == "2" && !$session_logged_in}
		<li><a href="login.php">{$L_LOGIN}</a></li>
	{else}
	  <li><a href="index.php">{$L_HOME}</a></li>
	  <li><a href="past.php">{$L_ALL_ENTRIES}</a></li>
	  {if $session_logged_in}
	    <li><a href="index.php?{$session_username}">{$L_MY_ENTRIES}</a></li>
		{if $journalnessConfig_post_level <= $session_useraccess}
	  	<li><a href="entry.php">{$L_CREATE_ENTRY}</a></li>
		{/if}
		<li><a href="user.php">{$L_MY_PANEL}</a></li>
	  	{if $session_is_admin}
	  		<li><a href="administrator/">{$L_ADMIN_PANEL}</a></li>
		{/if}
	  {/if}
	  {if $session_logged_in}
	  	<li><div class="leftnavoverflow"><a href="logout.php">{$L_LOGOUT}</a></div></li>
	  {else}
	  	<li><a href="login.php">{$L_LOGIN}</a></li>
	  {/if}
	  {if $journalnessConfig_journaltype == "0"  && !$session_logged_in }
	  	<li><a href="register.php">{$L_REGISTER}</a></li>
	  {/if}
	</ul>
	<br/>
	{section name=userlinks show=$show_user_links}
		{if $session_logged_in}
		  <h6>{$L_USER_PANEL_LINKS}</h6>
		    <ul class="leftnavigationlist">
			<li><a href="user.php?mode=clipboard">{$L_MY_CLIP}</a></li>
			<li><a href="profile.php?mode=editprofile">{$L_MY_PROFILE}</a></li>
			<li><a href="user.php?mode=signature">{$L_EDIT_SIG}</a></li>
			<li><a href="user.php?mode=massdelete">{$L_MASS_ENTRY_DELETE}</a></li>
			<li><a href="user.php?mode=imagemanager">{$L_IMAGE_MANAGER}</a></li>
		    </ul>
		{/if}
		<br/>
	{/section}
	{if $bloggers && $journalnessConfig_show_user_sidebar}
	  <h6>{$L_BLOGGERS}</h6>
	  <ul class="leftnavigationlist">
		{section name=bloggersloop loop=$bloggers}
		  <li><div class="leftnavoverflow"><a href="profile.php?mode=viewprofile&amp;user={$bloggers[bloggersloop].id}">{$bloggers[bloggersloop].username}</a></div></li>
		{/section}
	  </ul>
	  <br/>
	{/if}
	{if $links_list}
	  {section name=categoryloop loop=$links_list}
		<h6>{$links_list[categoryloop].title}</h6>
		{if $links_list[categoryloop]}
		<ul class="leftnavigationlist">
		  {section name=linksloop loop=$links_list[categoryloop].links}
		  <li><a href="{$links_list[categoryloop].links[linksloop].url}" onclick="window.open(this.href); return false;">{$links_list[categoryloop].links[linksloop].title}</a></li>
		  {/section}
		</ul>
		{/if}
	  {/section}
	  <br/>
	{/if}
	{if $journalnessConfig_rss || $journalnessConfig_atom}
	  <h6>{$L_FEEDS}</h6>
		<ul class="leftnavigationlist">
		{if $journalnessConfig_rss}
		  <li><a href="rss.php" ><img src="images/RSS_icon.gif" alt="Feed Icon">{$L_RSS}</a></li>
		{/if}
		{if $journalnessConfig_atom}
		  <li><a href="atom.php"><img src="images/RSS_icon.gif" alt="Feed Icon">{$L_ATOM}</a></li>
		{/if}<br/>
		</ul>
	{/if}
	{if $journalnessConfig_show_hit_count}
	  <div class="centered">
	    {$L_HIT_COUNT}<br/>
	    {$hit_count}
	  </div>
	{/if}
	{/if}
    </td>
    <td id="main">
