<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );


// Include XSS (Cross-site scripting) Protection
define('XML_HTMLSAX3', dirname(__FILE__) . "/");
require_once($journalnessConfig_absolute_path . '/includes/safehtml.php');

class Entry
{
	var $title; 		 // Title of the entry
	var $entry_text; 		 // Text contained in the entry
	var $uid;			 // UserID of the person who posted the entry
	var $userdata = array(); // More information about the user

	/*
	** Class constructor
	*/
	function Entry(){
		global $database;
	}

	function addEntry($title, $entry_text, $access, $entrycategories){
		global $database, $session, $form;

      	$field = "title";
      	if(!$title || strlen($title = trim($title)) == 0){
        		$form->setError($field, "* Title has not been entered");
		}elseif(strlen($title) > 45){
			$form->setError($field, "* Title is too long");
      	}else{
         		$title = $this->prepareTextInput($title);
      	}

      	$field = "entry_text";
		if(!$entry_text){
			$form->setError($field, "* Entry has not been entered");
		}else{
			$entry_text = $this->prepareTextInput($entry_text);
		}

		$entrycategories = implode(",", $entrycategories);
		$entrycategories = $database->QMagic($entrycategories);

		$access = intval($access);
		$access = $database->QMagic($access);

		$date = date('Y-m-d H:i:s');

		if($form->num_errors > 0){
			return 0;
		}else{
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$query = "INSERT INTO #__entries (title, entry_text, date, uid, access, catids, ip_address) VALUES ($title, $entry_text, '$date', '$session->uid', $access, $entrycategories, '$ip_address')";
			$result = $database->Execute($query);

			if($result){
				if($database->Insert_ID()){
					return $database->Insert_ID();
				}else{
					$query = "SELECT max(id) as id FROM #__entries";
					$result = $database->GetArray($query);
					return $result[0]['id'];
				}
			}else{
				return -1;
			}
		}

	}

	function addComment($entryid, $title, $comment_text){
		global $database, $session, $form, $journalnessConfig_anon_comments;

      	$field = "title";
      	if(!$title || strlen($title = trim($title)) == 0){
        		$form->setError($field, "* Title has not been entered");
		}elseif(strlen($title) > 30){
			$form->setError($field, "* Title is too long");
      	}else{
         		$title = $this->prepareTextInput($title);
      	}

      	$field = "comment_text";
		if(!$comment_text){
			$form->setError($field, "* Entry has not been entered");
		}else{
			$comment_text = $this->prepareTextInput($comment_text);
		}

		$date = date('Y-m-d H:i:s');
		$entryid = intval($entryid);
		$entryid = $database->QMagic($entryid);

		if($form->num_errors > 0){
			return 0;
		}else{
			if((!$session->logged_in && $journalnessConfig_anon_comments) || $session->logged_in){
				$query = "SELECT access FROM #__entries WHERE id = $entryid";
				$result = $database->GetArray($query);
				$access = $result[0]['access'];

				if($access <= $session->useraccess){
					$ip_address = $_SERVER['REMOTE_ADDR'];
					$query = "INSERT INTO #__comments (entryid, title, comment_text, date, uid, ip_address) VALUES ($entryid, $title, $comment_text, '$date', '$session->uid', '$ip_address')";

					$result = $database->Execute($query);
				}else{
					$result = 0;
				}

				if($result){
					if($database->Insert_ID()){
						return $database->Insert_ID();
					}else{
						$query = "SELECT max(id) as id FROM #__comments";
						$result = $database->GetArray($query);
						return $result[0]['id'];
					}
				}else{
					return -1;
				}
			}else{
				return -1;
			}
		}
	}

	function incrementViewCount($id){
		global $database;

		$id = $database->QMagic($id);
		$views = $this->getViewCount($id);
		$views++;

		$query = "UPDATE #__entries SET views = '$views' WHERE id = $id";
		$result = $database->Execute($query);
	}

