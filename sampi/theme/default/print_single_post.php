<?php
/**
 * SampiCMS theme print single post
 *
 * Show a single post.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Theme\Sampi13
 */
/**
 * Namespace
 */
namespace SampiCMS\Theme\Sampi13;
use SampiCMS;

global $db;

?>
<div id="post_<?php echo $this->getNr(); ?>" itemscope itemtype="http://schema.org/Article">
	<div id="post_<?php echo $this->getNr(); ?>_header">
		<?php if ($_SESSION['logged_in']) : ?>
		<input type="button" class="button-main" id="post_<?php echo $this->getNr(); ?>_header_edit" value="Edit" onclick="window.location.href += '&edit';" />
		<?php endif; ?>
		<div id="post_<?php echo $this->getNr(); ?>_header_title" itemprop="name"><?php echo $this->getTitle(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_date" itemprop="datePublished" datetime="<?php echo $this->getISODate(); ?>"><?php echo $this->getDate(); ?></div>
		<div id="post_<?php echo $this->getNr(); ?>_header_author" itemprop="author"><?php echo $this->getAuthor(SampiCMS\Post::AUTHOR_FULL_NAME) ?></div>
		<?php if ($this->getDate() !== $this->getDateUpdated()): ?>
			<div id="post_<?php echo $this->getNr(); ?>_header_date_updated" itemprop="dateModified" datetime="<?php echo $this->getISODateUpdated(); ?>"><?php echo $this->getDateUpdated(); ?></div>
		<?php endif; ?>
	</div>
	<div id="post_<?php echo $this->getNr(); ?>_content" itemprop="articleBody">
		<?php echo $this->getContent(); ?>
	</div>
	<a id="comments"></a>
	<div id="post_<?php echo $this->getNr(); ?>_footer">
		<?php echo $this->getCommentsCount(); ?> comments<br />
		<div id="post_<?php echo $this->getNr(); ?>_footer_keywords" itemprop="keywords">
			<?php echo $this->getKeywords(); ?>
		</div>
		<?php $this->showCommentsForm(); ?>
		<div id="comments_list">
			<?php $this->showComments(); ?>
		</div>
	</div>
</div>