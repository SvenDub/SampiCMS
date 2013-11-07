<?php
/**
 * SampiCMS functions file.
 *
 * This file contains almost all functions that are required to run SampiCMS properly.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS;
use SampiCMS;
/**
 * Handles errors.
 *
 * Does this by logging them and displaying an error-page if it's a fatal error.
 *
 * @param int $code
 *        	Required argument. Specifies error code.
 * @param string $arg
 *        	Optional argument. Specifies detailed error message.
 * @param boolean $fatal
 *        	Optional argument. 'True' for fatal error.
 */
function error($code, $arg = '', $fatal = false) {
	$log = fopen ( SampiCMS\ROOT . '/sampi/error.log', 'a' );
	
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
		print ('<script type="text/javascript">function go() {window.location.href = "' . SampiCMS\REL_ROOT . '?error=' . $code . '";} setTimeout("go()",0);</script>') ;
		die ();
	} else {
		fwrite ( $log, '[' . date ( 'Y-m-d H:i:s' ) . '] ' . $code . ': ' . $err . "\n" );
		fclose ( $log );
	}
}
/**
 * First function called upon start.
 *
 * Initializes connection with database or displays error page if necessary.
 */
function init() {
	global $db;
	
	if (SampiCMS\set_up !== true) {
		\header('Location: '.SampiCMS\REL_ROOT.'/sampi/admin/setup.php');
	}
	
	if (isset ( $_GET ['error'] )) {
		/** Shows error page. */
		include_once (SampiCMS\ROOT . '/sampi/error.php');
		die ();
	}
	
	$db = new DbFunctions();
	get_params ();
	$db->getSettings();
	header ();
	theme ();
	footer ();
}

/**
 * Includes header.
 *
 * Opens &lt;html&gt;-tag, adds &lt;head&gt;-part and open &lt;body&gt;-tag.
 */
function header() {
	include_once (SampiCMS\ROOT . '/sampi/header.php');
}

/**
 * Includes footer.
 *
 * Closes &lt;body&gt; and &lt;html&gt;-tags.
 */
function footer() {
	include_once (SampiCMS\ROOT . '/sampi/footer.php');
}

/**
 * Includes theme main file.
 */
function theme() {
	include_once (SampiCMS\ROOT . '/sampi/theme/' . theme . '/index.php');
}

/**
 * Includes theme header.
 *
 * The theme header is the visual top of the page.
 */
function theme_header() {
	include_once (SampiCMS\ROOT . '/sampi/theme/' . theme . '/header.php');
}

/**
 * Includes theme footer.
 *
 * The theme footer is the visual bottom of the page.
 */
function theme_footer() {
	include_once (SampiCMS\ROOT . '/sampi/theme/' . theme . '/footer.php');
}

/**
 * Converts constant with setting for normal usage.
 *
 * @param string $type
 *        	Required argument. Specifies requested info.
 * @return String with requested info.
 */
