<?php
//Duong dan den thu muc chua ung dung
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', 
			  realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV',
              (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
                                         : 'production'));
			  
//Nap duong dan den cac thu vien se su dung trong ung dung
set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__) . '/library',
    get_include_path(),
)));

//------------KHAI BAO DUONG DAN THUC DEN CAC THU MUC --------------
//Duong dan den thu muc /public
define ( 'PUBLIC_PATH', realpath ( dirname ( __FILE__ ) . '/public' ) );
//define('TEMP_PATH', PUBLIC_PATH . '/tmp');
define ( 'FILES_PATH', PUBLIC_PATH . '/files' );
define ( 'SCRIPTS_PATH', PUBLIC_PATH . '/scripts' );

//Duong dan den thu muc /templates
define ( 'TEMPLATE_PATH', PUBLIC_PATH . '/templates' );
//Duong dan den thu muc /captcha
define ( 'CAPTCHA_PATH', PUBLIC_PATH . '/captcha' );
define ( 'BLOCK_PATH', APPLICATION_PATH . '/blocks' );
define ( 'CONFIG_PATH', APPLICATION_PATH . '/configs' );
define ( 'CACHE_PATH', APPLICATION_PATH . '/caches' );

//------------KHAI BAO DUONG DAN URL DEN CAC THU MUC --------------
//Duong dan den thu muc /templates
define ( 'TEMPLATE_URL', '/public/templates' );
//Duong dan den thu muc ung
define ( 'APPLICATION_URL', '' );
define ( 'SRCIPTS_URL', APPLICATION_URL . '/public/scripts' );
define ( 'FILES_URL', APPLICATION_URL . '/public/files' );
define ( 'CAPTCHA_URL', APPLICATION_URL . '/public/captcha' );
define ( 'CSS_URL', APPLICATION_URL . '/public/css' );
define ( 'JWPLAYER_URL', APPLICATION_URL . '/public/jwplayer' );