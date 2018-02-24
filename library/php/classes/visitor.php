<?php
class visitor extends main_board
{
	public function logVisit()
	{
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/database.php");
		require_once("/var/www/vhosts/justinharings.nl/merchant.justinharings.nl/library/php/classes/motherboard.php");
		
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$ip = "";
		
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else 
		{
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		
		$mb = new motherboard();
		$mb->_runFunction("visitors", "log_visitor", array($this->_merchantID, $ip, $actual_link, $_SERVER['HTTP_USER_AGENT']));
	}
}	
?>