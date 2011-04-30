$(document).ready(function(){
	$(".useme").bind('click', function(){
		window.opener.insertCode("\n<sorbet://" + $(this).attr("data-file") +">\n");
		window.close();
	});
});