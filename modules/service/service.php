<?php
$content = $mb->_runFunction("content", "load", array(_LANGUAGE_PACK, $_GET['file']));
?>

<ul class="breadcrumbs">
	<li><a href="/<?= _LANGUAGE_PACK ?>/">home</a></li>
	<li class="spacer">-</li>
	<li>
		<strong>
			<a href="/<?= _LANGUAGE_PACK ?>/service/<?= $content['seo_url'] ?>"><?= strtolower($content['name']) ?></a>
		</strong>
	</li>
</ul>

<div class="page-menu">
	<? require_once($_SERVER['DOCUMENT_ROOT'] . "/modules/service/side_menu.php") ?>
</div>

<div class="page-content">
	<h1><?= $content['name'] ?></h1>
	
	<p>
		<?= $content['content'] ?>
	</p>
</div>