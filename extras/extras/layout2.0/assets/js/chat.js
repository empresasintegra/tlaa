$(document).ready(function(){

	$.ajax({
 		url: base_url+"chat/listado",
  		type: 'GET',
  		dataType: 'json',
  		success: function(data) {
  			//alert(data);
  			$.each(data,function(i){
  				html = "<li class=\"media\"><a href=\"#\"><i class=\"fa fa-circle status-online\"></i><img alt=\"...\" src=\""+base_url+data[i].imagen+"\" class=\"media-object\"><div class=\"media-body\"><h4 class=\"media-heading\">"+data[i].nombre+"</h4><span> Content Designer </span></div></a></li>";
  				$("#usr_chat").append(html);
  			});

  			$(".users-list .media a").on("click", function(e) {
		        $(this).closest(".tab-pane").find(".user-chat").show().end().css({
		            right: sideRight.outerWidth()
		        });
		        $(".right-wrapper").perfectScrollbar('update');
		        e.preventDefault();
		    });
  		}
	});
});