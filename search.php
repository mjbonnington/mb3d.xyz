<?php
$num_items = 6; // how many items to show per page?

echo "\t\t\t<section class='gallery-wrapper'>\n";
$max_items = createGrid($db->job, $s, $num_items, "media/", "1", $q);
createNav($s, $num_items, $max_items, false);
echo "\t\t\t</section>\n";
?>
