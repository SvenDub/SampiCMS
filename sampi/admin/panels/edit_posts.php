<?php

/**
 * SampiCMS panel
 *
 * Edit posts.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;
use SampiCMS;

global $db;

$posts = $db->getPosts ();
$posts = array_reverse ( $posts, true );
?>
<ol class="edit_list">
<?php
// List the posts
foreach ( $posts as $key => $val ) {
	echo '<li value="' . $val->getNr () . '"><a href="' . SampiCMS\REL_ROOT . '?p=' . $val->getNr () . '">' . $val->getTitle () . '</a> <a href="' . SampiCMS\REL_ROOT . '?p=' . $val->getNr () . '&amp;edit"><img src="' . SampiCMS\ADMIN_REL_ROOT . '/theme/' . admin_theme . '/images/edit.png" /></a><a href="javascript:;" onclick="deletePost(' . $val->getNr () . ');"><img src="' . SampiCMS\ADMIN_REL_ROOT . '/theme/' . admin_theme . '/images/delete.png" /></a></li>';
}
?>
</ol>