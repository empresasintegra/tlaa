$(document).ready(function(){
	
	$.tools.dateinput.localize("es",  {
	   months:        'enero,febrero,marzo,abril,mayo,junio,julio,agosto,' +
	                   	'septiembre,octubre,noviembre,diciembre',
	   shortMonths:   'ene,feb,mar,abr,may,jun,jul,ago,sep,oct,nov,dic',
	   days:          'domingo,lunes,martes,miercles,jueves,viernes,sabado',
	   shortDays:     'dom,lun,mar,mie,jue,vie,sab'
	});
	$(".filters a").click(function(event){
		event.preventDefault();
		$(this).next().next().toggle();
	});
	$(".filters a.dos").click(function(event){
		event.preventDefault();
		$(this).next().next().next().next().toggle();
	});
	
	$("#btn_filtrar").click(function(){
		if( $(".filters input:hidden") ){
			$(".filters input:hidden").val("");
		}
		if( $(".filters select:hidden") ){
			$(".filters select:hidden").val("");
		}
	});
	$(".rango").dateinput({ lang: 'es',format: 'dd mmmm yyyy'});
	
	// $("#submit_filtro").submit(function(event){
		// event.preventDefault();
// 		
		// $.post(base_url+'administracion/evaluaciones/ajax_filtrar', function(data) {
  			// //$('.result').html(data);
  		// });
		// alert("aaa");
	// });
	// $(".rango:first").data("dateinput").change(function() {
		// $(".rango:last").data("dateinput").setMin(this.getValue(), true);
	// });
	
	$("#subir_archivo").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar una evaluación");
		}
		else{
			url2 = document.URL;
			$.ajax({
			  type: 'POST',
			  url: base_url+'administracion/evaluaciones/ajax_urlEncriptada',
			  data: { url: url2},
			  async: false,
			  success: function(data) {
			    url_encript = data;
			  }
			});
			
			id = radio.val();
			url = base_url+"administracion/evaluaciones/ajax_subirDocumento";
			//url = url+'/'+id+'/'+url_encript;
			// window.open(url);
			//alert(url); 
			$.extend($.modal.defaults, {
				closeClass: "closeClass",
				closeHTML: "<a href='#'>x</a>"
			});
			$.post(url,{id: id, url: url_encript},function(data){
				$.modal(data);
				$("#form_modal").live('submit',function(event){
					nb = $("input[name='nb_arch']").val();
					dc = $("input[name='documento']").val();
					//alert(url2);
					if(nb != "" && dc != ""){
						return true;
					}
					else return false;
				});
			});
		}
	});
	$("#editar_eval").click(function(event){
		//event.preventDefault();
		radio =  $('*:radio:checked');
		
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar una evaluación");
			event.preventDefault();
		}
	});
	$('*:radio').one("click",function(){
		url = base_url+ "administracion/evaluaciones/editar/";
		salida = url + $(this).val();
		$("#editar_eval").attr('href',salida);
		$("#editar_eval").addClass('dialog');
	});
	$("#eliminar_archivo").live('click',function(e){
		e.preventDefault();
		$elim = $(this);
		$.msgbox("¿Esta seguro que desea eliminar este archivo?",{
			 type: "confirm",
			 buttons : [
			    {type: "submit", value: "Eliminar"},
			    {type: "cancel", value: "Cancelar"}
			 ]
		}, function(result) {
			if(result){
				id = $elim.attr("rel");
				$.ajax({
				  url: base_url+'administracion/evaluaciones/ajax_eliminarArchivo/'+id,
				  beforeSend: function(){
				  	$('#cont-arch').children().fadeOut('slow',function(){ $(this).remove(); });
				  	$('#cont-arch').html("<b>Eliminando archivo...</b>");
				  },
				  success: function(data) {
				   	$('#cont-arch').html("No posee archivo");
				   	$("input[name=documento]").attr('disabled',false);
				  }
				});
			}
		});
	});
	
	$("#del_eval").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar una evaluación");
			//event.preventDefault();
		}
		else{
			$.msgbox("¿Esta seguro que desea eliminar esta evaluación?",{
			 type: "confirm",
			 buttons : [
			    {type: "submit", value: "Eliminar"},
			    {type: "cancel", value: "Cancelar"}
			 ]
		}, function(result) {
			if(result){
				id = radio.val();
				$.ajax({
				  url: base_url+'administracion/evaluaciones/ajax_eliminar/'+id,
				  beforeSend: function(){
				  	 $.modal("<div style='height:100px;width:300px;text-align:center;margin-top:20px'>Se esta eliminando la evaluación, espere un momento.</div>");
				  },
				  success: function(data) {
				   	$.modal("<div style='height:100px;width:300px;text-align:center;margin-top:20px'>Eliminada correctamente.</div>");
				   	setInterval( function(){
				   		location.reload();
				   	}, 3000 );
				  }
				});
			}
		});
		}
	});
});
