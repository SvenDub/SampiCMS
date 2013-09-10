<?php

/**
 * SampiCMS admin theme style
 *
 * SampiCMS's default admin theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin\Theme\Sampi13;
use SampiCMS;
use SampiCMS\Admin;

header ( 'Content-Type: text/css' );

// Use gzip for improved speeds, if available
if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}

?>