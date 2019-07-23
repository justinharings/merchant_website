<?php
$string = $_GET['string'];
$string = $mb->real_escape_string($string);

$string = str_replace("-", " ", $string);
$string = str_replace("%20", " ", $string);
?>

<ul class="breadcrumbs">
	<li><a href="/<?= _LANGUAGE_PACK ?>/">home</a></li>
	<li class="spacer">-</li>
	<li>
		<strong>
			<a href="/<?= _LANGUAGE_PACK ?>/search/<?= $_GET['string'] ?>/"><?= $mb->_translateReturn("website_text", "search_results", array($string)) ?></a>
		</strong>
	</li>
</ul>

<div class="page-menu">
	<? require_once($_SERVER['DOCUMENT_ROOT'] . "/database/" . _DATABASE_FOLDER . "/library/menus/side_menu.php") ?>
</div>

<div class="page-content">
	<?php
	$products = $mb->_runFunction("catalog", "loadProducts", array(0, $string));
	
	$num = 0;
	$total = 0;
	
	if(count($products) > 0)
	{
		foreach($products AS $key => $product)
		{
			$product['name'] = unserialize($product['name']);
			$product['price'] = unserialize($product['price']);
			$product['price_adviced'] = unserialize($product['price_adviced']);
			$product['filters'] = unserialize($product['filters']);
			
			require(__DIR__ . "/product-tile.php");
			
			if($num == 2)
			{
				$num = 0;
			}
			
			$num++;
			$total++;
		}
	}
	
	if($total == 1)
	{
		?>
		<script type="text/javascript">
			document.location.href = '/<?= _LANGUAGE_PACK ?>/catalog/details/<?= $product['productID'] ?>/<?= _createCategoryURL($product['name'][strtolower(_LANGUAGE_PACK)]) ?>.html';
		</script>
		<?php
	} else if($num == 0)
	{
		?>
		<div class="no-results">
			<span class="fa fa-frown-o"></span>
			<?= $mb->_translateReturn("others", "view-no-results") ?>
		</div>
		<?php
	}
	?>
</div>

<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement":
		[
			{
				"@type": "ListItem",
				"position": 2,
				"item":
				{
					"@id": "https://www.haringstweewielers.com/<?= _LANGUAGE_PACK ?>/search/<?= $_GET['string'] ?>/",
					"name": "<?= $mb->_translateReturn("website_text", "search_results", array($string)) ?>"
				}
			}
		]
	}
</script>