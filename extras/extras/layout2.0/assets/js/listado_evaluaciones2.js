$(document).ready(function(){
	
	/*$.tools.dateinput.localize("es",  {
	   months:        'enero,febrero,marzo,abril,mayo,junio,julio,agosto,' +
	                   	'septiembre,octubre,noviembre,diciembre',
	   shortMonths:   'ene,feb,mar,abr,may,jun,jul,ago,sep,oct,nov,dic',
	   days:          'domingo,lunes,martes,miercles,jueves,viernes,sabado',
	   shortDays:     'dom,lun,mar,mie,jue,vie,sab'
	});
*/	$(".filters a").click(function(event){
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
	//$(".rango").dateinput({ lang: 'es',format: 'dd mmmm yyyy'});
	$('*:radio').one("click",function(){
		url_editar = base_url+ "administracion/evaluaciones/editar/";
		url_add = base_url+ "administracion/evaluaciones/agregar/";
		salida_ed = url_editar + $(this).val();
		salida_ad = url_add + $(this).val();
		$("#editar_eval").attr('href',salida_ed);
		$("#editar_eval").addClass('dialog');
		$("#add_eval").attr('href',salida_ad);
		$("#add_eval").addClass('dialog');
	});

	$("#subir_archivo").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		
		if( radio.val() == undefined ){
			$.msgBox({
			    title:"Error!",
			    type: "error",
			    content:"Debe seleccionar una evaluación"
			});
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
				$("#form_modal").on('submit',function(event){
					nb = $("input[name='nb_arch']").val();
					dc = $("input[name='docu']").val();
					//alert(url2);
					if(nb != "" && dc != ""){
						return true;
					}
					else return false;
				});
			});
		}
	});
	

