<?php

/**
 * SampiCMS query file
 *
 * <p>
 * Save a setup step and echo the response as a JSON encoded string.
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
define ( 'SampiCMS\REL_ROOT', substr ( $_SERVER ['SCRIPT_NAME'], 0, - 38 ) );
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

require_once SampiCMS\ROOT . '/sampi/functions.php';
require_once SampiCMS\ADMIN_ROOT . '/functions.php';

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
			$response ['msg'] = 'Saving settings...';
			if (is_writeable(SampiCMS\ROOT.'/sampi/settings.php')) {
				// Modify settings.php
				$content = file(SampiCMS\ROOT.'/sampi/settings.php');
	
				$db_host_line = SampiCMS\searchInFile('SampiCMS\db_host', $content);
				$content[$db_host_line] = "define ( 'SampiCMS\db_host', '".$db_host."' );\n";
				
				$db_line = SampiCMS\searchInFile('SampiCMS\db', $content);
				$content[$db_line] = "define ( 'SampiCMS\db', '".$db."' );\n";
				
				$db_user_line = SampiCMS\searchInFile('SampiCMS\db_user', $content);
				$content[$db_user_line] = "define ( 'SampiCMS\db_user', '".$db_user."' );\n";
				
				$db_pass_line = SampiCMS\searchInFile('SampiCMS\db_pass', $content);
				$content[$db_pass_line] = "define ( 'SampiCMS\db_pass', '".$db_pass."' );\n";
				
				file_put_contents(SampiCMS\ROOT.'/sampi/settings.php', implode('', $content));
				
				$response ['code'] = 0;
				$response ['msg'] .= '<span style="color: green;">OK!</span><br />';
				
				$response ['msg'] .= 'Creating tables...';
				
				$query = file_get_contents(SampiCMS\ADMIN_ROOT.'/resources/sql/db.sql');
				
				// Create tables
				$con = new \mysqli($db_host, $db_user, $db_pass, $db);
				$con->multi_query($query);
				while ($con->next_result()) {;}
				
				// Check tables
				$check = array();
				
				$con = new \mysqli($db_host, $db_user, $db_pass, $db);
				$stmt = $con->stmt_init();
				$stmt->prepare("SELECT * FROM sampi_comments");
				$stmt->execute();
				if ($stmt->errno !== 0) {
					$check ['sampi_comments'] = $stmt->error;
				}
				$stmt->close();
				
				$stmt = $con->stmt_init();
				$stmt->prepare("SELECT * FROM sampi_menu");
				$stmt->execute();
				if ($stmt->errno !== 0) {
					$check ['sampi_menu'] = $stmt->error;
				}
				$stmt->close();
				
				$stmt = $con->stmt_init();
				$stmt->prepare("SELECT * FROM sampi_panels");
				$stmt->execute();
				if ($stmt->errno !== 0) {
					$check ['sampi_panels'] = $stmt->error;
				}
				$stmt->close();
				
				$stmt = $con->stmt_init();
				$stmt->prepare("SELECT * FROM sampi_posts");
				$stmt->execute();
				if ($stmt->errno !== 0) {
					$check ['sampi_posts'] = $stmt->error;
				}
				$stmt->close();
				
				$stmt = $con->stmt_init();
				$stmt->prepare("SELECT * FROM sampi_settings");
				$stmt->execute();
				if ($stmt->errno !== 0) {
					$check ['sampi_settings'] = $stmt->error;
				}
				$stmt->close();
				
				$stmt = $con->stmt_init();
				$stmt->prepare("SELECT * FROM sampi_statics");
				$stmt->execute();
				if ($stmt->errno !== 0) {
					$check ['sampi_statics'] = $stmt->error;
				}
				$stmt->close();
				
				$stmt = $con->stmt_init();
				$stmt->prepare("SELECT * FROM sampi_users");
				$stmt->execute();
				if ($stmt->errno !== 0) {
					$check ['sampi_users'] = $stmt->error;
				}
				$stmt->close();
				
				if (count($check) == 0) {
					$response ['code'] = 0;
					$response ['msg'] .= '<span style="color: green;">OK!</span>';
				} else {
					$response ['code'] = 2;
					$response ['msg'] .= '<span style="color: red;">Error</span><br /><span style="color: red;">Do you have the required permissions? The following are required: SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX.</span><br />';
					foreach ($check as $table=>$error) {
						$response ['msg'] .= '<span style="color: red;">'.$error.'</span><br />';
					}
				}
			} else {
				$response ['code'] = 1;
				$response ['msg'] .= '<span style="color: red;">Error</span><br /><span style="color: red;">Settings file not writable. Are the file permissions correctly set up?</span><br />';
			}
		} else {
			$response ['code'] = -1;
			$response ['msg'] = 'Waiting for form to be completed...<br />';
		}
		break;
	case 3:
		if ($site_title && $site_description && $date_format) {
			$response ['code'] = 0;
			$response ['msg'] = 'Saving settings...';
			
			$db = new SampiCMS\Admin\DbFunctions();
			
			$settings = array(
					'theme' => 'default',
					'site_title' => $site_title,
					'site_description' => $site_description,
					'date_format' => $date_format,
					'window_title' => '%site_title%',
					'per_page_values' => '5,10,20,50',
					'admin_theme' => 'default',
					'admin_window_title' => '%site_title% - Admin panel - SampiCMS'
			);
			
			$check = array();
			
			foreach ($settings as $name => $value) {
				$errno = $db->saveSetting($name, $value);
				if ($errno !== 0) {
					$check [$name] = $errno;
				}
			}
			
			if (count ( $check ) == 0) {
				$response ['code'] = 0;
				$response ['msg'] .= '<span style="color: green;">OK!</span>';
			} else {
				$response ['code'] = 2;
				$response ['msg'] .= '<span style="color: red;">Error</span><br /><span style="color: red;">Do you have the required permissions for the database? The following are required: SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX.</span><br />';
				foreach ( $check as $setting => $error ) {
					$response ['msg'] .= '<span style="color: red;">' . $error . '</span><br />';
				}
			}
		} else {
			$response ['code'] = -1;
			$response ['msg'] = 'Waiting for form to be completed...<br />';
		}
		break;
	case 4:
		if ($username && $password && $full_name) {
			$response ['msg'] = 'Saving user...';
			$db = new SampiCMS\Admin\DbFunctions();
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
						if ($db->newAuthor($username, $password, $full_name, '', $twitter_user, $facebook_user, $google_plus_user)) {
							$db->saveSetting('global_user', $username);
							$response ['code'] = 0;
							$response ['msg'] .= '<span style="color: green;">OK!</span><br />';
						} else {
							$response ['code'] = 2;
							$response ['msg'] .= '<span style="color: red;">Error</span><br /><span style="color: red;">Do you have the required permissions for the database? The following are required: SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX.</span><br />';
						}
					}
				} else {
					if ($db->newAuthor($username, $password, $full_name, '')) {
						$db->saveSetting('global_user', $username);
						$response ['code'] = 0;
						$response ['msg'] .= '<span style="color: green;">OK!</span><br />';
					} else {
						$response ['code'] = 2;
						$response ['msg'] .= '<span style="color: red;">Error</span><br /><span style="color: red;">Do you have the required permissions for the database? The following are required: SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX.</span><br />';
					}
				}
			}
		} else {
			$response ['code'] = -1;
			$response ['msg'] = 'Waiting for form to be completed...<br />';
		}
		break;
	case 5:
		$response ['msg'] = 'Saving settings...';
		if (is_writeable(SampiCMS\ROOT.'/sampi/settings.php')) {
			// Modify settings.php
			$content = file(SampiCMS\ROOT.'/sampi/settings.php');
		
			$db_host_line = SampiCMS\searchInFile('SampiCMS\set_up', $content);
			$content[$db_host_line] = "define ( 'SampiCMS\set_up', true );\n";
		
			file_put_contents(SampiCMS\ROOT.'/sampi/settings.php', implode('', $content));
			
			$response ['code'] = 0;
			$response ['msg'] .= '<span style="color: green;">OK!</span><br />';
		} else {
			$response ['code'] = 1;
			$response ['msg'] .= '<span style="color: red;">Error</span><br /><span style="color: red;">Settings file not writable. Are the file permissions correctly set up?</span><br />';
		}
		break;
}

echo json_encode($response);
?>