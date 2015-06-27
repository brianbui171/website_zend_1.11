<?php
include_once 'define.php';

//Goi lop Zend Application
require_once 'Zend/Application.php';
$environment = APPLICATION_ENV;
$option = APPLICATION_PATH . '/configs/application.ini';
$application = new Zend_Application ( $environment, $option );
$application->bootstrap ()->run ();