<?php
class paylinks extends main_board
{
	public function validateCode($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("paylink", "front_validateCode", array($data[0]));
		
		return $return;
	}
	
	public function load($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("paylink", "front_loadPaylink", array($data[0]));
		
		return $return;
	}
	
	public function loadPaymentMethod($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("payment_methods", "load", array($data[0]));
		
		return $return;
	}
	
	public function startPaylink($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("orders", "front_startPaylink", $data);
	}
}
?>