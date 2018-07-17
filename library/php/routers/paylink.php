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
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/paylinks.php");

	$paylinks = new paylinks();
	
	if($paylinks->validateCode(array($_GET['paylink'])))
	{
		$data = $paylinks->getData(array($_GET['paylink']));
		
		define("_MERCHANT_ID", $data[0]);
		
		switch(strtolower($data[1]))
		{
			default:
				define("_LANGUAGE_PACK", "en");
			break;
			
			case "germany":
				define("_LANGUAGE_PACK", "de");
			break;
			
			case "netherlands":
				define("_LANGUAGE_PACK", "nl");
			break;
		}
		
		require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");
	
		$mb = new main_board();
		
		require_once($_SERVER['DOCUMENT_ROOT'] . "/modules/system/paylink.php");
	}
	else
	{
		header("location: /");
	}
	
	exit;
}
?>