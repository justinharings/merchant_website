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
				if(!isset($_GET['productID']))
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
					
					$title = $category_name . " - " . $title;
				}
				else
				{
					$details = $this->_runFunction("catalog", "loadProduct", array(intval($_GET['productID'])));
					
					$name = $details['name'];
			
					if($details[strtoupper(_LANGUAGE_PACK) . '_name'] != "")
					{
						$name = $details[strtoupper(_LANGUAGE_PACK) . '_name'];
					}
					
					$title = strip_tags($name) . " - " . $title;
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
		print $xml->html_head->default_description;
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