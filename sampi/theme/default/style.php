<?php
/**
 * SampiCMS theme style
 * SampiCMS's default theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Theme\default
 */
/**
 * Start PHPDoc
 */
$phpdoc;

header ( 'Content-Type: text/css' );

if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}

define ( 'ROOT', substr(dirname(__FILE__),0,-20) );
define ( 'REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-30) );
define ( 'ADMIN_ROOT', ROOT . '/sampi/admin' );
define ( 'ADMIN_REL_ROOT', REL_ROOT . '/sampi/admin' );
require_once ROOT . '/sampi/settings.php';
require_once ROOT . '/sampi/functions.php';

$db = new SampiDbFunctions();
$db->getSettings();

if (preg_match ( '/(?i)MSIE [7-8]/', $_SERVER ['HTTP_USER_AGENT'] )) {
	// If IE 7/8
	echo
	"div#header {
		background-image: none;
		-ms-filter: \"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . REL_ROOT ."/sampi/theme/" . theme . "/images/header.png', sizingMethod='scale')\";
		filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . REL_ROOT ."/sampi/theme/" . theme . "/images/header.png', sizingMethod='scale');
	}";
}
?>