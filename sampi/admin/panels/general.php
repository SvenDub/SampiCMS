<?php

/**
 * SampiCMS panel
 *
 * Most common settings that affect SampiCMS's behavior.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;
use SampiCMS;

global $db;

$site_title = site_title;
$site_description = site_description;
$date_format = date_format;
$per_page_values = per_page_values;
$global_user = global_user;

// Save settings
if (isset ( $_GET ['site_title'] )) {
	$site_title = $_GET ['site_title'];
	$db->saveSetting ( 'site_title', $site_title );
}
if (isset ( $_GET ['site_description'] )) {
	$site_description = $_GET ['site_description'];
	$db->saveSetting ( 'site_description', $site_description );
}
if (isset ( $_GET ['date_format'] )) {
	$date_format = $_GET ['date_format'];
	$db->saveSetting ( 'date_format', $date_format );
}
if (isset ( $_GET ['per_page_values'] )) {
	$per_page_values = $_GET ['per_page_values'];
	$db->saveSetting ( 'per_page_values', $per_page_values );
}
if (isset ( $_GET ['global_user'] )) {
	$per_page_values = $_GET ['global_user'];
	$db->saveSetting ( 'global_user', $global_user );
}

// TODO Show error/success notice

// Show form
?>
<p>Most common settings that affect SampiCMS's behavior.</p>
<div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Site name</div>
		<input type="text" id="settings[general][site_title]" value="<?php echo $site_title; ?>" />
		<div class="ui-hint">The name of your site.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Site description</div>
		<div class="textarea-wrapper">
			<textarea id="settings[general][site_description]" rows="10" cols="50"><?php echo $site_description; ?></textarea>
			<div class="ui-hint">A short description of your site or maybe a good punchline.</div>
		</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Date-time format</div>
		<select id="settings[general][date_format]">
  			<?php
					$values = array (
							'j-n-y',
							'j-n-y G:i',
							'Y-m-d',
							'Y-m-d H:i:s',
							'F j, Y',
							'F j, Y, g:i a'
					);
					for($i = 0; $i < count ( $values ); $i ++) {
						if ($values [$i] == $date_format) {
							echo '<option value="' . $values [$i] . '" selected>' . date ( $values [$i] ) . ' - ' . $values [$i] . '</option>';
						} else {
							echo '<option value="' . $values [$i] . '">' . date ( $values [$i] ) . ' - ' . $values [$i] . '</option>';
						}
					}
					?>
			<?php // @todo <option>Custom...</option> ?>
		</select>
		<div class="ui-hint">Date-time format to use for the post date-time.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Per page selector values</div>
		<input type="text" id="settings[general][per_page_values]" value="<?php echo $per_page_values; ?>" />
		<div class="ui-hint">Values to show for the amount of posts per page.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Global user</div>
		<select id="settings[general][global_user]">
			<?php
			$users = $db->getAuthors ();
			for($i = 0; $i < count ( $users ); $i ++) {
				if ($users [$i]->getUsername () == $global_user) {
					echo '<option value="' . $users [$i]->getUsername () . '" selected>' . $users [$i]->getName () . ' (' . $users [$i]->getUsername () . ')' . '</option>';
				} else {
					echo '<option value="' . $users [$i] ['username'] . '">' . $users [$i] ['full_name'] . '(' . $users [$i] ['username'] . ')' . '</option>';
				}
			}
			?>
		</select>
		<div class="ui-hint">User to show as main author for the site.</div>
	</div>
</div>