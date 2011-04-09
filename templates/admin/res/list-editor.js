/*
 * Sorbet list editor Javascript!
 */
$(document).ready(function(){
	$(".listTemplate").hide();
	$(".listTemplate *").attr("name", null);
	$("#addAnotherBox").show();
	var list_number = 0;
	$("#addAnotherItem").click(function(){
		clone = $(".listTemplate").clone().removeClass("listTemplate").
			insertBefore($("#addAnotherBox")).show();
		list_number = list_number + 1;
		$("*", clone).each(function(){
			$(this).attr("name", $(this).attr("data-name-template").replace("{x}", list_number));
		});
	});
});