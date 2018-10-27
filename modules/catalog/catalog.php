<?php
switch($_GET['catalog_name'])
{
	case "bicycles":
		$categoryID = 1;
		$banner_prefix = "fietsen";
	break;
	
	case "accessories":
		$categoryID = 4;
		$banner_prefix = "accessoires";
	break;
	
	case "parts":
		$categoryID = 44;
		$banner_prefix = "onderdelen";
	break;
	
	case "pennen":
		$categoryID = 1;
		$banner_prefix = "fietsen";
	break;
	
	case "decoration":
		$categoryID = 85;
		$banner_prefix = "decoratie";
	break;
	
	case "furniture":
		$categoryID = 86;
		$banner_prefix = "meubelen";
	break;
	
	case "lights":
		$categoryID = 87;
		$banner_prefix = "verlichting";
	break;
	
	case "clothes":
		$categoryID = 88;
		$banner_prefix = "kleden";
	break;
	
	case "dierenwinkel":
		$categoryID = 101;
		$banner_prefix = "dierenwinkel";
	break;
	
	case "webshop":
		$categoryID = 68;
		$banner_prefix = "webshop";
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