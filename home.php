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
<div class="section break">
	<p class="body">Welcome to my website. I am a London-based freelance CG artist specialising in 3D modelling, design and animation.</p>
</div>

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
