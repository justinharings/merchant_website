<?php
// Start session

if(!isset($_SESSION))
{
	session_start();
}



if(isset($_GET['paylink']))
{
	/*
	**	Classes are included here. We use a motherboard
	**	class that is able to construct all the classes
	**	and is able to run this class his function.
	*/
	
	define("_LANGUAGE_PACK", "nl");
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");
	
	$mb = new main_board();
	
	if($mb->_runFunction("paylinks", "validateCode", array($_GET['paylink'])))
	{
		// Load paylink and then the payment method.
		$paylink = $mb->_runFunction("paylinks", "load", array($_GET['paylink']));
		$paymentMethod = $mb->_runFunction("paylinks", "loadPaymentMethod", array($paylink['paymentID']));
		
		// Set variables.
		$_load_module = $paymentMethod['module'];
		$_module_keys = array($paymentMethod['api_key_1'], $paymentMethod['api_key_2']);
		
		$orderID = $paylink['orderID'];
		
		$data = array();
		$data[0] = $paylink['merchantID'];
		
		// Load module.
		$mb->_runFunction("paylinks", "startPaylink", array($_load_module, $_module_keys, $orderID, $data));
		exit;
	}
	else
	{
		header("location: /");
	}
	
	exit;
}
?>