/*
	$("#editar_eval").click(function(event){
		//event.preventDefault();
		radio =  $('*:radio:checked');
		
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar una evaluación");
			event.preventDefault();
		}
	});
	var $usr_id = "";
	$("#add_eval").click(function(event){
		event.preventDefault();
		radio =  $('input:radio[name=asignar]:checked');
		

		if( radio.val() == undefined ){
			$('#myModal').modal({
			  show: false
			});
			$.msgBox({
			    title:"Error!",
			    content:"Debe seleccionar una evaluación",
			    type: "error"
			});
		}
		else{
			$usr_id = radio.val();
			url = base_url +"administracion/evaluaciones/agregar/"+ $usr_id;
			$('#myModal').modal({
				show: true,
				keyboard: false
			});
			$('#myModal .modal-body').load(url);
		}
	});*/
	$("#eliminar_archivo").on('click',function(e){
		e.preventDefault();
		$elim = $(this);
		$.msgbox({
			title: "Esta Seguro?",
			content: "¿Desea eliminar este archivo?",
			type: "confirm",
			buttons: [{ value: "Si" }, { value: "No" }, { value: "Cancelar"}],
			success: function (result) {
		        if (result == "Si") {
		            id = $elim.attr("rel");
					$.ajax({
					  url: base_url+'administracion/evaluaciones/ajax_eliminarArchivo/'+id,
					  beforeSend: function(){
					  	$('#cont-arch').children().fadeOut('slow',function(){ $(this).remove(); });
					  	$('#cont-arch').html("<b>Eliminando archivo...</b>");
					  },
					  success: function(data) {
					   	$('#cont-arch').html("No posee archivo");
					   	$("input[name=docu\\["+id+"\\]]").attr('disabled',false);
					  }
					});
		        }
		    }
		});
	});
	
	$("#del_eval").click(function(event){
		event.preventDefault();
		radio =  $('input:radio[name=asignar]:checked');
		
		if( radio.val() == undefined ){
			$.msgBox({
			    title:"Error!",
			    content:"Debe seleccionar una evaluación"
			});
			//event.preventDefault();
		}
		else{
			$.ajax({
				url: base_url+"administracion/evaluaciones/ajax_archivos/"+radio.val(),
				async: false,
				success: function(data) {
					html = "<p><b>Examenes presentes</b>:</p>";
					obj = $.parseJSON(data);
					$.each(obj,function(){
						html += "<div><img src='"+base_url+"extras/img/arrow-right.png' style='margin-top: 2px;float: left;'  /> ";
						html += this.nombre_examen;
						html += "<br/><a href='"+base_url+"administracion/evaluaciones/ajax_eliminar/"+this.id_evaluacion+"' class='ajax_generado'>Eliminar</a></div>";
					});
					$(".ajax_generado").on('click',function(event){
						event.preventDefault();
						url = $(this).attr('href');
						if(!confirm('¿Está seguro que desea eliminar esta evaluación?')) {
						}
						else{
							//location.href=url;
							$.get(url, function(data) {
								location.reload();
							});
						}
					});
				}
			});
			$.msgbox(html,{type: "info"});
		}
	});
	/*
	$('.tooltip[rel]').each(function(){
		
		 $(this).qtip(
	      {
	         content: {
	            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
	            text: "<img class='throbber' src='"+ base_url + "extras/img/throbber.gif' alt='Cargando...' />",
	            ajax: {
	               url: $(this).attr('rel') // Use the rel attribute of each element for the url to load
	            },
	            title: {
	               text: 'Informacion de examen', // Give the tooltip a title using each elements text
	               button: true
	            }
	         },
	         position: {
	            at: 'top right', // Position the tooltip above the link
	            my: 'bottom right',
	            viewport: $(window), // Keep the tooltip on-screen at all times
	            effect: false // Disable positioning animation
	         },
	         show: {
	            event: 'click',
	            solo: true // Only show one tooltip at a time
	         },
	         hide: 'unfocus',
	         style: {
	            classes: 'ui-tooltip-wiki ui-tooltip-light ui-tooltip-shadow'
	         }
	      });
	});
	$('.tooltip').click(function(event){event.preventDefault();});
	*/
	
	$('.click_eval').on('click',function(event){
		event.preventDefault();
		tipo = $(this).attr('rel');
		//$('#simplemodal-container').css('height','auto');
		caja = $(this).parent().parent().next(".contenedor_nodesemp"); 
		caja.show();
		/*
		caja.fadeToggle("slow", function(){
			if(caja.is(":visible"))
				$('#simplemodal-container').animate({"top": "-=195px"}, "slow");
			else
				$('#simplemodal-container').animate({"top": "+=195px"}, "slow");
		});*/
	});
	var seleccionado_1 = 0;
	$('select[name=evaluacion]').on('change',function(){
		id = $(this).val();
		$('input[name=id_ee]').val(id);
		if(id){
			$('#simplemodal-container').css('height','auto');
				$.get( base_url+'administracion/evaluaciones/ajax_return_examenes/'+$usr_id,function(data){
					json2 = $.parseJSON(data);
					$.each(json2,function(){
						if(this.id_tipo != 1){
						if( id == this.id_examen){
							alert("Este examen ya existe. Si desea agregar uno nuevo, favor eliminelo antes.");
							$('#guardar_nuevo_examen').attr('disabled',true);
						}
						else{
							$('#guardar_nuevo_examen').attr('disabled',false);
						}
						}
					});
				});
			$.ajax({
				url: base_url+"administracion/evaluaciones/ajax_tipo_resultado/"+id,
				async:false,
				success: function(data) {
					json = $.parseJSON(data);
	    			if(json.tipo_resultado == 1){
	    				salida_res ="<input type='text' name='resultado' placeholder='promedio obtenido' />";
	    			}
	    			else if(json.tipo_resultado == 2){
	    				if(json.id_tipo == 1 || json.id_tipo == 3){
	    					salida_res = "<select name='resultado'>";
	    					salida_res +="<option value='0'>Aprobado</option><option value='1'>Rechazado</option>";
	    					salida_res += "</select>";
	    				}
	    				if(json.id_tipo == 2){
	    					salida_res = "<select name='resultado'>";
	    					salida_res +="<option value='0'>Sin Contraindicaciones</option><option value='1'>Con Contraindicaciones</option>";
	    					salida_res += "</select>";

	    				}
	    				else{
	    					salida_res = "<select name='resultado'>";
	    					salida_res +="<option value='0'>Aprobado</option><option value='1'>Rechazado</option>";
	    					salida_res += "</select>";
	    				}
	    			} 
	    			else{
	    				if(seleccionado_1 == 1){
	    					$('#simplemodal-container').animate({"top": "+=50px"}, "slow");
	    					seleccionado_1 = 0;
	    				}
	    			}	
	    			if(json.id_tipo == 1){
	    				$('#div_desempeno').fadeOut('slow');
	    				$('#div_faena').fadeIn('slow');
	    				$('#div_recomienda').fadeIn('slow');
	    				seleccionado_1 = 1;
	    				$('#simplemodal-container').animate({"top": "-=50px"}, "slow");
	    			}
	    			else if(json.id_tipo == 3){
	    				$('#div_desempeno').fadeOut('slow');
	    				$('#div_faena').fadeOut('slow');
	    				$('#div_recomienda').fadeOut('slow');
	    				if(seleccionado_1 == 1){
	    					$('#simplemodal-container').animate({"top": "+=50px"}, "slow");
	    					seleccionado_1 = 0;
	    				}
	    			}
	    			else{
	    				$('#div_desempeno').fadeIn('slow');
	    				$('#div_faena').fadeOut('slow');
	    				$('#div_recomienda').fadeOut('slow');
	    				if(seleccionado_1 == 1){
	    					$('#simplemodal-container').animate({"top": "+=50px"}, "slow");
	    					seleccionado_1 = 0;
	    				}
	    			}
	    			$('.fields.resultado').html(salida_res);
	 			 }
			});
		}
	});
});