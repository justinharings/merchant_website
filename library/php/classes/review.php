<?php
class review extends main_board
{
	public function getProducts($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("reviews", "front_getArticles", $data);
		
		return $return;
	}
	
	
	
	public function add($data)
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$mb = new motherboard();
		$return = $mb->_runFunction("reviews", "front_addReview", $data);
		
		return $return;
	}
}
?>