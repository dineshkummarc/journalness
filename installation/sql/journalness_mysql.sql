CREATE TABLE #__auth(
	id int(10) NOT NULL auto_increment,
	uid int(10) NOT NULL,
	authcode VARCHAR(32),
	PRIMARY KEY (id)
);

CREATE TABLE #__categories (
	id int(10) NOT NULL auto_increment,
	title varchar(255) NOT NULL,
	url varchar(255) NULL,
	ordering int(10) NULL,
	visible bool DEFAULT '1' NOT NULL,
	access int(10) DEFAULT '0' NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO #__categories (title, ordering, visible, access) VALUES ('Links', '1', '1', '0');



CREATE TABLE #__comments(
	id int(10) NOT NULL auto_increment,
	entryid int(10) NOT NULL,
	title varchar(255) NOT NULL,
	comment_text text NOT NULL,
	date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	uid int(10) NOT NULL,
	ip_address varchar(64) NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE #__entries(
	id int(10) NOT NULL auto_increment,
	title varchar(255) NOT NULL,
	entry_text TEXT NOT NULL,
	date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	modify_date datetime NULL,
	uid int(10) NOT NULL,
	access int(10) DEFAULT '0' NOT NULL,
	views int(11) NOT NULL default '0',
	catids varchar(255) NULL,
	ip_address varchar(64) NOT NULL, 
	PRIMARY KEY (id)
);

INSERT INTO #__entries (title, entry_text, date, uid, ip_address) VALUES ('Welcome to Journalness', '[B]Welcome to your own Journal! [/B]

This is just a test entry and your Journal seems to be in working order.

Have fun!', now(), '1', '127.0.0.1');

CREATE TABLE #__entry_categories(
	id int(11) NOT NULL auto_increment,
	name varchar(50) NOT NULL,
	description mediumtext,
	parent int(11) NOT NULL,
	def tinyint(1) NOT NULL default '0',
	ordering int(11) NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO #__entry_categories (name, description, parent, def, ordering) VALUES ('Uncategorized', 'The default category for all entries.', 0, 1, 1);

CREATE TABLE #__links(
	id int(10) NOT NULL auto_increment,
	title VARCHAR(255) NOT NULL,
	url VARCHAR(255) NULL,
	catid int(10) NOT NULL,
	ordering int(10) NULL,
	visible bool DEFAULT '1' NOT NULL,
	access bool DEFAULT '0' NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO #__links (title, url, catid, ordering, visible, access) VALUES ('Journalness', 'http://journalness.sourceforge.net', '1', '1', '1', '0');

CREATE TABLE #__passwordreset(
	id int(10) NOT NULL auto_increment,
	uid int(10) NOT NULL,
	resetcode varchar(32) default NULL,
	PRIMARY KEY (id)
);

CREATE TABLE #__sessions(
	ID int(11) NOT NULL auto_increment,
	SessionID VARCHAR(64) default NULL,
	session_data TEXT,
	expiry int(11) default NULL,
	expireref VARCHAR(64) DEFAULT '',
	PRIMARY KEY (ID),
	KEY SessionID (SessionID),
	KEY expiry (expiry)
);

CREATE TABLE #__stats(
	id int(10) NOT NULL,
	name varchar(255) NOT NULL,
	data text NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO #__stats (id, name, data) VALUES (1, 'hit_count', '0');

CREATE TABLE #__uploads(
	id int(10) NOT NULL auto_increment,
	image_name varchar(255) NOT NULL,
	image_path varchar(255) NOT NULL,
	image_data LONGTEXT,
	uid int(10) NOT NULL, 
	PRIMARY KEY (id)
);


CREATE TABLE #__users(
	id int(10) NOT NULL AUTO_INCREMENT,
	username varchar(40) NOT NULL,
	password varchar(40) NOT NULL,
	is_admin bool DEFAULT '0' NOT NULL,
	is_super_admin bool DEFAULT '0' NOT NULL,
	email varchar(255) NOT NULL,
	email_public bool DEFAULT '0' NOT NULL,
	verified bool DEFAULT '0' NOT NULL,
	def_user_lang varchar(255) NOT NULL,
	realname varchar(100),
	dob date NULL,
	sex varchar(1),
	icq varchar(15),
	aim varchar(255),
	yim varchar(255),
	msn varchar(255),
	website varchar(100),
	location varchar(100),
	clip TEXT,
	sig TEXT,
	def_user_theme varchar(255) NOT NULL,
	PRIMARY KEY(id),
	UNIQUE KEY email (email)	
);
