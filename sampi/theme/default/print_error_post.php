<?php
/**
 * SampiCMS theme print single post
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
<div id="post_<?php echo $this->getNr(); ?>">
	<div id="post_<?php echo $this->getNr(); ?>_header">
		<div id="post_<?php echo  $this->getNr(); ?>_header_nr">&#35;<?php echo $this->getNr(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_title"><?php echo $this->getTitle(); ?></div>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_content">
		<?php echo $this->getContent(); ?>
	</div>
</div>