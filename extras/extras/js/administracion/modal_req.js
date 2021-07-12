$(document).ready(function(){
	$.tools.dateinput.localize("es",  {
	   months:        'enero,febrero,marzo,abril,mayo,junio,julio,agosto,' +
	                   	'septiembre,octubre,noviembre,diciembre',
	   shortMonths:   'ene,feb,mar,abr,may,jun,jul,ago,sep,oct,nov,dic',
	   days:          'domingo,lunes,martes,miercles,jueves,viernes,sabado',
	   shortDays:     'dom,lun,mar,mie,jue,vie,sab'
	});
	$(".input_fecha").dateinput({
		lang: 'es',
		format: 'dd mmmm yyyy'
	});
});