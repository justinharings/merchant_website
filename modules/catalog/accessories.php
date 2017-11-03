<?php
$categoryID = 4;
$banner_prefix = "accessoires";

$category = $mb->_runFunction("catalog", "loadCatalog", array($categoryID));

$category_name = $category['name'];

if($category[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
{
	$category_name = $category[strtoupper(_LANGUAGE_PACK) . '_name'];
}

$first_tree = $mb->_runFunction("catalog", "loadCatalogTree", array($categoryID));

$banner_tile_1_1 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, $banner_prefix . "_tile_1"));
$banner_tile_1_2 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, $banner_prefix . "_tile_2"));
$banner_tile_1_3 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, $banner_prefix . "_tile_3"));
$banner_tile_1_4 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, $banner_prefix . "_tile_4"));

require_once(__DIR__ . "/splash.php");
?>