$(document).ready(
	function($)
	{
		$("span.lnr-phone-handset").on("click",
			function()
			{
				var url = $(this).attr("url");
				document.location.href = "/" + $(this).attr("lang") + url;
			}
		);
		
		$("span.lnr-map").on("click",
			function()
			{
				var url = $(this).attr("url");
				document.location.href = "/" + $(this).attr("lang") + url;
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
		
		$(".continue").on("click",
			function()
			{
				$("div.cart-notification").fadeOut("fast").css("display", "none");
			}
		);
	}
);