<?php

require_once( 'common.admin.inc.php' );

if(isset($_POST['cataccessid'])){

	$id = $_POST['cataccessid'];
	$cataccessvalue = $_POST['cataccessvalue'];

	if($cataccessvalue == "0"){
		$cataccessvalue = "1";
	}elseif($cataccessvalue == "1"){
		$cataccessvalue = "2";
	}else{
		$cataccessvalue = "0";
	}

	$query = "UPDATE #__categories SET access = '" . $cataccessvalue . "' WHERE id = '" . $id . "'";
	$database->Execute($query);

}elseif(isset($_POST['linkaccessid'])){

	$id = $_POST['linkaccessid'];
	$linkaccessvalue = $_POST['linkaccessvalue'];

	if($linkaccessvalue == "0"){
		$linkaccessvalue = "1";
	}elseif($linkaccessvalue == "1"){
		$linkaccessvalue = "2";
	}else{
		$linkaccessvalue = "0";
	}

	$query = "UPDATE #__links SET access = '" . $linkaccessvalue . "' WHERE id = '" . $id . "'";
	$database->Execute($query);

}

?>