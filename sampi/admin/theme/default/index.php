<?php

/**
 * SampiCMS admin theme index
 *
 * SampiCMS's default admin theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin\Theme\Sampi13;
use SampiCMS;
use SampiCMS\Admin;

?>
<div id="content">
	<?php SampiCMS\Admin\theme_header(); ?>
	<?php SampiCMS\Admin\sidebar(); ?>
	<div id="settings">
		<form action="#" method="post" name="settings">
		<?php SampiCMS\Admin\mode_selector(); ?>
		</form>
	</div>
	<div id="footer_push"></div>
</div>