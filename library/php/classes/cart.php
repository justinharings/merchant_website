<?php
class cart extends main_board
{
	/*
	**	Count the items that are in the shoppingcart.
	**	Used for the front-end to view how many products
	**	are added to the cart.
	*/
	
	public function countCartItems()
	{
		if(isset($_SESSION['cart']))
		{
			return count($_SESSION['cart']);
		}
		
		return 0;
	}
	
	
	/*
	**
	*/
	
	public function addCartItem($data)
	{
		$cart = array();
		
		foreach($data[1] AS $item)
		{
			$cart[] = $item;
		}
		
		$num = count($cart);
		
		$cart[$num]['productID'] = $data[0];
		$cart[$num]['quantity'] = 1;
		
		return $cart;
	}
	
	
	
	/*
	**
	*/
	
	public function deleteCartItem($data)
	{
		$cart = array();
		
		foreach($data[1] AS $item)
		{
			$cart[] = $item;
		}
		
		unset($cart[$data[0]]);
		
		return $cart;
	}
	
	
	
	/*
	**
	*/
	
	public function quantityCartItem($data)
	{
		$cart = array();
		
		foreach($data[2] AS $item)
		{
			$cart[] = $item;
		}
		
		$cart[$data[0]]['quantity'] = $data[1];
		
		return $cart;
	}
	
	
	
	/*
	**
	*/
	
	public function pickupLocations()
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("stock", "viewLocations", array($this->_merchantID, "", "locations.name", "0,9999"));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function paymentMethods()
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("payment_methods", "view", array($this->_merchantID, "", "payment_methods.name", "0,9999"));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function shipmentMethods()
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("shipment_methods", "view", array($this->_merchantID, "", "shipment_methods.name", "0,9999"));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function defaultStatusID($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("order_statuses", "loadDefaultStatus", array($data[0]));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function getEmployeeID($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("pos", "loadEmployeeSettings", array($this->_merchantID));
		
		foreach($return AS $key => $employee)
		{
			if($employee['locationID'] == $data[0])
			{
				return $employee['employeeID'];
				false;
			}
		}
		
		return 0;
	}
	
	
	
	/*
	**
	*/
	
	public function getLocation($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("stock", "loadLocation", array($data[0]));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function runOrder($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("orders", "runOrder", $data);

		return $return;
	}
	
	
	
	public function loadGeneralSettings($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("pos", "loadGeneralSettings", $data);

		return $return;
	}
}
?>