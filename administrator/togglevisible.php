<?php

require_once( 'common.admin.inc.php' );

if(isset($_POST['toggle_visible_cat'])){

	$id = $_POST['toggle_visible_cat'];
	$visible = $_POST['visible'];

	if($visible == "1"){
		$visible = "0";
	}else{
		$visible = "1";
	}

	$query = "UPDATE #__categories SET visible = '" . $visible . "' WHERE id = '" . $id . "'";
	$database->Execute($query);

}elseif(isset($_POST['toggle_visible_link'])){

	$id = $_POST['toggle_visible_link'];
	$visible = $_POST['visible'];

	if($visible == "1"){
		$visible = "0";
	}else{
		$visible = "1";
	}

	$query = "UPDATE #__links SET visible = '" . $visible . "' WHERE id = '" . $id . "'";
	$database->Execute($query);

}

?>