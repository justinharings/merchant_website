<?php
class catalog extends main_board
{
	/*
	**	data[0] =	categoryID
	*/
	
	public function loadCatalogTree($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		
		$array = array();
		$array[] = $this->_merchantID;
		$array[] = "";
		$array[] = "categories.name";
		$array[] = 9999;
		$array[] = $data[0];
		
		$return = $mb->_runFunction("categories", "view", $array);
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function getStockType($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("categories", "frontend_getStockType", array($data[0]));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function loadProduct($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("products", "load", array($data[0]));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function loadFilterValues($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("categories", "front_filterValues", array($data[0], _LANGUAGE_PACK));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function loadBrandTree($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("categories", "front_viewBrands", array($data[0]));
		
		return $return;
	}
	
	
	
	/*
	**	data[0] =	categoryID
	*/
	
	public function loadCatalog($data)
	{
		parent::_checkInputValues($data, 1);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("categories", "load", array($data[0]));
		
		return $return;
	}
	
	
	
	/*
	**
	*/
	
	public function viewFavorites($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("products", "front_highRated", array($this->_merchantID));
		
		return $return;
	}
	
	
	
	/*
	**	
	*/
	
	public function loadProducts($data)
	{
		parent::_checkInputValues($data, 2);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("products", "front_loadProducts", array($this->_merchantID, $data[0], $data[1]));
		
		return $return;
	}
}
?>