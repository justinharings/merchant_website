<div class="customer-card">
	<ul class="review">
		<li class="icon">
			<?php
			if(!isset($_SESSION['review_done']))
			{
				?>
				<a href="#" class="scroll-to-reviews">
					<img src="/library/media/review_product.png" /><br/><br/>
					<?= $mb->_translateReturn("reviews", "review-products") ?>
				</a>
				<?php
			}
			else
			{
				?>
				<img src="/library/media/review_product.png" class="faded" /><br/><br/>
				<?= $mb->_translateReturn("reviews", "review-thank-you") ?>
				<?php
			}
			?>
		</li>
		
		<li class="icon">
			<a href="<?= $mb->_translateReturn("reviews", "review-url") ?>" target="_blank">
				<img src="/library/media/review_company.png" /><br/><br/>
				<?= $mb->_translateReturn("reviews", "review-company") ?>
			</a>
		</li>
		 
		<li class="center">
			<span>
				<strong><?= $mb->_translateReturn("reviews", "review-title") ?></strong></br>
				<br/>
				<?= $mb->_translateReturn("reviews", "review-text") ?>
			</span>
		</li>
	</ul>
</div>

<?php
if(!isset($_SESSION['review_done']))
{
	?>
	<br/>
	<hr/>
	<br/><br/><br/>
	
	<h1><?= $mb->_translateReturn("reviews", "review-products-title") ?></h1>
	
	<form method="post" action="/library/php/posts/review.php">
		<input type="hidden" name="orderID" id="orderID" value="<?= intval($_GET['orderID']) ?>" />
		
		<?php
		$articles = $mb->_runFunction("review", "getProducts", array(intval($_GET['orderID'])));
		
		foreach($articles AS $article)
		{
			?>
			<div class="review-block">
				<input type="hidden" name="productID[]" id="productID" value="<?= $article['productID'] ?>" />
				<?php
				foreach($article['images'] AS $media)
				{
					if(!$media['thumb'])
					{
						continue;
					}
					?>
					
					<img src="https://merchant.justinharings.nl/library/media/products/<?= $media['productMediaID'] ?>.png" />
					
					<?php
				}
				?>
				
				<div class="review">
					<?= $mb->_translateReturn("reviews", "review-stars") ?>:<br/>
					<select name="stars[]" id="stars">
						<option>1 <?= $mb->_translateReturn("reviews", "review-stars-figure") ?></option>
						<option>2 <?= $mb->_translateReturn("reviews", "review-stars-figure") ?></option>
						<option>3 <?= $mb->_translateReturn("reviews", "review-stars-figure") ?></option>
						<option>4 <?= $mb->_translateReturn("reviews", "review-stars-figure") ?></option>
						<option selected="selected">5 <?= $mb->_translateReturn("reviews", "review-stars-figure") ?></option>
					</select><br/>
					<br/>
					<?= $mb->_translateReturn("reviews", "review-description") ?>:<br/>
					<textarea name="description[]" id="description"></textarea>
				</div>
			</div>
			<?php
		}
		?>
		
		<hr/>
						
		<input type="submit" name="add_reviews" id="add_reviews" value="<?= $mb->_translateReturn("reviews", "add-reviews") ?>" class="right" />
		<input type="button" name="return" id="return" value="<?= $mb->_translateReturn("cart", "return-to-shop") ?>" class="right white" click="/<?= _LANGUAGE_PACK ?>/" />
	</form>
	<?php
}
?>