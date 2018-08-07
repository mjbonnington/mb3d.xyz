<?php
session_start();

require_once("php/mjb-cms.inc");
//require_once("php/menu.inc");

// Set some variables so we know which page we're on...
$page_path = explode("_", $p, 2);
$rootpage = $db->xpath("//page[@id='" . $page_path[0] . "']");
$subpage = $db->xpath("//subpage[@id='" . $page_path[1] . "']");
$query = $db->xpath("//*[@id='" . $q . "']");

//if($page_path[0] == "job") $page_key = getRef(getReferer($valid_pages), $db->pages->page); // if we're on the 'job' page, get the key of the referring page, so the menu doesn't update
//else $page_key = getRef($page_path[0], $db->pages->page); // otherwise get the key (number) of the current page
//if($page_key == null) $page_key = 0;

if($page_path[0] != "job") $_SESSION["prev_page_key"] = $page_path[0];
$page_key = getRef($_SESSION["prev_page_key"], $db->pages->page);
?>
<!DOCTYPE html>
<html lang='en'>

<head>
	<meta charset='UTF-8'/>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
	<link rel='stylesheet' href='style.css'/>
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:300,400,700'>

<?php getMetaTags(); ?>

	<title><?php getPageTitle($rootpage, $subpage, $query); ?></title>
</head>

<body>
	<div class='row'>
		<div class='col-12 col-s-12 header'>
			<a id='logo' href='<?php echo ($r) ? "/" : "index.php"; ?>'><span><?php getTitle(); ?></span></a>
		</div>
	</div>

<?php includePage($p); ?>

	<div class='row'>
		<div class='col-12 col-s-12 footer'>
			<p>&copy; <?php echo $today["year"] . " "; getTitle(); createFooterLinks($db->pages->page); ?></p>
		</div>
	</div>
</body>

</html>
