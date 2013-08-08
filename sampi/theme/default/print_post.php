<?php
/**
 * SampiCMS theme print post
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
	<div id="post_<?php echo  $this->getNr(); ?>_header">
		<div id="post_<?php echo  $this->getNr(); ?>_header_nr">&#35;<?php echo $this->getNr(); ?></div>
		<div id="post_<?php echo  $this->getNr(); ?>_header_title">
			<a href="<?php echo REL_ROOT."/?p="; echo  $this->getNr(); ?>"><?php echo $this->getTitle(); ?></a>
		</div>
		<div id="post_<?php echo $this->getNr(); ?>_header_date"><?php echo $this->getDate(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_author"><?php echo $this->getAuthor(SampiPost::$AUTHOR_FULL_NAME) ?></div>
		<?php if ($this->getDate() !== $this->getDateUpdated()): ?>
			<div id="post_<?php echo $this->getNr(); ?>_header_date_updated"><?php echo $this->getDateUpdated(); ?></div>
		<?php endif; ?>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_content">
		<?php echo $this->getContent(); ?>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_footer">
		<a class="footer_link" href="<?php echo REL_ROOT."/?p="; echo $this->getNr(); ?>#comments"><?php echo $this->getCommentsCount(); ?> comments</a>
	</div>
</div>