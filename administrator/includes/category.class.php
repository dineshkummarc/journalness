<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Categories {

	function Categories(){

	}

	function getCategory($id){
		global $database, $lang;

		$id = $database->QMagic($id);
		$query = "SELECT * FROM #__categories WHERE id = $id";
		$category = $database->getArray($query);

		switch($category[0]['access']){
			case 0:
				$category[0]['accesstext'] = $lang['Public'];
				break;
			case 1:
				$category[0]['accesstext'] = $lang['Registered'];
				break;
			case 2:
				$category[0]['accesstext'] = $lang['Admin'];
				break;
			default:
				$category[0]['accesstext'] = $lang['Public'];
				break;
		}

		switch($category[0]['visible']){
			case 0:
				$category[0]['visibletext'] = $lang['No'];
				break;
			case 1:
				$category[0]['visibletext'] = $lang['Yes'];
				break;
			default:
				$category[0]['visibletext'] = $lang['No'];
				break;
		}

		return $category[0];
	}

	function getLink($id){
		global $database, $lang;

		$id = $database->QMagic($id);
		$query = "SELECT * FROM #__links WHERE id = $id";
		$link = $database->getArray($query);

		switch($link[0]['access']){
			case 0:
				$link[0]['accesstext'] = $lang['Public'];
				break;
			case 1:
				$link[0]['accesstext'] = $lang['Registered'];
				break;
			case 2:
				$link[0]['accesstext'] = $lang['Admin'];
				break;
			default:
				$link[0]['accesstext'] = $lang['Public'];
				break;
		}

		switch($link[0]['visible']){
			case 0:
				$link[0]['visibletext'] = $lang['No'];
				break;
			case 1:
				$link[0]['visibletext'] = $lang['Yes'];
				break;
			default:
				$link[0]['visibletext'] = $lang['No'];
				break;
		}

		return $link[0];
	}
	
	function saveCategory($id, $title, $access, $visible){
		global $database;

		$id = $database->QMagic($id);
		$title = $database->QMagic($title);
		$access = $database->QMagic($access);
		$visible = $database->QMagic($visible);

		$query = "UPDATE #__categories SET title = $title, access = $access, visible = $visible WHERE id = $id";
		$result = $database->Execute($query);

		return $result;
	}

	function saveLink($id, $title, $url, $incategory, $access, $visible){
		global $database;

		$id = $database->QMagic($id);
		$title = $database->QMagic($title);
		$url = $database->QMagic($url);
		$incategory = $database->QMagic($incategory);
		$access = $database->QMagic($access);
		$visible = $database->QMagic($visible);

		$query = "UPDATE #__links SET title = $title, url = $url, catid = $incategory, access = $access, visible = $visible WHERE id = $id";
		$result = $database->Execute($query);

		return $result;
	}

	function deleteCategory($id){
		global $database;

		$id = $database->QMagic($id);

		$query = "DELETE FROM #__categories WHERE id = $id";
		$result = $database->Execute($query);

		$query = "DELETE FROM #__links WHERE catid = $id";
		$result = $database->Execute($query);

		return $result;
	}

	function deleteLink($id){
		global $database;

		$id = $database->QMagic($id);

		$query = "DELETE FROM #__links WHERE id = $id";
		$result = $database->Execute($query);

		return $result;
	}

	function addCategory($title, $access, $visible){
		global $database;

		$query = "SELECT max(ordering) as totalordering FROM #__categories";
		$result = $database->GetArray($query);
		$newordering = $result[0]['totalordering']+1;

		$title = $database->QMagic($title);
		$access = $database->QMagic($access);
		$visible = $database->QMagic($visible);
		$ordering = $database->QMagic($newordering);

		$query = "INSERT INTO #__categories (title, access, visible, ordering) VALUES ($title, $access, $visible, $ordering)";
		$result = $database->Execute($query);

		return $result;
	}

	function addLink($title, $url, $incategory, $access, $visible){
		global $database;

		$title = $database->QMagic($title);
		$url = $database->QMagic($url);
		$incategory = $database->QMagic($incategory);
		$access = $database->QMagic($access);
		$visible = $database->QMagic($visible);

		$query = "SELECT max(ordering) as totalordering FROM #__links WHERE catid = $incategory";
		$result = $database->GetArray($query);
		$newordering = $result[0]['totalordering']+1;
		$ordering = $database->QMagic($newordering);

		$query = "INSERT INTO #__links (title, url, catid, access, visible, ordering) VALUES ($title, $url, $incategory, $access, $visible, $ordering)";
		$result = $database->Execute($query);

		return $result;
	}

	function getCategories(){
		global $database, $journalnessAdminConfig_def_theme, $lang;

		$query = "SELECT * FROM #__categories ORDER BY ordering ASC";
		$categories = $database->getArray($query);

		for($i=0; $i<count($categories); $i++){
			$categories[$i]['visible_img'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/disabled.png";
			if($categories[$i]['visible']){
				$categories[$i]['visible_img'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/enabled.png";
			}
		
			$categories[$i]['accessvalue'] = $categories[$i]['access'];

			switch($categories[$i]['access']){
				case 0:
					$categories[$i]['access'] = $lang['Public'];
					break;
				case 1:
					$categories[$i]['access'] = $lang['Registered'];
					break;
				case 2:
					$categories[$i]['access'] = $lang['Admin'];
					break;
				default:
					$categories[$i]['access'] = $lang['Public'];
					break;
			}
		

			$categories[$i]['links'] = $this->getLinks($categories[$i]['id']);
			/*$categories[$i]['links'] = "";
			$j=1;
			foreach($links as $link){
				$categories[$i]['links'] .= $j . ") <strong>" . $link['title'] . "</strong> (" . $link['url'] . ") <br/>";
				$j++;
			}

			if(empty($categories[$i]['links'])){
				$categories[$i]['links'] = $lang['No_links'];
			}*/
		}

		return $categories;
	}

	function getLinks($catid){
		global $database, $journalnessAdminConfig_def_theme, $lang;

		$query = "SELECT * FROM #__links WHERE catid = '$catid' ORDER BY ordering ASC";
		$links = $database->getArray($query);

		for($i=0; $i<count($links); $i++){
			$links[$i]['visible_img'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/disabled.png";
			if($links[$i]['visible']){
				$links[$i]['visible_img'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/enabled.png";
			}

			$links[$i]['accessvalue'] = $links[$i]['access'];

			switch($links[$i]['access']){
				case 0:
					$links[$i]['access'] = $lang['Public'];
					break;
				case 1:
					$links[$i]['access'] = $lang['Registered'];
					break;
				case 2:
					$links[$i]['access'] = $lang['Admin'];
					break;
				default:
					$links[$i]['access'] = $lang['Public'];
					break;
			}
		}

		return $links;
	}

	function getEntryCategories(){
		global $database, $journalnessAdminConfig_def_theme, $lang, $journalnessConfig_type, $adminsession;

		if($journalnessConfig_type == "postgres"){
			$query = "SELECT e.*, (SELECT COUNT(*) FROM #__entries WHERE (catids LIKE e.id OR catids LIKE e.id || ',%' OR catids LIKE '%,' || e.id) AND access <= $adminsession->useraccess) as numentries FROM #__entry_categories AS e WHERE e.parent = '0' ORDER BY e.ordering ASC";
		}else{
			$query = "SELECT e.*, COUNT(en.id) as numentries FROM #__entry_categories AS e LEFT JOIN #__entries AS en ON (FIND_IN_SET(e.id,en.catids) > 0 AND access <= $adminsession->useraccess) WHERE e.parent = '0' GROUP BY e.ordering ORDER BY e.ordering ASC";
		}

		$categories = $database->getArray($query);

		for($i=0; $i<count($categories); $i++){
			if($categories[$i]['def']){
				$categories[$i]['defaultimg'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/enabled.png";
				$categories[$i]['def'] = $lang['Yes'];
			}else{
				$categories[$i]['defaultimg'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/disabled.png";
				$categories[$i]['def'] = $lang['No'];
			}

			// Get Sub categories
			$categories[$i]['subcategories'] = $this->getEntrySubcategories($categories[$i]['id']);
		}

		return $categories;
	}

	function getEntrySubcategories($parentid){
		global $database, $journalnessAdminConfig_def_theme, $journalnessConfig_type, $lang, $adminsession;

		if($journalnessConfig_type == "postgres"){
			$query = "SELECT e.*, (SELECT COUNT(*) FROM #__entries WHERE (catids LIKE e.id OR catids LIKE e.id || ',%' OR catids LIKE '%,' || e.id) AND access <= $adminsession->useraccess) as numentries FROM #__entry_categories AS e WHERE e.parent = '$parentid' ORDER BY e.ordering ASC";
		}else{
			$query = "SELECT e.*, COUNT(en.id) as numentries FROM #__entry_categories AS e LEFT JOIN #__entries AS en ON (FIND_IN_SET(e.id,en.catids) > 0 AND access <= $adminsession->useraccess) WHERE e.parent = '$parentid' GROUP BY e.ordering ORDER BY e.ordering ASC";
		}

		$subcats = $database->getArray($query);

		for($i=0; $i<count($subcats); $i++){
			if($subcats[$i]['def']){
				$subcats[$i]['defaultimg'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/enabled.png";
				$subcats[$i]['def'] = $lang['Yes'];
			}else{
				$subcats[$i]['defaultimg'] = "templates/" . $journalnessAdminConfig_def_theme . "/images/disabled.png";
				$subcats[$i]['def'] = $lang['No'];
			}
		}

		return $subcats;
	}

	function getCategoriesList(){
		global $database;

		$query = "SELECT id, title FROM #__categories ORDER BY ordering ASC";
		$categories = $database->getArray($query);

		$categoriesList = "";
		for($i=0; $i<count($categories); $i++){
			$categoriesList[$categories[$i]['id']] = $categories[$i]['title'];
		}

		return $categoriesList;
	}

	function getParentEntryCategories($not_include=NULL){
		global $database, $lang;

		if(isset($not_include)){
			$not_include = "AND id != " . $database->QMagic($not_include);
		}

		$query = "SELECT id, name FROM #__entry_categories WHERE parent = '0'" . $not_include . " ORDER BY ordering ASC";
		$categories = $database->getArray($query);

		$categoriesList = "";
		$categoriesList[0] = $lang['None'];
		for($i=0; $i<count($categories); $i++){
			$categoriesList[$categories[$i]['id']] = $categories[$i]['name'];
		}

		return $categoriesList;
	}

	function addEntryCategory($name, $parent, $description){
		global $database;

		if($parent == 0){
			$query = "SELECT max(ordering) as totalordering FROM #__entry_categories WHERE parent = '0'";
		}else{
			$parentdb = $database->QMagic($parent);
			$query = "SELECT max(ordering) as totalordering FROM #__entry_categories WHERE parent = $parentdb";
		}
		$result = $database->GetArray($query);
		$newordering = $result[0]['totalordering']+1;

		$name = $database->QMagic($name);
		$description = $database->QMagic($description);
		$parent = $database->QMagic($parent);
		$ordering = $database->QMagic($newordering);

		$query = "INSERT INTO #__entry_categories (name, description, parent, ordering) VALUES ($name, $description, $parent, $ordering)";
		$result = $database->Execute($query);

		return $result;
	}

	function getDefaultEntryCategories(){
		global $database;

		$query = "SELECT * FROM #__entry_categories WHERE parent = '0' ORDER BY ordering";
		$result = $database->GetArray($query);

		$catList = NULL;
		for($i=0; $i<count($result); $i++){
			$query = "SELECT * FROM #__entry_categories WHERE parent = '" . $result[$i]['id'] . "' ORDER BY ordering";
			$subcats = $database->GetArray($query);

			$catList[$result[$i]['id']] = $result[$i]['name'];

			for($j=0; $j<count($subcats); $j++){
				if($subcats[$j]['parent'] != 0){
					$subcats[$j]['name'] = "&nbsp;&nbsp;&nbsp;" . $subcats[$j]['name'];
				}
				$catList[$subcats[$j]['id']] = $subcats[$j]['name'];
			}
		}

		return $catList;
	}

	function getDefaultEntryCategory(){
		global $database;

		$query = "SELECT * FROM #__entry_categories WHERE def = '1'";
		$result = $database->GetArray($query);

		if(isset($result[0])){
			return $result[0]['id'];
		}
		return false;
	}

	function setDefaultEntryCategory($catid){
		global $database;

		//$def = $this->getDefaultEntryCategory();

		//$query = "UPDATE #__entry_categories SET def = '0' WHERE id = '$def'";
		//$result = $database->Execute($query);

		$catid = $database->QMagic($catid);
		$query = "UPDATE #__entry_categories SET def = '1' WHERE id = $catid";
		$result = $database->Execute($query);

		return $result;
	}

	function setNotDefaultEntryCategory($catid){
		global $database;

		$catid = $database->QMagic($catid);
		$query = "UPDATE #__entry_categories SET def = '0' WHERE id = $catid";
		$result = $database->Execute($query);

		return $result;
	}

	function getEntryCategoryData($catid){
		global $database, $lang;

		$catid = $database->QMagic($catid);
		$query = "SELECT ec.*, ec2.name as parent_text FROM #__entry_categories as ec LEFT JOIN #__entry_categories AS ec2 ON ec.parent = ec2.id WHERE ec.id = $catid";
		$result = $database->GetArray($query);

		if($result[0]['parent'] == 0){
			$result[0]['parent_text'] = $lang['None'];
		}

		return $result[0];
	}

	function removeEntryCategory($id){
		global $database;

		$id = $database->QMagic($id);
		$query = "SELECT * FROM #__entry_categories WHERE id = $id";
		$result = $database->GetArray($query);

		if($result[0]['parent'] == 0){
			$query = "DELETE FROM #__entry_categories WHERE parent = $id";
			$result = $database->Execute($query);

			$query = "DELETE FROM #__entry_categories WHERE id = $id";
			$result = $database->Execute($query);
		}else{
			$query = "DELETE FROM #__entry_categories WHERE id = $id";
			$result = $database->Execute($query);
		}

		return $result;
	}

	function editEntryCategory($id, $name, $parent, $description){
		global $database;
	
		$id = $database->QMagic($id);
		$name = $database->QMagic($name);
		$description = $database->QMagic($description);
		$parent = $database->QMagic($parent);

		$query = "SELECT * FROM #__entry_categories WHERE parent = $id";
		$result = $database->GetArray($query);

		for($i=0; $i<count($result); $i++){
			$query = "UPDATE #__entry_categories SET parent = $parent WHERE id = '" . $result[$i]['id'] . "'";
			$result2 = $database->Execute($query);
		}

		$query = "UPDATE #__entry_categories SET name = $name, description = $description, parent = $parent WHERE id = $id";
		$result = $database->Execute($query);

		return $result;
	}


}

$categories = new Categories;
