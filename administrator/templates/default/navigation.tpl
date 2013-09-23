{if $adminsession_logged_in}
<script type="text/javascript"><!--
var myMenu =
[
    [null,'Home','index.php',null,'Journal Stats'],
    _cmSplit,
    [null,'Journal',null,null,'Journal Management',
	['<img src="includes/js/ThemeOffice/configuration.png" />','Configuration','configuration.php',null,'Configuration'],
	['<img src="includes/js/ThemeOffice/image_manager.png" />','Image Manager','imagemanager.php',null,'Manage uploaded images'],
	['<img src="includes/js/ThemeOffice/template_manager.png" />','Template Manager','templatemanager.php',null,'Manage Site and Admin templates'],
	['<img src="includes/js/ThemeOffice/language_manager.png" />','Language Manager','languagemanager.php',null,'Manage Site and Admin languages'],
	['<img src="includes/js/ThemeOffice/database_backup.png" />','Database Maintenance','databasemaintenance.php',null,'Optimize and Maintain Database'],
	['<img src="includes/js/ThemeOffice/mass_entry_delete.png" />','Mass Entry Delete','massdelete.php',null,'Select and Remove Mass Amounts of Entries at once'],
    ],
    _cmSplit,
    [null,'Backup',null,null,'Backup Options',
	['<img src="includes/js/ThemeOffice/database_backup.png" />','Database Backup','backup.php?type=database',null,'Backup Journal Database'],
	['<img src="includes/js/ThemeOffice/configuration.png" />','Config Backup','backup.php?type=config',null,'Backup Journal Configuration File'],
    ],
    _cmSplit,
    [null,'Links',null,null,'Link Options',
	['<img src="includes/js/ThemeOffice/category_manager.png" />','Category/Link Manager','categorymanager.php',null,'Manage Links and Link Categories'],
    ],
    _cmSplit,
    [null,'Entry Categories',null,null,'Categories for entries',
	['<img src="includes/js/ThemeOffice/entry_category_manager.png" />','Entry Category Manager','entrycategorymanager.php',null,'Manage Categories for Entries'],
    ],
    _cmSplit,
    [null,'Users',null,null,'User Options',
	['<img src="includes/js/ThemeOffice/user_manager.png" />','User Manager','usermanager.php',null,'Manage Users'],
	['<img src="includes/js/ThemeOffice/add_user.png" />','Add User','usermanager.php?mode=adduser',null,'Add a new User'],
    ],
    _cmSplit,
    [null,'<strong>Logout {$adminsession_username}</strong>','logout.php',null,'Logout {$adminsession_username}'],
];
--></script>

<div id="adminmenu" class="navmenu"></div>

<script type="text/javascript"><!--
cmDraw ('adminmenu', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
--></script>
{/if}