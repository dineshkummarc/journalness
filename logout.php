<?php

require_once( 'common.inc.php' );

if(!$session->logged_in){
	header("Location: index.php");
}else{
	$session->logout();
	header("Location: index.php");
}

$smarty->display("$theme/logout.tpl");

?>