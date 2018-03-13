<?php
$banner_large = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_large"));

$banner_fietsned = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_extra"));

$banner_small_1 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_small_1"));
$banner_small_2 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_small_2"));
$banner_small_3 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_small_3"));
$banner_small_4 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_small_4"));

$favorites = $mb->_runFunction("catalog", "viewFavorites", array());
?>

<div class="homepage">
	<div class="line-1">
		<img src="<?= $banner_large['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_large['url'] ?>" />
	</div>
	
	<div class="line-2">
		<img src="<?= $banner_small_1['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_small_1['url'] ?>" />
		<img src="<?= $banner_small_2['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_small_2['url'] ?>" />
		<img src="<?= $banner_small_3['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_small_3['url'] ?>" />
		<img src="<?= $banner_small_4['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_small_4['url'] ?>" />
	</div>
	
	<div class="line-3">
		<img src="<?= $banner_fietsned['image'] ?>" click="<?= $banner_fietsned['url'] ?>" />
	</div>
	
	<?php
	if($favorites[0]['name'])
	{
		?>
		<div class="line-4">
			<div class="title"><?= $mb->_translateReturn("homepage", "most_valued_products") ?></div>
			
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/details/<?= $favorites[0]['productID'] ?>/<?= _createCategoryURL($favorites[0]['name']) ?>.html">
				<div class="item first">
					<img src="<?= $favorites[0]['image'] ?>" /><br/>
					<?= $_currencies_symbols[$_SESSION['currency']] ?>&nbsp;<?= _frontend_float($mb->replaceCurrency($favorites[0]['price'], $_SESSION['currency']), $_SESSION['currency']) ?>
				</div>
			</a>
			
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/details/<?= $favorites[1]['productID'] ?>/<?= _createCategoryURL($favorites[1]['name']) ?>.html">
				<div class="item">
					<img src="<?= $favorites[1]['image'] ?>" /><br/>
					<?= $_currencies_symbols[$_SESSION['currency']] ?>&nbsp;<?= _frontend_float($mb->replaceCurrency($favorites[1]['price'], $_SESSION['currency']), $_SESSION['currency']) ?>
				</div>
			</a>
			
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/details/<?= $favorites[2]['productID'] ?>/<?= _createCategoryURL($favorites[2]['name']) ?>.html">
				<div class="item">
					<img src="<?= $favorites[2]['image'] ?>" /><br/>
					<?= $_currencies_symbols[$_SESSION['currency']] ?>&nbsp;<?= _frontend_float($mb->replaceCurrency($favorites[2]['price'], $_SESSION['currency']), $_SESSION['currency']) ?>
				</div>
			</a>
		</div>
		<?php
	}
	?>
</div>