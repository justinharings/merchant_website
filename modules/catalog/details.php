<?php
$details = $mb->_runFunction("catalog", "loadProduct", array(intval($_GET['productID'])));

$name = $details['name'];

if($details[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
{
	$name = $details[strtoupper(_LANGUAGE_PACK) . '_name'];
}

$breadcrumb = "";

if(isset($_GET['categoryID']))
{
	$category = $mb->_runFunction("catalog", "loadCatalog", array(intval($_GET['categoryID'])));
	$headCategory = $mb->_runFunction("catalog", "loadCatalog", array(intval($category['parentID'])));
	$headCategory = $mb->_runFunction("catalog", "loadCatalog", array(intval($headCategory['parentID'])));
}

if($details['deleted'] == 1)
{
	$details['status'] = 4;
}
?>

<ul class="breadcrumbs">
	<li><a href="/<?= _LANGUAGE_PACK ?>/">home</a></li>
	
	<?php
	$headName = strtolower($headCategory[(_LANGUAGE_PACK != "nl" ? strtoupper(_LANGUAGE_PACK) . "_" : "") . 'name']);
	
	if(isset($_GET['categoryID']) && $headName != "")
	{
		?>
		<li class="spacer">-</li>
		
		<li>
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>.html">
				<?= $headName ?>
			</a>
		</li>
		<?php
	}
	?>
	
	<li class="spacer">-</li>
	<li>
		<?php
		if(isset($_GET['categoryID']))
		{
			?>
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>/<?= $_GET['categoryID'] ?>/filters/none/<?= _createCategoryURL($category['EN_name']) ?>.html">
				<?= strtolower($category[(_LANGUAGE_PACK != "nl" ? strtoupper(_LANGUAGE_PACK) . "_" : "") . 'name']) ?>
			</a>
			<?php
		}
		else
		{
			print "zoekresultaten";
		}
		?>
	</li>
	<li class="spacer">-</li>
	<li>
		<strong>
			<?php
			$extra_breadcrumb = "";
				
			if(isset($_GET['categoryID']))
			{
				$extra_breadcrumb = $_GET['categoryID'] . "/" . _createCategoryURL($category['EN_name']) . "/";
			}
			?>
			
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= $extra_breadcrumb ?>details/<?= $details['productID'] ?>/<?= _createCategoryURL($details['name']) ?>.html"><?= strtolower($name) ?></a>
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
			
		if(count($details['images']))
		{
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
		}
		else
		{
			?>
			<img src="/library/media/no-image.png" />
			<?php
		}
		
		if(count($details['videos']) > 0)
		{
			foreach($details['videos'] AS $video)
			{
				?>
				<a href="<?= $video['url'] ?>" data-lity>
					<img src="/library/media/video-image.png" />
				</a>
				<?php
			}
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
		
		if(!$thumb)
		{
			$thumb = "/library/media/no-image.png";
		}
		else
		{
			$thumb = "https://merchant.justinharings.nl/library/media/products/" . $thumb . ".png";
		}
		?>
		
		<img itemprop="image" src="<?= $thumb ?>" />
	</div>
	
	<div class="follow-scroll">
		<?php
		if($details['core_product'])
		{
			?>
			<div class="core-collection">
				<span class="fa fa-bullseye"></span>
				<?= $mb->_translateReturn("website_text", "core_product") ?>
			</div>
			<?php
		}
		?>
		
		<div class="cart-info">
			<?= $details['brand'] != "" ? $details['brand'] . "<br/>" : "" ?>
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
					<meta itemprop="worstRating" content="1">
					<span itemprop="ratingValue"><?= ($details['review_stars']/2) ?></span>
					<meta itemprop="bestRating" content="5">
					<span itemprop="reviewCount"><?= count($details['reviews']) ?></span>
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
				<div class="button" productid="<?= $details['productID'] ?>" style="background-color: <?= $mb->_translateReturn("colors", "main_color") ?>;">
					<?= $mb->_translateReturn("cart", "add-cart-button") ?>
				</div>
				<?php
			}
			?>
		</div>
	
		<?php
		if($mb->_translateReturn("product-details", "call-me-button") != "")
		{
			?>
			<div class="call-me">
				<?= $mb->_translateReturn("product-details", "call-me") ?>
				
				<?php
				if(!isset($_SESSION['callback']))
				{
					?>
					<form id="callback" method="post" action="/library/php/posts/callback.php">
						<input type="text" name="phone_number" id="phone_number" value="" placeholder="<?= $mb->_translateReturn("product-details", "call-me-text") ?>" autocomplete="off" />
						
						<input type="hidden" name="productID" id="productID" value="<?= $details['productID'] ?>" />
						<input type="hidden" name="returnURL" id="returnURL" value="<?= $actual_link ?>" />
						
						<div class="button" onclick="submitCallme();">
							<?= $mb->_translateReturn("product-details", "call-me-button") ?>
						</div>
					</form>
					<?php
				}
				else
				{
					?>
					<div class="button disabled">
						<?= $mb->_translateReturn("product-details", "call-me-done") ?>
					</div>
					<?php
				}
				?>
			</div>	
			<?php
		}
		?>
	
		<div class="order-info first" style="background-color: <?= $mb->_translateReturn("colors", "secundary_color") ?>;">
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
				
				if($mb->_translateReturn("product-details", "six"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "six") ?></li>
					<?php
				}
				?>
			</ul>
		</div>
		
		<div class="order-info eco">
			<ul>
				<?php
				if($mb->_translateReturn("product-details", "seven"))
				{
					?>
					<li class="first"><?= $mb->_translateReturn("product-details", "seven") ?></li>
					<?php
				}
				
				if($mb->_translateReturn("product-details", "eight"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "eight") ?></li>
					<?php
				}
				
				if($mb->_translateReturn("product-details", "nine"))
				{
					?>
					<li><?= $mb->_translateReturn("product-details", "nine") ?></li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
	
	<?php
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
				?>
				<div itemprop="review" itemscope itemtype="http://schema.org/Review">
					<?php
					for($i = 1; $i <= 5; $i++)
					{
						?>
						<span class="fa review-star fa-<?= $review['stars'] >= $i ? "circle" : "circle-thin" ?>"></span>
						<?php
					}
					?>
					
					<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" style="display: none;">
						<meta itemprop="worstRating" content="1">
						<meta itemprop="ratingValue" content="<?= $review['stars'] ?>">
						<meta itemprop="bestRating" content="5">
					</div>
					
					<strong class="header">
						<span itemprop="author"><?= $review['name'] ?></span>
						
						<small>
							<meta itemprop="datePublished" content="<?= $review['date_added_raw'] ?>">
							<?= $review['date_added'] ?>
							<?= $mb->_translateReturn("product-details", "oclock") ?>
						</small>
					</strong><br/>
					<br/>
					<span style="color: #d00000;"><?= ucfirst($review['country']) ?></span><br/>
					<span class="review-description" itemprop="description"><?= $review['description'] ?></span>
					<hr/>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
</div>

<link href="/library/third-party/lity/dist/lity.css" rel="stylesheet">
<script src="/library/third-party/lity/vendor/jquery.js"></script>
<script src="/library/third-party/lity/dist/lity.js"></script>

<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement":
		[
			<?php
			if(isset($_GET['categoryID']))
			{
				?>
				{
					"@type": "ListItem",
					"position": 2,
					"item":
					{
						"@id": "https://www.haringstweewielers.com/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>.html",
						"name": "<?= strtolower($headCategory[(_LANGUAGE_PACK != "nl" ? strtoupper(_LANGUAGE_PACK) . "_" : "") . 'name']) ?>"
					}
				},
				{
					"@type": "ListItem",
					"position": 3,
					"item":
					{
						"@id": "https://www.haringstweewielers.com/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>/<?= $_GET['categoryID'] ?>/filters/none/<?= _createCategoryURL($category['EN_name']) ?>.html",
						"name": "<?= strtolower($category[(_LANGUAGE_PACK != "nl" ? strtoupper(_LANGUAGE_PACK) . "_" : "") . 'name']) ?>"
					}
				},
				{
					"@type": "ListItem",
					"position": 4,
					"item":
					{
						"@id": "https://www.haringstweewielers.com/<?= _LANGUAGE_PACK ?>/catalog/<?= $extra_breadcrumb ?>details/<?= $details['productID'] ?>/<?= _createCategoryURL($details['name']) ?>.html",
						"name": "<?= strtolower($name) ?>"
					}
				}
				<?php
			}
			else
			{
				?>
				{
					"@type": "ListItem",
					"position": 2,
					"item":
					{
						"@id": "https://www.haringstweewielers.com/<?= _LANGUAGE_PACK ?>/catalog/<?= $extra_breadcrumb ?>details/<?= $details['productID'] ?>/<?= _createCategoryURL($details['name']) ?>.html",
						"name": "<?= strtolower($name) ?>"
					}
				}
				<?php
			}
			?>
		]
	}
</script>

