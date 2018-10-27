<a href="/<?= _LANGUAGE_PACK ?>/service/company-information.html">
	<div class="block">
		<div class="split">
			<img src="<?= $block2['image'] ?>" onclick="<?= ($block2['url'] ? "document.location.href='" . $block2['url'] . "'" : '') ?>" />
		</div>
		
		<div class="split text no-li">
			<strong>
				<span style="color: <?= $mb->_translateReturn("colors", "main_color") ?> !important;">
					<?= $mb->_translateReturn("website_text", "history") ?>
				</span>
				
				<?= $mb->_translateReturn("website_text", "since_1899") ?>
			</strong>
			<p><?= $mb->_translateReturn("website_text", "history_text") ?></p>
		</div>
	</div>
</a>