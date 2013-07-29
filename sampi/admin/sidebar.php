<?php
/**
 * SampiCMS admin sidebar file
 * Contains the admin sidebar
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<ul class="sidebar_list">
	<li><a class="sidebar_link" href="<?php echo REL_ROOT; ?>">Home</a></li>
	<li>&nbsp;</li>
	<li><a class="sidebar_link" href="<?php echo ADMIN_REL_ROOT; ?>">All panels</a></li>
	<?php sampi_admin_panel_links (); ?>
	<li>&nbsp;</li>
	<li><a class="sidebar_link" href="?logout">Log out</a></li>
</ul>