<?php
$string = $_GET['string'];
$string = $mb->real_escape_string($string);

$string = str_replace("-", " ", $string);
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
	<? require_once($_SERVER['DOCUMENT_ROOT'] . "/library/menus/side_menu.php") ?>
</div>

<div class="page-content">
	<?php
	$products = $mb->_runFunction("catalog", "loadProducts", array(0, $string));
	$num = 0;
	
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
		}
	}
	
	if($num == 0)
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