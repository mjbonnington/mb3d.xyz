<?php
// Use xpath query to find relevant job...
$job = $db->xpath("//job[@id='" . $q . "']");

// Check job is valid...
if(!$job[0]) echo "\t<div class='error'><p>ERROR: Job does not exist: " . $q . "'</p></div>\n";

// Generate page markup...
else
{
	// Video container...
	if($job[0]->movie) {
		echo "\t\t\t<section class='video-wrapper'>\n";
		echo "\t\t\t\t<video width='1920' controls poster='" . $job[0]->image->attributes()->link . "'>\n";
		echo "\t\t\t\t\t<source src='" . $job[0]->movie->attributes()->link . "' type='video/mp4'/>\n";
		echo "\t\t\t\t\tYour browser does not support HTML5 video. <a href='" . $job[0]->movie->attributes()->link . "'>Download video</a>\n";
		echo "\t\t\t\t</video>\n";
		echo "\t\t\t</section>\n";
	}
	else echo "\t<div class='error'><p>ERROR: No video file specified.</p></div>\n";

	// Job title...
	echo "\t\t\t<section class='title-wrapper'>\n";
	echo "\t\t\t\t<div class='video-title'>\n";
	echo "\t\t\t\t\t<h1 class='title'>" . $job[0]->brand . "</h1>\n";
	echo "\t\t\t\t\t<h2 class='subtitle'>" . $job[0]->name . "</h2>\n";
	echo "\t\t\t\t</div>\n";
	echo "\t\t\t</section>\n";

	echo "\t\t\t<section class='section-wrapper'>\n";

	// Description...
	echo "\t\t\t\t<div class='body-text'>\n";
	echo "\t\t\t\t\t" . $job[0]->description->attributes()->link . "\n";  // need markdown parser
	echo "\t\t\t\t</div>\n";

	// Info & Credits...
	echo "\t\t\t\t<div class='video-description'>\n";
	echo "\t\t\t\t\t<ul class='job-details'>\n";
	echo "\t\t\t\t\t\t<li>Date <span class='field'>" . parseDate($job[0]->date, true) . "</span></li>\n";
	if($job[0]->format) echo "\t\t\t\t\t\t<li>Format <span class='field'>" . $job[0]->format . "</span></li>\n";
	if($job[0]->client) echo "\t\t\t\t\t\t<li>Client <span class='field'>" . $job[0]->client . "</span></li>\n";
	if($job[0]->agency) echo "\t\t\t\t\t\t<li>Agency <span class='field'>" . $job[0]->agency . "</span></li>\n";
	if($job[0]->studio) echo "\t\t\t\t\t\t<li>Studio <span class='field'>" . $job[0]->studio . "</span></li>\n";
	if($job[0]->director) echo "\t\t\t\t\t\t<li>Director <span class='field'>" . $job[0]->director . "</span></li>\n";
	// foreach($job[0]->credit as $credit) echo "\t\t\t<p>" . $credit->attributes()->role . ": <b>" . $credit . "</b></p>\n";
	echo "\t\t\t\t\t</ul>\n";

	// Tags...
	echo "\t\t\t\t\t<div class='tags'>\n";
	$tags = explode(", ", $job[0]->tags);
	foreach($tags as $tag) {
		//echo "<a class='tag' href='" . $hl["p"] . "search"
		if($r) {
			echo "\t\t\t\t\t\t<a class='tag' href='tag/" . $tag . "'>" . $tag . "</a>\n";
		} else {
			echo "\t\t\t\t\t\t<a class='tag' href='?p=search&amp;s=tag&amp;q=" . $tag . "'>" . $tag . "</a>\n";
		}
	}
	// echo "\t\t\t\t\t\t<a class='tag category' href='#'>Commercials</a>\n";
	// echo "\t\t\t\t\t\t<a class='tag' href='#'>Lookdev</a>\n";
	// echo "\t\t\t\t\t\t<a class='tag' href='#'>Lighting</a>\n";
	// echo "\t\t\t\t\t\t<a class='tag' href='#'>Matchmoving</a>\n";
	// echo "\t\t\t\t\t\t<a class='tag' href='#'>Set reconstruction</a>\n";
	// echo "\t\t\t\t\t\t<a class='tag sw' href='#'>Maya</a>\n";
	// echo "\t\t\t\t\t\t<a class='tag sw' href='#'>V-Ray</a>\n";
	// echo "\t\t\t\t\t\t<a class='tag sw' href='#'>PFTrack</a>\n";
	// echo "\t\t\t\t\t\t<a class='tag sw' href='#'>Nuke</a>\n";
	echo "\t\t\t\t\t</div>\n";
	echo "\t\t\t\t</div>\n";

	echo "\t\t\t</section>\n";
}
?>