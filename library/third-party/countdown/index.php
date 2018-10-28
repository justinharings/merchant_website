<?php
$background = $mb->_runFunction("banners", "loadMerchantBanner", array(_LANGUAGE_PACK, "language_background"));
$background = $background['image'];
?>

<!DOCTYPE html>
<html lang="<?= _LANGUAGE_PACK ?>">
	<head>
		<title><?= $mb->_runFunction("head", "title") ?></title>
		
		<meta name="google-site-verification" content="<?= $mb->_translateReturn("html_head", "google-site-verification") ?>" />
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="<?= _LANGUAGE_PACK ?>" />
		
		<meta name="robots" content="index, follow" />
		<meta name="description" content="<?= $mb->_runFunction("head", "description") ?>" />
		<meta name="keywords" content="<?= $mb->_runFunction("head", "keywords") ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	
		<link type="image/x-icon" rel="icon" href="/database/<?= _DATABASE_FOLDER ?>/library/media/<?= $mb->_translateReturn("images", "favicon") ?>" />
		<link type="image/x-icon" rel="shortcut icon" href="/database/<?= _DATABASE_FOLDER ?>/library/media/<?= $mb->_translateReturn("images", "favicon") ?>" />
	
		<link rel="stylesheet" href="/library/third-party/countdown/https://fonts.googleapis.com/css?family=Open+Sans:400,700%7CPoppins:400,500">
		<link rel="stylesheet" href="/library/third-party/countdown/common-css/ionicons.css">
		<link rel="stylesheet" href="/library/third-party/countdown/common-css/jquery.classycountdown.css" />
		<link rel="stylesheet" href="/library/third-party/countdown/css/styles.css">
		<link rel="stylesheet" href="/library/third-party/countdown/css/responsive.css">
	</head>

	<body>
	<div class="main-area-wrapper" style="background-image: url('<?= $background ?>?rand=<?= rand(0,99999) ?>')">
		<div class="main-area center-text" >
			
			<div class="display-table">
				<div class="display-table-cell">
					
					<h1 class="title"><b>COMING SOON</b></h1>
					<p class="desc font-white" style="text-transform: uppercase;">
						We're going live soon! In the meantime.. Follow us on Social Media
						for updates, cool photo's and more!
					</p>
					
					<div id="normal-countdown" data-date="<?= _endtimeYear ?>/<?= _endtimeMonth ?>/<?= _endtimeDate ?>"></div>
					
					<ul class="social-btn">
						<li class="list-heading">FOLLOW US ON</li>
						
						<?php
						if	(
								$mb->_translateReturn("urls", "facebook") != ""
								&& intval($mb->_returnTXT("facebook_" . $mb->_translateReturn("urls", "facebook"))) > 0
							)
						{
							?>
							<li><a target="_blank" href="https://www.facebook.com/<?= $mb->_translateReturn("urls", "facebook") ?>"><i class="ion-social-facebook"></i></a></li>
							<?php
						}
						
						if	(
								$mb->_translateReturn("urls", "twitter") != ""
								&& intval($mb->_returnTXT("twitter_" . $mb->_translateReturn("urls", "twitter"))) > 0
							)
						{
							?>
							<li><a target="_blank" href="https://www.twitter.com/<?= $mb->_translateReturn("urls", "twitter") ?>"><i class="ion-social-twitter"></i></a></li>
							<?php
						}

						if	(
								$mb->_translateReturn("urls", "instagram") != ""
								&& intval($mb->_returnTXT("instagram_" . $mb->_translateReturn("urls", "instagram"))) > 0
							)
						{
							?>
							<li><a target="_blank" href="https://www.instagram.com/<?= $mb->_translateReturn("urls", "instagram") ?>"><i class="ion-social-instagram-outline"></i></a></li>
							<?php
						}
						?>
					</ul>
					
				</div><!-- display-table -->
			</div><!-- display-table-cell -->
		</div><!-- main-area -->
	</div><!-- main-area-wrapper -->
	
	
	<!-- SCIPTS -->
	
	<script src="/library/third-party/countdown/common-js/jquery-3.1.1.min.js"></script>
	
	<script src="/library/third-party/countdown/common-js/jquery.countdown.min.js"></script>
	
	<script src="/library/third-party/countdown/common-js/scripts.js"></script>
	
</body>
</html>