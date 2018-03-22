<?php
class paylinks
{
	public function validateCode($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/paylink.php");
		
		$paylink = new paylink();
		$return = $paylink->front_validateCode(array($data[0]));
		
		return $return;
	}
	
	public function getData($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/paylink.php");
		
		$paylink = new paylink();
		$return = $paylink->front_getData(array($data[0]));
		
		return $return;
	}
	
	public function getOrder($orderID)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("orders", "load", array($orderID));
		
		return $return;
	}
}
?>