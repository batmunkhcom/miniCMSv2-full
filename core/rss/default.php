<?
echo "<item>";
		echo "<title>".mbmRSSecho(PAGE_TITLE)."</title>\n";
		echo "<link>".mbmRSSecho(DOMAIN)."</link>\n";
		echo "<author>".mbmRSSecho(ADMIN_NAME)." | ".mbmRSSecho(ADMIN_EMAIL)."</author>\n";
		echo "<pubDate>".mbmDate("Y-m-d H:i:s")."</pubDate>\n";
		echo "<description>The website developed by miniCMS v2. For more information please visit ".mbmRSSecho("http://www.mng.cc")."</description>\n";
echo "</item>";
?>