	function getViewCount($id){
		global $database;
		
		$query = "SELECT views FROM #__entries WHERE id = $id";
		$result = $database->GetArray($query);
		$views = intval($result[0]['views']);

		return $views;
	}

	function getEntry($id, $textonly="0"){
		global $database, $session, $journalnessConfig_next_prev;

		$id = $database->QMagic($id);
		$query = "SELECT e.*, u.sig AS signature, u.username AS user FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n WHERE e.id = $id AND e.access <= $session->useraccess";

		$entry = $database->GetArray($query);

		// Set next and previous buttons
		$navButtons = "";
		if($journalnessConfig_next_prev){
			$query = "SELECT max(id) as prev FROM #__entries WHERE id < $id AND access <= '$session->useraccess' ORDER BY id LIMIT 1";
			$result = $database->GetArray($query);
			$navButtons['prev'] = $result[0]['prev'];

			$query = "SELECT min(id) as next FROM #__entries WHERE id > $id AND access <= '$session->useraccess' ORDER BY id LIMIT 1";					$result = $database->GetArray($query);
			$navButtons['next'] = $result[0]['next'];

			$query = "SELECT title as prev_title FROM #__entries WHERE id = '" . $navButtons['prev'] . "' ORDER BY title LIMIT 1";
			$prev_title = $database->GetArray($query);
			if(isset($prev_title[0])){
				$prev_title = $prev_title[0]['prev_title'];
			}
			$query = "SELECT title as next_title FROM #__entries WHERE id = '" . $navButtons['next'] . "' ORDER BY title LIMIT 1";
			$next_title = $database->GetArray($query);
			if(isset($next_title[0])){
				$next_title = $next_title[0]['next_title'];
			}

			if(isset($navButtons['prev'])){
				$navButtons['prevtitle'] = $prev_title;
			}

			if(isset($navButtons['next'])){
				$navButtons['nexttitle'] = $next_title;
			}
		}

		if(count($entry)){
			$entry = $entry[0];

			if($textonly){

			}else{
				$entry['entry_text'] .= $this->appendSignature($entry['signature']);
				$entry['entry_text']  = $this->prepareText($entry['entry_text']);
				$entry['comments'] = $this->getComments($id);
			}
			$entry['date'] = $this->formatDate($entry['date']);
			if(isset($entry['modify_date'])){
				$entry['modify_date'] = $this->formatDate($entry['modify_date']);
			}
			$entry['navButtons'] = $navButtons;

			$entrycategories = $this->getEntryCategories();
			$catlist = explode(",", $entry['catids']);

			foreach($catlist as $catid){
				if(isset($entrycategories[$catid])){
					$entry['categories'][] = array("id" => $catid, "name" => $entrycategories[$catid]);
				}
			}

			return $entry;
		}else{
			$entry['navButtons'] = $navButtons;

			return $entry;
		}
	}

	function getComment($id, $textonly="0"){
		global $database, $session;

		if($session->is_admin){
			$id = $database->QMagic($id);
			$query = "SELECT c.* FROM #__comments AS c"
			. "\n WHERE id = $id";
			$comment = $database->GetArray($query);

			if(count($comment)){
				$comment = $comment[0];

				if($textonly){

				}else{
					$comment['comment_text']  = $this->prepareText($comment['comment_text']);
				}
				$comment['date'] = $this->formatDate($comment['date']);

				return $comment;
			}else{
				return false;
			}
		}
	
		return false;
	}

