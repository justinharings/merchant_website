<?php
function _frontend_float($float, $currency)
{
	$return = "";
	
	if($currency == "EUR")
	{
		setlocale(LC_MONETARY, 'nl_NL');
		$return = money_format('%i', $float);
	}
	else if($currency == "GBP")
	{
		setlocale(LC_MONETARY, 'en_GB');
		$return = money_format('%i', $float);
	}
	else if($currency == "USD")
	{
		setlocale(LC_MONETARY, 'en_US');
		$return = money_format('%i', $float);
	}
	
	$return = str_replace("EUR", "", $return);
	$return = str_replace("GBP", "", $return);
	$return = str_replace("USD", "", $return);
	$return = str_replace(" ", "", $return);
	
	return $return;
}
?>