<?php 
if ( ! function_exists('subir'))
{
	function subir($FILES,$nb_input,$destino,$nombre_nuevo = FALSE,$multiple=FALSE)
	{
		//echo $multiple;
		//echo $wa = $_FILES[$nb_input]['name'][$multiple];
		//echo pathinfo($wa,PATHINFO_EXTENSION);
		
		if(is_numeric($multiple))
			$archi = $FILES[$nb_input]['name'][$multiple];
		else
			$archi = $FILES[$nb_input]['name'];
		
		if(is_numeric($multiple))
			$tamano = $FILES[$nb_input]['size'][$multiple];
		else
			$tamano = $FILES[$nb_input]['size'];
	    
		if(is_numeric($multiple))
			$tipo = $FILES[$nb_input]['type'][$multiple];
		else
			$tipo = $FILES[$nb_input]['type'];
		
		
		$ext1 = pathinfo($archi,PATHINFO_EXTENSION);
		$ext = strtolower($ext1);
		$prefijo = substr(md5(uniqid(rand())),0,6);
		
		if($ext == "doc" || $ext == "docx" || $ext == "pdf"){
			$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
			$ruta_prin = $ruta_prin[0];
			if($nombre_nuevo){
				$destino_final =  $destino.$nombre_nuevo.'_'.$prefijo.'.'.$ext;
				$destino_tmp = $ruta_prin.$destino.$nombre_nuevo.'_'.$prefijo.'.'.$ext;
			}
			else{
				$destino_final =  $destino.$archi.'_'.$prefijo.'.'.$ext;
				$destino_tmp = $ruta_prin.$destino.$archi .'_'.$prefijo.'.'.$ext;
			}
			
			if(is_numeric($multiple)){
				if (copy($_FILES[$nb_input]['tmp_name'][$multiple],$destino_tmp)) {
		        	return $destino_final;
				} else {
		           return 2;
			    }
			}
			else{
				if (copy($_FILES[$nb_input]['tmp_name'],$destino_tmp)) {
		        	return $destino_final;
				} else {
		           return 2;
			    }
			}
		}
		else{
			return 1;
		}
	}
}
if ( ! function_exists('trabajadores'))
{
	function trabajadores($FILES,$nb_input,$destino,$nombre_nuevo)
	{
		$tamano = $FILES[$nb_input]['size'];
	    $tipo = $FILES[$nb_input]['type'];
	    $archivo = $FILES[$nb_input]['name'];
		$ext = pathinfo($archivo,PATHINFO_EXTENSION);
		$ext = strtolower($ext);
		if($ext == "xls" || $ext == "xlsx"){
			$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
			$ruta_prin = $ruta_prin[0];
			$destino_final =  $destino.$nombre_nuevo.'.'.$ext;
			$destino_tmp = $ruta_prin.$destino.$nombre_nuevo.'.'.$ext;
			 if (copy($FILES[$nb_input]['tmp_name'],$destino_tmp)) {
	        	return $destino_final;
			} else {
	           return 2;
		    }
		}
		else{
			return 1;
		}
	}
}
?>