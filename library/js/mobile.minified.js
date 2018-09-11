$(document).ready(function($)
{$(window).resize(function()
{_mobile()});setTimeout(function()
{$(window).trigger("resize")},300);setTimeout(function()
{$(".mobile-load").css("visibility","hidden")},500)});function _mobile()
{if($(window).width()>760&&$("input#mobile").val()==1)
{$("body").hide();document.location.href=document.location.href}
else if($(window).width()<=760&&$("input#mobile").val()==0)
{$("input#mobile").val(1);$("ul.header-menu").hide();$("div.page-menu").find("div.filters").hide();$("span.lnr-phone-handset").on("click",function()
{document.location.href="/"+$(this).attr("lang")+'/service/service-and-contact.html'});$("span.lnr-map-marker").on("click",function()
{document.location.href="/"+$(this).attr("lang")+'/service/pickup-locations.html'});$("ul.header-menu").parent().append('<div class="main-header-menu"><span class="fa fa-bars"></span>&nbsp;&nbsp;menu</div>');if($("div.page-menu").length!=0)
{var text="informatie pagina's";if($("div.page-menu").find("ul.head").hasClass("catalog"))
{text="bekijk onze catalogus"}
$("div.main-header-menu").parent().append('<div class="sub-header-menu"><span class="fa fa-caret-down"></span>&nbsp;&nbsp;'+text+'</div>');$("div.page-menu").find("ul.head").appendTo(".sub-header-menu")}
if($("div.filters").length!=0)
{$("div.main-header-menu").parent().append('<div class="sub-header-menu filter"><span class="fa fa-caret-down"></span>&nbsp;&nbsp;resultaten filteren</div>');$("div.filters").find("div.filterForm").appendTo(".sub-header-menu.filter")}
$("ul.header-menu").appendTo(".main-header-menu");$("div.main-header-menu").on("click",function()
{$("div.sub-header-menu").find("ul.head").hide();$("div.sub-header-menu").find("div.filterForm").hide();$("div.sub-header-menu").find("span.fa-caret-up").removeClass("fa-caret-up").addClass("fa-caret-down");$("div.search-field").hide();if($(this).find("ul.header-menu").css("display")=="table")
{$(this).find("ul.header-menu").hide()}
else{$(this).find("ul.header-menu").css("display","table")}});$("div.sub-header-menu").on("click",function()
{$("div.main-header-menu").find("ul.header-menu").hide();$("div.sub-header-menu").find("div.filterForm").hide();$("div.sub-header-menu").find("span.fa-caret-up").removeClass("fa-caret-up").addClass("fa-caret-down");$("div.search-field").hide();if($(this).find("ul.head").css("display")=="table")
{$(this).find("ul.head").hide();$(this).find("span.fa-caret-up").removeClass("fa-caret-up").addClass("fa-caret-down")}
else{$(this).find("ul.head").css("display","table");$(this).find("span.fa-caret-down").removeClass("fa-caret-down").addClass("fa-caret-up")}});$("div.sub-header-menu.filter").on("click",function()
{$("div.main-header-menu").find("ul.header-menu").hide();$("div.sub-header-menu").find("ul.head").hide();$("div.sub-header-menu").find("span.fa-caret-up").removeClass("fa-caret-up").addClass("fa-caret-down");$("div.search-field").hide();if($(this).find("div.filterForm").css("display")=="table")
{$(this).find("div.filterForm").hide();$(this).find("span.fa-caret-up").removeClass("fa-caret-up").addClass("fa-caret-down")}
else{$(this).find("div.filterForm").css("display","table");$(this).find("span.fa-caret-down").removeClass("fa-caret-down").addClass("fa-caret-up")}})}}