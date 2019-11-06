<?php
$today = getdate();

// Load XML database...
$xml_file = "data/database.xml";
if(file_exists($xml_file)) $db = simplexml_load_file($xml_file);
else exit("ERROR: Failed to open " . $xml_file);

// Get variables passed in URL...
$p = (isset($_GET["p"]) && !empty($_GET["p"])) ? $_GET["p"] : "home"; // set page string
$q = (isset($_GET["q"]) && !empty($_GET["q"])) ? $_GET["q"] : null; // set query string
$s = (isset($_GET["s"]) && !empty($_GET["s"])) ? $_GET["s"] : 0; // on which item/page/etc do we start?

// Sanitise variables passed in URL...
$p = trim(preg_replace("/\s\s+/", " ", preg_replace("/[^A-Za-z0-9_\-]/", "", $p)));
$q = trim(preg_replace("/\s\s+/", " ", preg_replace("/[^A-Za-z0-9_\- ]/", " ", $q)));
$s = preg_replace("/[^0-9]/", "", $s);

// Set $r to true to enable url_rewrite compatible links...
if($db->site->url->attributes()->rewrite == "true") $r = true;
else $r = false;

// Set up hyperlinks to work with standard and url_rewrite links...
if($r) $hl = array("p" => "page/", "q" => "/", "s" => "/");
else $hl = array("p" => "?p=", "q" => "&amp;q=", "s" => "&amp;s=");

// Rewrite URLs
/*function urlRewrite($url) {
	$out = preg_replace("/^page/?$/", "index.php", $url);
	$out = preg_replace("/^page/([0-9]+)/?$/", "index.php?s=$1", $url);
	$out = preg_replace("/^page/([^/\.]+)/?$/", "index.php?p=$1", $url);
	$out = preg_replace("/^page/([^/\.]+)/([0-9]+)/?$/", "index.php?p=$1&s=$2", $url);
	$out = preg_replace("/^page/([^/\.]+)/([^/\.]+)/?$/", "index.php?p=$1&q=$2", $url);
	$out = preg_replace("/^page/([^/\.]+)/([^/\.]+)/([0-9]+)/?$/", "index.php?p=$1&q=$2&s=$3", $url);

	return $out;
}*/

// Return page id of refering page
/*function getReferer(&$valid_pages) {
	global $r;

	$url = $_SERVER['HTTP_REFERER'];
	if($r) $referer_query = parse_url($url, PHP_URL_PATH);
	else $referer_query = parse_url($url, PHP_URL_QUERY);
	foreach($valid_pages as $referer) {
		if(strpos($referer_query, $referer)) return $referer;
	}
	return null;
}*/

// Create array containing all valid page IDs
foreach($db->page as $i)
{
	if($i->priority >= 1) $page_array[] = $i;
	$valid_pages[] .= $i->attributes()->id;
	// foreach($i->subpage as $j)
	// {
	// 	if($j->priority >= 1) $page_array[i]->$subpage[] = $j;
	// 	$valid_pages[] .= $i->attributes()->id . "_" . $j->attributes()->id;
	// }
}

// Get site's meta tags
function getMetaTags() {
	global $db, $r;

	if($r) echo "\t\t<base href='" . $db->site->url . "'/><!--[if lte IE 6]></base><![endif]-->\n\n";

	if($db->site->description) echo "\t\t<meta name='Description' content='" . $db->site->description . "'/>\n";
	if($db->site->keywords) echo "\t\t<meta name='Keywords' content='" . $db->site->keywords . "'/>\n";
	if($db->site->author) echo "\t\t<meta name='Author' content='" . $db->site->author . "'/>\n";
}

// Get site's title
function getTitle() {
	global $db;

	echo $db->site->title;
}

// Get page's title
function getPageTitle(&$rootpage, &$subpage, &$query) {
	global $db;
	$title_str = $db->site->title;
	$separator = " | ";

	if($rootpage[0]->name) $title_str .= $separator . $rootpage[0]->name;
	if($subpage[0]->name) $title_str .= $separator . $subpage[0]->name;
	if($query[0]->name) $title_str .= $separator . $query[0]->name;

	echo $title_str;
}

// Return array index of specified key
function getRef($search_ref, &$array) {
	for($i=0; $i<count($array); $i++) {
		if($search_ref == $array[$i]->attributes()->id) return $i;
	}
	return 0; //null;
}

