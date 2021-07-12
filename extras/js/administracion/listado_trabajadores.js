// UK Date Sorting 
jQuery.fn.dataTableExt.oSort['uk_date_html-asc']  = function(a,b) {  
    //use text()
    a_aux = $.trim($(a).text());
    b_aux = $.trim($(b).text());

	var ukDatea = a_aux.split('/');
    var ukDateb = b_aux.split('/');

    //Treat blank/non date formats as highest sort                 
    if (isNaN(parseInt(ukDatea[0]))) {
        return 1;
    }
     
    if (isNaN(parseInt(ukDateb[0]))) {
        return -1;
    }

    var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;

    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
    
};

jQuery.fn.dataTableExt.oSort['uk_date_html-desc'] = function(a,b) {
    //use text()
    a_aux = $.trim($(a).text());
    b_aux = $.trim($(b).text());
	
	var ukDatea = a_aux.split('/');
    var ukDateb = b_aux.split('/');

    //Treat blank/non date formats as highest sort                 
    if (isNaN(parseInt(ukDatea[0]))) {
        return -1;
    }
     
    if (isNaN(parseInt(ukDateb[0]))) {
        return 1;
    }

    var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;

    return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
    
} 

jQuery.fn.dataTableExt.oSort['uk_date_norm-asc']  = function(a,b) {  

    var ukDatea = a.split('/');
    var ukDateb = b.split('/');

    var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;

    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};

jQuery.fn.dataTableExt.oSort['uk_date_norm-desc'] = function(a,b) {

    var ukDatea = a.split('/');
    var ukDateb = b.split('/');

    var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;

    return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
} 


