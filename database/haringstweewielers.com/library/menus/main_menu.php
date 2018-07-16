<?php
$color1 = "";
$color2 = "";
$color3 = "";
$color4 = "";
$color5 = "";

if($mb->_translateReturn("main_menu", "item_1_colored") == 1)
{
	$color1 = "color: ". $mb->_translateReturn("colors", "main_color") ." !important;";
}

if($mb->_translateReturn("main_menu", "item_2_colored") == 1)
{
	$color2 = "color: ". $mb->_translateReturn("colors", "main_color") ." !important;";
}

if($mb->_translateReturn("main_menu", "item_3_colored") == 1)
{
	$color3 = "color: ". $mb->_translateReturn("colors", "main_color") ." !important;";
}

if($mb->_translateReturn("main_menu", "item_4_colored") == 1)
{
	$color4 = "color: ". $mb->_translateReturn("colors", "main_color") ." !important;";
}

if($mb->_translateReturn("main_menu", "item_5_colored") == 1)
{
	$color5 = "color: ". $mb->_translateReturn("colors", "main_color") ." !important;";
}
?>

<ul class="header-menu">
	<li>
		<a href="/<?= _LANGUAGE_PACK ?><?= $mb->_translateReturn("main_menu", "item_1_url") ?>" style="<?= $color1 ?>"><?= $mb->_translateReturn("main_menu", "item_1") ?></a>
	</li>
	
	<li>
		<a href="/<?= _LANGUAGE_PACK ?><?= $mb->_translateReturn("main_menu", "item_2_url") ?>" style="<?= $color2 ?>"><?= $mb->_translateReturn("main_menu", "item_2") ?></a>
	</li>
	
	<li>
		<a href="/<?= _LANGUAGE_PACK ?><?= $mb->_translateReturn("main_menu", "item_3_url") ?>" style="<?= $color3 ?>"><?= $mb->_translateReturn("main_menu", "item_3") ?></a>
	</li>
	
	<li>
		<a href="/<?= _LANGUAGE_PACK ?><?= $mb->_translateReturn("main_menu", "item_4_url") ?>" style="<?= $color4 ?>"><?= $mb->_translateReturn("main_menu", "item_4") ?></a>
	</li>
	
	<li>
		<a href="/<?= _LANGUAGE_PACK ?><?= $mb->_translateReturn("main_menu", "item_5_url") ?>" style="<?= $color5 ?>"><?= $mb->_translateReturn("main_menu", "item_5") ?></a>
	</li>
</ul>