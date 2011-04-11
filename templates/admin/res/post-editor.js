/*
 * Post editor
 */
$(document).ready(function(){
	var toolbar = [
     { "icon" : "image.png" }
    ];
	for(var tool in toolbar){
		tool = toolbar[tool];
		item = $("<img>").attr("src", "/templates/admin/res/" + tool.icon).bind('click',function(){
			
		});
		$(".toolbar").append(item);
	}
});