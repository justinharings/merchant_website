<?php
if(isset($_GET['currency']) && isset($_GET['language_pack']) && isset($_GET['referer']))
{
	$_SESSION['currency'] = strtoupper($_GET['currency']);
	header("location: /" . $_GET['referer']);
}
?>