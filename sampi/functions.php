<?php
/**
 * SampiCMS functions file.
 * This file contains almost all functions that are required to run SampiCMS properly.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
/**
 * Start PHPDoc
 */
$phpdoc;

/**
 * Handles errors.
 * Does this by logging them and displaying an error-page if it's a fatal error.
 *
 * @param int $code
 *        	Required argument. Specifies error code.
 * @param string $arg
 *        	Optional argument. Specifies detailed error message.
 * @param boolean $fatal
 *        	Optional argument. 'True' for fatal error.
 */
function sampi_error($code, $arg = '', $fatal = false) {
	$log = fopen ( ROOT . '/sampi/error.log', 'a' );
	
	if ($code == 100) {
		$err = 'Error contacting database: ' . $arg;
		$fatal = true;
	} elseif ($code == 101) {
		$err = 'Query "' . $arg . '" failed';
	} elseif ($code == 102) {
		$err = 'Processing results failed for query "' . $arg . '"';
	} elseif ($code == 200) {
		$err = 'Required file missing: ' . $arg;
	} elseif ($code == 201) {
		$err = 'Required theme file missing: ' . $arg;
	} elseif ($code == 202) {
		$err = 'Required admin file missing: ' . $arg;
	} else {
		$err = 'Unknown error: ' . $code . ':' . $arg;
	}
	
	if ($fatal) {
		fwrite ( $log, '[' . date ( 'Y-m-d H:i:s' ) . '] FATAL! ' . $code . ': ' . $err . "\n" );
		fclose ( $log );
		print ('<script type="text/javascript">function go() {window.location.href = "' . REL_ROOT . '?error=' . $code . '";} setTimeout("go()",0);</script>') ;
		die ();
	} else {
		fwrite ( $log, '[' . date ( 'Y-m-d H:i:s' ) . '] ' . $code . ': ' . $err . "\n" );
		fclose ( $log );
	}
}
/**
 * First function called upon start.
 * Initializes connection with database or displays error page if necessary.
 */
function sampi_init() {
	global $db;
	if (isset ( $_GET ['error'] )) {
		@include_once (ROOT . '/sampi/error.php');
		die ();
	}
	$db = new SampiDbFunctions();
	sampi_get_params ();
	$db->getSettings();
	sampi_header ();
	sampi_theme ();
	sampi_footer ();
}

/**
 * Includes header.
 * Opens &lt;html&gt;-tag, adds &lt;head&gt;-part and open &lt;body&gt;-tag.
 */
function sampi_header() {
	(@include_once (ROOT . '/sampi/header.php')) || sampi_error ( 200, 'header.php', true );
}

/**
 * Includes footer.
 * Closes &lt;body&gt; and &lt;html&gt;-tags.
 */
function sampi_footer() {
	(@include_once (ROOT . '/sampi/footer.php')) || sampi_error ( 200, 'footer.php', true );
}

/**
 * Includes theme main file.
 */
function sampi_theme() {
	(@include_once (ROOT . '/sampi/theme/' . theme . '/index.php')) || sampi_error ( 201, 'index.php', true );
}

/**
 * Includes theme header.
 * The theme header is the visual top of the page.
 */
function sampi_theme_header() {
	(@include_once (ROOT . '/sampi/theme/' . theme . '/header.php')) || sampi_error ( 201, 'header.php', true );
}

/**
 * Includes theme footer.
 * The theme footer is the visual bottom of the page.
 */
function sampi_theme_footer() {
	(@include_once (ROOT . '/sampi/theme/' . theme . '/footer.php')) || sampi_error ( 201, 'footer.php', true );
}

/**
 * Converts constant with setting for normal usage.
 *
 * @param string $type
 *        	Required argument. Specifies requested info.
 * @return String with requested info.
 */
function sampi_info($type) {
	switch ($type) {
		case 'title':
			return site_title;
			break;
		case 'description':
			return site_description;
			break;
		case 'version':
			return sampi_version;
			break;
		case 'window_title':
			return window_title;
			break;
		case 'admin_window_title':
			return admin_window_title;
			break;
		default:
			return 'Unknown request.';
			break;
	}
}

/**
 * Determines wether to show a single post, the blogstream or a static page.
 */
