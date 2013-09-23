<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html 
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>{$journalnessConfig_sitename} - Administration</title>
  <link rel="stylesheet" type="text/css" href="templates/{$theme}/style.css"/>
  <link rel="stylesheet" type="text/css" href="includes/js/tabber.css" media="screen"/>

{literal}
<script type="text/javascript">
var tabberOptions = {

  'cookie':"configtabber", /* Name to use for the cookie */

  'onLoad': function(argsObj)
  {
    var t = argsObj.tabber;
    var i;

    /* Optional: Add the id of the tabber to the cookie name to allow
       for multiple tabber interfaces on the site.  If you have
       multiple tabber interfaces (even on different pages) I suggest
       setting a unique id on each one, to avoid having the cookie set
       the wrong tab.
    */
    if (t.id) {
      t.cookie = t.id + t.cookie;
    }

    /* If a cookie was previously set, restore the active tab */
    i = parseInt(getCookie(t.cookie));
    if (isNaN(i)) { return; }
    t.tabShow(i);
  },

  'onClick':function(argsObj)
  {
    var c = argsObj.tabber.cookie;
    var i = argsObj.index;
    setCookie(c, i);
  }
};

/*==================================================
  Cookie functions
  ==================================================*/
function setCookie(name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}
function deleteCookie(name, path, domain) {
    if (getCookie(name)) {
        document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}

</script>
{/literal}

  <script type="text/javascript" src="includes/js/JSCookMenu.js"></script>
  <script type="text/javascript" src="includes/js/tabber.js"></script>
  <link rel="stylesheet" href="includes/js/ThemeOffice/theme.css" type="text/css" />
  <script type="text/javascript" src="includes/js/ThemeOffice/theme.js"></script>
  <script type="text/javascript" src="includes/js/prototype.js"></script>
  <script type="text/javascript" src="includes/js/scriptaculous.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="headerdata"><img src="templates/{$theme}/images/header_administration.png" alt="Journalness Administration" /></div>
	</div>
</div>
