<?php
/*
**	Get the full URL soo we can feed
**	the right information to the 
** 	language router.
*/

$_actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

switch($_actual_link)
{
	case "https://haringsvuurwerk.nl":
	case "https://www.haringsvuurwerk.nl":
		define("_MERCHANT_ID", 3);
	break;
	
	case "https://websites.justinharings.nl":	
	case "https://haringstweewielers.com":
	case "https://www.haringstweewielers.com":
		define("_MERCHANT_ID", 1);
	break;
}



/*
**	Array with the languages we support.
**	After this we check of the requested
**	language pack is supported. If not,
**	redirect the visitor to the map.
*/

$_recognized_languages = array(
	"nl" => "Nederlands",		// Netherlands
	"be" => "Belgisch",			// Belgium
	"de" => "Deutsch",			// Germany
	"en" => "English",			// Great Britain
	"dk" => "Dansk",			// Denmark,
	"it" => "Italiano"			// Denmark
);

$_language_keys = array_keys($_recognized_languages);



/*
**	Get all the language files in the system. This
**	gets the files and translates them info a array.
**	Language packs are not commited to the branch
**	soo they're website-specific.
*/

$_found_languages = array();

if($handle = opendir($_SERVER['DOCUMENT_ROOT'] . '/library/languages/')) 
{
    while(false !== ($entry = readdir($handle))) 
    {
	    if($entry == "." || $entry == ".." || is_dir($entry))
	    {
		    continue;
		}
	    
	    $entry = str_replace(".xml", "", $entry);
	    
	    if(in_array($entry, $_language_keys))
	    {
	        $_found_languages[] = $entry;
	    }
    }

    closedir($handle);
}



/*
**	This is the default currency setting
**	for the languages. Users may choose a
**	diffrent currency, but this is shown as
**	the default one. At this moment Merchant
**	supports EURO and GREAT BRITISH POUNDS.
*/

$_default_currency = array(
	"nl" => "EUR",
	"be" => "EUR",
	"de" => "EUR",
	"en" => "GBP",
	"it" => "EUR",
);



/*
**
*/

$_recognized_currencies = array();

foreach($_found_languages AS $abbreviation)
{
	$_recognized_currencies[] = $_default_currency[strtolower($abbreviation)];
}



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



if(!isset($_GET['language_pack']))
{
	if(count($_found_languages) == 1)
	{
		header("location: /" . strtolower($_found_languages[0]) . "/");
		exit;
	}
	
	/*
	**	No language is set. Go to the map
	**	view. The visitor can choose a country
	**	from the map.
	*/
	
	if(isset($_SESSION['currency']))
	{
		unset($_SESSION['currency']);
	}
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/modules/language/map.php");
	exit;
}
else
{
	if(in_array(strtolower($_GET['language_pack']), $_language_keys))
	{
		/*
		**	The language is found. Load the language
		**	pack and set some information in order
		**	for Google to index the right information.
		*/
		
		define("_LANGUAGE_PACK", strtolower($_GET['language_pack']));
		$_SESSION['_LANGUAGE_PACK'] = _LANGUAGE_PACK;
		
		
		/*
		**	When there is no currency set in the
		**	session $_SESSION['currency'], use the
		**	default currency for the used language.
		**	If the session is set, use that one instead.
		*/
		
		if(!isset($_SESSION['currency']))
		{
			$_currency = $_default_currency[strtolower($_GET['language_pack'])];
			$_SESSION['currency'] = $_currency;
		}
		else
		{
			if(!in_array($_SESSION['currency'], $_recognized_currencies))
			{
				$_currency = $_default_currency[strtolower($_GET['language_pack'])];
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
		
		require_once($_SERVER['DOCUMENT_ROOT'] . "/modules/language/map.php");
		exit;
	}
}
?>