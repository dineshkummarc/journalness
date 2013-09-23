CREATE SEQUENCE #__auth_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__categories_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__comments_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__entries_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__entry_categories_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__links_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__passwordreset_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__sessions_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__uploads_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE SEQUENCE #__users_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;


CREATE TABLE #__auth (
	id int4 DEFAULT nextval('#__auth_id_seq'::text) NOT NULL,
	uid int4 NOT NULL,
	authcode varchar(32),
	CONSTRAINT #__auth_pkey PRIMARY KEY (id)
);

CREATE TABLE #__categories (
	id int4 DEFAULT nextval('#__categories_id_seq'::text) NOT NULL,
	title varchar(255) NOT NULL,
	url varchar(255) NULL,
	ordering int4 NULL,
	visible int2 DEFAULT '1' NOT NULL,
	"access" int4 DEFAULT '0' NOT NULL,
	CONSTRAINT #__categories_pkey PRIMARY KEY (id)
);

INSERT INTO #__categories (title, ordering, visible, access) VALUES ('Links', '1', '1', '0');


CREATE TABLE #__comments (
	id int4 DEFAULT nextval('#__comments_id_seq'::text) NOT NULL,
	entryid int4 NOT NULL,
	title varchar(255) NOT NULL,
	comment_text text NOT NULL,
	date timestamp without time zone NOT NULL,
	uid int4 NOT NULL,
	ip_address varchar(64) NOT NULL,
	CONSTRAINT #__comments_pkey PRIMARY KEY (id)
);


CREATE TABLE #__entries (
	id int4 DEFAULT nextval('#__entries_id_seq'::text) NOT NULL,
	title varchar(255) NOT NULL,
	entry_text text NOT NULL,
	date timestamp without time zone NOT NULL,
	modify_date timestamp without time zone NULL,
	uid int4 NOT NULL,
	"access" int4 DEFAULT '0' NOT NULL,
	views int4 NOT NULL default '0',
	catids varchar(255) NULL,
	ip_address varchar(64) NOT NULL,
	CONSTRAINT #__entries_pkey PRIMARY KEY (id)
);

INSERT INTO #__entries (title, entry_text, date, uid, ip_address) VALUES ('Welcome to Journalness', '[B]Welcome to your own Journal! [/B]

This is just a test entry and your Journal seems to be in working order.

Have fun!', now(), '1', '127.0.0.1');

CREATE TABLE #__entry_categories(
	id int4 DEFAULT nextval('#__entry_categories_id_seq'::text) NOT NULL,
	name varchar(50) NOT NULL,
	description text,
	parent int4 NOT NULL,
	def int2 DEFAULT '0' NULL NULL,
	ordering int4 NOT NULL,
	CONSTRAINT #__entry_categories_pkey PRIMARY KEY (id)
);

INSERT INTO #__entry_categories (name, description, parent, def, ordering) VALUES ('Uncategorized', 'The default category for all entries.', '0', '1', '1');

CREATE TABLE #__links (
	id int4 DEFAULT nextval('#__links_id_seq'::text) NOT NULL,
	title varchar(255) NOT NULL,
	url varchar(255) NULL,
	catid int4 NOT NULL,
	ordering int4 NULL,
	visible int2 DEFAULT '1' NOT NULL,
	"access" int4 DEFAULT '0' NOT NULL,
	CONSTRAINT #__links_pkey PRIMARY KEY (id)
);

INSERT INTO #__links (title, url, catid, ordering, visible, access) VALUES ('Journalness', 'http://journalness.sourceforge.net', '1', '1', '1', '0');

CREATE TABLE #__passwordreset(
	id int4 DEFAULT nextval('#__passwordreset_id_seq'::text) NOT NULL,
	uid int4 NOT NULL,
	resetcode varchar(32) default NULL,
	CONSTRAINT #__passwordreset_pkey PRIMARY KEY (id)
);

CREATE TABLE #__sessions(
	ID int4 DEFAULT nextval('#__sessions_id_seq'::text) NOT NULL,
	SessionID VARCHAR(64) default NULL,
	session_data TEXT,
	expiry int8 default NULL,
	expireref VARCHAR(64) DEFAULT '',
	CONSTRAINT #__sessions_pkey PRIMARY KEY (ID)
);

CREATE TABLE #__stats(
	id int4 NOT NULL,
	name varchar(255) NOT NULL,
	data text NOT NULL,
	CONSTRAINT #__stats_pkey PRIMARY KEY (id)
);

INSERT INTO #__stats (id, name, data) VALUES (1, 'hit_count', '0');

CREATE TABLE #__uploads (
	id int4 DEFAULT nextval('#__uploads_id_seq'::text) NOT NULL,
	image_name varchar(255) NOT NULL,
	image_path varchar(255) NOT NULL,
	image_data text NULL,
	uid int4 NOT NULL,
	CONSTRAINT #__uploads_pkey PRIMARY KEY (id)
);


CREATE TABLE #__users (
	id int4 DEFAULT nextval('#__users_id_seq'::text) NOT NULL,
	username varchar(40) NOT NULL,
	"password" varchar(40) NOT NULL,
	is_admin int2 DEFAULT '0' NOT NULL,
	is_super_admin int2 DEFAULT '0' NOT NULL,
	email varchar(255) NOT NULL,
	email_public int2 DEFAULT '0' NOT NULL,
	verified int2 DEFAULT '0' NOT NULL,
	def_user_lang varchar(255) NOT NULL,
	realname varchar(100),
	dob date NULL,
	sex char(1),
	icq varchar(255),
	aim varchar(255),
	yim varchar(255),
	msn varchar(255),
	website varchar(100),
	"location" varchar(100),
	clip text,
	sig text,
	def_user_theme varchar(255) NOT NULL,
	CONSTRAINT #__users_email_key UNIQUE (email),
	CONSTRAINT #__users_pkey PRIMARY KEY (id)
);
