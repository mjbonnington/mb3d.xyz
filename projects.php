<?php
$num_items = 6; // how many items to show per page?

// If category is specified, list appropriate entries...
if($q) {
	$page_path = $db->xpath("//page[@id='films']/subpage[@id='" . $q . "']");

	// Check query is valid...
	if(!$page_path[0]) echo "<div class='error'><p>ERROR: '" . $q . "' category does not exist.</p></div>\n";

	else {
		echo "\t\t\t<section class='gallery-wrapper'>\n";
		$max_items = createGrid($db->job, $s, $num_items, 3, "media/", "3", (string)$page_path[0]->name, "category", false);
		createNav($s, $num_items, $max_items, false);
		echo "\t\t\t</section>\n";
	}

// If no category is specified, list first <$num_items> featured entries...
} else {
	echo "\t\t\t<section class='gallery-wrapper'>\n";
	$max_items = createGrid($db->job, $s, $num_items, 3, "media/", "4");
	// createNav($s, $num_items, $max_items);
	echo "\t\t\t</section>\n";
}
?>