function sampi_mode_selector() {
	global $p, $db, $s;
	if ($s !== false) {
		$static = $db->getStaticPage($s);
		$static->show();
	} elseif ($p !== false) {
		$post = $db->getSinglePost($p);
		if ($post->getNr() == null) {
			$post = new SampiPost(404, 'Error 404, post not found!', null, null, 'The requested post could not be found.', null, null);
			$post->show(SampiPost::$SHOW_ERROR);
		} elseif (isset($_GET['edit'])) {
			$post->show(SampiPost::$SHOW_EDIT);
		} else {
			$post->show(SampiPost::$SHOW_SINGLE);
		}
	} else {
		$posts = $db->getPosts();
		foreach ($posts as $key => $val) {
			$val->show(SampiPost::$SHOW_MULTIPLE);
		}
	}
}

/**
 * Retrieves parameters from url.
 * Parameters include the requested page, post or sorting.
 */
function sampi_get_params() {
	global $page, $per_page, $sort, $p, $s;
	if (isset ( $_GET ["page"] )) {
		$page = $_GET ["page"];
		if ($page < 1) {
			$page = 1;
		}
	} else
		$page = 1;
	
	if (isset ( $_GET ["per_page"] )) {
		$per_page = $_GET ["per_page"];
		if ($per_page < 1) {
			$per_page = 10;
		}
	} else
		$per_page = 10;
	
	if (isset ( $_GET ["sort"] )) {
		if (strtolower ( $_GET ["sort"] ) == "asc") {
			$sort = "ASC";
		} elseif (strtolower ( $_GET ["sort"] ) == "desc") {
			$sort = "DESC";
		} else {
			$sort = "DESC";
		}
	} else
		$sort = "DESC";
	
	$p = (isset ( $_GET ["p"] )) ? $p = $_GET ["p"] : $p = false;
	$s = (isset ( $_GET ["s"] )) ? $s = $_GET ["s"] : $s = false;
}

/**
 * Displays selector for current page.
 */
function sampi_pages() {
	global $page, $per_page, $con;
	$all_posts = mysqli_query ( $con, "SELECT COUNT(*) FROM sampi_posts" );
	list ( $amount ) = mysqli_fetch_row ( $all_posts );
	@mysqli_free_result ( $all_posts );
	$pages = ceil ( $amount / $per_page );
	if ($pages > 1) {
		$i = 1;
		
		print ("<div class='pages'>") ;
		
		if ($page > 1) {
			print ("<a href='?page=1&amp;per_page=" . $per_page . "'>&lt;&lt;</a> ") ;
			print ("<a href='?page=" . ($page - 1) . "&amp;per_page=" . $per_page . "'>&lt;</a> ") ;
		}
		
		while ( $i <= $pages ) {
			if ($i == $page) {
				print ("<b>[" . $i . "]</b>") ;
			} else {
				print ("<a href='?page=" . $i . "&amp;per_page=" . $per_page . "'>" . $i . "</a>") ;
			}
			print (" ") ;
			$i ++;
		}
		
		if ($page < $pages) {
			print ("<a href='?page=" . ($page + 1) . "&amp;per_page=" . $per_page . "'>&gt;</a> ") ;
			print ("<a href='?page=" . $pages . "&amp;per_page=" . $per_page . "'>&gt;&gt;</a> ") ;
		}
		
		print ("</div>") ;
	}
}

/**
 * Displays a selector for the amount of posts to show on a single page.
 */
function sampi_per_page_selector() {
	global $per_page;
	
	$a = explode ( ',', per_page_values );
	array_push ( $a, $per_page );
	natsort ( $a );
	$a = array_unique ( $a );
	print ("<form id='per_page' method='get' action='?'><select name='per_page' onchange='javascript:submit();'>") ;
	foreach ( $a as $key => $value ) {
		if ($value == $per_page) {
			print ("<option value='" . $value . "' selected='selected'>" . $value . "</option>") ;
		} else {
			print ("<option value='" . $value . "'>" . $value . "</option>") ;
		}
	}
	print ("</select></form>") ;
}

/**
 * Includes global- and theme-sidebar.
 */
function sampi_sidebar() {
	(@include_once (ROOT . '/sampi/sidebar.php')) || sampi_error ( 200, 'sidebar.php', true );
	(@include_once (ROOT . '/sampi/theme/' . theme . '/sidebar.php')) || sampi_error ( 201, 'sidebar.php', false );
}

/**
 * Provides integration with Twitter cards, Open Graph, Google+.
 *
 * @link https://dev.twitter.com/cards
 * @link http://ogp.me/
 * @link https://plus.google.com/
 * @link http://schema.org/
 */
