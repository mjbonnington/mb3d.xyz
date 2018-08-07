<?php
// Load XML database...
$xml_file = "data/database.xml";
if(file_exists($xml_file)) $db = simplexml_load_file($xml_file);
else exit("ERROR: Failed to open " . $xml_file);

// Get variables passed in URL...
$p = (isset($_GET["p"]) && !empty($_GET["p"])) ? $_GET["p"] : "home"; // set page string
$q = (isset($_GET["q"]) && !empty($_GET["q"])) ? $_GET["q"] : null; // set query string
$s = (isset($_GET["s"]) && !empty($_GET["s"])) ? $_GET["s"] : 0; // on which item/page/etc do we start?

// Sanitise variables passed in URL...
$p = trim(preg_replace("/\s\s+/", " ", preg_replace("/[^A-Za-z0-9_]/", "", $p)));
$q = trim(preg_replace("/\s\s+/", " ", preg_replace("/[^A-Za-z0-9_ ]/", " ", $q)));
$s = preg_replace("/[^0-9]/", "", $s);

// Set $r to true to enable url_rewrite compatible links...
if($db->site->url->attributes()->rewrite == "true") $r = true;
else $r = false;

// Set up hyperlinks to work with standard and url_rewrite links...
if($r) $hl = array("p" => "page/", "q" => "/", "s" => "/");
else $hl = array("p" => "?p=", "q" => "&amp;q=", "s" => "&amp;s=");

$today = getdate();

// Create array containing all valid page IDs...
foreach($db->page as $i) {
	if($i->status > "1") $page_array[] = $i;

	$valid_pages[] .= $i->attributes()->id;
	/*foreach($i->subpage as $j) {
		//if($j->status > "1") $page_array[i]->$subpage[] = $j;

		$valid_pages[] .= $i->attributes()->id . "_" . $j->attributes()->id;
	}*/
}

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

// Return array index of specified key
function getRef($search_ref, &$array) {
	for($i=0; $i<count($array); $i++) {
		if($search_ref == $array[$i]->attributes()->id) return $i;
	}
	return 0; //null;
}

