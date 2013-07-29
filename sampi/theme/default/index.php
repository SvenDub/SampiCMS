<?php
/**
 * SampiCMS theme index
 * SampiCMS's default website theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Theme\defaultSite
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<div id="content">
	<?php sampi_theme_header(); ?>
	<div id="sidebarContainer">
		<div id="sidebar">
			<?php sampi_sidebar(); ?>
		</div>
	</div>
	<div id="posts">
		<?php sampi_mode_selector(); ?>
		<?php sampi_pages(); ?>
	</div>
	<div id="footer_push"></div>
</div>