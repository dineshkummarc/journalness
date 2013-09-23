<?php

require_once( 'common.inc.php' );
require_once( 'includes/search.class.php' );

// Reset vars for quick search
if(isset($_POST['qsearch'])){
	foreach($_SESSION as $key => $var){
		if($key == "user" || substr($key, 0, 7) == "search_"){
			unset($_SESSION[$key]);
		}
	}
}

$search_text = NULL;
$user = NULL;
if(!empty($_REQUEST['search_text'])){
	$search_text = $_REQUEST['search_text'];
}
if(!empty($_REQUEST['user'])){
	$user = $_REQUEST['user'];
}
if(!isset($search_text) && !isset($user)){
	$category_options = $categories->getEntryCategoriesList();

	$time_options = array(0 => $lang['All_posts'], 1 => "1 " . $lang['Day'], 7 => "7 " . $lang['Days'], 14 => "2 " . $lang['Weeks'], 30 => "1 " . $lang['Month'], 90 => "3 " . $lang['Months'], 180 => "6 " . $lang['Months'], 364 => "1 " . $lang['Year']);

	$sort_options = array(0 => $lang['Search_order_by_entry_time'], 1 => $lang['Search_order_by_title'], 2 => $lang['Search_order_by_author']);

	$smarty->assign(array(
			"show_search_page" => "true",
			"L_SEARCH_QUERY" => $lang['Search_query'],
			"L_SEARCH_OPTIONS" => $lang['Search_options'],
			"L_SEARCH_BY_KEYWORD" => $lang['Search_by_keyword'],
			"L_SEARCH_BY_KEYWORD_EXPLAIN" => $lang['Search_by_keyword_explain'],
			"L_SEARCH_FOR_ANY" => $lang['Search_for_any'],
			"L_SEARCH_FOR_ALL" => $lang['Search_for_all'],
			"L_SEARCH_BY_AUTHOR" => $lang['Search_by_author'],
			"L_SEARCH_BY_AUTHOR_EXPLAIN" => $lang['Search_by_author_explain'],
			"L_SEARCH_IN" => $lang['Search_in'],
			"L_SEARCH_IN_TITLE" => $lang['Search_in_title'],
			"L_SEARCH_IN_ENTRY" => $lang['Search_in_entry'],
			"L_SEARCH_IN_COMMENTS" => $lang['Search_in_comments'],
			"L_SEARCH_IN_CATEGORY" => $lang['Search_in_category'],
			"category_options" => $category_options,
			"category_selected" => "0",
			"L_POSTED_WITHIN" => $lang['Posted_within'],
			"time_options" => $time_options,
			"time_selected" => "0",
			"L_SORT_BY" => $lang['Sort_by'],
			"sort_options" => $sort_options,
			"sort_selected" => "0",
			"L_ASCENDING" => $lang['Ascending'],
			"L_DESCENDING" => $lang['Descending'],
			"L_SHOW_RESULTS_AS" => $lang['Show_results_as'])
	);

	foreach($_SESSION as $key => $var){
		if($key == "user" || substr($key, 0, 7) == "search_"){
			unset($_SESSION[$key]);
		}
	}
}

