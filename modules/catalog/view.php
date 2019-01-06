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
	
	case "decoration":
		$headCategory = 85;
	break;
	
	case "furniture":
		$headCategory = 86;
	break;
	
	case "lights":
		$headCategory = 87;
	break;
	
	case "clothes":
		$headCategory = 88;
	break;
	
	case "dierenwinkel":
		$headCategory = 101;
	break;
	
	case "snoepgoed":
		$headCategory = 231;
	break;
}

$headCategory = $mb->_runFunction("catalog", "loadCatalog", array(intval($headCategory)));

$head_name = $headCategory['name'];

if($headCategory[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
{
	$head_name = $headCategory[strtoupper(_LANGUAGE_PACK) . '_name'];
}

$category = $mb->_runFunction("catalog", "loadCatalog", array(intval($_GET['categoryID'])));

$category_name = $category['name'];

if($category[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
{
	$category_name = $category[strtoupper(_LANGUAGE_PACK) . '_name'];
}

$parent = $mb->_runFunction("catalog", "loadCatalog", array(intval($category['parentID'])));

$parent_name = $parent['name'];

if($parent[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
{
	$parent_name = $parent[strtoupper(_LANGUAGE_PACK) . '_name'];
}

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
	<li><a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>.html"><?= strtolower($head_name) ?></a></li>
	
	<?php
	if(strtolower($head_name) != strtolower($category_name))
	{
		?>
		<li class="spacer">-</li>
		<li>
			<strong>
				<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>/<?= $category['categoryID'] ?>/filters/none/<?= _createCategoryURL($category['EN_name']) ?>.html"><?= strtolower($category_name) ?></a>
			</strong>
		</li>
		<?php
	}
	?>
</ul>

<div class="page-menu">
	<?php
	if(strtolower($head_name) != strtolower($category_name))
	{
		?>
		<ul class="head catalog">
			<li>
				<strong><?= $parent_name ?></strong>
				
				<?php
				$sub = $mb->_runFunction("catalog", "loadCatalogTree", array($parent['categoryID']));
					
				if($sub)
				{
					?>
					<ul>
						<?php
						foreach($sub AS $key => $second)
						{
							$name = $second['name'];
				
							if($second[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
							{
								$name = $second[strtoupper(_LANGUAGE_PACK) . '_name'];
							}
							
							?>
							<li>
								<a href="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>/<?= $second['categoryID'] ?>/filters/none/<?= _createCategoryURL($second['EN_name']) ?>.html" class="<?= $second['categoryID'] == $category['categoryID'] ? "active": "" ?>">
									<?= $name ?>
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
		<?php
	}
	?>
	
	<div class="filters">
		<strong>filters</strong>
		<hr/>
		
		<div class="filterForm">
			<form id="filterForm" method="get" action="/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>/<?= $category['categoryID'] ?>/filters/[[filterData]]/<?= _createCategoryURL($category['EN_name']) ?>.html">
				<?php
				foreach($category['filters'] AS $value)
				{
					$name = $value['name'];
					
					if($value[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
					{
						$name = $value[strtoupper(_LANGUAGE_PACK) . '_name'];
					}
					?>
					<strong class="header"><?= strtolower($name) ?></strong>
					
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
				
				<hr class="show-mobile" />
				
				<input type="button" name="post_filter" id="post_filter" value="start filter" class="show-mobile" />
			</form>
		</div>
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
					if($filterID == 0 && in_array($value['NL'], $selected[$filterID]))
					{
						$approved[] = "yes";
					}
					else
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
					"@id": "https://www.haringstweewielers.com/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>.html",
					"name": "<?= ucfirst($headCategory[(_LANGUAGE_PACK != "nl" ? strtoupper(_LANGUAGE_PACK) . "_" : "") . 'name']) ?>"
				}
			},
			{
				"@type": "ListItem",
				"position": 3,
				"item":
				{
					"@id": "https://www.haringstweewielers.com/<?= _LANGUAGE_PACK ?>/catalog/<?= strtolower($headCategory['EN_name']) ?>/<?= $category['categoryID'] ?>/filters/none/<?= _createCategoryURL($category['EN_name']) ?>.html",
					"name": "<?= ucfirst($category_name) ?>"
				}
			}
		]
	}
</script>