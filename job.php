<?php
require_once("php/Parsedown.php");

// Use xpath query to find relevant job...
$job = $db->xpath("//job[@id='" . $q . "']")[0];

// Check job is valid...
// if(!$job == "") echo "<div class='error'>No job specified.</div>\n";
if(!$job) echo "<div class='error'>Job not found: '" . $q . "'</div>\n";

// Generate page markup...
else
{
	// Generate title, subtitle and captions/badges...
	$titles = getJobTitle($job);

	// Read description from markdown file
	$Parsedown = new Parsedown();
	$md_file = $job->description->attributes()->link;
	$fh = fopen($md_file, "r"); // or die("Unable to open file!");
	$description = $Parsedown->text(fread($fh, filesize($md_file)));
	fclose($fh);

	// If that fails, read description from inline tag contents
	if(!$description) $description = $job->description;

	// Generate markup...

	// Video container...
	if($job->movie) {
		echo "\t\t\t<section class='video-wrapper'>\n";
		echo "\t\t\t\t<video width='1920' controls poster='" . $job->image->attributes()->link . "'>\n";
		echo "\t\t\t\t\t<source src='" . $job->movie->attributes()->link . "' type='video/mp4'/>\n";
		echo "\t\t\t\t\tYour browser does not support HTML5 video. <a href='" . $job->movie->attributes()->link . "'>Download video</a>\n";
		echo "\t\t\t\t</video>\n";
		echo "\t\t\t</section>\n";
	}
	else echo "<div class='error'>Video not found.</div>\n";

	// Title...
	echo "\t\t\t<section class='title-wrapper'>\n";
	echo "\t\t\t\t<div class='video-title'>\n";
	echo "\t\t\t\t\t<h1 class='title'>" . $titles[0] . "</h1>\n";
	echo "\t\t\t\t\t<h2 class='subtitle'>" . $titles[1] . "</h2>\n";
	echo "\t\t\t\t</div>\n";
	echo "\t\t\t</section>\n";

	echo "\t\t\t<section class='section-wrapper'>\n";

	// Description...
	if($description != "") {
		echo "\t\t\t\t<div class='body-text'>\n";
		echo "\t\t\t\t\t" . $description . "\n";
		echo "\t\t\t\t</div>\n";
	}

	// Info & Credits...
	echo "\t\t\t\t<div class='video-description'>\n";
	echo "\t\t\t\t\t<ul class='job-details'>\n";
	echo "\t\t\t\t\t\t<li>Date <span class='field'>" . parseDate($job->date, true) . "</span></li>\n";
	if($job->format) echo "\t\t\t\t\t\t<li>Format <span class='field'>" . $job->format . "</span></li>\n";
	if($job->client) echo "\t\t\t\t\t\t<li>Client <span class='field'>" . $job->client . "</span></li>\n";
	if($job->agency) echo "\t\t\t\t\t\t<li>Agency <span class='field'>" . $job->agency . "</span></li>\n";
	if($job->studio) echo "\t\t\t\t\t\t<li>Studio <span class='field'>" . $job->studio . "</span></li>\n";
	if($job->director) echo "\t\t\t\t\t\t<li>Director <span class='field'>" . $job->director . "</span></li>\n";
	foreach($job->credit as $credit) echo "\t\t\t\t\t\t<li>" . $credit->attributes()->role . " <span class='field'>" . $credit . "</span></li>\n";
	echo "\t\t\t\t\t</ul>\n";

	// Tags...
	echo "\t\t\t\t\t<div class='tags'>\n";
	getJobTags($job);
	echo "\t\t\t\t\t</div>\n";
	echo "\t\t\t\t</div>\n";

	echo "\t\t\t</section>\n";
}
?>