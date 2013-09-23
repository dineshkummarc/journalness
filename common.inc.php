<?php

// Parent File
define( '_VALID_JOURNALNESS', 1 );

// Handle installations with magic quotes enabled
fix_magic_quotes();

// Checks for configuration file, if none found loads installation page
if (!file_exists( dirname(__FILE__) . '/config.php' ) || filesize( dirname(__FILE__) . '/config.php' ) < 10) {
	$self = str_replace( '/' . basename($_SERVER['PHP_SELF']) . '','', strtolower( $_SERVER['PHP_SELF'] ) ). '/';
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $self . "installation/index.php" );
	exit();
}

// If installation folder exists, request that user removes it
if (file_exists( dirname(__FILE__) . '/installation')) {
	echo "Please remove Installation/ Directory";
	exit();
}


// Load all required files
require_once( dirname(__FILE__) . '/config.php' );
require_once( $journalnessConfig_absolute_path . '/includes/version.php' );
require_once( $journalnessConfig_absolute_path . '/includes/journalness.php' );

// Set language and theme data
if(!$session->logged_in){
	$language = $journalnessConfig_def_language;
	$theme = $journalnessConfig_def_theme;
}else{
	if($journalnessConfig_override_user_language){
		$language = $journalnessConfig_def_language;
	}else{
		$language = $session->userlanguage;
	}

	if($journalnessConfig_override_user_theme){
		$theme = $journalnessConfig_def_theme;
	}else{
		$theme = $session->usertheme;
	}
}

// Load Language File
require_once( $journalnessConfig_absolute_path . '/language/lang_' . $language . '/lang_' . $language . '.php' );

// Start new template
$smarty = new Smarty;


// Assign variables required across all templates
$smarty->assign(array(
	"theme" => $theme,
	"session_username" => $session->username,
	"session_useraccess" => $session->useraccess,
	"session_uid" => $session->uid,
	"session_is_admin" => $session->is_admin,
	"session_logged_in" => $session->logged_in,
	"journalnessConfig_sitename" => $journalnessConfig_sitename,
	"journalnessConfig_live_site" => $journalnessConfig_live_site,
	"journalnessConfig_journaltype" => $journalnessConfig_journaltype,
	"journalnessConfig_post_level" => $journalnessConfig_post_level,
	"journalnessConfig_next_prev" => $journalnessConfig_next_prev,
	"journalnessConfig_show_user_sidebar" => $journalnessConfig_show_user_sidebar,
	"journalnessConfig_show_hit_count" => $journalnessConfig_show_hit_count,
	"journalnessConfig_show_recent_entries_sidebar" => $journalnessConfig_show_recent_entries_sidebar,
	"journalnessconfig_num_recent_entries_sidebar" => $journalnessConfig_num_recent_entries_sidebar,
	"journalnessConfig_show_calendar" => $journalnessConfig_show_calendar,
	"journalnessConfig_rss" => $journalnessConfig_rss,
	"journalnessConfig_atom" => $journalnessConfig_atom,
	"L_POWERED_BY" => sprintf($lang['Powered_by'], "<a href=\"http://journalness.sourceforge.net\" onclick=\"window.open(this.href); return false;\">", "</a>", $version),
	"L_QUICK_SEARCH" => $lang['Quick_search'],
	"L_SEARCH" => $lang['Search'],
	"L_ADVANCED_SEARCH" => $lang['Advanced_search'],
	"L_JOURNAL_LINKS" => $lang['Journal_links'],
	"L_LOGIN" => $lang['Login'],
	"L_LOGOUT" => sprintf($lang['Logout'], "$session->username"),
	"L_HOME" => $lang['Home'],
	"L_ALL_ENTRIES" => $lang['All_entries'],
	"L_MY_ENTRIES" => $lang['My_entries'],
	"L_CREATE_ENTRY" => $lang['Create_entry'],
	"L_MY_PROFILE" => $lang['My_profile'],
	"L_MY_CLIP" => $lang['My_clip'],
	"L_MY_PANEL" => $lang['My_panel'],
	"L_MASS_ENTRY_DELETE" => $lang['Mass_entry_deletion'],
	"L_IMAGE_MANAGER" => $lang['Image_manager'],
	"L_ADMIN_PANEL" => $lang['Admin_panel'],
	"L_REGISTER" => $lang['Register'],
	"L_USER_PANEL_LINKS" => $lang['My_panel'],
	"L_EDIT_SIG"=> $lang['Edit_sig'],
	"L_BLOGGERS" => $lang['Bloggers'],
	"L_FEEDS" => $lang['Feeds'],
	"L_RSS" => $lang['RSS'],
	"L_ATOM" => $lang['ATOM'])
);

