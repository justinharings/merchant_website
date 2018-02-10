<?php
if($mb->_runFunction("cart", "countCartItems") == 0)
{
	require_once(__DIR__ . "/cart.php");
}
else
{
	?>
	<h1 class="no-margin"><?= $mb->_translateReturn("cart", "your-order") ?></h1>
	<h2 class="margin"><?= $mb->_translateReturn("cart", "your-order-eg") ?></h2>
	
	<form id="book" method="post" action="/library/php/posts/book.php">
		<div class="page-menu">
			<div class="cart follow-scroll">
				<strong><?= $mb->_translateReturn("cart", "shoppingcart") ?></strong><br/>
				<small>
					<?= $mb->_runFunction("cart", "countCartItems") ?>
					<?= $mb->_translateReturn("cart", "articles") ?>
					- <a href="/<?= _LANGUAGE_PACK ?>/system/cart.html"><?= $mb->_translateReturn("cart", "edit") ?><a/><br/>
				</small>
				<br/>
				
				<ul>
					<?php
					foreach($_SESSION['cart'] AS $key => $item)
					{
						$product = $mb->_runFunction("catalog", "loadProduct", array($item['productID']));
						
						$name = $product['name'];
				
						if($product[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
						{
							$name = $product[strtoupper(_LANGUAGE_PACK) . '_name'];
						}
						
						print "<li>" . $name . "</li>";
					}
					?>
				</ul>
			</div>
		</div>
		
		<div class="page-content large-margin">
			<input type="hidden" name="merchantID" id="merchantID" value="<?= $mb->_merchant_id() ?>" />
			<input type="hidden" name="locationID" id="locationID" value="0" />
			<input type="hidden" name="paymentID" id="paymentID" value="0" />
			<input type="hidden" name="shipmentID" id="shipmentID" value="0" />
			<input type="hidden" name="_website_language_pack" id="_website_language_pack" value="<?= $_GET['language_pack'] ?>" />
			
			<div class="checkout-form">
				<table>
					<tr>
						<td width="175"><strong><?= $mb->_translateReturn("cart", "form-name") ?></strong></td>
						<td><input type="text" name="name" id="name" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['name'] : "" ?>" req="text" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-company") ?></strong></td>
						<td>
							<input type="text" name="company" id="company" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['company'] : "" ?>" />
							<small><?= $mb->_translateReturn("cart", "form-optional") ?></small>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-address") ?></strong></td>
						<td><input type="text" name="address" id="address" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['address'] : "" ?>" req="text" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-zipcode") ?></strong></td>
						<td><input type="text" name="zipcode" id="zipcode" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['zip_code'] : "" ?>" req="text" class="small" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-city") ?></strong></td>
						<td><input type="text" name="city" id="city" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['city'] : "" ?>" req="text" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-country") ?></strong></td>
						<td>
							<select name="country" id="country" req="text">
								<option value=""></option>
								<?php
								$_countries = $mb->_allCountries();
								
								foreach($_countries AS $value)
								{
									?>
									<option <?= isset($_SESSION['customer']) && $_SESSION['customer']['country'] == $value ? "selected=\"selected\"" : "" ?> value="<?= $value ?>"><?= $value ?></option>
									<?php
								}
								?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-phone") ?></strong></td>
						<td>
							<input type="text" name="phone" id="phone" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['phone'] : "" ?>" />
							<small><?= $mb->_translateReturn("cart", "form-optional") ?></small>
						</td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-mobile") ?></strong></td>
						<td><input type="text" name="mobile_phone" id="mobile_phone" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['mobile_phone'] : "" ?>" req="text" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-email") ?></strong></td>
						<td><input type="text" name="email_adres" id="email_adres" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['email_address'] : "" ?>" req="email" /></td>
					</tr>
				</table>
			</div>
			
			<hr/>
			
			<?php
			if(_MERCHANT_ID == 1)
			{
				?>
				<ul class="checkout-choices" inputname="locationID">
					<!--
					'Bij mij laten bezorgen' optie.
						> Toont alle verzendopties die verplicht zijn inclusief de bijbehorende prijzen.
					-->
					
					<li id="0" class="first">
						<div class="choice">
							<span class="fa <?= !isset($_SESSION['shipment']) || $_SESSION['shipment'] == 0 ? "fa-check active" : "fa-circle" ?>"></span>
						</div>
						
						<div class="data">
							<strong><?= $mb->_translateReturn("cart", "delivery") ?></strong>&nbsp;
							<small><?= $mb->_translateReturn("cart", "delivery-eg") ?></small><br/>
							<br/>
							
							<?php
							foreach($_SESSION['shipment_array'] AS $shipment)
							{
								$shipment_data = $mb->_runFunction("cart", "loadShipment", array($shipment));
								
								$name = $shipment_data['name'];
								$price = $shipment_data['price'];
								
								if($shipment_data[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
								{
									$name = $shipment_data[strtoupper(_LANGUAGE_PACK) . '_name'];
									$price = $shipment_data[strtoupper(_LANGUAGE_PACK) . '_price'];
								}
								
								print $_currencies_symbols[$_SESSION['currency']];
								print " <strong>" . _frontend_float($mb->replaceCurrency($price, $_SESSION['currency']), $_SESSION['currency']) . "</strong> - " . $name . "<br/>";
								
								$total_ship += $price;
							}
							?>
							<br/>
							<?= $_currencies_symbols[$_SESSION['currency']] . " " . _frontend_float($mb->replaceCurrency($total_ship, $_SESSION['currency']), $_SESSION['currency']) ?>
							<?= $mb->_translateReturn("cart", "price") ?>
						</div>
					</li>
			
					<?php	
					$locations = $mb->_runFunction("cart", "pickupLocations", array());	
					
					foreach($locations AS $location)
					{
						if($location['webshop'] == 1)
						{
							?>
							<li id="<?= $location['locationID'] ?>">
								<div class="choice">
									<span class="fa <?= isset($_SESSION['shipment']) && $_SESSION['shipment'] == $location['locationID'] ? "fa-check active" : "fa-circle" ?>"></span>
								</div>
								
								<div class="data">
									<strong><?= $mb->_translateReturn("cart", "shop-pickup") ?></strong>&nbsp;
									<small><?= $mb->_translateReturn("cart", "shop-pickup-eg") ?></small><br/>
									<br/>
									<?= $mb->_translateReturn("cart", "shop-pickup-text") ?>
								</div>
							</li>
							<?php
								
							continue;
						}
						?>
						
						<li id="<?= $location['locationID'] ?>">
							<div class="choice">
								<span class="fa <?= isset($_SESSION['shipment']) && $_SESSION['shipment'] == $location['locationID'] ? "fa-check active" : "fa-circle" ?>"></span>
							</div>
							
							<div class="data">
								<strong><?= $mb->_translateReturn("cart", "service-pickup", array($location['name'])) ?></strong>&nbsp;
								<small><?= $mb->_translateReturn("cart", "service-pickup-eg") ?></small><br/>
								<br/>
								<?= $mb->_translateReturn("cart", "service-pickup-text", array($location['name'])) ?>
							</div>
						</li>
						
						<?php
					}
					?>
				</ul>
				<?php
			}
			else
			{
				?>
				<ul class="checkout-choices" inputname="shipmentID">
					<?php
					$shipments = $mb->_runFunction("cart", "shipmentMethods", array());	
					$num = 0;
					
					foreach($shipments AS $shipment)
					{
						if	(
								(
									$shipment['maximum'] > 0 
									&& ($shipment['used'] >= $shipment['maximum'])
								)
								|| $shipment['free_choice'] == 0
							)
						{
							continue;
						}
						
						?>
						<li id="<?= $shipment['shipmentID'] ?>" <?= (!isset($_SESSION['shipment']) && $num == 0) ? 'class="first"' : '' ?>>
							<div class="choice">
								<span class="fa fa-<?= (!isset($_SESSION['shipment']) && $num == 0) || (isset($_SESSION['shipment']) && $shipment['shipmentID'] == $_SESSION['shipment']) ? "check active" : "circle" ?>"></span>
							</div>
							
							<div class="data">
								<strong><?= $shipment['name'] ?></strong>
							</div>
						</li>
						<?php
							
						$num++;
					}
					?>
				</ul>
				<?php
			}
			?>
			
			<hr/>
			
			<ul class="checkout-choices" inputname="paymentID">
				<?php	
				$payments = $mb->_runFunction("cart", "paymentMethods", array());
				$num = 0;
				
				foreach($payments AS $payment)
				{
	 				if($payment['webshop'] == 0 || ($payment['maximum_amount'] > 0 && ($_SESSION['grand_total'] > $payment['maximum_amount'])))
					{
						continue;
					}
					
					$description = $payment['description'];
					
					if($payment[strtoupper(_LANGUAGE_PACK) . '_description'] != "")
					{
						$description = $payment[strtoupper(_LANGUAGE_PACK) . '_description'];
					}
					?>
					
					<li id="<?= $payment['paymentID'] ?>" <?= $num == 0 ? "class=\"first\"" : "" ?>>
						<div class="choice">
							<span class="fa fa-<?= (!isset($_SESSION['payment']) && $num == 0) || (isset($_SESSION['payment']) && $_SESSION['payment'] == $payment['paymentID']) ? "check active" : "circle" ?>"></span>
						</div>
						
						<div class="data">
							<strong><?= $payment['name'] ?></strong>&nbsp;
							<small>
								<?= $description ?>
								
								<?php
								if($payment['agreements'] != "")
								{
									?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#187;&nbsp;<span click="<?= $payment['agreements'] ?>"><?= ucfirst($mb->_translateReturn("footer_menu", "terms_and_conditions")) ?> <?= ucfirst($payment['name']) ?></span>
									<?php
								}
								?>
							</small>
						</div>
					</li>
					
					<?php
					if	(
							$payment['required_dob'] == 1
							// || ADD MORE HERE
						)
					{
						?>
						<li class="extra-field extra-<?= $payment['paymentID'] ?>">
							<?php
							if($payment['required_dob'] == 1)
							{
								?>
								<?= $mb->_translateReturn("cart", "dob") ?>:<br/>
								<input type="text" name="dob" id="dob" value="" class="date-mask-field" />
								<?php
							}
							
							// ADD MORE HERE
							?>
						</li>
						<?php
					}
						
					$num++;
				}
				?>
			</ul>
		</div>
		
		<hr/>
		
		<div class="conditions">
			<a href="/<?= _LANGUAGE_PACK ?>/service/terms-and-conditions.html"><?= $mb->_translateReturn("cart", "conditions-check") ?></a>
		</div>
		
		<input type="submit" name="book_order" id="book_order" value="<?= $mb->_translateReturn("cart", "happy-book-order") ?>" class="right" />
		<input type="button" name="return" id="return" value="<?= $mb->_translateReturn("cart", "return-to-shop") ?>" class="right white" click="/<?= _LANGUAGE_PACK ?>/" />
	</form>
	<?php
}
?>