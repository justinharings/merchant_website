<?php
$banner_large = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_large"));

$banner_extra = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_extra"));

$banner_small_1 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_small_1"));
$banner_small_2 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_small_2"));
$banner_small_3 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_small_3"));
$banner_small_4 = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "home_small_4"));

$favorites = $mb->_runFunction("catalog", "viewFavorites", array());
?>

<div class="homepage">
	<?php
	if($banner_large['image'] != "")
	{
		?>
		<div class="line-1">
			<img src="<?= $banner_large['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_large['url'] ?>" />
		</div>
		<?php
	}
	
	if	(
			$banner_small_1['image'] != ""
			&& $banner_small_2['image'] != ""
			&& $banner_small_3['image'] != ""
			&& $banner_small_4['image'] != ""
		)
	{
		?>
		<div class="line-2">
			<img src="<?= $banner_small_1['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_small_1['url'] ?>" />
			<img src="<?= $banner_small_2['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_small_2['url'] ?>" />
			<img src="<?= $banner_small_3['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_small_3['url'] ?>" />
			<img src="<?= $banner_small_4['image'] ?>?rand=<?= rand(0,99999) ?>" click="<?= $banner_small_4['url'] ?>" />
		</div>
		<?php
	}
	
	if($banner_extra['image'] != "")
	{
		?>
		<div class="line-3">
			<img src="<?= $banner_extra['image'] ?>" click="<?= $banner_extra['url'] ?>" />
		</div>
		<?php
	}
	
	if($favorites[0]['name'] != "")
	{
		?>
		<div class="line-4">
			<div class="title"><?= $mb->_translateReturn("homepage", "most_valued_products") ?></div>
			
			<?php
			$column = 3;
			$row = 1;
			
			for($i = 0; $i < 9; $i++)
			{
				if($favorites[$i]['name'] != "")
				{
					?>
					<a href="/<?= _LANGUAGE_PACK ?>/catalog/details/<?= $favorites[$i]['productID'] ?>/<?= _createCategoryURL($favorites[$i]['name']) ?>.html">
						<div class="item <?= $i == 0 ? "first" : "" ?> <?= $row > 1 ? "top-line" : "" ?>">
							<img src="<?= $favorites[$i]['image'] ?>" /><br/>
							<?= $_currencies_symbols[$_SESSION['currency']] ?>&nbsp;<?= _frontend_float($mb->replaceCurrency($favorites[$i]['price'], $_SESSION['currency']), $_SESSION['currency']) ?>
						</div>
					</a>
					<?php
				
					$column--;
				}
				
				if($column == 0)
				{
					$column = 3;
					$row++;
				}
			}
			?>
		</div>
		<?php
	}
	?>
</div>