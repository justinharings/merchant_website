<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= (isset($category['categoryID']) ? $category['categoryID'] . "/" . _createCategoryURL($category['EN_name']) . "/" : "") ?>details/<?= $product['productID'] ?>/<?= _createCategoryURL($product['name']['nl']) ?>.html">
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
		
		<strong><?= strip_tags($name) ?></strong>
		
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
		
		<span class="price">
			<?php
			$adviced = $product['price_adviced']['nl'];
			$price = $product['price']['nl'];
				
			if($product['price'][strtolower(_LANGUAGE_PACK)] > 0)
			{
				$adviced = $product['price_adviced'][strtolower(_LANGUAGE_PACK)];
				$price = $product['price'][strtolower(_LANGUAGE_PACK)];
			}
			
			if($adviced > 0)
			{
				print "<span class=\"adviced\">" . $_currencies_symbols[$_SESSION['currency']] . " " . _frontend_float($mb->replaceCurrency($adviced, $_SESSION['currency']), $_SESSION['currency']) . "</span>&nbsp;";
			}
			
			print $_currencies_symbols[$_SESSION['currency']] . " " . _frontend_float($mb->replaceCurrency($price, $_SESSION['currency']), $_SESSION['currency']);
			?>
		</span>
	</div>
</a>