// Parse a date string in the form of YYYYMM to return nicely formatted as
// MM/YYYY or MMM YYYY
function parseDate($input_date, $long=true) {
	$yyyy = substr($input_date, 0, 4);
	$mm = substr($input_date, 4, 2);
	$month_arr = array("01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
	if($long) return $month_arr[$mm] . " " . $yyyy;
	else return $mm . "/" . $yyyy;
}

// Get the nicest title and subtitle for a specified job, return an array
// containing the title and subtitle element
function getJobTitle(&$job) {
	if($job->brand) {
		$title = $job->brand;
		$subtitle = $job->name;
	} elseif($job->client) {
		$title = $job->client;
		$subtitle = $job->name;
	} else {
		$title = $job->name;
		$subtitle = "&nbsp;";
	}

	return [$title, $subtitle];
}

// Output HTML for a job's tags. Indentation not working.
// This can be cleaned up a lot
// TODO: make job param optional and if omitted return all tags
function getJobTags(&$job, $indent=0) {
	// Create indentation
	for($i=0; $i<$indent; $s++) {
		$ind .= "\t";
	}
	// echo "\t\t\t\t\t<div class='tags'>\n";
	if($r) {
		echo $ind . "<a class='tag category' href='category/" . $job->category . "'>" . $job->category . "</a>\n";
	} else {
		echo $ind . "<a class='tag category' href='?p=search&amp;s=category&amp;q=" . $job->category . "'>" . $job->category . "</a>\n";
	}
	$tags = explode(", ", $job->tags);
	foreach($tags as $tag) {
		if($r) {
			echo $ind . "<a class='tag' href='tag/" . $tag . "'>" . $tag . "</a>\n";
		} else {
			echo $ind . "<a class='tag' href='?p=search&amp;s=tag&amp;q=" . $tag . "'>" . $tag . "</a>\n";
		}
	}
	$tags_sw = explode(", ", $job->tagssw);
	foreach($tags_sw as $tag) {
		if($r) {
			echo $ind . "<a class='tag sw' href='tag/" . $tag . "'>" . $tag . "</a>\n";
		} else {
			echo $ind . "<a class='tag sw' href='?p=search&amp;s=tag&amp;q=" . $tag . "'>" . $tag . "</a>\n";
		}
	}
	// echo "\t\t\t\t\t</div>\n";
}

// Get page wrapper background
/*function getPageBG(&$rootpage, &$subpage) {
	$bg = false;

	if($rootpage[0]->bg) {
		$bg_str = $rootpage[0]->bg;
		$bg = true;
	}
	if($subpage[0]->bg) {
		$bg_str = $subpage[0]->bg;
		$bg = true;
	}

	if($bg && $bg_str!="") {
		echo "\t\t#wrapper {background: url(" . $bg_str . ");}\n";
		return true;
	}
	else return false;
}*/

// Generate URL rewrite-compatible hyperlinks (currently page links only)
function genLink($page_id) {
	global $r;

	if($r)
		$link_str = "/" . $page_id;
	else
		$link_str = "?p=" . $page_id;

	return $link_str;
}

// Include page content
function includePage($page_id) {
	global $db, $p, $q, $r, $s, $hl, $valid_pages;
	$page_url = "./" . $page_id . ".php";
	//if($q) $query = "_" . $q;
	//$page_url = "./" . $p . $query . ".php";

	// Check requested page is valid...
	if(in_array($page_id, $valid_pages))
	{
		// Check requested page exists...
		if(file_exists($page_url))
			include($page_url);
		else
			echo "<div class='error'>Page not found: '" . $page_id . "'</div>\n";
	}
	else
		echo "<div class='error'>Invalid page: '" . $page_id . "'</div>\n";
}

// Create search box
function createSearchBox($page_id) {
	if($page_id == "projects" || $page_id == "search")
	{
		if(isset($_GET["q"]) && !empty($_GET["q"]) && $page_id == "search")
			$query = $_GET["q"];
		else
		{
			$query = "Search projects";
			$click = " onclick='this.value=\"\"'";
		}

		echo "\t\t\t\t<form id='search' method='post' action='searchform.php'>\n";
		echo "\t\t\t\t\t<div><input type='text' name='query' value='" . $query . "'" . $click . "/></div>\n";
		echo "\t\t\t\t</form>\n";
	}
}

// Generate dynamic navigation menu
//function createMenu(&$menu_array, $page_id, $bg=false) {
function createMenu($page_id) {
	global $db, $r;

	echo "\t\t\t<header class='header-compact'>\n";
	if($page_id == "home")
		//echo "\t\t\t\t<a href='?p=sitemap'><img src='images/menu.svg' width='24' alt='Menu'/></a>\n";
		echo "\t\t\t\t&nbsp;\n";
	else
		echo "\t\t\t\t<a href='index.php'><img src='images/mb3d-logo-mono.svg' width='100' alt='" . $db->site->title . " home'/></a>\n";
	echo "\n";
	echo "\t\t\t\t<nav>\n";
	echo "\t\t\t\t\t<ul class='header-menu'>\n";

	foreach($db->page as $i) {
		if($i->priority == 2) {
			// Only create a link if this isn't the page we're on
			if($i->attributes()->id == $page_id) {
				$link_open = "";
				$link_close = "";
			} else {
				$link_open = "<a href='" . genLink($i->attributes()->id) . "'>";
				$link_close = "</a>";
			}
			// Create text only (default), image only, and combined links
			switch($i->type) {
				case "both":
					$link_content = "<img src='" . $i->image->attributes()->link . "'/>" . $i->name;
					break;
				case "image":
					$link_content = "<img src='" . $i->image->attributes()->link . "' alt='" . $i->name . "'/>";
					break;
				case "text":
				default:
					$link_content = $i->name;
			}
			// Generate menu item markup
			echo "\t\t\t\t\t\t<li>" . $link_open . $link_content . $link_close . "</li>\n";
		}
		$valid_pages[] = $i->attributes()->id;
	}

	echo "\t\t\t\t\t</ul>\n";
	echo "\t\t\t\t</nav>\n";
	echo "\t\t\t</header>\n";

}

// Create gallery view (grid of thumbnails)
function createGallery(&$grid_array, $start, $length, $thumb_path, $min_priority=1, $query=null, $filter=null, $literal=false, $suppress_error_message=false) {
	global $hl, $p;

	$max = 0;
	$n = 0;
	$match = false;

	// Filter search results...
	if($query) {
		if($filter) {
			if($literal) $eval_str = "if(\$item->" . $filter . " == '" . $query . "') \$match = true; else \$match = false;";
			else $eval_str = "if(stripos(\$item->" . $filter . ", \$query) !== false) \$match = true; else \$match = false;";
		} else {
			if($literal) $keywords = $query;
			else $keywords = explode(" ", $query);
		}
	} else {
		$eval_str = "\$match = true;"; // show all items
	}

	// Sort array...
	//sort($grid_array);

	echo "\t\t\t\t<div class='gallery'>\n";
	foreach($grid_array as $item) {

		// Evaluate search query string...
		if($filter) eval($eval_str);

		// Search in all fields...
		else {
			$search_str = printRecursive($item);
			$matches = 0;
			foreach($keywords as $i) if(preg_match("/\b" . $i . "\b/i", $search_str)) $matches += 1;
			if($matches == count($keywords)) $match = true; else $match = false; // AND
			//if($matches) $match = true; else $match = false; // OR
		}

		// Create grid...
		if($match && $item->priority >= $min_priority) {
			if($max>=$start && $max<$length+$start) {
				// Generate links...
				if($item->link) {
					if($item->link == "auto") $link = $hl["p"] . $p . $hl["q"] . $item->attributes()->id;
					else $link = $item->link;
				}
				else $link = $hl["p"] . "job" . $hl["q"] . $item->attributes()->id;

				// Generate title, subtitle and captions/badges...
				$titles = getJobTitle($item);

				// Check job thumbnail exists, otherwise use placeholder...
				$img_src = $thumb_path . $item->attributes()->id . "-thumb.jpg";
				if(!file_exists($img_src))
					$img_src = $item->image->attributes()->link;
				if(!file_exists($img_src))
					$img_src = "images/placeholder-thumb.png";
				// $img_src = $thumb_path . $item->image;
				// if(!file_exists($img_src)) $img_src = getLatest($thumb_path, $item->name, $filter);

				// Output the HTML...
				createGalleryItem($item->name, $img_src, $link, $titles[0], $titles[1], $item->caption);
				$n++;
			} else $n = 0;
			$max++;
		}
	}

	echo "\t\t\t\t</div>\n\n";

	// Print error message if no results found...
	if($max == 0 && !$suppress_error_message)
		echo "<div class='error'>No results found.</div>\n";

	return $max; // return the total number of results found - this value is used by the function createNav();
}

// Create gallery item (thumbnail)
function createGalleryItem($name, $image, $link, $title, $subtitle, $caption=null) {
	// Output the HTML...
	echo "\t\t\t\t\t<div class='gallery-item'>\n";
	echo "\t\t\t\t\t\t<a href='" . $link . "'>\n";
	echo "\t\t\t\t\t\t\t<img src='" . $image . "' alt='" . $name . "'/>\n";
	echo "\t\t\t\t\t\t\t<span class='gallery-item-title'>\n";
	echo "\t\t\t\t\t\t\t\t<h1 class='title'>" . $title . "</h1>\n";
	echo "\t\t\t\t\t\t\t\t<h2 class='subtitle'>" . $subtitle . "</h2>\n";
	if($caption)
		echo "\t\t\t\t\t\t\t\t<p class='caption'>" . $caption . "</p>\n";
	echo "\t\t\t\t\t\t\t</span>\n";
	echo "\t\t\t\t\t\t</a>\n";
	echo "\t\t\t\t\t</div>\n";
}

// Generate page navigation
function createNav($start, $length, $max, $show_pages=true, $prev_str="Prev", $next_str="Next") {

	// Generate base link...
	global $p, $q, $r;
	if($r) {
		$link_base = "page/" . $p;
		if($q) $link_base .= "/" . $q;
		$link_base .= "/";
	} else {
		$link_base = "?p=" . $p;
		if($q) $link_base .= "&amp;q=" . $q;
		$link_base .= "&amp;s=";
	}

	// Only create navigation if there are more items than can be displayed on
	// one page, and the first item is within the correct range...
	if($max > $length && $start < $max) {
		echo "\t\t\t\t<nav class='gallery-nav'>\n";
		echo "\t\t\t\t\t<ul class='header-menu'>\n";

		// Create previous page link...
		if($start > 0) {
			$page_link = ($start-$length)>=0 ? $start-$length : 0;
			$link = $link_base . $page_link;

			echo "\t\t\t\t\t\t<li><a href='" . $link . "'>" . $prev_str . "</a></li>\n";
		} else {
			echo "\t\t\t\t\t\t<li>" . $prev_str . "</li>\n";
		}

		// Create individual page links...
		if($show_pages) {
			for($n=1; $n<=ceil($max/$length); $n++) {
				$page_link = ($n-1)*$length;
				$link = $link_base . $page_link;

				if($start != $page_link) {
					echo "\t\t\t\t\t\t<li><a href='" . $link . "'>" . $n . "</a></li>\n";
				} else {
					echo "\t\t\t\t\t\t<li class='current'>" . $n . "</li>\n";
				}
			}
		} else {
			for($n=1; $n<=ceil($max/$length); $n++) {
				$page_link = ($n-1)*$length;
			}

			$first = $start+1;
			if($start+$length < $max) $last = $start+$length;
			else $last = $max;
			if($first == $last) $range = $first;
			else $range = $first . "-" . $last;
			echo "\t\t\t\t\t\t<li class='current'>" . $range . " of " . $max . "</li>\n";
		}

		// Create next page link...
		if($start < $page_link) {
			$page_link = ($start+$length)<$max ? $start+$length : $max-1;
			$link = $link_base . $page_link;

			echo "\t\t\t\t\t\t<li><a href='" . $link . "'>" . $next_str . "</a></li>\n";
		} else {
			echo "\t\t\t\t\t\t<li>" . $next_str . "</li>\n";
		}

		echo "\t\t\t\t\t</ul>\n";
		echo "\t\t\t\t</nav>\n\n";
	}
}

// Get the latest job within a category (used to display the thumbnail on the
// portfolio page)
function getLatest($thumb_path, $query, $filter) {
	global $db;
	$max_priority = 4;
	$min_priority = 1;

	$xml_path = $db->xpath('//job[' . $filter . ' = "' . $query . '"]');

	if($xml_path) {
	// Look for jobs with the highest priority level first, if none found try
	// reducing the level...
		for($s=$max_priority; $s>$min_priority; $s--) {
			foreach($xml_path as $item) {
				if($item->priority == $s) {
					$img_src = $thumb_path . $item->attributes()->id . "-thumb.jpg";
					if(file_exists($img_src)) return $img_src;
				}
			}
		}
	}

	return "images/placeholder-thumb.png";
}

// Return the number of results of a given category (or tag, when implemented)
function getCategoryCount($query, $filter, $min_priority=1) {
	global $db;
	$xml_path = $db->xpath("//job[" . $filter . "='" . $query . "' and priority>=" . $min_priority . "]");
	return count($xml_path);
}

// Recurse through XML data structure and return a long string of values
// (used for searching)
function printRecursive(&$xml_obj, $depth=0) {
	foreach($xml_obj->children() as $child) {
		$str .= $child . "\n";
		printRecursive($child, $depth+1);
	}
	return $str;
}

// Generate footer links
function createFooterLinks(&$menu_array) {
	global $hl;

	foreach($menu_array as $menu) {
		if($menu->priority == 1) {
			if($menu->link) $link = $menu->link;
			else $link = $hl["p"] . $menu->attributes()->id;

			echo " | <a href='" . $link . "'>" . $menu->name . "</a>";
		}
	}
}

?>