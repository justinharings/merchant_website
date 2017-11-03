<?php
if(isset($_GET['currency']) && isset($_GET['language_pack']))
{
	$_SESSION['currency'] = strtoupper($_GET['currency']);
	header("location: " . $_SESSION['HTTP_REFERER']);
}
?>