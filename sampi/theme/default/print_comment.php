<?php
/**
 * SampiCMS theme print comment
 *
 * Show a comment.
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
<div id="comment_<?php echo $this->getNr(); ?>" itemscope itemtype="http://schema.org/UserComments">
	<div id="comment_<?php echo $this->getNr(); ?>_header">
		<div id="comment_<?php echo $this->getNr(); ?>_header_nr" itemprop="name"><?php echo $this->getNr(); ?></div>
		<div id="comment_<?php echo $this->getNr(); ?>_header_date" itemprop="commentTime" datetime="<?php echo $this->getISODate(); ?>"><?php echo $this->getDate(); ?></div>
		<div id="comment_<?php echo $this->getNr(); ?>_header_author" itemprop="creator"><?php echo $this->getAuthor() ?></div>
		
		<div id="comment_<?php echo $this->getNr(); ?>_header_startdate" itemprop="startDate" datetime="<?php echo $this->getISODate(); ?>"><?php echo $this->getDate(); ?></div>
		<link href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/?p=' . $this->getPostNr(); ?>" id="comment_<?php echo $this->getNr(); ?>_header_discusses" itemprop="discusses" />
		<link href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . SampiCMS\REL_ROOT . '/?p=' . $this->getPostNr(); ?>" id="comment_<?php echo $this->getNr(); ?>_header_replytourl" itemprop="replyToUrl" />
	</div>
	<div id="comment_<?php echo $this->getNr(); ?>_content" itemprop="commentText">
		<?php echo $this->getContent(); ?>
	</div>
	<div id="comment_<?php echo $this->getNr(); ?>_footer"></div>
</div>