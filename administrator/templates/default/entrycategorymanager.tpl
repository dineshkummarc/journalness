{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name="categorymanager" show=$show_category_manager}
{if $adminsession_useraccess == "2"}

<div class="categorymanagercontainer">
  <div class="centered" style="padding-top:2em;">
    <span style="color:red; font-weight:bold;">{$MSG}</span>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
	<td align="left">
	  <h1>{$L_ENTRY_CATEGORY_MANAGER}</h1>
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
    <tr>
	<td colspan="2" align="left">
	  {$L_DELETE_NOTICE}
	</td>
    </tr>
  </table>
  <div id="page" class="categorydata">
    <table border="0" cellpadding="4" cellspacing="0" class="categoryrowheader">
	  <tr>
	    <th class="entrycategorycolumn1">{$L_CATEGORY_ID}</th>
	    <th class="entrycategorycolumn2"><div class="entrycategorycolumn2overflow">{$L_CATEGORY_NAME}</div></th>
	    <th class="entrycategorycolumn3"><div class="entrycategorycolumn3overflow">{$L_CATEGORY_DESCRIPTION}</div></th>
	    <th class="entrycategorycolumn4">{$L_CATEGORY_DEFAULT}</th>
	    <th class="entrycategorycolumn5">{$L_CATEGORY_NUM_ENTRIES}</th>
	    <th class="entrycategorycolumn6">{$L_CATEGORY_ORDERING}</th>
	    <th class="entrycategorycolumn7">&nbsp;</th>
	  </tr>
    </table>
    {section name="categoryloop" loop=$category_list}
    <div id="category_{$category_list[categoryloop].id}" class="section">
	  <table border="0" cellpadding="4" cellspacing="0" class="categorytable">
	    <tr>
		<td class="entrycategorycolumn1">
			{$smarty.section.categoryloop.iteration}
		</td>
		<td class="entrycategorycolumn2">
			<div class="entrycategorycolumn2overflow">{$category_list[categoryloop].name}</div>
		</td>
		<td class="entrycategorycolumn3">
			<div class="entrycategorycolumn3overflow">{$category_list[categoryloop].description}</div>
		</td>
		<td class="entrycategorycolumn4">
			<img src="{$category_list[categoryloop].defaultimg}" alt="{$category_list[categoryloop].default}" />
		</td>
		<td class="entrycategorycolumn5">
			{$category_list[categoryloop].numentries}
		</td>
		<td class="entrycategorycolumn6">
			{$category_list[categoryloop].ordering}
		</td>
		<td class="entrycategorycolumn7">
			<a href="entrycategorymanager.php?mode=edit&amp;catid={$category_list[categoryloop].id}"><img src="templates/{$theme}/images/edit.gif" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;<a href="entrycategorymanager.php?mode=delete&amp;catid={$category_list[categoryloop].id}"><img src="templates/{$theme}/images/delete.png" alt="Delete" /></a>
		</td>
	    </tr>
	  </table>
	  {section name="subcatloop" loop=$category_list[categoryloop].subcategories}
	  <div id="item_{$category_list[categoryloop].subcategories[subcatloop].id}" class="lineitem">
	  <table border="0" cellpadding="4" cellspacing="0" class="linktable">
	    <tr>
		<td class="entrycategorycolumn1">
			{$smarty.section.subcatloop.iteration}
		</td>
		<td class="entrycategorycolumn2">
			<div class="entrycategorycolumn2overflow">{$category_list[categoryloop].subcategories[subcatloop].name}</div>
		</td>
		<td class="entrycategorycolumn3">
			<div class="entrycategorycolumn3overflow">{$category_list[categoryloop].subcategories[subcatloop].description}</div>
		</td>
		<td class="entrycategorycolumn4">
			<img src="{$category_list[categoryloop].subcategories[subcatloop].defaultimg}" alt="{$category_list[categoryloop].default}" />
		</td>
		<td class="entrycategorycolumn5">
			{$category_list[categoryloop].subcategories[subcatloop].numentries}
		</td>
		<td class="entrycategorycolumn6">
			{$category_list[categoryloop].subcategories[subcatloop].ordering}
		</td>
		<td class="entrycategorycolumn7">
			<a href="entrycategorymanager.php?mode=edit&amp;catid={$category_list[categoryloop].subcategories[subcatloop].id}"><img src="templates/{$theme}/images/edit.gif" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;<a href="entrycategorymanager.php?mode=delete&amp;catid={$category_list[categoryloop].subcategories[subcatloop].id}"><img src="templates/{$theme}/images/delete.png" alt="Delete" /></a>
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
  		<form action="entrycategorymanager.php" method="post">
		<div class="add_category">
    		  <table border="0" cellpadding="0" cellspacing="5" width="100%">
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_NAME}:<br/>
	    		  <input type="text" name="category_name" size="30" />
	  		</td>
		    </tr>
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_PARENT}:<br/>
	    		  {html_options name=category_parent options=$parent_options}
	  		</td>
		    </tr>
		    <tr>
	  		<td>
	    		  {$L_CATEGORY_DESCRIPTION}: ({$L_OPTIONAL})<br/>
	    		  <textarea name="category_description" rows="5" style="width: 98%;"></textarea>
			</td>
		    </tr>
		    <tr>
			<td align="right">
			  <input type="submit" class="button2" name="add_category_submit" value="{$L_ADD_CATEGORY}" />
			</td>
		    </tr>
		  </table>
		</div>
		</form>
	</td>
	<td style="width:50%;">
		<h2>{$L_DEFAULT_CATEGORY}</h2>
  		<form action="entrycategorymanager.php" method="post">
		<div class="add_category">
    		  <table border="0" cellpadding="0" cellspacing="5" width="100%">
		    <tr>
	  		<td>
	    		  {$L_DEFAULT_CATEGORY}:<br/>
	    		  {html_options name=category_default options=$default_options selected=$default_selected}
	  		</td>
		    </tr>
		    <tr>
			<td align="right">
			  <input type="submit" class="button2" name="default_category_submit" value="{$L_SET_DEFAULT}" /> <input type="submit" class="button2" name="not_default_category_submit" value="{$L_SET_NOT_DEFAULT}" />
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
				window.location.href = "entrycategorymanager.php?msg={/literal}{$L_ORDERING_SAVED}{literal}";
			}
		};
		new Ajax.Request('saveentryorder.php', options);
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
	  <h1>{$L_EDIT_CATEGORY}</h1>
	</td>
    </tr>
  </table>
  <div class="categoryeditdata">
  <form action="entrycategorymanager.php" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td>
	    {$L_CATEGORY_NAME}:<br/>
	    <input type="text" name="category_name" value="{$category.name}" size="30" />
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_CATEGORY_PARENT}:<br/>
	    {html_options name=category_parent options=$parent_options selected=$category.parent}
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_CATEGORY_DESCRIPTION}: ({$L_OPTIONAL})<br/>
	    <textarea name="category_description" rows="5" style="width: 98%;">{$category.description}</textarea>
	  </td>
	</tr>	    		  
	<tr>
	  <td align="right">
	    <input type="hidden" name="id" value="{$category.id}" />
	    <input type="submit" class="button2" name="edit_cat_submit" value="{$L_SAVE_CATEGORY}" />
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
	  <h1>{$L_DELETE_CATEGORY}</h1>
	</td>
    </tr>
  </table>
  <div class="categorydeletedata">
  <form action="entrycategorymanager.php" method="post">
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
	  <td>
	    {$L_CATEGORY_NAME}:
	    <strong>{$category.name}</strong>
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_CATEGORY_PARENT}:
	    <strong>{$category.parent_text}</strong>
	  </td>
	</tr>
	<tr>
	  <td>
	    {$L_CATEGORY_DESCRIPTION}:
	    <strong>{$category.description}</strong>
	  </td>
	</tr>
	<tr>
	  <td align="right">
	    <input type="hidden" name="id" value="{$category.id}" />
	    <input type="submit" name="delete_cat_submit" value="{$L_DELETE_CATEGORY}" />
	  </td>
	</tr>
    </table>
  </form>
  </div>
</div>
{/if}
{/section}
{include file="$theme/footer.tpl"}
