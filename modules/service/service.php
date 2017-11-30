<?php
if(strpos($_GET['file'], "success") !== false)
{
	unset($_SESSION['cart']);
}

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
	<? require_once($_SERVER['DOCUMENT_ROOT'] . "/library/menus/side_menu.php") ?>
</div>

<div class="page-content">
	<h1><?= $content['name'] ?></h1>
	
	<p>
		<?php
		//unset($_SESSION['customercard']);
			
		if(strpos($content['content'], "{{customer-account-login}}") !== false)
		{
			if(!isset($_SESSION['customercard']))
			{
				$content['content'] = str_replace("{{customer-account-login}}", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/modules/service-modules/customer_login.php"), $content['content']);
			}
			else
			{
				$content['content'] = str_replace("{{customer-account-login}}", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/modules/service-modules/customer_view.php"), $content['content']);
				
				$customerDATA = $_SESSION['customercard'];
				
				$content['content'] = str_replace("{{customer-NAME}}", $customerDATA['name'], $content['content']);
				
				$content['content'] = str_replace("{{customer-ADDRESS}}", $customerDATA['address'], $content['content']);
				$content['content'] = str_replace("{{customer-ZIPCODE}}", $customerDATA['zip_code'], $content['content']);
				$content['content'] = str_replace("{{customer-CITY}}", $customerDATA['city'], $content['content']);
				$content['content'] = str_replace("{{customer-COUNTRY}}", $customerDATA['country'], $content['content']);
				
				$content['content'] = str_replace("{{customer-EMAIL}}", ($customerDATA['email_address'] ? $customerDATA['email_address'] : "Geen e-mail bekend"), $content['content']);
				$content['content'] = str_replace("{{customer-PHONE}}", ($customerDATA['mobile_phone'] ? $customerDATA['mobile_phone'] : ($customerDATA['phone'] ? $customerDATA['phone'] : "Geen telefoon bekend")), $content['content']);
				
				$articles = "";
				

				foreach($customerDATA['orders'] AS $key => $order)
				{
					$orderDATA = $mb->_runFunction("customercard", "loadOrder", array($order['orderID']));
					
					foreach($orderDATA['products'] AS $key => $product)
					{
						if($product['visibility'] == 1)
						{
							continue;
						}
						
						$articles .= "
							<tr>
								<td>" . $product['name'] . "</td>
								<td><small>" . $order['status'] . "</small></td>
								<td><small>&euro;&nbsp;" . _frontend_float($product['price']) . "</small></td>
								<td><small>" . $orderDATA['date_added'] . "</small></td>
							</tr>
						";
					}
				}
				
				$content['content'] = str_replace("{{article-row}}", $articles, $content['content']);
				
				$workordersRow = "";
				
				foreach($customerDATA['workorders'] AS $key => $workorders)
				{
					switch($workorders['status'])
					{
						case 0:
							$workorders['status'] = "Openstaand";
						break;
						
						case 1:
							$workorders['status'] = "Afgerond";
						break;
						
						case 3:
							$workorders['status'] = "In de wacht";
						break;
					}
					
					$workordersRow .= "
					<div class=\"customer-card\">
						<table width=\"100%\">
							<tr>
								<td><strong>Datum</strong></td>
								<td><strong>Monteur</strong></td>
								<td><strong>Huidige status</strong></td>
								<td><strong>Totaalbedrag</strong></td>
							</tr>
							
							<tr>
								<td>" . $workorders['expiration_date'] . "</td>
								<td>" . ($workorders['employee'] ? $workorders['employee'] : "Onbekend") . "</td>
								<td>" . $workorders['status'] . "</td>
								<td>&euro;&nbsp;" . _frontend_float($workorders['grand_total']) . "</td>
							</tr>
							
							<tr>
								<td colspan=\"4\">&nbsp;</td>
							</tr>
							
							<tr>
								<td colspan=\"4\" style=\"padding: 10px;\" class=\"blue\"><strong>Opmerkingen</strong><br/>" . ($workorders['note'] ? $workorders['note'] : "Geen bijzonderheden opgeschreven.") . "</td>
							</tr>
						</table>
					</div>
					";
				}
				
				$content['content'] = str_replace("{{workorder-row}}", $workordersRow, $content['content']);
			}
		}
		
		print $content['content'];
		?>
	</p>
</div>