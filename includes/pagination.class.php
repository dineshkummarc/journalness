<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

/*
** Modifed from the Joomla (http://www.joomla.org) mosPagNav class
*/

class Pagination {
	var $limit = null;
	var $offset = null;
	var $records = null;

	function Pagination( $records, $offset, $limit ){
		$this->records = intval($records);
		$this->offset = max( $offset, 0 );
		$this->limit = max ( $limit, 0 );
	}

	/**
	* Writes the html for the pages counter, eg, Results 1-10 of x
	*/
	function getPageCounter() {
		global $lang;

		$txt = '<span class="pagination">';
		$from_result = $this->offset+1;
		if ($this->offset + $this->limit < $this->records) {
			$to_result = $this->offset + $this->limit;
		} else {
			$to_result = $this->records;
		}
		if ($this->records > 0) {
			$txt .= $lang['P_Results'] ." $from_result - $to_result ".$lang['P_Of']." $this->records";
		}
		$txt .= "</span>";
		return $txt;
	}

	/**
	* Gets the html links for pages, eg, previous, next, 1 2 3 ... x
	* @param string The basic link to include in the href
	*/
	function getPageLinks( $link ) {
		global $lang;

		$txt = '';

		$displayed_pages = 10;
		$records_pages = ceil( $this->records / $this->limit );
		$this_page = ceil( ($this->offset+1) / $this->limit );
		$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
		if ($start_loop + $displayed_pages - 1 < $records_pages) {
			$stop_loop = $start_loop + $displayed_pages - 1;
		} else {
			$stop_loop = $records_pages;
		}

		$link .= '&amp;limit='. $this->limit;

        if ($lang['P_LT'] || $lang['P_GT']) $pnSpace = " ";

		if ($this_page > 1) {
			$page = ($this_page - 2) * $this->limit;
			$txt .= '<a href="' . $link . '&amp;offset=0" class="pagination" title="'. $lang['P_Start'] .'">'. $lang['P_LT'] . $lang['P_LT'] . $pnSpace . $lang['P_Start'] .'</a> ';
			$txt .= '<a href="' . $link . '&amp;offset=' . $page . '" class="pagination" title="'. $lang['P_Previous'] .'">'. $lang['P_LT'] . $pnSpace . $lang['P_Previous'] .'</a> ';
		} else {
			$txt .= '<span class="pagination">'. $lang['P_LT'] . $lang['P_LT'] . $pnSpace . $lang['P_Start'] .'</span> ';
			$txt .= '<span class="pagination">'. $lang['P_LT'] . $pnSpace . $lang['P_Previous'] .'</span> ';
		}

		for ($i=$start_loop; $i <= $stop_loop; $i++) {
			$page = ($i - 1) * $this->limit;
			if ($i == $this_page) {
				$txt .= '<span class="pagination">'. $i .'</span> ';
			} else {
				$txt .= '<a href="' . $link . '&amp;offset='. $page .'" class="pagination"><strong>'. $i .'</strong></a> ';
			}
		}

		if ($this_page < $records_pages) {
			$page = $this_page * $this->limit;
			$end_page = ($records_pages-1) * $this->limit;
			$txt .= '<a href="'. $link .'&amp;offset='. $page .' " class="pagination" title="'. $lang['P_Next'] .'">'. $lang['P_Next'] . $pnSpace . $lang['P_GT'] .'</a> ';
			$txt .= '<a href="'. $link .'&amp;offset='. $end_page .' " class="pagination" title="'. $lang['P_End'] .'">'. $lang['P_End'] . $pnSpace . $lang['P_GT'] . $lang['P_GT'] .'</a>';
		} else {
			$txt .= '<span class="pagination">'. $lang['P_Next'] . $pnSpace . $lang['P_GT'] .'</span> ';
			$txt .= '<span class="pagination">'. $lang['P_End'] . $pnSpace . $lang['P_GT'] . $lang['P_GT'] .'</span>';
		}
		return $txt;
	}

}

?>