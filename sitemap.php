<?php
echo "<div class='section'>\n";
echo "\t<h3>Sitemap</h3>\n";

echo "\t<div class='columns3'>\n";
echo "\t\t<ul>\n";

foreach($db->pages->page as $i) {
	if($i->status > "1" && $i->attributes()->id != "spacer") {
		if($i->link) $link = $i->link;
		else $link = $hl["p"] . $i->attributes()->id;

		echo "\t\t\t<li class='sitemap-link'><a href='" . $link . "'>" . $i->name . "</a></li>\n";

		foreach($i->subpage as $j) {
			if($j->status > "1" && $j->attributes()->id != "spacer") {
				if($j->link) {
					if($j->link == "auto") $link = $hl["p"] . $i->attributes()->id . $hl["q"] . $j->attributes()->id;
					else $link = $j->link;
				}
				else $link = $hl["p"] . $i->attributes()->id . "_" . $j->attributes()->id;

				echo "\t\t\t<li class='sitemap-sublink'><a href='" . $link . "'>" . $j->name . "</a></li>\n";
			}
		}
	}
}
echo "\t\t</ul>\n";
echo "\t</div>\n";

echo "</div>\n";
?>