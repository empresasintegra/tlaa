<?php 
if ( ! function_exists('diferencia_fechas'))
{
	function diferencia_fechas($fInicio,$fFinal){
		$fecha_inicio = explode("-",$fInicio);
		$fecha_final = explode("-",$fFinal);
		// Comprobamos si hay algún año bisiesto. 86400 segundos es un dias
		//$fInicio = "07/01/2010";
		//$fFinal = "08/02/2013";
		$AInicio = $fecha_inicio[0];
		$AFinal = $fecha_final[0];
		for ($i = $AInicio; $i <= $AFinal; $i++) {
		(($i % 4) == 0) ? $bis = 86400 : $bis = 0;
		@$sumadiasBis += $bis;
		}
		//echo "Fecha de Inicio " .$fInicio. "<br />Fecha Final " .$fFinal. "<br /><br />Restan<br />";
		// Calculamos los segundos entre las dos fechas
		$fechaInicio = mktime(0,0,0,$fecha_inicio[1],$fecha_inicio[2],$fecha_inicio[0]);
		$fechaFinal = mktime(0,0,0,$fecha_final[1],$fecha_final[2],$fecha_final[0]);
		$segundos = ($fechaFinal - $fechaInicio);
		$anyos = floor(($segundos-$sumadiasBis)/31536000);
		$segundosRestante = ($segundos-$sumadiasBis)%(31536000);
		$meses = floor($segundosRestante/2592000);
		$segundosRestante = ($segundosRestante%2592000); // Suma un día mas por cada años bisiesto
		//$segundosRestante = (($segundosRestante-$sumadiasBis)%2592000); // No suma un día mas por cada año bisiesto
		$dias = floor($segundosRestante/86400);
		if($dias == 0 && $meses == 0 && $anyos == 0) echo "Publicado hoy";
		elseif($meses == 0 && $anyos == 0) echo "Hace ".$dias." dias";
		elseif($anyos == 0) echo "Hace ".$dias." dias ".$meses." meses";
	}
}

if ( ! function_exists('mesXdia'))
{
	function mesXdia($mes){
		$meses = array( 'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre' );
		if(in_array($mes, $meses) ){
			$key = array_keys($meses,$mes,true);
			$sum = (int)$key[0] + 1;
			return $sum;
		}
		else{
			return false;
		}
	}
}
if ( ! function_exists('diaXmes'))
{
	function diaXmes($dia){
		$meses = array( 'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
		$key = (int)$dia - 1;
		$mes = $meses[$key];
		return $mes;
	}
}
if ( ! function_exists('meses'))
{
	function meses(){
		$meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
		return $meses;
	}
}

?>