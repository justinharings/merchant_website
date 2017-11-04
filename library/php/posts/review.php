<?php
if(!isset($_SESSION))
{
	session_start();
}

define("_LANGUAGE_PACK", "nl");
define("_DEVELOPMENT_ENVIRONMENT", true);

if(isset($_POST['stars']) && isset($_POST['description']))
{
	$_SESSION['review_done'] = true;
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");
	$mb = new main_board();
	
	$mb->_runFunction("review", "add", array($_POST['orderID'], $_POST['stars'], $_POST['description'], $_POST['productID']));
}

header("location: " . $_SESSION['HTTP_REFERER']);
?>