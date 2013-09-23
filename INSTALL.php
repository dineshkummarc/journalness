<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );
?>

REQUIREMENTS
------------

Journalness has been tested on: Linux and Windows NT/2000.
Apache 				 -> http://www.apache.org
MySQL	 				 -> http://www.mysql.com
PostgreSQL 				 -> http://www.postgresql.org
PHP (version 4.3.0 or better)	 -> http://www.php.net


SERVER CONFIGURATION
--------------------

You MUST ensure that PHP has been compiled with support for MySQL/PostgreSQL and Zlib
in order to successfully run Journalness.

Journalness may run on IIS but has only been tested on Apache.


UPGRADE
------------

1. Copy all the files from the upgrade package to your journalness installation.
2. Manually modify your SQL database by renaming the "default" column to "def" in the 'journalness_entry_categories' table (where 'journalness_ is your table prefix).


INSTALLATION
------------

1. Download Journalness

	Copy the tar.gz/zip file into a working directory e.g.

	$ cp Journalness_x.x.tar.gz /dir/journalness
	or
	$ cp Journalness_x.x.zip /dir/journalness

	Change to the working directory e.g.

	$ cd /dir/journalness

	Extract the files e.g.

	$ tar -zxvf Journalness_x.x.tar.gz
	or
	$ unzip Journalness_x.x.zip

	This will extract all Journalness files and directories.


2. Create the database

	First, you must create a new database for your Journalness installation unless you currently have a working database. ex:

	$ mysqladmin -u db_user -p create Journalness

	MySQL will prompt for the 'db_user' database password and then create
	the initial database files.  Next you must login and set the access
	database rights e.g.

	$ mysql -u db_user -p

	Again, you will be asked for the 'db_user' database password.  At the
	MySQL prompt, enter following command:

	GRANT ALL PRIVILEGES ON Journalness.*
		TO nobody@localhost IDENTIFIED BY 'password';

	where:

	'Journalness' is the name of your database
	'nobody@localhost' is the userid of your webserver MySQL account
	'password' is the password required to log in as the MySQL user

	If successful, MySQL will reply with

	Query OK, 0 rows affected

	to activate the new permissions you must enter the command

	flush privileges;

	and then enter '\q' to exit MySQL.

	Alternatively you can use your web control panel or phpMyAdmin to
	create a database for Journalness.


3. Web Installer

Finally point your web browser to http://www.mysite.com where the Journalness web
installer is located and it will guide you through the rest of the installation
process.


4. Configure Journalness

You can now launch your browser and point it to your Journalness installation e.g.

	http://www.mysite.com -> Main Site
	http://www.mysite.com/administrator -> Admin Panel

You can log into Admin Panel using the administrator username and
password.
