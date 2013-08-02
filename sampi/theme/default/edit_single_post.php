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
		<div id="post_<?php echo $this->getNr(); ?>_header_title" contenteditable="true"><?php echo $this->getTitle(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_postedby">Posted: <?php echo $this->getDate(); ?> by <?php echo $this->getAuthor(SampiPost::$AUTHOR_FULL_NAME) ?></div>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_content" contenteditable="true">
		<?php echo $this->getContent(); ?>
	</div>
</div>