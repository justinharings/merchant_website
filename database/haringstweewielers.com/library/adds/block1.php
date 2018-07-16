<a href="https://www.mijntweewielers.nl/" target="_blank">
	<div class="block first">
		<div class="split">
			<img src="<?= $block1['image'] ?>" onclick="<?= ($block1['url'] ? "document.location.href='" . $block1['url'] . "'" : '') ?>" />
		</div>
		
		<div class="split text">
			<strong>
				<span style="color: <?= $mb->_translateReturn("colors", "main_color") ?> !important;">
					<?= $mb->_translateReturn("website_text", "mijn_tweewielers_1") ?>
				</span>
				
				<?= $mb->_translateReturn("website_text", "mijn_tweewielers_2") ?>
			</strong>
			<ul>
				<li><?= $mb->_translateReturn("website_text", "always_free_maintenance") ?></li>
				<li><?= $mb->_translateReturn("website_text", "save_for_cool_gifts") ?></li>
				<li><?= $mb->_translateReturn("website_text", "online_maintenance") ?></li>
				<li><?= $mb->_translateReturn("website_text", "everything_in_one_place") ?></li>
				<li><?= $mb->_translateReturn("website_text", "just_cool_to_have") ?></li>
			</ul>
		</div>
	</div>
</a>