
$(document).ready(function(){
	var speckyboy = {}
	speckyboy.init = {}
	speckyboy.init.db = {}
	var id_planta = "";
	var id_origen = 0;
	var id_selec = Array();
	
	// Holding database inistance inside a global variable
	speckyboy.init.open = function(){
		speckyboy.init.db = openDatabase("speckyboy","1.0","My First database",5 * 1024 * 1024);
		// dbname, verison, desc, size
	}
	
	speckyboy.init.createTable = function(){
		var database = speckyboy.init.db;
		database.transaction(function(tx){
			tx.executeSql("CREATE TABLE IF NOT EXISTS todo (ID INTEGER PRIMARY KEY ASC,id_usuario INTEGER UNIQUE)", []);
		});
	}

	// adding created todo
	speckyboy.init.addTodo = function(id_usr){
		var database = speckyboy.init.db;
		database.transaction(function(tx){
			 tx.executeSql("INSERT INTO todo (id_usuario) VALUES (?)", [id_usr]);
		});
	}
	
	/*
	// getting created todo
	speckyboy.init.getTodo = function(){
		var database = speckyboy.init.db;
		var output = '';
		database.transaction(function(tx){
			tx.executeSql("SELECT * FROM todo", [], function(tx,result){
				for (var i=0; i < result.rows.length; i++) {
					todo_item = result.rows.item(i).todo_item;
					todo_due_date = result.rows.item(i).due_date;
					todo_id = result.rows.item(i).ID;
					//showAllTodo(todo_item,todo_due_date,todo_id);
				}
			});
		});
	}*/
	speckyboy.init.getTodo = function(){
		var database = speckyboy.init.db;
		var output = '';
		database.transaction(function(tx){
			tx.executeSql("SELECT * FROM todo", [], function(tx,result){
				for (var i=0; i < result.rows.length; i++) {
					result.rows.item(i).id_usuario;
					//showAllTodo(todo_item,todo_due_date,todo_id);
				}
			});
		});
	}

	// deleting a todo 
	speckyboy.init.deleteTodo = function(id){
		var database = speckyboy.init.db;
		database.transaction(function(tx){
			tx.executeSql("DELETE FROM todo WHERE ID=?",[id]);
		});
	}
	//del all
	speckyboy.init.deleteAll = function(){
		var database = speckyboy.init.db;
		database.transaction(function(tx){
			tx.executeSql("DELETE FROM todo ");
		});
	}

	/*
	// onclick add todo event
	$('#create_todo').click(function(){
		var todo_item_text = $('#todo_item_text').val();
		var todo_due_date = $('#todo_due_date').val();
	
		if(todo_item_text.length == '' || todo_due_date.length == '')
		{
			alert('Both fields are required');
		}
		else
		{
			speckyboy.init.addTodo(todo_item_text,todo_due_date);
			$('#todo_item_text').val('');
			$('#todo_due_date').val('');
		}
	});*/

	$("input[type=checkbox]").click(function(){
		if($(this).is(':checked')) { 
			id = $(this).val();
            //alert("Está activado "+ id);
            speckyboy.init.addTodo(id);
        } else { 
        	id = $(this).val();
            var database = speckyboy.init.db;
			database.transaction(function(tx){
				tx.executeSql("DELETE FROM todo WHERE id_usuario=?",[id]);
			});
        } 
	});

	// function to show all todos 
	/*
	function showAllTodo(todo_item,todo_due_date,todo_id){
	$('ul.list').append(
		'<li><div class="todo_item"><span class="todo_text">' + todo_item + '</span>' +
		'<a href="#" id="delete"> Delete </a><span class="due_date">' + todo_due_date + '</span>' +
		'<input id="this_id" value="' + todo_id + '" type="hidden"><div class="clear"></div></div></li>'); 
		$('li:last').addClass('highlight').delay(1000).queue(function(next){ $(this).removeClass('highlight'); next(); });
	}*/
	
	// onClick deleteEvent Handler

	$('#delete').live("click",function(){
		var id = $(this).closest('li').find('#this_id').val();
		$(this).closest('li').addClass('highlight').delay(1000).queue(function(next){ $(this).remove(); next(); });
		speckyboy.init.deleteTodo(id);
	});

	function init(){
		if(typeof(openDatabase) !== 'undefined')
		{
			speckyboy.init.open();
			speckyboy.init.createTable();
			speckyboy.init.getTodo();
		}
		else
		{
			alert('Tu Navegador (browser) es demaciado antiguo, favor cambiar a uno mas moderno');
		}
	}
		init();

	var database = speckyboy.init.db;
	var output = '';
	database.transaction(function(tx){
		tx.executeSql("SELECT * FROM todo", [], function(tx,result){
			for (var i=0; i < result.rows.length; i++) {
				id_usr = result.rows.item(i).id_usuario;
				$("input[type=checkbox]").each(function(){
					if ( $(this).val() == id_usr ){
						$(this).attr("checked","checked");
					}
				});
			}
		});
	});
	$("#modal_grupo").change(function(){
		id = $(this).val();
		$.ajax({
			type: "POST",
			url: base_url + "/administracion/trabajadores/req_ajax",
			data: "id="+id,
			dataType: "json",
			success: function(datos){
	            $("#modal_planta").html("<option>Seleccione...</option>");
	            $("#modal_origen").html("<option>Seleccione...</option>");
	            cant = 0;
	            $.each(datos,function(i,item){
	            	$("#modal_planta").append("<option value='"+datos[i].id+"'>"+datos[i].id+" - "+datos[i].nombre+ " - "+ datos[i].desc_cargo + " - " + datos[i].desc_area +"</option>");
	            });
	            $.ajax({
	            	url: base_url + "/administracion/trabajadores/origen_ajax",
	            	dataType: "json",
	            	success: function(dt){
	            		$.each(dt,function(i,item){
	            			$("#modal_origen").append("<option value='"+dt[i].id+"'>"+dt[i].name+"</option>");
	            		});
	            	}
	            });
	            num = 0;
	            var database = speckyboy.init.db;
				database.transaction(function(tx){
					tx.executeSql("SELECT * FROM todo", [], function(tx,result){
						for (var i=0; i < result.rows.length; i++) {
							id_usr = result.rows.item(i).id_usuario;
							num++;
							id_selec[i] = id_usr;
							$(".controls.select").html("<a id='seleccionados_o' href='#'>"+ num +"</a>");
						}
					});
				});
				$(".controls.asign").html("<a id='seleccionados_a' href='#'>"+ cant +"</a>");
				/*$.each(s,function(i,item){
					$(s[i]).each(function(){
						id_usr = $(this).find('input[name=edicion]').val();
						num++;
						id_selec[i] = id_usr;
					});
				});*/
				//$(".controls.select").html("<a id='seleccionados_o' href='#'>"+ num +"</a>");
	        }
		});
	});
	
	$("#modal_planta").change(function(){
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

	$("#modal_origen").change(function(){
		id_origen = $(this).val();
	});

	$("#save_btn").click(function(){
		alert(id_planta);
		alert(id_origen);
		alert(id_selec);
		if( id_planta == "" ){
			alert("tiene que seleccionar una planta");
		}
		else{
			if ( id_selec == 0 ){
				alert("no ha agregado trabajadores");
			}
			else{
				$.ajax({
					type: "POST",
					url: base_url + "/administracion/trabajadores/requerimiento_ajax",
					data: { id : id_planta,trabajadores: id_selec,origen:id_origen},
					success: function(datos){
						if(datos == "guardado")
							speckyboy.init.deleteAll();
							location.href = base_url + "/administracion/trabajadores/buscar_nuevo";
			        }
				});
			}
		}
	});

});
/*
$(document).ready(function(){
	$("input[type=checkbox]").click(function(){
		if($(this).is(':checked')) { 
			id = $(this).val();
            //alert("Está activado "+ id);
            $.ajax({
				type: "GET",
				url: base_url + "/administracion/trabajadores/sesion_usuarios_req",
				data: "usuario="+id+"&tipo=add",
				dataType: "html",
				success: function(datos){
					alert(datos);
		        }
			});
        } else {  
            alert("No está activado");  
        } 
	});

	$(".eliminar_trabajador2").click(function(event){
		event.preventDefault();
		url = $(this).attr("href");
		if( confirm( "Esta seguro que desea elminar el trabajador?" ) ){
			$.get(url,function(data){
				  location.reload();
			});
		}
	});

	$(".desactivar_trabajador").click(function(event){
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
	$("#modal_grupo").change(function(){
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
	$("#modal_planta").change(function(){
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

	$("#save_btn").click(function(){
		if( id_planta == "" ){
			alert("tiene que seleccionar una planta");
		}
		else{
			if ( id_selec == 0 ){
				alert("no ha agregado trabajadores");
			}
			else{
				$.ajax({
					type: "POST",
					url: base_url + "/administracion/trabajadores/requerimiento_ajax",
					data: { id : id_planta,trabajadores: id_selec},
					success: function(datos){
						alert(datos);
						location.href = base_url + "/administracion/trabajadores/buscar";
			        }
				});
			}
		}
	});
});
*/