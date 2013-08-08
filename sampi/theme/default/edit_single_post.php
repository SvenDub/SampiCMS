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

require_once ADMIN_ROOT . '/functions.php';
sampi_admin_auth();
?>
<div id="post_<?php echo $this->getNr(); ?>">
	<div id="post_<?php echo $this->getNr(); ?>_header">
		<input type="button" class="button-main" id="post_<?php echo $this->getNr(); ?>_header_edit" value="Save" onclick="editPost();" />
		<div id="post_<?php echo $this->getNr(); ?>_header_title" contenteditable="true"><?php echo $this->getTitle(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_date"><?php echo $this->getDate(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_author"><?php echo $this->getAuthor(SampiPost::$AUTHOR_FULL_NAME) ?></div>
		<?php if ($this->getDate() !== $this->getDateUpdated()): ?>
			<div id="post_<?php echo $this->getNr(); ?>_header_date_updated"><?php echo $this->getDateUpdated(); ?></div>
		<?php endif; ?>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_content" contenteditable="true">
		<?php echo $this->getContent(); ?>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_footer">
		<div id="post_<?php echo $this->getNr(); ?>_footer_keywords" contenteditable="true">
			<?php echo $this->getKeywords(); ?>
		</div>
	</div>
</div>