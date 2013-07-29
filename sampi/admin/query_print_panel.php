<?php
if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}

define ( 'ROOT', '/var/www/sampi' );
define ( 'REL_ROOT', '/sampi' );
define ( 'ADMIN_ROOT', '/var/www/sampi/sampi/admin' );
define ( 'ADMIN_REL_ROOT', '/sampi/sampi/admin' );
require_once ROOT . '/sampi/settings.php';
require_once ROOT . '/sampi/functions.php';
require_once ADMIN_ROOT . '/functions.php';
if (isset($_GET['panel'])) {
	if ($_GET['panel'] !== null) {
		global $db;
		$db = new SampiAdminDbFunctions();
		sampi_admin_auth ();
		$db->getSettings();
		$panel = $db->getSinglePanelByName($_GET['panel']);
		$panel->showBody();
	}
}
?>