function info($type) {
	switch ($type) {
		case 'title':
			return site_title;
			break;
		case 'description':
			return site_description;
			break;
		case 'version':
			return version;
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
function mode_selector() {
	global $p, $db, $s;
	
	if ($s !== false) { // Static page?
		$static = $db->getStaticPage($s);
		$static->show();
	} elseif ($p !== false) { // Single post?
		$post = $db->getSinglePost($p);
		if ($post->getNr() == null) {
			$post = new Post(404, 'Error 404, post not found!', null, 'The requested post could not be found.', null, null, null);
			$post->show(Post::SHOW_ERROR);
		} elseif (isset($_GET['edit'])) {
			$post->show(Post::SHOW_EDIT);
		} else {
			$post->show(Post::SHOW_SINGLE);
		}
	} else { // Blogstream
		$posts = $db->getPosts();
		if (count($posts) > 0) {
			foreach ($posts as $key => $val) {
				$val->show(Post::SHOW_MULTIPLE);
			}
		} else {
			$post = new Post(0, 'No posts yet!', null, 'Create your first post in the Admin panel.', null, null, null);
			$post->show(Post::SHOW_ERROR);
		}
	}
}

/**
 * Retrieves parameters from url.
 *
 * Parameters include the requested page, post or sorting.
 */
function get_params() {
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
function pages() {
	global $page, $per_page, $db;
	
	$posts = $db->getAllPosts();
	
	$amount = count($posts);
	$pages = ceil ( $amount / $per_page );
	if ($pages > 1) : // The posts are split up across multiple pages, so show the selector
		?>
<div class="posts-limiter-container">
	<div class="posts-limiter">
		<?php if ($page > 1) : ?>
		<a href="?page=<?php echo $page-1 . '&per_page=' . $per_page; ?>"><img src="<?php echo SampiCMS\REL_ROOT . '/sampi/theme/' . theme . '/images/nav-arrow-prev.png'; ?>" class="nav-arrow" align="left" width="48px"
			height="48px" /></a>
		<?php else : ?>
		<img src="" class="nav-arrow" align="left" width="48px"	height="48px" style="visibility: hidden;" />
		<?php endif;?>
		<form name="posts_limiter" action="?" method="get">
			Go to page: <select name="page" onchange="javascript:submit();">
		<?php
		for ($i = 1; $i <= $amount; $i++ ) {
			if ($i == $page) {
				echo '<option value="' . $i . '" selected>' . $i . '</option>';
			} else {
				echo '<option value="' . $i . '">' . $i . '</option>';
			}
		}
		?>
		</select>
		<?php
		if ($per_page) {
			echo '<input type="hidden" name="per_page" value="' . $per_page . '" />';
		}
		?>
		</form>
		<?php per_page_selector(); ?>
		<?php if ($page < $pages) : ?>
		<a href="?page=<?php echo $page+1 . '&per_page=' . $per_page; ?>"><img src="<?php echo SampiCMS\REL_ROOT . '/sampi/theme/' . theme . '/images/nav-arrow-next.png'; ?>" class="nav-arrow" align="right" width="48px"
			height="48px" /></a>
		<?php else: ?>
		<img src="" class="nav-arrow" align="right" width="48px" height="48px" style="visibility: hidden;" />
		<?php endif; ?>
	</div>
</div>
<?php endif;
}

/**
 * Displays a selector for the amount of posts to show on a single page.
 */
function per_page_selector() {
	global $per_page;
	
	$values = explode ( ',', per_page_values ); // Get the values in an array
	array_push ( $values, $per_page ); // Add the current value to the array
	natsort ( $values ); // Sort the values
	$values = array_unique ( $values ); // Remove any duplicate values
	?>
<form name="per_page" method="get" action="?">
	Posts per page: <select name="per_page" onchange="javascript:submit();">
	<?php
	foreach ( $values as $key => $value ) {
		if ($value == $per_page) {
			echo '<option value="' . $value . '" selected="selected">' . $value . '</option>';
		} else {
			echo '<option value="' . $value . '">' . $value . '</option>';
		}
	}
	?>
	</select>
</form>
<?php
}

/**
 * Includes global and theme sidebar.
 */
function sidebar() {
	/**
	 * Include global sidebar.
	 */
	include_once (SampiCMS\ROOT . '/sampi/sidebar.php');
	/**
	 * Include theme sidebar.
	 */
	include_once (SampiCMS\ROOT . '/sampi/theme/' . theme . '/sidebar.php');
}

/**
 * Provides integration with Twitter cards, Open Graph, Google+.
 *
 * @link https://dev.twitter.com/cards
 * @link http://ogp.me/
 * @link https://plus.google.com/
 * @link http://schema.org/
 */
function integration_meta() {
	global $p, $db;
	
	$twitter = true;
	$opengraph = true;
	$google = true;
	
	$user = $db->getGlobalUserData();
	
	if ($p) { // Single post
		$post = $db->getSinglePost($p);
		// Common tags
		echo '
			<meta name="description" content="' . substr(strip_tags( $post->getContent()),0,250) . '" />
			<meta name="author" content="' . $post->getAuthor(Post::AUTHOR_FULL_NAME) . '" />
			<meta name="keywords" content="' . $post->getKeywords() . '" />
		';
		if ($twitter) { // Twitter specific tags
			echo '
				<meta name="twitter:card" content="summary" />
				<meta name="twitter:site" content="" />
				<meta name="twitter:title" content="' . $post->getTitle() . '" />
				<meta name="twitter:description" content="' . substr(strip_tags( $post->getContent()),0,250) . '" />
				<meta name="twitter:creator" content="' . $post->getAuthor(Post::AUTHOR_TWITTER) . '" />
			';
		}
		if ($opengraph) { // Open Graph specific tags
			echo '
				<meta property="og:title" content="' . $post->getTitle() . '" />
				<meta property="og:type" content="article" />
				<meta property="article:published_time" content="' . $post->getISODate() . '" />
				<meta property="article:modified_time" content="' . $post->getISODateUpdated() . '" />
				<meta property="article:author" content="http://facebook.com/' . $post->getAuthor(Post::AUTHOR_FACEBOOK) . '" />
				<meta property="og:url" content=" http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/?p=' . $post->getNr() .'" />
				<meta property="og:site_name" content="' . info('title') . '"	/>
				<meta property="og:description" content="'. substr(strip_tags( $post->getContent()),0,250).'" />
			';
		}
		if ($google) { // Google specific tags
			echo '
				<link href="https://plus.google.com/' . $post->getAuthor(Post::AUTHOR_GOOGLE_PLUS) . '" rel="author" />
			';
		}
	} else { // Blogstream
		// Common tags
		echo '
			<meta name="description" content="' . substr(strip_tags( info('description')),0,250) . '" />
			<meta name="author" content="' . $user->getName() . '" />
		';
		if ($opengraph) { // Open Graph specific tags
			echo '
				<meta property="og:title" content="' . info('title') . '" />
				<meta property="og:type" content="website" />
				<meta property="og:url" content=" http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/' .'" />
				<meta property="og:site_name" content="' . info('title') . '"	/>
				<meta property="og:description" content="'. info('description') .'" />
 				<meta property="og:author" content="' . $user->getFacebook() . '" />
			';
			if (file_exists(SampiCMS\ROOT . '/sampi/resources/images/site_logo_l.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/sampi/resources/images/site_logo_l.png" />';
			} elseif (file_exists(SampiCMS\ROOT . '/sampi/resources/images/site_logo_m.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/sampi/resources/images/site_logo_m.png" />';
			} elseif (file_exists(SampiCMS\ROOT . '/sampi/resources/images/site_logo_s.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/sampi/resources/images/site_logo_s.png" />';
			} elseif (file_exists(SampiCMS\ROOT . '/sampi/resources/images/logo_l.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/sampi/resources/images/logo_l.png" />';
			} elseif (file_exists(SampiCMS\ROOT . '/sampi/resources/images/logo_m.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/sampi/resources/images/logo_m.png" />';
			} elseif (file_exists(SampiCMS\ROOT . '/sampi/resources/images/logo_s.png')) {
				echo '<meta property="og:image" content="http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/sampi/resources/images/logo_s.png" />';
			}
		}
		if ($twitter) { // Twitter specific tags
			echo '
				<meta name="twitter:card" content="summary" />
				<meta name="twitter:site" content="" />
				<meta name="twitter:title" content="' . info('title') . '" />
				<meta name="twitter:description" content="' . substr(strip_tags( info('description')),0,250) . '" />
				<meta name="twitter:creator" content="' . $user->getTwitter() . '" />
			';
		}
		if ($google) { // Google specific tags
			echo '
				<link href="https://plus.google.com/' . $user->getGooglePlus() . '" rel="author" />
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
class DbFunctions {
	
	/**
	 * Contains mysqli connection data.
	 *
	 * @var \mysqli
	 */
	public $con;
	
	/**
	 * Create a new connection to the database.
	 *
	 * The values used for the connection originate from the settings file.
	 */
	function __construct() {
		require_once SampiCMS\ROOT . '/sampi/settings.php';
		$this->con = new \mysqli ( SampiCMS\db_host, SampiCMS\db_user, SampiCMS\db_pass, SampiCMS\db );
		if ($this->con->connect_errno) {
			echo $this->con->connect_error;
			echo '<br />';
			echo 'Error connecting to the database. Please try again later.';
			exit();
		}
	}
	
	/**
	 * Close connection to the database
	 */
	function __destruct() {
		$this->con->kill($this->con->thread_id);
		$this->con->close ();
	}
	
	/**
	 * Get the security key and return it as a string
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
	 * Authenticate the user
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
	 * Fetch posts from the database
	 *
	 * Return them as an array with \SampiCMS\Post.
	 *
	 * @return array
	 * @see \SampiCMS\Post
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
			$posts [$post_nr] = new Post( $post_nr, $title, $author, $content, $date, $dateUpdated, $keywords );
		}
		$stmt->free_result();
		$stmt->close();
		return $posts;
	}
	
	/**
	 * Fetches posts from the database
	 *
	 * Return them as an array with \SampiCMS\Post.
	 *
	 * @return array
	 * @see \SampiCMS\Post
	 */
	function getAllPosts() {
		$posts = array ();
		$stmt = $this->con->prepare("SELECT post_nr, date, date_updated, author, title, content, keywords FROM sampi_posts ORDER BY post_nr ASC");
		$stmt->execute();
		$stmt->bind_result($post_nr, $date, $dateUpdated, $author, $title, $content, $keywords);
		while ( $stmt->fetch() ) {
			$posts [$post_nr] = new Post( $post_nr, $title, $author, $content, $date, $dateUpdated, $keywords );
		}
		$stmt->free_result();
		$stmt->close();
		return $posts;
	}
	
	/**
	 * Fetches static pages from the database
	 *
	 * Return them as an array with \SampiCMS\Post.
	 *
	 * @return array
	 * @see \SampiCMS\StaticPage
	 */
	function getAllStatics() {
		$stmt = $this->con->prepare( "SELECT page_nr, title, content FROM sampi_statics ORDER BY page_nr ASC" );
		$stmt->execute();
		$stmt->bind_result($page_nr, $title, $content);
		while ($stmt->fetch()) {
			$statics [$page_nr] = new StaticPage($page_nr, $title, $content);
		}
		$stmt->free_result();
		$stmt->close();
		return $statics;
	}
	
	/**
	 * Retrieve requested post from the database.
	 *
	 * @param integer $p The id of the requested post.
	 * @return \SampiCMS\Post
	 * @see \SampiCMS\Post
	 */
	function getSinglePost($p) {
		$stmt = $this->con->prepare( "SELECT post_nr, date, date_updated, author, title, content, keywords FROM sampi_posts WHERE post_nr=?" );
		$stmt->bind_param('i', $p);
		$stmt->execute();
		$stmt->bind_result($post_nr, $date, $dateUpdated, $author, $title, $content, $keywords);
		$stmt->store_result();
		$stmt->fetch();
		$post = new Post($post_nr, $title, $author, $content, $date, $dateUpdated, $keywords);
		$stmt->free_result();
		$stmt->close();
		return $post;
	}
	
	/**
	 * Retrieve requested page from the database.
	 *
	 * @param integer $s The id of the requested page.
	 * @return \SampiCMS\StaticPage
	 * @see \SampiCMS\StaticPage
	 */
	function getStaticPage($s) {
		$stmt = $this->con->prepare( "SELECT page_nr, title, content FROM sampi_statics WHERE page_nr=?" );
		$stmt->bind_param('i', $s);
		$stmt->execute();
		$stmt->bind_result($page_nr, $title, $content);
		$stmt->fetch();
		$static = new StaticPage($page_nr, $title, $content);
		$stmt->free_result();
		$stmt->close();
		return $static;
	}
	
	/**
	 * Fetch comments from the database
	 *
	 * Return them as an array with \SampiCMS\Comment 's.
	 *
	 * @return array
	 * @see \SampiCMS\Comment
	 */
	function getComments($p) {
		$comments = array ();
		$stmt = $this->con->prepare("SELECT comment_nr, post_nr, commenter, comment, date FROM sampi_comments WHERE post_nr = ? ORDER BY comment_nr");
		$stmt->bind_param('i', $p);
		$stmt->execute();
		$stmt->bind_result($comment_nr, $post_nr, $commenter, $comment, $date);
		$i = 1;
		while ( $stmt->fetch() ) {
			$comments [$comment_nr] = new Comment( $comment_nr, $post_nr, $commenter, $comment, $date, $i );
			$i++;
		}
		$stmt->free_result();
		$stmt->close();
		return $comments;
	}
	
	/**
	 * Fetche settings from the database.
	 *
	 * Return them as an array.
	 *
	 * @return array Settings
	 */
	function returnSettings() {
		$settings = array ();
		$exclude = array (
				'security_key'
		);
		$stmt = $this->con->prepare ( "SELECT setting_name, setting_value FROM sampi_settings" );
		$stmt->execute ();
		$stmt->bind_result ( $setting, $value );
		while ( $stmt->fetch () ) {
			if (! in_array ( $setting, $exclude )) {
				$settings [$setting] = $value;
			}
		}
		$stmt->free_result ();
		$stmt->close();
		return $settings;
	}
	
	/**
	 * Add a new post to the database
	 *
	 * @param string $title
	 *        	Title of the post
	 * @param string $content
	 *        	Content of the post
	 * @param string $keywords
	 * 			Keywords of the posts
	 * @return boolean True on success, false on failure
	 *
	 * @see \SampiCMS\Post
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
	
	/**
	 * Add a new static to the database
	 *
	 * @param string $title
	 *        	Title of the static
	 * @param string $content
	 *        	Content of the static
	 * @return boolean True on success, false on failure
	 *
	 * @see \SampiCMS\StaticPage
	 */
	function newStatic($title, $content) {
		if ($title !== "" && $content !== "") {
			if ($_SESSION['logged_in']) {
				$stmt = $this->con->prepare( "INSERT INTO sampi_statics (title, content) VALUES (?, ?)" );
				$stmt->bind_param('ss', $title, $content);
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
	
	/**
	 * Edit a post in the database.
	 *
	 * @param int $post_nr The id of the post.
	 * @param string $title The title to set.
	 * @param string $content The content to set.
	 * @param string $keywords The keywords to set.
	 * @return boolean True on success, false on failure
	 *
	 * @see \SampiCMS\Post
	 */
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
				}{
					$stmt->free_result();
					$stmt->close();
				false;
				}
			}
		}
	}
	
	/**
	 * Add a new comment to the database.
	 *
	 * @param int $post_nr The id of the post.
	 * @param string $author The author of the comment.
	 * @param string $content The content of the comment.
	 *
	 * @see \SampiCMS\Post
	 * @see \SampiCMS\Comment
	 */
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
	
	/**
	 * Add a new author to the database.
	 *
	 * @param string $username Username
	 * @param string $password Password
	 * @param string $full_name Full name
	 * @param string $rights Rights
	 * @param string $twitter_user Twitter username
	 * @param string $facebook_user Facebook username
	 * @param string $google_plus_user Google+ username
	 * @return boolean True on success, false on failure
	 */
	function newAuthor($username, $password, $full_name, $rights, $twitter_user = null, $facebook_user = null, $google_plus_user = null) {
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
	
	/**
	 * Retrieve all data about an user.
	 *
	 * Return it as an array with strings.
	 *
	 * @param string $username
	 * @return string[] User details
	 */
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
	
	/**
	 * Retrieve all data about the global user.
	 *
	 * @return \SampiCMS\User
	 */
	function getGlobalUserData() {
		$user = global_user;
		$stmt = $this->con->prepare( "SELECT id, full_name, username, twitter_user, facebook_user, google_plus_user FROM sampi_users WHERE username=?" );
		$stmt->bind_param('s', $user);
		$stmt->execute();
		$stmt->bind_result($id, $full_name, $username, $twitter_user, $facebook_user, $google_plus_user);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
		return new User($id, $username, $full_name, $twitter_user, $facebook_user, $google_plus_user);
	}
	
	/**
	 * Retrieve all authors from the database.
	 *
	 * Return them as an array with \SampiCMS\User.
	 *
	 * @return array
	 * @see \SampiCMS\User
	 */
	function getAuthors() {
		$authors = array();
		$stmt = $this->con->prepare( "SELECT id, full_name, username, twitter_user, facebook_user, google_plus_user FROM sampi_users" );
		$stmt->execute();
		$stmt->bind_result($id, $full_name, $username, $twitter_user, $facebook_user, $google_plus_user);
		while ($stmt->fetch()) {
			array_push($authors, new User($id, $username, $full_name, $twitter_user, $facebook_user, $google_plus_user));
		}
		$stmt->free_result();
		$stmt->close();
		return $authors;
	}
	
	/**
	 * Retrieve the amount of comments on a post.
	 *
	 * @param int $post The id of the post.
	 * @return int The amount of comments.
	 */
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
	 * Retrieve settings from MySQL database.
	 *
	 * Has custom handles for certain settings.
	 */
	function getSettings() {
		$query = 'SELECT setting_name,setting_value FROM sampi_settings';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($setting_name, $setting_value);
		while ( $stmt->fetch()) {
			if (($setting_name == 'window_title') || ($setting_name == 'admin_window_title')) { // Handle for window_title, admin_window_title splits with '%' delimiter
				$delimiter = '%';
				$pointer = 0;
				$next_is_var = false;
				$start = 0;
				$end = 0;
				$new_setting_value = '';
				while ( strpos ( $setting_value, $delimiter, $pointer ) !== false ) { // Continue if there is another delimiter
					$pos = strpos ( $setting_value, $delimiter, $pointer ); // Get the position of the next delimiter
					if ($next_is_var == false) { // Normal string
						$end = $pos + 1; // Set the end of the string to the position after the next delimiter
						if ($pointer == 0) { // Start of unsplit string
							$var = substr ( $setting_value, 0, $end - 1 ); // Get part of the split string
						} else {
							$var = substr ( $setting_value, $start, $end - $start ); // Get part of the split string
						}
						$new_setting_value = $new_setting_value . $var; // Append part of the split string to the new string
						$next_is_var = true; // Next part is a variable
					} else { // Variable string
						$start = $pos; // Set the start of the string to the position after the next delimiter
						$var = substr ( $setting_value, $end, $start - $end ); // Get part of the split string
						$new_setting_value = $new_setting_value . constant ( $var ); // Append value of the split variable to the new string
						$next_is_var = false; // Next part is a normal string
					}
					$pointer = $pos + 1; // Set the pointer to the position after the next delimiter
				}
				if ($pointer == 0) {
					//$var = substr ( $setting_value, $start, strlen ( $setting_value ) - $start );
					$new_setting_value = $setting_value; // Just a normal string, do nothing
				} else {
					$var = substr ( $setting_value, $start + 1, strlen ( $setting_value ) - $start ); // Get the rest of the split string
					$new_setting_value = $new_setting_value . $var; // Append the rest of the split string to the new string
				}
				/**
				 * Define the setting as a constant
				 * @ignore
				 */
				define ( $setting_name, $new_setting_value );
			} else { // Normal handle
				/**
				 * Define the setting as a constant
				 * @ignore
				 */
				define ( $setting_name, $setting_value );
			}
		}
		$stmt->free_result();
		$stmt->close();
		unset ( $settings, $setting_name, $setting_value );
	}
	
	/**
	 * Delete a post from the database.
	 *
	 * @param int $post_nr The id of the post.
	 * @return boolean True on success, false on failure.
	 */
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
 * Provides all functionality for displaying posts.
 *
 * @name SampiCMS Post
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
class Post {
	/**
	 * Date.
	 * @var string
	 */
	 private $date;
	/**
	 * Date last updated.
	 * @var string
	 */
	private $dateUpdated;
	/**
	 * Title.
	 * @var string
	 */
	private $title;
	/**
	 * Content
	 * @var string
	 */
	private $content;
	/**
	 * Author
	 * @var string|array
	 */
	private $author;
	/**
	 * Keywords
	 * @var string
	 */
	private $keywords;
	/**
	 * Id.
	 * @var int
	 */
	private $nr;
	/**
	 * Amount of comments
	 * @var int
	 */
	private $commentsCount;
	/**
	 * Comments.
	 *
	 * Array containting \SampiCMS\Comment.
	 *
	 * @var array
	 */
	private $comments;
	
	/**
	 * Full name.
	 *
	 * @var string
	 */
	CONST AUTHOR_FULL_NAME = 'full_name';
	/**
	 * Username.
	 *
	 * @var string
	 */
	CONST AUTHOR_USERNAME = 'username';
	/**
	 * Twitter username (without @).
	 *
	 * @var string
	 */
	CONST AUTHOR_TWITTER = 'twitter_username';
	/**
	 * Facebook username.
	 *
	 * @var string
	 */
	CONST AUTHOR_FACEBOOK = 'facebook_username';
	/**
	 * Google+ username.
	 *
	 * @var string
	 */
	CONST AUTHOR_GOOGLE_PLUS = 'google_plus_user';
	/**
	 * Show as single post.
	 *
	 * @var int
	 */
	CONST SHOW_SINGLE = 0x0;
	/**
	 * Show as blogstream post.
	 *
	 * @var int
	 */
	CONST SHOW_MULTIPLE = 0x1;
	/**
	 * Show as error page.
	 *
	 * @var int
	 */
	CONST SHOW_ERROR = 0x2;
	/**
	 * Show in editor.
	 *
	 * @var int
	 */
	CONST SHOW_EDIT = 0x3;
	
	/**
	 * Create a new instance of a post to interact with.
	 *
	 * @param int $post_nr
	 * @param string $title
	 * @param string $author
	 * @param string $content
	 * @param string $date
	 * @param string $dateUpdated
	 * @param string $keywords
	 */
	function __construct($post_nr, $title, $author, $content, $date, $dateUpdated, $keywords) {
		$db = new DbFunctions();
		$this->nr = $post_nr;
		$this->title = $title;
		$this->author = $author;
		$this->content = $content;
		$this->date = $date;
		$this->dateUpdated = $dateUpdated;
		$this->keywords = $keywords;
		
		$authorData = $db->getAuthorData($this->author);
		
		if ($authorData['full_name'] !== null) {
			$this->author = $authorData;
		} else {
			$this->author = array('full_name'=>$this->author);
		}
		$this->commentsCount = $db->getCommentsCount($this->nr);
		$this->comments = $db->getComments($this->nr);
		
		unset($db);
	}
	
	/**
	 * Get the title of the post.
	 *
	 * @return string Title
	 */
	public function getTitle() {
		return $this->title;
	}
	/**
	 * Get the date and convert it to the prefered format.
	 *
	 * @return string Date
	 */
	public function getDate() {
		return date ( date_format, strtotime ( $this->date ) );
	}
	/**
	 * Get the date and convert it to the default ISO8601 format.
	 *
	 * @return string Date
	 */
	public function getISODate() {
		return date ( \DateTime::ISO8601, strtotime ( $this->date ) );
	}
	/**
	 * Get the date the post is last updated and convert it to the prefered format.
	 *
	 * @return string Date
	 */
	public function getDateUpdated() {
		return date ( date_format, strtotime ( $this->dateUpdated ) );
	}
	/**
	 * Get the date the post is last updated and convert it to the default ISO8601 format.
	 *
	 * @return string Date
	 */
	public function getISODateUpdated() {
		return date ( \DateTime::ISO8601, strtotime ( $this->dateUpdated ) );
	}
	/**
	 * Get the number of the post.
	 *
	 * @return integer Number
	 */
	public function getNr() {
		return $this->nr;
	}
	/**
	 * Get the author of the post.
	 *
	 * @param string $type Optional argument. Specifies requested info.
	 * <p>
	 * Possible values:<br />
	 * Post::AUTHOR_FULL_NAME - Full name (default)<br />
	 * Post::AUTHOR_USERNAME - Username<br />
	 * Post::AUTHOR_TWITTER - Twitter username without @<br />
	 * Post::AUTHOR_FACEBOOK - Facebook username<br />
	 * Post::AUTHOR_GOOGLE_PLUS - Google+ account number<br />
	 * </p>
	 *
	 * @return string Author
	 */
	public function getAuthor($type = self::AUTHOR_FULL_NAME) {
		return $this->author[$type];
	}
	/**
	 * Get the number of comments on the current post.
	 *
	 * @return int Number of comments
	 */
	public function getCommentsCount() {
		return $this->commentsCount;
	}
	/**
	 * Show the post.
	 *
	 * @param int $mode
	 */
	public function show($mode) {
		switch ($mode) {
			case self::SHOW_SINGLE :
				include SampiCMS\ROOT . '/sampi/theme/' . theme . '/print_single_post.php';
				break;
			case self::SHOW_MULTIPLE :
				include SampiCMS\ROOT . '/sampi/theme/' . theme . '/print_post.php';
				break;
			case self::SHOW_ERROR :
				include SampiCMS\ROOT . '/sampi/theme/' . theme . '/print_error_post.php';
				break;
			case self::SHOW_EDIT :
				include SampiCMS\ROOT . '/sampi/theme/' . theme . '/edit_single_post.php';
				break;
		}
	}
	/**
	 * Get the content of the post.
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}
	/**
	 * Show a form to post a comment.
	 */
	public function showCommentsForm() {
		include SampiCMS\ROOT . '/sampi/theme/' . theme . '/comment_form.php';
	}
	/**
	 * Show all comments on a post.
	 */
	public function showComments() {
		foreach ($this->comments as $key => $val) {
			$val->show();
		}
	}
	/**
	 * Get the keywords of the post.
	 *
	 * @return string
	 */
	public function getKeywords() {
		return $this->keywords;
	}
}

/**
 * Provides all functionality for displaying comments.
 *
 * @name SampiCMS Comment
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
class Comment {
	/**
	 * Id.
	 * @var int
	 */
	private $comment_nr;
	/**
	 * Id of parent post.
	 * @var int
	 */
	private $post_nr;
	/**
	 * Number of the comment in the row.
	 * @var int
	 */
	private $order_nr;
	/**
	 * Commenter.
	 * @var string
	 */
	private $commenter;
	/**
	 * Content.
	 * @var string
	 */
	private $comment;
	/**
	 * Date.
	 * @var string
	 */
	private $date;
	
	/**
	 * Create a new instance of a comment to interact with.
	 *
	 * @param int $comment_nr
	 * @param int $post_nr
	 * @param string $commenter
	 * @param string $comment
	 * @param string $date
	 * @param int $order_nr
	 */
	function __construct( $comment_nr, $post_nr, $commenter, $comment, $date, $order_nr ) {
		$this->comment_nr = $comment_nr;
		$this->post_nr = $post_nr;
		$this->commenter = $commenter;
		$this->comment = $comment;
		$this->date = $date;
		$this->order_nr = $order_nr;
	}
	
	/**
	 * Get the number of the comment in the row.
	 *
	 * @return int
	 */
	public function getNr() {
		return $this->order_nr;
	}
	
	/**
	 * Get the id of the comment.
	 *
	 * @return int
	 */
	public function getCommentNr() {
		return $this->comment_nr;
	}
	
	/**
	 * Get the id of the parent post.
	 *
	 * @return int
	 */
	public function getPostNr() {
		return $this->post_nr;
	}
	
	/**
	 * Get the author of the comment.
	 *
	 * @return string
	 */
	public function getAuthor() {
		return $this->commenter;
	}
	
	/**
	 * Get the content of the comment.
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->comment;
	}
	/**
	 * Get the date and convert it to the prefered format.
	 *
	 * @return string Date
	 */
	public function getDate() {
		return date ( date_format, strtotime ( $this->date ) );
	}
	/**
	 * Get the date and convert it to the default ISO8601 format.
	 *
	 * @return string Date
	 */
	public function getISODate() {
		return date ( \DateTime::ISO8601, strtotime ( $this->date ) );
	}
	
	/**
	 * Show the comment.
	 */
	public function show() {
		include SampiCMS\ROOT . '/sampi/theme/' . theme . '/print_comment.php';
	}
}

/**
 * Provides all functionality for users.
 *
 * @name SampiCMS User
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
class User {
	/**
	 * Id.
	 * @var int
	 */
	private $id;
	/**
	 * Username.
	 * @var string
	 */
	private $username;
	/**
	 * Full name.
	 * @var string
	 */
	private $full_name;
	/**
	 * Twitter username (without @).
	 * @var string
	 */
	private $twitter_user;
	/**
	 * Facebook username.
	 * @var string
	 */
	private $facebook_user;
	/**
	 * Google+ username.
	 * @var string
	 */
	private $google_plus_user;
	
	/**
	 * Create a new instance of an user to interact with.
	 *
	 * @param int $id
	 * @param string $username
	 * @param string $full_name
	 * @param string $twitter_user
	 * @param string $facebook_user
	 * @param string $google_plus_user
	 */
	function __construct( $id, $username, $full_name, $twitter_user = NULL, $facebook_user = NULL, $google_plus_user = NULL ) {
		$this->id = $id;
		$this->username = $username;
		$this->full_name = $full_name;
		$this->twitter_user = $twitter_user;
		$this->facebook_user = $facebook_user;
		$this->google_plus_user= $google_plus_user;
	}
	/**
	 * Get the id of the user.
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * Get the username of the user.
	 *
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}
	/**
	 * Get the full name of the user.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->full_name;
	}
	/**
	 * Get the Twitter username (without @) of the user.
	 *
	 * @return string
	 */
	public function getTwitter() {
		return $this->twitter_user;
	}
	/**
	 * Get the Facebook username of the user.
	 *
	 * @return string
	 */
	public function getFacebook() {
		return $this->facebook_user;
	}
	/**
	 * Get the Google+ username of the user.
	 *
	 * @return string
	 */
	public function getGooglePlus() {
		return $this->google_plus_user;
	}
}
/**
 * Provides all functionality for displaying static pages.
 *
 * @name SampiCMS Static Page
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
class StaticPage {
	/**
	 * Id.
	 * @var int
	 */
	private $nr;
	/**
	 * Title.
	 * @var string
	 */
	private $title;
	/**
	 * Content.
	 * @var string
	 */
	private $content;
	/**
	 * Create a new instance of a static page to interact with.
	 *
	 * @param int $page_nr
	 * @param string $title
	 * @param string $content
	 */
	function __construct( $page_nr, $title, $content ) {
		$this->nr = $page_nr;
		$this->title = $title;
		$this->content = $content;
	}
	/**
	 * Show the page.
	 */
	public function show() {
		include SampiCMS\ROOT . '/sampi/theme/' . theme . '/print_static_page.php';
	}
	/**
	 * Get the id of the page.
	 *
	 * @return int
	 */
	public function getNr() {
		return $this->nr;
	}
	/**
	 * Get the title of the page.
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	/**
	 * Get the content of the page.
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}
}

/**
 * Provides authentication for the administration interface.
 *
 * Uses a connection with the MySQL database to verify the users identity.
 * If the user is not logged in, a loginscreen will show up.
 */
function admin_auth() {
	global $current_user, $db;
	session_start();
	if (isset ( $_GET ['logout'] )) { // Logout the user
		$_SESSION = array();
		session_destroy();
		\header ( 'Location: ' . SampiCMS\ADMIN_REL_ROOT );
	} elseif (! isset($_SESSION['logged_in']) || ! $_SESSION['logged_in']) { // User is not logged in
		if (isset ($_POST['login']['username']) && isset($_POST['login']['password'])) { // Login data found
			$username = $_POST['login']['username'];
			$password = $_POST['login']['password'];
			if ($db->checkAuth($username, $password)) { // Check login data
				// OK!
				session_regenerate_id();
				$session = session_get_cookie_params();
				setcookie(session_name(), session_id(), $session['lifetime'], $session['path'], $session['domain'], false, true );
				$_SESSION['logged_in'] = 1;
				$_SESSION['username'] = $username;
			} else {
				// Redirect to login page
				$_SESSION = array();
				session_destroy();
				\header ( 'Location: ' . SampiCMS\ADMIN_REL_ROOT );
			}
		} else { // No login data found, redirect to login page
			$_SESSION = array();
			session_destroy();
			require_once SampiCMS\ADMIN_ROOT . '/login.php';
			die();
		}
	} else {
		// User is logged in, refresh to session for security's sake
		session_regenerate_id();
		$session = session_get_cookie_params();
		setcookie(session_name(), session_id(), $session['lifetime'], $session['path'], $session['domain'], false, true );
	}
}

/**
 * Search for a string and return the line number it's found on.
 *
 * @param string $needle
 * @param array $content The content of the file as an array
 * @return int|boolean
 * @see \file()
 */
function searchInFile($needle, $content) {
	$match = false;
	foreach ($content as $line=>$text) {
		if (strpos($text, $needle) !== false) {
			$match = true;
			return $line;
		}
	}
	if (!$match) {
		return false;
	}
}

?>