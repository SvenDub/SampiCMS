<?php
/**
 * SampiCMS main file
 * Starts SampiCMS
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
/**
 * Start PHPDoc
 */
$phpdoc;
if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}
session_start();
define ( 'ROOT', dirname(__FILE__) );
define ( 'REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-10) );
define ( 'ADMIN_ROOT', ROOT . '/sampi/admin' );
define ( 'ADMIN_REL_ROOT', REL_ROOT . '/sampi/admin' );
require_once ROOT . '/sampi/settings.php';
require_once ROOT . '/sampi/functions.php';
sampi_init ();
?>
