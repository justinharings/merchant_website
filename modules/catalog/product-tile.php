<div class="product-container <?= $num == 0 ? "first" : "" ?>" click="/<?= _LANGUAGE_PACK ?>/catalog/<?= (isset($category['categoryID']) ? $category['categoryID'] . "/" . _createCategoryURL($category['en_name']) . "/" : "") ?>details/<?= $product['productID'] ?>/<?= _createCategoryURL($product['name']['nl']) ?>.html">		
	<?php
	if($product['status'] > 1)
	{
		?>
		<div class="flag">
			<?php
			switch($product['status'])
			{
				case 2:
					$mb->_translateReturn("stock-text", "sale");
				break;
				
				case 3:
					$mb->_translateReturn("stock-text", "temp-sold-out");
				break;
				
				case 4:
					$mb->_translateReturn("stock-text", "sold-out");
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
	
	<strong><?= $product['name']['nl'] ?></strong>
	
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
		<?= $product['price_adviced']['nl'] > 0 ? "<span class=\"adviced\">".$product['price_adviced']['nl']."</span>" : "" ?>
		<?= $product['price']['nl'] ?>
	</span>
</div>