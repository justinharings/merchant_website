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
	else if($currency == "DKK")
	{
		setlocale(LC_MONETARY, 'da_DK');
		$return = money_format('%i', $float);
	}
	else if($currency == "NOK")
	{
		setlocale(LC_MONETARY, 'no_NO');
		$return = money_format('%i', $float);
	}
	else if($currency == "CHF")
	{
		setlocale(LC_MONETARY, 'de_CH');
		$return = money_format('%i', $float);
	}
	else if($currency == "AUD")
	{
		setlocale(LC_MONETARY, 'en_AU');
		$return = money_format('%i', $float);
	}
	else if($currency == "CAD")
	{
		setlocale(LC_MONETARY, 'en_CA');
		$return = money_format('%i', $float);
	}
	else if($currency == "SEK")
	{
		setlocale(LC_MONETARY, 'sv_SE');
		$return = money_format('%i', $float);
	}
	else if($currency == "BRL")
	{
		setlocale(LC_MONETARY, 'pt_BR');
		$return = money_format('%i', $float);
	}
	
	$return = str_replace("EUR", "", $return);
	$return = str_replace("GBP", "", $return);
	$return = str_replace("USD", "", $return);
	$return = str_replace("DKK", "", $return);
	$return = str_replace("NOK", "", $return);
	$return = str_replace("CHF", "", $return);
	$return = str_replace("AUD", "", $return);
	$return = str_replace("CAD", "", $return);
	$return = str_replace("SEK", "", $return);
	$return = str_replace("BRL", "", $return);
	$return = str_replace(" ", "", $return);
	
	return $return;
}
?>