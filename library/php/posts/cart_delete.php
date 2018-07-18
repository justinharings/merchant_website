<?php
if(!isset($_SESSION))
{
	session_start();
}
	
define("_LANGUAGE_PACK", $_SESSION['_LANGUAGE_PACK']);
define("_DATABASE_FOLDER", $_SESSION['_DATABASE_FOLDER']);
	
require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");

$mb = new main_board();
$cart = $mb->_runFunction("cart", "deleteCartItem", array($_GET['key'], $_SESSION['cart']));

$_SESSION['cart'] = $cart;

header("location: /" . $_SESSION['_LANGUAGE_PACK'] . "/system/cart.html");
?>