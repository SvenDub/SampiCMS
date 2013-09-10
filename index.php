<?php
/**
 * SampiCMS main file
 *
 * Starts SampiCMS
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @version 0.0.1-alpha
 */
/**
 * Namespace
 */
namespace SampiCMS;
use SampiCMS;
// Use gzip for improved speeds, if available
if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}

session_start();

/**
 * Absolute path to the root of SampiCMS.
 */
define ( 'SampiCMS\ROOT', dirname(__FILE__) );
/**
 * Relative (web) path to the root of SampiCMS.
 */
define ( 'SampiCMS\REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-10) );
/**
 * Absolute path to the admin root.
 */
define ( 'SampiCMS\ADMIN_ROOT', SampiCMS\ROOT . '/sampi/admin' );
/**
 * Relative (web) path to the root of SampiCMS.
 */
define ( 'SampiCMS\ADMIN_REL_ROOT', SampiCMS\REL_ROOT . '/sampi/admin' );
/**
 * Absolute path to the mobile API root.
 */
define ( 'SampiCMS\API_ROOT', SampiCMS\ADMIN_ROOT . '/mobileapi' );
/**
 * Relative (web) path to the mobile API root.
 */
define ( 'SampiCMS\API_REL_ROOT', SampiCMS\ADMIN_REL_ROOT . '/mobileapi' );

require_once SampiCMS\ROOT . '/sampi/settings.php';
require_once SampiCMS\ROOT . '/sampi/functions.php';

init ();
?>
