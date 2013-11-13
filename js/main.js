
$(document).ready(init);

function init()
{
	
	$("#menu div").click(function(e){
		e.stopPropagation();
		console.log(e.currentTarget);		
		$("#wrapper").move($(e.currentTarget).data("goto"));
		$("#wrapper").move($(e.currentTarget).data("goto"));
		$(e.currentTarget).data("goto") ==1?$("#wrapper").move($(e.currentTarget).data("goto")):null;
		
	});
	
}