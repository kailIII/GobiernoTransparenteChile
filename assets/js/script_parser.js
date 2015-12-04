function parserMarcarTodos(){
	$(".servicio_check").attr("checked",true);
}

function parserMarcarNinguno(){
	$(".servicio_check").attr("checked",false);
}

var servicios, servicio_counter;
function parse(){
	servicio_counter=0;
	servicios=$(".servicio_check:checked");
	$("#results").append("<p>Comienzo del parseo: "+getFecha()+"</p>");
	callParser($(servicios[servicio_counter]).val());
}

function callParser(id){
	servicio_counter++;
	
	$("#results").append("<div id='servicio_"+id+"'><img src='"+base_url+"assets/images/ajax-loader.gif' /></div>");
	
	$.ajax({
		type: "GET",
		url: site_url+"/parser/ajax_parse_servicio/"+id,
		success: function(response){
					$("#servicio_"+id).html(response);
					if(servicio_counter<servicios.length)
						callParser($(servicios[servicio_counter]).val());
					else
						$("#results").append("<p>Fin del parseo: "+getFecha()+"</p>");
				},
        error: function(error,status, mensaje){
            $("#servicio_"+id).html(status+": "+mensaje);
            $("#results").append("<p>Error en el parseo "+status+": "+mensaje+"</p>");
        }
	});
}

function getFecha(){
	var date=new Date();
	return date.getDate()+"/"+(1+date.getMonth())+"/"+date.getFullYear()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
}