// If journal is offline, display and exit
if($journalnessConfig_offline){
	$smarty->assign(array(
		"L_JOURNAL_OFFLINE" => $lang['Journal_offline'],
		"journalnessConfig_offline_msg" => nl2br($journalnessConfig_offline_msg))
	);
	$smarty->display("$theme/offline.tpl");
	exit;
}

$filename = basename($_SERVER['SCRIPT_NAME']);

// If journal is set to private and user is not logged in
if($journalnessConfig_journaltype == "2" && !$session->logged_in && $filename != "login.php" && $filename != "forgotpassword.php"){
	header( 'Location: login.php' );
	exit;
}

if($journalnessConfig_show_user_sidebar){
	// Get user list and display it
	$bloggers = $users->getUserList();
	$smarty->assign('bloggers', $bloggers);
}

// Get categories/links and display them
$links_list = $categories->getCategories();
$smarty->assign('links_list', $links_list);

if($journalnessConfig_show_recent_entries_sidebar){
	$sidebar_entries = $entry->getEntries('', $journalnessConfig_num_recent_entries_sidebar);

	$smarty->assign(array(
		'sidebar_entries' => $sidebar_entries,
		"L_RECENT_ENTRIES" => $lang['Recent_entries'])
	);
}

// Get entry categories and display
$categoryList = $categories->getEntryCategories();

$smarty->assign(array(
	'categorylist' => $categoryList,
	"L_CATEGORIES" => $lang['Categories'])
);

// Generate Calendar
if($journalnessConfig_show_calendar){
	$entryCalendar = $calendar->getCalendar($_GET);

	$smarty->assign(array(
			"L_CALENDAR" => $lang['Calendar'],
			"calendar" => $entryCalendar)
	);
}

if($journalnessConfig_show_hit_count){
	// Update and output hit counter
	$stats->incrementHitCount();
	$hitCount = $stats->getHitCount();
	$smarty->assign(array(
			'L_HIT_COUNT' => $lang['Hit_count'],
			'hit_count' => $hitCount)
	);
}


function fix_magic_quotes ($var = NULL, $sybase = NULL)
{
	// if sybase style quoting isn't specified, use ini setting
	if ( !isset ($sybase) )
	{
		$sybase = ini_get ('magic_quotes_sybase');
	}

	// if no var is specified, fix all affected superglobals
	if ( !isset ($var) )
	{
		// if magic quotes is enabled
		if ( get_magic_quotes_gpc () )
		{
			// workaround because magic_quotes does not change $_SERVER['argv']
			$argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : NULL; 

			// fix all affected arrays
			foreach ( array ('_ENV', '_REQUEST', '_GET', '_POST', '_COOKIE', '_SERVER') as $var )
			{
				$GLOBALS[$var] = fix_magic_quotes ($GLOBALS[$var], $sybase);
			}

			$_SERVER['argv'] = $argv;

			// turn off magic quotes, this is so scripts which
			// are sensitive to the setting will work correctly
			ini_set ('magic_quotes_gpc', 0);
		}

		// disable magic_quotes_sybase
		if ( $sybase )
		{
			ini_set ('magic_quotes_sybase', 0);
		}

		// disable magic_quotes_runtime
		set_magic_quotes_runtime (0);
		return TRUE;
	}

	// if var is an array, fix each element
	if ( is_array ($var) )
	{
		foreach ( $var as $key => $val )
		{
			$var[$key] = fix_magic_quotes ($val, $sybase);
		}

		return $var;
	}

	// if var is a string, strip slashes
	if ( is_string ($var) )
	{
		return $sybase ? str_replace ('\'\'', '\'', $var) : stripslashes ($var);
	}

	// otherwise ignore
	return $var;
}

?>
