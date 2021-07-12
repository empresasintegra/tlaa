<?php 
	if ( !function_exists('encode_to_url'))
	{
		function encode_to_url($subject)
	    {
	        $pos_slash=  strpos($subject, '/');
	        if($pos_slash!==false)
	        {
	            $codigo_email_s= str_replace('/', ':', $subject);
	        }
	        else {$codigo_email_s=$subject;}
	        $pos_igual=  strpos($codigo_email_s, '=');
	        if($pos_igual!==false)
	        {
	            $codigo_email_m=  str_replace('=', '_', $codigo_email_s);
	        }
	        else {$codigo_email_m=$codigo_email_s;}
	        $pos_mas=  strpos($codigo_email_m, '+');
	        if($pos_mas!==false)
	        {
	            $codigo_email=  str_replace('+', '~', $codigo_email_m);
	        }
	        else {$codigo_email=$codigo_email_m;}
	        
	        return $codigo_email;
	    }
	}
	
	if ( !function_exists('url_to_encode'))
	{
		function url_to_encode($codigo)
	    {
	        $pos_slash=  strpos($codigo, ':');
	        if($pos_slash!==false)
	        {
	            $codigo_email_s= str_replace(':', '/', $codigo);
	        }
	        else {$codigo_email_s=$codigo;}
	        $pos_igual=  strpos($codigo_email_s, '_');
	        if($pos_igual!==false)
	        {
	            $codigo_email_m=  str_replace('_', '=', $codigo_email_s);
	        }
	        else {$codigo_email_m=$codigo_email_s;}
	        $pos_mas=  strpos($codigo_email_m, '~');
	        if($pos_mas!==false)
	        {
	            $subject=  str_replace('~', '+', $codigo_email_m);
	        }
	        else {$subject=$codigo_email_m;}
	        
	        return $subject;
	    }
	}

?>  