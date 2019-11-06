<?php
$num_items = 6; // how many items to show per page?
$priority_threshold = 1; // show items with this priority level or higher

echo "\t\t\t<section class='searchbar'>\n";
createSearchBox($p);
echo "\t\t\t</section>\n\n";

echo "\t\t\t<section class='gallery-wrapper'>\n";
$max_items = createGallery($db->job, $s, $num_items, "media/", $priority_threshold, $q);
createNav($s, $num_items, $max_items, false);
echo "\t\t\t</section>\n";
?>
