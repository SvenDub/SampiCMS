<?php

/**
 * SampiCMS theme style
 *
 * Dynamic stylesheet.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Theme\Sampi13
 */
/**
 * Namespace
 */
namespace SampiCMS\Theme\Sampi13;

use SampiCMS;

header ( 'Content-Type: text/css' );

if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}

/**
 * Absolute path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\ROOT', substr(dirname(__FILE__),0,-20) );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-30) );
/**
 * Absolute path to the admin root.
 * @ignore
 */
define ( 'SampiCMS\ADMIN_ROOT', \SampiCMS\ROOT . '/sampi/admin' );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\ADMIN_REL_ROOT', \SampiCMS\REL_ROOT . '/sampi/admin' );
require_once SampiCMS\ROOT . '/sampi/settings.php';
require_once SampiCMS\ROOT . '/sampi/functions.php';

$db = new SampiCMS\DbFunctions();
$db->getSettings();

if (preg_match ( '/(?i)MSIE [7-8]/', $_SERVER ['HTTP_USER_AGENT'] )) {
	// If IE 7/8
	echo
	"div#header {
		background-image: none;
		-ms-filter: \"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . SampiCMS\REL_ROOT ."/sampi/theme/" . theme . "/images/header.png', sizingMethod='scale')\";
		filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . SampiCMS\REL_ROOT ."/sampi/theme/" . theme . "/images/header.png', sizingMethod='scale');
	}";
}
?>