function sampi_integration_meta() {
	global $p, $db;
	$twitter = true;
	$opengraph = true;
	$google = true;
	if ($p) {
		$post = $db->getSinglePost($p);
		echo '
			<meta name="description" content="' . substr(strip_tags( $post->getContent()),0,250) . '" />
			<meta name="author" content="' . $post->getAuthor(SampiPost::$AUTHOR_FULL_NAME) . '" />
			<meta name="keywords" content="' . $post->getKeywords() . '" />
		';
		if ($twitter) {
			echo '
				<meta name="twitter:card" content="summary" />
				<meta name="twitter:site" content="" />
				<meta name="twitter:title" content="' . $post->getTitle() . '" />
				<meta name="twitter:description" content="' . substr(strip_tags( $post->getContent()),0,250) . '" />
				<meta name="twitter:creator" content="' . $post->getAuthor(SampiPost::$AUTHOR_TWITTER) . '" />
			';
		}
		if ($opengraph) {
			echo '
				<meta property="og:title" content="' . $post->getTitle() . '" />
				<meta property="og:type" content="article" />
				<meta property="article:published_time" content="' . $post->getISODate() . '" />
				<meta property="article:modified_time" content="' . $post->getISODateUpdated() . '" />
				<meta property="article:author" content="http://facebook.com/' . $post->getAuthor(SampiPost::$AUTHOR_FACEBOOK) . '" />
				<meta property="og:url" content=" http://' . $_SERVER['HTTP_HOST'] . REL_ROOT . '/?p=' . $post->getNr() .'" />
				<meta property="og:site_name" content="' . sampi_info('title') . '"	/>
				<meta property="og:description" content="'. substr(strip_tags( $post->getContent()),0,250).'" />
			';
		}
		if ($google) {
			echo '
				<link href="https://plus.google.com/' . $post->getAuthor(SampiPost::$AUTHOR_GOOGLE_PLUS) . '" rel="author" />
			';
		}
	} else {
		echo '
			<meta name="description" content="' . substr(strip_tags( sampi_info('description')),0,250) . '" />
			<meta name="author" content="' . $db->getAuthorData(global_user)['full_name'] . '" />
		';
		if ($opengraph) {
			echo '
				<meta property="og:title" content="' . sampi_info('title') . '" />
				<meta property="og:type" content="website" />
				<meta property="og:url" content=" http://' . $_SERVER['HTTP_HOST'] . REL_ROOT . '/' .'" />
				<meta property="og:site_name" content="' . sampi_info('title') . '"	/>
				<meta property="og:description" content="'. sampi_info('description') .'" />
			';
			if (file_exists(ROOT . '/sampi/resources/images/site_logo_l.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . REL_ROOT . '/sampi/resources/images/site_logo_l.png" />';
			} elseif (file_exists(ROOT . '/sampi/resources/images/site_logo_m.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . REL_ROOT . '/sampi/resources/images/site_logo_m.png" />';
			} elseif (file_exists(ROOT . '/sampi/resources/images/site_logo_s.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . REL_ROOT . '/sampi/resources/images/site_logo_s.png" />';
			} elseif (file_exists(ROOT . '/sampi/resources/images/logo_l.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . REL_ROOT . '/sampi/resources/images/logo_l.png" />';
			} elseif (file_exists(ROOT . '/sampi/resources/images/logo_m.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . REL_ROOT . '/sampi/resources/images/logo_m.png" />';
			} elseif (file_exists(ROOT . '/sampi/resources/images/logo_s.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . REL_ROOT . '/sampi/resources/images/logo_s.png" />';
			}
		}
		if ($twitter) {
			echo '
				<meta name="twitter:card" content="summary" />
				<meta name="twitter:site" content="" />
				<meta name="twitter:title" content="' . sampi_info('title') . '" />
				<meta name="twitter:description" content="' . substr(strip_tags( sampi_info('description')),0,250) . '" />
				<meta name="twitter:creator" content="' . $db->getAuthorData(global_user)['twitter_user'] . '" />
			';
		}
		if ($google) {
			echo '
				<link href="https://plus.google.com/' . $db->getAuthorData(global_user)['google_plus_user'] . '" rel="author" />
			';
		}
	}
}

/**
 * Contains all database related functions.
 *
 * @name SampiCMS Database Functions
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 *
 */
class SampiDbFunctions {
	
	/**
	 * Contains mysqli connection
	 *
	 * @var mysqli
	 */
	public $con;
	
	/**
	 * Sets up connection to the database.
	 *
	 * The values used for the connection originate from the settings file.
	 */
	function __construct() {
		require_once ROOT . '/sampi/settings.php';
		$this->con = new mysqli ( db_host, db_user, db_pass, db );
		if ($this->con->connect_errno) {
			echo $this->con->connect_error;
			echo '<br />';
			echo 'Error connecting to the database. Please try again later.';
			exit();
		}
	}
	
	/**
	 * Closes connection to the database
	 */
	function __destruct() {
		$this->con->kill($this->con->thread_id);
		$this->con->close ();
	}
	
	/**
	 * Gets the security key and returns it as a string
	 *
	 * @return string Security key
	 */
	function getSecurityKey() {
		$stmt = $this->con->prepare( "SELECT setting_value FROM sampi_settings WHERE setting_name='security_key'" );
		$stmt->execute();
		$stmt->bind_result( $key );
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
		return $key;
	}
	
	/**
	 * Authenticates the user
	 *
	 * @param string $username
	 *        	Username of the user.
	 *        	Used in combination with $password to authenticate the user.
	 * @param string $password
	 *        	Password of the user.
	 *        	Used in combination with $username to authenticate the user.
	 * @return array|boolean Array with user details on success, false on failure
	 */
	function checkAuth($username, $password) {
		list ( $id, $db_username, $db_password, $full_name, $rights, $twitter_user ) = $this->con->query ( "SELECT id, username, password, full_name, rights, twitter_user FROM sampi_users WHERE username='$username'" )->fetch_row ();

		if ($db_username == $username && crypt($password, $db_password) == $db_password) {
			return array (
					'id' => $id,
					'username' => $username,
					'password' => $password,
					'full_name' => $full_name,
					'rights' => $rights,
					'twitter_user' => $twitter_user
			);
		} else
			return false;
	}
	
	/**
	 * Fetches posts from the database
	 *
	 * Returns them as an array with objects.
	 *
	 * @return array Posts
	 */
	function getPosts() {
		global $page, $per_page, $sort;
		$posts = array ();
		$offset = $page * $per_page - $per_page;
		if ($sort == "ASC") {
			$stmt = $this->con->prepare("SELECT post_nr, date, date_updated, author, title, content, keywords FROM sampi_posts ORDER BY post_nr ASC LIMIT ?, ?");
		} else {
			$stmt = $this->con->prepare("SELECT post_nr, date, date_updated, author, title, content, keywords FROM sampi_posts ORDER BY post_nr DESC LIMIT ?, ?");
		}
		$stmt->bind_param('ii', $offset, $per_page);
		$stmt->execute();
		$stmt->bind_result($post_nr, $date, $dateUpdated, $author, $title, $content, $keywords);
		while ( $stmt->fetch() ) {
			$posts [$post_nr] = new SampiPost( $post_nr, $title, $author, $content, $date, $dateUpdated, $keywords );
		}
		$stmt->free_result();
		$stmt->close();
		return $posts;
	}
	
	/**
	 * Retrieves post and calls sampi_print_single_post() to display it.
	 * Selection based on url parameters.
	 */
	function getSinglePost($p) {
		$stmt = $this->con->prepare( "SELECT post_nr, date, date_updated, author, title, content, keywords FROM sampi_posts WHERE post_nr=?" );
		$stmt->bind_param('i', $p);
		$stmt->execute();
		$stmt->bind_result($post_nr, $date, $dateUpdated, $author, $title, $content, $keywords);
		$stmt->store_result();
		$stmt->fetch();
		$post = new SampiPost($post_nr, $title, $author, $content, $date, $dateUpdated, $keywords);
		$stmt->free_result();
		$stmt->close();
		return $post;
	}
	
	function getStaticPage($s) {
		$stmt = $this->con->prepare( "SELECT page_nr, title, content FROM sampi_statics WHERE page_nr=?" );
		$stmt->bind_param('i', $s);
		$stmt->execute();
		$stmt->bind_result($page_nr, $title, $content);
		$stmt->fetch();
		$static = new SampiStatic($page_nr, $title, $content);
		$stmt->free_result();
		$stmt->close();
		return $static;
	}
	
	/**
	 * Fetches comments from the database
	 *
	 * Returns them as an array with objects.
	 *
	 * @return array Comments
	 */
	function getComments($p) {
		$comments = array ();
		$stmt = $this->con->prepare("SELECT comment_nr, post_nr, commenter, comment, date FROM sampi_comments WHERE post_nr = ? ORDER BY comment_nr");
		$stmt->bind_param('i', $p);
		$stmt->execute();
		$stmt->bind_result($comment_nr, $post_nr, $commenter, $comment, $date);
		$i = 1;
		while ( $stmt->fetch() ) {
			$comments [$comment_nr] = new SampiComment( $comment_nr, $post_nr, $commenter, $comment, $date, $i );
			$i++;
		}
		$stmt->free_result();
		$stmt->close();
		return $comments;
	}
	
	/**
	 * Fetches settings from the database.
	 *
	 * Returns them as an array.
	 *
	 * @return array Settings
	 */
	function returnSettings() {
		$settings = array ();
		$exclude = array (
				'security_key'
		);
		$stmt = $this->con->prepare ( "SELECT setting_name, setting_value FROM sampi_settings" );
		$stmt->execute();
		$stmt->bind_result($setting, $value);
		while ( $stmt->fetch() ) {
			if (! in_array ( $setting, $exclude )) {
				$settings [$setting] = $value;
			}
		}
		$stmt->free_result();
		$stmt->close();
		return $settings;
	}
	
	/**
	 * Adds a new post to the database
	 *
	 * @param string $title
	 *        	Title of the post
	 * @param string $content
	 *        	Content of the post
	 * @param string $username
	 *        	Username of the poster.
	 *        	Used in combination with $password to authenticate the poster.
	 * @param string $password
	 *        	Password of the poster.
	 *        	Used in combination with $username to authenticate the poster.
	 * @return boolean True on success, false on failure
	 */
	function newPost($title, $content, $keywords) {
		if ($title !== "" && $content !== "") {
			if ($_SESSION['logged_in']) {
				$author = $_SESSION['username'];
				$date = date ( 'Y-m-d H:i:s' );
				$dateUpdated = date ( 'Y-m-d H:i:s' );
				$stmt = $this->con->prepare( "INSERT INTO sampi_posts (date, date_updated, author, title, content, keywords) VALUES (?, ?, ?, ?, ?, ?)" );
				$stmt->bind_param('ssssss', $date, $dateUpdated, $author, $title, $content, $keywords);
				$stmt->execute();
				if ($stmt->affected_rows > 0) {
					$stmt->free_result();
					$stmt->close();
					return true;
				} else {
					$stmt->free_result();
					$stmt->close();
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	function editPost($post_nr, $title, $content, $keywords) {
		if ($post_nr !== "" && $title !== "" && $content !== "") {
			if ($_SESSION['logged_in']) {
				$date = date ( 'Y-m-d H:i:s' );
				if ($keywords) {
					$stmt = $this->con->prepare( "UPDATE sampi_posts SET date_updated=?,title=?,content=?,keywords=? WHERE post_nr=?" );
					$stmt->bind_param('ssssi', $date, $title, $content, $keywords, $post_nr);
				} else {
					$stmt = $this->con->prepare( "UPDATE sampi_posts SET date_updated=?,title=?,content=? WHERE post_nr=?" );
					$stmt->bind_param('sssi', $date, $title, $content, $post_nr);
				}
				$stmt->execute();
				if ($stmt->affected_rows > 0) {
					$stmt->free_result();
					$stmt->close();
					return true;
				} else {
					$stmt->free_result();
					$stmt->close();
					return false;
				}
			}
		}
	}
	
	function newComment($post_nr, $author, $content) {
		$date = date ( date_format );
		$stmt = $this->con->prepare("INSERT INTO sampi_comments (post_nr, commenter, comment, date) VALUES (?, ?, ?, ?)");
		$stmt->bind_param('isss', $post_nr, $author, $content, $date);
		$stmt->execute();
		if ($stmt->affected_rows > 0) {
			print 'Comment posted!';
		} else {
			print 'Error posting comment!';
		}
		$stmt->free_result();
		$stmt->close();
	}
	
	function newAuthor($username, $password, $full_name, $rights, $twitter_user, $facebook_user, $google_plus_user) {
		$success = false;
		
		$salt = sprintf ( "$2a$%02d$", 10 ) . strtr ( base64_encode ( mcrypt_create_iv ( 16, MCRYPT_DEV_URANDOM ) ), '+', '.' ); // Create password salt
				
		$hash = crypt ( $password, $salt ); // Encrypt password
		
		$stmt = $this->con->prepare( "INSERT INTO sampi_users (username, password, full_name, twitter_user, facebook_user, google_plus_user) VALUES (?,?,?,?,?,?)" );
		$stmt->bind_param('ssssss', $username, $hash, $full_name, $twitter_user, $facebook_user, $google_plus_user);
		$stmt->execute();
		if ($stmt->affected_rows > 0) {
			$success = true;
		}
		$stmt->free_result();
		$stmt->close();
		if ($success) {
			return true;
		} else {
			return false;
		}
	}
	
	function getAuthorData($username) {
		$author = array();
		$stmt = $this->con->prepare( "SELECT full_name, username, twitter_user, facebook_user, google_plus_user FROM sampi_users WHERE username=?" );
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($author['full_name'], $author['username'], $author['twitter_username'], $author['facebook_username'], $author['google_plus_user']);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
		return $author;
	}
	
	function getAuthors() {
		$authors = array();
		$stmt = $this->con->prepare( "SELECT id, full_name, username, twitter_user, facebook_user, google_plus_user FROM sampi_users" );
		$stmt->execute();
		$stmt->bind_result($id, $full_name, $username, $twitter_user, $facebook_user, $google_plus_user);
		while ($stmt->fetch()) {
			array_push($authors, new SampiUser($id, $username, $full_name, $twitter_user, $facebook_user, $google_plus_user));
		}
		$stmt->free_result();
		$stmt->close();
		return $authors;
	}
	
	function getCommentsCount($post) {
		$stmt = $this->con->prepare( "SELECT COUNT(*) FROM sampi_comments WHERE post_nr = ?" );
		$stmt->bind_param('i', $post);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
		return $count;
	}
	
	/**
	 * Retrieves settings from MySQL database.
	 * Has custom handles for certain settings.
	 */
	function getSettings() {
		$query = 'SELECT setting_name,setting_value FROM sampi_settings';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($setting_name, $setting_value);
		while ( $stmt->fetch()) {
			if (($setting_name == 'window_title') || ($setting_name == 'admin_window_title')) { // Handle for window_title, admin_window_title splits with '%' delimiter
				$s = $setting_value;
				$f = '%';
				$h = 0;
				$i = 0;
				$j = 0;
				$k = 0;
				$l = 0;
				$new_setting_value = '';
				while ( strpos ( $s, $f, $i ) !== false ) {
					$pos = strpos ( $s, $f, $i );
					$i = $pos + 1;
					if ($j == 0) {
						$k = $pos;
						$j = 1;
						if ($h == 0) {
							$var = substr ( $setting_value, 0, $k );
						} else {
							$var = substr ( $setting_value, $l + 1, $k - $l - 1 );
						}
						$new_setting_value = $new_setting_value . $var;
					} else {
						$l = $pos;
						$var = substr ( $setting_value, $k + 1, $l - $k - 1 );
						$j = 0;
						$new_setting_value = $new_setting_value . constant ( $var );
					}
					$h ++;
				}
				if ($h == 0) {
					$var = substr ( $setting_value, $l, strlen ( $setting_value ) - $l );
				} else {
					$var = substr ( $setting_value, $l + 1, strlen ( $setting_value ) - $l );
				}
				$new_setting_value = $new_setting_value . $var;
				define ( $setting_name, $new_setting_value );
			} else { // Normal handle
				define ( $setting_name, $setting_value );
			}
		}
		$stmt->free_result();
		$stmt->close();
		unset ( $settings, $setting_name, $setting_value );
	}
	
	function deletePost($post_nr) {
		if ($_SESSION ['logged_in']) {
			$stmt = $this->con->prepare ( "DELETE FROM sampi_posts WHERE post_nr = ?" );
			$stmt->bind_param ( 'i', $post_nr );
			$stmt->execute ();
			if ($stmt->affected_rows > 0) {
				$success = true;
			}
			$stmt->free_result ();
			$stmt->close ();
			if ($success) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
}

/**
 * Provides basic functionality for all Sampi objects.
 * Sampi objects include posts, comments and widgets.
 *
 * @author Sven Dubbeld
 * @package SampiCMS
 */
class SampiObject {
	private $author;
	private $content;
	/**
	 * Gets the author of the object.
	 *
	 * @return string Author
	 */
	public function getAuthor() {
		return self::author;
	}
	/**
	 * Gets the content the object.
	 *
	 * @return string Content
	 */
	public function getContent() {
		return $this->content;
	}
	function __construct($author, $content) {
		$this->author = $author;
		$this->content = $content;
	}
}

/**
 * Provides all functionality for displaying posts.
 *
 * @author Sven Dubbeld
 * @package SampiCMS
 */
class SampiPost {
	private $date;
	private $dateUpdated;
	private $title;
	private $content;
	private $nr;
	private $comments;
	private $commentsCount;
	private $author;
	private $keywords;
	
	/**
	 * @var string
	 */
	public static $AUTHOR_FULL_NAME = 'full_name';
	/**
	 * @var string
	 */
	public static $AUTHOR_USERNAME = 'username';
	/**
	 * @var string
	 */
	public static $AUTHOR_TWITTER = 'twitter_username';
	/**
	 * @var string
	 */
	public static $AUTHOR_FACEBOOK = 'facebook_username';
	/**
	 * @var string
	 */
	public static $AUTHOR_GOOGLE_PLUS = 'google_plus_user';
	/**
	 * @var int
	 */
	public static $SHOW_SINGLE = 0x0;
	/**
	 * @var int
	 */
	public static $SHOW_MULTIPLE = 0x1;
	/**
	 * @var int
	 */
	public static $SHOW_ERROR = 0x2;
	/**
	 * @var int
	 */
	public static $SHOW_EDIT = 0x3;
	
	function __construct($post_nr, $title, $author, $content, $date, $dateUpdated, $keywords) {
		$db = new SampiDbFunctions();
		$this->nr = $post_nr;
		$this->title = $title;
		$this->author = $author;
		$this->content = $content;
		$this->date = $date;
		$this->dateUpdated = $dateUpdated;
		$this->keywords = $keywords;
		
		$this->author = $db->getAuthorData($this->author);
		$this->commentsCount = $db->getCommentsCount($this->nr);
		$this->comments = $db->getComments($this->nr);
		
		unset($db);
	}
	
	/**
	 * Gets the title of the post.
	 *
	 * @return string Title
	 */
	public function getTitle() {
		return $this->title;
	}
	/**
	 * Gets the date and converts it to global date-time format.
	 *
	 * @return string Date
	 */
	public function getDate() {
		return date ( date_format, strtotime ( $this->date ) );
	}
	public function getISODate() {
		return date ( DateTime::ISO8601, strtotime ( $this->date ) );
	}
	public function getDateUpdated() {
		return date ( date_format, strtotime ( $this->dateUpdated ) );
	}
	public function getISODateUpdated() {
		return date ( DateTime::ISO8601, strtotime ( $this->dateUpdated ) );
	}
	/**
	 * Gets the number of the post.
	 *
	 * @return integer Number
	 */
	public function getNr() {
		return $this->nr;
	}
	/**
	 * Gets the author of the post.
	 *
	 * @param string $type Optional argument. Specifies requested info.
	 * <p>
	 * Possible values:<br />
	 * SampiPost::AUTHOR_FULL_NAME - Full name<br />
	 * SampiPost::AUTHOR_USERNAME - Username<br />
	 * SampiPost::AUTHOR_TWITTER - Twitter username without @<br />
	 * SampiPost::AUTHOR_FACEBOOK - Facebook username<br />
	 * SampiPost::AUTHOR_GOOGLE_PLUS - Google+ account number<br />
	 * </p>
	 *
	 * @return string Author
	 *
	 * @see SampiObject::getAuthor()
	 */
	public function getAuthor($type = self::AUTHOR_FULL_NAME) {
		return $this->author[$type];
	}
	/**
	 * Gets the number of comments on the current post.
	 *
	 * @return Number of comments
	 */
	public function getCommentsCount() {
		return $this->commentsCount;
	}
	public function show($mode) {
		switch ($mode) {
			case self::$SHOW_SINGLE :
				include ROOT . '/sampi/theme/' . theme . '/print_single_post.php';
				break;
			case self::$SHOW_MULTIPLE :
				include ROOT . '/sampi/theme/' . theme . '/print_post.php';
				break;
			case self::$SHOW_ERROR :
				include ROOT . '/sampi/theme/' . theme . '/print_error_post.php';
				break;
			case self::$SHOW_EDIT :
				include ROOT . '/sampi/theme/' . theme . '/edit_single_post.php';
				break;
		}
	}
	public function getContent() {
		return $this->content;
	}
	public function showCommentsForm() {
		include ROOT . '/sampi/theme/' . theme . '/comment_form.php';
	}
	public function getComments() {
		foreach ($this->comments as $key => $val) {
			$val->show();
		}
	}
	public function getKeywords() {
		return $this->keywords;
	}
}

/**
 * Provides all functionality for displaying comments.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
class SampiComment {
	private $comment_nr;
	private $post_nr;
	private $commenter;
	private $comment;
	private $date;
	private $order_nr;
	
	function __construct( $comment_nr, $post_nr, $commenter, $comment, $date, $order_nr ) {
		$this->comment_nr = $comment_nr;
		$this->post_nr = $post_nr;
		$this->commenter = $commenter;
		$this->comment = $comment;
		$this->date = $date;
		$this->order_nr = $order_nr;
	}
	
	public function getNr() {
		return $this->order_nr;
	}
	
	public function getCommentNr() {
		return $this->comment_nr;
	}
	
	public function getPostNr() {
		return $this->post_nr;
	}
	
	public function getAuthor() {
		return $this->commenter;
	}
	
	public function getContent() {
		return $this->comment;
	}
	
	public function getDate() {
		return date ( date_format, strtotime ( $this->date ) );
	}
	public function getISODate() {
		return date ( DateTime::ISO8601, strtotime ( $this->date ) );
	}
	
	public function show() {
		include ROOT . '/sampi/theme/' . theme . '/print_comment.php';
	}
}

/**
 * Provides all functionality for users.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
class SampiUser {
	private $id;
	private $username;
	private $full_name;
	private $twitter_user;
	private $facebook_user;
	private $google_plus_user;
	function __construct( $id, $username, $full_name, $twitter_user = NULL, $facebook_user = NULL, $google_plus_user = NULL ) {
		$this->id = $id;
		$this->username = $username;
		$this->full_name = $full_name;
		$this->twitter_user = $twitter_user;
		$this->facebook_user = $facebook_user;
		$this->google_plus_user= $google_plus_user;
	}
	public function getId() {
		return $this->id;
	}
	public function getUsername() {
		return $this->username;
	}
	public function getName() {
		return $this->full_name;
	}
	public function getTwitter() {
		return $this->twitter_user;
	}
	public function getFacebook() {
		return $this->facebook_user;
	}
	public function getGooglePlus() {
		return $this->google_plus_user;
	}
}
/**
 * Provides all functionality for displaying static pages.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
class SampiStatic {
	private $nr;
	private $title;
	private $content;
	function __construct( $page_nr, $title, $content ) {
		$this->nr = $page_nr;
		$this->title = $title;
		$this->content = $content;
	}
	public function show() {
		include ROOT . '/sampi/theme/' . theme . '/print_static_page.php';
	}
	public function getNr() {
		return $this->nr;
	}
	public function getTitle() {
		return $this->title;
	}
	public function getContent() {
		return $this->content;
	}
}

/**
 * Provides authentication for the administration interface.
 * Uses a connection with the MySQL database to verify the users identity. If the user is not logged in, a loginscreen will show up.
 */
function sampi_admin_auth() {
	global $current_user, $db;
	session_start();
	if (isset ( $_GET ['logout'] )) {
		$_SESSION = array();
		session_destroy();
		header ( 'Location: ' . ADMIN_REL_ROOT );
	} elseif (! isset($_SESSION['logged_in']) || ! $_SESSION['logged_in']) {
		if (isset ($_POST['login']['username']) && isset($_POST['login']['password'])) {
			$username = $_POST['login']['username'];
			$password = $_POST['login']['password'];
			if ($db->checkAuth($username, $password)) {
				session_regenerate_id();
				$session = session_get_cookie_params();
				setcookie(session_name(), session_id(), $session['lifetime'], $session['path'], $session['domain'], false, true );
				$_SESSION['logged_in'] = 1;
				$_SESSION['username'] = $username;
			} else {
				$_SESSION = array();
				session_destroy();
				header ( 'Location: ' . ADMIN_REL_ROOT );
			}
		} else {
			$_SESSION = array();
			session_destroy();
			require_once ADMIN_ROOT . '/login.php';
			die();
		}
	} else {
		session_regenerate_id();
		$session = session_get_cookie_params();
		setcookie(session_name(), session_id(), $session['lifetime'], $session['path'], $session['domain'], false, true );
	}
}

?>