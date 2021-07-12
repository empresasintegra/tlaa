$(document).ready(function(){
	$("#wizard-1,#custom-back-1").click(function(event){
		event.preventDefault();
		$(".stepy-titles li").removeClass("current-step");
		$("#wizard-1").addClass("current-step");
		$(".step").hide();
		$("#wizard-step-1").show();
	});
	$("#wizard-2,#custom-back-2,#custom-next-0").click(function(event){
		event.preventDefault();
		$(".stepy-titles li").removeClass("current-step");
		$("#wizard-2").addClass("current-step");
		$(".step").hide();
		$("#wizard-step-2").show();
	});
	$("#wizard-3,#custom-next-1").click(function(event){
		event.preventDefault();
		$(".stepy-titles li").removeClass("current-step");
		$("#wizard-3").addClass("current-step");
		$(".step").hide();
		$("#wizard-step-3").show();
	});
	
	$("#select_region").change(function(){
		val = $(this).val();
		$.get(base_url+"administracion/trabajadores/provincia/"+val,function(data){
		   	$("#select_provincia").html(data);
		});
		$.get(base_url+"administracion/trabajadores/ciudad/"+val,function(data){
		   	$("#select_ciudad").html(data);
		});
	});
	// $("#select_region").change(function(){
		// val = $(this).val();
		// $.get(base_url+"ciudad/"+val,function(data){
		   	// $("#select_ciudad").html(data);
		// });
	// });
	
	$("#form_mandante").submit(function(event){ //validar vacios en la primera pestaña
		event.preventDefault();
		$(".error", this).remove();
		var e1 = 0;
		var e2 = 0;
		var e3 = 0;
		$(".required1",this).each(function(){
			if( !this.value ) {
				e1++;
            	$(this).before("<div class='error'><span>Obligatorio</span></div>");
      		}
		});
		$(".required2",this).each(function(){
			if( !this.value ) {
				e2++;
            	$(this).before("<div class='error'><span>Obligatorio</span></div>");
      		}
		});
		$(".required3",this).each(function(){
			if( !this.value ) {
				e3++;
            	$(this).before("<div class='error'><span>Obligatorio</span></div>");
      		}
		});
		if(e3 > 0) {
			$(".stepy-titles li").removeClass("current-step");
			$("#wizard-3").addClass("current-step");
			$(".step").hide();
			$("#wizard-step-3").show();
		}
		if(e2 > 0) {
			$(".stepy-titles li").removeClass("current-step");
			$("#wizard-2").addClass("current-step");
			$(".step").hide();
			$("#wizard-step-2").show();
		}
		if(e1 > 0) {
			$(".stepy-titles li").removeClass("current-step");
			$("#wizard-1").addClass("current-step");
			$(".step").hide();
			$("#wizard-step-1").show();
		}
		if( (e1<=0) && (e2<=0) && (e3<=0) ) $(this).unbind('submit').submit();
		
	});
	
	$("#form_trabajador").submit(function(event){ //validar vacios en la primera pestaña
		event.preventDefault();
		var e1 = 0;
		$(".required1",this).each(function(){
			if( !this.value ) {
				e1++;
            	$(this).before("<div class='error'><span>Obligatorio</span></div>");
      		}
		});

		if(e1 > 0) {
			$(".stepy-titles li").removeClass("current-step");
			$("#wizard-1").addClass("current-step");
			$(".step").hide();
			$("#wizard-step-1").show();
		}
		if( e1<=0 )  $(this).unbind('submit').submit();
		
	});
	
});