if(isset($search_text) || isset($user)){

	// Create search object	
	$search = new Search();


	if(!empty($_GET['offset'])){
		$offset = intval($_GET['offset']);
	}else{
		$offset = '0';
	}

	if(!empty($_GET['limit']) && $_GET['limit'] != $journalnessConfig_list_limit){
		$limit  = intval($_GET['limit']);
	}else{
		$limit  = $journalnessConfig_list_limit;
	}

	/*
	** Only searching by user
	*/
	if(isset($user) && !isset($search_text)){
		if(isset($_POST['search_advanced']) || isset($_SESSION['search_advanced'])){
			if(isset($_POST['search_advanced'])){
				$variables = $_POST;
			}else{
				$variables = $_SESSION;
			}

			$link = "search.php?user=" . $user;
			$vars = array();
			foreach($variables as $key => $var){
				if($key == "user" || substr($key, 0, 7) == "search_"){
					$vars[$key] = $var;
				}
			}

			$entries = $search->getAdvancedEntries($vars, $offset, $limit);
			$numEntries = $search->getNumAdvancedEntries($vars);
		}else{
			$entries = $search->getUserEntries($user, $uid, $offset, $limit);
			$numEntries = $search->getNumUserEntries($user, $uid);
			$link = "search.php?user=" . $user;
		}
	/*
	** Searching through text by a user
	*/
	}elseif(isset($user) && isset($search_text)){
		if(isset($_POST['search_advanced']) || isset($_SESSION['search_advanced'])){
			if(isset($_POST['search_advanced'])){
				$variables = $_POST;
			}else{
				$variables = $_SESSION;
			}

			$link = "search.php?user=" . $user . "&amp;search_text=" . $search_text;
			$vars = array();
			foreach($variables as $key => $var){
				if($key == "user" || substr($key, 0, 7) == "search_"){
					$vars[$key] = $var;
				}
			}
			$entries = $search->getAdvancedEntries($vars, $offset, $limit);
			$numEntries = $search->getNumAdvancedEntries($vars);
		}else{
			$entries = $search->getUserEntries($user, $uid, $offset, $limit, $search_text);
			$numEntries = $search->getNumUserEntries($user, $uid, $search_text);
			$link = "search.php?user=" . $user . "&amp;search_text=" . $search_text;
		}
	
	/*
	** Searching through text by all users
	*/
	}elseif(isset($search_text) && !isset($user)){
		if(isset($_POST['search_advanced']) || isset($_SESSION['search_advanced'])){
			if(isset($_POST['search_advanced'])){
				$variables = $_POST;
			}else{
				$variables = $_SESSION;
			}

			$link = "search.php?search_text=" . $search_text;
			$vars = array();
			foreach($variables as $key => $var){
				if($key == "user" || substr($key, 0, 7) == "search_"){
					$vars[$key] = $var;
				}
			}
			$entries = $search->getAdvancedEntries($vars, $offset, $limit);
			$numEntries = $search->getNumAdvancedEntries($vars);
		}else{
			$entries = $search->searchAll($offset, $limit, $search_text);
			$numEntries = $search->getNumSearchAll($search_text);
			$link = "search.php?search_text=" . $search_text;
		}
	}

	/*
	** No results to be displayed
	*/
	if($numEntries < 1){
		$smarty->assign(array(
			"show_no_results" => "true",
			"L_NO_RESULTS" => $lang['No_results'])
		);

	/*
	** Create pagination and send results to template
	*/
	}else{

		// Create pagination
		require_once( 'includes/pagination.class.php' );
		$pagination = new Pagination($numEntries, $offset, $limit);

		$pageLinks = $pagination->getPageLinks($link);
		$pageCounter = $pagination->getPageCounter();
	
		if(isset($_REQUEST['search_result_type'])){
			$result_type = $_REQUEST['search_result_type'];
		}elseif(isset($_REQUEST['search_result_type'])){
			$result_type = $_SESSION['search_result_type'];
		}else{
			$result_type = 0;
		}

		if(isset($result_type) && $result_type == "1"){
			$smarty->assign(array(
				"show_small_preview" => "true",
				"pageLinks" => $pageLinks,
				"pageCounter" => $pageCounter,
				"entries" => $entries,
				"offset" => $offset,
				"L_DATE" => $lang['Date'],
				"L_SEARCH_RESULTS" => $lang['Search_results'],
				"L_COMMENTS" => $lang['Comments'],
				"L_AUTHOR" => $lang['Author'],
				"L_VIEWS" => $lang['Views'],
				"L_POSTED_ON" => $lang['Posted_on'],
				"L_POSTED_BY" => $lang['Posted_by'])
			);

		}else{

			$smarty->assign(array(
				"pageLinks" => $pageLinks,
				"pageCounter" => $pageCounter,
				"entries" => $entries,
				"L_DATE" => $lang['Date'],
				"L_SEARCH_RESULTS" => $lang['Search_results'],
				"L_DATE_ENTERED" => $lang['Date_entered'],
				"L_TITLE" => $lang['Past_title'],
				"L_POSTED_BY" => $lang['Past_posted_by'],
				"L_AUTHOR" => $lang['Author'],
				"L_COMMENTS" => $lang['Comments'],
				"L_VIEWS" => $lang['Views'])
			);
		}
	}

}

$smarty->display("$theme/search.tpl");

?>