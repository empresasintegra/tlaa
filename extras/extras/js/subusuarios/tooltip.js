$(document).ready(function(){
	/*  CREAR TOOLTIPS,O TEXTO FLOTANTE DE IMAGENES  */
	$('.tooltip[rel]').each(function(){
		
		 $(this).qtip(
	      {
	         content: {
	            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
	            text: '<img class="throbber" src="../../../extras/img/throbber.gif" alt="Cargando..." />',
	            ajax: {
	               url: $(this).attr('rel') // Use the rel attribute of each element for the url to load
	            },
	            title: {
	               text: 'Informacion de usuario', // Give the tooltip a title using each elements text
	               button: true
	            }
	         },
	         position: {
	            at: 'bottom left', // Position the tooltip above the link
	            my: 'top left',
	            viewport: $(window), // Keep the tooltip on-screen at all times
	            effect: false // Disable positioning animation
	         },
	         show: {
	            event: 'click',
	            solo: true // Only show one tooltip at a time
	         },
	         hide: 'unfocus',
	         style: {
	            classes: 'ui-tooltip-wiki ui-tooltip-light ui-tooltip-shadow'
	         }
	      });
	});
	$('.tooltip').click(function(event){event.preventDefault();});
});
