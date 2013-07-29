<?php
/**
 * SampiCMS mobile API
 * Contains all database related functions for the mobile application.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin\MobileAPI
 */
/**
 * Start PHPDoc
 */
$phpdoc;

require_once ROOT.'/sampi/functions.php';

/**
 * Contains all database related functions for the mobile application.
 *
 * @name SampiCMS Mobile Database Functions
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin\MobileAPI
 *
 */
class SampiMobileDbFunctions extends SampiDbFunctions {
	
	/**
	 * Fetches posts from the database
	 *
	 * Returns them as an array with objects.
	 *
	 * @return array Posts
	 */
	function getPosts() {
		$posts = array ();
		$stmt = $this->con->prepare("SELECT post_nr, date, author, title, content FROM sampi_posts ORDER BY post_nr DESC");
		$stmt->execute();
		$stmt->bind_result($post_nr, $date, $author, $title, $content);
		while ( $stmt->fetch() ) {
			$posts [$post_nr] = new SampiPost( $post_nr, $title, $author, $content, $date );
		}
		$stmt->free_result();
		$stmt->close();
		return $posts;
	}
}