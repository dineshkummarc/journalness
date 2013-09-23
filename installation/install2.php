<?php
/**
* Installer heavily based off of Joomla! (http://www.joomla.org) Installer
*/

// Include common.php
require_once( 'common.php' );
require_once( '../includes/database/adodb.inc.php' );
require_once( '../includes/database/adodb-errorpear.inc.php' ); 

$DBtype	= getParam( $_POST, 'DBtype', '' );
$DBhostname = getParam( $_POST, 'DBhostname', '' );
$DBuserName = getParam( $_POST, 'DBuserName', '' );
$DBpassword = getParam( $_POST, 'DBpassword', '' );
$DBname  	= getParam( $_POST, 'DBname', '' );
$DBPrefix  	= getParam( $_POST, 'DBPrefix', '' );
$DBDel  	= intval( getParam( $_POST, 'DBDel', 0 ) );
$DBBackup  	= intval( getParam( $_POST, 'DBBackup', 0 ) );
$DBcreated	= intval( getParam( $_POST, 'DBcreated', 0 ) );
$BUPrefix 	= 'journalness_old_';
$BUSPrefix 	= $BUPrefix;
$configArray['sitename'] = trim( getParam( $_POST, 'sitename', '' ) );

$database = null;

$errors = array();
if (!$DBcreated){
	if (!$DBhostname || !$DBuserName || !$DBname) {
		db_err ('stepBack3','The database details provided are incorrect and/or empty.');
	}

	if($DBPrefix == '') {
		db_err ('stepBack','You have not entered a database prefix.');
	}
	
	$database = ADONewConnection($DBtype);
	$database->createdatabase = true ;
	$result = $database->Connect("$DBhostname", "$DBuserName", "$DBpassword", "$DBname");
	if(!$result)
	{
    		db_err ('stepBack2','A database error occurred.');
	}

	if ($DBBackup){
		$DBDel = "1";
	}

	// delete existing tables if requested
	if ($DBDel) {
		if($DBtype == "mysql"){
			$query = "SHOW TABLES FROM `$DBname`";
		}elseif($DBtype == "postgres"){
			$query = "SELECT relname FROM pg_class"
			. "\n WHERE relname NOT LIKE 'pg_%' AND"
			. "\n relname NOT LIKE 'sql_%' AND relkind='r'";
		}
		$errors = array();

		if ($tables = $database->GetArray($query)) {
			foreach ($tables as $table) {
				$table = $table[0];
				if (strpos( $table, $DBPrefix ) === 0) {
					if ($DBBackup) {
						$butable = str_replace( $DBPrefix, $BUPrefix, $table );
						if($DBtype == "mysql"){
							$query = "DROP TABLE IF EXISTS `$butable`";
						}elseif($DBtype == "postgres"){
							$query = "DROP TABLE $butable";
						}
						$database->Execute( $query );
						if ($database->ErrorNo()) {
							$errors[htmlspecialchars($database->sql)] = $database->ErrorMsg();
						}

						if($DBtype == "mysql"){
							$query = "RENAME TABLE `$table`TO `$butable`";
						}elseif($DBtype == "postgres"){
							$query = "ALTER TABLE $table RENAME TO $butable";
						}
						$database->Execute( $query );
						if ($database->ErrorNo()) {
							$errors[htmlspecialchars($database->sql)] = $database->ErrorMsg();
						}


						if($DBtype == "postgres"){
							$query = "SELECT relname FROM pg_class"
							. "\n WHERE relname NOT LIKE 'pg_%' AND"
							. "\n relname NOT LIKE 'sql_%' AND relkind='S'";
						}

						if ($sequences = $database->GetArray($query)) {
							foreach ($sequences as $sequence) {
								$sequence = $sequence[0];
								if ($DBBackup) {
									$busequence = str_replace( $DBPrefix, $BUSPrefix, $sequence );

									$query = "ALTER TABLE $sequence RENAME TO $busequence";
									$database->Execute( $query );
									if ($database->ErrorNo()) {
										$errors[htmlspecialchars($database->sql)] = $database->ErrorMsg();
									}
								}
								/* Doesn't seem to work at all */
								$query = "DROP SEQUENCE $sequence";
								$database->Execute( $query );
								if ($database->ErrorNo()) {
									$errors[htmlspecialchars($database->sql)] = $database->ErrorMsg();
								}
							}
						}
					}

					if($DBtype == "mysql"){
						$query = "DROP TABLE IF EXISTS `$table`";
					}elseif($DBtype == "postgres"){
						$query = "DROP TABLE $table";
					}
					$database->Execute( $query );
					if ($database->ErrorNo()) {
						$errors[htmlspecialchars($database->sql)] = $database->ErrorMsg();
					}
				}
			}
		}

	}

	if($DBtype == "mysql"){
		populate_db( $database, 'journalness_mysql.sql' );
	}elseif($DBtype == "postgres"){
		populate_db( $database, 'journalness_postgres.sql' );
	}

	$DBcreated = 1;
}

function db_err($step, $alert) {
	global $DBhostname,$DBuserName,$DBpassword,$DBDel,$DBname;
	echo "<form name=\"$step\" method=\"post\" action=\"install1.php\">
	<input type=\"hidden\" name=\"DBtype\" value=\"$DBtype\">
	<input type=\"hidden\" name=\"DBhostname\" value=\"$DBhostname\">
	<input type=\"hidden\" name=\"DBuserName\" value=\"$DBuserName\">
	<input type=\"hidden\" name=\"DBpassword\" value=\"$DBpassword\">
	<input type=\"hidden\" name=\"DBDel\" value=\"$DBDel\">
	<input type=\"hidden\" name=\"DBname\" value=\"$DBname\">
	</form>\n";
	//echo "<script>alert(\"$alert\"); window.history.go(-1);</script>";
	echo "<script>alert(\"$alert\"); document.location.href='install1.php';</script>";  
	exit();
}

