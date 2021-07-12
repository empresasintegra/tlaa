$(document).ready(function(){
	$("#menu-guardar").click(function(){
		$('#opGuardar').modal('show');
	});
	$('textarea').htmlarea();
	$('.jHtmlArea').find('iframe').removeAttr('style');
	
//	$('iframe').keypress(function(){
//		alert('lalalal');
//	});
	
	$('iframe').contents().find('body').keypress(function(){
		if($(this).css('height') > '784px'){
			alert('pasado');
			$('.cuerpo').append("<div class='aux'></div><textarea class='hoja-carta'></textarea>");
		}
	});
	
//	$(document).keypress(function (event) {
//	 // handle cursor keys
//		alert("otra tecla");
//	});
	
	$("#menu-link").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('link');
	});
	$("#menu-negrita").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('bold');
	});
	$("#menu-italica").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('italic');
	});
	$("#menu-tachado").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('strikeThrough');
	});
	$("#menu-under").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('underline');
	});
	$("#menu-left").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('justifyLeft');
	});
	$("#menu-center").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('justifyCenter');
	});
	$("#menu-right").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('justifyRight');
	});
	$("#menu-listNo").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('unorderedList');
	});
	$("#menu-listNu").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('orderedList');
	});
	$("#menu-super").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('superscript');
	});
	$("#menu-sub").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('subscript');
	});
	$("#menu-margenDer").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('outdent');
	});
	$("#menu-margenIzq").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('indent');
	});
	$("#menu-pegar").click(function(event){
		event.preventDefault();
		$('textarea.hoja-carta').htmlarea('pasteHTML');
	});
	
	
});