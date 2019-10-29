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
		<link rel='icon' href='images/favicon.png' type='image/png'/>

		<title><?php getPageTitle($rootpage, $subpage, $query); ?></title>
	</head>

	<body>
		<div class='page'>

<?php createMenu($p); ?>

<?php includePage($p); ?>

			<footer class='footer-wrapper'>
				<div class='footer'>
					<div class='social-icons'>
						<a href='mailto:mike@mb3d.xyz'><img src='images/icon-email-grey.png' width='32' alt='Email icon'/></a>
						<a href='https://vimeo.com/mjbonnington' target='_blank'><img src='images/icon-vimeo-grey.png' width='32' alt='Vimeo icon'/></a>
						<a href='https://www.linkedin.com/in/mjbonnington/' target='_blank'><img src='images/icon-linkedin-grey.png' width='32' alt='LinkedIn icon'/></a>
					</div>
					<div class='colophon'>
						<p><b>mb3d.xyz</b> is the website of Michael Bonnington, a London-based visual effects artist and technologist.</p>
						<p>Site design and development by Michael Bonnington.</p>
						<!-- <?php createFooterLinks($db->page); ?> -->
					</div>
					<div class='copyright'>
						<p>&copy; MMXIX</p>
					</div>
				</div>
			</footer>

		</div>
	</body>
</html>
