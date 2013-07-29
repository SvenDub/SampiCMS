<?php
/**
 * SampiCMS panel
 *
 * Add a new user.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
/**
 * Start PHPDoc
 */
$phpdoc;

global $db;

// Save settings
if (isset ( $_GET ['username'] ) && isset ( $_GET ['password'] ) && isset ( $_GET ['full_name'] ) && isset ( $_GET ['rights'] ) && isset ( $_GET ['twitter_user'] ) && isset ( $_GET ['facebook_user'] ) && isset ( $_GET ['google_plus_user'] )) {
	$success = $db->newAuthor ( $_GET ['username'], $_GET ['password'], $_GET ['full_name'], $_GET ['rights'], $_GET ['twitter_user'], $_GET ['facebook_user'], $_GET ['google_plus_user'] );
	if ($success == true) {
		echo '<span style="color: #0F0;">User <b>' . $_GET ['full_name'] . ' (' . $_GET ['username'] . ')</b> added!</span>';
	} else {
		echo '<span style="color: #F00;">Error while adding user <b>' . $_GET ['full_name'] . ' (' . $_GET ['username'] . ')</b>!</span>';
	}
}

// Show form

?>
<p>Add a new user.</p>
<table>
	<tr>
		<td>Username</td>
		<td><input type="text" name="settings[add_user][username]" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="settings[add_user][password]" /></td>
	</tr>
	<tr>
		<td>Full name</td>
		<td><input type="text" name="settings[add_user][full_name]" /></td>
	</tr>
	<tr>
		<td>Rights</td>
		<td><input type="text" name="settings[add_user][rights]" /></td>
	</tr>
	<tr>
		<td>Twitter account</td>
		<td><input type="text" name="settings[add_user][twitter_user]" /></td>
	</tr>
	<tr>
		<td>Facebook account</td>
		<td><input type="text" name="settings[add_user][facebook_user]" /></td>
	</tr>
	<tr>
		<td>Google+ account</td>
		<td><input type="text" name="settings[add_user][google_plus_user]" /></td>
	</tr>
</table>