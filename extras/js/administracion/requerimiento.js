$(document).ready(function(){
	$.tools.dateinput.localize("es",  {
	   months:        'enero,febrero,marzo,abril,mayo,junio,julio,agosto,' +
	                   	'septiembre,octubre,noviembre,diciembre',
	   shortMonths:   'ene,feb,mar,abr,may,jun,jul,ago,sep,oct,nov,dic',
	   days:          'domingo,lunes,martes,miercles,jueves,viernes,sabado',
	   shortDays:     'dom,lun,mar,mie,jue,vie,sab'
	});
	$(".input_fecha").dateinput({
		lang: 'es',
		format: 'dd mmmm yyyy'
	});
	$("#select_region").change(function(){
		val = $(this).val();
		$.get("ciudad/"+val,function(data){
		   	$("#select_ciudad").html(data);
		});
	});
	
	var ajax_cargos = '';
	var ajax_areas = '';
	var ajax_especialidades = '';
	var ajax_centrocostos = '';
	
	$.ajax({
		async:false,
	  	url: base_url + 'administracion/requerimiento/ajax_cargos/'+ $('#idplanta').val(),
	  	success: function(data) {
	  		ajax_cargos = data;
	  	}
	});
	
	$.ajax({
		async:false,
	  	url: base_url + 'administracion/requerimiento/ajax_areas/'+ $('#idplanta').val(),
	  	success: function(data) {
			ajax_areas = data;
		}
	});
	
	$.ajax({
		async:false,
	  	url: base_url + 'administracion/requerimiento/ajax_especialidades',
	  	success: function(data) {
			ajax_especialidades = data;
		}
	});
	
	$.ajax({
		async:false,
	  	url: base_url + 'administracion/requerimiento/ajax_centrocostos/'+ $('#idplanta').val(),
	  	success: function(data) {
			ajax_centrocostos = data;
		}
	});
	
	var clonado_grande = "<div class='field select clonar' style='border-bottom: 1px solid #DDD;padding-bottom: 18px;'>";
	clonado_grande += "<div class='field select ref'>";
	clonado_grande += "<label>Area:</label>";
	clonado_grande += "<div class='fields'>";
	clonado_grande += "<select name='select_area[]' class='required2 jarea'>";
	clonado_grande +=  ajax_areas ;
	clonado_grande += "</select>";
	clonado_grande += "<span id='click-medio' style='margin-left: 25px;'><a href='#'>Nuevo Cargo</a></span>";
	clonado_grande += "<a class='abs_elim_req' href='#'><img src='"+ base_url +"extras/img/delete.png' alt='Eliminar' /></a>";
	clonado_grande += "<input type='hidden' name='auxiliar' value='' /></div></div>";
	clonado_grande += "<div class='fields add'><div class='cargos_div'><select name='select_cargo[]' class='required2 jcargo'>" + ajax_cargos +"</select> ";
	clonado_grande += "<select name='select_especialidad[]' class='required2 jespecialidad'>" + ajax_especialidades +"</select> ";
	clonado_grande += "<a class='abs_elim_cargo' href='#'><img src='"+ base_url +"extras/img/remove.png' alt='Eliminar' /></a>";
	clonado_grande += "<input type='hidden' name='auxiliar' value='' />";
	clonado_grande += "<br /><br />";
	clonado_grande += "<div class='chicos'><input type='text' name='cantidad[]' value='' size='6' placeholder='cantidad' class='required2 jcantidad' style='width: 35px;'> ";
	clonado_grande += "<input type='text' name='fdesde[]' value='Desde' id='fdesde' class='input_fecha date jfdesde' size='40' autocomplete='off' style='width: 85px;' > ";
	clonado_grande += "<input type='text' name='fhasta[]' value='Hasta' id='fhasta' class='input_fecha date jfhasta' size='40' autocomplete='off' style='width: 85px;'> ";
	clonado_grande += "<select name='select_cc[]' class='jcc' >" + ajax_centrocostos +"</select>";
	clonado_grande += "<input type='file'>";
	clonado_grande += "<span id='click-chico' style='margin-left: 25px;'><a href='#'><img src='"+base_url+"extras/img/textfield_add.png' /></a></span>";
	clonado_grande += "<input type='hidden' name='auxiliar' value='' /><br><br></div></div></div>";
	
	var clonado_medio = "<hr /><select name='select_cargo[]' class='required2 jcargo'>" + ajax_cargos +"</select> ";
	clonado_medio += "<select name='select_especialidad[]' class='required2 jespecialidad'>" + ajax_especialidades +"</select> ";
	clonado_medio += "<br /><br />";
	clonado_medio += "<div class='chicos'><input type='text' name='cantidad[]' value='' size='6' placeholder='cantidad' class='required2 jcantidad' style='width: 35px;'> ";
	clonado_medio += "<input type='text' name='fdesde[]' value='Desde' id='fdesde' class='input_fecha date jfdesde' size='40' autocomplete='off' style='width: 85px;'> ";
	clonado_medio += "<input type='text' name='fhasta[]' value='Hasta' id='fhasta' class='input_fecha date jfhasta' size='40' autocomplete='off' style='width: 85px;'> ";
	clonado_medio += "<select name='select_cc[]' class='jcc' >" + ajax_centrocostos +"</select>";
	clonado_medio += "<input type='file'>";
	clonado_medio += "<span id='click-chico' style='margin-left: 25px;'><a href='#'><img src='"+base_url+"extras/img/textfield_add.png' /></a></span>";
	clonado_medio += "<input type='hidden' name='auxiliar' value='' /><br><br></div>";
	
	
	var	clonado_chico = "<input type='text' name='cantidad[]' value='' size='6' placeholder='cantidad' class='required2 jcantidad' style='width: 35px;'> ";
	clonado_chico += "<input type='text' name='fdesde[]' value='Desde' id='fdesde' class='input_fecha date jfdesde' size='40' autocomplete='off' style='width: 85px;'> ";
	clonado_chico += "<input type='text' name='fhasta[]' value='Hasta' id='fhasta' class='input_fecha date jfhasta' size='40' autocomplete='off' style='width: 85px;'> ";
	clonado_chico += "<select name='select_cc[]' class='jcc' >" + ajax_centrocostos +"</select>";
	clonado_chico += "<input type='file'><br><br>";
	
	function clonado_1($id_area,$id_cargo,$id_especialidad){
		var	clonado_chico2 = "<input type='text' name='cantidad["+$id_area+"]["+$id_cargo+"]["+$id_especialidad+"][]' value='' size='6' placeholder='cantidad' class='required2 jcantidad' style='width: 35px;'> ";
		clonado_chico2 += "<input type='text' name='fdesde["+$id_area+"]["+$id_cargo+"]["+$id_especialidad+"][]' value='Desde' id='fdesde' class='input_fecha date jfdesde' size='40' autocomplete='off' style='width: 85px;'> ";
		clonado_chico2 += "<input type='text' name='fhasta["+$id_area+"]["+$id_cargo+"]["+$id_especialidad+"][]' value='Hasta' id='fhasta' class='input_fecha date jfhasta' size='40' autocomplete='off' style='width: 85px;'> ";
		clonado_chico2 += "<select name='select_cc["+$id_area+"]["+$id_cargo+"]["+$id_especialidad+"][]' class='jcc' >" + ajax_centrocostos +"</select>";
		clonado_chico2 += "<input type='file'>";
		clonado_chico2 += "<a class='abs_elim_subreq' href='#'><img src='"+ base_url +"extras/img/delete_date.png' alt='Eliminar' /></a>";
		clonado_chico2 += "<input type='hidden' name='auxiliar' value='' />";
		clonado_chico2 += "<br><br>";
		return clonado_chico2;
	}
	
	function clonado_2($id_area){
		var clonado_medio2 = "<div class='cargos_div'>";
		clonado_medio2 += "<hr /><select name='select_cargo["+$id_area+"][]' class='required2 jcargo'>" + ajax_cargos +"</select> ";
		clonado_medio2 += "<select name='select_especialidad["+$id_area+"][]' class='required2 jespecialidad'>" + ajax_especialidades +"</select> ";
		clonado_medio2 += "<a class='abs_elim_cargo' href='#'><img src='"+ base_url +"extras/img/remove.png' alt='Eliminar' /></a>";
		clonado_medio2 += "<input type='hidden' name='axiliar' value=''>";
		clonado_medio2 += "<br /><br />";
		clonado_medio2 += "<div class='chicos'><input type='text' name='cantidad["+$id_area+"][0][0][]' value='' size='6' placeholder='cantidad' class='required2 jcantidad' style='width: 35px;'> ";
		clonado_medio2 += "<input type='text' name='fdesde["+$id_area+"][0][0][]' value='Desde' id='fdesde' class='input_fecha date jfdesde' size='40' autocomplete='off' style='width: 85px;'> ";
		clonado_medio2 += "<input type='text' name='fhasta["+$id_area+"][0][0][]' value='Hasta' id='fhasta' class='input_fecha date jfhasta' size='40' autocomplete='off' style='width: 85px;'> ";
		clonado_medio2 += "<select name='select_cc["+$id_area+"][0][0][]' class='jcc' >" + ajax_centrocostos +"</select>";
		clonado_medio2 += "<input type='file'>";
		clonado_medio2 += "<span id='click-chico' style='margin-left: 25px;'><a href='#'><img src='"+base_url+"extras/img/textfield_add.png' /></a></span>";
		clonado_medio2 += "<input type='hidden' name='auxiliar' value='' /><br><br></div>";
		clonado_medio2 += "</div>";
		return clonado_medio2;
	}
	
	$(".click_requerimiento").on("click",function(event){ // clonar todo
		event.preventDefault();
		//$(clonado_grande).appendTo(".clonados");
		$(".field.select.clonar:last").after(clonado_grande);
	});
	
	$("#click-medio a").live("click",function(event){
		event.preventDefault();
		id = $(this).parent().prev().val();
		$(this).parents(".field.select.clonar").children(".fields.add").append(clonado_2(id));
		// if(id.length > 0){
			// $(this).parents(".field.select.ref").next().children(".jcargo").attr("name","select_cargo[" + id + "][]");
			// $(this).parents(".field.select.ref").next().children(".jarea").attr("name","select_area[" + id + "][]");
			// $(this).parents(".field.select.ref").next().children(".jespecialidad").attr("name","select_especialidad[" + id + "][]");
			// $(this).parents(".field.select.ref").next().children(".jespecialidad").attr("name","select_especialidad[" + id + "][]");
			// $(this).parents(".field.select.ref").next().find(".jcantidad").attr("name","cantidad[" + id + "][0][0][]");
			// $(this).parents(".field.select.ref").next().find(".jfdesde").attr("name","fdesde[" + id + "][0][0][]");
			// $(this).parents(".field.select.ref").next().find(".jfhasta").attr("name","fhasta[" + id + "][0][0][]");
			// $(this).parents(".field.select.ref").next().find(".jcc").attr("name","select_cc[" + id + "][0][0][]");
		// }
	});
	
	$("#click-chico a").live("click",function(event){
		event.preventDefault();
		//id = $(this).parent().parent().parent().prev().find(".jarea").val();
		id = $(this).parents().find(".jarea").val();
		if(id.length == 0 )
			$.msgbox("Favor seleccione un area");
		else{
			//id_cargo = $(this).parent().parent().prev().prev().prev().prev().val();
			id_cargo = $(this).parents().find('.jcargo').val();
			//id_especialidad = $(this).parent().parent().prev().prev().prev().val();
			id_especialidad = $(this).parents().find('.jespecialidad').val();
			if(!id_especialidad) id_especialidad = 0;
			//alert(id_cargo);
			//alert(id_especialidad);
			$(this).parents(".chicos").append(clonado_1(id,id_cargo,id_especialidad));
			// if(id.length > 0){
				// $(this).parents(".field.select.ref").next().children(".jcargo").attr("name","select_cargo[" + id + "][]");
				// $(this).parents(".field.select.ref").next().children(".jarea").attr("name","select_area[" + id + "][]");
				// $(this).parents(".field.select.ref").next().children(".jespecialidad").attr("name","select_especialidad[" + id + "][]");
				// $(this).parents(".field.select.ref").next().children(".jespecialidad").attr("name","select_especialidad[" + id + "][]");
				// $(this).parent().parent().find(".jcantidad").attr("name","cantidad[" + id + "]["+ id_cargo +"]["+ id_especialidad +"][]");
				// $(this).parent().parent().find(".jfdesde").attr("name","fdesde[" + id + "]["+ id_cargo +"]["+ id_especialidad +"][]");
				// $(this).parent().parent().find(".jfhasta").attr("name","fhasta[" + id + "]["+ id_cargo +"]["+ id_especialidad +"][]");
				// $(this).parent().parent().find(".jcc").attr("name","select_cc[" + id + "]["+ id_cargo +"]["+ id_especialidad +"][]");
			// }
		}
	});
	
	$(".input_fecha").live("click",function(event){
		$(this).dateinput({
				lang: 'es',
				format: 'dd mmmm yyyy'
		});
	});
	
	//edicion de requerimiento
	$(".abs_elim_req").live('click',function(event){
		event.preventDefault();
		abs = $(this);
		$(abs).parent().parent().parent().fadeOut('slow',function(){
			$(this).remove();
		});
		
	});
	
	$('.abs_elim_cargo').click(function(event){
		event.preventDefault();
		abs = $(this);
		$(abs).parent().fadeOut('slow',function(){
			$(this).remove();
		});
	});
	
	$('.abs_elim_subreq').live('click',function(event){
		event.preventDefault();
		abs = $(this);
		$(abs).prev().fadeOut('slow',function(){
			$(this).remove();
		});
		$(abs).prev().prev().fadeOut('slow',function(){
			$(this).remove();
		});
		$(abs).prev().prev().prev().fadeOut('slow',function(){
			$(this).remove();
		});
		$(abs).prev().prev().prev().prev().fadeOut('slow',function(){
			$(this).remove();
		});
		$(abs).prev().prev().prev().prev().prev().fadeOut('slow',function(){
			$(this).remove();
		});
		// $(abs).prev().prev().prev().prev().prev().prev().fadeOut('slow',function(){
			// $(this).remove();
		// });
		$(abs).parent().fadeOut('slow',function(){ //revisar
			$(this).remove();
		});
		$(abs).next().next().fadeOut('slow',function(){
			$(this).remove();
		});
		$(abs).next().fadeOut('slow',function(){
			$(this).remove();
		});
		$(abs).fadeOut('slow',function(){
			$(this).remove();
		});
	});
	
	$(".jarea").live('change',function(){
		id = $(this).val();
		area_actual = $(this);
		$('.jarea').not(area_actual).each(function(){
			if( $(this).val() == id ){
				$.msgbox('El area ya esta creada, se elimino el subrequerimiento creado');
				$(area_actual).parent().parent().parent().remove();
				return false;
			}
		});
		//listado de id chicas para cambiar
		cant = $(this).parents(".field.select.ref").next().find('.chicos').children(".jcantidad").attr("name");
		desd = $(this).parents(".field.select.ref").next().find('.chicos').children(".jfdesde").attr("name");
		hast = $(this).parents(".field.select.ref").next().find('.chicos').children(".jfhasta").attr("name");
		
		tot_cant = cant.split(/\D/);
		tot_cant = $.grep(tot_cant,function(n,i){  return(n);}); 
		tot_desd = desd.split(/\D/);
		tot_desd = $.grep(tot_desd,function(n,i){  return(n);}); 
		tot_hast = hast.split(/\D/);
		tot_hast = $.grep(tot_hast,function(n,i){  return(n);}); 
		
		if(tot_cant.length == 3){
			valor_cant1 = tot_cant[1]; //el valor_cant1[2] => es el valor requerido
			valor_cant2 = tot_cant[2]; //el valor_cant2[0] => es el valor requerido
		}
		if(tot_desd.length == 3){
			valor_desd1 = tot_desd[1]; //el valor_desd1[2] => es el valor requerido
			valor_desd2 = tot_desd[2]; //el valor_cant2[0] => es el valor requerido
		}
		if(tot_hast.length == 3){
			valor_hast1 = tot_hast[1]; //el valor_cant1[2] => es el valor requerido
			valor_hast2 = tot_hast[2]; //el valor_cant2[0] => es el valor requerido
		}
		//cambiar id area
		$(this).parents(".field.select.ref").next().find('.cargos_div').children(".jcargo").attr("name","select_cargo[" + id + "][]");
		$(this).parents(".field.select.ref").next().find('.cargos_div').children(".jarea").attr("name","select_area[" + id + "][]");
		$(this).parents(".field.select.ref").next().find('.cargos_div').children(".jespecialidad").attr("name","select_especialidad[" + id + "][]");
		$(this).parents(".field.select.ref").next().find('.cargos_div').children(".jcargo_antiguo").attr("name","cargo_antiguo[" + id + "][]");
		
		if(tot_cant.length == 3) //si es 4 entonces si cambio el cargo y/o especialidad
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jcantidad").attr("name","cantidad[" + id + "]["+ valor_cant1 + "][" + valor_cant2 +"][]");
		else //si es 2, entonces aun no se cambia el cargo o la especialidad
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jcantidad").attr("name","cantidad[" + id + "][]");
		
		if(tot_desd.length == 3){
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jfdesde").attr("name","fdesde[" + id + "]["+ valor_desd1 + "][" + valor_desd2 +"][]");
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jcant_antiguo").attr("name","antiguo_rt[" + id + "]["+ valor_desd1 + "][" + valor_desd2 +"][]");
		}
		else{
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jfdesde").attr("name","fdesde[" + id + "][]");
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jcant_antiguo").attr("name","antiguo_rt[" + id + "][]");
		}
			
		if(tot_hast.length == 3){
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jfhasta").attr("name","fhasta[" + id + "]["+ valor_hast1 + "][" + valor_hast2 +"][]");
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jcc").attr("name","select_cc[" + id + "]["+ valor_hast1 + "][" + valor_hast2 +"][]");
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jcant_antiguo").attr("name","antiguo_rt[" + id + "]["+ valor_hast1 + "][" + valor_hast2 +"][]");
		}
		else{
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jfhasta").attr("name","fhasta[" + id + "][]");
			$(this).parents(".field.select.ref").next().find('.cargos_div').find('.chicos').children(".jcc").attr("name","select_cc[" + id + "][]");
		}
		//alert ( jcargo );
	});
	
	$(".jcargo").live('change',function(){
		id = $(this).parent().parent().prev().find(".jarea").val(); //id area
		
		if(id.length < 1)
			id = 0;
		
		id_cargo = $(this).val();
		
		cant = $(this).next().next().next().next().next().next().children(".jcantidad").attr("name");
		desd = $(this).next().next().next().next().next().next().children(".jfdesde").attr("name");
		hast = $(this).next().next().next().next().next().next().children(".jfhasta").attr("name");
		tot_cant = cant.split(/\D/);
		tot_cant = $.grep(tot_cant,function(n,i){  return(n);}); 
		tot_desd = desd.split(/\D/);
		tot_desd = $.grep(tot_desd,function(n,i){  return(n);}); 
		tot_hast = hast.split(/\D/);
		tot_hast = $.grep(tot_hast,function(n,i){  return(n);}); 
		
		if( (tot_cant.length == 0) && (tot_desd.length == 0) && (tot_hast.length == 0) )
			$.msgbox("Favor seleccione un area");
		
		if(tot_cant.length == 0){
			id = 0;
			valor_cant2 = 0;
		}
		if(tot_desd.length == 0){
			id = 0;
			valor_desd2 = 0;
		}
		if(tot_hast.length == 0){
			id = 0;
			valor_hast2 = 0;
		}
		
		if(tot_cant.length == 1 ){
			valor_cant2 = 0;
		}
		if(tot_cant.length == 3){
			valor_cant2 = tot_cant[2];
		}
		if(tot_desd.length == 1){
			valor_desd2 = 0;
		}
		if(tot_desd.length == 3){
			valor_desd2 = tot_desd[2]; //el valor_cant2[0] => es el valor requerido
		}
		if(tot_hast.length == 1){
			valor_hast2 = 0;
		}
		if(tot_hast.length == 3){
			valor_hast2 = tot_hast[2];
		}
		
		$(this).next().next().next().next().next().next().children(".jcantidad").attr("name","cantidad[" + id + "]["+ id_cargo + "][" + valor_cant2 +"][]");
		$(this).next().next().next().next().next().next().children(".jfdesde").attr("name","fdesde[" + id + "]["+ id_cargo + "][" + valor_desd2 +"][]");
		$(this).next().next().next().next().next().next().children(".jfhasta").attr("name","fhasta[" + id + "]["+ id_cargo + "][" + valor_hast2 +"][]");
		$(this).next().next().next().next().next().next().children(".jcc").attr("name","select_cc[" + id + "]["+ id_cargo + "][" + valor_hast2 +"][]");
		$(this).next().next().next().next().next().next().children(".jcant_antiguo").attr("name","antiguo_rt[" + id + "]["+ id_cargo + "][" + valor_hast2 +"][]");
		
	});
	
	$(".jespecialidad").live("change",function(){
		id_especialidad = $(this).val();
		if(!id_especialidad) id_especialidad = 0;
		id = $(this).parent().parent().prev().find(".jarea").val();
		if(id.length < 1)
			id = 0;
		cant = $(this).next().next().next().next().next().children(".jcantidad").attr("name");
		desd = $(this).next().next().next().next().next().children(".jfdesde").attr("name");
		hast = $(this).next().next().next().next().next().children(".jfhasta").attr("name");
		tot_cant = cant.split(/\D/);
		tot_cant = $.grep(tot_cant,function(n,i){  return(n);}); 
		tot_desd = desd.split(/\D/);
		tot_desd = $.grep(tot_desd,function(n,i){  return(n);}); 
		tot_hast = hast.split(/\D/);
		tot_hast = $.grep(tot_hast,function(n,i){  return(n);}); 
		
		if( (tot_cant.length == 0) && (tot_desd.length == 0) && (tot_hast.length == 0) )
			$.msgbox("Favor seleccione un area");
		
		if(tot_cant.length == 0){
			id = 0;
			valor_cant1 = 0;
		}
		if(tot_desd.length == 0){
			id = 0;
			valor_desd1 = 0;
		}
		if(tot_hast.length == 0){
			id = 0;
			valor_hast1 = 0;
		}
		
		
		if(tot_cant.length == 1){
			valor_cant1 = 0;
		}
		if(tot_cant.length == 3){
			valor_cant1 = tot_cant[1]; //el valor_cant1[2] => es el valor requerido
		}
		if(tot_desd.length == 1){
			valor_desd1 = 0;
		}
		if(tot_desd.length == 3){
			valor_desd1 = tot_desd[1]; //el valor_cant1[2] => es el valor requerido
		}
		if(tot_hast.length == 1){
			valor_hast1 = 0;
		}
		if(tot_hast.length == 3){
			valor_hast1 = tot_hast[1]; //el valor_cant1[2] => es el valor requerido
		}	
		$(this).next().next().next().next().next().find(".jcantidad").attr("name","cantidad[" + id + "]["+ valor_cant1 + "][" + id_especialidad +"][]");
		$(this).next().next().next().next().next().find(".jfdesde").attr("name","fdesde[" + id + "]["+ valor_desd1 + "][" + id_especialidad +"][]");
		$(this).next().next().next().next().next().find(".jfhasta").attr("name","fhasta[" + id + "]["+ valor_hast1 + "][" + id_especialidad +"][]");
		$(this).next().next().next().next().next().find(".jcc").attr("name","select_cc[" + id + "]["+ valor_hast1 + "][" + id_especialidad +"][]");
		$(this).next().next().next().next().next().find(".jcant_antiguo").attr("name","antiguo_rt[" + id + "]["+ valor_hast1 + "][" + id_especialidad +"][]");
		
	});
	
});
