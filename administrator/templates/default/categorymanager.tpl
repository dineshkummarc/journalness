{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name="mainpage" show=$showmainpage}
{if $adminsession_useraccess == "2"}

<div class="categorymanagercontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_CATEGORY_MANAGER}</h1>
	</td>
	<td align="right" valign="bottom">
	  <input class="button2" type="button" value="{$L_SAVE_ORDERING}" name="save_ordering" onclick="updateOrdering();" />
	</td>
    </tr>
    <tr>
	<td align="left" colspan="2" class="description-text">
	  {$L_DRAG_AND_DROP_ORDERING}
	</td>
    </tr>
  </table>
  <div id="page" class="categorydata">
    <table border="0" cellpadding="4" cellspacing="0" class="categoryrowheader">
	  <tr>
	    <th class="categorycolumn1">{$L_CATEGORY_ID}</th>
	    <th class="categorycolumn2"><div class="usercolumn2overflow">{$L_CATEGORY_TITLE}</div></th>
	    <th class="categorycolumn3"><div class="usercolumn3overflow">{$L_CATEGORY_URL}</div></th>
	    <th class="categorycolumn4">{$L_CATEGORY_ACCESS}</th>
	    <th class="categorycolumn5">{$L_CATEGORY_VISIBLE}</th>
	    <th class="categorycolumn6">{$L_CATEGORY_ORDERING}</th>
	    <th class="categorycolumn7">&nbsp;</th>
	  </tr>
    </table>
    {section name="categoryloop" loop=$category_list}
    <div id="category_{$category_list[categoryloop].id}" class="section">
	  <table border="0" cellpadding="4" cellspacing="0" class="categorytable">
	    <tr>
		<td class="categorycolumn1">
			{$smarty.section.categoryloop.iteration}
		</td>
		<td class="categorycolumn2">
			<div class="categorycolumn2overflow">{$category_list[categoryloop].title}</div>
		</td>
		<td class="categorycolumn3">
			<div class="categorycolumn3overflow">{$category_list[categoryloop].url}</div>
		</td>
		<td class="categorycolumn4">
			<a href="javascript:void(0);" id="cataccess_{$category_list[categoryloop].id}" onclick="changeCatAccess('{$category_list[categoryloop].id}');">{$category_list[categoryloop].access}</a>
			<input type="hidden" id="cataccessvalue_{$category_list[categoryloop].id}" value="{$category_list[categoryloop].accessvalue}"/>
		</td>
		<td class="categorycolumn5">
			<a href="javascript:void(0);" onclick="toggleVisibleCat('{$category_list[categoryloop].id}');"><img src="{$category_list[categoryloop].visible_img}" id="catvis_{$category_list[categoryloop].id}" alt="{$category_list[categoryloop].visible}" /></a>
			<input type="hidden" id="catvisvalue_{$category_list[categoryloop].id}" value="{$category_list[categoryloop].visible}"/>
		</td>
		<td class="categorycolumn6">
			{$category_list[categoryloop].ordering}
		</td>
		<td class="categorycolumn7">
			<a href="categorymanager.php?mode=edit&amp;catid={$category_list[categoryloop].id}"><img src="templates/{$theme}/images/edit.gif" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;<a href="categorymanager.php?mode=delete&amp;catid={$category_list[categoryloop].id}"><img src="templates/{$theme}/images/delete.png" alt="Delete" /></a>
		</td>
	    </tr>
	  </table>
	  {section name="linkloop" loop=$category_list[categoryloop].links}
	  <div id="item_{$category_list[categoryloop].links[linkloop].id}" class="lineitem">
	  <table border="0" cellpadding="4" cellspacing="0" class="linktable">
	    <tr>
		<td class="categorycolumn1">
			{$smarty.section.linkloop.iteration}
		</td>
		<td class="categorycolumn2">
			<div class="categorycolumn2overflow">{$category_list[categoryloop].links[linkloop].title}</div>
		</td>
		<td class="categorycolumn3">
			<div class="categorycolumn3overflow">{$category_list[categoryloop].links[linkloop].url}</div>
		</td>
		<td class="categorycolumn4">
			<a href="javascript:void(0);" id="linkaccess_{$category_list[categoryloop].links[linkloop].id}" onclick="changeLinkAccess('{$category_list[categoryloop].links[linkloop].id}');">{$category_list[categoryloop].links[linkloop].access}</a>
			<input type="hidden" id="linkaccessvalue_{$category_list[categoryloop].links[linkloop].id}" value="{$category_list[categoryloop].links[linkloop].accessvalue}"/>
		</td>
		<td class="categorycolumn5">
			<a href="javascript:void(0);" onclick="toggleVisibleLink('{$category_list[categoryloop].links[linkloop].id}');"><img src="{$category_list[categoryloop].links[linkloop].visible_img}" id="linkvis_{$category_list[categoryloop].links[linkloop].id}" alt="{$category_list[categoryloop].links[linkloop].visible}" /></a>
			<input type="hidden" id="linkvisvalue_{$category_list[categoryloop].links[linkloop].id}" value="{$category_list[categoryloop].links[linkloop].visible}"/>
		</td>
		<td class="categorycolumn6">
			{$category_list[categoryloop].links[linkloop].ordering}
		</td>
		<td class="categorycolumn7">
			<a href="categorymanager.php?mode=edit&amp;linkid={$category_list[categoryloop].links[linkloop].id}"><img src="templates/{$theme}/images/edit.gif" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;<a href="categorymanager.php?mode=delete&amp;linkid={$category_list[categoryloop].links[linkloop].id}"><img src="templates/{$theme}/images/delete.png" alt="Delete" /></a>
		</td>
	    </tr>
	  </table>
	  </div>
	  {/section}
    </div>
    {/section}
  </div>
  <table border="0" cellpadding="10" cellspacing="0" width="100%" class="add">
    <tr>
	<td style="width:50%;">
		<h2>{$L_ADD_CATEGORY}</h2>
  		<form action="categorymanager.php?mode=add" method="post">
		<div class="add_category">
    		  <table border="0" cellpadding="0" cellspacing="5" width="100%">
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_TITLE}:<br/>
	    		  <input type="text" name="title" size="30" />
	  		</td>
		    </tr>
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_ACCESS}:<br/>
	    		  {html_options name=access options=$access_options}
	  		</td>
		    </tr>
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_VISIBLE}:<br/>
	    		  {html_options name=visible options=$visible_options}
			</td>
		    </tr>
		    <tr>
			<td align="right">
			  <input type="submit" class="button2" name="add_cat_submit" value="{$L_ADD_CATEGORY}" />
			</td>
		    </tr>
		  </table>
		</div>
		</form>
	</td>
	<td style="width:50%;">
		<h2>{$L_ADD_LINK}</h2>
  		<form action="categorymanager.php?mode=add" method="post">
		<div class="add_link">
    		  <table border="0" cellpadding="0" cellspacing="5" width="100%">
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_TITLE}:<br/>
	    		  <input type="text" name="title" size="30" />
	  		</td>
		    </tr>
		    <tr>
			<td>
			  {$L_CATEGORY_URL}:<br/>
			  <input type="text" name="url" size="40" />
			</td>
		    </tr>
		    <tr>
			<td>
			  {$L_IN_CATEGORY}:<br/>
	    		  {html_options name=incategory options=$incategory_options}
			</td>
		    </tr>
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_ACCESS}:<br/>
	    		  {html_options name=access options=$access_options}
	  		</td>
		    </tr>
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_VISIBLE}:<br/>
	    		  {html_options name=visible options=$visible_options}
			</td>
		    </tr>
		    <tr>
			<td align="right">
			  <input type="submit" class="button2" name="add_link_submit" value="{$L_ADD_LINK}" />
			</td>
		    </tr>
		  </table>
		</div>
		</form>
	</td>
    </tr>
  </table>
