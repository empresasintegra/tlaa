$(document).ready(function(){
	$(".check_todos").click(function(event){
		if($(this).is(":checked")) {
			$(".ck:checkbox:not(:checked)").attr("checked", "checked");
		}else{
			$(".ck:checkbox:checked").removeAttr("checked");
		}
	});
});