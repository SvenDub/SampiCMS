<?php

/**
 * SampiCMS admin login page
 *
 * Provides login page for the admin interface
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
 *
 * @ignore
 *
 */
define ( 'SampiCMS\ROOT', substr ( dirname ( __FILE__ ), 0, - 12 ) );
/**
 * Relative (web) path to the root of SampiCMS.
 *
 * @ignore
 *
 */
define ( 'SampiCMS\REL_ROOT', substr ( $_SERVER ['SCRIPT_NAME'], 0, - 22 ) );
/**
 * Absolute path to the admin root.
 *
 * @ignore
 *
 */
define ( 'SampiCMS\ADMIN_ROOT', SampiCMS\ROOT . '/sampi/admin' );
/**
 * Relative (web) path to the root of SampiCMS.
 *
 * @ignore
 *
 */
define ( 'SampiCMS\ADMIN_REL_ROOT', SampiCMS\REL_ROOT . '/sampi/admin' );

require_once SampiCMS\ROOT . '/sampi/settings.php';
require_once SampiCMS\ROOT . '/sampi/functions.php';
require_once SampiCMS\ADMIN_ROOT . '/functions.php';
$db = new DbFunctions ();
$db->getSettings ();
?>
<!DOCTYPE html>
<html>
<head>
<title>Login - SampiCMS</title>
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT . '/theme/' . admin_theme . '/global_style.css'; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT.'/favicon.ico'; ?>" rel='shortcut icon' type='image/x-icon' />
</head>
<body style="height: auto;">
	<div id="login">
		<div id="login_header">
			<div id="login_header_title">Login</div>
		</div>
		<div id="login_msg">
		<?php
		if (isset ( $error )) {
			echo '<p>Error logging in. Are you sure you\'ve entered the correct credentials?</p>';
		}
		?>
		</div>
		<form name="login" action="<?php if ($_SERVER['REQUEST_URI'] == SampiCMS\ADMIN_REL_ROOT . '/login.php') { echo SampiCMS\ADMIN_REL_ROOT;} ?>" method="post">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="login[username]" /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="login[password]" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;<input type="submit" name="login[submit]" value="Login" /><input type="button" onclick="window.location.href='<?php echo SampiCMS\REL_ROOT; ?>';" value="Back" class="ui-align-right"></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>