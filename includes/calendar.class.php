<?php

/*
** Modified from PHP Calendar (version 2.3),  written by Keith Devens
** http://keithdevens.com/software/php_calendar
** License: http://keithdevens.com/software/license
*/

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Calendar
{

	function Calendar(){

	}

	function getCalendar($vars){
		global $database, $session;

		$time = time();
		$today = date('j',$time);

		if(isset($vars['y'])){
			$year = date("y", $time);
			if ( strpos( $vars[ 'y' ], array( '/', '.', '\\', '%' ) ) === false && strlen( $vars[ 'y' ] ) == 2 ) {
				$year = $vars[ 'y' ];
			}
		}else{
			$year = date("y", $time);
		}
		if(isset($vars['m'])){
			$month = date("m", $time);
			if ( strpos( $vars[ 'm' ], array( '/', '.', '\\', '%' ) ) === false && strlen( $vars[ 'm' ] ) == 2 ) {
				$month = $vars[ 'm' ];
			}
		}else{
			$month = date("m", $time);
		}

		$cal_date = "&y=" . $year . "&m=" . $month;

		// Rebuild Query String
		$query_str = NULL;
		if(strlen($_SERVER['QUERY_STRING'])){
			$parts = explode("&", $_SERVER['QUERY_STRING']);
			foreach($parts as $part){
				$key = explode("=", $part);
				if($key[0] != "y" && $key[0] != "Y" && $key[0] != "m" && $key[0] != "M"){
					$query_str .= $part . "&";
				}
			}
		}
		$_SERVER['QUERY_STRING'] = $query_str;

		$prev_month = "?" . $_SERVER['QUERY_STRING'];
		$prev_month .= 'y=' . ($month-1 == 0 ? str_pad($year-1, 2, "0", STR_PAD_LEFT) : $year) . '&m=' . ($month-1 == 0 ? 12 : str_pad($month-1, 2, "0", STR_PAD_LEFT));
		$next_month = NULL;
		if($month != date("m", $time)){
			$next_month .= "?" . $_SERVER['QUERY_STRING'];
			$next_month .= 'y=' . ($month+1 == 13 ? str_pad($year+1, 2, "0", STR_PAD_LEFT) : $year) . '&m=' . ($month+1 == 13 ? "01" : str_pad($month+1, 2, "0", STR_PAD_LEFT));
		}

		$prev_next = array('&laquo;'=>$prev_month, '&raquo;'=>$next_month);

		$date = str_pad($year, 4, "20", STR_PAD_LEFT);
		$dateyear = $date;
		$date = $date . $month;
		$query = "SELECT * FROM #__entries WHERE EXTRACT(YEAR FROM date)='" . $dateyear . "' AND EXTRACT(MONTH FROM date)='" . $month . "' AND access <= '$session->useraccess' ORDER BY date";
		$month_data = $database->GetArray($query);
		$days = array();
		foreach($month_data as $day){
			$arr = explode("-", $day['date']);
			$arr2 = explode(":", $date['date']);
			$arr3 = explode(" ", $arr2[0]);

			$day_value = date("j", mktime(0, 0, 0, $arr[1], $arr[2], $arr[0]));

			$days[$day_value] = array('past.php?year=' . $year . '&month=' . $month. '&day=' . $day_value . $cal_date, 'entry_day');
		}

		if(isset($days[$today])){
			array_push($days[$day_value], '<span style="font-weight: bold;">'.$today.'</span>');
		}elseif($month == date("m", $time)){
			$days[$today] = array(NULL, NULL, '<span style="font-weight: bold;">'.$today.'</span>');
		}

		return $this->generateCalendar($year, $month, $days, 3, NULL, 0, $prev_next);

	}

	function generateCalendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){
		$first_of_month = gmmktime(0,0,0,$month,1,$year);

		$day_names = array(); #generate all the day names according to the current locale
		for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400){
			$day_names[$n] = ucfirst(gmstrftime('%A',$t));
		}

		list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
		$weekday = ($weekday + 7 - $first_day) % 7;
		$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;

		@list($p, $pl) = each($pn); @list($n, $nl) = each($pn); 
		if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';
		if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';

		$calendar = '<table class="calendar">'."\n".
		'<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

		if($day_name_length){
			foreach($day_names as $d)
				$calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
			$calendar .= "</tr>\n<tr>";
		}

		if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>';

		for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
			if($weekday == 7){
				$weekday   = 0;
				$calendar .= "</tr>\n<tr>";
			}
			if(isset($days[$day]) and is_array($days[$day])){
				@list($link, $classes, $content) = $days[$day];
				if(is_null($content))  $content  = $day;

				$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
				($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
			}else{
				$calendar .= "<td>$day</td>";
			}
		}

		if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>';

		return $calendar."</tr>\n</table>\n";
	}

};


$calendar = new Calendar;

?>
