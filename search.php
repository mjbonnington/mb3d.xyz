<?php
$num_items = 15; // how many items to show per page?

$max_items = createGrid($db->job, $s, $num_items, 3, "", "1", $q);
createNav($s, $num_items, $max_items);
?>
