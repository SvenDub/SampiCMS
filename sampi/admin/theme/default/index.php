<?php
/**
 * SampiCMS admin theme index
 * SampiCMS's default admin theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin\Theme\default
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<div id="content">
	<?php sampi_admin_theme_header(); ?>
	<?php sampi_admin_sidebar(); ?>
	<div id="settings">
		<form action="" method="post" name="settings">
		<?php sampi_admin_mode_selector(); ?>
		</form>
	</div>
	<div id="footer_push"></div>
</div>