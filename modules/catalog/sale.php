<ul class="breadcrumbs">
	<li><a href="/<?= _LANGUAGE_PACK ?>/">home</a></li>
	<li class="spacer">-</li>
	<li>
		<strong>
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/sale.html"><?= $mb->_translateReturn("main_menu", "sale") ?></a>
		</strong>
	</li>
</ul>

<div class="page-menu">
	<? require_once($_SERVER['DOCUMENT_ROOT'] . "/library/menus/side_menu.php") ?>
</div>

<div class="page-content">
	<h1><?= $mb->_translateReturn("website_text", "sale_results"); ?></h1>
	
	<?php
	$products = $mb->_runFunction("catalog", "loadProducts", array(0, ""));
	$num = 0;
	
	foreach($products AS $key => $product)
	{
		$product['name'] = unserialize($product['name']);
		$product['price'] = unserialize($product['price']);
		$product['price_adviced'] = unserialize($product['price_adviced']);
		$product['filters'] = unserialize($product['filters']);
		
		$show = true;
		$approved = array();
		$had = 0;
		
		if(count($selected) > 0)
		{
			if(count($product['filters']) == 0)
			{
				$show = false;
			}
			
			foreach($product['filters'] AS $filterID => $value)
			{
				if(isset($selected[$filterID]))
				{
					if(in_array($value[strtoupper(_LANGUAGE_PACK)], $selected[$filterID]))
					{
						$approved[] = "yes";
					}
					else if(!in_array($value[strtoupper(_LANGUAGE_PACK)], $selected[$filterID]))
					{
						$approved[] = "no";
					}
				}
				
				$had++;
			}
			
			if	(
					(in_array("no", $approved) || !in_array("yes", $approved))
					|| $had < count($selected)
				)
			{
				$show = false;
			}
		}
		
		if($show == false)
		{
			continue;
		}
		
		require(__DIR__ . "/product-tile.php");
			
		if($num == 2)
		{
			$num = 0;
		}
		
		$num++;
	}
	?>
</div>