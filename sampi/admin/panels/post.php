<?php
/**
 * SampiCMS panel
 *
 * Create a new post.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
/**
 * Start PHPDoc
 */
$phpdoc;

global $db;

$title = '';
$content = '';
$keywords = '';

// Save settings
if (isset ( $_GET ['title'] ) && isset ( $_GET ['content'] )) {
	$title = $_GET ['title'];
	$content = $_GET ['content'];
	$keywords = $_GET ['keywords'];
	if ($title !== null && $content !== null) {
		$p = $db->newPost ( $title, $content, $keywords );
		if ($p == false) {
			echo '<span style="color: #F00;">Error while posting post <b>' . $title . '</b>!</span>';
		} else {
			echo '<span style="color: #0A0;">Post <b>' . $title . '</b> added!</span>';
			$title = '';
			$content = '';
			$keywords = '';
		}
	}
}

// Show form
?>
<p>Create a new post.</p>
<table>
	<tr>
		<td>Title</td>
		<td><input type="text" id="settings[post][title]" value="<?php echo $title; ?>" /></td>
	</tr>
	<tr>
		<td>Content</td>
		<td><div class="textarea-wrapper">
				<textarea id="settings[post][content]" rows="10" cols="50"><?php echo $content; ?></textarea>
			</div></td>
	</tr>
	<tr>
		<td>Keywords</td>
		<td><input type="text" id="settings[post][keywords]" value="<?php echo $keywords; ?>" /></td>
	</tr>
</table>