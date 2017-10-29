<?php
// Start session

if(!isset($_SESSION))
{
	session_start();
}

define("_LANGUAGE_PACK", "nl");

/*
**	Functions are added here. Used for quick access to all
**	of the extended special functions, all the files
**	are added to the core here.
*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/functions/arrays.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/functions/floats.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/functions/text.php");



/*
**	Classes are included here. We use a motherboard
**	class that is able to construct all the classes
**	and is able to run this class his function.
*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");

$mb = new main_board();



// CART ITEMS
// Array must be:
// array[KEY]['productID']
// array[KEY]['price']
// array[KEY]['name']
// array[KEY]['quantity']

$_cart = array();
$num = 0;

foreach($_SESSION['cart'] AS $cart)
{
	$product = $mb->_runFunction("catalog", "loadProduct", array($cart['productID']));
	
	$_cart[$num]['productID'] = $cart['productID'];
	$_cart[$num]['price'] = $product['price'];
	$_cart[$num]['name'] = $product['name'];
	$_cart[$num]['quantity'] = $cart['quantity'];
	
	$num++;
}



// CUSTOMER
// Variable must hold customerID.

$_customer = (isset($_SESSION['customer']) ? $_SESSION['customer'] : 0);

if($_customer == 0)
{
	$_customer = array();
	$_customer['name'] = $_POST['name'];
	$_customer['company'] = $_POST['company'];
	$_customer['address'] = $_POST['address'];
	$_customer['zip_code'] = $_POST['zipcode'];
	$_customer['city'] = $_POST['city'];
	$_customer['country'] = $_POST['country'];
	$_customer['phone'] = $_POST['phone'];
	$_customer['mobile_phone'] = $_POST['mobile_phone'];
	$_customer['email_address'] = $_POST['email_adres'];
}



// PAYMENTS
// Array must be:
// array[KEY]['paymentID']
// array[KEY]['amount']

$_payments = array();
$_payments[0]['paymentID'] = $_POST['paymentID'];
$_payments[0]['amount'] = 0;



// STATUS
// Variable must hold statusID.
$default_status = $mb->_runFunction("cart", "loadGeneralSettings", array($_POST['merchantID']));
$_status = $default_status['statusID'];

if(is_array($_status) && count($_status) == 0)
{
	exit;
}



// SHIPMENT
// Variable must hold shipmentID.

if($_POST['merchantID'] == 1)
{
	$shipmentArray = array();
	
	switch($_POST['locationID'])
	{
		case 0:
			// Internet bestelling. Verzending berekent in de winkelwagen.
			$shipment = $_SESSION['shipment_array'];
			$employeeID = 0;
		break;
		
		case 3:
			// Fixed ID, afhalen in de winkel.
			$shipment = 4;
			$employeeID = 0;
		break;
		
		default:
			// Fixed ID, afhalen bij een servicepunt.
			$shipment = 76;
			$employeeID = 0;
		break;
	}
	
	$_shipment = $shipment;
}
else
{
	$_shipment = $_POST['shipmentID'];
}



// EMPLOYEE
// Variable must hold employeeID.

$_employee = $employeeID;



// INVOICE RULES
// Array

$invoice_rules = array();

if($shipment == 76)
{
	$location = $mb->_runFunction("cart", "getLocation", array($_POST['locationID']));
	
	$invoice_rules['key_1'] = "Afhaalpunt";
	$invoice_rules['value_1'] = $location['name'];
}



// SET OPTIONAL ORDER
// Variable must hold orderID

$_orderID = (isset($_SESSION['orderID']) ? $_SESSION['orderID'] : 0);



// SET THE LANGUAGE PACK

$_GET['language_pack'] = $_POST['_website_language_pack'];

/*
print "<h1>Cart</h1><br/><pre>" . print_r($_cart, true) . "</pre><br/><br/>";
print "<h1>Customer</h1><br/><pre>".print_r($_customer, true) . "</pre><br/><br/>";
print "<h1>Payments</h1><br/><pre>" . print_r($_payments, true) . "</pre><br/><br/>";
print "<h1>Status</h1><br/>".$_status . "<br/><br/>";
print "<h1>Shipment</h1><br/><pre>" . print_r($_shipment, true) . "</pre><br/><br/>";
print "<h1>Employee</h1><br/>".$_employee . "<br/><br/>";
print "<h1>orderID</h1><br/>".$_orderID . "<br/><br/>";
*/

$orderID = $mb->_runFunction("cart", "runOrder", array($_POST['merchantID'], $_cart, $_customer, $_payments, $_status, $_employee, $_shipment, $_orderID, $invoice_rules));
$_SESSION['last_order'] = $orderID;

$_SESSION['cart'] = array();

header("location: /" . $_SESSION['_LANGUAGE_PACK'] . "/service/success.html");
?>