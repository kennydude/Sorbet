/*
 * Sorbet list editor Javascript!
 */
$(document).ready(function(){
	$(".listTemplate").hide();
	$(".listTemplate *").attr("name", null);
	$("#addAnotherBox").show();
	var list_number = 0;
	$("#addAnotherItem").bind('click', function(){
		clone = $("<div>").html($(".listTemplate").html()).addClass("box").show();
		$("#addAnotherBox").before(clone);
		list_number = list_number + 1;
		$("*", clone).each(function(){
			$(this).attr("name", $(this).attr("data-name-template").replace("{x}", list_number));
		});
	});
});