</div>
{literal}
<script type="text/javascript">
<!--
	var sectionlist = document.getElementsByClassName('section');
	var sections = Array();
	var i=0;
	sectionlist.each(function(section) {
		var sectionID = section.id;
		sections[i] = sectionID;
		i++;
	});

	function createLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.create(sections[i],{tag:'div',dropOnEmpty: true, containment: sections,only:'lineitem'});
		}
	}

	function destroyLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.destroy(sections[i]);
		}
	}

	function createCategorySortable() {
		Sortable.create('page',{tag:'div',only:'section', handle:'handle'});
	}

	function updateOrdering()
	{
		var order = "";
		var sections = document.getElementsByClassName('section');

		sections.each(function(section) {
			var sectionName = section.id;

			if(Sortable.serialize(sectionName) != ""){
				order += "&";
			}else{
				order += "&" + section.id + "=empty";
			}
			order += Sortable.serialize(sectionName);
		});

		var options = {
			method : 'post',
			parameters : order,
			onComplete : function(request) {
				window.location.href = "categorymanager.php?msg={/literal}{$L_ORDERING_SAVED}{literal}";
			}
		};
		new Ajax.Request('saveorder.php', options);
	}

	function toggleVisibleCat(id){
		var value = document.getElementById('catvisvalue_' + id);
		value = value.value;
		var options = {
			method : 'post',
			parameters : 'toggle_visible_cat=' + id + '&visible=' + value,
			onComplete : function(request) {
				var categoryVisible = document.getElementById('catvis_' + id);
				var value = document.getElementById('catvisvalue_' + id);

				if(value.value == 1){
					categoryVisible.src = "templates/default/images/disabled.png";
					value.value = 0;
				}else{
					categoryVisible.src = "templates/default/images/enabled.png";
					value.value = 1;
				}
			}
		};
		new Ajax.Request('togglevisible.php', options);
	}

	function toggleVisibleLink(id){
		var value = document.getElementById('linkvisvalue_' + id);
		value = value.value;
		var options = {
			method : 'post',
			parameters : 'toggle_visible_link=' + id + '&visible=' + value,
			onComplete : function(request) {
				var linkVisible = document.getElementById('linkvis_' + id);
				var value = document.getElementById('linkvisvalue_' + id);

				if(value.value == 1){
					linkVisible.src = "templates/default/images/disabled.png";
					value.value = 0;
				}else{
					linkVisible.src = "templates/default/images/enabled.png";
					value.value = 1;
				}
			}
		};
		new Ajax.Request('togglevisible.php', options);
	}

	function changeCatAccess(id){
		var value = document.getElementById('cataccessvalue_' + id);
		value = value.value;
		var options = {
			method : 'post',
			parameters : 'cataccessid=' + id + '&cataccessvalue=' + value,
			onComplete : function(request) {
				var catAccess = document.getElementById('cataccess_' + id);
				var value = document.getElementById('cataccessvalue_' + id);

				if(value.value == 0){
					catAccess.innerHTML = "{/literal}{$L_REGISTERED}{literal}";
					value.value = 1;
				}else if(value.value == 1){
					catAccess.innerHTML = "{/literal}{$L_ADMIN}{literal}";
					value.value = 2;
				}else{
					catAccess.innerHTML = "{/literal}{$L_PUBLIC}{literal}";
					value.value = 0;
				}
			}
		};
		new Ajax.Request('changeaccess.php', options);
	}

	function changeLinkAccess(id){
		var value = document.getElementById('linkaccessvalue_' + id);
		value = value.value;
		var options = {
			method : 'post',
			parameters : 'linkaccessid=' + id + '&linkaccessvalue=' + value,
			onComplete : function(request) {
				var linkAccess = document.getElementById('linkaccess_' + id);
				var value = document.getElementById('linkaccessvalue_' + id);

				if(value.value == 0){
					linkAccess.innerHTML = "{/literal}{$L_REGISTERED}{literal}";
					value.value = 1;
				}else if(value.value == 1){
					linkAccess.innerHTML = "{/literal}{$L_ADMIN}{literal}";
					value.value = 2;
				}else{
					linkAccess.innerHTML = "{/literal}{$L_PUBLIC}{literal}";
					value.value = 0;
				}
			}
		};
		new Ajax.Request('changeaccess.php', options);
	}

	createLineItemSortables();
	createCategorySortable();
