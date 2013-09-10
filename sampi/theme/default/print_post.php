<?php
/**
 * SampiCMS theme print post
 *
 * Show a blogstream post.
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
	<div id="post_<?php echo  $this->getNr(); ?>_header">
		<div id="post_<?php echo  $this->getNr(); ?>_header_nr">&#35;<?php echo $this->getNr(); ?></div>
		<div id="post_<?php echo  $this->getNr(); ?>_header_title">
			<a href="<?php echo SampiCMS\REL_ROOT."/?p="; echo  $this->getNr(); ?>"><?php echo $this->getTitle(); ?></a>
		</div>
		<div id="post_<?php echo $this->getNr(); ?>_header_date"><?php echo $this->getDate(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_author"><?php echo $this->getAuthor(SampiCMS\Post::AUTHOR_FULL_NAME) ?></div>
		<?php if ($this->getDate() !== $this->getDateUpdated()): ?>
			<div id="post_<?php echo $this->getNr(); ?>_header_date_updated"><?php echo $this->getDateUpdated(); ?></div>
		<?php endif; ?>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_content">
		<?php echo $this->getContent(); ?>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_footer">
		<a class="footer_link" href="<?php echo SampiCMS\REL_ROOT."/?p="; echo $this->getNr(); ?>#comments"><?php echo $this->getCommentsCount(); ?> comments</a>
	</div>
</div>