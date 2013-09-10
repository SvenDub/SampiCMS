<?php
/**
 * SampiCMS theme header
 *
 * Show the header.
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
<div id='header'>
	<h1>
		<a href="<?php echo SampiCMS\REL_ROOT; ?>"><?php echo SampiCMS\info('title'); ?></a>
	</h1>
	<p><?php echo SampiCMS\info('description'); ?><p>
</div>
<div id="popup_table" style="display: none; opacity: 1.0;">
	<div id="popup_cell"></div>
</div>