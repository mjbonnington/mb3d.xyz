<?php
$feat_jobs = array();
$rand_jobs = array();
$n = (isset($_GET['n']) && !empty($_GET['n'])) ? $_GET['n'] : 4;

for($i=0; $i<count($db->job); $i++) {
	if($db->job[$i]->status > "3") $feat_jobs[] = $i;
}

if($n > count($feat_jobs)) $n = count($feat_jobs);
$rand_jobs = array_slice($feat_jobs, 1, count($feat_jobs));
shuffle($rand_jobs);
?>

			<header class='header'>
				<img src='images/mb3d-logo.svg' width='160' alt='MB3D logo'/>
				<h1 class='title'>Michael Bonnington</h1>
				<h2 class='subtitle'>{ 3D&nbsp;Artist; CG&nbsp;Supervisor; VFX&nbsp;Pipeline&nbsp;Developer }</h2>
				<!-- <ul class='subtitle'>
					<li>3D Artist</li>
					<li>CG Supervisor</li>
					<li>VFX Pipeline Developer</li>
				</ul> -->
			</header>

			<section class='video-wrapper'>
				<video width='1920' controls>
					<source src='media/mb-reel-1806-v04-h264-1080p.mp4' type='video/mp4'/>
					Your browser does not support HTML5 video. <a href='media/mb-reel-1806-v04-h264-1080p.mp4'>Download video</a>
				</video>

				<nav class='gallery-nav'>
					<ul class='header-menu'>
						<li><a href='?p=reel'>Showreel &gt;</a></li>
					</ul>
				</nav>
			</section>

			<section class='gallery-wrapper'>

<?php $max_items = createGrid($db->job, $s, 3, "media/", "3"); ?>

				<nav class='gallery-nav'>
					<ul class='header-menu'>
						<li><a href='?p=projects'>More Projects &gt;</a></li>
						<li><a href='?p=projects&q=commercials'>Commercials</a></li>
						<li><a href='?p=projects&q=broadcast'>Broadcast</a></li>
						<li><a href='?p=projects&q=film'>Film</a></li>
						<li><a href='?p=projects&q=shorts'>Shorts</a></li>
						<li><a href='?p=projects&q=promos'>Promos</a></li>
						<li><a href='?p=projects&q=online'>Online</a></li>
						<li><a href='?p=projects&q=other'>Other</a></li>
					</ul>
				</nav>
			</section>
