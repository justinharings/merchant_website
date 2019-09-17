<?php
switch($_GET['catalog_name'])
{
	case "bicycles":
		$headCategory = 1;
	break;
	
	case "accessories":
		$headCategory = 4;
	break;
	
	case "parts":
		$headCategory = 44;
	break;
	
	case "webshop":
		$headCategory = 68;
	break;
	
	case "decoration":
		$headCategory = 85;
	break;
	
	case "furniture":
		$headCategory = 86;
	break;
	
	case "lights":
		$headCategory = 87;
	break;
	
	case "clothes":
		$headCategory = 88;
	break;
	
	case "dierenwinkel":
		$headCategory = 101;
	break;
	
	case "voeding-en-snacks":
		$headCategory = 231;
	break;
	
	case "pennen":
		$headCategory = 80;
	break;
	
	case "knuffels":
		$headCategory = 82;
	break;
	
	case "kleding":
		$headCategory = 83;
	break;
	
	case "draaiwerk":
		$headCategory = 81;
	break;
	
	default:
		?>
		<script type="text/javascript">
			window.location.href = '/<?= _LANGUAGE_PACK ?>/errors/404.html';
		</script>
		<?php
	break;
}

$category = $mb->_runFunction("catalog", "loadCatalog", array($categoryID));

$category_name = $category['name'];

if($category[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
{
	$category_name = $category[strtoupper(_LANGUAGE_PACK) . '_name'];
}

$first_tree = $mb->_runFunction("catalog", "loadCatalogTree", array($categoryID));

if(mysqli_num_rows($first_tree) == 0)
{
	?>
	<script type="text/javascript">
		document.location.href = '/<?= _LANGUAGE_PACK ?>/catalog/<?= $_GET['catalog_name'] ?>/<?= $categoryID ?>/filters/none/<?= $_GET['catalog_name'] ?>.html';
	</script>
	<?php
}

$banner_tile_1_1 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, $banner_prefix . "_tile_1"));
$banner_tile_1_2 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, $banner_prefix . "_tile_2"));
$banner_tile_1_3 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, $banner_prefix . "_tile_3"));
$banner_tile_1_4 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, $banner_prefix . "_tile_4"));

require_once(__DIR__ . "/splash.php");
?>

<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement":
		[
			{
				"@type": "ListItem",
				"position": 2,
				"item":
				{
					"@id": "https://www.haringstweewielers.com/<?= _LANGUAGE_PACK ?>/catalog/bicycles.html",
					"name": "<?= ucfirst($category_name) ?>"
				}
			}
		]
	}
</script>