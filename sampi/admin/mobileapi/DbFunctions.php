<?php

/**
 * SampiCMS mobile API
 *
 * Contains all database related functions for the mobile application.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin\MobileAPI;
use SampiCMS;
use SampiCMS\Admin;

require_once SampiCMS\ROOT . '/sampi/functions.php';

/**
 * Contains all database related functions for the mobile application.
 *
 * @name SampiCMS Mobile Database Functions
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin\MobileAPI
 *
 */
class DbFunctions extends SampiCMS\DbFunctions {
	/**
	 * Add a new post to the database
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
	 *
	 * @see \SampiCMS\Post
	 */
	function newPost($title, $content, $keywords, $username, $password) {
		if ($title !== "" && $content !== "") {
			if (SampiCMS\DbFunctions::checkAuth($username, $password)) {
				$date = date ( 'Y-m-d H:i:s' );
				$dateUpdated = date ( 'Y-m-d H:i:s' );
				$stmt = $this->con->prepare( "INSERT INTO sampi_posts (date, date_updated, author, title, content, keywords) VALUES (?, ?, ?, ?, ?, ?)" );
				$stmt->bind_param('ssssss', $date, $dateUpdated, $username, $title, $content, $keywords);
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
	 * @param string $username The username of the poster.
	 *        	Used in combination with $password to authenticate the poster.
	 * @param string $password The password of the poster.
	 *        	Used in combination with $username to authenticate the poster.
	 * @return boolean True on success, false on failure
	 *
	 * @see \SampiCMS\Post
	 */
	function editPost($post_nr, $title, $content, $keywords, $username, $password) {
		if ($post_nr !== "" && $title !== "" && $content !== "") {
			if (SampiCMS\DbFunctions::checkAuth($username, $password)) {
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
}