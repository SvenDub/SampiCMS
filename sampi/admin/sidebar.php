<?php

/**
 * SampiCMS admin sidebar file
 *
 * Contains the admin sidebar
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;
use SampiCMS;

?>
<ul class="sidebar_list">
	<li><a class="sidebar_link" href="<?php echo SampiCMS\REL_ROOT; ?>">Home</a></li>
	<li>&nbsp;</li>
	<li><a class="sidebar_link" href="<?php echo SampiCMS\ADMIN_REL_ROOT; ?>">All panels</a></li>
	<?php panel_links (); ?>
	<li>&nbsp;</li>
	<li><a class="sidebar_link" href="?logout">Log out</a></li>
</ul>