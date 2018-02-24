<?php
if(!isset($_SESSION))
{
	session_start();
}
	
define("_LANGUAGE_PACK", "NL");
	
require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");

$mb = new main_board();
$cart = $mb->_runFunction("cart", "callBack", array($_POST['productID'], $_POST['phone_number']));

$_SESSION['callback'] = true;

header("location: " . $_POST['returnURL']);
?>