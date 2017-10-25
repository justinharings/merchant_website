<?php
if(!isset($_GET['language_pack']))
{
	/*
	**	No language is set. Go to the map
	**	view. The visitor can choose a country
	**	from the map.
	*/
	
	if(isset($_SESSION['currency']))
	{
		unset($_SESSION['currency']);
	}
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/modules/language/map.php"); exit;
}
else
{
	/*
	**	Array with the languages we support.
	**	After this we check of the requested
	**	language pack is supported. If not,
	**	redirect the visitor to the map.
	*/
	
	$_recognized_languages = array(
		"NL",	// Netherlands
		"BE",	// Belgium
		"DE",	// Germany
		"EN"	// Great Britain
	);
	
	
	
	/*
	**	Languages written as full name for the
	**	website to use. Returned as array.
	*/
	
	$_full_name_languages = array(
		"Nederlands" => "NL",
		"Belgisch" => "BE",
		"Deutschland" => "DE",
		"Great Britain" => "EN"
	);
	
	
	
	/*
	**	This is an array with the supported
	**	currencies. If another currency
	**	is loaded, the webpage will eject it
	**	and use the default one.
	*/
	
	$_recognized_currencies = array(
		"EUR",
		"GBP"
	);
	
	
	
	/*
	**	These are the symbols used for
	**	the diffrent currencies. The symbols
	**	are in HTML code soo they can be used
	**	everywhere on the website.
	*/
	
	$_currencies_symbols = array(
		"EUR" => "&euro;",
		"GBP" => "&pound;"
	);
	
	
	
	/*
	**	This is the default currency setting
	**	for the languages. Users may choose a
	**	diffrent currency, but this is shown as
	**	the default one. At this moment Merchant
	**	supports EURO and GREAT BRITISH POUNDS.
	*/
	
	$_default_currency = array(
		"NL" => "EUR",
		"BE" => "EUR",
		"DE" => "EUR",
		"EN" => "GBP",
	);
	
	
	
	
	if(in_array(strtoupper($_GET['language_pack']), $_recognized_languages))
	{
		/*
		**	The language is found. Load the language
		**	pack and set some information in order
		**	for Google to index the right information.
		*/
		
		define("_LANGUAGE_PACK", $_GET['language_pack']);
		$_SESSION['_LANGUAGE_PACK'] = _LANGUAGE_PACK;
		
		
		/*
		**	When there is no currency set in the
		**	session $_SESSION['currency'], use the
		**	default currency for the used language.
		**	If the session is set, use that one instead.
		*/
		
		if(!isset($_SESSION['currency']))
		{
			$_currency = $_default_currency[strtoupper(_LANGUAGE_PACK)];
		}
		else
		{
			if(!in_array($_SESSION['currency'], $_recognized_currencies))
			{
				$_currency = $_default_currency[strtoupper(_LANGUAGE_PACK)];
				unset($_SESSION['currency']);
			}
			else
			{
				$_currency = $_SESSION['currency'];
			}
		}
		
		define("_CURRENCY", $_currency);
		define("_CURRENCY_SIGN", $_currencies_symbols[$_currency]);
	}
	else
	{
		/*
		**	The requested language pack is not
		**	available. Useally the visitor is
		**	typing the language himself in this
		**	case. Redirect to the map.
		*/
		
		if(isset($_SESSION['currency']))
		{
			unset($_SESSION['currency']);
		}
		
		require_once($_SERVER['DOCUMENT_ROOT'] . "/modules/language/map.php"); exit;
	}
}
?>