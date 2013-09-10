<?php

/**
 * SampiCMS query file
 *
 * Posts a comment by querying the database.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace;
 */
namespace SampiCMS;
use SampiCMS;

// Use gzip for improved speeds, if available
if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}
session_start ();
/**
 * Absolute path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\ROOT', substr(dirname(__FILE__),0,-6) );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-28) );
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

require_once SampiCMS\ROOT . '/sampi/settings.php';
require_once SampiCMS\ROOT . '/sampi/functions.php';

$post_nr = (isset ( $_GET ["post_nr"] )) ? $post_nr = $_GET ["post_nr"] : $post_nr = false;
$author = (isset ( $_GET ["author"] )) ? $author = $_GET ["author"] : $author = false;
$content = (isset ( $_GET ["content"] )) ? $content = $_GET ["content"] : $content = false;

if ($post_nr && $author && $content) {
	$db = new DbFunctions ();
	$db->getSettings ();
	$db->newComment ( $post_nr, $author, $content );
} else {
	echo 'Error posting comment!';
}
?>