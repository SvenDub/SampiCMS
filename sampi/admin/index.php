<?php
/**
 * SampiCMS admin main file
 *
 * Starts SampiCMS's admin interface
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;
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
 * @ignore
 */
define ( 'SampiCMS\ROOT', substr(dirname(__FILE__),0,-12) );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-22) );
/**
 * Absolute path to the admin root.
 * @ignore
 */
define ( 'SampiCMS\ADMIN_ROOT', SampiCMS\ROOT . '/sampi/admin' );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\ADMIN_REL_ROOT', SampiCMS\REL_ROOT . '/sampi/admin' );
/**
 * Absolute path to the mobile API root.
 * @ignore
 */
define ( 'SampiCMS\API_ROOT', SampiCMS\ADMIN_ROOT . '/mobileapi' );
/**
 * Relative (web) path to the mobile API root.
 * @ignore
 */
define ( 'SampiCMS\API_REL_ROOT', SampiCMS\ADMIN_REL_ROOT . '/mobileapi' );

require_once SampiCMS\ROOT . '/sampi/settings.php';
require_once SampiCMS\ROOT . '/sampi/functions.php';
require_once SampiCMS\ADMIN_ROOT . '/functions.php';
init ();
?>