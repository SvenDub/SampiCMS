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
		<div id="post_<?php echo $this->getNr(); ?>_header_title"><?php echo $this->getTitle(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_postedby">Posted: <?php echo $this->getDate(); ?> by <?php echo $this->getAuthor(SampiPost::$AUTHOR_FULL_NAME) ?></div>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_content">
		<?php echo $this->getContent(); ?>
	</div>
	<a id="comments"></a>
	<div id="post_<?php echo $this->getNr(); ?>_footer">
		<?php echo $this->getCommentsCount(); ?> comments<br />
		<?php $this->showCommentsForm(); ?>
		<div id="comments_list">
			<?php $this->getComments(); ?>
		</div>
	</div>
</div>