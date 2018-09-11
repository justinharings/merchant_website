<div class="container-mobile">
	<?php
	if(isset($_GET['error']))
	{
		?>
		<div class="error">
			<strong><?= $mb->_translateReturn("cart", "payment-error-title") ?></strong><br/>
			<?= $mb->_translateReturn("cart", "payment-error-text", array(ucfirst($_GET['error']))) ?>
			
			<?php
			if(isset($_SESSION['afterpay-error']))
			{
				print "<br/><br/><strong>Afterpay foutmelding:</strong><br/>";
				
				switch($_SESSION['afterpay-error'])
				{
					case 3:
						print "Op dit moment is het helaas niet mogelijk om je bestelling achteraf te betalen met AfterPay. Dit kan verschillende redenen hebben. Voor meer informatie kun je contact opnemen met de klantenservice van AfterPay. Kijk voor de contactgegevens en antwoorden op veelgestelde vragen op <a href=\"https://www.afterpay.nl/nl/consumenten/vraag-en-antwoord/\" target=\"_blank\">https://www.afterpay.nl/nl/consumenten/vraag-en-antwoord/</a>. We adviseren je om je bestelling met een andere betaalmethode af te ronden.";
					break;
					
					default:
						print "Onjuist ingevoerde persoonlijke gegevens. Controleer uw gegevens op juistheid en probeer het opnieuw.";
					break;
				}
			}
			?>
		</div>
		<?php
	}
		
	if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)
	{
		$total = 0;
		$used = array();
		
		foreach($_SESSION['cart'] AS $key => $item)
		{
			$product = $mb->_runFunction("catalog", "loadProduct", array($item['productID']));
			$thumb = "";
			
			$name = $product['name'];
	
			if($product[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
			{
				$name = $product[strtoupper(_LANGUAGE_PACK) . '_name'];
			}
			
			$total += $mb->replaceCurrency(($item['quantity']*$product['price']), $_SESSION['currency']);
			
			$loop = $item['quantity'];
			
			if($product['shipments']['pay_once'] == 1)
			{
				if(in_array($product['shipments']['shipmentID'], $used))
				{
					$loop = 0;
				}
				else
				{
					$loop = 1;
				}
			}
			
			for($i = 0; $i < $loop; $i++)
			{
				$shipment_data[] = $product['shipments'];
				$used[] = $product['shipments']['shipmentID'];
			}
			
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
						<td class="first"><img src="<?= $thumb != "" ? $thumb : "/library/media/no-image.png" ?>" /></td>
						
						<td class="second hide-mobile">
							<small><?= $mb->_translateReturn("product-details", "description") ?></small><br/>
							
							<a href="/<?= _LANGUAGE_PACK ?>/catalog/details/<?= $product['productID'] ?>/<?= _createCategoryURL($product['name']) ?>.html">
								<?= strip_tags($name) ?>
							</a>
						</td>
						
						<td class="third hide-mobile">
							<small><?= $mb->_translateReturn("cart", "stock-status") ?></small><br/>
							<?= _createStockText($product['stock'], 0, $product['productID'], _LANGUAGE_PACK) ?>
						</td>
						
						<td class="padding fourth">
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
						
						<td class="fifth hide-mobile">
							<small><?= $mb->_translateReturn("cart", "price") ?></small><br/>
							<?= $_currencies_symbols[$_SESSION['currency']] ?>
							<?= _frontend_float($mb->replaceCurrency(($item['quantity']*$product['price']), $_SESSION['currency']), $_SESSION['currency']) ?>
						</td>
						
						<td class="sixth">
							<a href="/library/php/posts/cart_delete.php?key=<?= $key ?>">
								<span class="fa fa-times"></span>
							</a>
						</td>
					</tr>
				</table>
			</div>
			
			<?php
		}
		
		$methods = array();
		$shipmentArray = array();
		
		foreach($shipment_data AS $key => $shipment)
		{
			if(!in_array($shipment['shipmentID'], $methods))
			{
				$methods[] = $shipment['shipmentID'];
			}
		}
		
		foreach($shipment_data AS $key => $shipment)
		{
			if($shipment['combine'] == 1 && count($methods) > 1)
			{
				unset($shipment_data[$key]);
			}
		}
		
		foreach($shipment_data AS $key => $shipment)
		{
			$shipmentArray[] = $shipment['shipmentID'];
		}
		
		// print_r($shipmentArray);
		
		$_SESSION['grand_total'] = ($total + $shipment_costs);
		$_SESSION['shipment_array'] = $shipmentArray;
		?>
		
		<div class="totals">
			<table>
				<tr>
					<td width="66%">&nbsp;</td>
					
					<td width="15%">
						<strong><?= $mb->_translateReturn("cart", "grand-total") ?></strong>
					</td>
					
					<td>
						<strong>
							<?= $_currencies_symbols[$_SESSION['currency']] ?>&nbsp;<?= _frontend_float($total, $_SESSION['currency']) ?>
						</strong>
					</td>
					
					<td width="1%">&nbsp;</td>
				</tr>
			</table>
		</div>
		
		<input type="button" name="return" id="return" value="<?= $mb->_translateReturn("cart", "button-continue-shopping") ?>" class="white" click="/<?= _LANGUAGE_PACK ?>/" />
		
		<?php
		if($settings['minimum_order_amount'] == 0 || $total > $settings['minimum_order_amount'])
		{
			?>
			<input type="button" name="continue" id="continue" value="<?= $mb->_translateReturn("cart", "continue") ?>" class="right" click="/<?= _LANGUAGE_PACK ?>/system/checkout.html" style="background-color: <?= $mb->_translateReturn("colors", "main_color") ?> !important;" />
			<?php
		}
		else
		{
			?>
			<input type="button" disabled="disabled" name="disabled" id="disabled" value="<?= $mb->_translateReturn("cart", "failed-grand-total") ?>" class="disabled right" />
			<?php
		}
	}
	else
	{
		?>
		<div class="no-results">
			<span class="fa fa-shopping-bag"></span><br/><br/>
			<?= $mb->_translateReturn("cart", "no-items") ?><br/><br/>
		</div>
		<?php
	}
	?>
</div>