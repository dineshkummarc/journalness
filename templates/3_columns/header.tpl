<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html 
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  {if $title}
  <title>{$title} - {$journalnessConfig_sitename}</title>
  {else}
  <title>{$journalnessConfig_sitename}</title>
  {/if}
  <link rel="stylesheet" type="text/css" href="templates/{$theme}/style.css"/>
  <link rel="shortcut icon" href="images/favicon.ico" />
  <script type="text/javascript" src="includes/js/journalness.js"></script>
</head>

<body>
<div class="centered">
<table border="0" cellpadding="0" cellspacing="0" id="maintable">
  <tr>
    <td colspan="3" align="center" id="headertop">
	<h1><a href="index.php">{$journalnessConfig_sitename}</a></h1>
	<p class="headerversion">{$L_POWERED_BY}</p>
    </td>
  </tr>
  <tr>
    <td colspan="3" align="right" id="headerbottom">
	 <form style="margin-bottom:0;" action="search.php" method="post" enctype="multipart/form-data">
	 <p class="headerversion">{$L_QUICK_SEARCH}<input class="textinput" type="text" name="search_text"/>
	 <input class="button" type="submit" name="qsearch" value="{$L_SEARCH}"/></p>
	 </form>
	 <p style="margin-top: 5px; color: #000000; font-size:10px;">[<a href="search.php">{$L_ADVANCED_SEARCH}</a>]</p>
    </td>
  </tr>
