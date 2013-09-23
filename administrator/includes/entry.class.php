<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

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

	function removeEntries($ids){
		global $database, $adminsession;

		foreach($ids as $id){
			$id = $database->QMagic($id);

			$query = "DELETE FROM #__entries WHERE id = $id AND access <= '$adminsession->useraccess'";
			$result = $database->Execute($query);

			if($result){
				$query = "DELETE FROM #__comments WHERE entryid = $id";
				$result = $database->Execute($query);
			}
		}

		return $result;
	}

	function getEntriesList($offset='', $limit=''){
		global $database, $adminsession;

		if($limit == "0"){
			$limit = "";
		}else{
			$limit = "LIMIT " . $limit;
		}

		$query = "SELECT e.*, u.username AS username, "
		. "\n COUNT(c.id) AS numcomments"
		. "\n FROM #__entries AS e"
		. "\n LEFT JOIN #__users AS u ON u.id = e.uid"
		. "\n LEFT JOIN #__comments AS c ON c.entryid = e.id"
		. "\n WHERE e.access <= '$adminsession->useraccess'"
		. "\n GROUP BY e.date"
		. "\n ORDER BY e.date DESC"
		. "\n $limit"
		. "\n OFFSET $offset";
		$entries = $database->GetArray($query);

		for($i=0; $i<count($entries); $i++){
			if(isset($entries[$i]['modify_date'])){
				$entries[$i]['modify_date'] = $this->formatDate($entries[$i]['date']);
			}
			$entries[$i]['date'] = $this->formatDate($entries[$i]['date']);
			//$entries[$i]['entry_text'] = $this->prepareText($entries[$i]['entry_text']);
			$length = strlen($entries[$i]['entry_text']);
			$entries[$i]['entry_text'] = substr($entries[$i]['entry_text'], 0, 100);
			if($length > 100){
				$entries[$i]['entry_text'] .= "...";
			}
		}

		return $entries;
	}

	function getNumEntriesList(){
		global $database, $adminsession;

		$query = "SELECT e.* FROM #__entries AS e"
		. "\n WHERE e.access <= '$adminsession->useraccess'";
		$result = $database->GetArray($query);
		$numEntries = count($result);

		return $numEntries;
	}

	function prepareText($text) {

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
		$text = preg_replace("#\[img]((www|ftp)\.[^ \"\n\r\t<]*?)\[/img]#si", "<img src=\"http://\\1\" alt=\"User Posted Image\"/>", $text);
		$text = preg_replace("#\[img](.*?)\[/img]#si", "<img src=\"\\1\" alt=\"User Posted Image\"/>", $text);

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

	function formatDate($val, $notime=1) {
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

$entry 	= new Entry();

?>