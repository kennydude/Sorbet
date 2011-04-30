/**
 * Code loosely based on http://dev.opera.com/articles/view/html5-canvas-painting/
 */
var tool, context;
$(document).ready(function(){
	tool = new tool_pencil();
	canvas = $("#pad")[0];
	/* not for protection, just to remove that annoyance! */
	disableSelection(document.body);
	context = canvas.getContext("2d");
	document.addEventListener('mouseup', ev_canvas, false);
	canvas.addEventListener('mousedown', ev_canvas, false);
	canvas.addEventListener('mousemove', ev_canvas, false);
	$("#clearall").bind('click', function(){
		context.clearRect(0,0,canvas.width,canvas.height);
	});
	$(".cb").bind('click', function(){
		$(".cb").removeClass("selected");
		$(this).addClass("selected");
		context.strokeStyle = $(this).css("background");
	});
});

function tool_pencil(){
	this.mousemove = function (ev) {
		if (tool.started) {
			context.lineTo(ev._x, ev._y);
			context.stroke();
		}
	};
	this.mousedown = function (ev) {
		context.beginPath();
		context.moveTo(ev._x, ev._y);
		tool.started = true;
	};
	this.mouseup = function(ev) {
		if (tool.started) {
			tool.started = false;
		}
	};
	this.started = false;
	$("#penciltool").attr("class", "selected");
}

function ev_canvas(ev){
	if (ev.layerX || ev.layerX == 0) { // Firefox
		ev._x = ev.layerX;
		ev._y = ev.layerY;
	} else if (ev.offsetX || ev.offsetX == 0) { // Opera
		ev._x = ev.offsetX;
		ev._y = ev.offsetY;
	}
	// Call the event handler of the tool.
	var func = tool[ev.type];
	if (func) {
		func(ev);
	}
}


/***********************************************
* Disable Text Selection script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

function disableSelection(target){
if (typeof target.onselectstart!="undefined") //IE route
	target.onselectstart=function(){return false}
else if (typeof target.style.MozUserSelect!="undefined") //Firefox route
	target.style.MozUserSelect="none"
else //All other route (ie: Opera)
	target.onmousedown=function(){return false}
target.style.cursor = "default"
}
