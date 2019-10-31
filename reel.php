<?php
function getJobSummary($jobid, $tc) {
	global $db;

	$job = $db->xpath("//job[@id='" . $jobid . "']")[0];

	if(!$job) echo "<div class='error'>Job not found: '" . $jobid . "'</div>\n";
	
	else {
		$titles = getJobTitle($job);
		echo "\t\t\t\t\t<p><span class='timecode'>" . $tc . "</span> <a href='?p=job&q=" . $jobid . "'>" . $titles[0] . " - <em>" . $titles[1] . "</em></a> (" . substr($job->date, 0, 4) . ")</p>\n";
		echo "\t\t\t\t\t<span class='tags'>\n";
		getJobTags($job);
		echo "\t\t\t\t\t</span>\n";
	}
}
?>
			<section class='video-wrapper'>
				<video width='1920' controls>
					<source src='media/mb-reel-1806-v04-h264-1080p.mp4' type='video/mp4'/>
					Your browser does not support HTML5 video. <a href='media/mb-reel-1806-v04-h264-1080p.mp4'>Download video</a>
				</video>

				<div class='video-description offset-tc'>
<?php getJobSummary("rbl-rethink-remembrance", "0:00"); ?>
					<hr/>
<?php getJobSummary("betfair-this-is-play", "0:05"); ?>
					<hr/>
<?php getJobSummary("butterfinger-bolder-than-bold", "0:17"); ?>
					<hr/>
<?php getJobSummary("ford-vw-vfx-tests", "0:24"); ?>
					<hr/>
<?php getJobSummary("tuborg-music-idents", "0:31"); ?>
					<hr/>
<?php getJobSummary("itv-im-a-celeb", "0:36"); ?>
					<hr/>
<?php getJobSummary("coco-pops-cupboard", "0:42"); ?>
					<hr/>
<?php getJobSummary("listerine-advanced-white", "0:50"); ?>
					<hr/>
					<p><span class='timecode'>0:55</span> <a href='?p=job&q=baron-otard-xo'>Bacardi Baron Otard XO</a> (2014)</p>
					<span class='tags'>
						<a class='tag' href='#'>Layout</a>
						<a class='tag' href='#'>Modelling</a>
						<a class='tag' href='#'>Animation</a>
						<a class='tag' href='#'>Lookdev</a>
						<a class='tag' href='#'>Lighting</a>
						<a class='tag' href='#'>Comp</a>
						<a class='tag sw' href='#'>Maya</a>
						<a class='tag sw' href='#'>V-Ray</a>
						<a class='tag sw' href='#'>Nuke</a>
					</span>
					<hr/>
					<p><span class='timecode'>1:02</span> <a href='?p=job&q=betfair-lets-play-nj'>Betfair - <em>Let's Play NJ</em></a> (2013)</p>
					<span class='tags'>
						<a class='tag' href='#'>Layout</a>
						<a class='tag' href='#'>Modelling</a>
						<a class='tag' href='#'>Lookdev</a>
						<a class='tag' href='#'>Lighting</a>
						<a class='tag sw' href='#'>Maya</a>
						<a class='tag sw' href='#'>V-Ray</a>
						<a class='tag sw' href='#'>Nuke</a>
					</span>
					<hr/>
					<p><span class='timecode'>1:07</span> <a href='?p=job&q=the-louvre'>Mark Lewis - <em>The Louvre Installation</em></a> (2014)</p>
					<span class='tags'>
						<a class='tag' href='#'>Modelling</a>
						<a class='tag' href='#'>Photogrammetry</a>
						<a class='tag' href='#'>Lookdev</a>
						<a class='tag' href='#'>Comp</a>
						<a class='tag sw' href='#'>Maya</a>
						<a class='tag sw' href='#'>Photoshop</a>
						<a class='tag sw' href='#'>Photoscan</a>
						<a class='tag sw' href='#'>Nuke</a>
					</span>
					<hr/>
					<p><span class='timecode'>1:13</span> <a href='?p=job&q=boss-orange'>Hugo Boss - <em>Boss Orange</em></a> (2012)</p>
					<span class='tags'>
						<a class='tag' href='#'>Layout</a>
						<a class='tag' href='#'>Modelling</a>
						<a class='tag' href='#'>Lookdev</a>
						<a class='tag' href='#'>Lighting</a>
						<a class='tag sw' href='#'>Maya</a>
						<a class='tag sw' href='#'>mentalray</a>
					</span>
					<hr/>
					<p><span class='timecode'>1:17</span> <a href='?p=job&q=ribena-currant-affairs'>Ribena - <em>Currant Affairs</em></a> (2006)</p>
					<span class='tags'>
						<a class='tag' href='#'>Matchmoving</a>
						<a class='tag' href='#'>Layout</a>
						<a class='tag' href='#'>Modelling</a>
						<a class='tag' href='#'>Lookdev</a>
						<a class='tag' href='#'>Lighting</a>
						<a class='tag' href='#'>Comp</a>
						<a class='tag sw' href='#'>Maya</a>
						<a class='tag sw' href='#'>mentalray</a>
						<a class='tag sw' href='#'>Boujou</a>
						<a class='tag sw' href='#'>Photoshop</a>
						<a class='tag sw' href='#'>After Effects</a>
					</span>
					<hr/>
					<p><span class='timecode'>1:25</span> <a href='?p=job&q=f1-rocks'>F1 Rocks</a> (2009)</p>
					<span class='tags'>
						<a class='tag' href='#'>Layout</a>
						<a class='tag' href='#'>Motion Design</a>
						<a class='tag' href='#'>Modelling</a>
						<a class='tag' href='#'>Animation</a>
						<a class='tag sw' href='#'>Maya</a>
						<a class='tag sw' href='#'>After Effects</a>
					</span>
					<hr/>
					<p><span class='timecode'>1:30</span> <a href='?p=job&q=mini-lasers'>Mini - <em>Lasers</em></a> (2006)</p>
					<span class='tags'>
						<a class='tag' href='#'>Modelling</a>
						<a class='tag' href='#'>Animation</a>
						<a class='tag' href='#'>Lookdev</a>
						<a class='tag' href='#'>Lighting</a>
						<a class='tag sw' href='#'>Maya</a>
						<a class='tag sw' href='#'>mentalray</a>
						<a class='tag sw' href='#'>After Effects</a>
					</span>
					<hr/>
					<p><span class='timecode'>1:33</span> <a href='?p=job&q=betfair-world-cup-cashout'>Betfair - <em>World Cup Cashout</em></a> (2014)</p>
					<span class='tags'>
						<a class='tag' href='#'>Set reconstruction</a>
						<a class='tag' href='#'>Lookdev</a>
						<a class='tag' href='#'>Lighting</a>
						<a class='tag sw' href='#'>Maya</a>
						<a class='tag sw' href='#'>V-Ray</a>
						<a class='tag sw' href='#'>Nuke</a>
					</span>
				</div>
			</section>
