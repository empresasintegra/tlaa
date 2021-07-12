<?php 
if ( ! function_exists('subir'))
{
	function subir($FILES,$nb_imagen,$destino,$width = FALSE ,$height=FALSE)
	{

		$tamano = $FILES[$nb_imagen]['size'];
	    $tipo = $FILES[$nb_imagen]['type'];
	    $archivo = $FILES[$nb_imagen]['name'];
		$ext = pathinfo($archivo,PATHINFO_EXTENSION);
		$ext = strtolower($ext);
		$prefijo = substr(md5(uniqid(rand())),0,6);
		if($ext == "jpg" || $ext == "png" || $ext == "jpeg"){
			$CI =& get_instance();
			$CI->load->library('image_lib');
			$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
			$ruta_prin = $ruta_prin[0];
			
			$destino_final =  $destino.$prefijo."_".$archivo;
			$destino_tmp = $ruta_prin ."/extras/layout2.0/img_perfil/tmp/".$prefijo."_".$archivo;
			 if (copy($FILES[$nb_imagen]['tmp_name'],$destino_tmp)) {
	        	$config['image_library'] = 'gd2';
		        $config['source_image'] = $destino_tmp;   
				$config['create_thumb'] = FALSE;
		        $config['maintain_ratio'] = TRUE;
				if($width)
		        	$config['width'] = $width;
				if($height)
		         	$config['height'] = $height;
		        $config['new_image'] = $ruta_prin.$destino_final;
				
		        $CI->image_lib->initialize($config);
		        if(!$CI->image_lib->resize()) 
		         	echo $CI->image_lib->display_errors();
			} else {
	            $status = "Error al subir el archivo";
		    }
		    unlink($destino_tmp);
			$CI->image_lib->clear();
			return $destino_final;
		}
		else{
			return false;
		}
	}
}
?>