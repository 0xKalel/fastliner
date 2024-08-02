function center(element,direction)
{
if(($(element).css('position')=="undefined")||($(element).css('position')=="static"))
{
$(element).css('position','relative')
}
if((direction=="v")||(direction=="all")){
var parent_height=$(element).parent().css("height");
var child_height=$(element).css("height");
var top=(parseFloat(parent_height)-parseFloat(child_height))/2;
$(element).css('top',top+"px");
}
if((direction=="h")||(direction=="all")){
var parent_width=$(element).parent().css("width");
var child_width=$(element).css("width");
var left=(parseFloat(parent_width)-parseFloat(child_width))/2;
$(element).css('left',left+"px");
}
}
function butt(id)
{
	$("#"+id).attr("src","elements/"+id+".png")
	document.getElementById(id).onmouseover=function(){
	$("#"+id).attr("src","elements/"+id+"2.png")
	}
	document.getElementById(id).onmouseout=function(){
	$("#"+id).attr("src","elements/"+id+".png")
	}
}
function fullscreen(element)
{
	$(element).css("min-height",$(window).height());
}
function displaying(toshow,tohide)
{
	$(tohide).hide();
	$(toshow).show()
}