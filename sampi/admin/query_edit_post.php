<?php

/**
 * SampiCMS query file
 *
 * Edit a post.
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
session_start ();
/**
 * Absolute path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\ROOT', substr ( dirname ( __FILE__ ), 0, - 12 ) );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\REL_ROOT', substr ( $_SERVER ['SCRIPT_NAME'], 0, - 32 ) );
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
require_once SampiCMS\ADMIN_ROOT . '/functions.php';

$post_nr = (isset ( $_GET ["post_nr"] )) ? $post_nr = $_GET ["post_nr"] : $post_nr = false;
$title = (isset ( $_GET ["title"] )) ? $title = $_GET ["title"] : $title = false;
$content = (isset ( $_GET ["content"] )) ? $content = $_GET ["content"] : $content = false;
$keywords = (isset ( $_GET ["keywords"] )) ? $keywords = $_GET ["keywords"] : $keywords = false;

if ($post_nr && $title && $content) {
	global $db;
	$db = new DbFunctions ();
	SampiCMS\admin_auth ();
	$db->getSettings ();
	$post = $db->editPost ( $post_nr, $title, $content, $keywords );
	if ($post) {
		echo 'Post edited!';
	} else {
		echo 'Error editing post!';
	}
} else {
	echo 'Error editing post!';
}
?>