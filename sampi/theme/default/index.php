<?php
/**
 * SampiCMS theme index
 * SampiCMS's default theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Theme\default
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<div id="content">
	<?php sampi_theme_header(); ?>
	<?php sampi_sidebar(); ?>
	<div id="posts">
		<?php sampi_mode_selector(); ?>
		<?php sampi_pages(); ?>
	</div>
	<div id="footer_push"></div>
</div>