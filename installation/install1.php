<?php

/**
* Installer heavily based off of Joomla! (http://www.joomla.org) Installer
*/

/** Include common.php */
require_once( 'common.php' );

$DBtype	= getParam( $_POST, 'DBtype', '' );
$DBhostname = getParam( $_POST, 'DBhostname', '' );
$DBuserName = getParam( $_POST, 'DBuserName', '' );
$DBpassword = getParam( $_POST, 'DBpassword', '' );
$DBname  	= getParam( $_POST, 'DBname', '' );
$DBPrefix  	= getParam( $_POST, 'DBPrefix', 'journalness_' );
$DBDel  	= intval( getParam( $_POST, 'DBDel', 0 ) );
$DBBackup  	= intval( getParam( $_POST, 'DBBackup', 0 ) );

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Journalness Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../images/favicon.ico" />
<link rel="stylesheet" href="install.css" type="text/css" />
<script  type="text/javascript">
<!--
function check() {
	// form validation check
	var formValid=false;
	var f = document.form;
	if ( f.DBhostname.value == '' ) {
		alert('Please enter a Host name');
		f.DBhostname.focus();
		formValid=false;
	} else if ( f.DBuserName.value == '' ) {
		alert('Please enter a Database User Name');
		f.DBuserName.focus();
		formValid=false;
	} else if ( f.DBname.value == '' ) {
		alert('Please enter a Name for your Database');
		f.DBname.focus();
		formValid=false;
	} else if ( f.DBPrefix.value == '' ) {
		alert('You must enter a Table Prefix for Journalness to operate correctly.');
		f.DBPrefix.focus();
		formValid=false;
	} else if ( f.DBPrefix.value == 'old_' ) {
		alert('You cannot use "journalness_old_" as the Table Prefix because Journalness uses this prefix for backup tables.');
		f.DBPrefix.focus();
		formValid=false;
	} else if ( confirm('Are you sure these settings are correct? \nJournalness will now attempt to populate a Database with the settings you have supplied')) {
		formValid=true;
	}

	return formValid;
}
//-->
</script>
</head>
<body onload="document.form.DBhostname.focus();">
<div id="wrapper">
	<div id="header">
		Journalness Installer
	</div>
</div>

<div id="ctr" align="center">
	<form action="install2.php" method="post" name="form" id="form" onsubmit="return check();">
	<div class="install">
		<div id="stepbar">
			<div class="step-off">
				pre-installation check
			</div>
			<div class="step-off">
				license
			</div>
			<div class="step-on">
				step 1
			</div>
			<div class="step-off">
				step 2
			</div>
			<div class="step-off">
				step 3
			</div>
			<div class="step-off">
				step 4
			</div>
		</div>
		<div id="right">
			<div class="far-right">
				<input class="button" type="submit" name="next" value="Next >>"/>
  			</div>
	  		<div id="step">
	  			step 1
	  		</div>
  			<div class="clr"></div>
  			<h1>Database configuration:</h1>
	  		<div class="install-text">
  				<p>Setting up Journalness to run on your server requires 5 basic actions:</p>
				<p>1) Select the type of database you are installing on.</p>
  				<p>2) Enter the hostname of the database server Journalness is to be installed on.</p>
				<p>3) Enter the database username, password and database name you wish to use with Journalness.</p>
				<p>4) Enter the table name prefix to be used by this Journalness install</p>
				<p>6) Decide what to do with the existing tables from former installations.</p>
  			</div>
			<div class="install-form">
  				<div class="form-block">
  		 			<table class="content2">
  		  			<tr>
  						<td></td>
  						<td></td>
  						<td></td>
  					</tr>
  		  			<tr>
  						<td colspan="2">
  							Database Type
  							<br/>
							<select name="DBtype">
								<option value="mysql" selected="selected">MySQL</option>
								<option value="postgres">PostgreSQL</option>
							</select>
  						</td>
			  			<td>
			  				<em>The type of database to be installed on. If you don't know, choose 'MySQL'.</em>
			  			</td>
  					</tr>
  		  			<tr>
  						<td colspan="2">
  							Database Host Name
  							<br/>
  							<input class="inputbox" type="text" name="DBhostname" value="<?php echo "$DBhostname"; ?>" />
  						</td>
			  			<td>
			  				<em>This is usually 'localhost'</em>
			  			</td>
  					</tr>
					<tr>
			  			<td colspan="2">
			  				Database User Name
			  				<br/>
			  				<input class="inputbox" type="text" name="DBuserName" value="<?php echo "$DBuserName"; ?>" />
			  			</td>
			  			<td>
			  				<em>Either something as 'root' or a username given by the host</em>
			  			</td>
  					</tr>
			  		<tr>
			  			<td colspan="2">
			  				Database Password
			  				<br/>
			  				<input class="inputbox" type="text" name="DBpassword" value="<?php echo "$DBpassword"; ?>" />
			  			</td>
			  			<td>
			  				<em>For site security using a password for the database account is mandatory</em>
			  			</td>
					</tr>
  		  			<tr>
  						<td colspan="2">
  							Database Name
  							<br/>
  							<input class="inputbox" type="text" name="DBname" value="<?php echo "$DBname"; ?>" />
  						</td>
			  			<td>
			  				<em>The name of the database to be installed on.</em>
			  			</td>
  					</tr>
  		  			<tr>
  						<td colspan="2">
  							Database Table Prefix
  							<br/>
  							<input class="inputbox" type="text" name="DBPrefix" value="<?php echo "$DBPrefix"; ?>" />
  						</td>
			  			<td>
						<em>Some hosts only allow one database per site. Use a table prefix in this case for multiple Journalness installations.</em>
			  			<!--
			  			<em>Don't use 'journalness_old_' since this is used for backup tables</em>
			  			-->
			  			</td>
  					</tr>
  		  			<tr>
			  			<td>
			  				<input type="checkbox" name="DBDel" id="DBDel" value="1" <?php if ($DBDel) echo 'checked="checked"'; ?> />
			  			</td>
						<td>
							<label for="DBDel">Drop Existing Tables</label>
						</td>
  						<td>
  						</td>
			  		</tr>
  		  			<tr>
			  			<td>
			  				<input type="checkbox" name="DBBackup" id="DBBackup" value="1" <?php if ($DBBackup) echo 'checked="checked"'; ?> />
			  			</td>
						<td>
							<label for="DBBackup">Backup Old Tables</label>
						</td>
  						<td>
  							<em>Any existing backup tables from former Journalness installations will be replaced</em>
  						</td>
			  		</tr>
		  		 	</table>
  				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	</form>
</div>
<div class="clr"></div>
</body>
</html>