	function editEntry($entryid, $newtitle, $newentrytext, $access, $entrycategories){
		global $database, $session, $form;

      	$field = "title";
      	if(!$newtitle || strlen($newtitle = trim($newtitle)) == 0){
        		$form->setError($field, "* Title has not been entered");
      	}else{
         		$newtitle = $this->prepareTextInput($newtitle);
      	}

      	$field = "entry_text";
		if(!$newentrytext){
			$form->setError($field, "* Entry has not been entered");
		}else{
			$newentrytext = $this->prepareTextInput($newentrytext);
		}

		$access = $database->QMagic($access);

		$entrycategories = implode(",", $entrycategories);
		$entrycategories = $database->QMagic($entrycategories);

		if($form->num_errors > 0){
			return 1;
		}else{
			$entryid = intval($entryid);
			$now = date('Y-m-d H:i:s');
			$query = "UPDATE #__entries SET title = $newtitle, entry_text = $newentrytext, modify_date = '$now', access = $access, catids = $entrycategories WHERE id = '$entryid'";
			$result = $database->Execute($query);

			if($result){
				return 0;
			}else{
				return 2;
			}
		}

		return $result;
	}

	function editComment($id, $entryid, $newtitle, $newcommenttext){
		global $database, $session, $form;

      	$field = "title";
      	if(!$newtitle || strlen($newtitle = trim($newtitle)) == 0){
        		$form->setError($field, "* Title has not been entered");
      	}else{
         		$newtitle = $this->prepareTextInput($newtitle);
      	}

      	$field = "comment_text";
		if(!$newcommenttext){
			$form->setError($field, "* Entry has not been entered");
		}else{
			$newcommenttext = $this->prepareTextInput($newcommenttext);
		}

		if($form->num_errors > 0){
			return 1;
		}else{
			$id = intval($id);
			$entryid = intval($entryid);
			$query = "UPDATE #__comments SET title = $newtitle, comment_text = $newcommenttext WHERE id = '$id' AND entryid = '$entryid'";
			$result = $database->Execute($query);

			if($result){
				return 0;
			}else{
				return 2;
			}
		}

		return $result;
	}

	function removeEntry($id){
		global $database, $session;

		$id = intval($id);
		$id = $database->QMagic($id);
		$uid = $database->QMagic($session->uid);
		$check = "";

		if(!$session->is_admin){
			$check = "AND uid = $uid";
		}

		// Remove the entry
		$query = "DELETE FROM #__entries WHERE id = $id " . $check;
		$result = $database->Execute($query);

		// Remove all comments attached to the entry
		if($result){
			$query = "DELETE FROM #__comments WHERE entryid = $id";
			$result = $database->Execute($query);
		}

		return $result;
	}

	function removeComment($id, $entryid){
		global $database, $session;

		$id = intval($id);
		$id = $database->QMagic($id);
		$entryid = intval($entryid);
		$entryid = $database->QMagic($entryid);

		$result = false;
		if($session->is_admin){
			// Remove the entry
			$query = "DELETE FROM #__comments WHERE id = $id AND entryid = $entryid";
			$result = $database->Execute($query);
		}

		return $result;
	}

	function getEntryPreview($title, $entry_text){
		global $database, $session;

		$preview['title'] = $this->prepareTextPreview($title);
		$preview['entry_text'] = $this->prepareTextPreview($entry_text);
		$preview['entry_text_original'] = $preview['entry_text'];
		$preview['entry_text'] = $this->prepareText($preview['entry_text']);
		$preview['date'] = date('Y-m-d H:i:s');
		$preview['date'] = $this->formatDate($preview['date']);

		return $preview;
	}

	function getPictures(){
		global $database, $session, $lang;

		$query = "SELECT image_path, image_name FROM #__uploads WHERE uid = '" . $session->uid . "'";
		$result = $database->GetArray($query);

		$pictures['default'] = $lang['Select_picture'];

		for($i=0; $i<count($result); $i++){
			$pictures[$result[$i]['image_path']] = $result[$i]['image_name'];
		}

		return $pictures;
	}


	function getComments($id){
		global $database, $journalnessConfig_guest_name;

		$query = "SELECT c.*, u.sig AS signature, u.username AS username FROM #__comments AS c"
		. "\n LEFT JOIN #__users AS u ON u.id = c.uid"
		. "\n WHERE c.entryid = $id ORDER BY c.date ASC";
		$comments = $database->GetArray($query);

		for($i=0; $i<count($comments); $i++){
			if($comments[$i]['uid'] == "0"){
				$comments[$i]['username'] = $journalnessConfig_guest_name;
			}
			$comments[$i]['comment_text'] .= $this->appendSignature($comments[$i]['signature']);
			$comments[$i]['comment_text'] = $this->prepareText($comments[$i]['comment_text']);
			$comments[$i]['date'] = $this->formatDate($comments[$i]['date']);
		}

		return $comments;
	}

