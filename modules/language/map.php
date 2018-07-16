<?php
define("_DEVELOPMENT_ENVIRONMENT", false);
define("_LANGUAGE_PACK", "nl");
	
require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");

$mb = new main_board();
$background = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "language_background"));
$background = $background['image'];

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
		<title>Please select your language to continue ...</title>
		
		<meta name="google-site-verification" content="B39UOVeOwQd0ZBlZrfm-NSmb10n3XQUM6wEGC647JH0" />
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="en" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
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
		<div class="map-background" style="background-image: url('<?= $background ?>?rand=<?= rand(0,99999) ?>')"></div>
		
		<div class="map-block">
			<?= $mb->_translateReturn("language_page", "title") ?>
			
			<p><?= $mb->_translateReturn("language_page", "text") ?></p>
			
			<select name="language" onchange="if (this.value) window.location.href=this.value" style="background-color: #fff;">
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
	</body>
</html>	