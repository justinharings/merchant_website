<?php
define("_endtimeYear", "2018");
define("_endtimeMonth", "11");
define("_endtimeDate", "7");

$current = new DateTime();
$countdw = new DateTime(_endtimeYear . '-' . _endtimeMonth . '-' . _endtimeDate);

$current->setTimezone(new DateTimeZone('Europe/Amsterdam'));
$countdw->setTimezone(new DateTimeZone('Europe/Amsterdam'));

if($current > $countdw)
{
	rename('force.php', '_force.php');
	header("location: /");
}

require($_SERVER['DOCUMENT_ROOT'] . "/library/third-party/countdown/index.php");
exit;
?>