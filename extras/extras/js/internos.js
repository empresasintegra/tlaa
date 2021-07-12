$(document).ready(function(){
	$("input[name=contra]").click(function(){
		$(".pass,.pass2").hide();
		id = $(this).attr("id");
		$("."+id).show();
	});
});
