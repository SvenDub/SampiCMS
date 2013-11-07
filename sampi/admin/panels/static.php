<?php

/**
 * SampiCMS panel
 *
 * Create a new static.
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

// Save settings
if (isset ( $_GET ['title'] ) && isset ( $_GET ['content'] )) {
	$title = $_GET ['title'];
	$content = $_GET ['content'];
	if ($title !== null && $content !== null) {
		$s = $db->newStatic ( $title, $content );
		if ($s == false) {
			echo '<span style="color: #F00;">Error while adding static <b>' . $title . '</b>!</span>';
		} else {
			echo '<span style="color: #0A0;">Static <b>' . $title . '</b> added!</span>';
			$title = '';
			$content = '';
		}
	}
}

// Show form
?>
<p>Create a new static page.</p>
<div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Title</div>
		<input type="text" id="settings[static][title]" value="<?php echo $title; ?>" />
		<div class="ui-hint">The title of the static.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Content</div>
		<div class="textarea-wrapper">
			<textarea id="settings[static][content]" rows="10" cols="50"><?php echo $content; ?></textarea>
			<div class="ui-hint">The content of the static. Supports HTML tags.</div>
		</div>
	</div>
</div>