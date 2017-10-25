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
						print "<li>" . $product['name'] . "</li>";
					}
					?>
				</ul>
			</div>
		</div>
		
		<div class="page-content large-margin">
			<input type="hidden" name="locationID" id="locationID" value="0" />
			<input type="hidden" name="paymentID" id="paymentID" value="0" />
			
			<div class="checkout-form">
				<table>
					<tr>
						<td width="175"><strong><?= $mb->_translateReturn("cart", "form-name") ?></strong></td>
						<td><input type="text" name="name" id="name" value="" req="text" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-company") ?></strong></td>
						<td>
							<input type="text" name="company" id="company" value="" />
							<small><?= $mb->_translateReturn("cart", "form-optional") ?></small>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-address") ?></strong></td>
						<td><input type="text" name="address" id="address" value="" req="text" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-zipcode") ?></strong></td>
						<td><input type="text" name="zipcode" id="zipcode" value="" req="text" class="small" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-city") ?></strong></td>
						<td><input type="text" name="city" id="city" value="" req="text" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-country") ?></strong></td>
						<td>
							<select name="country" id="country">
								<?php
								$_countries = $mb->_allCountries();
								
								foreach($_countries AS $value)
								{
									?>
									<option <?= (isset($_GET['dataID']) && $data['country'] == $value) || (!isset($_GET['dataID']) && $value == "Netherlands") ? "selected=\"selected\"" : "" ?> value="<?= $value ?>"><?= $value ?></option>
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
							<input type="text" name="phone" id="phone" value="" />
							<small><?= $mb->_translateReturn("cart", "form-optional") ?></small>
						</td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-mobile") ?></strong></td>
						<td><input type="text" name="mobile_phone" id="mobile_phone" value="" req="text" /></td>
					</tr>
					
					<tr>
						<td><strong><?= $mb->_translateReturn("cart", "form-email") ?></strong></td>
						<td><input type="text" name="email_adres" id="email_adres" value="" req="email" /></td>
					</tr>
				</table>
			</div>
			
			<hr/>
			
			<ul class="checkout-choices" inputname="locationID">
				<li id="0" class="first">
					<div class="choice">
						<span class="fa fa-check active"></span>
					</div>
					
					<div class="data">
						<strong><?= $mb->_translateReturn("cart", "delivery") ?></strong>&nbsp;
						<small><?= $mb->_translateReturn("cart", "delivery-eg") ?></small><br/>
						<br/>
						<?= $mb->_translateReturn("cart", "delivery-text", _frontend_float($_SESSION['shipment_costs'])) ?>
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
								<span class="fa fa-circle"></span>
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
							<span class="fa fa-circle"></span>
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
					?>
					
					<li id="<?= $payment['paymentID'] ?>" <?= $num == 0 ? "class=\"first\"" : "" ?>>
						<div class="choice">
							<span class="fa fa-<?= $num == 0 ? "check active" : "circle" ?>"></span>
						</div>
						
						<div class="data">
							<strong><?= $payment['name'] ?></strong>&nbsp;
							<small><?= $payment['description'] ?></small>
						</div>
					</li>
					
					<?php
					$num++;
				}
				?>
			</ul>
		</div>
		
		<hr/>
		
		<input type="submit" name="book_order" id="book_order" value="<?= $mb->_translateReturn("cart", "happy-book-order") ?>" class="right" />
		<input type="button" name="return" id="return" value="<?= $mb->_translateReturn("cart", "return-to-shop") ?>" class="right white" click="/<?= _LANGUAGE_PACK ?>/" />
	</form>
	<?php
}
?>