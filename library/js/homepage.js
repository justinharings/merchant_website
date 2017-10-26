$(document).ready(
	function($)
	{
		$("div.homepage").find("img").each(
			function()
			{
				if($(this).attr("onclick") != "")
				{
					$(this).css("cursor", "pointer");
				}
			}	
		);
	}
);