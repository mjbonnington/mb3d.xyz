<?php
$num_items = 6; // how many items to show per page?
$priority_threshold = 2; // show items with this priority level or higher

// If category is specified, list appropriate entries...
if($q) {
	$page_path = $db->xpath("//page[@id='projects']/subpage[@id='" . $q . "']");

	// Check query is valid...
	if(!$page_path[0]) echo "<div class='error'>Category '" . $q . "' does not exist.</div>\n";

	else {
		echo "\t\t\t<section class='gallery-wrapper'>\n";
		$max_items = createGallery($db->job, $s, $num_items, "media/", $priority_threshold, (string)$page_path[0]->name, "category", false);
		createNav($s, $num_items, $max_items, false);
		echo "\t\t\t</section>\n";
	}

// If no category is specified, display category thumbnail gallery...
} else {
	echo "\t\t\t<section class='gallery-wrapper'>\n";
	// $max_items = createGallery($db->job, $s, $num_items, "media/", "3");
	// createNav($s, $num_items, $max_items);
	echo "\t\t\t\t<div class='gallery'>\n";
	$n = 0;
	$categories = $db->xpath("//page[@id='projects']/subpage");
	foreach($categories as $cat) {
		$count = getCategoryCount($cat->name, "category", $priority_threshold);
		if($count) {
			$img_src = getLatest("media/", $cat->name, "category");
			$link = "?p=projects&q=" . $cat->attributes()->id;
			if($count == 1) $suffix = " project";
			else $suffix = " projects";
			$subtitle = $count . $suffix;
			createGalleryItem($cat->name, $img_src, $link, $cat->name, $subtitle);
			$n++;
		}
	}
	echo "\t\t\t\t</div>\n";
	// Print error message if no results found...
	if($n == 0) echo "<div class='error'>No results found.</div>\n";
	echo "\t\t\t</section>\n";
}
?>
