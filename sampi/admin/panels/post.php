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
?>
<p>Create a new post.</p>
<table>
	<tr>
		<td>Title</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][title]" /></td>
	</tr>
	<tr>
		<td>Content</td>
		<td><div class="textarea-wrapper"><textarea name="settings[<?php echo $this->getNr(); ?>][content]" rows="10" cols="50"></textarea></div></td>
	</tr>
</table>