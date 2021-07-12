$(document).ready(function(){

	var href = window.location.href;
	var msg = href.substr(href.lastIndexOf('/') + 1);

	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "0",
	  "hideDuration": "1000",
	  "timeOut": "0",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}

	if(msg == "error"){
		toastr.error("Error al enviar el documento, favor intentar nuevamente o consultar con administrador de sistemas");
	}
	if(msg == "correcto"){
		toastr.success("Archivo enviado correctamente, favor revise su correo electrónico");
	}
});