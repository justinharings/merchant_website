<?php
class main_board
{
	protected $_merchantID = _MERCHANT_ID;
	
	protected $language_xml = null;
	protected $thirdPartyApps = array();
	
	
	
	public function _merchant_id()
	{
		return $this->_merchantID;
	}
	
	
	public function num_rows($result)
	{
		return mysqli_num_rows($result);
	}
	
	
	/*
	**	Construct the motherboard class. The language pack is
	**	loaded by the motherboard for quick access and
	**	translations as well by other classes as the site itself.
	*/
	
	public function __construct()
	{
		$folder = $_SERVER['DOCUMENT_ROOT'] . "/database/" . _DATABASE_FOLDER . "/library/languages/" . strtolower(_LANGUAGE_PACK) . ".xml";
		
		if(file_exists($folder))
		{
			$this->language_xml = file_get_contents($folder);
		}
		else
		{
			if(defined("_DEVELOPMENT_ENVIRONMENT") && _DEVELOPMENT_ENVIRONMENT == true)
			{
				die("Language pack <em>" . strtolower(_LANGUAGE_PACK) . ".xml</em> not found in:<br/>" . $folder);
			}
			else
			{
				$this->_throwUserError();
			}
		}
	}
	
	
	
	/*
	**	Create and show the user-friendly error page.
	**	If the error page is not found, show the apache
	**	default HTTP error.
	*/
	
	private function _throwUserError($type = "")
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/modules/errors/general.php"))
		{
			require_once($_SERVER['DOCUMENT_ROOT'] . "/modules/errors/general.php");
			exit;
		}
		else
		{
			header("HTTP/1.1 500 Internal Server Error");
			die();
		}
	}
	
	
	
	/*
	**	Return a single translated word used for
	**	display on the webpage.
	*/
	
	public function _translateReturn($group, $word, $words = array())
	{
		$xml = simplexml_load_string($this->language_xml);
		
		return vsprintf(
			$xml->$group->$word,
			$words
		);
	}
	
	
	
	/*
	**	Return the contents of a .TXT file located
	**	in the quick-access library folder.
	*/
	
	public function _returnTXT($file)
	{
		return file_get_contents("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/txt/" . $file . ".txt");
	}
	
	
	
	/*
	**	Call a second-class and run a function within it.
	**	If the class or the function doesn't exists, an
	**	error is given by the motherboard.
	*/
	
	public function _runFunction($className, $function, $values = array())
	{
		if(file_exists(__DIR__ . "/" . $className . ".php"))
		{
			require_once(__DIR__ . "/" . $className . ".php");
			
			$class = new $className();
			
			if(!method_exists($class, $function))
			{
				if(defined("_DEVELOPMENT_ENVIRONMENT") && _DEVELOPMENT_ENVIRONMENT == true)
				{
					die("Function <em>" . $function . "</em> does not exists within the given class <em>" . $className . "</em>");
				}
				else
				{
					$this->_throwUserError();
				}
			}
			
			return $class->$function($values);
		}
		else
		{
			if(defined("_DEVELOPMENT_ENVIRONMENT") && _DEVELOPMENT_ENVIRONMENT == true)
			{
				die("Class <em>" . $class . "</em> is not found, the file doesn't exists.");
			}
			else
			{
				$this->_throwUserError();
			}
		}
	}
	
	
	
	/*
	**	Load third-party apps by using the autoloader. If
	**	there is no autoloader found, give an error.
	**	After loading the app, add it to a array. Check,
	**	before loading, if the app isn't loaded before.
	*/
	
	public function _requireThirdParty($folder)
	{
		$apps = $this->thirdPartyApps;
		
		if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/library/third-party/" . $folder . "/autoload.php"))
		{
			if(!in_array($folder, $apps))
			{
				require_once($_SERVER['DOCUMENT_ROOT'] . "/library/third-party/" . $folder . "/autoload.php");
				
				$apps[] = $folder;
				$this->thirdPartyApps = $apps;
			}
			else
			{
				if(defined("_DEVELOPMENT_ENVIRONMENT") && _DEVELOPMENT_ENVIRONMENT == true)
				{
					die("Third-party software package <em>" . $folder . "</em> is called to load twice.");
				}
				else
				{
					$this->_throwUserError();
				}
			}
		}
		else
		{
			if(defined("_DEVELOPMENT_ENVIRONMENT") && _DEVELOPMENT_ENVIRONMENT == true)
			{
				die("Third-party software package <em>" . $folder . "</em> is not found or the autoloader is not installed.");
			}
			else
			{
				$this->_throwUserError();
			}
		}
	}
	
	
	
	/*
	**	This function can be called by a child-class 
	**	to check if the values given to a function
	**	are complete. If not, throw exception.
	*/
	
	public function _checkInputValues($values, $count)
	{
		$correct = true;
		
		if(!is_array($values))
		{
			$correct = false;
		}
		
		if($count != count($values))
		{
			$correct = false;
		}
		
		if($correct == false)
		{
			if(defined("_DEVELOPMENT_ENVIRONMENT") && _DEVELOPMENT_ENVIRONMENT == true)
			{
				die("Class error. Wrong strings given.<br/>" . print_r($values, true));
			}
			else
			{
				$this->_throwUserError();
			}
		}
	}
	
	
	
	/*
	**
	*/
	
	public function real_escape_string($string)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		return $mb->_runFunction("database", "real_escape_string", $string);
	}
	
	
	
	/*
	**	Return a array with all the worldwide countries.
	**	This array is a download from the internet.
	*/
	
	public function _allCountries()
	{
		return array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
	}
	
	
	
	/*
	**
	*/
	
	public function replaceCurrency($amount, $currency)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		
		switch(strtoupper($currency))
		{
			default:
				return ($amount);
			break;
			
			case "GBP":
				$target = $mb->replaceCurrency("GBP");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
			
			case "USD":
				$target = $mb->replaceCurrency("USD");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
			
			case "DKK":
				$target = $mb->replaceCurrency("DKK");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
			
			case "NOK":
				$target = $mb->replaceCurrency("NOK");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
			
			case "CHF":
				$target = $mb->replaceCurrency("CHF");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
			
			case "AUD":
				$target = $mb->replaceCurrency("AUD");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
			
			case "CAD":
				$target = $mb->replaceCurrency("CAD");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
			
			case "SEK":
				$target = $mb->replaceCurrency("SEK");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
			
			case "BRL":
				$target = $mb->replaceCurrency("BRL");
				
				if($target == 0)
				{
					return ($amount);
				}
				else
				{
					return (($amount * $target));
				}
			break;
		}
	}
}
?>