<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Categories
{

	/*
	** Class constructor
	*/
	function Categories(){
		global $database;
	}

	function getCategories(){
		global $database, $session;

		$query = "SELECT * FROM #__categories WHERE visible = '1' AND access <= '$session->useraccess' ORDER BY ordering ASC";
		$categories = $database->getArray($query);

		for($i=0; $i<count($categories); $i++){
			$categories[$i]['links'] = $this->getLinks($categories[$i]['id']);
		}

		return $categories;
	}

	function getLinks($catid){
		global $database, $session;

		$query = "SELECT * FROM #__links WHERE catid = '$catid' AND visible = '1' AND access <= '$session->useraccess' ORDER BY ordering ASC";
		$links = $database->getArray($query);

		return $links;
	}

	function getEntryCategories(){
		global $database, $lang, $journalnessConfig_type, $session;

		if($journalnessConfig_type == "postgres"){
			$query = "SELECT e.*, (SELECT COUNT(*) FROM #__entries WHERE (catids LIKE e.id OR catids LIKE e.id || ',%' OR catids LIKE '%,' || e.id) AND access <= $session->useraccess) as numentries FROM #__entry_categories AS e WHERE e.parent = '0' ORDER BY e.ordering ASC";
		}else{
			$query = "SELECT e.*, COUNT(en.id) as numentries FROM #__entry_categories AS e LEFT JOIN #__entries AS en ON (FIND_IN_SET(e.id,en.catids) > 0 AND access <= $session->useraccess) WHERE e.parent = '0' GROUP BY e.ordering ORDER BY e.ordering ASC";
		}

		$categories = $database->getArray($query);

		for($i=0; $i<count($categories); $i++){
			// Get Sub categories
			$categories[$i]['subcategories'] = $this->getEntrySubcategories($categories[$i]['id']);
		}

		return $categories;
	}

	function getEntrySubcategories($parentid){
		global $database, $lang, $journalnessConfig_type, $session;

		if($journalnessConfig_type == "postgres"){
			$query = "SELECT e.*, (SELECT COUNT(*) FROM #__entries WHERE (catids LIKE e.id OR catids LIKE e.id || ',%' OR catids LIKE '%,' || e.id) AND access <= $session->useraccess) as numentries FROM #__entry_categories AS e WHERE e.parent = '$parentid' ORDER BY e.ordering ASC";
		}else{
			$query = "SELECT e.*, COUNT(en.id) as numentries FROM #__entry_categories AS e LEFT JOIN #__entries AS en ON (FIND_IN_SET(e.id,en.catids) > 0 AND access <= $session->useraccess) WHERE e.parent = '$parentid' GROUP BY e.ordering ORDER BY e.ordering ASC";
		}

		$subcats = $database->getArray($query);

		return $subcats;
	}

	function getEntryCategoriesList(){
		global $database, $lang;

		$query = "SELECT e.id, e.name FROM #__entry_categories AS e WHERE e.parent = '0' ORDER BY e.ordering ASC";
		$categories = $database->getArray($query);

		$categories_list[0] = $lang['All_available'];

		for($i=0; $i<count($categories); $i++){
			// Get Sub categories
			$categories_list[$categories[$i]['id']] = $categories[$i]['name'];
			$subcategories = $this->getEntrySubcategories($categories[$i]['id']);
			for($j=0; $j<count($subcategories); $j++){
				$categories_list[$subcategories[$j]['id']] = "&nbsp;&nbsp;&nbsp;" . $subcategories[$j]['name'];
			}
		}

		return $categories_list;
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

	function getCategoryName($catid){
		global $database;

		$catid = $database->QMagic($catid);		

		$query = "SELECT name FROM #__entry_categories WHERE id = $catid";
		$result = $database->GetArray($query);

		if(isset($result[0]['name'])){
			return $result[0]['name'];
		}
		return false;
	}

}

$categories 	= new Categories();

?>
