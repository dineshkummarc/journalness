<?php

require_once( 'common.admin.inc.php' );

if(!$adminsession->logged_in){
	header("Location: login.php");
}else{
	$adminsession->logout();
	header("Location: login.php");
}

?>