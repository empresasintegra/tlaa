<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'local';
$active_record = TRUE;

$db['local']['hostname'] = 'localhost';
$db['local']['username'] = 'root';
$db['local']['password'] = '';
$db['local']['database'] = 'intgracl_transportes';
//$db['local']['port']     = 3050;
$db['local']['dbdriver'] = 'mysql';
$db['local']['dbprefix'] = '';
$db['local']['pconnect'] = FALSE;
$db['local']['db_debug'] = TRUE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = '';
$db['local']['char_set'] = 'utf8';
$db['local']['dbcollat'] = 'utf8_general_ci';
$db['local']['swap_pre'] = '';
$db['local']['autoinit'] = TRUE;
$db['local']['stricton'] = FALSE;


/*$db['local']['hostname'] = 'localhost';
$db['local']['username'] = 'SYSDBA';
$db['local']['password'] = 'integra';//demente
$db['local']['database'] = 'C:\SISTEMAS_INTEGRA.FDB';
$db['local']['port']      = 3050;
$db['local']['dbdriver'] = 'firebird';
$db['local']['dbprefix'] = '';
$db['local']['pconnect'] = FALSE;
$db['local']['db_debug'] = TRUE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = '';
$db['local']['char_set'] = 'utf8';
$db['local']['dbcollat'] = 'utf8_general_ci';
$db['local']['swap_pre'] = '';
$db['local']['autoinit'] = TRUE;
$db['local']['stricton'] = FALSE;*/

// $db['externo']['hostname'] = 'mysql.integraest.cl';
// $db['externo']['username'] = 'usr_sistema';
// $db['externo']['password'] = 'integra123';//demente
// $db['externo']['database'] = 'sgo_est';
// $db['externo']['dbdriver'] = 'mysql';
// $db['externo']['dbprefix'] = '';
// $db['externo']['pconnect'] = TRUE;
// $db['externo']['db_debug'] = TRUE;
// $db['externo']['cache_on'] = FALSE;
// $db['externo']['cachedir'] = '';
// $db['externo']['char_set'] = 'utf8';
// $db['externo']['dbcollat'] = 'utf8_spanish2_ci';
// $db['externo']['swap_pre'] = '';
// $db['externo']['autoinit'] = TRUE;
// $db['externo']['stricton'] = FALSE;



/* End of file database.php */
/* Location: ./application/config/database.php */