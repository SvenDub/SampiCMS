<?php
/**
 * SampiCMS theme index
 *
 * The theme's entry point. Loads the other theme resources.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Theme\Sampi13
 */
/**
 * Namespace
 */
namespace SampiCMS\Theme\Sampi13;
use SampiCMS;
?>
<div id="content">
	<?php SampiCMS\theme_header(); ?>
	<div id="sidebarContainer">
		<div id="sidebar">
			<?php SampiCMS\sidebar(); ?>
		</div>
	</div>
	<div id="posts">
		<?php SampiCMS\pages(); ?>
		<?php SampiCMS\mode_selector(); ?>
	</div>
	<div id="footer_push"></div>
</div>