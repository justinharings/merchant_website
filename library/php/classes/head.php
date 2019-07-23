<?php
class head extends main_board
{
	/*
	**	Generate the website's <title/> tag. Use given information
	**	as the shown webshop category, service page or anything
	**	like that. If there is no special page active, show the default title.
	*/
	
	public function title()
	{
		$xml = simplexml_load_string($this->language_xml);
		$title = $xml->html_head->default_title;
		
		switch($_GET['module'])
		{
			case "catalog":
				if(!isset($_GET['productID']) && $_GET['page'] == "sale")
				{
					$title = $this->_translateReturn("main_menu", "sale") . " - " . $title;
				}
				else if(!isset($_GET['productID']) && $_GET['page'] == "search")
				{
					$content = $this->_translateReturn("website_text", "search_results", array($_GET['string']));
					$title = $content . " - " . $title;
				}
				else if(!isset($_GET['productID']))
				{
					$categoryID = (isset($_GET['categoryID']) ? $_GET['categoryID'] : 0);
					
					if($categoryID == 0)
					{
						switch($_GET['page'])
						{
							case "bicycles":
								$categoryID = 1;
							break;
							
							case "accessories":
								$categoryID = 4;
							break;
							
							case "parts":
								$categoryID = 44;
							break;
							
							case "webshop":
								$categoryID = 68;
							break;
						}
					}
				
					$category = $this->_runFunction("catalog", "loadCatalog", array($categoryID));
					
					$category_name = $category['name'];
					
					if($category[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
					{
						$category_name = $category[strtoupper(_LANGUAGE_PACK) . '_name'];
					}
					
					$title = "Catalogus: " . $category_name . " | " . $title;
				}
				else
				{
					$details = $this->_runFunction("catalog", "loadProduct", array(intval($_GET['productID'])));
					
					$name = $details['name'];
			
					if($details[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
					{
						$name = $details[strtoupper(_LANGUAGE_PACK) . '_name'];
					}
					
					$codes = "";
					
					if($details['barcode'] != "")
					{
						$codes .= $details['barcode'];
					}
					
					if($details['supplier_code'] != "")
					{
						if($codes != "")
						{
							$codes .= " ";
						}
						
						$codes .= $details['supplier_code'];
					}
					
					if($codes != "")
					{
						$codes = " | " . $codes;
					}
					
					$title = strip_tags($name) . $codes . " | " . $title;
				}
			break;
			
			case "service":
				$content = $this->_runFunction("content", "load", array(_LANGUAGE_PACK, $_GET['file']));
				$title = $content['name'] . " - " . $title;
			break;
		}
		
		print $title;
	}
	
	
	
	/*
	**	Generate the website's <description/> tag. Use given information
	**	as the shown webshop category, service page or anything
	**	like that. If there is no special page active, show the default description.
	*/
	
	public function description()
	{
		$xml = simplexml_load_string($this->language_xml);
		
		$return = "";
		
		switch($_GET['module'])
		{
			case "catalog":
				if(!isset($_GET['productID']) && $_GET['page'] == "sale")
				{
					$return = $xml->html_head->product_description_sale;
				}
				else if(!isset($_GET['productID']) && $_GET['page'] == "search")
				{
					$return = sprintf(
							$xml->html_head->product_description_search,
						$_GET['string']
					);
				}
				else if(!isset($_GET['productID']))
				{
					$categoryID = (isset($_GET['categoryID']) ? $_GET['categoryID'] : 0);
					
					if($categoryID == 0)
					{
						switch($_GET['page'])
						{
							case "bicycles":
								$categoryID = 1;
							break;
							
							case "accessories":
								$categoryID = 4;
							break;
							
							case "parts":
								$categoryID = 44;
							break;
							
							case "webshop":
								$categoryID = 68;
							break;
							
							case "decoration":
								$categoryID = 85;
							break;
							
							case "furniture":
								$categoryID = 86;
							break;
							
							case "lights":
								$categoryID = 87;
							break;
							
							case "clothes":
								$categoryID = 88;
							break;
							
							case "dierenwinkel":
								$categoryID = 101;
							break;
							
							case "snoepgoed":
								$categoryID = 231;
							break;
						}
					}
				
					$category = $this->_runFunction("catalog", "loadCatalog", array($categoryID));
					
					$category_name = $category['name'];
					
					if($category[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
					{
						$category_name = $category[strtoupper(_LANGUAGE_PACK) . '_name'];
					}
					
					if(isset($_GET['categoryID']))
					{
						$return = sprintf(
								$xml->html_head->product_description_category,
							strtolower($category_name)
						);
					}
					else
					{
						$return = sprintf(
								$xml->html_head->product_description_headcategory,
							strtolower($category_name)
						);
					}
				}
				else
				{
					$details = $this->_runFunction("catalog", "loadProduct", array(intval($_GET['productID'])));
					
					if($details['brand'] != "")
					{
						$return = sprintf(
								$xml->html_head->product_description_brand,
							$details['brand']
						);
						
						$return .= " " ;
					}
					
					$return .= strip_tags($details['description']);
				}
			break;
			
			case "service":
				$content = $this->_runFunction("content", "load", array(_LANGUAGE_PACK, $_GET['file']));
				$return = $content['seo_description'];
			break;
		}
		
		if($return == "")
		{
			print $xml->html_head->default_description;
		}
		else
		{
			print substr($return, 0, 297) . (strlen($return) > 300 ? "..." : "");
		}
	}



	/*
	**	Generate the website's <keywords/> tag. Use given information
	**	as the shown webshop category, service page or anything
	**	like that. If there is no special page active, show the default keywords.
	*/
		
	public function keywords()
	{
		$xml = simplexml_load_string($this->language_xml);
		print $xml->html_head->default_keywords;
	}
}
?>