<?php

require_once( 'common.inc.php' );

if(!$journalnessConfig_rss){
	header("Location: index.php");
}

$entries = $entry->getEntries();
$numentries = $entry->numEntries();

$items_output    = null;
foreach($entries as $entry){
	$entry['entry_text'] = preg_replace('/(<img src="uploads)/', "<img src=\"" . $journalnessConfig_live_site . "/uploads", $entry['entry_text']);
	$link = htmlentities($journalnessConfig_live_site . "/past.php?id=" . $entry[id]);
	$comments = htmlentities($journalnessConfig_live_site . "/past.php?id=" . $entry[id] . "#comments");
	$pubdate = gmdate('r', strtotime($entry[3]));
	$author = $entry['username'];
	$description = "<![CDATA[  " . $entry['entry_text'] . " ]]>";
        
	$items_output .= <<<EOF

	<item>
	  <title>{$entry['title']}</title>
	  <link>{$link}</link>
	  <comments>{$comments}</comments>
	  <pubDate>{$pubdate}</pubDate>
	  <guid>{$link}</guid>
	  <description>
	    {$description}
	  </description>
	</item>
EOF;

}

$pubDate = gmdate('r');
$output = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title>{$journalnessConfig_sitename}</title>
        <link>{$journalnessConfig_live_site}</link>
        <description></description>
	  <pubDate>{$pubDate}</pubDate>

	  <language>en</language>
	  {$items_output}
    </channel>
</rss>

EOF;

header("Content-type: application/xml; charset=UTF-8");
echo $output;

?>