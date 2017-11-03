<?php
$details = $mb->_runFunction("catalog", "loadProduct", array(intval($_GET['productID'])));
?>

<ul class="breadcrumbs">
	<li><a href="/<?= _LANGUAGE_PACK ?>/">home</a></li>
	<li class="spacer">-</li>	
	<li>
		<strong>
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/details/<?= $details['productID'] ?>/<?= _createCategoryURL($details['name']) ?>.html"><?= strtolower($details['name']) ?></a>
		</strong>
	</li>
</ul>

<div class="page-content full-width">
	<div class="return-page">
		<span class="fa fa-long-arrow-left"></span>
		<?= $mb->_translateReturn("others", "previous-page") ?>
	</div>
	
	<div class="images">
		<?php
		$thumb = 0;
			
		foreach($details['images'] AS $media)
		{
			if($media['thumb'])
			{
				$thumb = $media['productMediaID'];
			}
			?>
			
			<img src="https://merchant.justinharings.nl/library/media/products/<?= $media['productMediaID'] ?>.png" />
			
			<?php
		}
		?>
	</div>
	
	<div class="image">
		<?php
		if($details['status'] > 1)
		{
			?>
			<div class="flag">
				<?php
				switch($details['status'])
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
		?>
		
		<img src="https://merchant.justinharings.nl/library/media/products/<?= $thumb ?>.png" />
	</div>
	
	<div class="follow-scroll">
		<div class="cart-info">
			<?php
			$name = $details['name'];
	
			if($details[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
			{
				$name = $details[strtoupper(_LANGUAGE_PACK) . '_name'];
			}
			?>
			
			<?= $details['brand'] ?><br/>
			<strong class="name"><?= $name ?></strong>
			<?= _createStockText($details['stock'], (isset($_GET['categoryID']) ? intval($_GET['categoryID']) : 0), $_GET['productID'], _LANGUAGE_PACK, $details['status']) ?>
			
			<?php
			if(count($details['review_stars']) > 0)
			{
				?>
				<div class="review-holder">
					<?php
					for($i = 1; $i <= 5; $i++)
					{
						?>
						<span class="fa review-star fa-<?= $details['review_stars'] >= $i ? "circle" : "circle-thin" ?>"></span>
						<?php
					}
					?>
					
					<span class="review-text">
						<a href="#">
							<?= count($details['reviews']) ?> review(s)
						</a>
					</span>
				</div>
				<?php
			}
			?>
			
			<strong class="price">
				<?php
				$adviced = $details['price_adviced'];
				$price = $details['price'];
				
				if($details[strtoupper(_LANGUAGE_PACK) . '_price'] > 0)
				{
					$adviced = $details[strtoupper(_LANGUAGE_PACK) . '_price_adviced'];
					$price = $details[strtoupper(_LANGUAGE_PACK) . '_price'];
				}
				
				if($adviced > 0)
				{
					print "<small>" . $_currencies_symbols[$_SESSION['currency']] . " " .$mb->replaceCurrency($adviced, $_SESSION['currency']) . "</small>";
				}
				
				print $_currencies_symbols[$_SESSION['currency']] . " " .$mb->replaceCurrency($price, $_SESSION['currency']);
				?>
			</strong>
			
			<?php
			if($details['status'] < 3)
			{
				?>
				<div class="button" productid="<?= $details['productID'] ?>">
					<?= $mb->_translateReturn("cart", "add-cart-button") ?>
				</div>
				<?php
			}
			?>
		</div>
	
		<div class="order-info">
			<ul>
				<?php
				if($mb->_translateReturn("product-details", "one"))
				{
					?>
					<li class="first"><?= $mb->_translateReturn("product-details", "one") ?></li>
					<?php
				}
				
				if($mb->_translateReturn("product-details", "two"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "two") ?></li>
					<?php
				}
				
				if($mb->_translateReturn("product-details", "three"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "three") ?></li>
					<?php
				}
				
				if($mb->_translateReturn("product-details", "four"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "four") ?></li>
					<?php
				}
				
				if($mb->_translateReturn("product-details", "five"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "five") ?></li>
					<?php
				}
				?>
			</ul>
		</div>
		
		<div class="order-info eco">
			<ul>
				<?php
				if($mb->_translateReturn("product-details", "six"))
				{
					?>
					<li class="first"><?= $mb->_translateReturn("product-details", "six") ?></li>
					<?php
				}
				
				if($mb->_translateReturn("product-details", "seven"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "seven") ?></li>
					<?php
				}
				
				if($mb->_translateReturn("product-details", "eight"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "eight") ?></li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
	
	<div class="description">
		<strong><?= $mb->_translateReturn("product-details", "description") ?></strong>
		<?php
		if(_LANGUAGE_PACK != "nl")
		{
			print "<u>" . $mb->_translateReturn("product-details", "description-only-dutch") . "</u><br/><br/>";
		}
		
		print nl2br($details['description']);
		?>
	</div>
	
	<div class="specifications">
		<strong><?= $mb->_translateReturn("product-details", "specifications") ?></strong>
		
		<table>
			<?php
			if($details['brand'] != "")
			{
				?>
				<tr>
					<td width="150"><?= $mb->_translateReturn("product-details", "specifications") ?></td>
					<td><?= $properties['value'] ?></td>
				</tr>
				<?php
			}
				
			foreach($details['products_properties'] AS $properties)
			{
				?>
				<tr>
					<td width="150"><?= $properties['key'] ?></td>
					<td><?= $properties['value'] ?></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
	
	<?php
	if(count($details['review_stars']) > 0)
	{
		?>
		<div class="reviews scrollto-reviews">
			<strong>
				<img src="/library/media/reviews.png" />
				<?= $mb->_translateReturn("product-details", "reviews") ?>
			</strong>
			
			
			<?php
			
			print "<hr/>";
			
			foreach($details['reviews'] AS $key => $review)
			{
				for($i = 1; $i <= 5; $i++)
				{
					?>
					<span class="fa review-star fa-<?= $review['stars'] >= $i ? "circle" : "circle-thin" ?>"></span>
					<?php
				}
				?>
				
				<strong class="header">
					<?= $review['name'] ?>
					
					<small>
						<?= $review['date_added'] ?>
						<?= $mb->_translateReturn("product-details", "oclock") ?>
					</small>
				</strong><br/>
				<br/>
				<span style="color: #d00000;"><?= ucfirst($review['country']) ?></span><br/>
				<?= $review['description'] ?>
				<hr/>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
</div>