	function getEntriesList($offset='', $limit=''){
		global $database, $session;

		$query = "SELECT e.*, u.username AS username, "
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. "\n WHERE e.access <= '$session->useraccess'"
		. "\n GROUP BY e.date"
		. "\n ORDER BY e.date DESC"
		. "\n LIMIT $limit OFFSET $offset";
		$entries = $database->GetArray($query);
		$entrycategories = $this->getEntryCategories();

		for($i=0; $i<count($entries); $i++){
			if(isset($entries[$i]['modify_date'])){
				$entries[$i]['modify_date'] = $this->formatDate($entries[$i]['date']);
			}
			$entries[$i]['datesmall'] = $this->formatDate($entries[$i]['date'], 1);
			$entries[$i]['date'] = $this->formatDate($entries[$i]['date']);
			$catlist = explode(",", $entries[$i]['catids']);

			foreach($catlist as $catid){
				if(isset($entrycategories[$catid])){
					$entries[$i]['categories'][] = array("id" => $catid, "name" => $entrycategories[$catid]);
				}
			}
		}

		return $entries;
	}

	function numEntries(){
		global $database, $session;

		$query = "SELECT e.* FROM #__entries AS e"
		. "\n WHERE e.access <= '$session->useraccess'";
		$result = $database->GetArray($query);
		$numEntries = count($result);

		return $numEntries;
	}

	function getEntriesCategoryList($catid, $offset='', $limit=''){
		global $database, $session, $journalnessConfig_type;

		$catid = $database->QMagic($catid);

		if($journalnessConfig_type == "postgres"){
			$findinset = "e.catids LIKE $catid OR e.catids LIKE $catid || ',%' OR e.catids LIKE '%,' || $catid";
		}else{
			$findinset = "FIND_IN_SET($catid,e.catids) > 0";
		}

		$query = "SELECT e.*, u.username AS username, "
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. "\n WHERE e.access <= '$session->useraccess' AND"
		. "\n " . $findinset . " "
		. "\n GROUP BY e.date"
		. "\n ORDER BY e.date DESC"
		. "\n LIMIT $limit OFFSET $offset";

		$entries = $database->GetArray($query);
		$entrycategories = $this->getEntryCategories();

		for($i=0; $i<count($entries); $i++){
			if(isset($entries[$i]['modify_date'])){
				$entries[$i]['modify_date'] = $this->formatDate($entries[$i]['date']);
			}
			$entries[$i]['datesmall'] = $this->formatDate($entries[$i]['date'], 1);
			$entries[$i]['date'] = $this->formatDate($entries[$i]['date']);

			$catlist = explode(",", $entries[$i]['catids']);

			foreach($catlist as $catid){
				if(isset($entrycategories[$catid])){
					$entries[$i]['categories'][] = array("id" => $catid, "name" => $entrycategories[$catid]);
				}
			}
		}

		return $entries;
	}



	function numCategoryEntries($catid){
		global $database, $session, $journalnessConfig_type;

		$catid = $database->QMagic($catid);

		if($journalnessConfig_type == "postgres"){
			$findinset = "e.catids LIKE $catid OR e.catids LIKE $catid || ',%' OR e.catids LIKE '%,' || $catid";
		}else{
			$findinset = "FIND_IN_SET($catid,e.catids) > 0";
		}

		$query = "SELECT e.* FROM #__entries AS e"
		. "\n WHERE e.access <= '$session->useraccess'"
		. "\n AND " . $findinset . " ";
		$result = $database->GetArray($query);
		$numEntries = count($result);

		return $numEntries;
	}

