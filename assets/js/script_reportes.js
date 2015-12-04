$(document).ready(function(){
	$(".treeview").treeview({
		animated: "fast",
		collapsed: true
	});
	
	$(".accordion").accordion({
		autoHeight: false,
		collapsible: true	
	});
	
});

function toggleHijos(element){
	if ($(element).attr("checked"))
		$(element).next().children().children().attr("checked",true);
	else
		$(element).next().children().children().removeAttr("checked");
}

function togglePadre(element){
	if ($(element).attr("checked"))
		$(element).parent().parent().prev().attr("checked",true);
}

function parserMarcarTodos(){
	$("input[type=checkbox]").attr("checked",true);
}

function parserMarcarNinguno(){
	$("input[type=checkbox]").attr("checked",false);
}

function printReport(element){
	$(element).parent().parent().jqprint({importCSS: true});
}