<?php

/**
 * SampiCMS panel
 *
 * Create a new post.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;
use SampiCMS;

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
<div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Title</div>
		<input type="text" id="settings[post][title]" value="<?php echo $title; ?>" />
		<div class="ui-hint">The title of the post.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Content</div>
		<div class="textarea-wrapper">
			<textarea id="settings[post][content]" rows="10" cols="50"><?php echo $content; ?></textarea>
			<div class="ui-hint">The content of the post. Supports HTML tags.</div>
		</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Keywords</div>
		<input type="text" id="settings[post][keywords]" value="<?php echo $keywords; ?>" />
		<div class="ui-hint">The keywords of the post. Separate multiple keywords with a comma.</div>
	</div>
</div>