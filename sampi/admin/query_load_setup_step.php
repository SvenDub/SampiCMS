<?php

/**
 * SampiCMS query file
 *
 * Load a setup step.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;

use SampiCMS;

// Use gzip for improved speeds, if available
if (substr_count ( $_SERVER ['HTTP_ACCEPT_ENCODING'], 'gzip' )) {
	ob_start ( "ob_gzhandler" );
} else {
	ob_start ();
}

/**
 * Absolute path to the root of SampiCMS.
 * @ignore
 */
define ( 'SampiCMS\ROOT', substr ( dirname ( __FILE__ ), 0, - 12 ) );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
*/
define ( 'SampiCMS\REL_ROOT', substr ( $_SERVER ['SCRIPT_NAME'], 0, - 38 ) );
/**
 * Absolute path to the admin root.
 * @ignore
*/
define ( 'SampiCMS\ADMIN_ROOT', SampiCMS\ROOT . '/sampi/admin' );
/**
 * Relative (web) path to the root of SampiCMS.
 * @ignore
*/
define ( 'SampiCMS\ADMIN_REL_ROOT', SampiCMS\REL_ROOT . '/sampi/admin' );

$step = (isset ( $_GET ["step"] )) ? $p = $_GET ["step"] : $step = false;

switch ($step) {
	default:
	case 1:
		?>
<p>Welcome to SampiCMS. This setup guides you through the installation process. Just follow the steps and your site will be operational before you
	know it!</p>
<p>
	<a href="#step_2">Let's go!</a>
</p>
<?php
		break;
	case 2:
		?>
<p>Let's start with suppling the login data for the database. If you do not know what values to use, contact your hosting provider.</p>
<form method="post" action="" autocomplete="off" onchange="checkSetupStep(2, false);">
	<div class="ui-hint-host">
		<div class="ui-input-label">Hostname:</div>
		<input type="text" name="db_host" id="db_host" />
		<div class="ui-hint">The database server to connect to.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Database:</div>
		<input type="text" name="db" id="db" />
		<div class="ui-hint">The name of the database.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Username:</div>
		<input type="text" name="db_user" id="db_user" />
		<div class="ui-hint">The username used to connect to the database.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Password:</div>
		<input type="password" name="db_pass" id="db_pass" />
		<div class="ui-hint">The password used to connect to the database.</div>
	</div>
	<br />
	<input type="submit" value="Next" onclick="checkSetupStep(2, true); return false;" />
</form>
<p>Connection status:</p>
<div id="setup_msg">Waiting for form to be completed...</div>
<?php
		break;
	case 3:
		?>
<p>Next on are the settings for your site.</p>
<form method="post" action="" autocomplete="off" onchange="checkSetupStep(3, false);">
	<div class="ui-hint-host">
		<div class="ui-input-label">Site name</div>
		<input type="text" name="site_title" id="site_title" />
		<div class="ui-hint">The name of your site.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Site description</div>
		<div class="textarea-wrapper">
			<textarea name="site_description" id="site_description" rows="5"></textarea>
			<div class="ui-hint">A short description of your site or maybe a good punchline.</div>
		</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Date-time format</div>
		<select name="date_format" id="date_format">
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
						if ($values [$i] == 'j-n-y G:i') {
							echo '<option value="' . $values [$i] . '" selected>' . date ( $values [$i] ) . ' - ' . $values [$i] . '</option>';
						} else {
							echo '<option value="' . $values [$i] . '">' . date ( $values [$i] ) . ' - ' . $values [$i] . '</option>';
						}
					}
					?>
		</select>
		<div class="ui-hint">Date-time format to use for the post date-time</div>
	</div>
	<br />
	<input type="submit" value="Next" onclick="checkSetupStep(3, true); return false;" />
</form>
<p>Connection status:</p>
<div id="setup_msg">Waiting for form to be completed...</div>
<?php
		break;
	case 4:
		?>
<p>
	The last bit of information is about... you! Down here you have to answers a few answers about the main user of the system.
	The main user is displayed as the owner of the site.
</p>
<p>More users can be added later via the admin panel.</p>
<form method="post" action="" autocomplete="off" onchange="checkSetupStep(4, false);">
	<div class="ui-hint-host">
		<div class="ui-input-label">Username</div>
		<input type="text" name="username" id="username" />
		<div class="ui-hint">Your username.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Password</div>
		<input type="password" name="password" id="password" />
		<div class="ui-hint">Your password. Minimal 4 characters.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Full name</div>
		<input type="text" name="full_name" id="full_name" />
		<div class="ui-hint">Your display name.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Twitter</div>
		twitter.com/<input type="text" name="twitter_user" id="twitter_user" />
		<div class="ui-hint">Optional. Your Twitter username (without @).</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Facebook</div>
		facebook.com/<input type="text" name="facebook_user" id="facebook_user" />
		<div class="ui-hint">Optional. Your Facebook username.</div>
	</div>
	<div class="ui-hint-host">
		<div class="ui-input-label">Google+</div>
		plus.google.com/<input type="text" name="google_plus_user" id="google_plus_user" />
		<div class="ui-hint">Optional. Your Google+ user ID. <a href="https://plus.google.com/108151908266643238934/posts/VFSRK9BcLuU" target="_blank">Find your user ID.</a></div>
	</div>
	<br />
	<input type="submit" value="Next" onclick="checkSetupStep(4, true); return false;" />
</form>
<p>Connection status:</p>
<div id="setup_msg">Waiting for form to be completed...</div>
<?php
		break;
case 5:
	?>
<p>That's all! SampiCMS is now ready to rock. Just click 'next' to continue to your brand new site.</p>
<form method="post" action="" autocomplete="off" onchange="checkSetupStep(5, false);">
	<input type="submit" value="Next" onclick="checkSetupStep(5, true); return false;" />
</form>
<p>Connection status:</p>
<div id="setup_msg">Just click next...</div>
	<?php
	break;
}

?>