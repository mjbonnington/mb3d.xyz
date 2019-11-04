<?php
require_once("php/mjb-cms.inc");

// Sanitise search input...
$query = trim(preg_replace("/\s\s+/", " ", preg_replace("/[^A-Za-z0-9 ]/", " ", $_POST["query"])));

if($r) header("Location:page/search/" . $query);
else header("Location:index.php?p=search&q=" . $query);
?>