/**
 * @param object
 * @param string File name
 */
function populate_db( &$database, $sqlfile='journalness_mysql.sql') {
	global $errors, $DBPrefix;

	$mqr = @get_magic_quotes_runtime();
	@set_magic_quotes_runtime(0);
	$query = fread( fopen( 'sql/' . $sqlfile, 'r' ), filesize( 'sql/' . $sqlfile ) );
	@set_magic_quotes_runtime($mqr);

	$pieces  = split_sql($query);

	for ($i=0; $i<count($pieces); $i++) {
		$pieces[$i] = trim($pieces[$i]);
		if(!empty($pieces[$i]) && $pieces[$i] != "#") {
			$result = $database->Execute( $pieces[$i]);
			if (!$result) {
				$errors[] = array ( $database->ErrorMsg(), $pieces[$i] );
			}
		}
	}

}

/**
 * @param string
 */
function split_sql($sql) {
	$sql = trim($sql);
	$sql = ereg_replace("\n#[^\n]*\n", "\n", $sql);

	$buffer = array();
	$ret = array();
	$in_string = false;

	for($i=0; $i<strlen($sql)-1; $i++) {
		if($sql[$i] == ";" && !$in_string) {
			$ret[] = substr($sql, 0, $i);
			$sql = substr($sql, $i + 1);
			$i = 0;
		}

		if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
			$in_string = false;
		}
		elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
			$in_string = $sql[$i];
		}
		if(isset($buffer[1])) {
			$buffer[0] = $buffer[1];
		}
		$buffer[1] = $sql[$i];
	}

	if(!empty($sql)) {
		$ret[] = $sql;
	}
	return($ret);
}

$isErr = intval( count( $errors ) );

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Journalness Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../images/favicon.ico" />
<link rel="stylesheet" href="install.css" type="text/css" />
<script type="text/javascript">
<!--
function check() {
	// form validation check
	var formValid = true;
	var f = document.form;
	if ( f.sitename.value == '' ) {
		alert('Please enter a Site Name');
		f.sitename.focus();
		formValid = false
	}
	return formValid;
}
//-->
</script>
</head>
<body onload="document.form.sitename.focus();">
<div id="wrapper">
	<div id="header">
		Journalness Installer
	</div>
</div>

<div id="ctr" align="center">
	<form action="install3.php" method="post" name="form" id="form" onsubmit="return check();">
	<input type="hidden" name="DBtype" value="<?php echo "$DBtype"; ?>" />
	<input type="hidden" name="DBhostname" value="<?php echo "$DBhostname"; ?>" />
	<input type="hidden" name="DBuserName" value="<?php echo "$DBuserName"; ?>" />
	<input type="hidden" name="DBpassword" value="<?php echo "$DBpassword"; ?>" />
	<input type="hidden" name="DBname" value="<?php echo "$DBname"; ?>" />
	<input type="hidden" name="DBPrefix" value="<?php echo "$DBPrefix"; ?>" />
	<input type="hidden" name="DBcreated" value="<?php echo "$DBcreated"; ?>" />
	<div class="install">
		<div id="stepbar">
		  	<div class="step-off">pre-installation check</div>
	  		<div class="step-off">license</div>
		  	<div class="step-off">step 1</div>
		  	<div class="step-on">step 2</div>
	  		<div class="step-off">step 3</div>
		  	<div class="step-off">step 4</div>
		</div>
		<div id="right">
  			<div class="far-right">
<?php if (!$isErr) { ?>
  		  		<input class="button" type="submit" name="next" value="Next >>"/>
<?php } ?>
  			</div>
	  		<div id="step">step 2</div>
  			<div class="clr"></div>

  			<h1>Enter the name of your Journalness installation:</h1>
			<div class="install-text">
<?php if ($isErr) { ?>
			Looks like there have been some errors with inserting data into your database!<br />
  			You cannot continue.
<?php } else { ?>
			SUCCESS!
			<br/>
			<br/>
  			Type in the name for your Journalness site. This
			name is used in email messages so make it something meaningful.
<?php } ?>
  		</div>
  		<div class="install-form">
  			<div class="form-block">
  				<table class="content2">
<?php
			if ($isErr) {
				echo '<tr><td colspan="2">';
				echo '<b></b>';
				echo "<br/><br />Error log:<br />\n";
				// abrupt failure
				echo '<textarea rows="10" cols="50">';
				foreach($errors as $error) {
					echo "SQL=$error[0]:\n- - - - - - - - - -\n$error[1]\n= = = = = = = = = =\n\n";
				}
				echo '</textarea>';
				echo "</td></tr>\n";
  			} else {
?>
  				<tr>
  					<td width="100">Journal name</td>
  					<td align="center"><input class="inputbox" type="text" name="sitename" size="50" value="<?php echo "{$configArray['sitename']}"; ?>" /></td>
  				</tr>
  				<tr>
  					<td width="100">&nbsp;</td>
  					<td align="center" class="small">e.g. My Web Journal</td>
  				</tr>
  				</table>
<?php
  			} // if
?>
  			</div>
  		</div>
  		<div class="clr"></div>
  		<div id="break"></div>
	</div>
	<div class="clr"></div>
	</form>
</div>
<div class="clr"></div>
</div>
</body>
</html>