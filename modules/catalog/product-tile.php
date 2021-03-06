<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= (isset($category['categoryID']) ? $category['categoryID'] . "/" . _createCategoryURL($category[(_LANGUAGE_PACK != "nl" ? strtoupper(_LANGUAGE_PACK) . "_" : "") . 'name']) . "/" : "") ?>details/<?= $product['productID'] ?>/<?= _createCategoryURL($product['name'][strtolower(_LANGUAGE_PACK)]) ?>.html">
	<div class="product-container <?= $num == 0 ? "first" : "" ?>">		
		<?php
		if($product['status'] > 1)
		{
			?>
			<div class="flag">
				<?php
				switch($product['status'])
				{
					case 2:
						print $mb->_translateReturn("stock-text", "sale");
					break;
					
					case 3:
						print $mb->_translateReturn("stock-text", "temp-sold-out");
					break;
					
					case 4:
						print $mb->_translateReturn("stock-text", "sold-out");
					break;
				}
				?>
			</div>
			<?php
		}
		
		if($product['status'] == 4)
		{
			?>
			<div class="soldout"></div>
			<?php
		}
		?>
		
		<div class="img-holder">
			<img src="<?= $product['image'] != "" ? $product['image'] : "/library/media/no-image.png" ?>" />
		</div>
		
		<?php
		$name = $product['name']['nl'];
		
		if($product['name'][_LANGUAGE_PACK] != "")
		{
			$name = $product['name'][_LANGUAGE_PACK];
		}
		?>
		
		<br/>
		<strong><?= strip_tags($name) ?></strong>
		
		<?php
		if($settings['hide_reviews'] == 0)
		{
			?>
			<div class="stars">
				<?php
				if($product['review_stars'] > 0)
				{
					for($i = 1; $i <= 5; $i++)
					{
						?>
						<span class="fa fa-<?= $product['review_stars'] >= $i ? "circle" : "circle-thin" ?>"></span>
						<?php
					}
				}
				else
				{
					?>
					<span class="fa"></span>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
		
		<span class="price">
			<?php
			$adviced = $product['price_adviced']['nl'];
			$price = $product['price']['nl'];
			
			if($adviced > 0)
			{
				print "<span class=\"adviced\">" . $_currencies_symbols[$_SESSION['currency']] . " " . _frontend_float($mb->replaceCurrency($adviced, $_SESSION['currency']), $_SESSION['currency']) . "</span>&nbsp;";
			}
			
			print $_currencies_symbols[$_SESSION['currency']] . " " . _frontend_float($mb->replaceCurrency($price, $_SESSION['currency']), $_SESSION['currency']);
			?>
		</span>
		
		<span class="stock <?= ($product['stock'] > 0 || $product['stock_type'] == 7 ? "green" : ($product['status'] > 2 ? "red" : "orange")) ?>">
			<?= _createStockText($product['stock'], (isset($_GET['categoryID']) ? intval($_GET['categoryID']) : 0), $product['productID'], _LANGUAGE_PACK, $product['status'], true) ?>
		</span>
	</div>
</a>