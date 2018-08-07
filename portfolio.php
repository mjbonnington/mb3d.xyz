<?php
$num_items = 15; // how many items to show per page?

// If category is specified, list appropriate films...
if($q) {
	$page_path = $db->xpath("//page[@id='films']/subpage[@id='" . $q . "']");

	// Check query is valid...
	if(!$page_path[0]) echo "<div class='error'><p>ERROR: Category not found: &quot;" . $q . "&quot;</p></div>\n";

	else {
		$max_items = createGrid($db->job, $s, $num_items, 3, "images/films/", "3", (string)$page_path[0]->name, "category", false);
		createNav($s, $num_items, $max_items);
	}

// If no category is specified, list first <$num_items> featured films...
} else {
	$max_items = createGrid($db->job, $s, $num_items, 3, "images/films/", "4");
	//createNav($s, $num_items, $max_items);
}
?>
