<?php
if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}

define ( 'ROOT', substr(dirname(__FILE__),0,-12) );
define ( 'REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-32) );
define ( 'ADMIN_ROOT', ROOT . '/sampi/admin' );
define ( 'ADMIN_REL_ROOT', REL_ROOT . '/sampi/admin' );
require_once ROOT . '/sampi/settings.php';
require_once ROOT . '/sampi/functions.php';
require_once ADMIN_ROOT . '/functions.php';

$post_nr = (isset ( $_GET ["post_nr"] )) ? $post_nr = $_GET ["post_nr"] : $post_nr = false;
$title = (isset ( $_GET ["title"] )) ? $title = $_GET ["title"] : $title = false;
$content = (isset ( $_GET ["content"] )) ? $content = $_GET ["content"] : $content = false;

if ($post_nr && $title && $content) {
		global $db;
		$db = new SampiAdminDbFunctions();
		sampi_admin_auth ();
		$username = $_COOKIE['username'];
		$password = $_COOKIE['password'];
		$db->getSettings();
		$post = $db->editPost($post_nr, $title, $content, $keywords, $username, $password);
		if ($post) {
			echo 'Post edited!';
		} else {
			echo 'Error editing post!';
		}
} else {
	echo 'Error editing post!';
}
?>