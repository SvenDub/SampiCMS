<?php
/**
 * SampiCMS admin login page
 * Provides login page for the admin interface
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
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
define ( 'ADMIN_REL_ROOT', '/sampi/sampi/admin' );
require_once ROOT . '/sampi/settings.php';
require_once ROOT . '/sampi/functions.php';
require_once ADMIN_ROOT . '/functions.php';
$db = new SampiAdminDbFunctions ();
$db->getSettings ();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Login - SampiCMS</title>
<link href="<?php echo ADMIN_REL_ROOT.'/theme/'.admin_theme.'/style.css'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo ADMIN_REL_ROOT.'/theme/'.admin_theme.'/style.php'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo ADMIN_REL_ROOT.'/favicon.ico'; ?>" rel='shortcut icon' type='image/x-icon' />
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
		<form name="login" action="" method="post">
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
					<td colspan="2"><input type="submit" name="login[submit]" value="Login" /></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>