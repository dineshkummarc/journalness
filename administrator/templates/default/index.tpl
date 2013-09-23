{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{if $adminsession_useraccess == "2"}
<div class="centered">
    <div class="info">
	<h1>{$L_WELCOME}</h1>
	<div class="infotable">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="centered">
	    <tr>
		<td class="topleftborder">
		</td>
		<td class="topborder">
		</td>
		<td class="toprightborder">
		</td>
	    </tr>
	    <tr>
		<td class="leftborder">
		</td>
		<td class="middleborder">
		  <table border="0" cellspacing="0" cellpadding="0" width="100%">
		    <tr>
			<th colspan="4" class="tableheader">
			  <p>{$L_STATISTICS_TITLE}</p>
			</th>
		   </tr>
		   <tr class="tablerow1">
			<td class="textcell">
			  <p><strong>{$L_TOTAL_JOURNAL_POSTS}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$TOTAL_JOURNAL_POSTS}</p>
			</td>
			<td class="textcell">
			  <p><strong>{$L_TOTAL_COMMENTS}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$TOTAL_COMMENTS}</p>
			</td>
		    </tr>
		    <tr class="tablerow2">
			<td class="textcell">
			  <p><strong>{$L_TOTAL_USERS}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$TOTAL_USERS}</p>
			</td>
			<td class="textcell">
			  <p><strong>{$L_PHP_VER}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$PHP_VER}</p>
			</td>
		    </tr>
		    <tr class="tablerow1">
			<td class="textcell">
			  <p><strong>{$L_TOTAL_TABLE_SIZE}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$TOTAL_TABLE_SIZE}</p>
			</td>
			<td class="textcell">
			  <p><strong>{$L_DB_INFO}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$DB_INFO}</p>
			</td>
		    </tr>
		    <tr class="tablerow2">
			<td class="textcell">
			  <p><strong>{$L_UPLOAD_FOLDER_SIZE}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$UPLOAD_FOLDER_SIZE}</p>
			</td>
			<td class="textcell">
			  <p><strong>{$L_DB_UPLOAD_SIZE}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$DB_UPLOAD_SIZE}</p>
			</td>
		    </tr>
		    <tr class="tablerow1">
			<td class="textcell">
	      	  <p><strong>{$L_J_VER}</strong></p>
			</td>
			<td class="datacell">
			  <p>{$J_VER}</p>
			</td>
			<td class="textcell">
	      	  <p><strong>{$L_HIT_COUNT}</strong> (<a href="index.php?mode=resethitcount">{$L_RESET}</a>)</p>
			</td>
			<td class="datacell">
			  <p>{$HIT_COUNT}</p>
			</td>
		    </tr>
		  </table>
		</td>
		<td class="rightborder">
		</td>
	    </tr>
	    <tr>
		<td class="bottomleftborder">
		</td>
		<td class="bottomborder">
		</td>
		<td class="bottomrightborder">
		</td>
	    </tr>
	  </table>
	</div>
	<a href="http://www.sf.net/donate/index.php?group_id=101583" onclick="window.open(this.href); return false;"><img src="templates/{$theme}/images/project-support.jpg" alt="Support this project" /></a>
    </div>
</div>
{/if}
{include file="$theme/footer.tpl"}