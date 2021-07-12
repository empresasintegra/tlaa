$(document).ready(function(){
	$("input[name=del_all],#del_all").toggle(function(){
		$("input[type=checkbox]").attr("checked","checked");
	},function(){
		$("input[type=checkbox]").removeAttr("checked");
	});

	$("#del_news").click(function(){
		if( $("input[type=checkbox]").is(":checked") ){
			return true;
		}
		else{
			alert("debe seleccionar a lo menos una noticia");
			return false;
		}
	});
});