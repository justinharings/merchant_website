<?php
class content extends main_board
{
	/*
	**	
	*/
	
	public function load($data)
	{
		parent::_checkInputValues($data, 2);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("cms", "front_loadContent", array($this->_merchantID, $data[0], $data[1]));
		
		return $return;
	}
}