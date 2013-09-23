<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Search
{

	/*
	** Class constructor
	*/
	function Search(){
		global $database;
	}

	function getNumUserEntries($username='', $uid='', $search_text=''){
		global $database, $session, $journalnessConfig_type;

		if(!empty($search_text)){
			$search_text = "%" . $search_text . "%";
			$search_text = $database->QMagic($search_text);
			if($journalnessConfig_type == "postgres"){
				$searchquery = "\n AND (e.entry_text ILIKE $search_text OR e.title ILIKE $search_text)";
			}else{
				$searchquery = "\n AND (e.entry_text LIKE $search_text OR e.title LIKE $search_text)";
			}
		}else{
			$searchquery = "";
		}

		if(!empty($uid)){
			$uid = $database->QMagic($uid);
			$query = "SELECT DISTINCT e.*, "
			. "\n COUNT(c.id) AS numcomments"
			. "\n FROM #__entries AS e"
			. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
			. "\n WHERE e.uid = $uid"
			. $searchquery
			. "\n AND e.access <= '$session->useraccess'"
			. "\n GROUP BY e.id";
		}elseif(!empty($username)){
			$username = $database->QMagic($username);
			$query = "SELECT DISTINCT e.*, "
			. "\n COUNT(c.id) AS numcomments"
			. "\n FROM #__entries AS e"
			. "\n LEFT JOIN #__users AS u ON u.username = $username"
			. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
			. "\n WHERE e.uid = u.id "
			. $searchquery
			. "\n AND e.access <= '$session->useraccess'"
			. "\n GROUP BY e.id";
		}
		$result = $database->GetArray($query);
		$numEntries = count($result);

		return $numEntries;
	}

	function getUserEntries($username='', $uid='', $offset, $limit, $search_text=''){
		global $database, $session, $journalnessConfig_type;

		if(!empty($username)){
			$username = $database->QMagic($username);
			$userquery = "\n WHERE u.username = $username";
		}elseif(!empty($uid)){
			$uid = intval($uid);
			$userquery = "\n WHERE e.uid = $uid";
		}else{
			$userquery = "WHERE ";
		}

		if(!empty($search_text)){
			$search_text = "%" . $search_text . "%";
			$search_text = $database->QMagic($search_text);
			if($journalnessConfig_type == "postgres"){
				$searchquery = "\n AND (e.entry_text ILIKE $search_text OR e.title ILIKE $search_text)";
			}else{
				$searchquery = "\n AND (e.entry_text LIKE $search_text OR e.title LIKE $search_text)";
			}
		}else{
			$searchquery = "";
		}

		$query = "SELECT DISTINCT e.*, u.username AS username, "
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. $userquery
		. $searchquery
		. "\n AND e.access <= '$session->useraccess'"
		. "\n GROUP BY e.id"
		. "\n ORDER BY e.date DESC"
		. "\n LIMIT $limit OFFSET $offset";

		$entries = $database->GetArray($query);

		for($i=0; $i<count($entries); $i++){
			$entries[$i]['smalldate'] = $this->formatDate($entries[$i]['date'], 1);
			$entries[$i]['date'] = $this->formatDate($entries[$i]['date']);
		}

		return $entries;
	}

	function getAdvancedEntries($vars, $offset, $limit){
		global $database, $session, $entry;

		$query = $this->createSearchQuery($vars);
		$query .= " LIMIT " . $limit . " OFFSET " . $offset;
		$entries = $database->GetArray($query);

		for($i=0; $i<count($entries); $i++){
			if($vars['search_result_type'] == "1"){
				$entries[$i]['entry_text'] = $entry->prepareText($entries[$i]['entry_text']);
				$length = strlen($entries[$i]['entry_text']);
				$entries[$i]['entry_text'] = substr($entries[$i]['entry_text'], 0, 200);
				$entries[$i]['preview'] = $entries[$i]['entry_text'];
				$entries[$i]['preview'] = strip_tags($entries[$i]['preview'], "<br>");
				if($length > 200){
					$entries[$i]['preview'] .= "...";
				}
			}
			$entries[$i]['smalldate'] = $this->formatDate($entries[$i]['date'], 1);
			$entries[$i]['date'] = $this->formatDate($entries[$i]['date']);
		}

		return $entries;
	}

	function getNumAdvancedEntries($vars){
		global $database, $session;

		$query = $this->createSearchQuery($vars);

		$result = $database->GetArray($query);
		$numEntries = count($result);

		return $numEntries;
	}

	function getNumSearchAll($search_text){
		global $database, $session, $journalnessConfig_type;

		$search_text = "%" . $search_text . "%";
		$search_text = $database->QMagic($search_text);
		if($journalnessConfig_type == "postgres"){
			$searchquery = "\n WHERE (e.entry_text ILIKE $search_text OR e.title ILIKE $search_text)";
		}else{
			$searchquery = "\n WHERE (e.entry_text LIKE $search_text OR e.title LIKE $search_text)";
		}

		$query = "SELECT DISTINCT e.*, u.username AS username,"
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. $searchquery
		. "\n AND e.access <= '$session->useraccess'"
		. "\n GROUP BY e.id"
		. "\n ORDER BY e.date DESC";

		$result = $database->GetArray($query);
		$numEntries = count($result);

		return $numEntries;
	}

	function searchAll($offset, $limit, $search_text){
		global $database, $session, $journalnessConfig_type;

		$search_text = "%" . $search_text . "%";
		$search_text = $database->QMagic($search_text);
		if($journalnessConfig_type == "postgres"){
			$searchquery = "\n WHERE (e.entry_text ILIKE $search_text OR e.title ILIKE $search_text)";
		}else{
			$searchquery = "\n WHERE (e.entry_text LIKE $search_text OR e.title LIKE $search_text)";
		}

		$query = "SELECT DISTINCT e.*, u.username AS username,"
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. $searchquery
		. "\n AND e.access <= '$session->useraccess'"
		. "\n GROUP BY e.id"
		. "\n ORDER BY e.date DESC"
		. "\n LIMIT $limit OFFSET $offset";

		$entries = $database->GetArray($query);

		for($i=0; $i<count($entries); $i++){
			$entries[$i]['smalldate'] = $this->formatDate($entries[$i]['date'], 1);
			$entries[$i]['date'] = $this->formatDate($entries[$i]['date']);
		}

		return $entries;
	}

	function createSearchQuery($vars){
		global $session, $database, $journalnessConfig_type;

		foreach($vars as $key => $val){
			$_SESSION[$key] = $val;
		}

		$query = "SELECT DISTINCT e.*, u.username AS username, "
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. "\n WHERE ";


		if(!empty($vars['user'])){
			$vars['user'] = "%" . $vars['user'] . "%";
			$vars['user'] = $database->QMagic($vars['user']);
			if($journalnessConfig_type == "postgres"){
				$query .= "u.username ILIKE " . $vars['user'] . " ";
			}else{
				$query .= "u.username LIKE " . $vars['user'] . " ";
			}
		}

		if(!empty($vars['search_text'])){
			if(!empty($vars['user'])){
				$query .= "AND (";
			}else{
				$query .= " (";
			}
			$vars['search_text'] = "%" . $vars['search_text'] . "%";
			$vars['search_text'] = $database->QMagic($vars['search_text']);

			if(isset($vars['search_in'])){
				$count = count($vars['search_in']);
				$i=1;
				foreach($vars['search_in'] as $in){
					if($in == "title"){
						if($journalnessConfig_type == "postgres"){
							$query .= " e.title ILIKE " . $vars['search_text'] . "";
						}else{
							$query .= " e.title LIKE " . $vars['search_text'] . "";
						}
					}elseif($in == "entry_text"){
						if($journalnessConfig_type == "postgres"){
							$query .= " e.entry_text ILIKE " . $vars['search_text'] . "";
						}else{
							$query .= " e.entry_text LIKE " . $vars['search_text'] . "";
						}
					}elseif($in == "comments"){
						if($journalnessConfig_type == "postgres"){
							$query .= " c.title ILIKE " . $vars['search_text'] . " OR c.comment_text ILIKE " . $vars['search_text'];
						}else{
							$query .= " c.title LIKE " . $vars['search_text'] . " OR c.comment_text LIKE " . $vars['search_text'];
						}
					}
	
					if($i < $count){
						$query .= " OR ";
					}

					$i++;
				}
			}else{
				if($journalnessConfig_type == "postgres"){
					$query .= "e.entry_text ILIKE " . $vars['search_text'] . " OR e.title ILIKE " . $vars['search_text'] . " ";	
				}else{
					$query .= "e.entry_text LIKE " . $vars['search_text'] . " OR e.title LIKE " . $vars['search_text'] . " ";	
				}
			}
			$query .= ") ";
		}

		$query .= " AND e.access <= '$session->useraccess'";

		if($journalnessConfig_type == "postgres"){
			$findinset = "e.catids LIKE " . $vars['search_category'] . " OR e.catids LIKE " . $vars['search_category'] . " || ',%' OR e.catids LIKE '%,' || " . $vars['search_category'];
		}else{
			$findinset = "FIND_IN_SET(" . $vars['search_category'] . ",e.catids) > 0";
		}

		if(isset($vars['search_category']) && $vars['search_category'] != 0){
			$vars['search_category'] = $database->QMagic($vars['search_category']);
			$query .= " AND " . $findinset . " ";
		}

		if(isset($vars['search_date']) && $vars['search_date'] != 0){
			$vars['search_date'] = intval($vars['search_date']);
			if($journalnessConfig_type == "postgres"){
				$query .= " AND (CURRENT_TIMESTAMP - INTERVAL '" . $vars['search_date'] . " DAY' <= e.date) ";
			}else{
				$query .= " AND DATE_SUB(CURDATE(), INTERVAL " . $vars['search_date'] . " DAY) <= e.date ";
			}
		}

		$query .= " GROUP BY e.id";

		if(isset($vars['search_sort_type'])){
			if($vars['search_sort_type'] == 0){
				$query .= " ORDER BY e.date ";
			}elseif($vars['search_sort_type'] == 1){
				$query .= " ORDER BY e.title ";
			}elseif($vars['search_sort_type'] == 2){
				$query .= " ORDER BY u.username ";
			}
		}

		if(isset($vars['search_sort_direction'])){
			if($vars['search_sort_direction'] == "1"){
				$query .= " ASC ";
			}else{
				$query .= " DESC ";
			}
		}

		return $query;
	}

	function formatDate($val, $notime=0) {
		$arr = explode("-", $val);
		$arr2 = explode(":", $val);
		$arr3 = explode(" ", $arr2[0]);

		if($notime){
			return date("m/d/y", mktime(0, 0, 0, $arr[1], $arr[2], $arr[0]));
		}else{
			return date("l, F j, Y @ g:i a", mktime($arr3[1], $arr2[1], $arr2[2], $arr[1], $arr[2], $arr[0]));
		}
	}
}

?>