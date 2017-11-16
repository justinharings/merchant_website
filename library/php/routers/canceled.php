<?php
if(!isset($_SESSION))
{
	session_start();
}

if(isset($_GET['orderID']) && isset($_SESSION['_LANGUAGE_PACK']))
{
	$redirect = "checkout.html";
	
	if(isset($_GET['error']) && strpos($_GET['error'], "afterpay" !== false)
	{
		if(!isset($_SESSION['afterpay-suffix']))
		{
			$_SESSION['afterpay-suffix'] = 0;
		}
		
		$_SESSION['afterpay-suffix'] = $_SESSION['afterpay-suffix'] + 1;
		
		$expl = explode("afterpay", $_GET['error']);
		$error = $expl[1];
		
		unset($_SESSION['afterpay-error']);
		
		if($error != "")
		{
			$_SESSION['afterpay-error'] = $error;
		}
		
		$redirect = "error/afterpay/cart.html";
	}
	
	$_SESSION['orderID'] = $_GET['orderID'];
	
	header("location: /" . $_SESSION['_LANGUAGE_PACK'] . "/system/". $redirect);
}
else if(!isset($_GET['orderID']) && isset($_SESSION['_LANGUAGE_PACK']))
{
	header("location: /" . $_SESSION['_LANGUAGE_PACK'] . "/");
}
else
{
	header("location: /");
}
?>