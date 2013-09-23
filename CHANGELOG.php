<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );
?>

Version 4.1.1
- Fixed adodb-perf-module bug

Version 4.1
- Fixed profile bug
- Fixed mysql reserved word for default category
- Fixed unable to retrieve lost password on private bug
- Fixed bug in 3 column template rightnav.tpl
- Reversed order of comments to be oldest first
- Added dynamic title bar
- Added feeds icons and moved feeds to bottom of nav

Version 4.0.2
- Added RSS/ATOM Feeds for newest entries and individual entries
- Updated all templates with links to RSS/Atom Feeds
- Added Enable/Disable function for RSS/Atom Feeds in Journal Configuration
- Updated Smarty

Version 4.0.1
- Fixed compatibility problem with some versions of PHP5
- Found and fixed bug that caused users to be logged out after running a search by user
- Upgraded to the latest version of ADODB lite
- A Few other minor fixes and upgrades.

Version 4.0.0
- Codebase completely re-written with a more object oriented approach.
- Administrator panel moved to administrator/ subdirectory and separated from main site
- Administrator panel features customizable theme.
- New features in the admin panel include more Journal customization options, image manager, template and language manager with web installers, advanced link, category and user managers.
- Entry categories added to allow better grouping of entries.
- Recent entries list
- Calendar with linked days corresponding to entries for that day.
- Users list can be turned on or off.
- Hit counter
- Advanced search with ability to search by keywords or user, search in title, entry or comments, in categories, by date range, sort by title, user, entry date and to show a small preview of each result.
- Many security enhancements including Protection against XSS (Cross-site scripting) and SQL Injection.
- Database abstraction layer is ADOdb lite (http://adodblite.sourceforge.net)
- Mass entry deletion for each user and by all entries in the admin panel.
- User image manager.
- More BBCode added (Code, Quote, Color and Size)
- Age field changed to Date of Birth
- Pictures can be resized on the fly if php is compiled with GD library.
- User access levels added for links and entries (Public, Registered, Admin) which restricts access based on level.
- Many more new features, security enhancements and changes.

Version 3.5.4
-Fixed a couple of bugs in Spanish language pack
-Added some helpful info about links on the admin link page
-Added "Support this project" icon and link to admin panel
-Note that a bug that caused image uploads with capital letters in the file
extension was fixed in a version after 3.5.0. It is fixed in this version as
well
-Added Journalness version display in admin panel statistics
-Fixed the css tag on the quick search label in header.tpl

Version 3.5.3
-Really fixed the age bug for new registers and for admin update

Version 3.5.2
-Fixed age bug
-Fixed template submit bug
-Added 'view all entries" to bottom of index

Version 3.5.1
-Fixed a bug that broke new users when admin added them
-Fixed bug in all of the default templates

Version 3.5.0
-Added a Spanish Language Pack *Thanks to Jose Garcia (blackflint)*
-Cleaned up and made all css tags consistent from one file for easy tweaking
-Added a theming system. Includes a number of themes to choose from
-Admin option for allowing/dissallowing anonymous comments
-Removed the footer completely
-Fixed other small bugs

Version 3.4.3
-Added My Controls panel for users
-Added clipboard for users
-Added signatures for users
-Fixed bug with Age in profile
-Fixed number of posts can be displayed as more than 9
-Fixed bug with admin username change
-Fixed upgrader to preserve current settings

Version 3.4.2
-Fixed admin change username without problems
-Linked website in profile
-Fixed blank page when view profile of invalid user
-Fixed length of email field
-Fixed slashes in preview

Version 3.4.1
-Open admin-added links to new window
-Users and admin can no longer create usernames with '<>#&' characaters
-My posts link now works with users who have spaces in their name
-Other minor fixes

Version 3.4.0
-Update feature added to installer script
-PHP5 Compatible
-Added support for the PostgreSQL Database (www.postgresql.org).
-Created user profiles with the ability for users to put information about
themselves such as Real name, ICQ, MSN, AIM, YIM, Website, etc. This also
allows others to view it and you can change it at will.
-Email validation: The admin can choose to make the users validate their
account via email before they are allowed to log in.
-Multilingual Support added. All that needs to be done is someone needs to
translate the english language file. Once translated all you need to do is
place the language file in its own lang_language folder and journalness will
automatically detect it.
-Each user can choose different languages for the board to be displayed in,
the languages must be installed first.
-Uploaded images can be stored inside the database or in files, the admin can
change this in the journal configuration.
-You can preview entries before you post them. This works with modifying
entries too.
-Optimized and cleaned code.
-New Auth system (PEAR Auth). Doesnt require that you have the pear package
installed.
-Added Database abstraction layer (PEAR DB).
-Admin can add links to the navigation bar on the left hand side of the
screen.
-User administration has been totally re-tooled
-New journal configuration.
-Other bug fixes and much more.


Version 3.3.2
-Fixed browser title to display journal title
-Fixed picture upload bug

Version 3.3.1
-User CP added for password changes
-Fixed problems with slashes in Title

Version 3.3.0
-Template engine switched to Smarty (http://smarty.php.net)
-Default theme and source code is XHTML 1.0 Strict (www.w3.org)
-Registered users can upload and post images to their entries.
-Users and Guests can posts comments to any open entry.
-Web installer created from Scratch.
-Various bug fixes, visual errors and more.

Version 3.2.0
-Interface redone for a cleaner look
-Entire source code rebuilt and Template engine installed (PatTemplate)
-Ability for a themeable interface
-Admin Panel Redone
-Backup is now more secure and easier to use
-Ability to change Journal Type and Title on the fly
-Fixed minor errors and optimized the source code
(Thanks to Todd West)

Version 3.1.0
-Added tags for bold, underline and italics [B][U][I] and images [IMG] and site links [URL]

Version 3.0.9b
-Fixed issue with post editing involving usernames with spaces in them

Version 3.0.9a
-Fixed the backup script
-Fixed php errors in links pages
-Fixed page links in search script
-Fixed compatibility with older versions of PHP

Version 3.0.9
-Fixed title.php to show newest whatever number of posts you choose, on the front page
-Fixed problem with logout and cookie removal
-Fixed max length of title in posts
-Fixed error caused when using Apostrophes in the title
-Moved some things around to make stuff neater
-Fixed admin panel so when you change a users name, their posts owner changes to, that way they can continue to edit their pages
-Fixed a flaw that allowed someone to register a username that contained html code that could be a potential security risk
-Added page system for when the are too many posts for one page


Version 3.0.8
-Fixed vulnerability where invalid users could create/edit posts
-Fixed links table to work with search bar
-Fixed parsing of HTML Tags
-Fixed various problems with the editing of posts
-Added ability for a private or public journal
-Fixed some form space sizes
-Fixed password changing to nothing when the admin only changes the username

Version 3.0.7
-Added ability to search through posts
-Moved Styles and links to include files
-Fixed bugs in config script

Version 3.0.5
-Fixed issue with register_globals
-Fixed config script

Version 3.0.4
-Switched from md5 to sha1 for password authentication
-Added ability for admin to change and delete usernames and passwords

Version 3.0.3
-Fixed wrapping for posting, editing and displaying entries

Version 3.0.2
-Fixed error in mysql table generation in config.sh

Version 3.0.1
-Fixed login error pages

Version 3.0.0
-Whole new layout
-Other various fixes

Version 2.1.4
-Fixed admin login creation script

Version 2.1.2
-Minor cosmetic fixes

Version 2.1.1
-Added newest entry to front page
-Removed logo setting in config script
-Changed the layout of the posts
-Changed some font settings
-Alligned and formatted pages that were previously not
-Created an admin panel for registering users

Version 2.1
-Ability to Log in Integrated
-Must be logged in to post
-Ability to see who posted a message, records username.
-Can only edit/delete your own posts unless Admin
-Various Cosmetic Issues

Version 1.13-r1
-Fixed bug when a post contained certain characters causing borked display.
-Fixed ability to post titleless posts

Version 1.13
-Fixed text wrapping
-Added ability to delete and modify past post

Version 1.12-r1
-Fixed line breaks in entry submissions

Version 1.12
-Set past entries to sort by newest entry
-Set alternating colors to past entry table

Version 1.11
-Added configuration/installation script
-Added compatibility with newer versions of PHP
-Minor Bug fixes
