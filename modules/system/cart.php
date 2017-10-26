<h1><?= $mb->_translateReturn("cart", "shoppingcart") ?></h1>

<hr/>

<?php
if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)
{
	$total = 0;
	
	foreach($_SESSION['cart'] AS $key => $item)
	{
		$product = $mb->_runFunction("catalog", "loadProduct", array($item['productID']));
		$thumb = "";
		
		$total += ($item['quantity']*$product['price']);
		
		$shipment_data[] = $product['shipments'];
		
		foreach($product['images'] AS $media)
		{
			if($media['thumb'])
			{
				$thumb = "https://merchant.justinharings.nl/library/media/products/" . $media['productMediaID'] . ".png";
			}
		}
		?>
		
		<div class="cart-item">
			<table>
				<tr>
					<td width="15%"><img src="<?= $thumb != "" ? $thumb : "/library/media/no-image.png" ?>" /></td>
					
					<td width="25%">
						<small><?= $mb->_translateReturn("product-details", "description") ?></small><br/>
						
						<a href="/<?= _LANGUAGE_PACK ?>/catalog/details/<?= $product['productID'] ?>/<?= _createCategoryURL($product['name']) ?>.html">
							<?= strip_tags($product['name']) ?>
						</a>
					</td>
					
					<td width="25%">
						<small><?= $mb->_translateReturn("cart", "stock-status") ?></small><br/>
						<?= _createStockText($product['stock'], 0, $product['productID'], _LANGUAGE_PACK) ?>
					</td>
					
					<td width="16%" class="padding">
						<small><?= $mb->_translateReturn("cart", "stock-quantity") ?></small><br/>
						<form method="post" action="/library/php/posts/cart_quantity.php">
							<input type="hidden" name="key" id="key" value="<?= $key ?>" />
							
							<select name="quantity" id="quantity">
								<?php
								for($i = 1; $i < 20; $i++)
								{
									?>
									<option <?= $i == $item['quantity'] ? "selected=\"selected\"" : "" ?> value="<?= $i ?>"><?= $i ?></option>
									<?php
								}
								?>
							</select>
						</form>
						<span class="fa fa-caret-down"></span>
					</td>
					
					<td>
						<small><?= $mb->_translateReturn("cart", "price") ?></small><br/>
						<?= _frontend_float($item['quantity']*$product['price']) ?>
					</td>
					
					<td width="1%">
						<a href="/library/php/posts/cart_delete.php?key=<?= $key ?>">
							<span class="fa fa-times"></span>
						</a>
					</td>
				</tr>
			</table>
		</div>
		
		<?php
	}
	
	$shipment_costs = 0;
	$payed = array();
	$shipmentArray = array();
	
	foreach($shipment_data AS $key => $shipment)
	{
		if($shipment['combine'] == 1 && count($shipment_data > 1))
		{
			unset($shipment_data[$key]);
		}
		else
		{
			if($shipment['pay_once'] == 1 && isset($payed[$key]))
			{
				unset($shipment_data[$key]);
			}
			else
			{
				$shipment_costs += $shipment['price'];
				$payed[$key] = 1;
			}
		}
	}
	
	foreach($shipment_data AS $key => $shipment)
	{
		$shipmentArray[] = $shipment['shipmentID'];
	}
	
	$_SESSION['shipment_costs'] = $shipment_costs;
	$_SESSION['grand_total'] = ($total + $shipment_costs);
	$_SESSION['shipment_array'] = $shipmentArray;
	?>
	
	<div class="totals">
		<table>
			<tr>
				<td width="66%">&nbsp;</td>
				
				<td width="15%">
					<strong><?= $mb->_translateReturn("cart", "sub-total") ?></strong>
				</td>
				
				<td>
					<?= _frontend_float($total) ?>
				</td>
				
				<td width="1%">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="66%">&nbsp;</td>
				
				<td width="15%">
					<strong><?= $mb->_translateReturn("cart", "shipment-costs") ?></strong>
				</td>
				
				<td>
					<?= _frontend_float($shipment_costs) ?>
					<small>(optioneel)</small>
				</td>
				
				<td width="1%">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="66%">&nbsp;</td>
				<td width="15%">&nbsp;</td>
				
				<td>
					<hr/>
				</td>
				
				<td width="1%">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="66%">&nbsp;</td>
				
				<td width="15%">
					<strong><?= $mb->_translateReturn("cart", "grand-total") ?></strong>
				</td>
				
				<td>
					<strong>
						<?= _frontend_float($total + $shipment_costs) ?>
					</strong>
				</td>
				
				<td width="1%">&nbsp;</td>
			</tr>
			
			<tr>
				<td width="66%">&nbsp;</td>
				<td width="15%">&nbsp;</td>
				
				<td>
					<input type="button" name="continue" id="continue" value="<?= $mb->_translateReturn("cart", "continue") ?>" click="/<?= _LANGUAGE_PACK ?>/system/checkout.html" />
				</td>
				
				<td width="1%">&nbsp;</td>
			</tr>
		</table>
	</div>
	<?php
}
else
{
	?>
	<h2><?= $mb->_translateReturn("cart", "no-items") ?></h2>
	<input type="button" name="return" id="return" value="<?= $mb->_translateReturn("cart", "button-continue-shopping") ?>" click="/<?= _LANGUAGE_PACK ?>/" />
	<?php
}
?>