// Parse a date string in the form of YYYYMM to return nicely formatted as MM/YYYY or MMM YYYY
function parseDate($input_date, $long=true) {
	$yyyy = substr($input_date, 0, 4);
	$mm = substr($input_date, 4, 2);
	$month_arr = array("01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
	if($long) return $month_arr[$mm] . " " . $yyyy;
	else return $mm . "/" . $yyyy;
}

// Get site's meta tags
function getMetaTags() {
	global $db, $r;

	if($r) echo "\t<base href='" . $db->site->url . "'/><!--[if lte IE 6]></base><![endif]-->\n\n";

	echo "\t<meta name='Description' content='" . $db->site->description . "'/>\n";
	echo "\t<meta name='Keywords' content='" . $db->site->keywords . "'/>\n";
	echo "\t<meta name='Author' content='" . $db->site->author . "'/>\n";
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

	if($rootpage[0]->name) $title_str .= " | " . $rootpage[0]->name;
	if($subpage[0]->name) $title_str .= " | " . $subpage[0]->name;
	if($query[0]->name) $title_str .= " | " . $query[0]->name;

	echo $title_str;
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

// Create search box
function createSearchBox($page_id) {
	if($page_id == "films" || $page_id == "search") {
		if(isset($_GET["q"]) && !empty($_GET["q"]) && $page_id == "search") {
			$query = $_GET["q"];
		} else {
			$query = "Search Films";
			$click = " onclick='this.value=\"\"'";
		}

		echo "<form id='search' method='post' action='searchform.php'>\n";
		echo "\t<div><input type='text' name='query' value='" . $query . "'" . $click . "/></div>\n";
		echo "</form>\n";
	}
}

// Get the latest job within a category (used to display the thumbnail on the portfolio page)
function getLatest($thumb_path, $query, $filter) {
	global $db;
	$max_status_level = 4;

	$xml_path = $db->xpath('//job[' . $filter . ' = "' . $query . '"]');

	if($xml_path) {
	// Look for jobs with the highest status level first, if none found try reducing the level...
		for($s=$max_status_level;$s>1;$s--) {
			foreach($xml_path as $item) {
				if($item->status == $s) {
					$img_src = $thumb_path . $item->attributes()->id . "/192x108/01.jpg";
					if(file_exists($img_src)) return $img_src;
				}
			}
		}
	}

	return "images/placeholder_192x108.gif";
}

// Recurse through XML data structure and return a long string of values (used for searching)
function printRecursive(&$xmlObj, $depth=0) {
	foreach($xmlObj->children() as $child) {
		$str .= $child . "\n";
		printRecursive($child, $depth+1);
	}
	return $str;
}

// Create grid of thumbnails
function createGrid(&$grid_array, $start, $length, $num_per_row, $thumb_path, $status_threshold="1", $query=null, $filter=null, $literal=false, $suppress_error_message=false) {
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

	echo "<div class='section'>\n";
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
		if($match && $item->status > $status_threshold) {
			if($max>=$start && $max<$length+$start) {
				$item_str = "thumb rollover";
				if($n%$num_per_row <= 1) $item_str .= " spacer";
				//if($n%$num_per_row == 0) $item_str .= " break";

				// Generate links...
				if($item->link) {
					if($item->link == "auto") $link = $hl["p"] . $p . $hl["q"] . $item->attributes()->id;
					else $link = $item->link;
				}
				else $link = $hl["p"] . "job" . $hl["q"] . $item->attributes()->id;

				// Check job thumbnail exists, otherwise use placeholder...
				//$img_src = $thumb_path . $item->attributes()->id . "/192x108/01.jpg";
				$img_src = $thumb_path . $item->image;
				if(!file_exists($img_src)) $img_src = getLatest($thumb_path, $item->name, $filter);

				// Output the HTML...
				echo "\t<div class='" . $item_str . "'>\n";
				echo "\t\t<div class='title'>" . $item->name . "</div>\n";
				echo "\t\t<a href='" . $link . "'><img src='" . $img_src . "' alt='" . $item->name . "'/></a>\n";
				if($item->caption) echo "\t\t<div class='caption'>" . $item->caption . "</div>\n";
				echo "\t</div>\n\n";
				$n++;
			} else $n = 0;
			$max++;
		}
	}

	// Print error message if no results found...
	if($max == 0 && !$suppress_error_message) echo "\t<div class='error'><p>No results found</p></div>\n";

	echo "\t<div class='break'></div>\n";
	echo "</div>\n";

		return $max; // return the total number of results found - this value is used by the function createNav();
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

	// Only create navigation if there are more items than can be displayed on one page...
	if($max > $length) {

		echo "<div class='nav'>\n";

		// Create previous page link...
		if($start > 0) {
			$page_link = ($start-$length)>=0 ? $start-$length : 0;
			$link = $link_base . $page_link;

			echo "\t<a class='lfloat' href='" . $link . "'><img src='images/button_minus.gif' alt=''/><span>" . $prev_str . "</span></a>\n";
		} else {
			echo "\t<div class='lfloat opacity0'><img src='images/button_minus.gif' alt=''/><span>" . $prev_str . "</span></div>\n";
		}

		// Create individual page links...
		for($n=1; $n<=ceil($max/$length); $n++) {
			$page_link = ($n-1)*$length;
			$link = $link_base . $page_link;

			if($show_pages) {
				if($start != $page_link) {
					echo "\t<a class='border' href='" . $link . "'><span>" . $n . "</span></a>\n";
				} else {
					echo "\t<span><b>" . $n . "</b></span>\n";
				}
			}
		}

		// Create next page link...
		if($start < $page_link) {
			$page_link = ($start+$length)<$max ? $start+$length : $max-1;
			$link = $link_base . $page_link;

			echo "\t<a class='rfloat' href='" . $link . "'><span>" . $next_str . "</span><img src='images/button_plus.gif' alt=''/></a>\n";
		} else {
			echo "\t<div class='rfloat opacity0'><span>" . $next_str . "</span><img src='images/button_plus.gif' alt=''/></div>\n";
		}

		echo "</div>\n";
	}
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
		if(file_exists($page_url)) include($page_url);

		else
		{
			echo "<div class='error'><p>ERROR: Page does not exist: &quot;" . $page_id . "&quot;</p></div>\n";
		}
	}
	else echo "<div class='error'><p>ERROR: Invalid page specified: &quot;" . $page_id . "&quot;</p></div>\n";
}

// Generate footer links
function createFooterLinks(&$menu_array) {
	global $hl;

	foreach($menu_array as $menu) {
		if($menu->status == "2-footer") {
			if($menu->link) $link = $menu->link;
			else $link = $hl["p"] . $menu->attributes()->id;

			echo " | <a href='" . $link . "'>" . $menu->name . "</a>";
		}
	}
}
?>
