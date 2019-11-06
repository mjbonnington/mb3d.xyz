<?php
$num_items = 6; // how many items to show per page?
$priority_threshold = 2; // show items with this priority level or higher

$tag_array = getAllTags($q);

// If tag is specified, list appropriate entries...
if($q) {
	// Check query is valid...
	if($q not in $tag_array)
		echo "<div class='error'>Tag '" . $q . "' does not exist.</div>\n";
	else {
		echo "\t\t\t<section class='gallery-wrapper'>\n";
		$max_items = createGallery($db->job, $s, $num_items, "media/", $priority_threshold, $q, "tag", false);
		createNav($s, $num_items, $max_items, false);
		echo "\t\t\t</section>\n";
	}

// If no tag is specified, display list of all tags...
} else {
	echo "\t\t\t<section class='gallery-wrapper'>\n";
	echo "\t\t\t\t<span class='tags'>\n";
	$n = 0;
	foreach($tag_array as $tag) {
		$count = getTagCount($tag, "tag", $priority_threshold);
		if($count) {
			getJobTags($job);
			$n++;
		}
	}
	echo "\t\t\t\t</span>\n";
	// Print error message if no results found...
	if($n == 0) echo "<div class='error'>No results found.</div>\n";
	echo "\t\t\t</section>\n";
}
?>
