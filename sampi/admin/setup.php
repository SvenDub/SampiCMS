<?php

/**
 * SampiCMS Setup
 *
 * Provides the setup process for new installations.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;
use SampiCMS;
// Use gzip for improved speeds, if available and not already used
if (! array_search ( 'ob_gzhandler', ob_list_handlers () )) {
	if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
		ob_start ( "ob_gzhandler" );
	} else {
		ob_start ();
	}
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
define ( 'SampiCMS\REL_ROOT', substr ( $_SERVER ['SCRIPT_NAME'], 0, - 22 ) );
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

if (!SampiCMS\set_up) :
?>
<!DOCTYPE html>
<html>
<head>
<title>Setup - SampiCMS</title>
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT . '/theme/default/global_style.css'; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT.'/favicon.ico'; ?>" rel='shortcut icon' type='image/x-icon' />
<script type="text/javascript" src="<?php echo SampiCMS\REL_ROOT.'/sampi/resources/js/json2.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo SampiCMS\ADMIN_REL_ROOT,'/functions.js'; ?>"></script>
<script type="text/javascript" src="<?php echo SampiCMS\ADMIN_REL_ROOT,'/resources/js/setup.js'; ?>"></script>
<meta name="REL_ROOT" content="<?php echo SampiCMS\REL_ROOT; ?>">
<meta name="ADMIN_REL_ROOT" content="<?php echo SampiCMS\ADMIN_REL_ROOT; ?>">
</head>
<body>
	<div id="setup">
		<div id="setup_header">
			<div id="setup_header_title">Setup</div>
			<div id="setup_header_subtitle">SampiCMS</div>
		</div>
		<div id="setup_body">
			<div style="text-align: center;">
				<img src="<?php echo SampiCMS\REL_ROOT.'/sampi/resources/images/logo_m.png'?>" alt="SampiCMS Logo" />
			</div>
		</div>
		<div id="setup_footer">
			<div id="setup_footer_1">1. Welcome</div>
			<div id="setup_footer_2">2. Database</div>
			<div id="setup_footer_3">3. Settings</div>
			<div id="setup_footer_4">4. Users</div>
			<div id="setup_footer_5">5. Done!</div>
		</div>
	</div>
</body>
</html>
<?php
else :
?>
<!DOCTYPE html>
<html>
<head>
<title>Setup - SampiCMS</title>
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT . '/theme/default/global_style.css'; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT.'/favicon.ico'; ?>" rel='shortcut icon' type='image/x-icon' />
<script type="text/javascript" src="<?php echo SampiCMS\ADMIN_REL_ROOT,'/functions.js'; ?>"></script>
<meta name="REL_ROOT" content="<?php echo SampiCMS\REL_ROOT; ?>">
<meta name="ADMIN_REL_ROOT" content="<?php echo SampiCMS\ADMIN_REL_ROOT; ?>">
</head>
<body>
	<div id="setup">
		<div id="setup_header">
			<div id="setup_header_title">Setup</div>
			<div id="setup_header_subtitle">SampiCMS</div>
		</div>
		<div id="setup_body">
			<p>The setup has already been completed! Please return to the <a href="<?php echo SampiCMS\REL_ROOT; ?>">site</a>.</p>
		</div>
	</div>
</body>
</html>
<?php
endif;
?>