<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('URL',"https://".$_SERVER['SERVER_NAME']."/Station/");
define('URL_ASSETS',URL."assets/");
define('URL_PLUGINS',URL."plugins/");
define('URL_LESS',URL."less/");
define('URL_IMG',URL."img/");
define('URL_FILES',"./files/");


/* Pour afficher les info bulles */
define('TOOLTIP',"1");

/* Pour les dates BDD */
define('DATE_MASK',"dd/mm/yyyy hh:mm:ss");

/* [ORACLE] */
define('NLS_DATE_FORMAT',"DD/MM/YYYY");
define('NLS_TIMESTAMP_FORMAT',"DD/MM/RR HH24:MI:SSXFF");

/* Titre fenetre navigateur */
define('TITLE',"Console Bihrdy");

/* End of file constants.php */
/* Location: ./application/config/constants.php */