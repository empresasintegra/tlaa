CKEDITOR.dialog.add( 'myDialog', function( editor )
{
	//var imt = ['cero','uno','dos','tres'];
	 var buttonType1 = new Array('cero','uno');
	 var buttonType2 = new Array('dos','tres');
     var myItems = new Array(); 
	$.ajax({
		 url: base_url+"administracion/contratos/listado_variables",
		 async:false,
	     success: function(datos){
	    	 itm = datos.split(';');
	    	 for(var i in itm){
	    		 sld = itm[i].split('-');
	    		 myItems.push(sld);
	    	 }
	     }
    });
	return {
		title : 'Variables de Contrato',
		minWidth : 250,
		minHeight : 100,
		contents : [
			{
				id : 'tab1',
				label : 'Label',
				title : 'Title',
				expand : true,
				padding : 0,
				elements :
				[
					{
						type : 'html',
						html : '<p>Favor seleccione una variable.</p>'
					},
					{
						type : 'select',
						id : 'select_id',
						items : myItems
					}
				]
			}
		],
		buttons : [ CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton ],
		onOk : function() {
			// "this" is now a CKEDITOR.dialog object.
			// Accessing dialog elements:
			var textareaObj = this.getContentElement( 'tab1', 'select_id' );
			var valSalida = textareaObj.getValue();
			valSalida = "<b>"+valSalida+"</b>";
			editor.insertHtml( valSalida );
			//alert(item));
			//alert( "You have entered: " + textareaObj.getValue() );
		}
	};
} );