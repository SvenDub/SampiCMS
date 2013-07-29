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
define ( 'ROOT', '/var/www/sampi' );
define ( 'REL_ROOT', '/sampi' );
define ( 'ADMIN_ROOT', '/var/www/sampi/sampi/admin' );
define ( 'ADMIN_REL_ROOT', '/sampi/admin' );
require_once ROOT . '/sampi/settings.php';
require_once ROOT . '/sampi/functions.php';

$post_nr = (isset ( $_GET ["post_nr"] )) ? $post_nr = $_GET ["post_nr"] : $post_nr = false;

if ($post_nr) {
	$db = new SampiDbFunctions();
	$db->getSettings();
	$comments = $db->getComments($post_nr);
	foreach ($comments as $key => $val) {
		$val->show();
	}
} else {
	echo 'Error loading comments!';
}
?>