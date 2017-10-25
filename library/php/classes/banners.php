<?php
class banners extends main_board
{
	/*
	**	Load the banners from Merchant. Based on the
	**	group name given. If it's more then 1, return
	**	a arary. If not, return a image.
	*/
	
	public function loadMerchantBanner($data)
	{
		parent::_checkInputValues($data, 2);
		
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("cms", "front_loadBanner", array($this->_merchantID, $data[0], $data[1], _LANGUAGE_PACK));
		
		if(count($return) == 1)
		{
			return $return[0];
		}
		
		return $return;
	}
}
?>