	function getUserEntriesList($offset='', $limit=''){
		global $database, $session;

		$query = "SELECT e.*, u.username AS username, "
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. "\n WHERE e.uid = '$session->uid'"
		. "\n GROUP BY e.date"
		. "\n ORDER BY e.date DESC"
		. "\n LIMIT $limit OFFSET $offset";
		$entries = $database->GetArray($query);
		$entrycategories = $this->getEntryCategories();

		for($i=0; $i<count($entries); $i++){
			if(isset($entries[$i]['modify_date'])){
				$entries[$i]['modify_date'] = $this->formatDate($entries[$i]['date']);
			}
			$entries[$i]['datesmall'] = $this->formatDate($entries[$i]['date'], 1);
			$entries[$i]['date'] = $this->formatDate($entries[$i]['date'], 1);
			$length = strlen($entries[$i]['entry_text']);
			$entries[$i]['entry_text'] = substr($entries[$i]['entry_text'], 0, 100);
			if($length > 100){
				$entries[$i]['entry_text'] .= "...";
			}

			$catlist = explode(",", $entries[$i]['catids']);

			foreach($catlist as $catid){
				if(isset($entrycategories[$catid])){
					$entries[$i]['categories'][] = array("id" => $catid, "name" => $entrycategories[$catid]);
				}
			}
		}

		return $entries;
	}

	function getNumUserEntries(){
		global $database, $session;

		$query = "SELECT e.* FROM #__entries AS e"
		. "\n WHERE e.uid <= '$session->uid'";
		$result = $database->GetArray($query);
		$numEntries = count($result);

		return $numEntries;
	}

	function removeEntries($ids){
		global $database, $session;

		foreach($ids as $id){
			$id = $database->QMagic($id);

			$query = "DELETE FROM #__entries WHERE id = $id AND uid = '$session->uid'";
			$result = $database->Execute($query);

			if($result){
				$query = "DELETE FROM #__comments WHERE entryid = $id";
				$result = $database->Execute($query);
			}
		}

		return $result;
	}

	function getDayList($date, $offset='', $limit=''){
		global $database, $session, $journalnessConfig_type;

		$date = $database->QMagic($date);

		if($journalnessConfig_type == "postgres"){
			$dateformat = "to_char(e.date, 'YYYY-MM-DD')";
		}else{
			$dateformat = "DATE_FORMAT(e.date,'%Y-%m-%d')";
		}

		$query = "SELECT e.*, u.username AS username, "
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. "\n WHERE e.access <= '$session->useraccess' AND " . $dateformat . " = $date"
		. "\n GROUP BY e.date"
		. "\n ORDER BY e.date DESC"
		. "\n LIMIT $limit OFFSET $offset";
		$entries = $database->GetArray($query);

		$entrycategories = $this->getEntryCategories();

		for($i=0; $i<count($entries); $i++){
			if(isset($entries[$i]['modify_date'])){
				$entries[$i]['modify_date'] = $this->formatDate($entries[$i]['date']);
			}
			$entries[$i]['datesmall'] = $this->formatDate($entries[$i]['date'], 1);
			$entries[$i]['date'] = $this->formatDate($entries[$i]['date']);

			$catlist = explode(",", $entries[$i]['catids']);

			foreach($catlist as $catid){
				if(isset($entrycategories[$catid])){
					$entries[$i]['categories'][] = array("id" => $catid, "name" => $entrycategories[$catid]);
				}
			}
		}

		return $entries;
	}

	function numDayEntries($date){
		global $database, $session, $journalnessConfig_type;

		$date = $database->QMagic($date);

		if($journalnessConfig_type == "postgres"){
			$dateformat = "to_char(e.date, 'YYYY-MM-DD')";
		}else{
			$dateformat = "DATE_FORMAT(e.date,'%Y-%m-%d')";
		}

		$query = "SELECT e.* FROM #__entries AS e"
		. "\n WHERE e.access <= '$session->useraccess' AND " . $dateformat . " = $date";
		$result = $database->GetArray($query);
		$numEntries = count($result);

		return $numEntries;
	}


