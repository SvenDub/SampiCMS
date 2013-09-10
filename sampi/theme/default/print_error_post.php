<?php
/**
 * SampiCMS theme print error post
 *
 * Show an error.
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
<div id="post_<?php echo $this->getNr(); ?>">
	<div id="post_<?php echo $this->getNr(); ?>_header">
		<div id="post_<?php echo $this->getNr(); ?>_header_nr">&#35;<?php echo $this->getNr(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_title"><?php echo $this->getTitle(); ?></div>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_content">
		<?php echo $this->getContent(); ?>
	</div>
</div>