//-->
 </script>
{/literal}
{/if}
{/section}
{section name="edit" show=$showedit}
{if $adminsession_useraccess == "2"}
<div class="categoryeditcontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1>{if $category}{$L_EDIT_CATEGORY}{else}{$L_EDIT_LINK}{/if}</h1>
	</td>
    </tr>
  </table>
  <div class="categoryeditdata">
  <form action="categorymanager.php?mode=edit" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td>
	    {$L_TITLE}:<br/>
	    <input type="text" name="title" value="{if $category}{$category.title}{else}{$link.title}{/if}" size="30" />
	  </td>
	</tr>
	{if $link}
	<tr>
	  <td>
	    {$L_URL}:<br/>
	    <input type="text" name="url" value="{$link.url}" size="40" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_IN_CATEGORY}:<br/>
	    {html_options name=incategory options=$incategory_options selected=$incategory_selected}
	  </td>
	</tr>
	{/if}
	<tr>
	  <td>
	    {$L_ACCESS}:<br/>
	    {html_options name=access options=$access_options selected=$access_selected}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_VISIBLE}:<br/>
	    {html_options name=visible options=$visible_options selected=$visible_selected}
	  </td>
	</tr>
	<tr>
	  <td align="right">
	    <input type="hidden" name="id" value="{if $category}{$category.id}{else}{$link.id}{/if}" />
	    <input type="submit" class="button2" name="edit_{if $category}cat{else}link{/if}_submit" value="{if $category}{$L_SAVE_CATEGORY}{else}{$L_SAVE_LINK}{/if}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/if}
{/section}
{section name="delete" show=$showdelete}
{if $adminsession_useraccess == "2"}
<div class="categorydeletecontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td colspan="2" align="left">
	  <h1>{if $category}{$L_DELETE_CATEGORY}{else}{$L_DELETE_LINK}{/if}</h1>
	</td>
    </tr>
  </table>
  <div class="categorydeletedata">
  <form action="categorymanager.php?mode=delete" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td>
	    {$L_TITLE}:
	    <strong>{if $category}{$category.title}{else}{$link.title}{/if}</strong>
	  </td>
	</tr>
	{if $link}
	<tr>
	  <td>
	    {$L_URL}:
	    <strong>{$link.url}</strong>
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_IN_CATEGORY}:
	    <strong>{$link.category}</strong>
	  </td>
	</tr>
	{/if}
	<tr>
	  <td>
	    {$L_ACCESS}:
	    <strong>{if $category}{$category.accesstext}{else}{$link.accesstext}{/if}</strong>
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_VISIBLE}:
	    <strong>{if $category}{$category.visibletext}{else}{$link.visibletext}{/if}</strong>
	  </td>
	</tr>
	<tr>
	  <td align="right">
	    <input type="hidden" name="id" value="{if $category}{$category.id}{else}{$link.id}{/if}" />
	    <input type="submit" name="delete_{if $category}cat{else}link{/if}_submit" value="{if $category}{$L_DELETE_CATEGORY}{else}{$L_DELETE_LINK}{/if}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/if}
{/section}
{include file="$theme/footer.tpl"}
