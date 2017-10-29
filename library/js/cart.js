$(document).ready(
	function($)
	{
		/*
		**
		*/
		
		$("form#book").find("input[type='submit']").on("click",
			function(e)
			{
				e.preventDefault();
				
				var button = $("#book_order");
				button.attr("text", button.val()).val("One moment please ...");
				
				var valid = true;
				
				$("input[req]").removeAttr("style");
				
				$("input[req]").each(
					function()
					{
						if($(this).val() == "")
						{
							$(this).css("border-color", "#d00000");
							valid = false;
						}
						else if($(this).attr("req") == "email")
						{
							var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
							
							if(!re.test($(this).val()))
							{
								$(this).css("border-color", "#d00000");
								valid = false;
							}
						}
					}
				);
				
				if(valid == true)
				{
					$(this).closest("form").submit();
				}
				else
				{
					button.val(button.attr("text"));
				}
			}
		);
		
		
		
		
		$("div.cart-info").find("div.button").on("click",
			function()
			{
				var elm = $(this);
				
				var txt = elm.html();
				elm.html("loading . . .");
				
				$.post(
					"/library/php/posts/cart.php",
					{
						productID: elm.attr("productid")
					}
				).done(
					function(data) 
					{
						$("div.cart-count").html(data);
						
						$("div.search-field").fadeOut("fast");
						
						elm.html(txt);
						
						$("body, html").animate(
							{
								scrollTop: 0
							}, 
							500,
							function()
							{
								$("div.cart-notification").fadeIn("fast").css("display", "table");
							}
						);
					}
				);

			}
		);
		
		
		
		/*
		**		
		*/
		
		$("div.button.light").on("click",
			function()
			{
				$("div.cart-notification, div.search-field").fadeOut("fast");
			}
		);
		
		
		
		/*
		**
		*/
		
		$("select#quantity").on("change",
			function()
			{
				$(this).closest("form").submit();
			}
		);
		
		
		
		/*
		**
		*/
		
		$("ul.checkout-choices").find("li").on("click",
			function()
			{
				var input = $(this).closest("ul").attr("inputname");
				
				$("input#" + input).val($(this).attr("id"));
				
				$(this).closest("ul").find("div.choice").find("span").removeClass("fa-check active").addClass("fa-circle");
				$(this).find("div.choice").find("span").removeClass("fa-circle").addClass("fa-check active");
			}
		);
		
		$("ul.checkout-choices").find("li").find("div.choice").find("span.active").closest("li").trigger("click");
	}
);