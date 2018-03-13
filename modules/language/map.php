<?php
define("_DEVELOPMENT_ENVIRONMENT", false);
define("_LANGUAGE_PACK", "nl");
	
require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");

$mb = new main_board();
$banner = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "map"));

$_found_languages = array();

if($handle = opendir($_SERVER['DOCUMENT_ROOT'] . '/library/languages/')) 
{
    while(false !== ($entry = readdir($handle))) 
    {
	    if($entry == "." || $entry == ".." || is_dir($entry))
	    {
		    continue;
		}
	    
	    $entry = str_replace(".xml", "", $entry);
	    
	    if(in_array($entry, $_language_keys))
	    {
	        $_found_languages[] = $entry;
	    }
    }

    closedir($handle);
}

asort($_found_languages);

$xml = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/library/languages/" . strtolower($_found_languages[0]) . ".xml");
$xml = simplexml_load_string($xml);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Please select your language to continue</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="en" />
		
		<meta name="robots" content="index, follow" />
		<meta name="description" content="We're the largest online retailer for quality Dutch bicycles in Europe. Please choose your language to continue!" />
		<meta name="keywords" content="duch, bicycles, europe, language" />
		
		<link type="image/x-icon" rel="icon" href="/library/media/<?= $xml->images->favicon ?>" />
		<link type="image/x-icon" rel="shortcut icon" href="/library/media/<?= $xml->images->favicon ?>" />
		
		<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="/library/css/motherboard.minified.css" />

		<script type="text/javascript" src="//code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript" src="/library/js/motherboard.minified.js"></script>
	</head>

	<body>
		<div class="map-background"></div>
		
		<div class="map-block">
			Select your language
			
			<p>We're shipping Dutch quality bicycles to every country in the world. Select your language to start browsing our catalog.</p>
			
			<select name="language" onchange="if (this.value) window.location.href=this.value">
				<option value=""></option>
				<?php
				foreach($_found_languages AS $abbreviation)
				{
					$xml = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/library/languages/" . strtolower($abbreviation) . ".xml");
					$xml = simplexml_load_string($xml);
					?>
					<option value="/<?= $abbreviation ?>/"><?= $xml->info->full_name ?></option>
					<?php
				}
				?>
			</select>
		</div>
		
		<!--
		<div class="header">
			<div class="container">
				<div class="header-content">
					<img class="logo" src="/library/media/map.png" />
					<img class="expert" src="/library/media/map_expert.png" />
					<img class="map" src="/library/media/map_world.png" />
				</div>
			</div>
		</div>
		
		<div class="content">
			<div class="container">
				<p class="map">Please select your preferred language to continue...</p>
				
				<?php
				foreach($_found_languages AS $abbreviation)
				{
					$xml = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/library/languages/" . strtolower($abbreviation) . ".xml");
					$xml = simplexml_load_string($xml);
					?>
					
					<a href="/<?= $abbreviation ?>/">
						<div class="lang-item">
							<?= $xml->info->full_name ?>
						</div>
					</a>
					
					<?php
				}
				
				if($banner != "" && count($banner) > 0)
				{
					?>
					<img class="map-banner" src="<?= $banner['image'] ?>" />
					<?php
				}
				?>
			</div>
		</div>
		-->
	</body>
</html>	