$(document).ready(function(){
	//$(".hiddenUntilMouseOver").css("opacity",0);
	$("body").mouseover(function(){
		$(".hiddenUntilMouseOver").animate({opacity: 1},1000);
	});
	$("#searchInput").DefaultValue("Buscar...");
	$("#searchInput").autocomplete(site_url+"/busqueda/ajax_search",{
		matchContains: true,
		selectFirst: false,
		highlight: false,
		formatItem: function(item){
			var item=item[0].split(";");
			return "<span class='autocompleteItem'>"+item[0]+"</span><span class='autocompleteCounter'>"+item[1]+" resultados</span>";
			},
		formatResult: function(item){
			var item=item[0].split(";");
			return item[0];
			}
		//minChars: 3,
		//extraParams: {buscarpor: $("#searchDiv input[name=buscarpor]:checked").val()}
	});

        /*
	$('a.download').each(function(){
		var url=$(this).attr('href');
		if (url.substr(url.length-4)==".pdf"){
			var content = '<img src="'+site_url+'directorio/ajax_pdfpreview?x=0&y=0&url='+url+'" alt="Generando previsualización..." style="width: 240px; height:320px;" />';
			$(this).qtip({
				content: content,
				position: {target: "mouse", adjust: {screen: true}},
				style: {name: "dark", fontSize: "12px", tip: true, border:{radius: 5}, width: "240px", height: "320px"}
			});
		}
	});
        */
	
	$(".tooltip").qtip({
		position: {target: "mouse", adjust: {screen: true}},
		style: {name: "dark", fontSize: "12px", tip: true, border:{radius: 5}},
		show: {delay: 0}
	});
	
	$("#busquedaAvanzadaForm .selectAllEntidadesDiv input").click(function(){
		$("#busquedaAvanzadaForm .selectEntidadesDiv input").attr("checked", false);
	})
	$("#busquedaAvanzadaForm .selectEntidadesDiv input").click(function(){
		$("#busquedaAvanzadaForm .selectAllEntidadesDiv input").attr("checked", false);
	})
	$("#busquedaAvanzadaForm .selectAllCategoriasDiv input").click(function(){
		$("#busquedaAvanzadaForm .selectCategoriasDiv input").attr("checked", false);
	})
	$("#busquedaAvanzadaForm .selectCategoriasDiv input").click(function(){
		$("#busquedaAvanzadaForm .selectAllCategoriasDiv input").attr("checked", false);
	})
	
});