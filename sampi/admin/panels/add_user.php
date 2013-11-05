<?php

/**
 * SampiCMS panel
 *
 * Add a new user.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;
use SampiCMS;

global $db;

// Save settings
$username = (isset ( $_GET ["username"] )) ? $username = $_GET ["username"] : $username = false;
$password = (isset ( $_GET ["password"] )) ? $password = $_GET ["password"] : $password = false;
$full_name = (isset ( $_GET ["full_name"] )) ? $full_name = $_GET ["full_name"] : $full_name = false;
$twitter_user = (isset ( $_GET ["twitter_user"] )) ? $twitter_user = $_GET ["twitter_user"] : $twitter_user = false;
$facebook_user = (isset ( $_GET ["facebook_user"] )) ? $facebook_user = $_GET ["facebook_user"] : $facebook_user = false;
$google_plus_user = (isset ( $_GET ["google_plus_user"] )) ? $google_plus_user = $_GET ["google_plus_user"] : $google_plus_user = false;
$response ['msg'] = '';
if ($username && $password && $full_name) {
	if (strlen($password) < 4) {
		$response ['msg'] .= '<span style="color: red;">Minimal password length is 4 characters.</span><br />';
	} else {
		if ($twitter_user || $facebook_user || $google_plus_user) {
			if ($twitter_user) {
				if (preg_match ( '/^([A-Za-z0-9_]+)$/', $twitter_user )) {
					$twitter = true;
				} else {
					$twitter = false;
				}
			}
			if ($facebook_user) {
				if (preg_match ( '/^[a-z\d.]{5,}$/i', $facebook_user )) {
					$facebook = true;
				} else {
					$facebook = false;
				}
			}
			if ($google_plus_user) {
				if (preg_match ( '/^([0-9]{21,21})$/', $google_plus_user )) {
					$google_plus = true;
				} else {
					$google_plus = false;
				}
			}
			if ((isset ( $twitter ) && ! $twitter) || (isset ( $facebook ) && ! $facebook) || (isset ( $google_plus ) && ! $google_plus)) {
				$response ['msg'] .= '<span style="color: red;">Error</span><br />';
				if (isset ( $twitter ) && ! $twitter) {
					$response ['msg'] .= '<span style="color: red;">Invalid Twitter username.</span><br />';
				}
				if (isset ( $facebook ) && ! $facebook) {
					$response ['msg'] .= '<span style="color: red;">Invalid Facebook username.</span><br />';
				}
				if (isset ( $google_plus ) && ! $google_plus) {
					$response ['msg'] .= '<span style="color: red;">Invalid Google+ ID.</span><br />';
				}
			} else {
				if ($db->newAuthor($username, $password, $full_name, '', $twitter_user, $facebook_user, $google_plus_user)) {
					$response ['msg'] .= '<span style="color: green;">User <b>' . $full_name . ' (' . $username . ')</b> added!</span><br />';
				} else {
					$response ['msg'] .= '<span style="color: #F00;">Error while adding user <b>' . $full_name . ' (' . $username . ')</b>!</span><br />';
				}
			}
		} else {
			if ($db->newAuthor($username, $password, $full_name, '')) {
				$response ['msg'] .= '<span style="color: green;">User <b>' . $full_name . ' (' . $username . ')</b> added!</span><br />';
			} else {
				$response ['msg'] .= '<span style="color: #F00;">Error while adding user <b>' . $full_name . ' (' . $username . ')</b>!</span><br />';
			}
		}
	}
}

echo $response ['msg'];
// Show form

?>
<p>Add a new user.</p>
<div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Username</div>
		<input type="text" autocomplete="off" name="settings[add_user][username]" />
		<div class="ui-hint">The username.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Password</div>
		<input type="password" autocomplete="off" name="settings[add_user][password]" />
		<div class="ui-hint">The password. Minimal 4 characters.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Full name</div>
		<input type="text" autocomplete="off" name="settings[add_user][full_name]" />
		<div class="ui-hint">The display name.</div>
	</div>
	<!--
	<div class="ui-hint-host">
		<div class="ui-input-label">Rights</div>
		<input type="text" autocomplete="false" name="settings[add_user][rights]" />
		<div class="ui-hint">The rights. Not functional yet.</div>
	</div>
	-->
	<div class="ui-hint-host">
		<div class="ui-input-label">Twitter account</div>
		<input type="text" autocomplete="off" name="settings[add_user][twitter_user]" />
		<div class="ui-hint">Optional. Your Twitter username (without @).</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Facebook account</div>
		<input type="text" name="settings[add_user][facebook_user]" />
		<div class="ui-hint">Optional. Your Facebook username.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Google+ account</div>
		<input type="text" name="settings[add_user][google_plus_user]" />
		<div class="ui-hint">Optional. Your Google+ user ID. <a href="https://plus.google.com/108151908266643238934/posts/VFSRK9BcLuU" target="_blank">Find your user ID.</a></div>
	</div>
</div>