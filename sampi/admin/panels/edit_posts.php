<?php
/**
 * SampiCMS panel
 *
 * Edit posts.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
/**
 * Start PHPDoc
 */
$phpdoc;


global $db;

$posts = $db->getPosts();

foreach ($posts as $key=>$val) {
	echo '<a href="' . REL_ROOT . '?p=' . $val->getNr() . '&edit">'. $val->getTitle() . '</a>';
}
?>