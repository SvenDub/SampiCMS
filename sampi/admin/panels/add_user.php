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
?>
<p>Add a new user.</p>
<table>
	<tr>
		<td>Username</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][username]" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="settings[<?php echo $this->getNr(); ?>][password]" /></td>
	</tr>
	<tr>
		<td>Full name</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][full_name]" /></td>
	</tr>
	<tr>
		<td>Rights</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][rights]" /></td>
	</tr>
	<tr>
		<td>Twitter account</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][twitter_user]" /></td>
	</tr>
	<tr>
		<td>Facebook account</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][facebook_user]" /></td>
	</tr>
	<tr>
		<td>Google+ account</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][google_plus_user]" /></td>
	</tr>
</table>