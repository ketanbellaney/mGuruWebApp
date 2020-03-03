<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| EMAIL CONFING
| -------------------------------------------------------------------
| Configuration of outgoing mail server.
|
*/

$config['smtp_timeout']='30';
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl:';
$config['smtp_port'] = '465';
$config['smtp_user'] = '';
$config['smtp_pass'] = '';
$config['charset'] = 'utf-8';
$config['mailtype'] = 'html';
$config['newline'] = "\r\n";


/* End of file email.php */
/* Location: ./system/application/config/email.php */
?>