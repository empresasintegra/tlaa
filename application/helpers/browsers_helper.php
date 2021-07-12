<?php 
if ( ! function_exists('getBrowser'))
{
	function getBrowser()
	{
		$CI =& get_instance();
		$CI->load->library('user_agent');
		if ($CI->agent->is_browser())
		{
		    $agent = $CI->agent->browser().' '.$CI->agent->version();
			if($CI->agent->browser() == "Internet Explorer"){
				if($CI->agent->version() < 10){
					return true;
				}
			}
		}
		return false;
	}
}
?>