	function getEntries($username='', $numEntries=''){
		global $database, $session, $lang, $journalnessConfig_newest_entries;

		if(empty($numEntries)){
			$numEntries = $journalnessConfig_newest_entries;
		}
		
		if(empty($username)){
			$query = "SELECT DISTINCT e.*, u.username AS username, u.sig AS signature,"
			. "\n COUNT(c.id) AS numcomments"
			. "\n FROM #__entries AS e"
			. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
			. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
			. "\n WHERE e.access <= '$session->useraccess'"
			. "\n GROUP BY e.date"
			. "\n ORDER BY e.date DESC"
			. "\n LIMIT $numEntries";
		}else{
			$username = str_replace('%20',' ',$database->QMagic($username));
			$query = "SELECT DISTINCT e.*, u.username AS username, u.sig AS signature,"
			. "\n COUNT(c.id) AS numcomments"
			. "\n FROM #__entries AS e"
			. "\n LEFT JOIN #__users AS u ON u.username = $username"
			. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
			. "\n WHERE e.uid = u.id AND e.access <= '$session->useraccess'"
			. "\n GROUP BY e.date"
			. "\n ORDER BY e.date DESC"
			. "\n LIMIT $numEntries";
		}

		$result = $database->GetArray($query);

		$entrycategories = $this->getEntryCategories();

		for($i=0; $i<count($result); $i++){
			$result[$i]['entry_text'] .= $this->appendSignature($result[$i]['signature']);
			$result[$i]['entry_text'] = $this->prepareText($result[$i]['entry_text']);
			$result[$i]['date_notime'] = $this->formatDate($result[$i]['date'], 1);
			$result[$i]['date'] = $this->formatDate($result[$i]['date']);
			if(isset($result[$i]['modify_date'])){
				$result[$i]['modify_date'] = $this->formatDate($result[$i]['modify_date']);
			}
			$catlist = explode(",", $result[$i]['catids']);

			foreach($catlist as $catid){
				if(isset($entrycategories[$catid])){
					$result[$i]['categories'][] = array("id" => $catid, "name" => $entrycategories[$catid]);
				}
			}
		}

		return $result;
	}

	function getEntryCategories(){
		global $database;

		// Get Category Array
		$query = "SELECT * FROM #__entry_categories ORDER BY ordering";
		$result2 = $database->GetArray($query);
		for($i=0; $i<count($result2); $i++){
			$entrycategories[$result2[$i]['id']] = $result2[$i]['name'];
		}

		if(!empty($entrycategories)){
			return $entrycategories;
		}
		return false;
	}

