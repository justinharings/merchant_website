<?php
function _chopString($string, $len)
{
	if(strlen($string) > $len)
	{
		return substr($string, 0, $len) . "...";
	}
	
	return $string;
}

function _createCategoryURL($name)
{
	$name = strtolower($name);
	$name = strip_tags($name);
	
	$name = str_replace(" ", "_", $name);
	$name = str_replace("/", "_", $name);
	$name = str_replace("&", "en", $name);
	
	return $name;
}

function _createStockText($stock, $categoryID, $productID, $language_pack, $status, $short = false)
{
	define("_LANGUAGE_PACK", $language_pack);
	
	if($short == true)
	{
		$short = "-short";
	}
	else
	{
		$short = "";
	}
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");
	
	$mb = new main_board();
	
	if($status > 2)
	{
		if($status == 3)
		{
			return $mb->_translateReturn("stock-text", "text-temp-sold-out" . $short);
		}
		else
		{
			return $mb->_translateReturn("stock-text", "text-sold-out" . $short);
		}
	}
	else
	{
		$stock_type = 0;
		
		if($categoryID == 0 && $productID > 0)
		{
			$product = $mb->_runFunction("catalog", "loadProduct", array(intval($productID)));
			$stock_type = $product['stock_type'];
		}
		
		if($stock_type == 0)
		{
			$stock_type = $mb->_runFunction("catalog", "getStockType", array($categoryID));
		}
		
		$details = $mb->_runFunction("catalog", "loadProduct", array($productID));
		
		$supplier = ($details['externalStock'] > 0 ? 1 : 0);
		$delivery = ($details['delivery_days'] > 0 ? $details['delivery_days'] : 1);
		
		switch($stock_type)
		{
			case 1:
				// Actuele voorraad
				if($stock > 0)
				{
					return $mb->_translateReturn("stock-text", "actual-stock" . $short, array($stock));
				}
				else
				{
					return $mb->_translateReturn("stock-text", "actual-stock-empty" . $short);
				}
			break;
			
			case 2:
				// Actuele voorraad + leverancier
				if($stock > 0)
				{
					return $mb->_translateReturn("stock-text", "actual-stock" . $short, array($stock));
				}
				else if($supplier > 0)
				{
					return $mb->_translateReturn("stock-text", "stock-supplier" . $short, array($delivery));
				}
				else
				{
					return $mb->_translateReturn("stock-text", "actual-stock-empty" . $short);
				}
			break;
			
			case 3:
				// Stoplicht
				if($stock > 0)
				{
					return $mb->_translateReturn("stock-text", "RG-stock-G" . $short);
				}
				else
				{
					return $mb->_translateReturn("stock-text", "RG-stock-R" . $short);
				}
			break;
			
			case 4:
				// Stoplicht + leverancier
				if($stock > 0)
				{
					return $mb->_translateReturn("stock-text", "RG-stock-G" . $short);
				}
				else if($supplier > 0)
				{
					return $mb->_translateReturn("stock-text", "stock-supplier" . $short, array($delivery));
				}
				else
				{
					return $mb->_translateReturn("stock-text", "RG-stock-R" . $short);
				}
			break;
			
			case 5:
				// Altijd (beperkte) voorraad
				if($stock > 0)
				{
					return $mb->_translateReturn("stock-text", "in-stock" . $short);
				}
				else
				{
					return $mb->_translateReturn("stock-text", "limited-stock-contact" . $short);
				}
			break;
			
			case 6:
				// Altijd (beperkte) voorraad + leverancier
				if($stock > 0)
				{
					return $mb->_translateReturn("stock-text", "in-stock" . $short);
				}
				else if($supplier > 0)
				{
					return $mb->_translateReturn("stock-text", "stock-supplier" . $short, array($delivery));
				}
				else
				{
					return $mb->_translateReturn("stock-text", "limited-stock-contact" . $short);
				}
			break;
			
			case 7:
				// Altijd op voorrad
				return $mb->_translateReturn("stock-text", "in-stock" . $short);
			break;
		}
	}
}

function _dutchDate($date, $type)
{
	if($type == "date")
	{
		$oDate = new DateTime($date);
		$sDate = $oDate->format("d-m-Y");
		
		return $sDate;
	}
	else if($type == "date-text")
	{
		$oDate = new DateTime($date);
		$sDate = $oDate->format("d");
		$sDate .= " " . _dutchDate($oDate->format("m"), "month-text");
		$sDate .= " " . $oDate->format("Y");
		
		return $sDate;
	}
	else if($type == "time-short")
	{
		$oDate = new DateTime($date);
		$sDate = $oDate->format("H:i");
		
		return $sDate;
	}
	else if($type == "time-long")
	{
		$oDate = new DateTime($date);
		$sDate = $oDate->format("H:i:s");
		
		return $sDate;
	}
	else if($type == "month-text")
	{
		if($date == 0)
		{
			$date = 12;
		}
		
		switch($date)
		{
			case 1: return "Januari";
			break;
			
			case 2: return "Februari";
			break;
			
			case 3: return "Maart";
			break;
			
			case 4: return "April";
			break;
			
			case 5: return "Mei";
			break;
			
			case 6: return "Juni";
			break;
			
			case 7: return "Juli";
			break;
			
			case 8: return "Augustus";
			break;
			
			case 9: return "September";
			break;
			
			case 10: return "Oktober";
			break;
			
			case 11: return "November";
			break;
			
			case 12: return "December";
			break;
		}
	}
	else if($type == "month-text-short")
	{
		if($date == 0)
		{
			$date = 12;
		}
		
		switch($date)
		{
			case 1: return "Jan";
			break;
			
			case 2: return "Feb";
			break;
			
			case 3: return "Mrt";
			break;
			
			case 4: return "Apr";
			break;
			
			case 5: return "Mei";
			break;
			
			case 6: return "Jun";
			break;
			
			case 7: return "Jul";
			break;
			
			case 8: return "Aug";
			break;
			
			case 9: return "Sep";
			break;
			
			case 10: return "Okt";
			break;
			
			case 11: return "Nov";
			break;
			
			case 12: return "Dec";
			break;
		}
	}
	
	return $date;
}
?>