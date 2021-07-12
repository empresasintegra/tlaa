$(document).ready(function(){
	$(".sv-callback-list").on("click", function(e) {
		e.preventDefault();
		url = $(this).attr('href');
		$('#subview-eval-list').load(url, function() {
			$("#sv-callback-add").on("click", function(e) {
				e.preventDefault();
				url2 = $(this).attr('href');
				$('#subview-eval-add').load(url2);
				$.subview({
					content: "#subview-eval-add",
					startFrom: "right",
				});
			});
		});
		$.subview({
			content: "#subview-eval-list",
			startFrom: "right",
		});
	});
	$('#select-req').select2().on("change", function(e) {
		id_req = $(this).val();
		$.get(base_url+"est/requerimiento/guardar_usuarios_requerimiento/"+id_req,function(data){
        	if(data == ""){
        		toastr.success("Guardado exitosamente");
        	}
        	else{
        		toastr.error("Error al guardar, favor comunicarse con el administrador");
        	}
        });
	});

	$('.check_edit').change(function() {
		usr = $(this).val();
        if($(this).is(":checked")) {
            toastr.info("Chequeado")
            $.get(base_url+"est/requerimiento/agregar_session/"+usr,function(data){
            	toastr.info(data);
            });
        }
       	else{
       		toastr.info('no chequeado');
       		 $.get(base_url+"est/requerimiento/agregar_session/"+usr+"/remove",function(data){
            	toastr.info(data);
            });
       	}       
    });
    $('#sample_1').dataTable({
			"aoColumnDefs" : [{
				"aTargets" : [0]
			}],
			"oLanguage" : {
				"sLengthMenu" : "Show _MENU_ Rows",
				"sSearch" : "",
				"oPaginate" : {
					"sPrevious" : "",
					"sNext" : ""
				}
			},
			"aaSorting" : [[2, 'asc']],
			"aLengthMenu" : [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"] // change per page values here
			],
			// set the initial value
			"iDisplayLength" : 20,
		});
});
