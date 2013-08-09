<?php
/**
 * SampiCMS query file
 * Posts a comment by querying the database
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
define ( 'ROOT', substr(dirname(__FILE__),0,-6) );
define ( 'REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-28) );
define ( 'ADMIN_ROOT', ROOT . '/sampi/admin' );
define ( 'ADMIN_REL_ROOT', REL_ROOT . '/sampi/admin' );
require_once ROOT . '/sampi/settings.php';
require_once ROOT . '/sampi/functions.php';

$post_nr = (isset ( $_GET ["post_nr"] )) ? $post_nr = $_GET ["post_nr"] : $post_nr = false;
$author = (isset ( $_GET ["author"] )) ? $author = $_GET ["author"] : $author = false;
$content = (isset ( $_GET ["content"] )) ? $content = $_GET ["content"] : $content = false;

if ($post_nr && $author && $content) {
	$db = new SampiDbFunctions();
	$db->getSettings();
	$db->newComment($post_nr, $author, $content);
} else {
	echo 'Error posting comment!';
}
?>