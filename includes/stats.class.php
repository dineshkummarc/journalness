<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Stats
{

	function Stats(){

	}

	function incrementHitCount(){
		global $database;
		
		$hit_count = $this->getHitCount();
		$hit_count++;

		$query = "UPDATE #__stats SET data = '$hit_count' WHERE name = 'hit_count'";
		$result = $database->Execute($query);
	}

	function getHitCount(){
		global $database;

		$query = "SELECT data FROM #__stats WHERE name = 'hit_count'";
		$result = $database->GetArray($query);
		$hit_count = intval($result[0]['data']);

		return $hit_count;
	}

	function resetHitCount(){
		global $database;

		$query = "UPDATE #__stats SET data = '0' WHERE name = 'hit_count'";
		$result = $database->Execute($query);

		return $result;
	}
};


$stats = new Stats;

?>