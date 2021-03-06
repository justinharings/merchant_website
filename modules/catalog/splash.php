<ul class="breadcrumbs">
	<li><a href="/<?= _LANGUAGE_PACK ?>/">home</a></li>
	<li class="spacer">-</li>
	<li>
		<strong>
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= $_GET['page'] ?>.html"><?= strtolower($category_name) ?></a>
		</strong>
	</li>
</ul>

<div class="page-menu">
	<ul class="head catalog">
		<?php
		foreach($first_tree AS $key => $first)
		{
			if($first['active'] == 0)
			{
				continue;
			}
			
			$sub = $mb->_runFunction("catalog", "loadCatalogTree", array($first['categoryID']));
			
			$name = $first['name'];
			
			if($first[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
			{
				$name = $first[strtoupper(_LANGUAGE_PACK) . '_name'];
			}
			?>
			<li>
				<strong><?= $name ?></strong>
				
				<?php
				if($sub)
				{
					?>
					<ul>
						<?php
						foreach($sub AS $key => $second)
						{
							if($second['active'] == 0)
							{
								continue;
							}
							
							$name = $second['name'];
			
							if($second[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
							{
								$name = $second[strtoupper(_LANGUAGE_PACK) . '_name'];
							}
							
							?>
							<li>
								<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= $_GET['catalog_name'] ?>/<?= $second['categoryID'] ?>/filters/none/<?= _createCategoryURL($second['EN_name']) ?>.html">
									<?= $name ?>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
					<?php
				}
				?>
			</li>
			<?php
		}
		?>
	</ul>
</div>

<div class="page-content">
	<div class="tile-row-1">
		<div class="tile-1">
			<img src="<?= $banner_tile_1_1['image'] ?>?rand=<?= rand(0,99999) ?>" onclick="<?= ($banner_tile_1_1['url'] ? "document.location.href='" . $banner_tile_1_1['url'] . "'" : '') ?>" />
		</div>
		
		<div class="tile-2">
			<img src="<?= $banner_tile_1_2['image'] ?>?rand=<?= rand(0,99999) ?>" onclick="<?= ($banner_tile_1_2['url'] ? "document.location.href='" . $banner_tile_1_2['url'] . "'" : '') ?>" />
		</div>
		
		<div class="tile-3">
			<img src="<?= $banner_tile_1_3['image'] ?>?rand=<?= rand(0,99999) ?>" onclick="<?= ($banner_tile_1_3['url'] ? "document.location.href='" . $banner_tile_1_3['url'] . "'" : '') ?>" />
		</div>
		
		<?php
		if($banner_tile_1_4['image'] != "")
		{
			?>
			<div class="tile-4">
				<img src="<?= $banner_tile_1_4['image'] ?>?rand=<?= rand(0,99999) ?>" onclick="<?= ($banner_tile_1_4['url'] ? "document.location.href='" . $banner_tile_1_4['url'] . "'" : '') ?>" />
			</div>
			<?php
		}
		?>
	</div>
</div>