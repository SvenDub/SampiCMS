<?php

/**
 * SampiCMS query file
 *
 * <p>
 * Check a setup step and echo the response as a JSON encoded string.
 * In this JSON string 'code' is the result code and 'msg' the returned message.
 * </p>
 * Result codes:
 * <p>
 * 1 - Incorrect data
 * 0 - Good
 * -1 - Missing data
 * </p>
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

/**
 * Absolute path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\ROOT', substr ( dirname ( __FILE__ ), 0, - 12 ) );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
*/
define ( 'SampiCMS\REL_ROOT', substr ( $_SERVER ['SCRIPT_NAME'], 0, - 39 ) );
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

$step = (isset ( $_GET ["step"] )) ? $step = $_GET ["step"] : $step = false;

$db_host = (isset ( $_GET ["db_host"] )) ? $db_host = $_GET ["db_host"] : $db_host = false;
$db = (isset ( $_GET ["db"] )) ? $db = $_GET ["db"] : $db = false;
$db_user = (isset ( $_GET ["db_user"] )) ? $db_user = $_GET ["db_user"] : $db_user = false;
$db_pass = (isset ( $_GET ["db_pass"] )) ? $db_pass = $_GET ["db_pass"] : $db_pass = false;

$site_title = (isset ( $_GET ["site_title"] )) ? $site_title = $_GET ["site_title"] : $site_title = false;
$site_description = (isset ( $_GET ["site_description"] )) ? $site_description = $_GET ["site_description"] : $site_description = false;
$date_format = (isset ( $_GET ["date_format"] )) ? $date_format = $_GET ["date_format"] : $date_format = false;

$username = (isset ( $_GET ["username"] )) ? $username = $_GET ["username"] : $username = false;
$password = (isset ( $_GET ["password"] )) ? $password = $_GET ["password"] : $password = false;
$full_name = (isset ( $_GET ["full_name"] )) ? $full_name = $_GET ["full_name"] : $full_name = false;
$twitter_user = (isset ( $_GET ["twitter_user"] )) ? $twitter_user = $_GET ["twitter_user"] : $twitter_user = false;
$facebook_user = (isset ( $_GET ["facebook_user"] )) ? $facebook_user = $_GET ["facebook_user"] : $facebook_user = false;
$google_plus_user = (isset ( $_GET ["google_plus_user"] )) ? $google_plus_user = $_GET ["google_plus_user"] : $google_plus_user = false;

$response = array();

switch ($step) {
	case 2:
		if ($db_host && $db && $db_user && $db_pass) {
			$response ['msg'] = 'Connecting...';
			$con = new \mysqli($db_host, $db_user, $db_pass, $db);
			if ($con->connect_errno == 0) {
				$response ['code'] = 0;
				$response ['msg'] .= '<span style="color: green;">OK!</span><br />';
			} else {
				$response ['code'] = 1;
				$response ['msg'] .= '<span style="color: red;">Error</span><br /><span style="color: red;">' . $con->connect_error . '</span><br />';
			}
		} else {
			$response ['code'] = -1;
			$response ['msg'] = 'Waiting for form to be completed...<br />';
		}
		break;
	case 3:
		if ($site_title && $site_description && $date_format) {
			$response ['code'] = 0;
			$response ['msg'] = 'Checking...';
			$response ['msg'] .= '<span style="color: green;">OK!</span><br />';
		} else {
			$response ['code'] = -1;
			$response ['msg'] = 'Waiting for form to be completed...<br />';
		}
		break;
	case 4:
		if ($username && $password && $full_name) {
			$response ['msg'] = 'Checking...';
			if (strlen($password) < 4) {
				$response ['code'] = 1;
				$response ['msg'] .= '<span style="color: red;">Error</span><br />';
				$response ['msg'] .= '<span style="color: red;">Minimal password length is 4 characters.</span><br />';
			} else {
				if ($twitter_user || $facebook_user || $google_plus_user) {
					if ($twitter_user) {
						if (preg_match ( '/^([A-Za-z0-9_]+)$/', $twitter_user )) {
							$twitter = true;
						} else {
							$twitter = false;
						}
					}
					if ($facebook_user) {
						if (preg_match ( '/^[a-z\d.]{5,}$/i', $facebook_user )) {
							$facebook = true;
						} else {
							$facebook = false;
						}
					}
					if ($google_plus_user) {
						if (preg_match ( '/^([0-9]{21,21})$/', $google_plus_user )) {
							$google_plus = true;
						} else {
							$google_plus = false;
						}
					}
					if ((isset ( $twitter ) && ! $twitter) || (isset ( $facebook ) && ! $facebook) || (isset ( $google_plus ) && ! $google_plus)) {
						$response ['code'] = 1;
						$response ['msg'] .= '<span style="color: red;">Error</span><br />';
						if (isset ( $twitter ) && ! $twitter) {
							$response ['msg'] .= '<span style="color: red;">Invalid Twitter username.</span><br />';
						}
						if (isset ( $facebook ) && ! $facebook) {
							$response ['msg'] .= '<span style="color: red;">Invalid Facebook username.</span><br />';
						}
						if (isset ( $google_plus ) && ! $google_plus) {
							$response ['msg'] .= '<span style="color: red;">Invalid Google+ ID.</span><br />';
						}
					} else {
						$response ['code'] = 0;
						$response ['msg'] .= '<span style="color: green;">OK!</span><br />';
					}
				} else {
					$response ['code'] = 0;
					$response ['msg'] .= '<span style="color: green;">OK!</span><br />';
				}
			}
		} else {
			$response ['code'] = -1;
			$response ['msg'] = 'Waiting for form to be completed...<br />';
		}
		break;
	case 5:
		$response ['code'] = 0;
		$response ['msg'] = '';
		break;
}

echo json_encode($response);

?>