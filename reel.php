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
<?php getJobSummary("ford-vw-cg-breakdown", "0:24"); ?>
					<hr/>
<?php getJobSummary("tuborg-music-idents", "0:31"); ?>
					<hr/>
<?php getJobSummary("itv-im-a-celeb", "0:36"); ?>
					<hr/>
<?php getJobSummary("coco-pops-cupboard", "0:42"); ?>
					<hr/>
<?php getJobSummary("listerine-advanced-white", "0:50"); ?>
					<hr/>
<?php getJobSummary("baron-otard-xo", "0:55"); ?>
					<hr/>
<?php getJobSummary("betfair-lets-play-nj", "1:02"); ?>
					<hr/>
<?php getJobSummary("the-louvre", "1:07"); ?>
					<hr/>
<?php getJobSummary("boss-orange-packshot", "1:13"); ?>
					<hr/>
<?php getJobSummary("ribena-currant-affairs", "1:17"); ?>
					<hr/>
<?php getJobSummary("f1-rocks", "1:25"); ?>
					<hr/>
<?php getJobSummary("mini-lasers", "1:30"); ?>
					<hr/>
<?php getJobSummary("betfair-world-cup-cashout", "1:33"); ?>
				</div>
			</section>
