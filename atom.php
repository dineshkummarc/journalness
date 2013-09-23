<?php

require_once( 'common.inc.php' );

if(!$journalnessConfig_atom){
	header("Location: index.php");
}

$entries = $entry->getEntries();
$numentries = $entry->numEntries();

$items_output    = null;
foreach($entries as $entry){
	$link = htmlentities($journalnessConfig_live_site . "/past.php?id=" . $entry[id]);
	$entry['entry_text'] = preg_replace('/(<img src="uploads)/', "<img src=\"" . $journalnessConfig_live_site . "/uploads", $entry['entry_text']);
	$description = $entry['entry_text'];
	
	$published = gmdate('Y-m-d\TH:i:s\Z',strtotime($entry[3]));
	$updated = gmdate('Y-m-d\TH:i:s\Z',strtotime($entry[3]));
	if(!empty($entry['modify_date'])){
		$updated = gmdate('Y-m-d\TH:i:s\Z',strtotime($entry['modify_date']));
	}

	$url = parse_url($journalnessConfig_live_site);
	$url = $url['host'];
	$id = $url . ":postid:" . md5($entry['id'] . $entry['uid']);
        
	$items_output .= <<<EOF
  <entry xmlns="http://www.w3.org/2005/Atom">
    <author>
	<name>{$entry['username']}</name>
    </author>
    <published>{$published}</published>
    <updated>{$updated}</updated>
    <title>{$entry['title']}</title>
    <link href="{$link}" rel="alternate" title="{$entry['title']}" type="text/html"/>
    <id>{$id}</id>
    <content type="xhtml" xml:base="{$journalnessConfig_live_site}" xml:space="preserve">
	<div xmlns="http://www.w3.org/1999/xhtml">{$description}</div>
    </content>
  </entry>

EOF;
}

$updated = gmdate('Y-m-d\TH:i:s\Z',strtotime($entries[0][3]));
$url = parse_url($journalnessConfig_live_site);
$url = $url['host'];
$id = $url . ":feedid:" . md5($journalnessConfig_live_site);

$output = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en-US">
  <title>{$journalnessConfig_sitename}</title>
  <link href="{$journalnessConfig_live_site}/atom.php" rel="self"/>
  <link href="{$journalnessConfig_live_site}" rel="alternate" />
  <updated>{$updated}</updated>
  <id>{$id}</id>
  {$items_output}
</feed>

EOF;

header("Content-type: application/xml; charset=UTF-8");
echo $output;

?>