$(document).ready(function(){
	/*var oTable = $('table.data').dataTable({
		"aoColumnDefs" : [ 
               { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"} 
        ] 
	});*/
	
	$('table.data').dataTable({
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
            "sSwfPath": base_url + "/extras/js/TableTools/swf/copy_csv_xls_pdf.swf"
        },
		"aoColumnDefs" : [ 
		 	{ "aTargets" : ["uk-date-column"] , "sType" : "uk_date_norm"},
            { "aTargets" : ["uk-date-html"] , "sType" : "uk_date_html"}  
        ]
	});

	$('.check_edit').click( function() {
		id = $(this).val();
		if ( $(this).parent().parent().hasClass('row_selected') ){
			$(this).parent().parent().removeClass('row_selected');

			$.ajax({
				type: "POST",
				url: base_url + "/administracion/trabajadores/usuarios_listado_session",
				data: "id_rem="+id,
				success: function(datos){
		            alert(datos);
		        }
			});
		}
		else{
			$(this).parent().parent().addClass('row_selected');
			$.ajax({
				type: "POST",
				url: base_url + "/administracion/trabajadores/usuarios_listado_session",
				data: "id="+id,
				success: function(datos){
		            //alert(datos);
		        }
			});
		}
	} );

	$("#agregar_lista").click(function(e){
		e.preventDefault();
		usuarios = '';
		$.ajax({
			async: false,
			type: "GET",
			url: base_url + "/administracion/trabajadores/usuarios_listado_session",
			success: function(data){
	            //alert(data);
	            usuarios = data;
	        }
		});
		/*
		$.get( base_url + "/administracion/trabajadores/usuarios_listado_session", function( data ) {
		  alert( data );
		  usuarios = data;
		});*/
		val_select = $( "#select_grupo option:selected" ).val();
		if(val_select == 0)
			alert( 'Antes de agregar, seleccione un grupo' );
		else{
			$.ajax({
				async: false,
				type: "POST",
				url: base_url + "/administracion/trabajadores/guardar_usuarios_listado_session",
				data: "id_grupo="+val_select+'&usuarios='+usuarios,
				success: function(datos){
		            alert(datos);
		        }
			});
		}
	});

	/*
	$('#modal_nuevo').on('show', function () {
		s = fnGetSelected(oTable);
        num = 0;
        id_selec = Array();
		$.each(s,function(i,item){
			$(s[i]).each(function(){
				id_usr = $(this).find('input[name=edicion]').val();
				num++;
				id_selec[i] = id_usr;
			});
		});
		$(".controls.select").html("<a id='seleccionados_o' href='#'>"+ num +"</a>");
	}) */
	/*
	$("#eliminar_trabajador").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar un trabajador");
		}
		else{
			if( confirm( "Esta seguro que desea elminar el trabajador?" ) ){
				id = radio.val();
				$.get(base_url+"administracion/trabajadores/eliminar_trabajador/"+id,function(data){
				   	location.reload();
				});
			}
		}
	}); */
	$(".eliminar_trabajador2").live('click',function(event){
		event.preventDefault();
		url = $(this).attr("href");
		if( confirm( "Esta seguro que desea elminar el trabajador?" ) ){
			$.get(url,function(data){
				  location.reload();
			});
		}
	});

	$(".desactivar_trabajador").live('click',function(event){
		event.preventDefault();
		url = $(this).attr("href");
		$.get(url,function(data){
			  location.reload();
		});
	});
	
	//$('input#id_search').quicksearch('table.data tbody tr');
	$(".filters a").click(function(event){
		event.preventDefault();
		$(this).next().next().toggle();
	});
	$("#btn_filtrar").click(function(){
		if( $(".filters input:hidden") ){
			$(".filters input:hidden").val("");
		}
		if( $(".filters select:hidden") ){
			$(".filters select:hidden").val("");
		}
	});

	$("#req_trabajador").click(function(e){
		e.preventDefault();
		s = fnGetSelected(oTable);
		$.each(s,function(i,item){
			$(s[i]).each(function(){
				id_usr = $(this).find('input[name=edicion]').val();
				alert( id_usr );
			});
		});
	});

	// MODAL DE ASIGNACION DE REQUERIMIENTO
	$("#modal_grupo").live('change',function(){
		id = $(this).val();
		$.ajax({
			type: "POST",
			url: base_url + "/administracion/trabajadores/req_ajax",
			data: "id="+id,
			dataType: "json",
			success: function(datos){
	            $("#modal_planta").html("<option>Seleccione...</option>");
	            $.each(datos,function(i,item){
	            	$("#modal_planta").append("<option value='"+datos[i].id+"'>"+datos[i].id+" - "+datos[i].nombre+ " - "+ datos[i].desc_cargo + " - " + datos[i].desc_area +"</option>");
	            });
	            s = fnGetSelected(oTable);
	            num = 0;
	            id_selec = Array();
				$.each(s,function(i,item){
					$(s[i]).each(function(){
						id_usr = $(this).find('input[name=edicion]').val();
						num++;
						id_selec[i] = id_usr;
					});
				});
				$(".controls.select").html("<a id='seleccionados_o' href='#'>"+ num +"</a>");
	        }
		});
	});
	id_planta = "";
	$("#modal_planta").live('change',function(){
		id = $(this).val();
		id_planta = id;
		cantidad = 0;
		$.ajax({
			type: "POST",
			url: base_url + "/administracion/trabajadores/asign_ajax",
			data: "id="+id,
			dataType: "json",
			success: function(datos){
				cantidad = datos.cantidad;
	            $(".controls.asign").html("<a href='#'>0/"+ datos.cantidad+"</a>");
	        }
		});
	});

	$("#seleccionados_o").live("click",function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: base_url + "/administracion/trabajadores/trabajadores_ajax",
			data: { id : id_selec },
			dataType: "json",
			success: function(datos){
				//alert(datos);
				texto = "Usuarios Seleccionados:\n";
				$.each(datos,function(i,item){
					texto += datos[i].rut_usuario + " "+ datos[i].nombres + " " +datos[i].paterno + " "+ datos[i].materno +"\n";
				});
				alert(texto);
	        }
		});
	});

	id_origen = "";
	$("#modal_origen").live('change',function(){
		id_origen = $(this).val();
	});

	$("#save_btn").live('click',function(){
		if( id_planta == "" || id_origen == "" ){
			alert("tiene que seleccionar una planta o el origen");
		}
		else{
			if ( id_selec == 0 ){
				alert("no ha agregado trabajadores");
			}
			else if ( id_origen == 0 ){
				alert("no ha agregado el origen");
			}
			else{
				$.ajax({
					type: "POST",
					url: base_url + "/administracion/trabajadores/requerimiento_ajax",
					data: { id : id_planta,trabajadores: id_selec,origen:id_origen},
					success: function(datos){
						alert(datos);
						$(".check_edit").removeAttr("checked");
						$(".check_edit").parent().parent().removeClass('row_selected');
						$('#modal_nuevo').modal('hide');
						/*$.each(id_selec,function(){
							$(".check_edit").each(function(){
								if ( $(this).val() == id_selec )
									$(this).removeAttr("checked");
								alert(  $(this).val() + " <====> " + id_selec );
							});
						});*/
						//location.href = base_url + "/administracion/trabajadores/buscar";
			        }
				});
			}
		}
	});
});

function fnGetSelected( oTableLocal )
{
	var aReturn = new Array();
	var aTrs = oTableLocal.fnGetNodes();
	
	for ( var i=0 ; i<aTrs.length ; i++ )
	{
		if ( $(aTrs[i]).hasClass('row_selected') )
		{
			aReturn.push( aTrs[i] );
		}
	}
	return aReturn;
}
