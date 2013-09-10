<?php

/**
 * SampiCMS admin theme header
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
<div id="header">
	<h1>
		<a href="<?php echo SampiCMS\ADMIN_REL_ROOT; ?>"><?php echo SampiCMS\info('title').' - Admin panel'; ?></a>
	</h1>
</div>
<div id="popup_table" style="display: none; opacity: 1.0;">
	<div id="popup_cell"></div>
</div>