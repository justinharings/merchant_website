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

<div class="page-content full-width" itemscope itemtype="http://schema.org/Product">
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
		
		<img itemprop="image" src="https://merchant.justinharings.nl/library/media/products/<?= $thumb ?>.png" />
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
			<strong class="name">
				<span itemprop="name">
					<?= $name ?>
				</span>
			</strong>
			<?= _createStockText($details['stock'], (isset($_GET['categoryID']) ? intval($_GET['categoryID']) : 0), $_GET['productID'], _LANGUAGE_PACK, $details['status']) ?>
			
			<?php
			if(count($details['review_stars']) > 0)
			{
				?>
				<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" style="display: none;">
					<span itemprop="ratingValue"><?= $details['review_stars'] ?></span>
					<span itemprop="ratingCount"><?= count($details['reviews']) ?></span>
				</span>
				
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
					print "<small>" . $_currencies_symbols[$_SESSION['currency']] . " " . _frontend_float($mb->replaceCurrency($adviced, $_SESSION['currency']), $_SESSION['currency']) . "</small>";
				}
				
				print $_currencies_symbols[$_SESSION['currency']] . " " . _frontend_float($mb->replaceCurrency($price, $_SESSION['currency']), $_SESSION['currency']);
				?>
				
				<span itemprop="offers" itemscope itemtype="http://schema.org/Offer" style="display: none;">
					<meta itemprop="priceCurrency" content="<?= $_SESSION['currency'] ?>" />
					<span itemprop="price"><?= $mb->replaceCurrency($price, $_SESSION['currency']) ?></span>
					<link itemprop="itemCondition" href="http://schema.org/NewCondition" />
					
					<?php
					$stock = "InStock";
					
					if($details['stock'] < 1)
					{
						if($details['externalStock'] > 0)
						{
							$stock = "LimitedAvailability";
						}
						else
						{
							switch($details['status'])
							{
								default:
									$stock = "LimitedAvailability";
								break;
								
								case 3:
									$stock = "OutOfStock";
								break;
								
								case 4:
									$stock = "SoldOut";
								break;
							}
						}
					}
					?>
					
					<link itemprop="availability" href="http://schema.org/<?= $stock ?>" />
				</span>
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
	
	<?php
	if(count($details['videos']) > 0)
	{
		?>
		<div class="description">
			<strong>Video's</strong>
			
			<?php
			foreach($details['videos'] AS $video)
			{
				?>
				<a href="<?= $video['url'] ?>" target="_blank">
					<div class="video-tile">
						<span class="fa fa-youtube-play"></span>
					</div>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}
	
	if($details['description'] != "")
	{
		?>
		<div class="description">
			<strong><?= $mb->_translateReturn("product-details", "description") ?></strong>
			<?php
			if(_LANGUAGE_PACK != "nl")
			{
				print "<u>" . $mb->_translateReturn("product-details", "description-only-dutch") . "</u><br/><br/>";
			}
			?>
			
			<span itemprop="description">
				<?= nl2br($details['description']) ?>
			</span>
		</div>
		<?php
	}
	?>
	
	<div class="specifications">
		<strong><?= $mb->_translateReturn("product-details", "specifications") ?></strong>
		
		<table>
			<?php
			if($details['brand'] != "")
			{
				?>
				<tr>
					<td width="170"><?= $mb->_translateReturn("product-details", "brand") ?></td>
					<td><span itemprop="brand"><?= $details['brand'] ?></span></td>
				</tr>
				<?php
			}
			
			?>
			<tr>
				<td width="170"><?= $mb->_translateReturn("product-details", "article-code") ?></td>
				<td><?= $details['article_code'] ?></td>
			</tr>
			<?php
			
			if($details['barcode'] != "")
			{
				?>
				<tr>
					<td width="170"><?= $mb->_translateReturn("product-details", "ean-code") ?></td>
					<td><?= $details['barcode'] ?></td>
				</tr>
				<?php
			}
			
			if($details['supplier_code'] != "" && $details['barcode'] != $details['supplier_code'])
			{
				?>
				<tr>
					<td width="170"><?= $mb->_translateReturn("product-details", "supplier-code") ?></td>
					<td><?= $details['supplier_code'] ?></td>
				</tr>
				<?php
			}
			
			?>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<?php
			
			foreach($details['products_properties'] AS $properties)
			{
				if($properties['language'] != _LANGUAGE_PACK && $properties['language'] != strtoupper(_LANGUAGE_PACK))
				{
					continue;
				}
				?>
				
				<tr>
					<td width="170"><?= $properties['key'] ?></td>
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