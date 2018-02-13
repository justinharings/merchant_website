<?php
if(!isset($_SESSION))
{
	session_start();
}

if(!isset($_SESSION['cart']))
{
	$_SESSION['cart'] = array();
}
	
define("_LANGUAGE_PACK", "NL");
	
require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");

$mb = new main_board();
$cart = $mb->_runFunction("cart", "exportFee", array($_POST['country'], $_SESSION['cart']));

$_SESSION['cart'] = $cart;

print count($_SESSION['cart']);
?>