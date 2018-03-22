<?php
$orderData = $paylinks->getOrder(base64_decode($_GET['paylink']));

$_SESSION['customer'] = $orderData['customer'];
$_SESSION['orderID'] = $orderData['orderID'];
?>

<!DOCTYPE html>
<html lang="<?= _LANGUAGE_PACK ?>">
	<head>
		<title>Paylink | <?= $mb->_runFunction("head", "title") ?></title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		<meta name="robots" content="no-index, no-follow" />

		<link type="image/x-icon" rel="icon" href="/library/media/<?= $mb->_translateReturn("images", "favicon") ?>" />
		<link type="image/x-icon" rel="shortcut icon" href="/library/media/<?= $mb->_translateReturn("images", "favicon") ?>" />
		
		<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="/library/css/motherboard.minified.css" />

		<script type="text/javascript" src="//code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript" src="/library/js/motherboard.minified.js"></script>
	</head>

	<body>
		<div class="paylink">
			<a href="/<?= _LANGUAGE_PACK ?>/">
				<img class="logo" src="/library/media/<?= $mb->_translateReturn("images", "logo") ?>" />
			</a>
			
			<img class="expert" src="/library/media/<?= $mb->_translateReturn("images", "expert") ?>" />

			<form id="book" method="post" action="/library/php/posts/book.php">
				<input type="hidden" name="paylink" id="paylink" value="1" />
				<input type="hidden" name="merchantID" id="merchantID" value="<?= $mb->_merchant_id() ?>" />
				<input type="hidden" name="locationID" id="locationID" value="0" />
				<input type="hidden" name="paymentID" id="paymentID" value="0" />
				<input type="hidden" name="shipmentID" id="shipmentID" value="0" />
				<input type="hidden" name="_website_language_pack" id="_website_language_pack" value="<?= _LANGUAGE_PACK ?>" />

				<input type="hidden" name="name" id="name" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['name'] : "" ?>" />
				<input type="hidden" name="company" id="company" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['company'] : "" ?>" />
				<input type="hidden" name="address" id="address" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['address'] : "" ?>" />
				<input type="hidden" name="zipcode" id="zipcode" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['zip_code'] : "" ?>" />
				<input type="hidden" name="city" id="city" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['city'] : "" ?>" />
				<input type="hidden" name="country" id="country" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['country'] : "" ?>" />
				<input type="hidden" name="phone" id="phone" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['phone'] : "" ?>" />
				<input type="hidden" name="mobile_phone" id="mobile_phone" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['mobile_phone'] : "" ?>" />
				<input type="hidden" name="email_adres" id="email_adres" value="<?= isset($_SESSION['customer']) ? $_SESSION['customer']['email_address'] : "" ?>" />
				
				<div class="page-content full-width">
					<ul class="checkout-choices" inputname="paymentID">
						<?php	
						$payments = $mb->_runFunction("cart", "paymentMethods", array());
						$num = 0;
						
						foreach($payments AS $payment)
						{
			 				if($payment['webshop'] == 0 || $payment['paylink'] == 1 || ($payment['maximum_amount'] > 0 && ($_SESSION['grand_total'] > $payment['maximum_amount'])))
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
				<input type="submit" name="book_order" id="book_order" value="<?= $mb->_translateReturn("cart", "continue-payment") ?>" class="right" />
			</form>
		</div>
	</body>
</html>