	function prepareText($text) {
		global $journalnessConfig_resize_images;

		$safehtml =& new safehtml();

		$tag_arr = array();
		array_push($tag_arr, '[i]', '<em>', '[/i]', '</em>');
		array_push($tag_arr, '[b]', '<strong>', '[/b]', '</strong>');
		array_push($tag_arr, '[u]', '<span style="text-decoration : underline;">', '[/u]', '</span>');
		array_push($tag_arr, chr(10), '<br/>' . chr(13) );
		for ($i = 0; $i < count($tag_arr ); $i = $i + 2 ) {
			$text = $this->jstr_ireplace($tag_arr[$i], $tag_arr[$i+1], $text);
		}

		// [code]
		$text = preg_replace_callback("#\[code](.*?)\[/code]#si", create_function('$matches','global $lang; return "<div class=\"codetitle\">" . $lang["Code"] . ": </div><div class=\"code\">" . $matches[1] . "</div>";'), $text);

		// [quote]
		$text = preg_replace_callback("#\[quote=(.*?)](.*?)\[/quote]#si", create_function('$matches','global $lang; return "<div class=\"quotetitle\">" . $matches[1] . " " . $lang["Said"] . ": </div><div class=\"quote\">" . $matches[2] . "</div>";'), $text);
		$text = preg_replace_callback("#\[quote](.*?)\[/quote]#si", create_function('$matches','global $lang; return "<div class=\"quotetitle\">" . $lang["Quote"] . ": </div><div class=\"quote\">" . $matches[1] . "</div>";'), $text);

		// [color]
		$text = preg_replace("#\[color=(.*?)](.*?)\[/color]#si", "<span style=\"color: \\1;\">\\2</span>", $text);

		// [size]
		$text = preg_replace("#\[size=([0-9]{1,2})](.*?)\[/size]#si", "<span style=\"font-size: \\1pt;\">\\2</span>", $text);

		// [url]
		$text = preg_replace("#\[url=((www|ftp)\.[^ \"\n\r\t<]*?)\](.*?)\[/url\]#is", "<a href=\"http://\\1\" onclick=\"window.open(this.href); return false;\">\\3</a>", $text );
		$text = preg_replace("#\[url=([\w]+?://[^ \"\n\r\t<]*?)\](.*?)\[/url\]#is", "<a href=\"\\1\" onclick=\"window.open(this.href); return false;\">\\2</a>", $text );
		$text = preg_replace("#\[url\]((www|ftp)\.[^ \"\n\r\t<]*?)\[/url\]#is", "<a href=\"http://\\1\" onclick=\"window.open(this.href); return false;\">\\1</a>", $text );
		$text = preg_replace("#\[url\]([\w]+?://[^ \"\n\r\t<]*?)\[/url\]#is", "<a href=\"\\1\" onclick=\"window.open(this.href); return false;\">\\1</a>", $text );

		// [img]
		if($journalnessConfig_resize_images){
			$text = preg_replace("#\[img](.*?)\[/img]#si", "<a href=\"\\1\"><img src=\"resizeimage.php?file=\\1\" alt=\"User Posted Image\"/></a>", $text);
		}else{
			$text = preg_replace("#\[img](.*?)\[/img]#si", "<img src=\"\\1\" alt=\"User Posted Image\"/>", $text);
		}
		$text = preg_replace("#\[img]((www|ftp)\.[^ \"\n\r\t<]*?)\[/img]#si", "<img src=\"http://\\1\" alt=\"User Posted Image\"/>", $text);

		$text = $safehtml->parse($text);

		return $text;
	}

	function jstr_ireplace($search,$replace,$subject) { 
		if(function_exists('str_ireplace')) return str_ireplace($search,$replace,$subject);
		$srchlen=strlen($search);    // lenght of searched string 
     
		while ($find = stristr($subject,$search)) {    // find $search text in $subject - case insensitiv 
			$srchtxt = substr($find,0,$srchlen);    // get new search text  
			$subject = str_replace($srchtxt,$replace,$subject);    // replace founded case insensitive search text with $replace 
		} 
		return $subject; 
	}

	function prepareTextPreview($text){
		$text = htmlspecialchars($text, ENT_QUOTES);

		return $text;
	}

	function prepareTextInput($text, $allowHTML="0") {
		global $database;

		if(!$allowHTML){
			$text = htmlspecialchars($text, ENT_QUOTES);
		}

		$text = $database->QMagic($text);

		return $text;
	}

	function appendSignature($signature) {
		$result = "";

		if(!empty($signature)){
			$result = "\n\n____________________\n";
			$result .= $signature;
		}

		return $result;
	}

	function formatDate($val, $notime=0) {
		$arr = explode("-", $val);
		$arr2 = explode(":", $val);
		$arr3 = explode(" ", $arr2[0]);
		$arr4 = explode("-", $arr3[0]);

		if($notime){
			return date("m/d/y", mktime(0, 0, 0, $arr[1], $arr4[2], $arr[0]));
		}else{
			return date("l, F j, Y @ g:i a", mktime($arr3[1], $arr2[1], $arr2[2], $arr[1], $arr4[2], $arr[0]));
		}
	}

}

$entry 	= new Entry();

?>
