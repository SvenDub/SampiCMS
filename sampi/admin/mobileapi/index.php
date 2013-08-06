<?php
/**
 * SampiCMS mobile API
 * Handles requests for the mobile app.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin\MobileAPI
 */
/**
 * Start PHPDoc
 */
$phpdoc;
define ( 'ROOT', substr(dirname(__FILE__),0,-22) );
define ( 'REL_ROOT', substr($_SERVER['SCRIPT_NAME'],0,-32) );
define ( 'ADMIN_ROOT', ROOT . '/sampi/admin' );
define ( 'ADMIN_REL_ROOT', REL_ROOT . '/sampi/admin' );
define ( 'API_ROOT', ADMIN_ROOT . '/mobileapi' );
define ( 'API_REL_ROOT', ADMIN_REL_ROOT . '/mobileapi' );

require_once 'SampiMobileDbFunctions.php';
$db = new SampiMobileDbFunctions ();

$db->getSettings();

if (isset ( $_POST ['tag'] ) && $_POST ['tag'] != '') {
	$tag = $_POST ['tag'];
	
	$response = array (
			'tag' => $tag,
			'success' => 0,
			'error' => 0
	);
	$security_key = $db->getSecurityKey ();
	
	$username = $_POST ['username'];
	$password = $_POST ['password'];
	
	$user = $db->checkAuth ( $username, $password );
	
	switch ($tag) {
		case 'login' :
			if ($user != false) {
				$response ['success'] = 1;
				$response ['user'] ['id'] = $user ['id'];
				$response ['user'] ['username'] = $user ['username'];
				$response ['user'] ['password'] = $user ['password'];
				$response ['user'] ['full_name'] = $user ['full_name'];
				$response ['user'] ['rights'] = $user ['rights'];
				$response ['user'] ['twitter_user'] = $user ['twitter_user'];
				echo json_encode ( $response );
			} else {
				$response ['error'] = 1;
				$response ['error_msg'] = 'Error logging in. Are you sure you\'ve entered the correct credentials?';
				echo json_encode ( $response );
			}
			break;
		case 'new_post' :
			if ($user != false) {
				$title = @$_POST ['title'];
				$content = @$_POST ['content'];
				$keywords = @$_POST ['keywords'];
				if ($db->newPost ( $title, $content, $keywords, $username, $password ) == true) {
					$response ['success'] = 1;
				} else {
					$response ['error'] = 1;
					$response ['error_msg'] = 'Error adding post.';
				}
				echo json_encode ( $response );
			} else {
				$response ['error'] = 1;
				$response ['error_msg'] = 'Error logging in. Are you sure you\'ve entered the correct credentials?';
				echo json_encode ( $response );
			}
			break;
		case 'settings' :
			if ($user != false) {
				$settings = $db->returnSettings ();
				$response ['success'] = 1;
				foreach ( $settings as $setting => $value ) {
					$response ['settings'] [$setting] = $value;
				}
				echo json_encode ( $response );
			} else {
				$response ['error'] = 1;
				$response ['error_msg'] = 'Error logging in. Are you sure you\'ve entered the correct credentials?';
				echo json_encode ( $response );
			}
			break;
		case 'fetch_posts' :
			if ($user != false) {
				$posts = $db->getPosts ();
				$response ['success'] = 1;
				foreach ( $posts as $key => $val ) {
					$response ['posts'] [$val->getNr()] ['post_nr'] = $val->getNr();
					$response ['posts'] [$val->getNr()] ['date'] = $val->getDate();
					$response ['posts'] [$val->getNr()] ['author'] = $val->getAuthor(SampiPost::$AUTHOR_USERNAME);
					$response ['posts'] [$val->getNr()] ['title'] = $val->getTitle();
					$response ['posts'] [$val->getNr()] ['content'] = $val->getContent();
				}
				echo json_encode ( $response );
			} else {
				$response ['error'] = 1;
				$response ['error_msg'] = 'Error logging in. Are you sure you\'ve entered the correct credentials?';
				echo json_encode ( $response );
			}
			break;
		case 'fetch_authors' :
			if ($user != false) {
				$authors = $db->getAuthors ();
				$response ['success'] = 1;
				foreach ( $authors as $key => $val ) {
					$response ['authors'] [$val->getId ()] ['id'] = $val->getId ();
					$response ['authors'] [$val->getId ()] ['username'] = $val->getUsername ();
					$response ['authors'] [$val->getId ()] ['full_name'] = $val->getName ();
					$response ['authors'] [$val->getId ()] ['twitter_user'] = $val->getTwitter ();
				}
				echo json_encode ( $response );
			} else {
				$response ['error'] = 1;
				$response ['error_msg'] = 'Error logging in. Are you sure you\'ve entered the correct credentials?';
				echo json_encode ( $response );
			}
			break;
		default :
			$response ['error'] = 1;
			$response ['error_msg'] = 'Invalid Request';
			echo json_encode ( $response );
			break;
	}
} else {
	$response ['error_msg'] = 'Access Denied';
	echo json_encode ( $response );
}
