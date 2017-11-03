<?php
class customercard extends main_board
{
	public function validate($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("customers", "front_validateCard", array($data[0], $data[1]));
		
		$orders = array();
		$workorders = array();
		
		foreach($return['orders'] AS $key => $value)
		{
			$orders[] = $value;
		}
		
		foreach($return['workorders'] AS $key => $value)
		{
			$workorders[] = $value;
		}
		
		$return['orders'] = $orders;
		$return['workorders'] = $workorders;
		
		return $return;
	}
	
	
	
	public function loadOrder($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("orders", "load", array($data[0]));
		
		return $return;
	}
}
?>