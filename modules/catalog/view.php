<?php
switch($_GET['headCategory'])
{
	case "bicycles":
		$headCategory = 1;
	break;
	
	case "accessories":
		$headCategory = 4;
	break;
	
	case "parts":
		$headCategory = 44;
	break;
	
	case "webshop":
		$headCategory = 68;
	break;
}

$headCategory = $mb->_runFunction("catalog", "loadCatalog", array(intval($headCategory)));
$category = $mb->_runFunction("catalog", "loadCatalog", array(intval($_GET['categoryID'])));
$parent = $mb->_runFunction("catalog", "loadCatalog", array(intval($category['parentID'])));

$brands = $mb->_runFunction("catalog", "loadBrandTree", array(intval($_GET['categoryID'])));

$filters = $_GET['filters'];
$filters = explode("F--", $filters);

$selected = array();

if($_GET['filters'] != "none")
{
	foreach($filters AS $filter)
	{
		$value = explode("V--", $filter);
		
		$filterID = base64_decode($value[0]);
		$value = base64_decode($value[1]);
		
		if($filterID == "")
		{
			continue;
		}
		
		if(!isset($selected[$filterID]))
		{
			$selected[$filterID] = array();	
		}
	
		$selected[$filterID][] = $value;
	}
}
?>

<ul class="breadcrumbs">
	<li><a href="/<?= _LANGUAGE_PACK ?>/">home</a></li>
	<li class="spacer">-</li>
	<li><a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['en_name']) ?>.html"><?= strtolower($headCategory['name']) ?></a></li>
	<li class="spacer">-</li>
	<li><?= strtolower($parent['name']) ?></li>
	<li class="spacer">-</li>
	<li>
		<strong>
			<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['en_name']) ?>/<?= $category['categoryID'] ?>/filters/none/<?= _createCategoryURL($category['en_name']) ?>.html"><?= strtolower($category['name']) ?></a>
		</strong>
	</li>
</ul>

<div class="page-menu">
	<ul>
		<li>
			<strong><?= $parent['name'] ?></strong>
			
			<?php
			$sub = $mb->_runFunction("catalog", "loadCatalogTree", array($parent['categoryID']));
				
			if($sub)
			{
				?>
				<ul>
					<?php
					foreach($sub AS $key => $second)
					{
						?>
						<li>
							<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['en_name']) ?>/<?= $second['categoryID'] ?>/filters/none/<?= _createCategoryURL($second['en_name']) ?>.html" class="<?= $second['categoryID'] == $category['categoryID'] ? "active": "" ?>">
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
	</ul>
	
	<div class="filters">
		<strong>filters</strong>
		<hr/>
		
		<form id="filterForm" method="get" action="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['en_name']) ?>/<?= $category['categoryID'] ?>/filters/[[filterData]]/<?= _createCategoryURL($category['en_name']) ?>.html">
			<?php
			foreach($category['filters'] AS $value)
			{
			?>
				<strong class="header"><?= strtolower($value['name']) ?></strong>
				
				<?php
				$filters = $mb->_runFunction("catalog", "loadFilterValues", array($value['filterID']));
					
				foreach($filters AS $filter)
				{
					?>
					<div class="option">
						<div class="input-holder">
							<input <?= isset($selected[$value['filterID']]) && in_array($filter, $selected[$value['filterID']]) ? "checked=\"checked\"" : "" ?> type="<?= $value['multiple_choice'] ? "checkbox" : "radio" ?>" name="<?= $value['filterID'] ?>[]" id="<?= $value['filterID'] ?>_<?= $filter ?>" value="<?= $filter['value'] ?>" data-url="F--<?= base64_encode($value['filterID']) ?>V--<?= base64_encode($filter) ?>" />
						</div>
						
						<label for="<?= $value['filterID'] ?>_<?= $filter ?>"><?= $filter ?></label>
					</div>
					<?php
				}
				?>
				<hr/>
				<?php
			}
			?>
			
			<strong class="header">merken</strong>

			<?php			
			foreach($brands AS $key => $brand)
			{
				?>
				<div class="option">
					<div class="input-holder">
						<input <?= isset($selected[0]) && in_array($brand['name'], $selected[0]) ? "checked=\"checked\"" : "" ?> type="checkbox" name="0[]" id="0_<?= $brand['name'] ?>" value="<?= $brand['name'] ?>" data-url="F--<?= base64_encode(0) ?>V--<?= base64_encode($brand['name']) ?>" />
					</div>
					
					<label for="0_<?= $brand['name'] ?>"><?= $brand['name'] ?></label>
				</div>
				<?php
			}
			?>	
		</form>
	</div>
</div>

<div class="page-content">
	<?php
	$products = $mb->_runFunction("catalog", "loadProducts", array(intval($_GET['categoryID']), ""));
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