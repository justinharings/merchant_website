<?php
if(file_exists(__DIR__ . "/force.php"))
{
	require_once(__DIR__ . "/force.php");
	exit;
}



// Start session

if(!isset($_SESSION))
{
	session_start();
}

foreach($_SESSION AS $key => $session)
{
	//unset($_SESSION[$key]);
}



/*
**	Tell the classes and functions if the development
**	mode is activated or not. This will allow the classes
**	to display a user-friendly message or the real 
**	PHP exception for the developer.
*/

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$actual_link = "websites.";
define("_DEVELOPMENT_ENVIRONMENT", (strpos($actual_link, "websites.") !== false ? true : false));



/*
**	Routers are used for redirecting people to
**	the right part of the website. They may change
**	some settings before redirecting.
*/

require_once(__DIR__ . "/library/php/routers/paylink.php");
require_once(__DIR__ . "/library/php/routers/currency.php");
require_once(__DIR__ . "/library/php/routers/language.php");
require_once(__DIR__ . "/library/php/routers/countries.php");



/*
**	Functions are added here. Used for quick access to all
**	of the extended special functions, all the files
**	are added to the core here.
*/

require_once(__DIR__ . "/library/php/functions/arrays.php");
require_once(__DIR__ . "/library/php/functions/floats.php");
require_once(__DIR__ . "/library/php/functions/text.php");



/*
**	Classes are included here. We use a motherboard
**	class that is able to construct all the classes
**	and is able to run this class his function.
*/

require_once(__DIR__ . "/library/php/classes/motherboard.php");

$mb = new main_board();



/*
**	Include the required third-party software.
**	Each software package includes a autoload.php
**	file that is requiring all of the needed
**	packages. If there is no autoload, a error is displayed.
*/

$mb->_requireThirdParty("minify-master");
$mb->_requireThirdParty("path-converter");



/*
**	Load the website settings
*/

$settings = $mb->_runFunction("content", "settings", array());


/*
**
*/

$mb->_runFunction("visitor", "logVisit", array());



/*
**	If requested by the administrator (using the querystring /?minify),
**	the CSS and javascript files are made smaller in order for the
**	webshops performance to increase.
*/

use MatthiasMullie\Minify;

if(isset($_GET['minify']) || _DEVELOPMENT_ENVIRONMENT)
{
	$sourcePath = $_SERVER['DOCUMENT_ROOT'] . '/library/css/motherboard.css';
	$savePath = $_SERVER['DOCUMENT_ROOT'] . '/library/css/motherboard.minified.css';
	
	$minifier = new Minify\CSS();
	$minifier->add($sourcePath);
	$minifier->minify($savePath);
	
	
	$sourcePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/motherboard.js';
	$savePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/motherboard.minified.js';
	
	$minifier = new Minify\JS();
	$minifier->add($sourcePath);
	$minifier->minify($savePath);
	
	
	$sourcePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/homepage.js';
	$savePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/homepage.minified.js';
	
	$minifier = new Minify\JS();
	$minifier->add($sourcePath);
	$minifier->minify($savePath);
	
	
	$sourcePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/cart.js';
	$savePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/cart.minified.js';
	
	$minifier = new Minify\JS();
	$minifier->add($sourcePath);
	$minifier->minify($savePath);
	
	
	$sourcePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/datemask.js';
	$savePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/datemask.minified.js';
	
	$minifier = new Minify\JS();
	$minifier->add($sourcePath);
	$minifier->minify($savePath);
	
	$sourcePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/starrating.js';
	$savePath = $_SERVER['DOCUMENT_ROOT'] . '/library/js/starrating.minified.js';
	
	$minifier = new Minify\JS();
	$minifier->add($sourcePath);
	$minifier->minify($savePath);
}



$open = false;

if(date("G") > 9 && date("G") < 18)
{
	$open = true;
}



/*
**	Set the currect url as last one.
*/

