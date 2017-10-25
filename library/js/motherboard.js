$(document).ready(
	function()
	{
		$.getScript("/library/js/homepage.minified.js", 
			function()
			{
				console.log("Homepage file loaded.");
			}
		);
		
		$.getScript("/library/js/cart.minified.js", 
			function()
			{
				console.log("Cart file loaded.");
			}
		);
		
		
		
		/*
		**
		*/
		
		$("*[click]").on("click",
			function()
			{
				var url = $(this).attr("click");
				var search = "http";
				
				if(url.indexOf(search) !== -1)
				{
					window.open(url);
				}
				else
				{
					document.location.href = url;	
				}
			}
		);
		
		
		
		/*
		**
		*/
		
		$("div.images").find("img").on("click",
			function()
			{
				var src = $(this).attr("src");
				
				$("div.image").find("img").attr("src", src);
			}
		);
		
		
		
		/*
		**
		*/
		
		$(".return-page").on("click",
			function()
			{
				history.go(-1);
				return false;
			}
		);
		
		
		
		/*
		**
		*/
		
		$(".review-text").on("click",
			function()
			{
				$('html, body').animate(
					{
						scrollTop: $("div.scrollto-reviews").offset().top
					}, 2000
				);
			}
		);


		
		/*
		**	Expand the languages menu.
		*/
		
		$("div.top-item.submenu-active").mouseenter(
			function()
			{
				$(this).find(".lnr-chevron-down").removeClass("lnr-chevron-down").addClass("lnr-chevron-up");
				$(this).find("div.top-item-submenu").css("display", "table");
			}
		).mouseleave(
			function()
			{
				$(this).find(".lnr-chevron-up").removeClass("lnr-chevron-up").addClass("lnr-chevron-down");
				$(this).find("div.top-item-submenu").css("display", "none");
			}
		);
		
		
		
		/*
		**	Expand the Kayako chat function.
		*/
		
		$("div.open-kayako").on("click",
			function()
			{
				if (kayako.visibility() === 'minimized') 
				{
					kayako.maximize()
				}
				else 
				{
					kayako.minimize()
				}
			}
		);
		
		
		
		/*
		**
		*/
		
		$(".open-search").on("click",
			function()
			{
				$("div.cart-notification").fadeOut("fast");
				$("div.search-field").fadeIn("fast").css("display", "table").find("input").focus();
			}
		);
		
		
		
		/*
		**
		*/
		
		$("form#filterForm").find("input").on("click",
			function()
			{
				var filterValue = "";
				
				$("form#filterForm").find("input:checked").each(
					function()
					{
						filterValue += $(this).attr("data-url");
					}
				);
				
				if(filterValue == "")
				{
					filterValue = "none";
				}
				
				var action = $(this).closest("form").attr("action");
				action = action.replace("[[filterData]]", filterValue);
				
				window.location.href = action;
			}
		);
		
		
		
		/*
		**
		*/
		
		(
			function($) 
			{
			    var element = $('.follow-scroll');
			    
			    if(element.length > 0)
			    {
				    var originalY = element.offset().top;
				
				    // Space between element and top of screen (when scrolling)
				    var topMargin = 20;
				
				    // Should probably be set in CSS; but here just for emphasis
				    element.css('position', 'relative');
				
					var max = $("div.advertisement-blocks").offset().top;
					max = max - element.height() - $("div.advertisement-blocks").height() - 78;
					
				    $(window).on('scroll', 
				    	function(event) 
				    	{
					        var scrollTop = $(window).scrollTop();
							var scrollToPx = (scrollTop - originalY + topMargin);
							
							if(scrollToPx > max)
							{
								scrollToPx = max;
							}
					
					        element.stop(false, false).animate(
						        {
						            top: scrollTop < originalY
						                    ? 0
						                    : scrollToPx
						        }, 300
						    );
						}
					);
				}
			}
		)(jQuery);
	}
);