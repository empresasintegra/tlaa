<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Encoded url
 *
 * Create a spam-protected mailto link written in Javascript
 *
 * @access	public
 * @param	string	the link title
 * @return	string
 */

if(	!function_exists('convert')){
	
	function convert($string = '')
	{
		$string = trim($string);
 
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('n', 'N', 'c', 'C'),
	        $string
	    );
		
		$string = str_replace(
			 array('-', ' '),
	        array('_', '_'),
	        $string
		);
	 
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    $string = str_replace(
	        array("\\", "¨", "º", "~",
	             "#", "@", "|", "!", "\"",
	             "·", "$", "%", "&", "/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "`", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "<", ";", ",", ":",
	             ".",),
	        '',
	        $string
	    );
	return utf8_encode(strtolower($string));
	}
}
/* End of file url_amigabel_helper.php */
/* Location: ./aplication/helpers/url_amigable_helper.php */