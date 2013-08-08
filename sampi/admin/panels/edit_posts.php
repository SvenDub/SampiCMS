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

$posts = $db->getPosts ();
$posts = array_reverse ( $posts, true );
?>
<ol class="edit_list">
<?php
foreach ( $posts as $key => $val ) {
	echo '<li value="' . $val->getNr () . '"><a href="' . REL_ROOT . '?p=' . $val->getNr () . '">' . $val->getTitle () . '</a> <a href="' . REL_ROOT . '?p=' . $val->getNr () . '&amp;edit"><img src="' . ADMIN_REL_ROOT . '/theme/' . admin_theme . '/images/edit.png" /></a><a href="javascript:;" onclick="deletePost(' . $val->getNr() . ');"><img src="' . ADMIN_REL_ROOT . '/theme/' . admin_theme . '/images/delete.png" /></a></li>';
}
?>
</ol>