<?php
if(!isset($_SESSION))
{
	session_start();
}

define("_LANGUAGE_PACK", "nl");

if(isset($_POST['zipcode']) && isset($_POST['code']))
{
	require_once($_SERVER['DOCUMENT_ROOT'] . "/library/php/classes/motherboard.php");
	$mb = new main_board();
	
	$valid = $mb->_runFunction("customercard", "validate", array($_POST['zipcode'], $_POST['code']));
	
	if(is_array($valid))
	{
		$_SESSION['customercard'] = $valid;
	}
}

header("location: " . $_SESSION['HTTP_REFERER']);
?>