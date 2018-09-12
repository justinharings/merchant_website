$(document).ready(
	function($)
	{
		$("span.lnr-phone-handset").on("click",
			function()
			{
				document.location.href = "/" + $(this).attr("lang") + '/service/service-and-contact.html';
			}
		);
		
		$("span.lnr-map").on("click",
			function()
			{
				document.location.href = "/" + $(this).attr("lang") + '/service/pickup-locations.html';
			}
		);
		
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