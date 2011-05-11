/*
 * Post editor
 */
$(document).ready(function(){
	$("#time-to-now").removeClass("hide").one("click", function(){
		d = new Date();
		$("#day").val(d.getDate());
		$("#month").val(d.getMonth());
		$("#year").val(d.getFullYear());
		$("#hour").val(d.getHours());
		$("#min").val(d.getHours());
		return false;
	});
	var toolbar = [
     { "icon" : "image.png", "tooltip" : "Insert image", "popup" : "popup/insert-media.php" },
     { "icon" : "picture--pencil.png", "tooltip" : "Insert doodle", "popup" : "popup/insert-doodle.php" }
    ];
	for(var tool in toolbar){
		tool = toolbar[tool];
		item = $("<img>").attr("src", "/templates/admin/res/" + tool.icon).bind('click',function(){
			 window.open($(this).attr("data-popup"), 1, 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=760,height=450,left = 260,top = 287');
		});
		item.attr("title", tool.tooltip + "").attr("data-popup", tool.popup);
		$(".toolbar").append(item);
	}
});

window.insertCode = function(code){
	addText(code, "body");
};

function addText(text, areaId){
	var txtarea = document.getElementById(areaId);
	var scrollPos = txtarea.scrollTop;
	var strPos = 0;
	var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
		"ff" : (document.selection ? "ie" : false ) );
	if (br == "ie") { 
		txtarea.focus();
		var range = document.selection.createRange();
		range.moveStart ('character', -txtarea.value.length);
		strPos = range.text.length;
	}
	else if (br == "ff") strPos = txtarea.selectionStart;
	
	var front = (txtarea.value).substring(0,strPos);  
	var back = (txtarea.value).substring(strPos,txtarea.value.length); 
	txtarea.value=front+text+back;
	strPos = strPos + text.length;
	if (br == "ie") { 
		txtarea.focus();
		var range = document.selection.createRange();
		range.moveStart ('character', -txtarea.value.length);
		range.moveStart ('character', strPos);
		range.moveEnd ('character', 0);
		range.select();
	}
	else if (br == "ff") {
			txtarea.selectionStart = strPos;
			txtarea.selectionEnd = strPos;
			txtarea.focus();
		}
		txtarea.scrollTop = scrollPos;
}
