			<section>
				<pre>
<?php
echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";

$browser = get_browser(null, true);

print_r($browser);

print_r($valid_pages);

print_r($db);
//echo displayChildrenRecursive($db->job, 3);
?>
				</pre>
			</section>
