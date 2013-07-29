<?php
/**
 * SampiCMS admin theme style
 * SampiCMS's default admin theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin\Theme\default
 */
/**
 * Start PHPDoc
 */
$phpdoc;

header('Content-Type: text/css');

if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}

?>