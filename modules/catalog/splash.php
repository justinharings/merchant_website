<ul class="breadcrumbs">
	<li><a href="/<?= _LANGUAGE_PACK ?>/">home</a></li>
	<li class="spacer">-</li>
	<li>
		<strong>
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= $_GET['page'] ?>.html"><?= strtolower($category['name']) ?></a>
		</strong>
	</li>
</ul>

<div class="page-menu">
	<ul>
		<?php
		foreach($first_tree AS $key => $first)
		{
			$sub = $mb->_runFunction("catalog", "loadCatalogTree", array($first['categoryID']));
			
			?>
			<li>
				<strong><?= $first['name'] ?></strong>
				
				<?php
				if($sub)
				{
					?>
					<ul>
						<?php
						foreach($sub AS $key => $second)
						{
							?>
							<li>
								<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= $_GET['page'] ?>/<?= $second['categoryID'] ?>/filters/none/<?= _createCategoryURL($second['en_name']) ?>.html">
									<?= $second['name'] ?>
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
			<img src="<?= $banner_tile_1_1['image'] ?>" onclick="<?= ($banner_tile_1_1['url'] ? "document.location.href='" . $banner_tile_1_1['url'] . "'" : '') ?>" />
		</div>
		
		<div class="tile-2">
			<img src="<?= $banner_tile_1_2['image'] ?>" onclick="<?= ($banner_tile_1_2['url'] ? "document.location.href='" . $banner_tile_1_2['url'] . "'" : '') ?>" />
		</div>
		
		<div class="tile-3">
			<img src="<?= $banner_tile_1_3['image'] ?>" onclick="<?= ($banner_tile_1_3['url'] ? "document.location.href='" . $banner_tile_1_3['url'] . "'" : '') ?>" />
		</div>
		
		<div class="tile-4">
			<img src="<?= $banner_tile_1_4['image'] ?>" onclick="<?= ($banner_tile_1_4['url'] ? "document.location.href='" . $banner_tile_1_4['url'] . "'" : '') ?>" />
		</div>
	</div>
</div>