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

if(	!function_exists('in_array_r')){
	
	function in_array_r($needle, $haystack, $strict = true) {
	    foreach ($haystack as $item) {
	        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
	            return true;
	        }
	    }
	
	    return false;
	}
}
/* End of file url_amigabel_helper.php */
/* Location: ./aplication/helpers/multidimencional_array_helper.php */