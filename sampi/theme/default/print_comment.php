<?php
/**
 * SampiCMS theme print comment
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
<div id="comment_<?php echo $this->getNr(); ?>">
	<div id="comment_<?php echo $this->getNr(); ?>_header">
		<div id="comment_<?php echo $this->getNr(); ?>_header_nr"><?php echo $this->getNr(); ?></div>
		<div id="comment_<?php echo $this->getNr(); ?>_header_postedby"><?php echo $this->getDate(); ?> by <?php echo $this->getAuthor(); ?></div>
	</div>
	<div id="comment_<?php echo $this->getNr(); ?>_content">
		<?php echo $this->getContent(); ?>
	</div>
	<div id="comment_<?php echo $this->getNr(); ?>_footer"></div>
</div>