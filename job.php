<?php
// Use xpath query to find relevant job...
$job = $db->xpath("//job[@id='" . $q . "']");

// Check job is valid...
if(!$job[0]) echo "\t<div class='error'><p>ERROR: Job does not exist: &quot;" . $q . "&quot;</p></div>\n";

// Generate page markup...
else
{
	if($job[0]->movie) {
		echo "\t<div class='row'>\n";
		echo "\t\t<video width='1920' controls poster='" . $job[0]->image . "'>\n";
		echo "\t\t\t<source src='" . $job[0]->movie . "' type='video/mp4'/>\n";
		echo "\t\t\tYour browser does not support HTML5 video. <a href='" . $job[0]->movie . "'>Download video</a>\n";
		echo "\t\t</video>\n";
		echo "\t</div>\n";
	}
	else echo "\t<div class='error'><p>ERROR: No video file specified.</p></div>\n";

	// Job title...
	echo "\t<div class='row'>\n";
	echo "\t\t<div class='col-12 col-s-12'>\n";
	echo "\t\t\t<div class='job-title'><b>" . $job[0]->brand . "</b> " . $job[0]->name . "</div>\n";
	if($job[0]->caption) echo "\t\t\t<div class='job-subtitle'>" . $job[0]->caption . "</div>\n";
	echo "\t\t</div>\n";
	echo "\t</div>\n";

	// Description...
	echo "\t<div class='row'>\n";
	echo "\t\t<div class='col-8 col-s-8 body-text'>\n";
	if($job[0]->description) echo "\t\t\t<p>" . $job[0]->description . "</p>\n";
	echo "\t\t</div>\n";

	// Info & Credits...
	echo "\t\t<div class='col-4 col-s-4 job-details'>\n";
	if($job[0]->date) echo "\t\t\t<p>Date: <b>" . parseDate($job[0]->date, true) . "</b></p>\n";
	if($job[0]->format) echo "\t\t\t<p>Format: <b>" . $job[0]->format . "</b></p>\n";
	if($job[0]->client) echo "\t\t\t<p>Client: <b>" . $job[0]->client . "</b></p>\n";
	if($job[0]->agency) echo "\t\t\t<p>Agency: <b>" . $job[0]->agency . "</b></p>\n";
	if($job[0]->studio) echo "\t\t\t<p>Studio: <b>" . $job[0]->studio . "</b></p>\n";
	foreach($job[0]->credit as $credit) echo "\t\t\t<p>" . $credit->attributes()->role . ": <b>" . $credit . "</b></p>\n";
	echo "\t\t</div>\n";
	echo "\t</div>\n";

	// Tags...
	echo "\t<div class='row'>\n";
	echo "\t\t<div class='col-12 col-s-12 tags'>\n";
	$tags = explode(", ", $job[0]->tags);
	foreach($tags as $tag) {
		//echo "<a class='tag' href='" . $hl["p"] . "search"
		if($r) {
			echo "<a class='tag' href='tag/" . $tag . "'>" . $tag . "</a>";
		} else {
			echo "<a class='tag' href='?p=search&amp;s=tag&amp;q=" . $tag . "'>" . $tag . "</a>";
		}
	}
	echo "\t\t</div>\n";
	echo "\t</div>\n";
}
?>