$(document).ready(function(){
	// Admin related functions
	$("<img>").attr("src", resdir + "/res/down.png").css("cursor", "hand").attr("title", "Show all list types").insertAfter("#postsAndMore").click(function(){
		// More dropout!
		if($("#postsAndMoreDropout").length == 0){
			$("<div>").attr("id", "postsAndMoreDropout").insertBefore("#wcontent *:first");
			$.getJSON("list.php?type=content_types", function(data){
				$.each(data, function(key, value){
					li = $("<li>").appendTo("#postsAndMoreDropout");
					$("<a>").attr("href", "list.php?type=" + key).html(value.humans).appendTo(li);
				});
				$("<div style='clear:both'>").appendTo("#postsAndMoreDropout");
				$("#postsAndMoreDropout").addClass("dropout w980").hide().show("medium", "linear");
			});
		} else{
			$("#postsAndMoreDropout").remove();
		}
	});
});
