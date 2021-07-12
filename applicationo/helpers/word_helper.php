<?php
if ( ! function_exists('cambiar_tags'))
{
	function cambiar_tags($_texto, $_nombre, $_rut, $_ciudad,$_finicio = false, $_ftermino = false, $_nacionalidad = false, $fnacimiento = false, $_ecivil = false, $_direccion = false, $_motivo = false, $_sueldo_n = false, $_sueldo_p = false,$_afp = false, $_isapre = false)
	{
		$txt_salida = str_replace('{NOMBRE}', $_nombre, $_texto);
		$txt_salida = str_replace('{RUT}', $_rut, $txt_salida);
		$txt_salida = str_replace('{CIUDAD}', $_ciudad, $txt_salida);
		$txt_salida = str_replace('{FECHA_INICIO}', $_ciudad, $txt_salida);
		$txt_salida = str_replace('{FECHA_TERMINO}', $_ciudad, $txt_salida);
		$txt_salida = str_replace('{NACIONALIDAD}', $_ciudad, $txt_salida);
		$txt_salida = str_replace('{FECHA_NACIMIENTO}', $_ciudad, $txt_salida);
		$txt_salida = str_replace('{ESTADO_CIVIL}', $_ciudad, $txt_salida);
		$txt_salida = str_replace('{DIRECCION}', $_ciudad, $txt_salida);
		$txt_salida = str_replace('{MOTIVO}', $_ciudad, $txt_salida);
		$txt_salida = str_replace('{SUELDO_NUMERO}', $_ciudad, $txt_salida);	
		$txt_salida = str_replace('{SUELDO_PALABRAS}', $_ciudad, $txt_salida);	
		$txt_salida = str_replace('{AFP}', $_ciudad, $txt_salida);	
		$txt_salida = str_replace('{ISAPRE}', $_ciudad, $txt_salida);	
		
		return $txt_salida;
	}
}

?>