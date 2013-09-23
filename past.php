<?php

require_once( 'common.inc.php' );

if(isset($_GET['id'])){
	$id = intval($_GET['id']);
	$smarty->assign('show_viewing_entry', 'true');
	
	if(($journalnessConfig_anon_comments == "1" || $session->logged_in) && $journalnessConfig_allow_comments == "1"){
		$smarty->assign('show_comment_form', 'true');
	}

	$entryData = $entry->getEntry($id);

	if(isset($_POST['submit'])){

      	$returnval = $entry->addComment($_POST['entryid'], $_POST['title'], $_POST['comment_text']);
     
      	if($returnval > 0){
         		header("Location: past.php?id=" . $_POST['entryid'] . "#c" . $returnval);
      	}elseif($returnval == 0){
         		$_SESSION['value_array'] = $_POST;
         		$_SESSION['error_array'] = $form->getErrorArray();
         		header("Location: past.php?id=" . $_POST['entryid'] . "#addcomment");
      	}elseif($returnval == -1){
         		$_SESSION['commentsuccess'] = false;
         		header("Location: past.php?id=" . $_POST['entryid'] . "#addcomment");
      	}
	}elseif(isset($_SESSION['commentsuccess'])){
		if($_SESSION['commentsuccess']){

		}else{
			// Problem occured
		}
		unset($_SESSION['commentsuccess']);
	}elseif(isset($entryData['id'])){

		// Increment # of times viewed
		$entry->incrementViewCount($entryData['id']);

		$comments = $entryData['comments'];
		$smarty->assign('comments', $comments);
		$smarty->assign('show_comment_loop', 'true');


		// If there are nav buttons, display them
		if(isset($entryData['navButtons']['prev'])){
			$smarty->assign(array(
				"prev" => $entryData['navButtons']['prev'],
				"prevtitle" => $entryData['navButtons']['prevtitle'])
			);
		}
		if(isset($entryData['navButtons']['next'])){
			$smarty->assign(array(
				"next" => $entryData['navButtons']['next'],
				"nexttitle" => $entryData['navButtons']['nexttitle'])
			);
		}

		$smarty->assign(array(
			"session_uid" => $session->uid,
			"session_useraccess" => $session->useraccess,
			"entry" => $entryData,
			"uid" => $entryData['uid'],
			"id" => $entryData['id'],
			"date" => $entryData['date'],
			"title" => $entryData['title'],
			"entry_text" => $entryData['entry_text'],
			"user" => $entryData['user'],
			"ip_address" => $entryData['ip_address'],
			"numcomments" => count($comments),
			"L_POSTED" => $lang['Posted'],
			"L_POSTED_ON" => $lang['Posted_on'],
			"L_EDITED_ON" => $lang['Edited_on'],
			"L_POSTED_IN" => $lang['Posted_in'],
			"L_POSTED_BY" => $lang['Posted_by'],
			"L_COMMENTS" => $lang['Comments'],
			"L_NO_COMMENTS" => $lang['No_comments'],
			"journalnessConfig_allow_comments" => $journalnessConfig_allow_comments,
			"L_COMMENTS_DISABLED" => $lang['Comments_disabled'],
			"L_ADD_COMMENT" => $lang['Add_comment'],
			"L_TITLE" => $lang['Title'],
			"L_COMMENT" => $lang['Comment'],
			"L_POST_COMMENT" => $lang['Post_comment'],
			"L_PREVIOUS_POST" => $lang['Previous_post'],
			"L_NEXT_POST" => $lang['Next_post'],
			"num_errors" => $form->num_errors,
			"title_value" => $form->value("title"),
			"title_error" => $form->error("title"),
			"comment_text_value" => $form->value("comment_text"),
			"comment_text_error" => $form->error("comment_text"))
		);	
	}else{
		$smarty->assign(array(
			"L_INVALID_ID" => $lang['InvalidID'])
		);
	}

}elseif(isset($_GET['catid'])){
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

	$catname = $categories->getCategoryName($_GET['catid']);
	$entries = $entry->getEntriesCategoryList($_GET['catid'], $offset, $limit);
	$numEntries = $entry->numCategoryEntries($_GET['catid']);

	// Create pagination
	require_once( 'includes/pagination.class.php' );
	$pagination = new Pagination($numEntries, $offset, $limit);

	$link = "past.php?" . $_SERVER['QUERY_STRING'];
	$pageLinks = $pagination->getPageLinks($link);
	$pageCounter = $pagination->getPageCounter();

	$smarty->assign(array(
		"pageLinks" => $pageLinks,
		"pageCounter" => $pageCounter,
		"show_titles" => "true",
		"show_entry_list" => "true",
		"entries" => $entries,
		"show_cat_entries" => "true",
		"L_POSTED" => $lang['Posted'],
		"L_DATE" => $lang['Date'],
		"L_AUTHOR" => $lang['Author'],
		"L_ENTRIES_FOR_CATEGORY" => sprintf($lang['Entries_for_category'], $catname),
		"L_ALL_ENTRIES" => $lang['All_entries'],
		"L_DATE_ENTERED" => $lang['Date_entered'],
		"L_PAST_TITLE" => $lang['Past_title'],
		"L_PAST_POSTED_BY" => $lang['Past_posted_by'],
		"L_COMMENTS" => $lang['Comments'],
		"L_VIEWS" => $lang['Views'])
	);
}elseif(isset($_GET['year']) && isset($_GET['month']) && isset($_GET['day'])){
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

	$year = str_pad($_GET['year'], 4, "20", STR_PAD_LEFT);
	$month = str_pad($_GET['month'], 2, "0", STR_PAD_LEFT);
	$day = str_pad($_GET['day'], 2, "0", STR_PAD_LEFT);
	$date = $year . "-" . $month . "-" . $day;
	$entries = $entry->getDayList($date, $offset, $limit);
	$numEntries = $entry->numDayEntries($date);

	// Create pagination
	require_once( 'includes/pagination.class.php' );
	$pagination = new Pagination($numEntries, $offset, $limit);

	$link = "past.php?" . $_SERVER['QUERY_STRING'];
	$pageLinks = $pagination->getPageLinks($link);
	$pageCounter = $pagination->getPageCounter();

	$smarty->assign(array(
		"pageLinks" => $pageLinks,
		"pageCounter" => $pageCounter,
		"show_titles" => "true",
		"show_entry_list" => "true",
		"show_day_entries" => "true",
		"entries" => $entries,
		"L_ALL_ENTRIES" => $lang['All_entries'],
		"L_ENTRIES_FOR" => sprintf($lang['Entries_for'], date("F jS, Y", mktime(0, 0, 0, $month, $day, $year))),
		"L_DATE_ENTERED" => $lang['Date_entered'],
		"L_PAST_TITLE" => $lang['Past_title'],
		"L_DATE" => $lang['Date'],
		"L_AUTHOR" => $lang['Author'],
		"L_PAST_POSTED_BY" => $lang['Past_posted_by'],
		"L_POSTED" => $lang['Posted'],
		"L_COMMENTS" => $lang['Comments'],
		"L_VIEWS" => $lang['Views'])
	);
}else{
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

	$entries = $entry->getEntriesList($offset, $limit);
	$numEntries = $entry->numEntries();

	// Create pagination
	require_once( 'includes/pagination.class.php' );
	$pagination = new Pagination($numEntries, $offset, $limit);

	$link = "past.php?";
	$pageLinks = $pagination->getPageLinks($link);
	$pageCounter = $pagination->getPageCounter();

	$smarty->assign(array(
		"pageLinks" => $pageLinks,
		"pageCounter" => $pageCounter,
		"show_titles" => "true",
		"show_entry_list" => "true",
		"entries" => $entries,
		"L_ALL_ENTRIES" => $lang['All_entries'],
		"L_DATE_ENTERED" => $lang['Date_entered'],
		"L_DATE" => $lang['Date'],
		"L_AUTHOR" => $lang['Author'],
		"L_PAST_TITLE" => $lang['Past_title'],
		"L_PAST_POSTED_BY" => $lang['Past_posted_by'],
		"L_COMMENTS" => $lang['Comments'],
		"L_VIEWS" => $lang['Views'])
	);
}

$smarty->display("$theme/past.tpl");

?>