$_SESSION['HTTP_REFERER'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!DOCTYPE html>
<html lang="<?= _LANGUAGE_PACK ?>">
	<head>
		<title><?= $mb->_runFunction("head", "title") ?></title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="<?= _LANGUAGE_PACK ?>" />
		
		<meta name="robots" content="index, follow" />
		<meta name="description" content="<?= $mb->_runFunction("head", "description") ?>" />
		<meta name="keywords" content="<?= $mb->_runFunction("head", "keywords") ?>" />

		<?php
		foreach($_found_languages AS $abbreviation)
		{
			?>
			<link rel="alternate" hreflang="<?= $abbreviation ?>" href="<?= str_replace("/"._LANGUAGE_PACK."/", "/".$abbreviation."/", $_SESSION['HTTP_REFERER']) ?>">
			<?php
		}
		?>

		<link type="image/x-icon" rel="icon" href="/library/media/<?= $mb->_translateReturn("images", "favicon") ?>" />
		<link type="image/x-icon" rel="shortcut icon" href="/library/media/<?= $mb->_translateReturn("images", "favicon") ?>" />
		
		<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="/library/css/motherboard.minified.css" />

		<?php
		if($open)
		{
			?>
			<script>(function(d,a){function c(){var b=d.createElement("script");b.async=!0;b.type="text/javascript";b.src=a._settings.messengerUrl;b.crossOrigin="anonymous";var c=d.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}window.kayako=a;a.readyQueue=[];a.newEmbedCode=!0;a.ready=function(b){a.readyQueue.push(b)};a._settings={apiUrl:"https://harings-tweewielers.kayako.com/api/v1",teamName:"Harings Tweewielers",homeTitles:[{"locale":"en-us","translation":"Hello! 👋"}],homeSubtitles:[{"locale":"en-us","translation":"Stel gerust uw vragen via de chat! We beantwoorden alle vragen zo snel mogelijk. Ontvangt u niet direct een reactie? Laat dan uw e-mail adres achter. We komen zo snel mogelijk terug op uw vraag! You're not Dutch? Well let me translate... Ask anything you want. If you're not receiving a reply on short notice, please leave your e-mail address and we get back to you ASAP!"}],messengerUrl:"https://harings-tweewielers.kayakocdn.com/messenger",realtimeUrl:"wss://kre.kayako.net/socket",widgets:{presence:{enabled:false},twitter:{enabled:false,twitterHandle:"738160281235292160"},articles:{enabled:false,sectionId:1}},styles:{primaryColor:"#d00000",homeBackground:"#FF3B30",homePattern:"https://assets.kayako.com/messenger/pattern-9.svg",homeTextColor:"#FFFFFF"}};window.attachEvent?window.attachEvent("onload",c):window.addEventListener("load",c,!1)})(document,window.kayako||{});</script>
			<?php
		}
		?>

		<script type="text/javascript" src="//code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript" src="/library/js/motherboard.minified.js"></script>
	</head>

	<body>
		
		<!--
		----	Top DIV, the the bar at the top
		----	of the webpage. Including the content.
		--->
		
		<?php
		if(strtoupper($_country_code) != strtoupper(_LANGUAGE_PACK) && !isset($_SESSION['country_selection']))
		{
			?>
			
			<div class="language-overlay"></div>
			
			<?php
		}
		?>
		
		<div class="top">
			<div class="container">
				<div class="top-left">
					<div class="top-item submenu-active">
						<?php
						if(strtoupper($_country_code) != strtoupper(_LANGUAGE_PACK) && !isset($_SESSION['country_selection']))
						{
							$_SESSION['country_selection'] = true;
							?>
							
							<div class="language-arrow">
								<img src="/library/media/language_choice.png" />
							</div>
							
							<?php
						}
						?>
						
						<a href="/">
							<?= $mb->_translateReturn("info", "full_name") ?>
							
							<?php
							if(count($_found_languages) > 1)
							{
								?>
								<span class="lnr lnr-chevron-down"></span>
								
								<nav>
									<div class="top-item-submenu">
										<ul>
											<?php
											foreach($_found_languages AS $abbreviation)
											{
												$name = $_recognized_languages[$abbreviation];
												
												$url = $_actual_link . $_SERVER['REQUEST_URI'];
												$url = str_replace("/"._LANGUAGE_PACK."/", "/".$abbreviation."/", $url);
												?>
												
												<li>
													<a href="<?= $url ?>"><?= $name ?></a>
												</li>
												
												<?php
											}
											?>
										</ul>
									</div>
								</nav>
								<?php
							}
							?>
						</a>
					</div>
					
					<div class="top-item submenu-active">
						<?= _CURRENCY ?> (<?= _CURRENCY_SIGN ?>)
						
						<?php
						$had = array();
							
						if(count($_recognized_currencies) > 1)
						{
							?>
							<span class="lnr lnr-chevron-down"></span>
							
							<nav>
								<div class="top-item-submenu">
									<ul>
										<?php
										foreach($_recognized_currencies AS $abbreviation)
										{
											if(in_array($abbreviation, $had))
											{
												continue;
											}
											
											$had[] = $abbreviation;
											?>
											<li>
												<a href="/<?= strtolower(_LANGUAGE_PACK) ?>/currency/<?= $abbreviation ?>/"><?= $abbreviation ?>&nbsp;(<?= $_currencies_symbols[$abbreviation] ?>)</a>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
							</nav>
							<?php
						}
						?>
					</div>
					
					<div class="top-item text-<?= $open ? "green open-kayako" : "" ?>">
						<span class="lnr lnr-bubble large"></span>
						<?= $open ? $mb->_translateReturn("others", "chat_online") : $mb->_translateReturn("others", "chat_offline") ?>
					</div>
				</div>
				
				<div class="top-right">
					<div class="top-item">
						<a href="https://www.instagram.com/<?= $mb->_translateReturn("urls", "instagram") ?>/" target="_blank" class="text-color-instagram">
							<span class="fa fa-instagram"></span>
							
							<?= $mb->_returnTXT("instagram_" . $mb->_translateReturn("urls", "instagram")) ?>
							<span class="hide-portrait">photo lovers!</span>
						</a>
					</div>
					
					<div class="top-item">
						<a href="https://www.twitter.com/<?= $mb->_translateReturn("urls", "twitter") ?>/" target="_blank" class="text-color-twitter">
							<span class="fa fa-twitter"></span>
							
							<?= $mb->_returnTXT("twitter_" . $mb->_translateReturn("urls", "twitter")) ?>
							<span class="hide-portrait">dedicated followers!</span>
						</a>
					</div>
					
					<div class="top-item">
						<a href="https://www.facebook.com/<?= $mb->_translateReturn("urls", "facebook") ?>/" target="_blank" class="text-color-facebook">
							<span class="fa fa-facebook-square"></span>
							
							<?= $mb->_returnTXT("facebook_" . $mb->_translateReturn("urls", "facebook")) ?>
							<span class="hide-landscape">happy likers!</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		
		
		
		<!--
		----	Header DIV, containing the logo, menu,
		----	search button and shoppingcart button.
		--->
		
		<header>
			<div class="header">
				<div class="container">
					<div class="header-content">
						<a href="/<?= _LANGUAGE_PACK ?>/">
							<img class="logo" src="/library/media/<?= $mb->_translateReturn("images", "logo") ?>" />
						</a>
						
						<img class="expert" src="/library/media/<?= $mb->_translateReturn("images", "expert") ?>" />
						
						<nav>
							<?php
							if(file_exists(__DIR__ . "/library/menus/main_menu.php"))
							{
								require_once(__DIR__ . "/library/menus/main_menu.php");
							}
							?>
						</nav>
						
						<ul class="header-icons">
							<li>
								<span class="lnr lnr-cart" click="/<?= _LANGUAGE_PACK ?>/system/cart.html"></span>
								<div class="cart-count" click="/<?= _LANGUAGE_PACK ?>/system/cart.html"><?= $mb->_runFunction("cart", "countCartItems") ?></div>
								
								<div class="cart-notification">
									<span class="fa fa-caret-up"></span>
									
									<strong><?= $mb->_translateReturn("cart", "added-cart") ?></strong>
									
									<div class="button" click="/<?= _LANGUAGE_PACK ?>/system/cart.html">
										<?= $mb->_translateReturn("cart", "button-goto-cart") ?>
									</div>
									
									<div class="button light">
										<?= $mb->_translateReturn("cart", "button-continue-shopping") ?>
									</div>
								</div>
							</li>
							
							<li>
								<span class="lnr lnr-magnifier open-search"></span>
								
								<div class="search-field">
									<span class="fa fa-caret-up"></span>
									
									<strong><?= $mb->_translateReturn("website_text", "search") ?></strong>
									
									<form method="post" onsubmit="window.location.href = '/<?= _LANGUAGE_PACK ?>/search/' + search.value; return false;">
										<input type="text" name="search" id="search" value="" autocomplete="off" />
									</form>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</header>
		
		<main>
			<div class="content">
				<div class="container">
					<?php
					if($settings['note_content'])
					{
						?>
						<div class="notification">
							<?= $settings['note_content'] ?>
						</div>
						<?php
					}
						
					if(isset($_GET['module']))
					{
						if(file_exists(__DIR__ . "/modules/" . $_GET['module'] . "/" . $_GET['page'] . ".php"))
						{
							require_once(__DIR__ . "/modules/" . $_GET['module'] . "/" . $_GET['page'] . ".php");
						}
						else
						{
							?>
							<script type="text/javascript">
								window.location.href = '/<?= _LANGUAGE_PACK ?>/errors/404.html';
							</script>
							<?php
						}
					}
					else
					{
						require_once(__DIR__ . "/modules/homepage/homepage.php");
					}
					?>
				</div>
			</div>
		</main>
		
		<footer>
			<div class="advertisement">
				<?php
				$logos = $mb->_runFunction("banners", "loadMerchantBanner", array("nl", "home_logos"));

				$block1 = $mb->_runFunction("banners", "loadMerchantBanner", array("nl", "footer_block_1"));
				$block2 = $mb->_runFunction("banners", "loadMerchantBanner", array("nl", "footer_block_2"));
				?>
				
				<div class="container">
					<div class="advertisement-blocks">
						<?php
						if(file_exists(__DIR__ . "/library/adds/block1.php"))
						{
							require_once(__DIR__ . "/library/adds/block1.php");
						}
						
						if(file_exists(__DIR__ . "/library/adds/block2.php"))
						{
							require_once(__DIR__ . "/library/adds/block2.php");
						}
						?>
					</div>
					
					<div class="logo-cloud">
						<?php
						foreach($logos AS $logo)
						{
							?>
							<img src="<?= $logo['image'] ?>" click="<?= $logo['url'] ?>" />
							<?php
						}
						?>
					</div>
				</div>
			</div>
			
			<div class="footer">
				<div class="container">
					<div class="block hide-portrait">
						<strong><?= $mb->_translateReturn("footer", "follow_us") ?></strong>
						
						<div class="clear">
							<a href="https://www.facebook.com/<?= $mb->_translateReturn("urls", "facebook") ?>/" target="_blank">
								<span class="fa fa-facebook-official"></span>
							</a>
							
							<a href="https://www.twitter.com/<?= $mb->_translateReturn("urls", "twitter") ?>/" target="_blank">
								<span class="fa fa-twitter"></span>
							</a>
							
							<a href="https://www.instagram.com/<?= $mb->_translateReturn("urls", "instagram") ?>/" target="_blank">
								<span class="fa fa-instagram"></span>
							</a>
						</div>
					</div>
					
					<div class="block">
						<strong><?= $mb->_translateReturn("footer", "customer_service") ?></strong>
						
						<div class="clear">
							<a href="/<?= _LANGUAGE_PACK ?>/service/customer-service.html">
								<span class="fa fa-whatsapp"></span>
								<span class="fa fa-envelope-o"></span>
								<span class="fa fa-comments-o"></span>
								<span class="fa fa-phone"></span>
							</a>
						</div>
					</div>
					
					<div class="block">
						<strong><?= $mb->_translateReturn("footer", "easy_payment") ?></strong>
						
						<div class="clear">
							<a href="/<?= _LANGUAGE_PACK ?>/service/payment-methods.html">
								<?php
								$icons = $mb->_runFunction("banners", "loadMerchantBanner", array("nl", "payment_icons"));
								
								foreach($icons AS $icon)
								{
									?>
									<img src="<?= $icon['image'] ?>" />
									<?php
								}
								?>
							</a>
						</div>
					</div>
					
					<div class="block last">
						<strong><?= $mb->_translateReturn("footer", "search_shop") ?></strong>
						
						<div class="clear">
							<form method="post" onsubmit="window.location.href = '/<?= _LANGUAGE_PACK ?>/search/' + search.value; return false;">
								<input type="text" name="search" id="search" value="" autocomplete="off" />
							</form>
						</div>
					</div>
				</div>
			</div>
			
			<div class="footer-menu">
				<div class="container">
					<?php
					if(file_exists(__DIR__ . "/library/menus/footer_menu.php"))
					{
						require_once(__DIR__ . "/library/menus/footer_menu.php");
					}
					?>
					
					<div class="menu-block">
						<a href="/<?= _LANGUAGE_PACK ?>/">
							<img class="logo" src="/library/media/<?= $mb->_translateReturn("images", "logo") ?>" />
						</a>
					</div>
				</div>
			</div>
		</footer>
		
		<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
			  ga('create', 'UA-100999595-1', 'auto');
			  ga('send', 'pageview');
		
		</script>
	</body>
</html>