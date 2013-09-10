<?php
/**
 * SampiCMS theme print static page
 *
 * Show a static page.
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
<div id="static_<?php echo $this->getNr(); ?>">
	<div id="static_<?php echo $this->getNr(); ?>_header">
		<div id="static_<?php echo $this->getNr(); ?>_header_title"><?php echo $this->getTitle(); ?></div>
	</div>
	<div id="static_<?php echo $this->getNr(); ?>_content">
		<?php echo $this->getContent(); ?>
	</div>
</div>