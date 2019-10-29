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
						<li><a href='static-reel.html'>Showreel &gt;</a></li>
					</ul>
				</nav>
			</section>

			<section class='gallery-wrapper'>



				<nav class='gallery-nav'>
					<ul class='header-menu'>
						<li><a href='static-projects.html'>More Projects &gt;</a></li>
					</ul>
				</nav>
			</section>



<?php include("news/latest.html"); ?>

<div class="section break">
	<h2 class="heading break">Featured Jobs</h2>

	<div class="thumb full break">
		<p class="category">Latest: <?php echo $db->job[$feat_jobs[0]]->category; ?></p>
		<a href="<?php if($r) echo "job/" . $db->job[$feat_jobs[0]]->attributes()->id; else echo "?p=job&amp;j=" . $db->job[$feat_jobs[0]]->attributes()->id; ?>"><img src="images/<?php echo $db->job[$feat_jobs[0]]->attributes()->id; ?>_main.jpg" width="600" height="200" alt=""/></a>
		<h3><?php echo $db->job[$feat_jobs[0]]->title; ?></h3>
		<p><?php echo substr($db->job[$feat_jobs[0]]->description, 0, strpos($db->job[$feat_jobs[0]]->description, ". ")+1); ?></p>
		<p><a href="<?php if($r) echo "job/" . $db->job[$feat_jobs[0]]->attributes()->id; else echo "?p=job&amp;j=" . $db->job[$feat_jobs[0]]->attributes()->id; ?>">[read more]</a></p>
	</div>

<?php
for($i=0; $i<$n-1; $i++) {
	$j = $rand_jobs[$i];
	$item_str = "thumb third";
	if($i%3 <= 1) $item_str .= " spacer12";
	if($i%3 == 0) $item_str .= " break";
?>
	<div class="<?php echo $item_str; ?>">
		<p class="category"><?php echo $db->job[$j]->category; ?></p>
		<a href="<?php if($r) echo "job/" . $db->job[$j]->attributes()->id; else echo "?p=job&amp;j=" . $db->job[$j]->attributes()->id; ?>"><img src="images/<?php echo $db->job[$j]->attributes()->id; ?>_t.jpg" width="184" height="104" alt=""/></a>
		<h3><?php echo $db->job[$j]->title; ?></h3>
		<p><?php echo substr($db->job[$j]->description, 0, strpos($db->job[$j]->description, ". ")+1); ?></p>
		<p><a href="<?php if($r) echo "job/" . $db->job[$j]->attributes()->id; else echo "?p=job&amp;j=" . $db->job[$j]->attributes()->id; ?>">[read more]</a></p>
	</div>

<?php
}
?>
	<div class="break"></div>
</div>
