$(document).ready(function(){
	$.tools.dateinput.localize("es",  {
		   months:        'enero,febrero,marzo,abril,mayo,junio,julio,agosto,' +
		                   	'septiembre,octubre,noviembre,diciembre',
		   shortMonths:   'ene,feb,mar,abr,may,jun,jul,ago,sep,oct,nov,dic',
		   days:          'domingo,lunes,martes,miercles,jueves,viernes,sabado',
		   shortDays:     'dom,lun,mar,mie,jue,vie,sab'
		});
		$('.i_fecha').live('click',function(){
			$(this).dateinput({
				lang: 'es',
				format: 'dd-mm-yyyy'
			});
		});
		$(".input_fecha").dateinput({
			lang: 'es',
			format: 'dd mmmm yyyy'
		});
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var f = new Date();
	
	$("#asignar").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			id = radio.val();
			url = $(this).attr("href");
			url = url+"/"+id;
			document.location.href=url;
		}
	});
	$("#ver-detalles").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar un requerimiento");
		}
		else{
			id = radio.val();
			url = $(this).attr("href");
			url = url+"/"+id;
			document.location.href=url;
		}
	});
	$("#agregar").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			id = $.base64.encode( radio.val() );
			id = $.URLEncode(id);
			url = $(this).attr("href");
			url = url+"/"+id;
			document.location.href=url;
		}
	});
	$("#contratos").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			id = radio.val();
			url = $(this).attr("href");
			url = url+"/"+id;
			document.location.href=url;
		}
	});
	/*************************************************/
	/*  CREAR TOOLTIPS,O TEXTO FLOTANTE DE IMAGENES  */
	$('.tooltip[rel]').each(function(){
		
		 $(this).qtip(
	      {
	         content: {
	            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
	            text: '<img class="throbber" src="../../../extras/img/throbber.gif" alt="Cargando..." />',
	            ajax: {
	               url: $(this).attr('rel') // Use the rel attribute of each element for the url to load
	            },
	            title: {
	               text: 'Informacion de usuario', // Give the tooltip a title using each elements text
	               button: true
	            }
	         },
	         position: {
	            at: 'bottom left', // Position the tooltip above the link
	            my: 'top left',
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
	
	/*************************************************/
	/*  				MOSTRAR FILTROS  			 */
	
	$(".filters a").click(function(event){
		event.preventDefault();
		$(this).next().next().toggle();
	});
	
	$("#btn_filtrar").click(function(){
		if( $(".filters input:hidden") ){
			$(".filters input:hidden").val("0");
		}
		if( $(".filters select:hidden") ){
			$(".filters select:hidden").val("0");
		}
	});
	
	/************************************************/
	/*		GUARDAR SESSION LOS USUARIOS CHECKBOX	*/
	var asignados = 0;
	$(".check").click(function(){
		id = $(this).attr("name");
		input_check = $(this);
		id_usuario = $("input[name=id_usuario]").val();
		id_req =  $("input[name=id]").val();
		id_req_padre =  $("input[name=req_anterior]").val();
		id_otro_req = $(this).parent().attr("title");
		tipo = $(this).attr("title");
		por_asignar_aux = $("#por-asignar").text();
		por_asignar = parseInt(por_asignar_aux);
		asignados_aux = $("#asignados").text();
		asignados = parseInt(asignados_aux);
		if( $(this).is(":checked") ){
			if(asignados >= por_asignar){ //contar usuarios pedidos y usuarios que se asignan
				$.msgbox("no puede agregar mas usuarios que los requeridos", {type: "error"});
				return false;
			}
			if( $(this).parent().is(".opaco") ){
				$.msgbox("Este usuario esta asignado a otro requerimiento, al presionar <strong>\"asignar\"</strong>, se finalizará este usuario en el <a target='_blank' href='"+base_url+"administracion/requerimiento/detalles/"+id_req_padre+"/req/"+id_otro_req+"'>requerimiento anterior</a> y se asignara al actual.<br/>Si desea puede <a target='_blank' href='"+base_url+"administracion/perfil/trabajador/"+id_usuario+"'>ver el perfil del trabajador</a>.", {
					 type: "confirm",
					 buttons : [
					    {type: "submit", value: "Asignar"},
					    {type: "cancel", value: "No asignar"}
					 ]
				}, function(result) {
					if(result == "Asignar"){
						select_dia = "<select name='f_dia'><option value=''>Dia</option>";
							for(d=1;d<=31;d++){
								select_dia += "<option "; 
								if(d==f.getDate()) select_dia += "selected='TRUE'"; 
								select_dia += ">"+d+"</option>";
							}
						select_dia += "</select>";
						select_mes = "<select name='f_mes'><option value=''>Mes</option>";
							for(m=0;m<12;m++){
								select_mes += "<option value='"+(m+1)+"'"; 
								if(m==f.getMonth()) select_mes += "selected='TRUE'"; 
								select_mes += ">"+meses[m]+"</option>";
							}
						select_mes += "</select>";
						select_ano = "<select name='f_ano'><option>Año</option>";
							select_ano += "<option>"+ (parseInt(f.getFullYear())-1)+"</option>";
							select_ano += "<option selected='TRUE'>"+f.getFullYear()+"</option>";
							select_ano += "<option>"+(parseInt(f.getFullYear())+1)+"</option>";
						select_ano += "</select>";
						$.msgbox("Especifique <b>fecha y motivo</b> del retiro del requerimiento anterior:<br/><br/><strong>Fecha termino:</strong><br/>"+select_dia+"&nbsp;"+select_mes+"&nbsp;"+select_ano+"&nbsp;", {
						 	type: "prompt",
						  	inputs  : [
						  		{type: "text", label: "<strong>Motivo:</strong>", required: true}
						  	],
						}, function(result) {
						  	if(result) {
						    	dia = $(".jquery-msgbox select[name='f_dia']").val();
						    	mes = $(".jquery-msgbox select[name='f_mes']").val();
						    	ano = $(".jquery-msgbox select[name='f_ano']").val();
						    	$.get(base_url+'administracion/requerimiento/agregar_usr/'+id);
						    	$.post(base_url+'administracion/requerimiento/session_usuarios_finalizados/',{ motivo:result, dia: dia, mes: mes, ano: ano, id_req : id_otro_req, usuario: id }
						    	, function(salida){
						    		alert(salida);
						    	});
								asignados = asignados+1;
								$("#asignados").text(asignados);
							}
							else{
								input_check.attr('checked', false);
								return false;
							}
						});
					}
					if(result === false){
						input_check.attr('checked', false);
						return false;
					}
				});
			}
			else{
				$.get(base_url+'administracion/requerimiento/agregar_usr/'+id, function(data) {
					//alert(data);
				});
				asignados = asignados +1;
			}			
		}
		else{
			$.get(base_url+'administracion/requerimiento/eliminar_usr/'+id, function(data) {
				//alert(data);
			});
			asignados = asignados -1;
		}
		$("#asignados").text(asignados);
	});
	
	$(".quitar").live("click",function(event){
		event.preventDefault();
		id = $(this).attr("rel");
		tipo = $(this).attr("title");
		id_req =  $("input[name=id]").val();
		$(this).parent().parent("tr").prev().remove();
		$(this).parent().parent("tr").remove();
		$.get(base_url+'administracion/requerimiento/eliminar_usr/'+id, function(data) {
			//alert(data);
		});
		asignados_aux = $("#asignados").text();
		asignados = parseInt(asignados_aux);
		asignados = asignados -1;
		$("#asignados").text(asignados);
		$(".check").each(function(){
			if( $(this).attr("name") == id ){
				$(this).attr('checked', false);
			}
		});
	});
	$(".quitar_reemplazo").live("click",function(event){
		event.preventDefault();
		href = $(this).attr('href');
		href = href.split(',');
		$.get(base_url+'administracion/requerimiento/quitar_session_reemplazo_final/'+href[0]+'/'+href[1]+'/'+href[2]+'/'+href[3]+'/'+href[4], function(data){
			//alert(data);
			$.modal.close();
			id_subreq = href[1];
			url_over = base_url+'administracion/requerimiento/session_asignados/'+id_subreq;
			$.get(url_over, function(data) {
				 $.modal(data);
			});
		});
	});
	
	$("#boton_envio").live('click',function(event){
		event.preventDefault();
		asignados_aux = $("#asignados").text();
		asignados = parseInt(asignados_aux);
		por_asignar_aux = $("#por-asignar").text();
		por_asignar = parseInt(por_asignar_aux);
		id_req =  $("input[name=id]").val();
		vacia_fecha = false;
		vacia_origen = false;
		$('.i_fecha').each(function(){
			if( ($(this).val() == 'inicio') || ($(this).val() == 'término') || ($(this).val() == '') ){
				vacia_fecha = true;
			}
		});
		$('select[name=origen]').each(function(){
			if( $(this).val() == '' ){
				vacia_origen = true;
			}
		});
		if(vacia_fecha || vacia_origen){
			if(vacia_fecha && vacia_origen){
				$.msgbox('Las fechas y los valores de origen no pueden estar vacios');
			}
			else if(vacia_fecha){
				$.msgbox('Las fechas no pueden estar vacias');
			}
			else if(vacia_origen){
				$.msgbox('Los valores de origen no pueden estar vacios');
			}
		}
		else{
			if(asignados < 1)
				$.msgbox("los trabajadores asignados son insuficientes", {type: "error"});
			else{
				if(asignados < por_asignar ){
					$.msgbox("Los trabajadores asignados no son el total requerido,¿desea guardar de igual manera?",{
						type: "confirm"
					},function(result){
						if(result){
							$("form[name=asignado]").submit();
							//location.href = base_url+'administracion/requerimiento/guardar_requerimiento/'+id_req;
						}
						else return false;
					});
				}
				else{
					$("form[name=asignado]").submit();
					//location.href = base_url+'administracion/requerimiento/guardar_requerimiento/'+id_req;
				}
			}
		}
	});
	
	$("li.opaco").css("opacity", 0.4);
	
	var $id_radio = '';
	
	$('*:radio').click(function(){
		$id_radio = $(this).val();
	});
	
	/*************** ELIMINAR REQUERIMIENTO *********************/
	$("#eliminar_req").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		url = $(this).attr('href');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			$.msgbox("¿Esta seguro que desea eliminar este requerimiento?<br/><br/><b>*</b> Si este requerimiento tiene trabajadores asociados, ellos <b>se eliminarán del trabajo</b>.", {
			  type: "confirm"
			}, function(result) {
			  if (result) {
			  	//url = base_url + 'administracion/requerimiento/eliminar/'+radio.val();
			  	url = url + '/' + $id_radio;
			    //$.get(base_url+"administracion/requerimiento/eliminar/"+radio.val());
			    location.href = url;
			  }
			});
		}
	});
	
	/*************** EDITAR REQUERIMIENTO *********************/
	$("#editar_req").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		url = $(this).attr('href');
		
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			url = url + '/' + $id_radio;
			location.href = url;
		}
	});
	
	$(".reemplazo").live('click',function(event){
		event.preventDefault();
		url =$(this).attr('href');
//		id_req = $("#aux_form input[name='id_req']").val();
//		url = $(this).attr('href');
//		url = url +'/'+id_req;
		dat = $(this).attr('rel');
		id_subreq = $(this).attr('title');
		url_over = base_url+'administracion/requerimiento/session_asignados/'+id_subreq;
		//$(document).data('usuario_original',dat);
		usuario_original = $(this).attr('rel');
		$.modal.close();
		$.get(base_url+"administracion/requerimiento/session_guardar_usuario_reemplazar/"+usuario_original);
		$.colorbox({
			iframe:true, 
			width:"90%", 
			height:"90%",
			onLoad:function(){ $('body').css('overflow', 'hidden'); },
			onClosed:function(){ 
				$.get(url_over, function(data) {
					 $.modal(data);
				});
				$('body').css('overflow-y', 'scroll');
			},
			href:url
		});
	});

	/************** SELECT ASOCIATIVOS EN LISTADO DE REQUERIMIENTOS (PARA FILTROS) *****************/

	$("#grupo_asc_planta").change(function(){
		id = $(this).val();
		html = "";
		$.ajax({
		  dataType: "json",
		  url: base_url+"/administracion/requerimiento/ajax_grupos_planta/"+id,
		  success: function(salida){
		  	if (salida.length == 0){
		  		html += "<option value='0'>No existen grupos</option>";
		  	}
		  	else{
		  		html += "<option value='0'>Ver Todas</option>";
		  		$.each(salida, function(i){
		  			html += "<option value='"+ salida[i].id +"'>"+ salida[i].nombre +"</option>";
		  		});
		  	}
		  	$("#grupo_asc").html(html);
		  }
		});
	});
});
